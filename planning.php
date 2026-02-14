<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - MNA Club</title>
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

        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .calendar-day { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 12px; min-height: 100px; transition: all 0.3s ease; }
        .calendar-day:hover { border-color: rgba(255,107,157,0.3); }
        .calendar-day.today { border-color: var(--accent); }
        .calendar-day.other-month { opacity: 0.3; }

        .slot-card { background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 8px; padding: 8px; margin-top: 8px; font-size: 12px; cursor: pointer; transition: all 0.3s ease; }
        .slot-card:hover { border-color: var(--accent); background: rgba(255,107,157,0.1); }
        .slot-card.available { border-left: 3px solid #22c55e; }
        .slot-card.full { border-left: 3px solid #ef4444; opacity: 0.6; }
        .slot-card.limited { border-left: 3px solid #f59e0b; }

        .week-nav { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .week-btn { width: 48px; height: 48px; border-radius: 50%; background: var(--card); border: 1px solid var(--border); color: var(--fg); cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; }
        .week-btn:hover { border-color: var(--accent); background: rgba(255,107,157,0.1); }

        .filter-btn { padding: 8px 16px; border-radius: 20px; background: transparent; border: 1px solid var(--border); color: var(--muted); cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
        .filter-btn:hover { border-color: var(--accent); color: var(--fg); }
        .filter-btn.active { background: var(--accent); border-color: var(--accent); color: white; }

        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .legend-dot { width: 12px; height: 12px; border-radius: 50%; }

        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: #22c55e; }
        .toast.error { border-color: #ef4444; }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }

        @media (max-width: 768px) {
            .calendar-grid { grid-template-columns: repeat(4, 1fr); }
            .calendar-day { min-height: 80px; padding: 8px; }
        }

        @media (max-width: 480px) {
            .calendar-grid { grid-template-columns: repeat(2, 1fr); }
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
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 reveal">
                <h1 class="font-display text-5xl sm:text-6xl mb-4">PLANNING DES SEANCES</h1>
                <p class="text-[var(--muted)] max-w-2xl mx-auto">Consulte les creneaux disponibles et reserve ta seance en quelques clics.</p>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8 reveal">
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active" onclick="filterSlots('all')">Tous</button>
                    <button class="filter-btn" onclick="filterSlots('available')">Disponibles</button>
                    <button class="filter-btn" onclick="filterSlots('limited')">Places limitees</button>
                    <button class="filter-btn" onclick="filterSlots('morning')">Matin</button>
                    <button class="filter-btn" onclick="filterSlots('evening')">Soir</button>
                </div>
                <div class="flex items-center gap-6">
                    <div class="legend-item"><div class="legend-dot bg-green-500"></div><span class="text-sm text-[var(--muted)]">Disponible</span></div>
                    <div class="legend-item"><div class="legend-dot bg-yellow-500"></div><span class="text-sm text-[var(--muted)]">Limite</span></div>
                    <div class="legend-item"><div class="legend-dot bg-red-500"></div><span class="text-sm text-[var(--muted)]">Complet</span></div>
                </div>
            </div>

            <!-- Week Navigation -->
            <div class="week-nav mb-8 reveal">
                <button class="week-btn" onclick="changeWeek(-1)" aria-label="Semaine precedente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="text-center">
                    <h2 class="font-display text-2xl" id="week-title">JANVIER 2025</h2>
                    <p class="text-[var(--muted)] text-sm" id="week-range">20 - 26 Janvier</p>
                </div>
                <button class="week-btn" onclick="changeWeek(1)" aria-label="Semaine suivante">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid reveal" id="calendar-grid">
                <!-- Generated by JS -->
            </div>

            <!-- List View for Mobile -->
            <div class="mt-8 space-y-4 lg:hidden" id="slots-list">
                <!-- Generated by JS -->
            </div>
        </div>
    </main>

    <!-- Slot Detail Modal -->
    <div id="slot-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100; justify-content: center; align-items: center; padding: 20px;">
        <div class="bg-[var(--bg-secondary)] border border-[var(--border)] rounded-3xl p-8 max-w-md w-full">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-display text-2xl">DETAILS SEANCE</h3>
                <button onclick="closeModal()" class="p-2 hover:opacity-70 transition-opacity" aria-label="Fermer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div id="modal-content">
                <!-- Filled by JS -->
            </div>
        </div>
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
    <?php include 'footer.php'; ?>

    <!-- Toast -->
    <div id="toast" class="toast"><p id="toast-message"></p></div>

    <script>
        // ===== DATA =====
        const scheduleData = [
            { id: 1, day: 1, dayName: 'Lundi', date: '20 Janvier', time: '18:00', endTime: '19:00', places: 8, maxPlaces: 10, type: 'soir' },
            { id: 2, day: 2, dayName: 'Mardi', date: '21 Janvier', time: '10:00', endTime: '11:00', places: 5, maxPlaces: 10, type: 'matin' },
            { id: 3, day: 3, dayName: 'Mercredi', date: '22 Janvier', time: '10:00', endTime: '11:00', places: 3, maxPlaces: 10, type: 'matin' },
            { id: 4, day: 3, dayName: 'Mercredi', date: '22 Janvier', time: '18:00', endTime: '19:00', places: 7, maxPlaces: 10, type: 'soir' },
            { id: 5, day: 4, dayName: 'Jeudi', date: '23 Janvier', time: '18:00', endTime: '19:00', places: 2, maxPlaces: 10, type: 'soir' },
            { id: 6, day: 5, dayName: 'Vendredi', date: '24 Janvier', time: '18:00', endTime: '19:00', places: 6, maxPlaces: 10, type: 'soir' },
            { id: 7, day: 6, dayName: 'Samedi', date: '25 Janvier', time: '10:00', endTime: '11:00', places: 0, maxPlaces: 10, type: 'matin' },
            { id: 8, day: 6, dayName: 'Samedi', date: '25 Janvier', time: '14:00', endTime: '15:00', places: 4, maxPlaces: 10, type: 'matin' },
        ];

        // Merge admin-managed slots from localStorage so admin changes appear immediately on the public planning
        try {
            const adminSlots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
            if (Array.isArray(adminSlots) && adminSlots.length) {
                adminSlots.forEach(s => {
                    if (s.kind === 'recurring') {
                        scheduleData.push({
                            id: s.id,
                            day: Number(s.day) || 1,
                            dayName: s.dayName || fullDays[(Number(s.day) || 1) % 7],
                            date: '',
                            time: s.time || s.start || '18:00',
                            endTime: s.endTime || '',
                            places: s.places || s.capacity || 10,
                            maxPlaces: s.capacity || s.max || 10,
                            type: (s.time && s.time < '12:00') ? 'matin' : 'soir'
                        });
                    } else if (s.kind === 'single' && s.date) {
                        const d = new Date(s.date);
                        const dayIdx = d.getDay() === 0 ? 7 : d.getDay();
                        scheduleData.push({
                            id: s.id,
                            day: dayIdx,
                            dayName: fullDays[dayIdx % 7],
                            date: d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                            time: s.time || '18:00',
                            endTime: '',
                            places: s.places || s.capacity || 10,
                            maxPlaces: s.capacity || s.max || 10,
                            type: (s.time && s.time < '12:00') ? 'matin' : 'soir'
                        });
                    }
                });
            }
        } catch (err) { console.warn('Could not merge admin slots into planning:', err); }

        // Also fetch server-side slots (public endpoint) and merge so DB-persistent admin slots appear on the public planning
        try {
            fetch('slots_list.php').then(res => res.ok ? res.json() : []).then(rows => {
                if (!Array.isArray(rows) || rows.length === 0) return;
                rows.forEach(r => {
                    const kind = r.kind || 'recurring';
                    const capacity = r.capacity || 10;
                    if (kind === 'recurring' && r.day) {
                        const dayNum = Number(r.day) || 1;
                        scheduleData.push({
                            id: r.id,
                            day: dayNum,
                            dayName: fullDays[dayNum % 7],
                            date: '',
                            time: r.time || '18:00',
                            endTime: '',
                            places: capacity,
                            maxPlaces: capacity,
                            type: (r.time && r.time < '12:00') ? 'matin' : 'soir'
                        });
                    } else if (kind === 'single' && r.date) {
                        const d = new Date(r.date);
                        const dayIdx = d.getDay() === 0 ? 7 : d.getDay();
                        scheduleData.push({
                            id: r.id,
                            day: dayIdx,
                            dayName: fullDays[dayIdx % 7],
                            date: d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                            time: r.time || '18:00',
                            endTime: '',
                            places: capacity,
                            maxPlaces: capacity,
                            type: (r.time && r.time < '12:00') ? 'matin' : 'soir'
                        });
                    }
                });

                // Re-render calendar now we merged server slots
                try { renderCalendar(); } catch (e) { /* ignore if not ready */ }
            }).catch(err => console.warn('Could not fetch server slots for planning:', err));
        } catch (e) { /* ignore */ }

        const days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        const fullDays = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        let currentWeekOffset = 0;
        let currentFilter = 'all';

        // ===== RENDER CALENDAR =====
        function renderCalendar() {
            const grid = document.getElementById('calendar-grid');
            const listContainer = document.getElementById('slots-list');
            if (!grid) return;

            const today = new Date();
            today.setDate(today.getDate() + (currentWeekOffset * 7));
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay() + 1);

            // Update title
            const monthNames = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
            document.getElementById('week-title').textContent = monthNames[startOfWeek.getMonth()].toUpperCase() + ' ' + startOfWeek.getFullYear();

            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            document.getElementById('week-range').textContent = startOfWeek.getDate() + ' - ' + endOfWeek.getDate() + ' ' + monthNames[startOfWeek.getMonth()];

            // Generate grid
            let gridHTML = '';
            let listHTML = '';

            for (let i = 0; i < 7; i++) {
                const date = new Date(startOfWeek);
                date.setDate(startOfWeek.getDate() + i);
                const dayNum = date.getDate();
                const isToday = date.toDateString() === new Date().toDateString();

                // Get slots for this day
                const daySlots = scheduleData.filter(s => s.day === (i + 1) || (i === 6 && s.day === 6)).filter(filterFunction);

                gridHTML += `
                    <div class="calendar-day ${isToday ? 'today' : ''}">
                        <div class="text-center mb-2">
                            <p class="text-xs text-[var(--muted)]">${days[(i + 1) % 7]}</p>
                            <p class="font-display text-xl">${dayNum}</p>
                        </div>
                        ${daySlots.map(slot => renderSlotCard(slot)).join('')}
                    </div>
                `;

                if (daySlots.length > 0) {
                    listHTML += `
                        <div class="bg-[var(--card)] border border-[var(--border)] rounded-2xl p-4">
                            <p class="font-medium mb-3">${fullDays[(i + 1) % 7]} ${dayNum}</p>
                            <div class="space-y-2">
                                ${daySlots.map(slot => `
                                    <div class="flex items-center justify-between p-3 bg-[rgba(255,255,255,0.02)] rounded-lg cursor-pointer hover:bg-[rgba(255,107,157,0.1)] transition-colors" onclick="openSlotModal(${slot.id})">
                                        <div>
                                            <p class="font-medium">${slot.time} - ${slot.endTime}</p>
                                            <p class="text-sm text-[var(--muted)]">${getAvailabilityText(slot)}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatusClass(slot)}">${slot.places}/${slot.maxPlaces}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }
            }

            grid.innerHTML = gridHTML;
            listContainer.innerHTML = listHTML;
        }

        function renderSlotCard(slot) {
            const statusClass = getSlotStatusClass(slot);
            return `
                <div class="slot-card ${statusClass}" onclick="openSlotModal(${slot.id})">
                    <p class="font-medium">${slot.time}</p>
                    <p class="text-[var(--muted)]">${slot.places}/${slot.maxPlaces}</p>
                </div>
            `;
        }

        function getSlotStatusClass(slot) {
            if (slot.places === 0) return 'full';
            if (slot.places <= 3) return 'limited';
            return 'available';
        }

        function getStatusClass(slot) {
            if (slot.places === 0) return 'bg-red-500/20 text-red-400';
            if (slot.places <= 3) return 'bg-yellow-500/20 text-yellow-400';
            return 'bg-green-500/20 text-green-400';
        }

        function getAvailabilityText(slot) {
            if (slot.places === 0) return 'Complet';
            if (slot.places <= 3) return 'Dernieres places';
            return slot.places + ' places disponibles';
        }

        function filterFunction(slot) {
            if (currentFilter === 'all') return true;
            if (currentFilter === 'available') return slot.places > 3;
            if (currentFilter === 'limited') return slot.places > 0 && slot.places <= 3;
            if (currentFilter === 'morning') return slot.type === 'matin';
            if (currentFilter === 'evening') return slot.type === 'soir';
            return true;
        }

        // ===== FILTER SLOTS =====
        function filterSlots(filter) {
            currentFilter = filter;
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            renderCalendar();
        }

        // ===== WEEK NAVIGATION =====
        function changeWeek(direction) {
            currentWeekOffset += direction;
            renderCalendar();
        }

        // ===== MODAL =====
        function openSlotModal(id) {
            const slot = scheduleData.find(s => s.id === id);
            if (!slot) return;

            const modal = document.getElementById('slot-modal');
            const content = document.getElementById('modal-content');

            const isAvailable = slot.places > 0;
            const statusText = getAvailabilityText(slot);
            const statusClass = getStatusClass(slot);

            content.innerHTML = `
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-display text-xl">${slot.dayName}</p>
                            <p class="text-[var(--muted)]">${slot.date}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-[var(--card)] rounded-xl p-4">
                            <p class="text-sm text-[var(--muted)] mb-1">Horaire</p>
                            <p class="font-semibold">${slot.time} - ${slot.endTime}</p>
                        </div>
                        <div class="bg-[var(--card)] rounded-xl p-4">
                            <p class="text-sm text-[var(--muted)] mb-1">Disponibilite</p>
                            <p class="font-semibold ${statusClass.includes('red') ? 'text-red-400' : statusClass.includes('yellow') ? 'text-yellow-400' : 'text-green-400'}">${statusText}</p>
                        </div>
                    </div>

                    <div class="bg-[var(--card)] rounded-xl p-4">
                        <p class="text-sm text-[var(--muted)] mb-2">Places restantes</p>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-2 bg-[var(--border)] rounded-full overflow-hidden">
                                <div class="h-full ${slot.places === 0 ? 'bg-red-500' : slot.places <= 3 ? 'bg-yellow-500' : 'bg-green-500'}" style="width: ${(slot.places / slot.maxPlaces) * 100}%"></div>
                            </div>
                            <span class="font-semibold">${slot.places}/${slot.maxPlaces}</span>
                        </div>
                    </div>

                    ${isAvailable ? `
                        <a href="reservation.php?slot=${slot.id}" class="btn-primary w-full justify-center">
                            Reserver cette seance
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    ` : `
                        <button class="btn-secondary w-full justify-center" onclick="joinWaitlist(${slot.id})">
                            Rejoindre la liste d'attente
                        </button>
                    `}
                </div>
            `;

            modal.style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('slot-modal').style.display = 'none';
        }

        function joinWaitlist(id) {
            showToast('Vous avez ete ajoute a la liste d\'attente', 'success');
            closeModal();
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
        }

        function logout() {
            try { localStorage.removeItem('mna_user'); } catch(e) {}
            window.location.href = 'logout.php';
        }

        // ===== INIT =====
        renderCalendar();

        // Close modal on outside click
        document.getElementById('slot-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>