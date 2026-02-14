<?php
session_start();

// Protect page: only allow admin
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

$user_json = json_encode($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - MNA Club</title>
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
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg); }
        .font-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.02em; }

        .sidebar { width: 280px; background: var(--bg-secondary); border-right: 1px solid var(--border); min-height: 100vh; position: fixed; left: 0; top: 0; padding: 24px; z-index: 50; transition: transform 0.3s ease; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; color: var(--muted); transition: all 0.3s ease; text-decoration: none; cursor: pointer; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,107,157,0.1); color: var(--fg); }
        .sidebar-link.active { border-left: 3px solid var(--accent); }

        .main-content { margin-left: 280px; padding: 32px; min-height: 100vh; }

        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 24px; }
        .stat-number { font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 10px 20px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-secondary { background: transparent; color: var(--fg); padding: 10px 20px; border-radius: 50px; font-weight: 600; border: 1px solid var(--border); cursor: pointer; transition: all 0.3s ease; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { border-color: var(--accent); }
        .btn-danger { background: var(--error); color: white; padding: 8px 16px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; font-size: 12px; }
        .btn-danger:hover { background: #dc2626; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 16px; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); border-bottom: 1px solid var(--border); }
        .data-table td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 14px; }
        .data-table tr:hover { background: rgba(255,255,255,0.02); }

        .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-success { background: rgba(34,197,94,0.2); color: var(--success); }
        .badge-warning { background: rgba(245,158,11,0.2); color: #f59e0b; }
        .badge-danger { background: rgba(239,68,68,0.2); color: var(--error); }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; display: flex; align-items: center; gap: 12px; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: var(--success); }
        .toast.error { border-color: var(--error); }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.2; }

        /* Gallery styles */
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
        .gallery-item { position: relative; border-radius: 12px; overflow: hidden; aspect-ratio: 1; background: var(--card); border: 1px solid var(--border); }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
        .gallery-item:hover img { transform: scale(1.05); }
        .gallery-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 12px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); }

        .upload-zone { border: 2px dashed var(--border); border-radius: 16px; padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s ease; }
        .upload-zone:hover, .upload-zone.dragover { border-color: var(--accent); background: rgba(255,107,157,0.05); }
        .upload-zone.dragover { transform: scale(1.02); }

        .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100; display: none; justify-content: center; align-items: center; padding: 20px; }
        .modal.open { display: flex; }
        .modal-content { background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 20px; padding: 32px; max-width: 500px; width: 100%; }

        .file-preview { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
        .file-preview-item { position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); }
        .file-preview-item img { width: 100%; height: 100%; object-fit: cover; }
        .file-preview-remove { position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: var(--error); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.3s ease forwards; }
    </style>
</head>
<body>
    <script>try{ localStorage.setItem('mna_user', <?php echo $user_json; ?>); }catch(e){}</script>
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
            <div class="sidebar-link active" onclick="showAdminTab('overview')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Vue d'ensemble
            </div>
            <div class="sidebar-link" onclick="showAdminTab('reservations')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Reservations
            </div>
            <div class="sidebar-link" onclick="showAdminTab('clients')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Clients
            </div>
            <div class="sidebar-link" onclick="showAdminTab('slots')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Creneaux
            </div>
            <div class="sidebar-link" onclick="showAdminTab('gallery')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Galerie / Medias
            </div>
            <div class="sidebar-link" onclick="showAdminTab('reviews')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Avis
            </div>
            <div class="sidebar-link" onclick="showAdminTab('settings')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Parametres
            </div>
        </nav>

        <div class="mt-auto pt-8 border-t border-[var(--border)] mt-8">
            <a href="index.php" class="sidebar-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Retour au site
            </a>
            <div class="sidebar-link" onclick="logout()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Deconnexion
            </div>
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
                <h1 class="font-display text-3xl" id="page-title">TABLEAU DE BORD</h1>
                <p class="text-[var(--muted)]">Bienvenue, Administrateur</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-[var(--muted)]">Aujourd'hui: <span id="current-date"></span></span>
            </div>
        </div>

        <!-- Overview Tab -->
        <div id="tab-overview">
            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Clients actifs</p>
                    <div class="stat-number" id="stat-clients">0</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Reservations ce mois</p>
                    <div class="stat-number" id="stat-reservations">0</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Revenus du mois</p>
                    <div class="stat-number" id="stat-revenue">0€</div>
                </div>
                <div class="stat-card">
                    <p class="text-[var(--muted)] text-sm mb-2">Photos galerie</p>
                    <div class="stat-number" id="stat-photos">0</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid lg:grid-cols-2 gap-6">
                <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                    <h2 class="font-display text-xl mb-4">DERNIERES RESERVATIONS</h2>
                    <div id="recent-reservations" class="space-y-3">
                        <!-- Filled by JS -->
                    </div>
                </div>

                <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                    <h2 class="font-display text-xl mb-4">DERNIERS CLIENTS</h2>
                    <div id="recent-clients" class="space-y-3">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservations Tab -->
        <div id="tab-reservations" style="display: none;">
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-[var(--border)]">
                    <h2 class="font-display text-xl">TOUTES LES RESERVATIONS</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Offre</th>
                                <th>Seances</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody id="reservations-table">
                            <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Clients Tab -->
        <div id="tab-clients" style="display: none;">
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-[var(--border)] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="font-display text-xl">LISTE DES CLIENTS</h2>
                    <button onclick="exportClients()" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Exporter CSV
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                                <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Rôle</th>
                                <th>Inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="clients-table">
                            <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Slots Tab -->
        <div id="tab-slots" style="display: none;">
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6 mb-6">
                <h2 class="font-display text-xl mb-4">GESTION DES CRENEAUX</h2>
                <p class="text-[var(--muted)]">Ajoutez des créneaux hebdomadaires (jour + heure) ou des créneaux exceptionnels (date + heure). Tous les créneaux sont rattachés à votre compte administrateur.</p>

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <div class="p-4 bg-[rgba(255,255,255,0.01)] rounded-lg">
                        <h3 class="font-medium mb-2">Ajouter - récurrent</h3>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <select id="rec-day" class="form-input">
                                <option value="1">Lundi</option>
                                <option value="2">Mardi</option>
                                <option value="3">Mercredi</option>
                                <option value="4">Jeudi</option>
                                <option value="5">Vendredi</option>
                                <option value="6">Samedi</option>
                                <option value="7">Dimanche</option>
                            </select>
                            <input id="rec-time" type="time" class="form-input" value="18:00">
                        </div>
                        <div class="flex gap-3 items-center">
                            <input id="rec-capacity" type="number" class="form-input" style="width:110px;" min="1" value="10">
                            <button class="btn-primary" onclick="addRecurringSlot()">Ajouter récurrent</button>
                        </div>
                    </div>

                    <div class="p-4 bg-[rgba(255,255,255,0.01)] rounded-lg">
                        <h3 class="font-medium mb-2">Ajouter - exceptionnel</h3>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <input id="single-date" type="date" class="form-input">
                            <input id="single-time" type="time" class="form-input" value="18:00">
                        </div>
                        <div class="flex gap-3 items-center">
                            <input id="single-capacity" type="number" class="form-input" style="width:110px;" min="1" value="10">
                            <button class="btn-primary" onclick="addExceptionalSlot()">Ajouter exceptionnel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg">Créneaux existants</h3>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-[var(--muted)]">Filtrer :</label>
                        <select id="slots-filter" class="form-input" onchange="fetchSlots()">
                            <option value="all">Tous</option>
                            <option value="recurring">Récurrents</option>
                            <option value="single">Exceptionnels</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="data-table w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Jour / Date</th>
                                <th>Heure</th>
                                <th>Capacité</th>
                                <th>Auteur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="slots-tbody">
                            <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Gallery Tab -->
        <div id="tab-gallery" style="display: none;">
            <!-- Upload Zone -->
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6 mb-6">
                <h2 class="font-display text-xl mb-4">AJOUTER DES PHOTOS</h2>
                
                <div class="upload-zone" id="upload-zone" onclick="document.getElementById('file-input').click()">
                    <input type="file" id="file-input" multiple accept="image/jpeg,image/png,image/webp" style="display: none;" onchange="handleFileSelect(event)">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.5" class="mx-auto mb-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <p class="text-[var(--muted)] mb-2">Glissez-deposez vos images ici ou cliquez pour parcourir</p>
                    <p class="text-xs text-[var(--muted)]">Formats acceptes: JPG, PNG, WebP - Taille max: 5MB par image</p>
                </div>

                <!-- File Preview -->
                <div id="file-preview" class="file-preview" style="display: none;"></div>

                <!-- Upload Button -->
                <div id="upload-actions" style="display: none;" class="mt-4 flex gap-4">
                    <button onclick="uploadFiles()" class="btn-primary flex-1 justify-center" id="upload-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Uploader les images
                    </button>
                    <button onclick="clearFiles()" class="btn-secondary">Annuler</button>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-xl">PHOTOS EXISTANTES</h2>
                    <span class="text-sm text-[var(--muted)]" id="photo-count">0 photo(s)</span>
                </div>
                
                <div class="gallery-grid" id="gallery-grid">
                    <!-- Filled by JS -->
                </div>

                <div id="empty-gallery" class="text-center py-16" style="display: none;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1" class="mx-auto mb-4">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <p class="text-[var(--muted)]">Aucune photo dans la galerie</p>
                    <p class="text-sm text-[var(--muted)]">Uploadez vos premieres images ci-dessus</p>
                </div>
            </div>
        </div>

        <!-- Reviews Tab -->
        <div id="tab-reviews" style="display: none;">
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                <h2 class="font-display text-xl mb-4">GESTION DES AVIS</h2>
                <p class="text-[var(--muted)]">Cette section permet de moderer les avis. Fonctionnalite complete disponible avec le backend Spring Boot.</p>

                <div id="reviews-list" class="space-y-4 mt-6">
                    <!-- Filled by JS -->
                </div>
            </div>
        </div>

        <!-- Settings Tab -->
        <div id="tab-settings" style="display: none;">
            <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-6">
                <h2 class="font-display text-xl mb-4">PARAMETRES DU SITE</h2>
                <p class="text-[var(--muted)]">Configuration du site, mode maintenance, etc. Fonctionnalite complete disponible avec le backend Spring Boot.</p>
            </div>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="delete-modal">
        <div class="modal-content">
            <h3 class="font-display text-xl mb-4">CONFIRMER LA SUPPRESSION</h3>
            <p class="text-[var(--muted)] mb-6">Etes-vous sur de vouloir supprimer cette photo ? Cette action est irreversible.</p>
            <div class="flex gap-4">
                <button onclick="closeDeleteModal()" class="btn-secondary flex-1 justify-center">Annuler</button>
                <button onclick="confirmDelete()" class="btn-danger flex-1 justify-center">Supprimer</button>
            </div>
        </div>
    </div>

    <!-- Client Edit Modal -->
    <div class="modal" id="client-edit-modal" style="display:none;">
        <div class="modal-content max-w-xl">
            <h3 class="font-display text-xl mb-4">Éditer le client</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input type="hidden" id="edit-client-id">
                <div>
                    <label class="block text-sm mb-1">Prénom</label>
                    <input id="edit-client-first" class="form-input" type="text" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Nom</label>
                    <input id="edit-client-last" class="form-input" type="text" />
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm mb-1">Email</label>
                    <input id="edit-client-email" class="form-input" type="email" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Téléphone</label>
                    <input id="edit-client-phone" class="form-input" type="tel" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Rôle</label>
                    <select id="edit-client-role" class="form-input"><option value="client">Client</option><option value="admin">Administrateur</option></select>
                </div>
            </div>
            <div class="flex gap-4 mt-6">
                <button class="btn-secondary flex-1" onclick="closeClientEditModal()">Annuler</button>
                <button class="btn-primary flex-1" onclick="saveClientEdits()">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="toast">
        <svg id="toast-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"></svg>
        <p id="toast-message"></p>
    </div>

    <script>
        // ===== CHECK ADMIN AUTH =====
        const currentUser = JSON.parse(localStorage.getItem('mna_user') || 'null');
        if (!currentUser || currentUser.role !== 'admin') {
            window.location.href = 'connexion.php';
        }

        // ===== SET CURRENT DATE =====
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' });

        // ===== DATA =====
        let users = JSON.parse(localStorage.getItem('mna_users') || '[]');
        const reservations = JSON.parse(localStorage.getItem('mna_reservations') || '[]');
        let galleryImages = JSON.parse(localStorage.getItem('mna_gallery') || '[]');

        // Initialize with sample images if empty
        if (galleryImages.length === 0) {
            galleryImages = [
                { id: 1, filename: 'sample-1.jpg', path: 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=400', title: 'Seance collective', createdAt: new Date(Date.now() - 86400000 * 5).toISOString() },
                { id: 2, filename: 'sample-2.jpg', path: 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400', title: 'Coaching personnalise', createdAt: new Date(Date.now() - 86400000 * 3).toISOString() },
                { id: 3, filename: 'sample-3.jpg', path: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400', title: 'Espace fitness', createdAt: new Date(Date.now() - 86400000 * 1).toISOString() },
            ];
            localStorage.setItem('mna_gallery', JSON.stringify(galleryImages));
        }

        // Update stats
        document.getElementById('stat-clients').textContent = users.length;
        document.getElementById('stat-reservations').textContent = reservations.length;
        document.getElementById('stat-photos').textContent = galleryImages.length;
        
        let totalRevenue = 0;
        reservations.forEach(r => totalRevenue += r.price);
        document.getElementById('stat-revenue').textContent = totalRevenue + '€';

        // ===== SIDEBAR TOGGLE =====
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        // ===== RENDER DATA =====
        function renderRecentReservations() {
            const container = document.getElementById('recent-reservations');
            const recent = reservations.slice(-5).reverse();
            
            if (recent.length === 0) {
                container.innerHTML = '<p class="text-[var(--muted)]">Aucune reservation</p>';
                return;
            }

            container.innerHTML = recent.map(r => `
                <div class="flex items-center justify-between p-3 bg-[rgba(255,255,255,0.02)] rounded-lg">
                    <div>
                        <p class="font-mono text-sm">${r.id}</p>
                        <p class="text-xs text-[var(--muted)]">${r.offer === 'abonnement' ? 'Abonnement 4 seances' : r.offer === 'decouverte' ? 'Seance Decouverte' : 'Seance Unitaire'}</p>
                    </div>
                    <span class="badge badge-success">${r.price}€</span>
                </div>
            `).join('');
        }

        function renderRecentClients() {
            const container = document.getElementById('recent-clients');
            const recent = users.slice(-5).reverse();
            
            if (recent.length === 0) {
                container.innerHTML = '<p class="text-[var(--muted)]">Aucun client</p>';
                return;
            }

            container.innerHTML = recent.map(u => `
                <div class="flex items-center gap-3 p-3 bg-[rgba(255,255,255,0.02)] rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center font-semibold text-sm">
                        ${u.firstName.charAt(0)}${u.lastName.charAt(0)}
                    </div>
                    <div>
                        <p class="font-medium">${u.firstName} ${u.lastName}</p>
                        <p class="text-xs text-[var(--muted)]">${u.email}</p>
                    </div>
                </div>
            `).join('');
        }

        function renderReservationsTable() {
            const tbody = document.getElementById('reservations-table');
            
            if (reservations.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-[var(--muted)]">Aucune reservation</td></tr>';
                return;
            }

            tbody.innerHTML = reservations.map(r => `
                <tr>
                    <td class="font-mono text-sm">${r.id}</td>
                    <td class="capitalize">${r.offer === 'abonnement' ? 'Abonnement' : r.offer}</td>
                    <td>
                        ${r.sessions ? r.sessions.length : 1} seance(s)
                        ${r.locked ? '<span class="badge badge-warning ml-2">Verrouille</span>' : ''}
                    </td>
                    <td class="font-semibold">${r.price}€</td>
                    <td><span class="badge badge-success">Confirmee</span></td>
                </tr>
            `).join('');
        }

        async function renderClientsTable() {
            const tbody = document.getElementById('clients-table');

            // Prefer server-side users when admin session exists, otherwise localStorage fallback
            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('users_list.php');
                    if (res.ok) {
                        const j = await res.json();
                        if (Array.isArray(j)) {
                            users = j.map(u => ({
                                id: u.id,
                                firstName: u.first_name || u.firstName || '',
                                lastName: u.last_name || u.lastName || '',
                                email: u.email,
                                phone: u.phone || '',
                                role: u.role || 'client',
                                createdAt: u.created_at || u.createdAt || new Date().toISOString()
                            }));
                        }
                    }
                } catch (err) {
                    console.warn('users_list.php failed, using local snapshot', err);
                }
            } else {
                users = JSON.parse(localStorage.getItem('mna_users') || '[]');
            }

            document.getElementById('stat-clients').textContent = (users || []).length;

            if (!users || users.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-[var(--muted)]">Aucun client</td></tr>';
                return;
            }

            tbody.innerHTML = users.map(u => `
                <tr>
                    <td class="font-mono text-sm">${u.id || ''}</td>
                    <td>${(u.firstName || '') + ' ' + (u.lastName || '')}</td>
                    <td><a href="mailto:${u.email}">${u.email}</a></td>
                    <td>${u.phone || '-'}</td>
                    <td class="capitalize">${u.role || 'client'}</td>
                    <td>${new Date(u.createdAt || u.created_at || Date.now()).toLocaleDateString('fr-FR')}</td>
                    <td>
                        <button class="btn-secondary" onclick="openClientEditModal('${u.id}')">Editer</button>
                        <button class="btn-danger" onclick="deleteClient('${u.id}')">Supprimer</button>
                    </td>
                </tr>
            `).join('');
        }

        // ===== REVIEWS (ADMIN) =====
        let adminReviews = JSON.parse(localStorage.getItem('mna_reviews') || 'null');
        if (!adminReviews) {
            adminReviews = [];
        }

        async function loadAdminReviewsFromServer() {
            const localSnapshot = JSON.parse(localStorage.getItem('mna_reviews') || '[]') || [];

            // Try server first (admin sees all reviews)
            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('reviews_list.php');
                    if (res.ok) {
                        const json = await res.json();
                        const serverReviews = Array.isArray(json) ? json.map(r => ({
                            id: r.id,
                            name: r.name || 'Membre',
                            initials: (r.name || 'M').split(' ').map(s=>s.charAt(0)).slice(0,2).join(''),
                            rating: parseInt(r.rating) || 5,
                            date: r.created_at ? new Date(r.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : '',
                            comment: r.comment || '',
                            gradient: 'from-[var(--accent)] to-[var(--accent-secondary)]',
                            approved: !!r.approved
                        })) : [];

                        const keyOf = v => ((v.comment||'').trim().toLowerCase() + '|' + (v.rating||'') + '|' + (v.name||'').trim().toLowerCase());
                        const serverKeys = new Set(serverReviews.map(keyOf));

                        // Merge local pending reviews for immediate admin visibility
                        const pendingLocal = (localSnapshot || []).filter(l => String(l.id).startsWith('local-') || l._local);
                        const merged = serverReviews.slice();
                        pendingLocal.forEach(l => {
                            const k = keyOf(l);
                            if (!serverKeys.has(k)) merged.unshift(l);
                        });

                        adminReviews = merged;
                        localStorage.setItem('mna_reviews', JSON.stringify(adminReviews));
                        renderAdminReviews();

                        // Best-effort: push pending local reviews to server (admin-add will auto-approve)
                        for (const l of pendingLocal) {
                            const k = keyOf(l);
                            if (serverKeys.has(k)) continue;
                            try {
                                const addRes = await fetch('reviews_add.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ name: l.name, rating: l.rating, comment: l.comment }) });
                                if (addRes.ok) {
                                    const saved = await addRes.json();
                                    // replace local id with server id in adminReviews
                                    adminReviews = adminReviews.map(a => a.id === l.id ? ({ ...a, id: saved.id, approved: !!saved.approved, date: saved.created_at ? new Date(saved.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : a.date }) : a);
                                    serverKeys.add(k);
                                    localStorage.setItem('mna_reviews', JSON.stringify(adminReviews));
                                }
                            } catch (err) { console.warn('push local review failed', err); }
                        }

                        // Refresh authoritative server list after pushing
                        try {
                            const res2 = await fetch('reviews_list.php');
                            if (res2.ok) {
                                const j2 = await res2.json();
                                if (Array.isArray(j2)) {
                                    adminReviews = j2.map(r => ({
                                        id: r.id,
                                        name: r.name || 'Membre',
                                        initials: (r.name || 'M').split(' ').map(s=>s.charAt(0)).slice(0,2).join(''),
                                        rating: parseInt(r.rating) || 5,
                                        date: r.created_at ? new Date(r.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }) : '',
                                        comment: r.comment || '',
                                        gradient: 'from-[var(--accent)] to-[var(--accent-secondary)]',
                                        approved: !!r.approved
                                    }));
                                    localStorage.setItem('mna_reviews', JSON.stringify(adminReviews));
                                    renderAdminReviews();
                                }
                            }
                        } catch (err) { /* ignore */ }

                        return;
                    }
                } catch (err) {
                    console.warn('reviews_list.php failed — using local snapshot', err);
                }
            }

            // fallback to localStorage snapshot
            adminReviews = localSnapshot;
            renderAdminReviews();
        }

        function renderAdminReviews() {
            const container = document.getElementById('reviews-list');
            if (!adminReviews || adminReviews.length === 0) {
                container.innerHTML = '<p class="text-[var(--muted)]">Aucun avis</p>';
                return;
            }

            container.innerHTML = adminReviews.map(r => `
                <div class="p-4 border border-[var(--border)] rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold">${r.name}</span>
                            <div class="flex">
                                ${Array(5).fill(0).map((_, i) => `<svg width="14" height="14" viewBox="0 0 24 24" fill="${i < r.rating ? '#ff6b9d' : 'none'}" stroke="#ff6b9d" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`).join('')}
                            </div>
                        </div>
                        <p class="text-[var(--muted)]">"${r.comment}"</p>
                        <p class="text-xs text-[var(--muted)] mt-2">${r.date || ''}</p>
                    </div>
                    <div class="flex gap-2 items-center">
                        ${r.approved ? `<span class="badge badge-success">Valide</span>` : `<button class="btn-success" onclick="approveAdminReview(${r.id})">Valider</button>`}
                        <button class="btn-danger" onclick="deleteAdminReview(${r.id})">Supprimer</button>
                    </div>
                </div>
            `).join('');
        }

        async function approveAdminReview(id) {
            const rev = adminReviews.find(r => r.id == id);
            if (!rev) return showToast('Avis introuvable', 'error');

            // Try server update first
            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('reviews_update.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id: id, approved: 1 }) });
                    if (!res.ok) throw new Error('server');
                } catch (err) {
                    console.warn('reviews_update.php failed — local fallback used', err);
                }
            }

            rev.approved = true;
            localStorage.setItem('mna_reviews', JSON.stringify(adminReviews));
            renderAdminReviews();
            showToast('Avis valide', 'success');
        }

        async function deleteAdminReview(id) {
            if (!confirm('Supprimer cet avis ?')) return;

            // Try server delete first
            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('reviews_delete.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) });
                    if (!res.ok) throw new Error('server');
                } catch (err) {
                    console.warn('reviews_delete.php failed — local fallback used', err);
                }
            }

            adminReviews = adminReviews.filter(r => r.id != id);
            localStorage.setItem('mna_reviews', JSON.stringify(adminReviews));
            renderAdminReviews();
            showToast('Avis supprime', 'success');
        }

        // ===== CLIENT EDIT MODAL API =====
        let editingClientId = null;

        function openClientEditModal(id) {
            const u = users.find(x => x.id == id);
            if (!u) return showToast('Client non trouve', 'error');
            editingClientId = id;
            document.getElementById('edit-client-id').value = id;
            document.getElementById('edit-client-first').value = u.firstName || '';
            document.getElementById('edit-client-last').value = u.lastName || '';
            document.getElementById('edit-client-email').value = u.email || '';
            document.getElementById('edit-client-phone').value = u.phone || '';
            document.getElementById('edit-client-role').value = (u.role || 'client');
            document.getElementById('client-edit-modal').style.display = 'flex';
        }

        function closeClientEditModal() {
            editingClientId = null;
            document.getElementById('client-edit-modal').style.display = 'none';
        }

        async function saveClientEdits() {
            const id = document.getElementById('edit-client-id').value;
            const first = document.getElementById('edit-client-first').value.trim();
            const last = document.getElementById('edit-client-last').value.trim();
            const email = document.getElementById('edit-client-email').value.trim();
            const phone = document.getElementById('edit-client-phone').value.trim();
            const role = document.getElementById('edit-client-role').value || 'client';

            if (!first || !email) return showToast('Prénom et email requis', 'error');
            const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRe.test(email)) return showToast('Email invalide', 'error');

            // Try server update when available
            if (window.__MNA_SERVER_USER) {
                try {
                    const payload = { id, first_name: first, last_name: last, email, phone, role };
                    const res = await fetch('users_update.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
                    const j = await res.json();
                    if (j && j.updated) {
                        // merge returned user if present
                        if (j.user) {
                            users = users.map(u => u.id == id ? { id: j.user.id, firstName: j.user.first_name || j.user.firstName, lastName: j.user.last_name || j.user.lastName, email: j.user.email, phone: j.user.phone, role: j.user.role, createdAt: j.user.created_at || u.createdAt } : u);
                        } else {
                            users = users.map(u => u.id == id ? { ...u, firstName: first, lastName: last, email, phone, role } : u);
                        }
                        localStorage.setItem('mna_users', JSON.stringify(users));
                        renderClientsTable();
                        closeClientEditModal();
                        return showToast('Client mis à jour (serveur)', 'success');
                    }
                    return showToast(j && j.message ? j.message : 'Mise à jour refusée', 'error');
                } catch (err) {
                    console.warn('users_update.php failed', err);
                    showToast('Erreur serveur — mise à jour locale', 'warning');
                }
            }

            // Local fallback
            users = users.map(u => u.id == id ? { ...u, firstName: first, lastName: last, email, phone, role } : u);
            localStorage.setItem('mna_users', JSON.stringify(users));
            renderClientsTable();
            closeClientEditModal();
            showToast('Client mis à jour (local)', 'success');
        }

        // Delete client (tries server then falls back to local)
        async function deleteClient(id) {
            if (!confirm('Supprimer ce client ?')) return;

            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('users_delete.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) });
                    const j = await res.json();
                    if (j && j.deleted) {
                        users = users.filter(u => u.id != id);
                        localStorage.setItem('mna_users', JSON.stringify(users));
                        renderClientsTable();
                        showToast('Client supprime (serveur)', 'success');
                        return;
                    }
                    showToast('Suppression serveur échouée', 'error');
                } catch (err) {
                    console.warn('users_delete.php failed', err);
                }
            }

            // local fallback
            users = users.filter(u => u.id != id);
            localStorage.setItem('mna_users', JSON.stringify(users));
            renderClientsTable();
            showToast('Client supprime (local)', 'success');
        }

        // ===== GALLERY FUNCTIONS =====
        let selectedFiles = [];
        let deleteTargetId = null;

        function renderGallery() {
            const grid = document.getElementById('gallery-grid');
            const emptyState = document.getElementById('empty-gallery');
            const photoCount = document.getElementById('photo-count');
            
            // Sort by most recent
            const sortedImages = [...galleryImages].sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
            
            photoCount.textContent = sortedImages.length + ' photo(s)';
            
            if (sortedImages.length === 0) {
                grid.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }
            
            grid.style.display = 'grid';
            emptyState.style.display = 'none';
            
            grid.innerHTML = sortedImages.map(img => `
                <div class="gallery-item fade-in">
                    <img src="${img.path}" alt="${img.title || img.filename}" loading="lazy">
                    <div class="gallery-overlay">
                        <button onclick="openDeleteModal(${img.id})" class="btn-danger">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Supprimer
                        </button>
                    </div>
                    <div class="gallery-info">
                        <p class="text-xs font-medium truncate">${img.title || img.filename}</p>
                        <p class="text-xs text-[var(--muted)]">${new Date(img.createdAt).toLocaleDateString('fr-FR')}</p>
                    </div>
                </div>
            `).join('');
            
            // Update stat
            document.getElementById('stat-photos').textContent = sortedImages.length;
        }

        // Drag and drop
        const uploadZone = document.getElementById('upload-zone');

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            handleFileSelect({ target: { files: e.dataTransfer.files } });
        });

        function handleFileSelect(event) {
            const files = Array.from(event.target.files);
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            let validFiles = [];
            let errors = [];
            
            files.forEach(file => {
                if (!validTypes.includes(file.type)) {
                    errors.push(`${file.name}: Format non supporte`);
                } else if (file.size > maxSize) {
                    errors.push(`${file.name}: Fichier trop volumineux (max 5MB)`);
                } else {
                    validFiles.push(file);
                }
            });
            
            if (errors.length > 0) {
                showToast(errors.join('\n'), 'error');
            }
            
            if (validFiles.length > 0) {
                selectedFiles = validFiles;
                showFilePreview();
            }
        }

        function showFilePreview() {
            const preview = document.getElementById('file-preview');
            const actions = document.getElementById('upload-actions');
            
            preview.innerHTML = selectedFiles.map((file, index) => {
                const url = URL.createObjectURL(file);
                return `
                    <div class="file-preview-item fade-in">
                        <img src="${url}" alt="${file.name}">
                        <div class="file-preview-remove" onclick="removeFile(${index})">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </div>
                    </div>
                `;
            }).join('');
            
            preview.style.display = 'flex';
            actions.style.display = 'flex';
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            if (selectedFiles.length === 0) {
                clearFiles();
            } else {
                showFilePreview();
            }
        }

        function clearFiles() {
            selectedFiles = [];
            document.getElementById('file-preview').style.display = 'none';
            document.getElementById('upload-actions').style.display = 'none';
            document.getElementById('file-input').value = '';
        }

        async function uploadFiles() {
            const btn = document.getElementById('upload-btn');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                </svg>
                Upload en cours...
            `;

            const useServer = window.__MNA_SERVER_USER && window.__MNA_SERVER_ROLE === 'admin';
            if (useServer) {
                try {
                    const fd = new FormData();
                    selectedFiles.forEach(f => fd.append('files[]', f));
                    const res = await fetch('media_upload.php', { method: 'POST', body: fd });
                    const json = await res.json();
                    if (json && json.uploaded && json.uploaded.length) {
                        json.uploaded.forEach(u => {
                            galleryImages.push({
                                id: u.id || (Date.now()+Math.random()),
                                filename: u.filename || '',
                                originalName: u.originalName || '',
                                path: u.path || ('uploads/gallery/' + (u.filename||'')),
                                title: u.originalName || '',
                                createdAt: new Date().toISOString()
                            });
                        });
                        localStorage.setItem('mna_gallery', JSON.stringify(galleryImages));
                        clearFiles(); renderGallery();
                        showToast(`${json.uploaded.length} image(s) uploadee(s) (serveur)`, 'success');
                        btn.disabled = false; btn.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Uploader les images
                        `;
                        return;
                    }
                } catch (err) {
                    console.warn('Server upload failed, falling back to local', err);
                }
            }

            // Fallback local behaviour
            setTimeout(() => {
                selectedFiles.forEach(file => {
                    // Generate unique filename
                    const timestamp = Date.now();
                    const randomStr = Math.random().toString(36).substring(2, 8);
                    const ext = file.name.split('.').pop().toLowerCase();
                    const filename = `${timestamp}_${randomStr}.${ext}`;
                    
                    // Create local URL for demo
                    const url = URL.createObjectURL(file);
                    
                    const newImage = {
                        id: Date.now() + Math.random(),
                        filename: filename,
                        originalName: file.name,
                        path: url,
                        title: file.name.replace(/\.[^/.]+$/, ''),
                        createdAt: new Date().toISOString()
                    };
                    
                    galleryImages.push(newImage);
                });
                
                // Save to localStorage
                localStorage.setItem('mna_gallery', JSON.stringify(galleryImages));
                
                // Update UI
                clearFiles();
                renderGallery();
                
                showToast(`${selectedFiles.length} image(s) uploadee(s) avec succes`, 'success');
                
                btn.disabled = false;
                btn.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Uploader les images
                `;
            }, 1500);
        }

        function openDeleteModal(id) {
            deleteTargetId = id;
            document.getElementById('delete-modal').classList.add('open');
        }

        function closeDeleteModal() {
            deleteTargetId = null;
            document.getElementById('delete-modal').classList.remove('open');
        }

        function confirmDelete() {
            if (!deleteTargetId) return;
            
            galleryImages = galleryImages.filter(img => img.id !== deleteTargetId);
            localStorage.setItem('mna_gallery', JSON.stringify(galleryImages));
            
            renderGallery();
            closeDeleteModal();
            showToast('Photo supprimee avec succes', 'success');
        }

        // ===== CLIENT FUNCTIONS =====
        function blockClient(id) {
            showToast('Client bloque (demo)', 'success');
        }

        function exportClients() {
            let csv = 'Nom,Email,Telephone,Date inscription\n';
            users.forEach(u => {
                csv += `"${u.firstName} ${u.lastName}","${u.email}","${u.phone || ''}","${new Date(u.createdAt).toLocaleDateString('fr-FR')}"\n`;
            });
            
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'clients-mnaclub-' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
            URL.revokeObjectURL(url);
            
            showToast('Export CSV reussi', 'success');
        }

        // ===== SLOTS (localStorage + server fallback) =====
        const _dayNames = [null, 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

        async function fetchSlots() {
            // Try server first when available
            const useServer = !!(window.__MNA_SERVER_USER);
            let slots = [];

            if (useServer) {
                try {
                    const res = await fetch('slots_list.php');
                    if (res.ok) {
                        const j = await res.json();
                        if (Array.isArray(j)) slots = j.map(s => ({ ...s }));
                    }
                } catch (err) {
                    console.warn('slots_list.php unreachable, falling back to localStorage', err);
                }
            }

            // localStorage fallback / default data
            const local = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            if (slots.length === 0 && local.length > 0) slots = local;
            if (slots.length === 0) {
                // sensible defaults for admin view
                slots = [
                    { id: 1, kind: 'recurring', day: 1, dayName: 'Lundi', time: '18:00', capacity: 10, author: 'system' },
                    { id: 2, kind: 'recurring', day: 3, dayName: 'Mercredi', time: '10:00', capacity: 10, author: 'system' },
                    { id: 3, kind: 'recurring', day: 5, dayName: 'Vendredi', time: '18:00', capacity: 10, author: 'system' }
                ];
            }

            // Apply filter
            const filter = document.getElementById('slots-filter') ? document.getElementById('slots-filter').value : 'all';
            let list = slots.slice();
            if (filter === 'recurring') list = list.filter(s => s.kind === 'recurring');
            if (filter === 'single') list = list.filter(s => s.kind === 'single');

            const tbody = document.getElementById('slots-tbody');
            if (!tbody) return;

            if (list.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-[var(--muted)]">Aucun creneau</td></tr>`;
                return;
            }

            tbody.innerHTML = list.map(s => {
                const typeLabel = s.kind === 'recurring' ? 'Recurrent' : 'Exceptionnel';
                const dayOrDate = s.kind === 'recurring' ? (s.dayName || _dayNames[s.day] || s.day) : (s.date || s.day || '—');
                const time = s.time || (s.start ? `${s.start}${s.end ? ' - ' + s.end : ''}` : '—');
                const capacity = s.capacity || s.max || s.places || '—';
                const author = s.author || (window.__MNA_SERVER_USER ? 'server' : (JSON.parse(localStorage.getItem('mna_user')||'null') || {}).email || 'admin');

                return `
                    <tr>
                        <td class="font-mono text-sm">${s.id}</td>
                        <td>${typeLabel}</td>
                        <td>${dayOrDate}</td>
                        <td>${time}</td>
                        <td>${capacity}</td>
                        <td>${author}</td>
                        <td>
                            <button class="btn-secondary" onclick="openSlotEditModal(${s.id})">Modifier</button>
                            <button class="btn-danger" onclick="deleteSlot(${s.id})">Supprimer</button>
                        </td>
                    </tr>
                `;
            }).join('');

            // Persist local copy for later (if source was server we still keep a snapshot)
            localStorage.setItem('mna_slots', JSON.stringify(slots));
        }

        async function addRecurringSlot() {
            const day = parseInt(document.getElementById('rec-day').value, 10);
            const time = document.getElementById('rec-time').value;
            const capacity = parseInt(document.getElementById('rec-capacity').value, 10) || 10;
            if (!day || !time) return showToast('Selectionnez un jour et une heure', 'error');

            const newSlot = { id: Date.now(), kind: 'recurring', day, dayName: _dayNames[day], time, capacity, author: (JSON.parse(localStorage.getItem('mna_user')||'null')||{}).email || 'admin', createdAt: new Date().toISOString() };

            // Try server persist when possible
            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('slots_add.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(newSlot) });
                    const j = await res.json();
                    if (j && j.id) newSlot.id = j.id;
                } catch (err) { console.warn('slots_add.php failed — using local fallback', err); }
            }

            const slots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            slots.push(newSlot);
            localStorage.setItem('mna_slots', JSON.stringify(slots));
            fetchSlots();
            showToast('Creneau recurrent ajoute', 'success');
        }

        async function addExceptionalSlot() {
            const date = document.getElementById('single-date').value;
            const time = document.getElementById('single-time').value;
            const capacity = parseInt(document.getElementById('single-capacity').value, 10) || 10;
            if (!date || !time) return showToast('Saisissez une date et une heure', 'error');

            const newSlot = { id: Date.now(), kind: 'single', date, time, capacity, author: (JSON.parse(localStorage.getItem('mna_user')||'null')||{}).email || 'admin', createdAt: new Date().toISOString() };

            if (window.__MNA_SERVER_USER) {
                try {
                    const res = await fetch('slots_add.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(newSlot) });
                    const j = await res.json();
                    if (j && j.id) newSlot.id = j.id;
                } catch (err) { console.warn('slots_add.php failed — using local fallback', err); }
            }

            const slots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            slots.push(newSlot);
            localStorage.setItem('mna_slots', JSON.stringify(slots));
            fetchSlots();
            showToast('Creneau exceptionnel ajoute', 'success');
        }

        function openSlotEditModal(id) {
            const slots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            const s = slots.find(x => x.id == id);
            if (!s) return showToast('Creneau non trouve', 'error');

            const newTime = prompt('Modifier l\'horaire (HH:MM) :', s.time || s.start || '');
            if (newTime === null) return; // cancelled
            s.time = newTime;
            localStorage.setItem('mna_slots', JSON.stringify(slots));
            fetchSlots();
            showToast('Creneau mis a jour', 'success');
        }

        async function deleteSlot(id) {
            if (!confirm('Supprimer ce creneau ?')) return;
            // Try server delete
            if (window.__MNA_SERVER_USER) {
                try {
                    await fetch('slots_delete.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) });
                } catch (err) { console.warn('slots_delete.php failed — local fallback used', err); }
            }

            let slots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            slots = slots.filter(s => s.id != id);
            localStorage.setItem('mna_slots', JSON.stringify(slots));
            fetchSlots();
            showToast('Creneau supprime', 'success');
        }

        // ===== TABS =====
        function showAdminTab(tab) {
            // Hide all tabs
            document.querySelectorAll('[id^="tab-"]').forEach(t => t.style.display = 'none');
            
            // Show selected tab
            document.getElementById('tab-' + tab).style.display = 'block';
            
            // Update sidebar
            document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');

            // Update page title
            const titles = {
                overview: 'TABLEAU DE BORD',
                reservations: 'RESERVATIONS',
                clients: 'CLIENTS',
                slots: 'CRENEAUX',
                gallery: 'GALERIE / MEDIAS',
                reviews: 'AVIS',
                settings: 'PARAMETRES'
            };
            document.getElementById('page-title').textContent = titles[tab] || 'ADMINISTRATION';

            // Render content
            if (tab === 'reservations') renderReservationsTable();
            if (tab === 'clients') renderClientsTable();
            if (tab === 'gallery') renderGallery();
            if (tab === 'slots') fetchSlots();
            if (tab === 'reviews') { loadAdminReviewsFromServer(); }
        }

        // ===== LOGOUT =====
        function logout() {
            localStorage.removeItem('mna_user');
            window.location.href = 'connexion.php';
        }

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            
            toast.className = 'toast ' + type;
            toastMessage.textContent = message;
            
            if (type === 'success') {
                toastIcon.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            } else {
                toastIcon.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
            }
            
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        // ===== INIT =====
        renderRecentReservations();
        renderRecentClients();
        // sync pending local reviews when connection is restored
        window.addEventListener('online', loadAdminReviewsFromServer);
        
        // Close modal on backdrop click
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>