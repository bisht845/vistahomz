  </div><!-- /.adm-content -->
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Confirm deletes
document.querySelectorAll('[data-confirm]').forEach(el => {
  el.addEventListener('click', function(e) {
    if (!confirm(this.dataset.confirm || 'Are you sure?')) e.preventDefault();
  });
});
// Flash message auto-hide
setTimeout(() => {
  document.querySelectorAll('.adm-flash').forEach(el => el.style.opacity = '0');
}, 3000);
</script>
</body>
</html>
