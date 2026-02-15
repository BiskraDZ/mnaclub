<?php
// header.php — navigation include (shared)
$current = basename($_SERVER['PHP_SELF']);
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
$is_logged_in = !empty($_SESSION['user']);
function is_active($file) { global $current; return $current === $file ? 'active' : ''; }
?>

<!-- Shared navigation -->
<nav class="nav-glass fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
                <span class="font-display text-2xl tracking-wider">MNA CLUB</span>
            </a>

<?php if (!in_array($current, ['connexion.php','medias.php','planning.php']) || $is_logged_in): ?>
            <div class="hidden lg:flex items-center gap-8">
                <a href="index.php" class="nav-link text-sm font-medium <?php echo is_active('index.php'); ?>">Accueil</a>
                <a href="tarifs.php" class="nav-link text-sm font-medium <?php echo is_active('tarifs.php'); ?>">Tarifs</a>
                <?php if ($current !== 'tarifs.php' && $current !== 'avis.php' && $current !== 'contact.php'): ?>
                    <a href="planning.php" class="nav-link text-sm font-medium <?php echo is_active('planning.php'); ?>">Planning</a>
                    <a href="avis.php" class="nav-link text-sm font-medium <?php echo is_active('avis.php'); ?>">Avis</a>
                    <a href="medias.php" class="nav-link text-sm font-medium <?php echo is_active('medias.php'); ?>">Medias</a>
                    <a href="contact.php" class="nav-link text-sm font-medium <?php echo is_active('contact.php'); ?>">Contact</a>
                <?php endif; ?>
            </div>
<?php endif; ?>

            <div class="hidden lg:flex items-center gap-4" id="nav-auth">
                <?php
                if (session_status() == PHP_SESSION_NONE) { @session_start(); }
                if (!empty($_SESSION['user'])) {
                    $role = $_SESSION['user']['role'] ?? 'client';
                    $dash = $role === 'admin' ? 'dashboard-admin.php' : 'dashboard-client.php';
                    echo '<a href="'.phpspecialchars($dash).'" class="btn-secondary text-sm">Mon Espace</a>';
                    echo '<a href="logout.php" class="btn-primary text-sm">Deconnexion</a>';
                } else {
                    // Show Connexion / S'inscrire on all pages for unauthenticated users
                    echo '<a href="connexion.php" class="btn-secondary text-sm">Connexion</a>';
                    echo '<a href="inscription.php" class="btn-primary text-sm ml-2">S\'inscrire</a>';
                }
                ?>
            </div>

            <button id="menu-toggle" class="lg:hidden p-2" aria-label="Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu (shared) -->
<div class="mobile-overlay" id="mobile-overlay"></div>
<div class="mobile-menu" id="mobile-menu">
    <button id="menu-close" class="absolute top-6 right-6 p-2" aria-label="Fermer">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
<?php if (!in_array($current, ['connexion.php','medias.php','planning.php']) || $is_logged_in): ?>
    <div class="flex flex-col gap-6">
        <a href="index.php" class="text-2xl font-display">Accueil</a>
        <a href="tarifs.php" class="text-2xl font-display">Tarifs</a>
        <?php if ($current !== 'tarifs.php' && $current !== 'avis.php' && $current !== 'contact.php'): ?>
            <a href="planning.php" class="text-2xl font-display">Planning</a>
            <a href="avis.php" class="text-2xl font-display">Avis</a>
            <a href="medias.php" class="text-2xl font-display">Medias</a>
            <a href="contact.php" class="text-2xl font-display">Contact</a>
        <?php endif; ?> 
        <div class="section-divider my-6"></div>
        <?php
            if (session_status() == PHP_SESSION_NONE) { @session_start(); }
            if (!empty($_SESSION['user'])) {
                $role = $_SESSION['user']['role'] ?? 'client';
                $dash = $role === 'admin' ? 'dashboard-admin.php' : 'dashboard-client.php';
                echo '<a href="'.phpspecialchars($dash).'" class="btn-secondary text-center">Mon Espace</a>';
                echo '<a href="logout.php" class="btn-primary text-center">Deconnexion</a>';
            } else {
                // Show public auth CTAs on all pages (mobile menu)
                echo '<a href="connexion.php" class="btn-secondary text-center">Connexion</a>';
                echo '<a href="inscription.php" class="btn-primary text-center">S\'inscrire</a>';
            }
        ?>
    </div>
<?php endif; ?>
</div><script>
    // Server session indicator for client-side scripts (true when PHP session user exists)
    window.__MNA_SERVER_USER = <?php echo !empty($_SESSION['user']) ? 'true' : 'false'; ?>;
    // Server session role ("admin" | "client" | null) — useful for showing admin-only UI without extra AJAX
    window.__MNA_SERVER_ROLE = <?php echo !empty($_SESSION['user']) ? json_encode($_SESSION['user']['role'] ?? 'client') : 'null'; ?>;

    // Force logout (clear localStorage + server session) then show login page
    function forceShowLogin(e) {
        if (e && e.preventDefault) e.preventDefault();
        try { localStorage.removeItem('mna_user'); } catch(err) {}
        window.location.href = 'logout.php';
    }
</script>