<!-- Top Announcement Bar -->
<div class="vh-announcement-bar">
    <div class="vh-container vh-bar-content">
        <div class="vh-announcement-badge">
            <i class="bi bi-shield-check"></i>
            <span><?= htmlspecialchars($announcement_text) ?></span>
        </div>
        <div class="vh-announcement-contacts">
            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $phone1) ?>">
                <i class="bi bi-telephone-fill"></i> <?= htmlspecialchars($phone1) ?>
            </a>
            <span class="d-none d-md-inline">|</span>
            <a href="mailto:<?= htmlspecialchars($email) ?>" class="d-none d-md-inline">
                <i class="bi bi-envelope-fill"></i> <?= htmlspecialchars($email) ?>
            </a>
        </div>
    </div>
</div>
    
<!-- Main Navigation Header -->
<header class="vh-header">
    <div class="vh-container vh-header-row">
        <!-- Logo -->
        <a href="index.php" class="vh-logo-link" aria-label="VISTAHOMZ Homepage">
            <img src="assets/images/logo.png" alt="VISTAHOMZ Logo" class="vh-logo-img">
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="d-none d-lg-block">
            <ul class="vh-nav-menu">
                <li><a href="index.php" class="vh-nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="category.php?cat=living" class="vh-nav-link <?= (isset($_GET['cat']) && $_GET['cat'] == 'living') ? 'active' : '' ?>">Living</a></li>
                <li><a href="category.php?cat=dining" class="vh-nav-link <?= (isset($_GET['cat']) && $_GET['cat'] == 'dining') ? 'active' : '' ?>">Dining</a></li>
                <li><a href="category.php?cat=bedroom" class="vh-nav-link <?= (isset($_GET['cat']) && $_GET['cat'] == 'bedroom') ? 'active' : '' ?>">Bedroom</a></li>
                <li><a href="category.php?cat=office" class="vh-nav-link <?= (isset($_GET['cat']) && $_GET['cat'] == 'office') ? 'active' : '' ?>">Office</a></li>
                <li><a href="category.php?cat=commercial" class="vh-nav-link <?= (isset($_GET['cat']) && $_GET['cat'] == 'commercial') ? 'active' : '' ?>">Commercial</a></li>
                <li><a href="about.php" class="vh-nav-link <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>">About</a></li>
                <li><a href="contact.php" class="vh-nav-link <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>">Contact</a></li>
            </ul>
        </nav>

        <!-- Header Actions: Search, Cart, Quote CTA, Mobile Toggle -->
        <div class="vh-header-actions">
            <!-- Search Form -->
            <form action="category.php" method="GET" class="vh-search-box">
                <i class="bi bi-search vh-search-icon"></i>
                <input type="text" name="q" placeholder="Search furniture..." class="vh-search-input" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            </form>

            <!-- Shopping Cart -->
            <a href="cart.php" class="vh-cart-btn" aria-label="View Shopping Cart">
                <i class="bi bi-bag"></i>
                <span class="vh-cart-badge" id="cartBadgeCount"><?= (int)$cart_count ?></span>
            </a>

            <!-- Quick Quote CTA -->
            <button type="button" class="vh-btn vh-btn-gold vh-btn-sm d-none d-sm-inline-flex" onclick="openQuoteModal()">
                <span>Get a Quote</span>
                <i class="bi bi-arrow-right-short"></i>
            </button>

            <!-- Mobile Hamburger Toggle -->
            <button type="button" class="vh-mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle navigation menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="vh-mobile-drawer" id="mobileDrawer">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <img src="assets/images/logo.svg" alt="VISTAHOMZ" style="height: 40px;">
        <button type="button" style="background: none; border: none; font-size: 24px; cursor: pointer;" onclick="toggleMobileMenu()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <form action="category.php" method="GET" style="margin-bottom: 24px;">
        <input type="text" name="q" placeholder="Search furniture..." class="vh-form-control" style="border-radius: 9999px;">
    </form>

    <ul style="list-style: none; padding: 0; margin: 0 0 32px; display: flex; flex-direction: column; gap: 16px;">
        <li><a href="index.php" style="font-size: 17px; font-weight: 600;">Home</a></li>
        <li><a href="category.php?cat=living" style="font-size: 17px; font-weight: 600;">Living Room</a></li>
        <li><a href="category.php?cat=dining" style="font-size: 17px; font-weight: 600;">Dining Room</a></li>
        <li><a href="category.php?cat=bedroom" style="font-size: 17px; font-weight: 600;">Bedroom</a></li>
        <li><a href="category.php?cat=office" style="font-size: 17px; font-weight: 600;">Office Workspaces</a></li>
        <li><a href="category.php?cat=commercial" style="font-size: 17px; font-weight: 600;">Commercial Bulk</a></li>
        <li><a href="about.php" style="font-size: 17px; font-weight: 600;">About VISTAHOMZ</a></li>
        <li><a href="contact.php" style="font-size: 17px; font-weight: 600;">Contact Us</a></li>
    </ul>

    <button type="button" class="vh-btn vh-btn-gold" style="width: 100%;" onclick="openQuoteModal(); toggleMobileMenu();">
        Request Free Quote
    </button>
</div>
