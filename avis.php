<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avis - MNA Club</title>
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

        .review-card { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid var(--border); border-radius: 24px; padding: 32px; transition: all 0.3s ease; }
        .review-card:hover { border-color: rgba(255,107,157,0.3); transform: translateY(-4px); }

        .star { cursor: pointer; transition: all 0.2s ease; }
        .star:hover { transform: scale(1.2); }
        .star.filled { fill: var(--accent); stroke: var(--accent); }

        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; text-center; }
        .stat-number { font-size: 3rem; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .rating-bar { height: 8px; background: var(--border); border-radius: 4px; overflow: hidden; }
        .rating-fill { height: 100%; background: linear-gradient(90deg, var(--accent), var(--accent-secondary)); border-radius: 4px; transition: width 0.5s ease; }

        .form-input { width: 100%; padding: 14px 20px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 12px; color: var(--fg); font-size: 16px; transition: all 0.3s ease; resize: vertical; }
        .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,107,157,0.1); }

        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: #22c55e; }
        .toast.error { border-color: #ef4444; }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }
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
            <!-- Hero -->
            <div class="text-center mb-8 reveal">
                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl mb-4">AVIS DES MEMBRES</h1>
                <p class="text-[var(--muted)] max-w-2xl mx-auto">Decouvre les temoignages de nos membres et partage ton experience</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-16 reveal">
                <div class="stat-card">
                    <div class="stat-number">4.9</div>
                    <p class="text-[var(--muted)] text-sm mt-2">Note moyenne</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">127</div>
                    <p class="text-[var(--muted)] text-sm mt-2">Avis verifies</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <p class="text-[var(--muted)] text-sm mt-2">Recommandent</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.8</div>
                    <p class="text-[var(--muted)] text-sm mt-2">Amelioration continue</p>
                </div>
            </div>

            <!-- Rating Distribution -->
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-3xl p-8 mb-16 reveal">
                <h2 class="font-display text-2xl mb-6">REPARTITION DES NOTES</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="w-12 text-sm">5 etoiles</span>
                            <div class="rating-bar flex-1"><div class="rating-fill" style="width: 78%"></div></div>
                            <span class="text-sm text-[var(--muted)] w-12 text-right">78%</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-12 text-sm">4 etoiles</span>
                            <div class="rating-bar flex-1"><div class="rating-fill" style="width: 15%"></div></div>
                            <span class="text-sm text-[var(--muted)] w-12 text-right">15%</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-12 text-sm">3 etoiles</span>
                            <div class="rating-bar flex-1"><div class="rating-fill" style="width: 5%"></div></div>
                            <span class="text-sm text-[var(--muted)] w-12 text-right">5%</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-12 text-sm">2 etoiles</span>
                            <div class="rating-bar flex-1"><div class="rating-fill" style="width: 2%"></div></div>
                            <span class="text-sm text-[var(--muted)] w-12 text-right">2%</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-12 text-sm">1 etoile</span>
                            <div class="rating-bar flex-1"><div class="rating-fill" style="width: 0%"></div></div>
                            <span class="text-sm text-[var(--muted)] w-12 text-right">0%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-7xl font-bold bg-gradient-to-r from-[var(--accent)] to-[var(--accent-secondary)] bg-clip-text text-transparent">4.9</div>
                            <div class="flex items-center justify-center gap-1 mt-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--accent)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--accent)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--accent)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--accent)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--accent)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                            <p class="text-[var(--muted)] mt-2">Base sur 127 avis</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="reviews-container">
                <!-- Filled by JS -->
            </div>

            <!-- Write Review -->
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-3xl p-8 reveal" id="write-review">
                <h2 class="font-display text-2xl mb-6">PARTAGE TON EXPERIENCE</h2>
                
                <div id="review-form">
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-3">Ta note</label>
                        <div class="flex gap-2" id="star-rating">
                            <svg class="star" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" onclick="setRating(1)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg class="star" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" onclick="setRating(2)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg class="star" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" onclick="setRating(3)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg class="star" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" onclick="setRating(4)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg class="star" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" onclick="setRating(5)"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Ton commentaire</label>
                        <textarea id="review-comment" class="form-input" rows="4" placeholder="Decris ton experience avec le MNA Club..."></textarea>
                    </div>

                    <button onclick="submitReview()" class="btn-primary">
                        Envoyer mon avis
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </div>

                <div id="login-prompt" style="display: none;" class="text-center py-8">
                    <p class="text-[var(--muted)] mb-4">Tu dois etre connecte pour laisser un avis</p>

                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== DATA =====
        let reviewsData = JSON.parse(localStorage.getItem('mna_reviews') || 'null');
        if (!reviewsData) {
            reviewsData = [
                { id: 1, name: 'Sophie L.', initials: 'SL', rating: 5, date: '15 Janvier 2025', comment: 'Apres 3 mois, j\'ai perdu 8kg et retrouve confiance en moi. Les seances sont adaptees et le suivi personnalise fait toute la difference. Je recommande a 100% !', gradient: 'from-[var(--accent)] to-[var(--accent-secondary)]', approved: true },
                { id: 2, name: 'Claire M.', initials: 'CM', rating: 5, date: '10 Janvier 2025', comment: 'En tant que debutante, j\'etais apprehensive. L\'ambiance est bienveillante et chaque seance est un vrai moment de plaisir. Merci pour tout !', gradient: 'from-indigo-500 to-purple-600', approved: true },
                { id: 3, name: 'Laura D.', initials: 'LD', rating: 5, date: '8 Janvier 2025', comment: 'Le meilleur investissement pour ma sante. J\'ai redécouvert le plaisir du sport avec des objectifs realistes et atteignables.', gradient: 'from-green-500 to-teal-600', approved: true },
                { id: 4, name: 'Marie P.', initials: 'MP', rating: 4, date: '5 Janvier 2025', comment: 'Tres satisfaite de mon parcours. Les coachs sont a l\'ecoute et les seances sont varies. Seul petit bémol : les creneaux du soir sont tres demandes.', gradient: 'from-yellow-500 to-orange-500', approved: true },
                { id: 5, name: 'Emma R.', initials: 'ER', rating: 5, date: '2 Janvier 2025', comment: 'Une equipe au top ! L\'ambiance conviviale motive a se depasser. Les resultats sont visibles des les premieres semaines.', gradient: 'from-blue-500 to-cyan-500', approved: true },
                { id: 6, name: 'Julie B.', initials: 'JB', rating: 5, date: '28 Decembre 2024', comment: 'Je suis fan ! Les seances sont intenses mais adaptees a mon niveau. L\'encadrement est professionnel et bienveillant.', gradient: 'from-pink-500 to-rose-500', approved: true },
            ];
            localStorage.setItem('mna_reviews', JSON.stringify(reviewsData));
        }

        // Try to load server-side approved reviews (falls back to localStorage)
        (async function loadServerReviews() {
            try {
                const res = await fetch('reviews_list.php');
                if (res.ok) {
                    const json = await res.json();
                    if (Array.isArray(json) && json.length > 0) {
                        // map server fields to client format
                        reviewsData = json.map(r => ({
                            id: r.id,
                            name: r.name || 'Membre',
                            initials: (r.name || 'M').split(' ').map(s=>s.charAt(0)).slice(0,2).join(''),
                            rating: parseInt(r.rating) || 5,
                            date: r.created_at ? new Date(r.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : '',
                            comment: r.comment || '',
                            gradient: 'from-[var(--accent)] to-[var(--accent-secondary)]',
                            approved: !!r.approved
                        }));
                        localStorage.setItem('mna_reviews', JSON.stringify(reviewsData));
                    }
                }
            } catch (e) {
                // keep local snapshot
                console.warn('reviews_list.php unavailable, using local snapshot');
            }
        })();

        let currentRating = 0;

        // ===== RENDER REVIEWS =====
        function renderReviews() {
            const container = document.getElementById('reviews-container');
            
            container.innerHTML = reviewsData.map(review => `
                <div class="review-card reveal">
                    <div class="flex items-center gap-1 mb-4">
                        ${Array(5).fill(0).map((_, i) => `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="${i < review.rating ? 'var(--accent)' : 'none'}" stroke="${i < review.rating ? 'var(--accent)' : 'var(--muted)'}" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        `).join('')}
                    </div>
                    <p class="text-[var(--muted)] mb-6 leading-relaxed">"${review.comment}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br ${review.gradient} flex items-center justify-center font-semibold">${review.initials}</div>
                        <div>
                            <p class="font-medium">${review.name}</p>
                            <p class="text-sm text-[var(--muted)]">${review.date}</p>
                        </div>
                    </div>
                </div>
            `).join('');

            // Re-observe for reveal
            document.querySelectorAll('.reveal').forEach(el => {
                revealObserver.observe(el);
            });
        }

        // ===== RATING =====
        function setRating(rating) {
            currentRating = rating;
            const stars = document.querySelectorAll('#star-rating .star');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });
        }

        // ===== SUBMIT REVIEW =====
        function submitReview() {
            const comment = document.getElementById('review-comment').value;
            
            if (currentRating === 0) {
                showToast('Veuillez selectionner une note', 'error');
                return;
            }

            if (!comment.trim()) {
                showToast('Veuillez ecrire un commentaire', 'error');
                return;
            }

            const currentUser = JSON.parse(localStorage.getItem('mna_user') || 'null');
            if (!currentUser) {
                showToast('Veuillez vous connecter', 'error');
                return;
            }

            const newReview = {
                id: Date.now(),
                name: currentUser.firstName + ' ' + currentUser.lastName.charAt(0) + '.',
                initials: currentUser.firstName.charAt(0) + currentUser.lastName.charAt(0),
                rating: currentRating,
                date: new Date().toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }),
                comment: comment,
                gradient: 'from-[var(--accent)] to-[var(--accent-secondary)]'
            };

            // attempt server submit first
            try {
                const payload = { name: newReview.name, rating: newReview.rating, comment: newReview.comment };
                const res = await fetch('reviews_add.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
                if (res.ok) {
                    const saved = await res.json();
                    // map server result into client-format and insert
                    const srv = {
                        id: saved.id || Date.now(),
                        name: saved.name || newReview.name,
                        initials: (saved.name || newReview.name).split(' ').map(s=>s.charAt(0)).slice(0,2).join(''),
                        rating: saved.rating || newReview.rating,
                        date: saved.created_at ? new Date(saved.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : '',
                        comment: saved.comment || newReview.comment,
                        gradient: newReview.gradient,
                        approved: !!saved.approved
                    };
                    reviewsData.unshift(srv);
                    localStorage.setItem('mna_reviews', JSON.stringify(reviewsData));
                    renderReviews();
                    document.getElementById('review-comment').value = '';
                    setRating(0);
                    showToast('Merci pour votre avis !', 'success');
                    return;
                }
            } catch (err) {
                console.warn('reviews_add.php failed — falling back to local', err);
            }

            // fallback: local-only
            reviewsData.unshift(newReview);
            localStorage.setItem('mna_reviews', JSON.stringify(reviewsData));
            renderReviews();
            document.getElementById('review-comment').value = '';
            setRating(0);
            showToast('Merci pour votre avis (mode local)', 'success');
        }

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toast.className = 'toast ' + type;
            toastMessage.textContent = message;
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
        } else {
            document.getElementById('review-form').style.display = 'none';
            document.getElementById('login-prompt').style.display = 'block';
        }

        function logout() {
            try { localStorage.removeItem('mna_user'); } catch(e) {}
            window.location.href = 'logout.php';
        }

        // ===== INIT =====
        renderReviews();
    </script>
</body>
</html>