<?php
/**
 * VISTAHOMZ — Uploads Handler
 *
 * Storage convention
 * ------------------
 * Files are saved in   <project root>/uploads/<folder>/<random>.<ext>
 * The database stores  uploads/<folder>/<random>.<ext>   (path relative to the site root)
 *
 * Older records that only contain a bare file name (e.g. "abc123.jpg") are still
 * supported: the helpers below look for the file in the known upload folders.
 */

/** Folders (relative to the project root) that deleteUpload() is allowed to touch. */
function uploadAllowedRoots(): array
{
    return ['uploads', 'products', 'banners', 'categories', 'reviews', 'testimonials'];
}

/** Candidate folders searched for legacy records that store only a file name. */
function uploadLegacyFolders(): array
{
    return [
        'uploads/products', 'uploads/banners', 'uploads/categories', 'uploads/reviews',
        'uploads/testimonials', 'products', 'banners', 'categories', 'reviews',
        'testimonials', 'uploads',
    ];
}

function isRemoteUrl($path): bool
{
    return is_string($path) && (bool) preg_match('~^(https?:)?//~i', $path);
}

/**
 * Turn a value stored in the database into a path relative to the site root.
 * Returns '' for empty values and the URL unchanged for remote images.
 */
function resolveUploadPath($path): string
{
    $path = trim((string) $path);
    if ($path === '') {
        return '';
    }
    if (isRemoteUrl($path)) {
        return $path;
    }

    $path = ltrim(str_replace('\\', '/', $path), '/');

    // Already a relative path such as "uploads/products/abc.jpg"
    if (strpos($path, '/') !== false) {
        return $path;
    }

    // Legacy: bare file name — find where it actually lives.
    $root = dirname(__DIR__);
    foreach (uploadLegacyFolders() as $folder) {
        if (is_file($root . '/' . $folder . '/' . $path)) {
            return $folder . '/' . $path;
        }
    }

    return 'uploads/products/' . $path;
}

/**
 * Public-site helper. Returns a relative path (or remote URL), or the fallback.
 */
function get_image_url($path, $fallback = 'assets/images/placeholder.jpg')
{
    $resolved = resolveUploadPath($path);
    return $resolved === '' ? $fallback : $resolved;
}

/**
 * Admin helper. Returns a full URL path that works from any admin sub-folder.
 */
function getImageUrl($path, $fallback = 'assets/images/placeholder.jpg'): string
{
    $resolved = resolveUploadPath($path);
    if ($resolved === '') {
        $resolved = $fallback;
    }
    if (isRemoteUrl($resolved)) {
        return $resolved;
    }

    $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';
    return $base . '/' . ltrim($resolved, '/');
}

/**
 * Human readable message for a PHP upload error code.
 */
function uploadErrorMessage(int $code): string
{
    switch ($code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The file is larger than the server limit (upload_max_filesize = '
                . ini_get('upload_max_filesize') . ').';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The file is larger than the size allowed by the form.';
        case UPLOAD_ERR_PARTIAL:
            return 'The file was only partially uploaded. Please try again.';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was selected.';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'The server has no temporary folder for uploads.';
        case UPLOAD_ERR_CANT_WRITE:
            return 'The server could not write the file to disk.';
        case UPLOAD_ERR_EXTENSION:
            return 'A PHP extension blocked the upload.';
        default:
            return 'Upload failed (error code ' . $code . ').';
    }
}

/**
 * Upload an image file.
 *
 * Returns ['success' => bool, 'filename' => 'uploads/<folder>/<name>', 'error' => string].
 * "filename" is the value to store in the database.
 */
function uploadImage($file, $folder = 'products')
{
    $fail = function (string $message): array {
        return ['success' => false, 'filename' => '', 'error' => $message];
    };

    if (!is_array($file) || !isset($file['error'], $file['tmp_name'])) {
        return $fail('No valid image was uploaded.');
    }
    if ((int) $file['error'] !== UPLOAD_ERR_OK) {
        return $fail(uploadErrorMessage((int) $file['error']));
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return $fail('No valid image was uploaded.');
    }

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    $imageInfo = @getimagesize($file['tmp_name']);
    $mimeType  = is_array($imageInfo) ? ($imageInfo['mime'] ?? '') : '';

    if (!isset($allowedTypes[$mimeType])) {
        return $fail('Invalid image format. Please upload a JPG, PNG, WEBP or GIF.');
    }

    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        return $fail('Image size must not exceed 5 MB.');
    }

    // Folder name may only contain letters, numbers, dash and underscore.
    $folder = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $folder) ?: 'products';
    $relativeDir = 'uploads/' . $folder;
    $uploadDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $folder;

    if (!is_dir($uploadDirectory) && !@mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
        return $fail('Could not create the upload folder (' . $relativeDir . '). Check folder permissions.');
    }
    if (!is_writable($uploadDirectory)) {
        return $fail('The upload folder (' . $relativeDir . ') is not writable. Set its permissions to 755 or 775.');
    }

    try {
        $name = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mimeType];
    } catch (Throwable $e) {
        return $fail('Could not generate a filename.');
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . DIRECTORY_SEPARATOR . $name)) {
        return $fail('Could not save the uploaded image.');
    }

    return ['success' => true, 'filename' => $relativeDir . '/' . $name, 'error' => ''];
}

/**
 * Delete an uploaded file from disk. Remote URLs and paths outside the
 * allowed upload folders are ignored. Returns true if a file was removed.
 */
function deleteUpload($path): bool
{
    $resolved = resolveUploadPath($path);
    if ($resolved === '' || isRemoteUrl($resolved)) {
        return false;
    }

    $root = realpath(dirname(__DIR__));
    $file = realpath($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $resolved));
    if ($root === false || $file === false || !is_file($file)) {
        return false;
    }

    foreach (uploadAllowedRoots() as $allowed) {
        $dir = realpath($root . DIRECTORY_SEPARATOR . $allowed);
        if ($dir !== false && strpos($file, $dir . DIRECTORY_SEPARATOR) === 0) {
            return @unlink($file);
        }
    }

    return false;
}
