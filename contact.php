<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - MNA Club</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg); }
        .font-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.02em; }

        .nav-glass { background: rgba(10,10,15,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
        .nav-link { position: relative; color: var(--muted); transition: color 0.3s ease; }
        .nav-link:hover { color: var(--fg); }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, var(--accent), var(--accent-secondary)); transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }

        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 14px 32px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px var(--glow); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px var(--glow); }
        .btn-secondary { background: transparent; color: var(--fg); padding: 14px 32px; border-radius: 50px; font-weight: 600; border: 1px solid var(--border); cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: var(--accent); }

        .form-card { background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid var(--border); border-radius: 24px; padding: 32px; }
        .form-input { width: 100%; padding: 14px 20px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 12px; color: var(--fg); font-size: 16px; transition: all 0.3s ease; resize: vertical; }
        .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,107,157,0.1); }
        .form-label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; }

        .contact-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; transition: all 0.3s ease; }
        .contact-card:hover { border-color: rgba(255,107,157,0.3); transform: translateY(-4px); }

        .map-container { border-radius: 20px; overflow: hidden; border: 1px solid var(--border); }

        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: #22c55e; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }

        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; }
    </style>
</head>
<body>
    <div class="gradient-bg">
        <div class="gradient-orb" style="width: 500px; height: 500px; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); top: -200px; right: -100px;"></div>
        <div class="gradient-orb" style="width: 400px; height: 400px; background: linear-gradient(135deg, var(--accent-secondary), #6366f1); bottom: -100px; left: -100px;"></div>
    </div>

    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main class="pt-12 pb-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8 reveal">
                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl mb-4">CONTACTEZ-NOUS</h1>
                <p class="text-[var(--muted)] max-w-2xl mx-auto">Une question ? Besoin d'informations ? Nous sommes la pour vous aider.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div class="space-y-6 reveal">
                    <div class="contact-card">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center flex-shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Adresse</h3>
                                <p class="text-[var(--muted)]">63 BD Stalingrad<br>Vitry-sur-Seine, 94400</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--accent-secondary)] to-indigo-500 flex items-center justify-center flex-shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Telephone</h3>
                                <p class="text-[var(--muted)]">06 XX XX XX XX</p>
                                <p class="text-sm text-[var(--muted)] mt-1">Lun-Ven: 9h-19h</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Email</h3>
                                <p class="text-[var(--muted)]">contact@mnaclub.fr</p>
                                <p class="text-sm text-[var(--muted)] mt-1">Reponse sous 24h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="map-container aspect-video">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2638.0456!2d2.3972!3d48.7886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67d8f0c4b4b0d%3A0x0!2s63%20Bd%20Stalingrad%2C%2094400%20Vitry-sur-Seine!5e0!3m2!1sfr!2sfr!4v1620000000000!5m2!1sfr!2sfr" 
                            width="100%" 
                            height="100%" 
                            style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" 
                            allowfullscreen="" 
                            loading="lazy"
                            title="Localisation MNA Club">
                        </iframe>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="form-card reveal" style="transition-delay: 0.2s;">
                    <h2 class="font-display text-2xl mb-6">ENVOYEZ UN MESSAGE</h2>
                    
                    <form id="contact-form" onsubmit="submitContact(event)">
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="form-label" for="name">Nom complet</label>
                                <input type="text" id="name" class="form-input" placeholder="Marie Dupont" required>
                            </div>
                            <div>
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" class="form-input" placeholder="marie@email.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="phone">Telephone (optionnel)</label>
                            <input type="tel" id="phone" class="form-input" placeholder="06 XX XX XX XX">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="subject">Sujet</label>
                            <select id="subject" class="form-input" required>
                                <option value="">Selectionnez un sujet</option>
                                <option value="info">Demande d'informations</option>
                                <option value="reservation">Question sur une reservation</option>
                                <option value="partnership">Partenariat</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label" for="message">Message</label>
                            <textarea id="message" class="form-input" rows="5" placeholder="Votre message..." required></textarea>
                        </div>

                        <button type="submit" class="btn-primary w-full justify-center" id="submit-btn">
                            Envoyer le message
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                    </form>

                    <div id="success-message" style="display: none;" class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <h3 class="font-display text-xl mb-2">MESSAGE ENVOYE</h3>
                        <p class="text-[var(--muted)]">Nous vous repondrons dans les plus brefs delais.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== SUBMIT CONTACT =====
        function submitContact(e) {
            e.preventDefault();

            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                </svg>
                Envoi en cours...
            `;

            setTimeout(() => {
                document.getElementById('contact-form').style.display = 'none';
                document.getElementById('success-message').style.display = 'block';
                showToast('Message envoye avec succes !', 'success');
            }, 2000);
        }

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = message;
            toast.className = 'toast ' + type;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== SCROLL REVEAL =====
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        revealElements.forEach(el => revealObserver.observe(el));

        // ===== AUTH CHECK =====
        const currentUser = localStorage.getItem('mna_user');
        if (!window.__MNA_SERVER_USER && currentUser) {
            const navAuth = document.getElementById('nav-auth');
            if (navAuth) {
                navAuth.innerHTML = `
                    <a href="dashboard-client.php" class="btn-secondary text-sm">Mon Espace</a>
                    <button onclick="logout()" class="btn-primary text-sm">Deconnexion</button>
                `;
            }
        }

        function logout() {
            try { localStorage.removeItem('mna_user'); } catch(e) {}
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>