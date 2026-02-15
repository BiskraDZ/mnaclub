<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medias - MNA Club</title>
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

        .media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
        .media-item { position: relative; border-radius: 16px; overflow: hidden; aspect-ratio: 1; cursor: pointer; transition: transform 0.3s ease; }
        .media-item:hover { transform: scale(1.02); }
        .media-item img { width: 100%; height: 100%; object-fit: cover; }
        .media-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: flex-end; padding: 20px; }
        .media-item:hover .media-overlay { opacity: 1; }

        .filter-btn { padding: 10px 24px; border-radius: 25px; background: transparent; border: 1px solid var(--border); color: var(--muted); cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
        .filter-btn:hover { border-color: var(--accent); color: var(--fg); }
        .filter-btn.active { background: var(--accent); border-color: var(--accent); color: white; }

        .lightbox { position: fixed; inset: 0; background: rgba(0,0,0,0.95); z-index: 200; display: none; justify-content: center; align-items: center; padding: 20px; }
        .lightbox.open { display: flex; }
        .lightbox-content { max-width: 90vw; max-height: 90vh; position: relative; }
        .lightbox-img { max-width: 100%; max-height: 90vh; border-radius: 16px; }
        .lightbox-close { position: absolute; top: -50px; right: 0; background: none; border: none; color: white; cursor: pointer; padding: 10px; }
        .lightbox-nav { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.1); border: none; color: white; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.3s ease; }
        .lightbox-nav:hover { background: rgba(255,255,255,0.2); }
        .lightbox-prev { left: -70px; }
        .lightbox-next { right: -70px; }

        .video-badge { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; background: rgba(255,107,157,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; }

        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 300; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
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
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 reveal">
                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl mb-4">GALERIE MEDIAS</h1>
                <p class="text-[var(--muted)] max-w-2xl mx-auto">Decouvre les moments forts du MNA Club en images et videos</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap justify-center gap-3 mb-6 reveal">
                <button class="filter-btn active" onclick="filterMedia('all')">Tous</button>
                <button class="filter-btn" onclick="filterMedia('training')">Entrainements</button>
                <button class="filter-btn" onclick="filterMedia('events')">Evenements</button>
                <button class="filter-btn" onclick="filterMedia('facility')">Espace</button>
                <button class="filter-btn" onclick="filterMedia('results')">Resultats</button>
            </div>

            <!-- Admin controls (visible only to admins) -->
            <div id="admin-controls" class="flex justify-end mb-6" style="display:none;">
                <button class="btn-secondary mr-3" onclick="openUploadModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Ajouter un media
                </button>
                <a href="dashboard-admin.php#gallery" class="btn-primary">Ouvrir la gestion</a>
            </div>

            <!-- Media Grid -->
            <div class="media-grid reveal" id="media-grid">
                <!-- Filled by JS -->
            </div>

            <!-- Upload modal (admin) -->
            <div id="upload-modal" class="lightbox" style="display:none; z-index:400;">
                <div class="lightbox-content" style="background:var(--bg-secondary); padding:20px; border-radius:12px; max-width:600px; width:100%;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3 style="font-weight:700;">Ajouter des medias</h3>
                        <button onclick="closeUploadModal()" aria-label="Fermer">&times;</button>
                    </div>
                    <div style="display:flex; gap:12px; margin-bottom:12px; flex-wrap:wrap;">
                        <input id="admin-file-input" type="file" accept="image/*,video/*" multiple style="flex:1;" />
                        <input id="admin-media-title" type="text" placeholder="Titre (optionnel)" style="flex:1; padding:10px; border-radius:8px; background:transparent; border:1px solid var(--border); color:var(--fg);" />
                        <select id="admin-media-type" style="padding:10px; border-radius:8px; background:transparent; border:1px solid var(--border); color:var(--fg);">
                            <option value="training">Entrainements</option>
                            <option value="events">Evenements</option>
                            <option value="facility">Espace</option>
                            <option value="results">Resultats</option>
                        </select>
                    </div>
                    <div id="admin-upload-preview" style="display:none; gap:8px; flex-wrap:wrap; margin-bottom:12px;"></div>
                    <div style="text-align:right;">
                        <button class="btn-secondary" onclick="closeUploadModal()">Annuler</button>
                        <button id="admin-upload-btn" class="btn-primary" style="margin-left:8px;" onclick="uploadAdminFiles()">Uploader</button>
                    </div>
                </div>
            </div>

            <!-- Delete confirmation modal (admin) -->
            <div id="admin-delete-modal" class="lightbox" style="display:none; z-index:401;">
                <div class="lightbox-content" style="background:var(--bg-secondary); padding:20px; border-radius:12px; max-width:420px; width:100%; text-align:center;">
                    <h3 style="margin-bottom:12px;">Confirmer la suppression</h3>
                    <p class="text-[var(--muted)]" style="margin-bottom:16px;">Voulez-vous vraiment supprimer cet élément ?</p>
                    <div style="display:flex; justify-content:center; gap:8px;">
                        <button class="btn-secondary" onclick="closeDeleteModal()">Annuler</button>
                        <button class="btn-primary" id="confirm-delete-btn" onclick="confirmAdminDelete()">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()" aria-label="Fermer">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)" aria-label="Precedent">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-img" id="lightbox-img">
        </div>
        <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)" aria-label="Suivant">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>

    <!-- Footer -->
    <footer class="py-12 bg-[var(--bg-secondary)] border-t border-[var(--border)]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
                    </div>
                    <span class="font-display text-xl">MNA CLUB</span>
                </div>
                <p class="text-[var(--muted)] text-sm">2025 MNA Club - 63 BD Stalingrad, Vitry-sur-Seine, 94400</p>
            </div>
        </div>
    </footer>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== DATA (load persisted gallery when available) =====
        const defaultMedia = [
            { id: 1, type: 'training', src: 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600', title: 'Seance collective', isVideo: false },
            { id: 2, type: 'training', src: 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600', title: 'Coaching personnalise', isVideo: false },
            { id: 3, type: 'events', src: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600', title: 'Evenement special', isVideo: false },
            { id: 4, type: 'facility', src: 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=600', title: 'Notre espace', isVideo: false },
            { id: 5, type: 'results', src: 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=600', title: 'Resultats membres', isVideo: false },
            { id: 6, type: 'training', src: 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=600', title: 'Entrainement intense', isVideo: false },
            { id: 7, type: 'training', src: 'https://images.unsplash.com/photo-1517963879433-6ad2b056d712?w=600', title: 'Yoga et stretching', isVideo: true },
            { id: 8, type: 'events', src: 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=600', title: 'Challenge mensuel', isVideo: false },
            { id: 9, type: 'facility', src: 'https://images.unsplash.com/photo-1593079831268-3381b0db4a77?w=600', title: 'Vestiaires', isVideo: false },
            { id: 10, type: 'results', src: 'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=600', title: 'Transformation', isVideo: false },
            { id: 11, type: 'training', src: 'https://images.unsplash.com/photo-1549576490-b0b4831ef60a?w=600', title: 'Cardio training', isVideo: false },
            { id: 12, type: 'events', src: 'https://images.unsplash.com/photo-1534258936925-c58bed479fcb?w=600', title: 'Workshop nutrition', isVideo: true },
        ];

        // Load gallery from localStorage (admin edits saved here) — fallback to defaultMedia
        function loadGallery() {
            try {
                const stored = localStorage.getItem('mna_gallery');
                if (stored) {
                    const parsed = JSON.parse(stored);
                    // Normalize stored items to unified format {id,type,src,title,isVideo}
                    return parsed.map(p => ({
                        id: p.id || Date.now() + Math.random(),
                        type: p.type || p.category || 'training',
                        src: p.path || p.src || p.url || p.filename || '',
                        title: p.title || p.originalName || p.filename || 'Media',
                        isVideo: !!(p.isVideo || (p.path && p.path.match(/\.(mp4|webm|ogg)$/i)) || (p.filename && p.filename.match(/\.(mp4|webm|ogg)$/i)))
                    })).filter(x => x.src);
                }
            } catch (err) {
                console.warn('Could not parse saved gallery', err);
            }
            return defaultMedia.slice();
        }

        let gallery = loadGallery();
        let currentFilter = 'all';
        let currentLightboxIndex = 0;
        let filteredMedia = [];
        let adminDeleteTarget = null;
        let adminSelectedFiles = [];

        function isAdminUser() {
            const storedUser = (() => { try { return JSON.parse(localStorage.getItem('mna_user')||'null'); } catch(e) { return null; } })();
            const serverRole = window.__MNA_SERVER_ROLE || null;
            return (window.__MNA_SERVER_USER && serverRole === 'admin') || (storedUser && storedUser.role === 'admin');
        }

        // ===== RENDER MEDIA =====
        function renderMedia() {
            const grid = document.getElementById('media-grid');
            filteredMedia = currentFilter === 'all' ? gallery : gallery.filter(m => m.type === currentFilter);

            grid.innerHTML = filteredMedia.map((item, index) => `
                <div class="media-item" onclick="openLightbox(${index})">
                    <img src="${item.src}" alt="${item.title}" loading="lazy">
                    ${item.isVideo ? `
                        <div class="video-badge" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                    ` : ''}
                    <div class="media-overlay">
                        <div>
                            <p class="font-medium">${item.title}</p>
                            <p class="text-sm text-[var(--muted)] capitalize">${item.type}</p>
                        </div>
                        ${isAdminUser() ? `
                            <div style="margin-left:12px; display:flex; gap:8px; align-items:center;">
                                <button class="btn-secondary" onclick="event.stopPropagation(); openEditMedia(${item.id})">Editer</button>
                                <button class="btn-primary" onclick="event.stopPropagation(); openDeleteModal(${item.id})">Supprimer</button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `).join('');

            // Show/hide admin controls area
            document.getElementById('admin-controls').style.display = isAdminUser() ? 'flex' : 'none';
        }

        // ===== FILTER =====
        function filterMedia(filter) {
            currentFilter = filter;
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            renderMedia();
        }

        // ===== LIGHTBOX =====
        function openLightbox(index) {
            currentLightboxIndex = index;
            const item = filteredMedia[index];
            document.getElementById('lightbox-img').src = item.src;
            document.getElementById('lightbox').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('open');
            document.body.style.overflow = '';
        }

        function navigateLightbox(direction) {
            currentLightboxIndex = (currentLightboxIndex + direction + filteredMedia.length) % filteredMedia.length;
            const item = filteredMedia[currentLightboxIndex];
            document.getElementById('lightbox-img').src = item.src;
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!document.getElementById('lightbox').classList.contains('open')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') navigateLightbox(-1);
            if (e.key === 'ArrowRight') navigateLightbox(1);
        });

        // ===== ADMIN: Upload & Delete =====
        function openUploadModal() {
            if (!isAdminUser()) return showToast('Acces admin requis');
            document.getElementById('upload-modal').style.display = 'flex';
            document.getElementById('admin-file-input').value = '';
            document.getElementById('admin-upload-preview').style.display = 'none';
            adminSelectedFiles = [];
        }
        function closeUploadModal() { document.getElementById('upload-modal').style.display = 'none'; }

        document.getElementById('admin-file-input').addEventListener('change', function(e) {
            adminSelectedFiles = Array.from(e.target.files || []);
            const preview = document.getElementById('admin-upload-preview');
            if (adminSelectedFiles.length === 0) { preview.style.display = 'none'; return; }
            preview.style.display = 'flex';
            preview.innerHTML = adminSelectedFiles.map(f => `<div style="padding:8px; border-radius:8px; border:1px solid var(--border); background:rgba(255,255,255,0.02);">${f.name}</div>`).join('');
        });

        async function uploadAdminFiles() {
            if (!isAdminUser()) return showToast('Acces admin requis');
            const titleInput = document.getElementById('admin-media-title').value.trim();
            const type = document.getElementById('admin-media-type').value || 'training';
            if (adminSelectedFiles.length === 0) return showToast('Aucun fichier selectionne');

            const btn = document.getElementById('admin-upload-btn');
            btn.disabled = true; btn.textContent = 'Upload...';

            // If server session available, try server upload first
            const useServer = window.__MNA_SERVER_USER && window.__MNA_SERVER_ROLE === 'admin';
            if (useServer) {
                try {
                    const fd = new FormData();
                    adminSelectedFiles.forEach(f => fd.append('files[]', f));
                    fd.append('title', titleInput);
                    fd.append('type', type);

                    const res = await fetch('media_upload.php', { method: 'POST', body: fd });
                    const json = await res.json();
                    if (json && json.uploaded && json.uploaded.length) {
                        json.uploaded.forEach(u => {
                            gallery.unshift({ id: u.id || (Date.now()+Math.random()), type: u.type || type, src: u.path || ('uploads/gallery/'+u.filename), title: u.title || u.originalName || titleInput || 'Media', isVideo: !!u.is_video });
                        });
                        localStorage.setItem('mna_gallery', JSON.stringify(gallery));
                        renderMedia();
                        closeUploadModal();
                        showToast('Upload reussi');
                        btn.disabled = false; btn.textContent = 'Uploader';
                        return;
                    }
                } catch (err) {
                    console.warn('Server upload failed, falling back to local', err);
                    // fallthrough to local behavior
                }
            }

            // Local fallback (keeps behavior used by the admin dashboard during development)
            setTimeout(() => {
                adminSelectedFiles.forEach(file => {
                    const id = Date.now() + Math.floor(Math.random()*1000);
                    const url = URL.createObjectURL(file);
                    const isVideo = file.type.startsWith('video/') || /\.(mp4|webm|ogg)$/i.test(file.name);
                    gallery.unshift({ id, type, src: url, title: titleInput || file.name.replace(/\.[^/.]+$/, ''), isVideo });
                });
                localStorage.setItem('mna_gallery', JSON.stringify(gallery));
                renderMedia();
                closeUploadModal();
                showToast('Media(s) ajoute(s) (local)');
                btn.disabled = false; btn.textContent = 'Uploader';
            }, 600);
        }

        function openDeleteModal(id) {
            if (!isAdminUser()) return showToast('Acces admin requis');
            adminDeleteTarget = id;
            document.getElementById('admin-delete-modal').style.display = 'flex';
        }
        function closeDeleteModal() { adminDeleteTarget = null; document.getElementById('admin-delete-modal').style.display = 'none'; }
        async function confirmAdminDelete() {
            if (!adminDeleteTarget) return closeDeleteModal();

            const target = gallery.find(g => g.id === adminDeleteTarget);
            const useServer = window.__MNA_SERVER_USER && window.__MNA_SERVER_ROLE === 'admin';
            let serverDeleted = false;

            if (useServer && target) {
                try {
                    // prefer deleting by filename/path if available
                    const payload = {};
                    if (target.src && target.src.indexOf('uploads/gallery/') !== -1) {
                        payload.filename = target.src.split('/').pop();
                    } else if (target.id) {
                        payload.id = target.id;
                    }
                    const res = await fetch('media_delete.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
                    const json = await res.json();
                    serverDeleted = json && json.deleted;
                } catch (err) {
                    console.warn('Server delete failed', err);
                }
            }

            // Remove locally regardless (keeps UI consistent). If server delete failed, item will still be removed locally.
            gallery = gallery.filter(g => g.id !== adminDeleteTarget);
            localStorage.setItem('mna_gallery', JSON.stringify(gallery));
            renderMedia();
            closeDeleteModal();
            showToast(serverDeleted ? 'Media supprime (serveur)' : 'Media supprime (local)');
        }

        // Placeholder for editing media (could open a small edit modal or redirect to admin gallery)
        function openEditMedia(id) {
            const item = gallery.find(g => g.id === id);
            if (!item) return;
            // For now redirect to dashboard-admin where a full editor exists
            window.location.href = 'dashboard-admin.php#gallery';
        }

        // ===== TOAST =====
        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ===== SCROLL REVEAL (same as before) =====
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        revealElements.forEach(el => revealObserver.observe(el));

        // ===== AUTH NAV UPDATE (reuse existing behaviour) =====
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
        function logout() { try { localStorage.removeItem('mna_user'); } catch(e) {} window.location.href = 'logout.php'; }

        // ===== INIT =====
        renderMedia();

        // Close lightbox on backdrop click
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });
    </script>
</body>
</html>