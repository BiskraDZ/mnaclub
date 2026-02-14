<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - MNA Club</title>
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
            color: var(--fg);
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

        .form-input.success {
            border-color: var(--success);
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
            align-items: flex-start;
            gap: 12px;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--muted);
            cursor: pointer;
        }

        .checkbox-label a {
            color: var(--accent);
            text-decoration: none;
        }

        .checkbox-label a:hover {
            text-decoration: underline;
        }

        .strength-bar {
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { width: 33%; background: var(--error); }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: var(--success); }

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

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 32px;
        }

        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: var(--accent);
            box-shadow: 0 0 10px var(--glow);
        }

        .step-dot.completed {
            background: var(--success);
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
                <h1 class="font-display text-4xl sm:text-5xl mb-4">CREER MON COMPTE</h1>
                <p class="text-[var(--muted)]">Rejoins la communaute MNA Club</p>
            </div>

            <div class="step-indicator">
                <div class="step-dot active" id="step-1"></div>
                <div class="step-dot" id="step-2"></div>
                <div class="step-dot" id="step-3"></div>
            </div>

            <div class="form-card">
                <form id="register-form" onsubmit="handleSubmit(event)">
                    <!-- Step 1: Personal Info -->
                    <div id="form-step-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label" for="firstName">Prenom</label>
                                <input type="text" id="firstName" class="form-input" placeholder="Marie" required>
                                <p class="form-error" id="firstName-error"></p>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="lastName">Nom</label>
                                <input type="text" id="lastName" class="form-input" placeholder="Dupont" required>
                                <p class="form-error" id="lastName-error"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" class="form-input" placeholder="marie@email.com" required>
                            <p class="form-error" id="email-error"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone">Telephone</label>
                            <input type="tel" id="phone" class="form-input" placeholder="06 XX XX XX XX" required>
                            <p class="form-error" id="phone-error"></p>
                        </div>

                        <button type="button" onclick="nextStep(2)" class="btn-primary w-full justify-center">
                            Continuer
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Step 2: Password -->
                    <div id="form-step-2" style="display: none;">
                        <div class="form-group relative">
                            <label class="form-label" for="password">Mot de passe</label>
                            <input type="password" id="password" class="form-input pr-12" placeholder="Min 8 caracteres" required oninput="checkPasswordStrength()">
                            <span class="password-toggle" onclick="togglePassword('password')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </span>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <p class="form-error" id="password-error"></p>
                        </div>

                        <div class="form-group relative">
                            <label class="form-label" for="confirmPassword">Confirmer le mot de passe</label>
                            <input type="password" id="confirmPassword" class="form-input pr-12" placeholder="Repetez le mot de passe" required>
                            <span class="password-toggle" onclick="togglePassword('confirmPassword')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </span>
                            <p class="form-error" id="confirmPassword-error"></p>
                        </div>

                        <div class="flex gap-4">
                            <button type="button" onclick="prevStep(1)" class="btn-secondary flex-1 justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="19" y1="12" x2="5" y2="12"/>
                                    <polyline points="12 19 5 12 12 5"/>
                                </svg>
                                Retour
                            </button>
                            <button type="button" onclick="nextStep(3)" class="btn-primary flex-1 justify-center">
                                Continuer
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Terms & Submit -->
                    <div id="form-step-3" style="display: none;">
                        <div class="form-group">
                            <label class="form-label" for="birthdate">Date de naissance</label>
                            <input type="date" id="birthdate" class="form-input" required>
                            <p class="form-error" id="birthdate-error"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="goals">Objectifs (optionnel)</label>
                            <select id="goals" class="form-input">
                                <option value="">Selectionnez votre objectif</option>
                                <option value="weight-loss">Perte de poids</option>
                                <option value="muscle-gain">Prise de muscle</option>
                                <option value="fitness">Remise en forme</option>
                                <option value="endurance">Endurance</option>
                                <option value="flexibility">Souplesse</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="terms" class="checkbox-input" required>
                                <label for="terms" class="checkbox-label">
                                    J'accepte les <a href="#">conditions generales</a> et la <a href="#">politique de confidentialite</a>
                                </label>
                            </div>
                            <p class="form-error" id="terms-error"></p>
                        </div>

                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="newsletter" class="checkbox-input">
                                <label for="newsletter" class="checkbox-label">
                                    Je souhaite recevoir les actualites et offres du MNA Club
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="button" onclick="prevStep(2)" class="btn-secondary flex-1 justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="19" y1="12" x2="5" y2="12"/>
                                    <polyline points="12 19 5 12 12 5"/>
                                </svg>
                                Retour
                            </button>
                            <button type="submit" class="btn-primary flex-1 justify-center" id="submit-btn">
                                Creer mon compte
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-[var(--muted)] text-sm">
                        Deja un compte ?
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div id="toast" class="toast">
        <p id="toast-message"></p>
    </div>

    <script>
        let currentStep = 1;

        // ===== STEP NAVIGATION =====
        function nextStep(step) {
            if (!validateStep(currentStep)) return;

            document.getElementById('form-step-' + currentStep).style.display = 'none';
            document.getElementById('step-' + currentStep).classList.remove('active');
            document.getElementById('step-' + currentStep).classList.add('completed');

            currentStep = step;
            document.getElementById('form-step-' + currentStep).style.display = 'block';
            document.getElementById('step-' + currentStep).classList.add('active');
        }

        function prevStep(step) {
            document.getElementById('form-step-' + currentStep).style.display = 'none';
            document.getElementById('step-' + currentStep).classList.remove('active');

            currentStep = step;
            document.getElementById('form-step-' + currentStep).style.display = 'block';
            document.getElementById('step-' + currentStep).classList.remove('completed');
            document.getElementById('step-' + currentStep).classList.add('active');
        }

        // ===== VALIDATION =====
        function validateStep(step) {
            let valid = true;

            if (step === 1) {
                const firstName = document.getElementById('firstName');
                const lastName = document.getElementById('lastName');
                const email = document.getElementById('email');
                const phone = document.getElementById('phone');

                if (!firstName.value.trim()) {
                    showError('firstName', 'Le prenom est requis');
                    valid = false;
                } else {
                    clearError('firstName');
                }

                if (!lastName.value.trim()) {
                    showError('lastName', 'Le nom est requis');
                    valid = false;
                } else {
                    clearError('lastName');
                }

                if (!email.value.trim()) {
                    showError('email', 'L\'email est requis');
                    valid = false;
                } else if (!isValidEmail(email.value)) {
                    showError('email', 'Email invalide');
                    valid = false;
                } else {
                    clearError('email');
                }

                if (!phone.value.trim()) {
                    showError('phone', 'Le telephone est requis');
                    valid = false;
                } else {
                    clearError('phone');
                }
            }

            if (step === 2) {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirmPassword');

                if (password.value.length < 8) {
                    showError('password', 'Minimum 8 caracteres');
                    valid = false;
                } else {
                    clearError('password');
                }

                if (password.value !== confirmPassword.value) {
                    showError('confirmPassword', 'Les mots de passe ne correspondent pas');
                    valid = false;
                } else {
                    clearError('confirmPassword');
                }
            }

            return valid;
        }

        function showError(field, message) {
            const input = document.getElementById(field);
            const error = document.getElementById(field + '-error');
            input.classList.add('error');
            input.classList.remove('success');
            error.textContent = message;
            error.classList.add('show');
        }

        function clearError(field) {
            const input = document.getElementById(field);
            const error = document.getElementById(field + '-error');
            input.classList.remove('error');
            input.classList.add('success');
            error.classList.remove('show');
        }

        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        // ===== PASSWORD STRENGTH =====
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthFill = document.getElementById('strength-fill');
            
            strengthFill.className = 'strength-fill';

            if (password.length === 0) {
                strengthFill.style.width = '0';
                return;
            }

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            if (strength <= 1) {
                strengthFill.classList.add('strength-weak');
            } else if (strength <= 2) {
                strengthFill.classList.add('strength-medium');
            } else {
                strengthFill.classList.add('strength-strong');
            }
        }

        // ===== TOGGLE PASSWORD =====
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        // ===== FORM SUBMIT =====
        function handleSubmit(e) {
            e.preventDefault();

            const terms = document.getElementById('terms');
            if (!terms.checked) {
                showError('terms', 'Vous devez accepter les conditions');
                return;
            }

            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                </svg>
                Creation en cours...
            `;

            // Submit to server-side registration (register.php)
            const formData = new FormData();
            formData.append('firstName', document.getElementById('firstName').value);
            formData.append('lastName', document.getElementById('lastName').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('password', document.getElementById('password').value);
            formData.append('birthdate', document.getElementById('birthdate').value);
            formData.append('goals', document.getElementById('goals').value);
            formData.append('newsletter', document.getElementById('newsletter').checked ? '1' : '0');

            fetch('register.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        try { 
                            localStorage.setItem('mna_user', JSON.stringify(data.user)); 
                            // ensure admin UI (local fallback) sees this user when DB is unavailable
                            const list = JSON.parse(localStorage.getItem('mna_users') || '[]');
                            const exists = list.find(u => u.email === data.user.email);
                            if (!exists) {
                                list.unshift({ id: data.user.id || Date.now(), firstName: data.user.firstName || data.user.first_name || '', lastName: data.user.lastName || data.user.last_name || '', email: data.user.email, phone: data.user.phone || '', role: data.user.role || 'client', createdAt: data.user.createdAt || new Date().toISOString() });
                                localStorage.setItem('mna_users', JSON.stringify(list));
                            }
                        } catch(e) {}
                        showToast('Compte cree avec succes !', 'success');
                        setTimeout(() => window.location.href = 'dashboard-client.php', 900);
                    } else {
                        showToast(data.message || 'Erreur', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Creer mon compte';
                    }
                })
                .catch(() => {
                    showToast('Erreur reseau — veuillez reessayer', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Creer mon compte';
                });
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

        // ===== CHECK IF ALREADY LOGGED IN =====
        const currentUser = localStorage.getItem('mna_user');
        if (currentUser) {
            window.location.href = 'dashboard-client.php';
        }
    </script>
</body>
</html>