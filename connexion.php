<?php
session_start();
require_once __DIR__ . '/config.php';

// If already logged in (and not submitting the login form), redirect to appropriate dashboard
// Allow POST requests to this page so a logged-in user can submit new credentials to switch accounts.
if (isset($_SESSION['user']) && ($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
        header('Location: dashboard-admin.php');
        exit;
    } else {
        header('Location: dashboard-client.php');
        exit;
    }
}

$login_error = '';
// Handle POST login (using DB when available)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($pdo) {
        try {
            $stmt = $pdo->prepare('SELECT id, email, password, first_name, last_name, role, created_at FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Normalize role from DB (accept Admin/ADMIN/admin) and sanitize
                $role = strtolower(trim($user['role'] ?? 'client'));
                if ($role !== 'admin' && $role !== 'client') { $role = 'client'; }

                $_SESSION['user'] = [
                    'id' => (int)$user['id'],
                    'firstName' => $user['first_name'],
                    'lastName' => $user['last_name'],
                    'email' => $user['email'],
                    'role' => $role,
                    'createdAt' => $user['created_at'] ?? date(DATE_ISO8601)
                ];

                if ($role === 'admin') {
                    header('Location: dashboard-admin.php');
                    exit;
                }
                header('Location: dashboard-client.php');
                exit;
            }

            $login_error = 'Email ou mot de passe incorrect';
        } catch (Exception $e) {
            $login_error = 'Erreur serveur, reessayez plus tard';
        }
    } else {
        // Fallback demo behavior if DB unavailable
        if ($email === 'admin@mnaclub.fr' && $password === 'admin123') {
            $_SESSION['user'] = [
                'id' => 1,
                'firstName' => 'Admin',
                'lastName' => 'MNA',
                'email' => $email,
                'role' => 'admin',
                'createdAt' => date(DATE_ISO8601)
            ];
            header('Location: dashboard-admin.php');
            exit;
        }
        $_SESSION['user'] = [
            'id' => 2,
            'firstName' => '',
            'lastName' => '',
            'email' => $email,
            'role' => 'client',
            'createdAt' => date(DATE_ISO8601)
        ];
        header('Location: dashboard-client.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - MNA Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f;
            --bg-secondary: #12121a;
            --fg: #ffffff;
            --muted: #8b8b9e;
            --accent: #ff6b9d;
            --accent-secondary: #c44cff;
            --card: rgba(255,255,255,0.03);
            --border: rgba(255,255,255,0.08);
            --glow: rgba(255,107,157,0.4);
            --error: #ef4444;
            --success: #22c55e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg); min-height: 100vh; }
        .font-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.02em; }

        .nav-glass {
            background: rgba(10,10,15,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px var(--glow);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--glow);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: transparent;
            color: var(--fg);
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.05);
            border-color: var(--accent);
        }

        .form-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid var(--border);
            border-radius: 32px;
            padding: 48px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 20px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--fg);
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255,107,157,0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .form-error {
            color: var(--error);
            font-size: 12px;
            margin-top: 6px;
            display: none;
        }

        .form-error.show {
            display: block;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--fg);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--muted);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--accent);
            font-size: 14px;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .forgot-link:hover {
            opacity: 0.8;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 24px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-text {
            padding: 0 16px;
            color: var(--muted);
            font-size: 14px;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 24px;
            z-index: 1000;
            transform: translateX(150%);
            transition: transform 0.3s ease;
        }

        .toast.show { transform: translateX(0); }
        .toast.success { border-color: var(--success); }
        .toast.error { border-color: var(--error); }

        .gradient-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -1;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
        }

        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 4px;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body>
    <div class="gradient-bg">
        <div class="gradient-orb" style="width: 500px; height: 500px; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); top: -200px; right: -100px;"></div>
        <div class="gradient-orb" style="width: 400px; height: 400px; background: linear-gradient(135deg, var(--accent-secondary), #6366f1); bottom: -100px; left: -100px;"></div>
    </div>

    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="pt-32 pb-16 px-6">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="font-display text-4xl sm:text-5xl mb-4">CONNEXION</h1>
                <p class="text-[var(--muted)]">Accede a ton espace personnel</p>
            </div>

            <div class="form-card">
                <form id="login-form" method="POST" action="connexion.php" onsubmit="handleLogin(event)" autocomplete="off" novalidate>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" autocomplete="off" class="form-input" placeholder="ton@email.com" required>
                        <p class="form-error" id="email-error"></p>
                    </div>

                    <div class="form-group relative">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" autocomplete="new-password" class="form-input pr-12" placeholder="Ton mot de passe" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                        <p class="form-error" id="password-error"></p>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember" class="checkbox-input">
                            <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="forgot-link" onclick="showForgotPassword()">Mot de passe oublie ?</a>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center" id="submit-btn">
                        Se connecter
                    </button>
                </form>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">ou</span>
                    <div class="divider-line"></div>
                </div>


            </div>

            <!-- Demo Credentials -->
            <div class="mt-8 p-4 rounded-xl bg-[var(--card)] border border-[var(--border)]">
                <p class="text-sm text-[var(--muted)] text-center">
                    <strong>Demo :</strong> Inscrivez-vous pour tester
                </p>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div id="toast" class="toast">
        <p id="toast-message"></p>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgot-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100; justify-content: center; align-items: center;">
        <div class="form-card max-w-md mx-4">
            <h3 class="font-display text-2xl mb-4">MOT DE PASSE OUBLIE</h3>
            <p class="text-[var(--muted)] mb-6">Entre ton email pour recevoir un lien de reinitialisation.</p>
            <input type="email" id="forgot-email" class="form-input mb-4" placeholder="ton@email.com">
            <div class="flex gap-4">
                <button onclick="closeForgotPassword()" class="btn-secondary flex-1 justify-center">Annuler</button>
                <button onclick="submitForgotPassword()" class="btn-primary flex-1 justify-center">Envoyer</button>
            </div>
        </div>
    </div>

    <script>
        // ===== TOGGLE PASSWORD =====
        function togglePassword() {
            const field = document.getElementById('password');
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        // ===== FORGOT PASSWORD =====
        function showForgotPassword() {
            document.getElementById('forgot-modal').style.display = 'flex';
        }

        function closeForgotPassword() {
            document.getElementById('forgot-modal').style.display = 'none';
        }

        function submitForgotPassword() {
            const email = document.getElementById('forgot-email').value;
            if (!email) {
                showToast('Veuillez entrer votre email', 'error');
                return;
            }
            showToast('Email de reinitialisation envoye !', 'success');
            closeForgotPassword();
        }

        // ===== LOGIN =====
        function handleLogin(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const submitBtn = document.getElementById('submit-btn');

            // Reset errors
            document.querySelectorAll('.form-error').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));

            // Validate
            if (!email) {
                showError('email', 'L\'email est requis');
                return;
            }

            if (!password) {
                showError('password', 'Le mot de passe est requis');
                return;
            }

            // Show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                </svg>
                Connexion...
            `;

            // Submit form to server (server sets PHP session and redirects)
            document.getElementById('login-form').submit();
        }

        function showError(field, message) {
            const input = document.getElementById(field);
            const error = document.getElementById(field + '-error');
            input.classList.add('error');
            error.textContent = message;
            error.classList.add('show');
        }

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toast.className = 'toast ' + type;
            toastMessage.textContent = message;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        <?php if (!empty($login_error)): ?>
        document.addEventListener('DOMContentLoaded', function(){ showToast('<?php echo addslashes($login_error); ?>','error'); });
        <?php endif; ?>

        // Clear login fields on page load to force fresh input
        document.addEventListener('DOMContentLoaded', function(){
            try {
                const e = document.getElementById('email');
                const p = document.getElementById('password');
                const r = document.getElementById('remember');
                if (e) { e.value = ''; }
                if (p) { p.value = ''; }
                if (r) { r.checked = false; }
                // Remove any local fallback user to avoid auto-login UI
                try { localStorage.removeItem('mna_user'); } catch(_) {}
            } catch(_) {}
        });

    </script>
</body>
</html>