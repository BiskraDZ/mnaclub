<?php
session_start();

// Protect client dashboard (requires a logged-in user)
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit;
}
// If an admin accidentally lands here, send to admin dashboard
if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
    header('Location: dashboard-admin.php');
    exit;
}

$user_json = json_encode($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - MNA Club</title>
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

        .sidebar { width: 280px; background: var(--bg-secondary); border-right: 1px solid var(--border); min-height: 100vh; position: fixed; left: 0; top: 0; padding: 24px; transition: transform 0.3s ease; z-index: 50; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: var(--muted); transition: all 0.3s ease; text-decoration: none; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,107,157,0.1); color: var(--fg); }
        .sidebar-link.active { border-left: 3px solid var(--accent); }

        .main-content { margin-left: 280px; padding: 32px; min-height: 100vh; }
        
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
        .stat-number { font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 12px 24px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px var(--glow); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px var(--glow); }
        .btn-secondary { background: transparent; color: var(--fg); padding: 12px 24px; border-radius: 50px; font-weight: 600; border: 1px solid var(--border); cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-size: 14px; }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: var(--accent); }

        .tab-btn { padding: 12px 24px; border-radius: 12px; background: transparent; border: none; color: var(--muted); cursor: pointer; transition: all 0.3s ease; font-weight: 500; }
        .tab-btn:hover { color: var(--fg); }
        .tab-btn.active { background: var(--accent); color: white; }

        .reservation-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 20px; transition: all 0.3s ease; }
        .reservation-card:hover { border-color: rgba(255,107,157,0.3); }

        .form-input { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 10px; color: var(--fg); font-size: 14px; transition: all 0.3s ease; }
        .form-input:focus { outline: none; border-color: var(--accent); }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: #22c55e; }
        .toast.error { border-color: #ef4444; }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.2; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; }
    </style>
</head>
<body>
    <script>try{ localStorage.setItem('mna_user', <?php echo $user_json; ?>); }catch(e){}</script>
    <div class="gradient-bg">
        <div class="gradient-orb" style="width: 400px; height: 400px; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); top: -100px; right: 100px;"></div>
        <div class="gradient-orb" style="width: 300px; height: 300px; background: linear-gradient(135deg, var(--accent-secondary), #6366f1); bottom: 100px; left: -50px;"></div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
            </div>
            <span class="font-display text-xl">MNA CLUB</span>
        </div>

        <nav class="space-y-2">
            <a href="#" class="sidebar-link active" onclick="showTab('dashboard')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Tableau de bord
            </a>
            <a href="#" class="sidebar-link" onclick="showTab('reservations')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Mes reservations
            </a>
            <a href="#" class="sidebar-link" onclick="showTab('profile')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mon profil
            </a>
            <a href="contact.php" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Contact
            </a>
        </nav>

        <div class="mt-auto pt-8 border-t border-[var(--border)] mt-8">
            <button onclick="logout()" class="sidebar-link w-full text-left">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Deconnexion
            </button>
        </div>
    </aside>

    <!-- Mobile Menu Toggle -->
    <button class="fixed top-4 left-4 z-50 p-3 bg-[var(--bg-secondary)] border border-[var(--border)] rounded-xl lg:hidden" onclick="toggleSidebar()" aria-label="Menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-display text-3xl sm:text-4xl">BONJOUR, <span id="user-name">MEMBRE</span></h1>
                <p class="text-[var(--muted)]">Bienvenue dans ton espace personnel</p>
            </div>
            <a href="reservation.php" class="btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouvelle reservation
            </a>
        </div>

        <!-- Dashboard Tab -->
        <div id="tab-dashboard">
            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Seances reservees</p>
                    <div class="stat-number" id="stat-reservations">0</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Seances restantes</p>
                    <div class="stat-number" id="stat-remaining">0</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Prochaine seance</p>
                    <div class="stat-number text-2xl" id="stat-next">-</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Total depense</p>
                    <div class="stat-number" id="stat-spent">0€</div>
                </div>
            </div>

            <!-- Upcoming Reservations -->
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6 mb-8">
                <h2 class="font-display text-xl mb-4">PROCHAINES SEANCES</h2>
                <div id="upcoming-list" class="space-y-4">
                    <!-- Filled by JS -->
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid sm:grid-cols-3 gap-4">
                <a href="reservation.php" class="reservation-card flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[var(--accent)]/20 flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <p class="font-medium">Reserver</p>
                        <p class="text-sm text-[var(--muted)]">Nouvelle seance</p>
                    </div>
                </a>
                <a href="planning.php" class="reservation-card flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[var(--accent-secondary)]/20 flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent-secondary)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <p class="font-medium">Planning</p>
                        <p class="text-sm text-[var(--muted)]">Voir les creneaux</p>
                    </div>
                </a>
                <a href="avis.php" class="reservation-card flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div>
                        <p class="font-medium">Avis</p>
                        <p class="text-sm text-[var(--muted)]">Partager mon experience</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Reservations Tab -->
        <div id="tab-reservations" style="display: none;">
            <div class="flex items-center gap-4 mb-6">
                <button class="tab-btn active" onclick="filterReservations('all')">Toutes</button>
                <button class="tab-btn" onclick="filterReservations('upcoming')">A venir</button>
                <button class="tab-btn" onclick="filterReservations('past')">Passees</button>
            </div>
            <div id="reservations-list" class="space-y-4">
                <!-- Filled by JS -->
            </div>
        </div>

        <!-- Profile Tab -->
        <div id="tab-profile" style="display: none;">
            <div class="max-w-2xl">
                <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                    <h2 class="font-display text-xl mb-6">INFORMATIONS PERSONNELLES</h2>
                    
                    <form onsubmit="updateProfile(event)">
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Prenom</label>
                                <input type="text" id="profile-firstName" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Nom</label>
                                <input type="text" id="profile-lastName" class="form-input">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Email</label>
                            <input type="email" id="profile-email" class="form-input" disabled>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Telephone</label>
                                <input type="tel" id="profile-phone" class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Date de naissance</label>
                                <input type="date" id="profile-birthdate" class="form-input">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Objectif</label>
                            <select id="profile-goals" class="form-input">
                                <option value="">Selectionnez</option>
                                <option value="weight-loss">Perte de poids</option>
                                <option value="muscle-gain">Prise de muscle</option>
                                <option value="fitness">Remise en forme</option>
                                <option value="endurance">Endurance</option>
                                <option value="flexibility">Souplesse</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary">
                            Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== CHECK AUTH =====
        const currentUser = JSON.parse(localStorage.getItem('mna_user') || 'null');
        if (!currentUser) {
            window.location.href = 'connexion.php';
        }

        // ===== INIT USER DATA =====
        document.getElementById('user-name').textContent = currentUser.firstName.toUpperCase();
        document.getElementById('profile-firstName').value = currentUser.firstName || '';
        document.getElementById('profile-lastName').value = currentUser.lastName || '';
        document.getElementById('profile-email').value = currentUser.email || '';
        document.getElementById('profile-phone').value = currentUser.phone || '';
        document.getElementById('profile-birthdate').value = currentUser.birthdate || '';
        document.getElementById('profile-goals').value = currentUser.goals || '';

        // ===== RESERVATIONS DATA =====
        const reservations = JSON.parse(localStorage.getItem('mna_reservations') || '[]');
        const userReservations = reservations.filter(r => r.status === 'confirmed');

        // Update stats
        document.getElementById('stat-reservations').textContent = userReservations.length;
        
        let totalSpent = 0;
        userReservations.forEach(r => totalSpent += r.price);
        document.getElementById('stat-spent').textContent = totalSpent + '€';

        // Upcoming
        const upcoming = userReservations.filter(r => new Date(r.date) > new Date());
        document.getElementById('stat-remaining').textContent = upcoming.length || 0;
        
        if (upcoming.length > 0 && upcoming[0].slot) {
            document.getElementById('stat-next').textContent = upcoming[0].slot.day.split(' ')[0];
        }

        // ===== RENDER RESERVATIONS =====
        function renderUpcoming() {
            const container = document.getElementById('upcoming-list');
            if (upcoming.length === 0) {
                container.innerHTML = '<p class="text-[var(--muted)] text-center py-8">Aucune seance programmee. <a href="reservation.php" class="text-[var(--accent)]">Reserver maintenant</a></p>';
                return;
            }

            container.innerHTML = upcoming.slice(0, 3).map(r => `
                <div class="reservation-card flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-[var(--accent)]/20 flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <p class="font-medium">${r.slot ? r.slot.day : 'Date a definir'}</p>
                            <p class="text-sm text-[var(--muted)]">${r.slot ? r.slot.time : ''}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">Confirmee</span>
                </div>
            `).join('');
        }

        function renderReservations(filter = 'all') {
            const container = document.getElementById('reservations-list');
            let filtered = userReservations;
            
            if (filter === 'upcoming') {
                filtered = userReservations.filter(r => new Date(r.date) > new Date());
            } else if (filter === 'past') {
                filtered = userReservations.filter(r => new Date(r.date) <= new Date());
            }

            if (filtered.length === 0) {
                container.innerHTML = '<p class="text-[var(--muted)] text-center py-8">Aucune reservation</p>';
                return;
            }

            container.innerHTML = filtered.map(r => `
                <div class="reservation-card">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center text-sm font-bold">
                                ${r.offer === 'decouverte' ? 'D' : r.offer === 'unitaire' ? 'U' : 'A'}
                            </div>
                            <div>
                                <p class="font-medium">${r.slot ? r.slot.day : 'Date a definir'}</p>
                                <p class="text-sm text-[var(--muted)]">${r.slot ? r.slot.time : ''} - ${r.id}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-lg font-bold">${r.price}€</span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">Confirmee</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterReservations(filter) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            renderReservations(filter);
        }

        // ===== TABS =====
        function showTab(tab) {
            document.querySelectorAll('[id^="tab-"]').forEach(t => t.style.display = 'none');
            document.getElementById('tab-' + tab).style.display = 'block';
            
            document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');

            if (tab === 'reservations') renderReservations();
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        // ===== PROFILE =====
        function updateProfile(e) {
            e.preventDefault();
            
            currentUser.firstName = document.getElementById('profile-firstName').value;
            currentUser.lastName = document.getElementById('profile-lastName').value;
            currentUser.phone = document.getElementById('profile-phone').value;
            currentUser.birthdate = document.getElementById('profile-birthdate').value;
            currentUser.goals = document.getElementById('profile-goals').value;

            localStorage.setItem('mna_user', JSON.stringify(currentUser));

            // Update in users list
            const users = JSON.parse(localStorage.getItem('mna_users') || '[]');
            const index = users.findIndex(u => u.id === currentUser.id);
            if (index !== -1) {
                users[index] = currentUser;
                localStorage.setItem('mna_users', JSON.stringify(users));
            }

            showToast('Profil mis a jour', 'success');
        }

        // ===== LOGOUT =====
        function logout() {
            localStorage.removeItem('mna_user');
            window.location.href = 'index.php';
        }

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = message;
            toast.className = 'toast ' + type;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== INIT =====
        renderUpcoming();
    </script>
</body>
</html>