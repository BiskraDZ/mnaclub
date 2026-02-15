<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Complete - MNA Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .sidebar { width: 280px; background: var(--bg-secondary); border-right: 1px solid var(--border); min-height: 100vh; position: fixed; left: 0; top: 0; padding: 24px; z-index: 50; transition: transform 0.3s; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: var(--muted); transition: all 0.3s ease; text-decoration: none; cursor: pointer; background: none; border: none; width: 100%; text-align: left; font-size: 14px; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,107,157,0.1); color: var(--fg); }
        .sidebar-link.active { border-left: 3px solid var(--accent); }

        .main-content { margin-left: 280px; padding: 32px; min-height: 100vh; }
        
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
        .stat-number { font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 10px 20px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary { background: var(--card); color: var(--fg); padding: 10px 20px; border-radius: 50px; font-weight: 600; border: 1px solid var(--border); cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
        .btn-secondary:hover { border-color: var(--accent); }
        .btn-danger { background: #ef4444; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 12px; }
        .btn-danger:hover { background: #dc2626; }
        .btn-success { background: #22c55e; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; font-size: 12px; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 16px; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); border-bottom: 1px solid var(--border); }
        .data-table td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 14px; }
        .data-table tr:hover { background: rgba(255,255,255,0.02); }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; }
        .badge-success { background: rgba(34,197,94,0.2); color: #22c55e; }
        .badge-warning { background: rgba(245,158,11,0.2); color: #f59e0b; }
        .badge-danger { background: rgba(239,68,68,0.2); color: #ef4444; }

        .form-input { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 10px; color: var(--fg); font-size: 14px; transition: all 0.3s ease; }
        .form-input:focus { outline: none; border-color: var(--accent); }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: #22c55e; }
        .toast.error { border-color: #ef4444; }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.2; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); position: fixed; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="gradient-bg">
        <div class="gradient-orb" style="width: 400px; height: 400px; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); top: -100px; right: 100px;"></div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
            </div>
            <div>
                <span class="font-display text-xl">MNA CLUB</span>
                <p class="text-xs text-[var(--muted)]">Administration</p>
            </div>
        </div>

        <nav class="space-y-2">
            <button class="sidebar-link active" onclick="showAdminTab('overview')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Vue d'ensemble
            </button>
            <button class="sidebar-link" onclick="showAdminTab('reservations')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Reservations
            </button>
            <button class="sidebar-link" onclick="showAdminTab('clients')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Clients
            </button>
            <button class="sidebar-link" onclick="showAdminTab('slots')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Creneaux
            </button>
            <button class="sidebar-link" onclick="showAdminTab('reviews')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Avis
            </button>
            <button class="sidebar-link" onclick="showAdminTab('settings')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Parametres
            </button>
        </nav>

        <div class="mt-auto pt-8 border-t border-[var(--border)] mt-8">
            <a href="index.php" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Retour au site
            </a>
            <button onclick="logout()" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Deconnexion
            </button>
        </div>
    </aside>

    <!-- Mobile Toggle -->
    <button class="fixed top-4 left-4 z-50 p-3 bg-[var(--bg-secondary)] border border-[var(--border)] rounded-xl lg:hidden" onclick="toggleSidebar()">Menu</button>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-3xl">TABLEAU DE BORD</h1>
                <p class="text-[var(--muted)]">Bienvenue, Administrateur</p>
            </div>
            <div class="text-sm text-[var(--muted)]" id="current-date"></div>
        </div>

        <!-- OVERVIEW TAB -->
        <div id="tab-overview">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card"><p class="text-[var(--muted)] text-sm mb-2">Clients</p><div class="stat-number" id="stat-clients">0</div></div>
                <div class="stat-card"><p class="text-[var(--muted)] text-sm mb-2">Reservations</p><div class="stat-number" id="stat-reservations">0</div></div>
                <div class="stat-card"><p class="text-[var(--muted)] text-sm mb-2">Revenus</p><div class="stat-number" id="stat-revenue">0€</div></div>
                <div class="stat-card"><p class="text-[var(--muted)] text-sm mb-2">Note</p><div class="stat-number">4.9</div></div>
            </div>
            <div class="grid lg:grid-cols-2 gap-6">
                <div class="stat-card"><h2 class="font-display text-xl mb-4">DERNIERES RESERVATIONS</h2><div id="recent-reservations" class="space-y-3"></div></div>
                <div class="stat-card"><h2 class="font-display text-xl mb-4">DERNIERS CLIENTS</h2><div id="recent-clients" class="space-y-3"></div></div>
            </div>
        </div>

        <!-- RESERVATIONS TAB -->
        <div id="tab-reservations" style="display: none;">
            <div class="stat-card overflow-hidden">
                <div class="p-6 border-b border-[var(--border)] flex justify-between items-center">
                    <h2 class="font-display text-xl">TOUTES LES RESERVATIONS</h2>
                    <button class="btn-secondary" onclick="exportData('reservations')">Exporter</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table"><thead><tr><th>ID</th><th>Client</th><th>Offre</th><th>Date</th><th>Montant</th><th>Statut</th></tr></thead><tbody id="reservations-table"></tbody></table>
                </div>
            </div>
        </div>

        <!-- CLIENTS TAB -->
        <div id="tab-clients" style="display: none;">
            <div class="stat-card overflow-hidden">
                <div class="p-6 border-b border-[var(--border)] flex justify-between items-center">
                    <h2 class="font-display text-xl">LISTE DES CLIENTS</h2>
                    <button class="btn-secondary" onclick="exportData('clients')">Exporter CSV</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table"><thead><tr><th>Nom</th><th>Email</th><th>Telephone</th><th>Inscription</th><th>Statut</th><th>Actions</th></tr></thead><tbody id="clients-table"></tbody></table>
                </div>
            </div>
        </div>

        <!-- SLOTS TAB -->
        <div id="tab-slots" style="display: none;">
            <div class="stat-card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-display text-xl">GESTION DES CRENEAUX</h2>
                    <button class="btn-primary" onclick="addNewSlot()">+ Ajouter un creneau</button>
                </div>
                <div id="slots-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Filled by JS -->
                </div>
            </div>
            
            <!-- Add Slot Form (Hidden by default) -->
            <div id="add-slot-form" class="stat-card mt-6" style="display: none;">
                <h3 class="font-display text-lg mb-4">NOUVEAU CRENEAU</h3>
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm mb-2">Jour</label>
                        <select id="slot-day" class="form-input">
                            <option value="Lundi">Lundi</option>
                            <option value="Mardi">Mardi</option>
                            <option value="Mercredi">Mercredi</option>
                            <option value="Jeudi">Jeudi</option>
                            <option value="Vendredi">Vendredi</option>
                            <option value="Samedi">Samedi</option>
                            <option value="Dimanche">Dimanche</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-2">Heure debut</label>
                        <input type="time" id="slot-start" class="form-input" value="18:00">
                    </div>
                    <div>
                        <label class="block text-sm mb-2">Heure fin</label>
                        <input type="time" id="slot-end" class="form-input" value="19:00">
                    </div>
                    <div>
                        <label class="block text-sm mb-2">Places max</label>
                        <input type="number" id="slot-max" class="form-input" value="10">
                    </div>
                </div>
                <div class="flex gap-4">
                    <button onclick="saveSlot()" class="btn-primary">Enregistrer</button>
                    <button onclick="closeSlotForm()" class="btn-secondary">Annuler</button>
                </div>
            </div>
        </div>

        <!-- REVIEWS TAB -->
        <div id="tab-reviews" style="display: none;">
            <div class="stat-card">
                <h2 class="font-display text-xl mb-6">MODERATION DES AVIS</h2>
                <div id="reviews-list" class="space-y-4">
                    <!-- Filled by JS -->
                </div>
            </div>
        </div>

        <!-- SETTINGS TAB -->
        <div id="tab-settings" style="display: none;">
            <div class="stat-card max-w-2xl">
                <h2 class="font-display text-xl mb-6">PARAMETRES DU SITE</h2>
                
                <div class="space-y-6">
                    <!-- Maintenance Mode -->
                    <div class="flex items-center justify-between p-4 border border-[var(--border)] rounded-xl">
                        <div>
                            <h3 class="font-semibold">Mode Maintenance</h3>
                            <p class="text-sm text-[var(--muted)]">Desactive le site pour les utilisateurs</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="maintenance-toggle" class="sr-only peer" onchange="toggleMaintenance()">
                            <div class="w-11 h-6 bg-[var(--border)] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--accent)]"></div>
                        </label>
                    </div>

                    <!-- Business Info -->
                    <div>
                        <h3 class="font-semibold mb-4">Informations business</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm mb-2">Email de contact</label>
                                <input type="email" class="form-input" value="contact@mnaclub.fr">
                            </div>
                            <div>
                                <label class="block text-sm mb-2">Telephone</label>
                                <input type="tel" class="form-input" value="06 XX XX XX XX">
                            </div>
                            <div>
                                <label class="block text-sm mb-2">Adresse</label>
                                <input type="text" class="form-input" value="63 BD Stalingrad, Vitry-sur-Seine, 94400">
                            </div>
                        </div>
                    </div>

                    <button class="btn-primary" onclick="saveSettings()">Sauvegarder les parametres</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== AUTH CHECK =====
        const currentUser = JSON.parse(localStorage.getItem('mna_user') || 'null');
        if (!currentUser || currentUser.role !== 'admin') {
            window.location.href = 'connexion.php';
        }

        // ===== DATA =====
        let users = JSON.parse(localStorage.getItem('mna_users') || '[]');
        let reservations = JSON.parse(localStorage.getItem('mna_reservations') || '[]');
        let slots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
        let reviews = [
            { id: 1, name: 'Sophie L.', rating: 5, comment: 'Excellent coaching !', approved: true },
            { id: 2, name: 'Julie M.', rating: 4, comment: 'Tres bien mais creneaux limites.', approved: false },
            { id: 3, name: 'Claire D.', rating: 5, comment: 'Je recommande a 100%.', approved: true }
        ];

        // Init dates
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

        // ===== STATS =====
        document.getElementById('stat-clients').textContent = users.length;
        document.getElementById('stat-reservations').textContent = reservations.length;
        let totalRevenue = reservations.reduce((sum, r) => sum + r.price, 0);
        document.getElementById('stat-revenue').textContent = totalRevenue + '€';

        // ===== RENDER FUNCTIONS =====
        function renderRecentReservations() {
            const c = document.getElementById('recent-reservations');
            const recent = reservations.slice(-5).reverse();
            if (recent.length === 0) { c.innerHTML = '<p class="text-[var(--muted)]">Aucune reservation</p>'; return; }
            c.innerHTML = recent.map(r => `
                <div class="flex items-center justify-between p-3 bg-[rgba(255,255,255,0.02)] rounded-lg">
                    <div><p class="font-medium">${r.id}</p><p class="text-sm text-[var(--muted)]">${r.slot ? r.slot.day : 'N/A'}</p></div>
                    <span class="badge badge-success">${r.price}€</span>
                </div>
            `).join('');
        }

        function renderRecentClients() {
            const c = document.getElementById('recent-clients');
            const recent = users.slice(-5).reverse();
            if (recent.length === 0) { c.innerHTML = '<p class="text-[var(--muted)]">Aucun client</p>'; return; }
            c.innerHTML = recent.map(u => `
                <div class="flex items-center gap-3 p-3 bg-[rgba(255,255,255,0.02)] rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center font-semibold text-sm">${u.firstName.charAt(0)}${u.lastName.charAt(0)}</div>
                    <div><p class="font-medium">${u.firstName} ${u.lastName}</p><p class="text-sm text-[var(--muted)]">${u.email}</p></div>
                </div>
            `).join('');
        }

        function renderReservationsTable() {
            const t = document.getElementById('reservations-table');
            if (reservations.length === 0) { t.innerHTML = '<tr><td colspan="6" class="text-center text-[var(--muted)]">Aucune donnee</td></tr>'; return; }
            t.innerHTML = reservations.map(r => `
                <tr>
                    <td class="font-mono text-sm">${r.id}</td>
                    <td>-</td>
                    <td class="capitalize">${r.offer}</td>
                    <td>${r.slot ? r.slot.day : 'N/A'}</td>
                    <td class="font-semibold">${r.price}€</td>
                    <td><span class="badge badge-success">Confirmee</span></td>
                </tr>
            `).join('');
        }

        function renderClientsTable() {
            const t = document.getElementById('clients-table');
            if (users.length === 0) { t.innerHTML = '<tr><td colspan="6" class="text-center text-[var(--muted)]">Aucun client</td></tr>'; return; }
            t.innerHTML = users.map(u => `
                <tr>
                    <td>${u.firstName} ${u.lastName}</td>
                    <td>${u.email}</td>
                    <td>${u.phone || '-'}</td>
                    <td>${new Date(u.createdAt).toLocaleDateString('fr-FR')}</td>
                    <td><span class="badge badge-success">Actif</span></td>
                    <td><button class="btn-danger" onclick="blockClient('${u.id}')">Bloquer</button></td>
                </tr>
            `).join('');
        }

        function renderSlots() {
            const grid = document.getElementById('slots-grid');
            if (slots.length === 0) {
                // Default slots if empty
                slots = [
                    { id: 1, day: 'Lundi', start: '18:00', end: '19:00', max: 10 },
                    { id: 2, day: 'Mercredi', start: '10:00', end: '11:00', max: 10 },
                    { id: 3, day: 'Vendredi', start: '18:00', end: '19:00', max: 10 }
                ];
            }
            
            grid.innerHTML = slots.map(s => `
                <div class="p-4 border border-[var(--border)] rounded-xl bg-[rgba(255,255,255,0.01)]">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-semibold">${s.day}</h3>
                        <button onclick="deleteSlot(${s.id})" class="text-[var(--muted)] hover:text-red-400 transition-colors">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </div>
                    <p class="text-2xl font-bold mb-1">${s.start} - ${s.end}</p>
                    <p class="text-sm text-[var(--muted)]">${s.max} places max</p>
                </div>
            `).join('');
        }

        function renderReviews() {
            const list = document.getElementById('reviews-list');
            list.innerHTML = reviews.map(r => `
                <div class="p-4 border border-[var(--border)] rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold">${r.name}</span>
                            <div class="flex">
                                ${Array(5).fill(0).map((_, i) => `<svg width="14" height="14" viewBox="0 0 24 24" fill="${i < r.rating ? '#ff6b9d' : 'none'}" stroke="#ff6b9d" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`).join('')}
                            </div>
                        </div>
                        <p class="text-[var(--muted)]">"${r.comment}"</p>
                    </div>
                    <div class="flex gap-2">
                        ${r.approved 
                            ? `<span class="badge badge-success">Valide</span>` 
                            : `<button onclick="approveReview(${r.id})" class="btn-success">Valider</button><button onclick="deleteReview(${r.id})" class="btn-danger">Supprimer</button>`
                        }
                    </div>
                </div>
            `).join('');
        }

        // ===== TAB NAVIGATION =====
        function showAdminTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('[id^="tab-"]').forEach(el => el.style.display = 'none');
            // Show target tab
            document.getElementById('tab-' + tabName).style.display = 'block';
            // Update sidebar active state
            document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');
            
            // Render specific content
            if (tabName === 'reservations') renderReservationsTable();
            if (tabName === 'clients') renderClientsTable();
            if (tabName === 'slots') renderSlots();
            if (tabName === 'reviews') renderReviews();
        }

        // ===== ACTIONS =====
        function blockClient(id) {
            if(confirm('Bloquer ce client ?')) {
                showToast('Client bloque', 'error');
            }
        }

        function addNewSlot() {
            document.getElementById('add-slot-form').style.display = 'block';
        }

        function closeSlotForm() {
            document.getElementById('add-slot-form').style.display = 'none';
        }

        function saveSlot() {
            const newSlot = {
                id: Date.now(),
                day: document.getElementById('slot-day').value,
                start: document.getElementById('slot-start').value,
                end: document.getElementById('slot-end').value,
                max: parseInt(document.getElementById('slot-max').value)
            };
            slots.push(newSlot);
            localStorage.setItem('mna_slots', JSON.stringify(slots));
            renderSlots();
            closeSlotForm();
            showToast('Creneau ajoute', 'success');
        }

        function deleteSlot(id) {
            if(confirm('Supprimer ce creneau ?')) {
                slots = slots.filter(s => s.id !== id);
                localStorage.setItem('mna_slots', JSON.stringify(slots));
                renderSlots();
                showToast('Creneau supprime', 'error');
            }
        }

        function approveReview(id) {
            const review = reviews.find(r => r.id === id);
            if(review) {
                review.approved = true;
                renderReviews();
                showToast('Avis valide', 'success');
            }
        }

        function deleteReview(id) {
            if(confirm('Supprimer cet avis ?')) {
                reviews = reviews.filter(r => r.id !== id);
                renderReviews();
                showToast('Avis supprime', 'error');
            }
        }

        function toggleMaintenance() {
            const isOn = document.getElementById('maintenance-toggle').checked;
            showToast(isOn ? 'Mode maintenance active' : 'Site en ligne', 'success');
        }

        function saveSettings() {
            showToast('Parametres sauvegardes', 'success');
        }

        function exportData(type) {
            let data, filename;
            if (type === 'clients') {
                data = users;
                filename = 'clients.csv';
            } else {
                data = reservations;
                filename = 'reservations.csv';
            }
            
            if (data.length === 0) {
                showToast('Aucune donnee a exporter', 'error');
                return;
            }

            const keys = Object.keys(data[0]);
            let csv = keys.join(',') + '\n';
            data.forEach(row => {
                csv += keys.map(k => JSON.stringify(row[k] || '')).join(',') + '\n';
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            
            showToast('Export termine', 'success');
        }

        // ===== UTILITY =====
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function logout() {
            try { localStorage.removeItem('mna_user'); } catch(e) {}
            window.location.href = 'logout.php';
        }

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = message;
            toast.className = 'toast ' + type;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== INIT =====
        renderRecentReservations();
        renderRecentClients();
    </script>
</body>
</html>