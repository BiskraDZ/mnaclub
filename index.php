<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNA Club - Coaching Sportif Femme</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--fg);
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.02em;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            top: -200px;
            right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, var(--accent-secondary), #6366f1);
            bottom: -100px;
            left: -100px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #f472b6, var(--accent));
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.05); }
            50% { transform: translate(-20px, 20px) scale(0.95); }
            75% { transform: translate(20px, 30px) scale(1.02); }
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
        }

        #particles-canvas {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .nav-glass {
            background: rgba(10,10,15,0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-link {
            position: relative;
            color: var(--muted);
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--fg);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-secondary));
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
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

        .card-glass {
            background: var(--card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 24px;
            transition: all 0.4s ease;
        }

        .card-glass:hover {
            transform: translateY(-8px);
            border-color: rgba(255,107,157,0.3);
            box-shadow: 0 20px 40px rgba(255,107,157,0.1);
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-number {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .testimonial-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            border-color: rgba(255,107,157,0.3);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: var(--bg-secondary);
            z-index: 100;
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 100px 40px;
        }

        .mobile-menu.open {
            right: 0;
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 99;
        }

        .mobile-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .schedule-slot {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .schedule-slot:hover {
            border-color: var(--accent);
            background: rgba(255,107,157,0.05);
        }

        .schedule-slot.available {
            border-left: 3px solid #22c55e;
        }

        .schedule-slot.full {
            border-left: 3px solid #ef4444;
            opacity: 0.6;
        }

        footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 4px;
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

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            border-color: #22c55e;
        }

        .toast.error {
            border-color: #ef4444;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Hero Section -->

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20">
        <div class="hero-bg">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="gradient-orb orb-3"></div>
            <div class="grid-pattern"></div>
            <canvas id="particles-canvas"></canvas>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <span class="inline-block px-4 py-2 rounded-full bg-gradient-to-r from-[var(--accent)]/20 to-[var(--accent-secondary)]/20 border border-[var(--accent)]/30 text-sm font-medium mb-6">
                        Coaching Sportif Feminin
                    </span>
                    <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl xl:text-8xl leading-none mb-6">
                        REVELE TON
                        <span class="block bg-gradient-to-r from-[var(--accent)] to-[var(--accent-secondary)] bg-clip-text text-transparent">
                            POTENTIEL
                        </span>
                    </h1>
                    <p class="text-lg text-[var(--muted)] max-w-lg mb-8 leading-relaxed">
                        Rejoins une communaute de femmes determinees. Des seances personnalisees, un suivi adapte, des resultats visibles.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="reservation.php" class="btn-primary">
                            <span>Reserver une seance</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                        <a href="tarifs.php" class="btn-secondary">
                            <span>Voir les tarifs</span>
                        </a>
                    </div>
                </div>

                <div class="reveal relative" style="transition-delay: 0.2s;">
                    <div class="relative aspect-square max-w-md mx-auto">
                        <div class="absolute inset-0 rounded-full border border-[var(--accent)]/20 animate-pulse"></div>
                        <div class="absolute inset-4 rounded-full border border-[var(--accent-secondary)]/30"></div>
                        <div class="absolute inset-8 rounded-full bg-gradient-to-br from-[var(--accent)]/20 to-[var(--accent-secondary)]/20 overflow-hidden flex items-center justify-center">
                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="1" class="opacity-50">
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#ff6b9d"/>
                                        <stop offset="100%" style="stop-color:#c44cff"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="12" cy="5" r="3"/>
                                <line x1="12" y1="8" x2="12" y2="16"/>
                                <line x1="12" y1="12" x2="8" y2="10"/>
                                <line x1="12" y1="12" x2="16" y2="10"/>
                                <line x1="12" y1="16" x2="9" y2="21"/>
                                <line x1="12" y1="16" x2="15" y2="21"/>
                            </svg>
                        </div>

                        <div class="absolute -right-4 top-1/4 card-glass p-4 animate-bounce" style="animation-duration: 3s;">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[var(--muted)]">Places ce mois</p>
                                    <p class="font-semibold">12 disponibles</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -left-4 bottom-1/4 card-glass p-4 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[var(--accent)]/20 flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ff6b9d" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-[var(--muted)]">Membres actifs</p>
                                    <p class="font-semibold">150+</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
            <span class="text-xs text-[var(--muted)]">Scroll</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="relative py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 reveal">
                <div class="text-center">
                    <div class="stat-number" data-target="150">0</div>
                    <p class="text-[var(--muted)] mt-2">Membres actives</p>
                </div>
                <div class="text-center">
                    <div class="stat-number" data-target="500">0</div>
                    <p class="text-[var(--muted)] mt-2">Seances realisees</p>
                </div>
                <div class="text-center">
                    <div class="stat-number" data-target="98">0</div>
                    <p class="text-[var(--muted)] mt-2">% Satisfaction</p>
                </div>
                <div class="text-center">
                    <div class="stat-number" data-target="3">0</div>
                    <p class="text-[var(--muted)] mt-2">Ans d'experience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-24" id="services">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="inline-block px-4 py-2 rounded-full bg-[var(--card)] border border-[var(--border)] text-sm font-medium mb-4">
                    Nos formules
                </span>
                <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl">
                    DES SEANCES ADAPTEES
                </h2>
                <p class="text-[var(--muted)] mt-4 max-w-2xl mx-auto">
                    Chaque programme est concu pour repondre a vos objectifs specifiques
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-glass p-8 reveal" style="transition-delay: 0.1s;">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-2xl mb-3">Seance Decouverte</h3>
                    <p class="text-[var(--muted)] mb-6">
                        Decouvre notre approche avec une premiere seance accessible. Ideal pour commencer en douceur.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold">10€</span>
                        <a href="reservation.php?type=decouverte" class="text-[var(--accent)] font-medium flex items-center gap-2 hover:gap-3 transition-all">
                            Reserver
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="card-glass p-8 reveal" style="transition-delay: 0.2s;">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[var(--accent-secondary)] to-indigo-500 flex items-center justify-center mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-2xl mb-3">Seance Unitaire</h3>
                    <p class="text-[var(--muted)] mb-6">
                        Une seance ponctuelle pour travailler un objectif precis ou maintenir votre forme.
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold">15€</span>
                        <a href="reservation.php?type=unitaire" class="text-[var(--accent)] font-medium flex items-center gap-2 hover:gap-3 transition-all">
                            Reserver
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="card-glass p-8 reveal" style="transition-delay: 0.3s;">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-6">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-2xl mb-3">Abonnement 4 Seances</h3>
                    <p class="text-[var(--muted)] mb-6">
                        L'offre complete pour progresser regulierement. 4 seances avec une reduction significative.
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold">55€</span>
                            <span class="text-[var(--muted)] text-sm ml-2 line-through">60€</span>
                        </div>
                        <a href="reservation.php?type=abonnement" class="text-[var(--accent)] font-medium flex items-center gap-2 hover:gap-3 transition-all">
                            Reserver
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Preview -->
    <section class="py-24 bg-[var(--bg-secondary)]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="inline-block px-4 py-2 rounded-full bg-[var(--card)] border border-[var(--border)] text-sm font-medium mb-4">
                    Planning
                </span>
                <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl">
                    PROCHAINS CRENEAUX
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 reveal" id="schedule-preview">
                <!-- Rempli par JS -->
            </div>

            <div class="text-center mt-12">
                <a href="planning.php" class="btn-primary">
                    Voir tout le planning
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="inline-block px-4 py-2 rounded-full bg-[var(--card)] border border-[var(--border)] text-sm font-medium mb-4">
                    Temoignages
                </span>
                <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl">
                    ELLES TEMOIGNENT
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6 reveal">
                <div class="testimonial-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <p class="text-[var(--muted)] mb-6 leading-relaxed">
                        "Apres 3 mois, j'ai perdu 8kg et retrouve confiance en moi. Les seances sont adaptees et le suivi personnalise fait toute la difference."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center font-semibold">SL</div>
                        <div>
                            <p class="font-medium">Sophie L.</p>
                            <p class="text-sm text-[var(--muted)]">Membre depuis 6 mois</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <p class="text-[var(--muted)] mb-6 leading-relaxed">
                        "En tant que debutante, j'etais apprehensive. L'ambiance est bienveillante et chaque seance est un vrai moment de plaisir."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-semibold">CM</div>
                        <div>
                            <p class="font-medium">Claire M.</p>
                            <p class="text-sm text-[var(--muted)]">Membre depuis 3 mois</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="flex items-center gap-1 mb-4">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="#ff6b9d"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <p class="text-[var(--muted)] mb-6 leading-relaxed">
                        "Le meilleur investissement pour ma sante. J'ai redécouvert le plaisir du sport avec des objectifs realistes et atteignables."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center font-semibold">LD</div>
                        <div>
                            <p class="font-medium">Laura D.</p>
                            <p class="text-sm text-[var(--muted)]">Membre depuis 1 an</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[var(--accent)]/10 to-[var(--accent-secondary)]/10"></div>
        <div class="absolute inset-0">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-br from-[var(--accent)]/20 to-[var(--accent-secondary)]/20 blur-3xl"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center reveal">
            <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-6">
                PRETE A COMMENCER ?
            </h2>
            <p class="text-xl text-[var(--muted)] mb-10 max-w-2xl mx-auto">
                Rejoins MNA Club et transforme ton corps et ton esprit. Premiere seance decouverte a 10€.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="contact.php" class="btn-secondary text-lg">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <a href="index.php" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
                                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                            </svg>
                        </div>
                        <span class="font-display text-xl">MNA CLUB</span>
                    </a>
                    <p class="text-[var(--muted)] text-sm leading-relaxed">
                        Coaching sportif feminin personnalise. Atteins tes objectifs dans une ambiance bienveillante.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-[var(--muted)] hover:text-white transition-colors text-sm">Accueil</a></li>
                        <li><a href="tarifs.php" class="text-[var(--muted)] hover:text-white transition-colors text-sm">Tarifs</a></li>
                        <li><a href="planning.php" class="text-[var(--muted)] hover:text-white transition-colors text-sm">Planning</a></li>
                        <li><a href="avis.php" class="text-[var(--muted)] hover:text-white transition-colors text-sm">Avis</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Mon compte</h4>
                    <ul class="space-y-2">
                        <li><a href="dashboard-client.php" class="text-[var(--muted)] hover:text-white transition-colors text-sm">Mon espace</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2">
                        <li class="text-[var(--muted)] text-sm">contact@mnaclub.fr</li>
                        <li class="text-[var(--muted)] text-sm">06 XX XX XX XX</li>
                        <li class="text-[var(--muted)] text-sm">63 BD Stalingrad, Vitry-sur-Seine, 94400</li>
                    </ul>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-[var(--card)] border border-[var(--border)] flex items-center justify-center hover:border-[var(--accent)] transition-colors" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[var(--card)] border border-[var(--border)] flex items-center justify-center hover:border-[var(--accent)] transition-colors" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

    <?php include 'footer.php'; ?>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <p id="toast-message"></p>
    </div>

    <script>
        // ===== DATA INITIALIZATION =====
        const scheduleData = [
            { id: 1, day: 'Lundi', date: '20 Janvier', time: '18h00 - 19h00', places: 3, available: true },
            { id: 2, day: 'Mercredi', date: '22 Janvier', time: '10h00 - 11h00', places: 5, available: true },
            { id: 3, day: 'Vendredi', date: '24 Janvier', time: '18h00 - 19h00', places: 2, available: true },
            { id: 4, day: 'Samedi', date: '25 Janvier', time: '10h00 - 11h00', places: 0, available: false }
        ];

        // ===== CANVAS PARTICLES =====
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationId = null;
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        function createParticles() {
            particles = [];
            const particleCount = Math.min(80, Math.floor(window.innerWidth / 20));
            for (let i = 0; i < particleCount; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.max(1, Math.random() * 2),
                    vx: (Math.random() - 0.5) * 0.5,
                    vy: (Math.random() - 0.5) * 0.5,
                    alpha: Math.random() * 0.5 + 0.2
                });
            }
        }

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            particles.forEach((p, i) => {
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0) p.x = canvas.width;
                if (p.x > canvas.width) p.x = 0;
                if (p.y < 0) p.y = canvas.height;
                if (p.y > canvas.height) p.y = 0;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255, 107, 157, ' + p.alpha + ')';
                ctx.fill();

                for (let j = i + 1; j < particles.length; j++) {
                    const p2 = particles[j];
                    const dx = p.x - p2.x;
                    const dy = p.y - p2.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 120) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.strokeStyle = 'rgba(255, 107, 157, ' + (0.1 * (1 - dist / 120)) + ')';
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            });

            animationId = requestAnimationFrame(drawParticles);
        }

        if (!prefersReducedMotion) {
            resizeCanvas();
            createParticles();
            drawParticles();
            window.addEventListener('resize', () => {
                resizeCanvas();
                createParticles();
            });
        }

        // Mobile menu behaviour is handled globally in `footer.php` (no duplicate here).

        // ===== SCROLL REVEAL =====
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        revealElements.forEach(el => revealObserver.observe(el));

        // ===== STATS COUNTER =====
        const statNumbers = document.querySelectorAll('.stat-number');
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.target);
                    animateCounter(entry.target, target);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => statsObserver.observe(stat));

        function animateCounter(element, target) {
            if (prefersReducedMotion) {
                element.textContent = target + (target > 10 ? '+' : '');
                return;
            }
            
            let current = 0;
            const increment = target / 50;
            const duration = 1500;
            const stepTime = duration / 50;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (target > 10 ? '+' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, stepTime);
        }

        // ===== RENDER SCHEDULE PREVIEW =====
        function renderSchedulePreview() {
            const container = document.getElementById('schedule-preview');
            if (!container) return;

            container.innerHTML = scheduleData.map(slot => `
                <div class="schedule-slot ${slot.available ? 'available' : 'full'}" onclick="selectSlot(${slot.id})">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg ${slot.available ? 'bg-[rgba(255,107,157,0.2)]' : 'bg-[rgba(239,68,68,0.2)]'} flex items-center justify-center">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="${slot.available ? '#ff6b9d' : '#ef4444'}" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold">${slot.day}</p>
                            <p class="text-sm text-[var(--muted)]">${slot.date}</p>
                        </div>
                    </div>
                    <p class="text-lg font-medium">${slot.time}</p>
                    <p class="text-sm ${slot.available ? 'text-green-400' : 'text-red-400'} mt-1">
                        ${slot.available ? slot.places + ' places restantes' : 'Complet'}
                    </p>
                </div>
            `).join('');
        }

        function selectSlot(id) {
            const slot = scheduleData.find(s => s.id === id);
            if (slot && slot.available) {
                window.location.href = 'reservation.php?slot=' + id;
            } else if (slot) {
                showToast('Ce creneau est complet', 'error');
            }
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

        // ===== NAV SCROLL =====
        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(10, 10, 15, 0.95)';
            } else {
                nav.style.background = 'rgba(10, 10, 15, 0.8)';
            }
        });

        // ===== INIT =====
        renderSchedulePreview();

        // Check if user is logged in (only update nav from localStorage when server has no active session)
        const currentUser = localStorage.getItem('mna_user');
        if (!window.__MNA_SERVER_USER && currentUser) {
            const user = JSON.parse(currentUser);
            const navRight = document.querySelector('nav .hidden.lg\\:flex.items-center.gap-4');
            if (navRight) {
                navRight.innerHTML = `
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