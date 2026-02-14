<!-- Shared footer -->
<footer class="py-8 border-t border-[var(--border)] mt-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="text-[var(--muted)] text-sm">2025 MNA Club - 63 BD Stalingrad, Vitry-sur-Seine, 94400</p>
    </div>
</footer>

<!-- Shared small scripts (menu toggle) -->
<script>
(function(){
    const menuToggle = document.getElementById('menu-toggle');
    if (!menuToggle) return;
    const menuClose = document.getElementById('menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');

    function openMenu() {
        mobileMenu.classList.add('open');
        mobileOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeMenu() {
        mobileMenu.classList.remove('open');
        mobileOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    menuToggle.addEventListener('click', openMenu);
    menuClose && menuClose.addEventListener('click', closeMenu);
    mobileOverlay && mobileOverlay.addEventListener('click', closeMenu);

    // Close mobile menu when a link inside it is clicked (useful on small screens)
    try {
        const mobileLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];
        mobileLinks.forEach(link => link.addEventListener('click', closeMenu));
    } catch (e) { /* ignore if not available */ }

    // Ensure menu closes when viewport becomes large
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeMenu();
    });
})();
</script>
