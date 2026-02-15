<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifs - MNA Club</title>
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
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg); overflow-x: hidden; }
        .font-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.02em; }

        .nav-glass {
            background: rgba(10,10,15,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-link {
            position: relative;
            color: var(--muted);
            transition: color 0.3s ease;
        }

        .nav-link:hover { color: var(--fg); }
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
        .nav-link:hover::after { width: 100%; }

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

        .pricing-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid var(--border);
            border-radius: 32px;
            padding: 40px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pricing-card:hover::before { opacity: 1; }
        .pricing-card:hover { transform: translateY(-10px); }

        .pricing-featured {
            border-color: var(--accent);
            box-shadow: 0 0 60px rgba(255,107,157,0.2);
        }

        .pricing-featured::before { opacity: 1; }

        .badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .feature-list li:last-child { border-bottom: none; }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }

        .faq-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover { border-color: rgba(255,107,157,0.3); }

        .faq-question {
            padding: 20px 24px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0 24px;
        }

        .faq-item.open .faq-answer {
            max-height: 200px;
            padding-bottom: 20px;
        }

        .faq-item.open .faq-icon {
            transform: rotate(180deg);
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
        .toast.success { border-color: #22c55e; }
        .toast.error { border-color: #ef4444; }

        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 4px;
        }

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

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, var(--accent), var(--accent-secondary));
            top: -200px;
            right: -100px;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, var(--accent-secondary), #6366f1);
            bottom: -100px;
            left: -100px;
        }
    </style>
</head>
<body>
    <div class="gradient-bg">
        <div class="gradient-orb orb-1"></div>
        <div class="gradient-orb orb-2"></div>
    </div>

    <?php include 'header.php'; ?>

    <!-- Hero -->
    <section class="pt-0 pb-16">
        <div class="max-w-7xl mx-auto px-6 text-center reveal">
            <span class="inline-block px-4 py-2 rounded-full bg-[var(--card)] border border-[var(--border)] text-sm font-medium mb-4">
                Nos tarifs
            </span>
            <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl mb-6">
                CHOISIS TON FORMULE
            </h1>
            <p class="text-lg text-[var(--muted)] max-w-2xl mx-auto">
                Des offres adaptees a tes besoins et ton budget. Commence des aujourd'hui.
            </p>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Decouverte -->
                <div class="pricing-card reveal" style="transition-delay: 0.1s;">
                    <div class="mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center mb-4">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-3xl mb-2">DECOUVERTE</h3>
                        <p class="text-[var(--muted)] text-sm">Pour debuter en douceur</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-5xl font-bold">10€</span>
                        <span class="text-[var(--muted)]">/ seance</span>
                    </div>

                    <ul class="feature-list mb-8 text-sm">
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>1 seance de 1h</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Bilan initial offert</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Programme personnalise</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Offre premiere inscription</span>
                        </li>
                    </ul>

                    <a href="reservation.php?type=decouverte" class="btn-primary w-full justify-center">
                        Choisir cette offre
                    </a>
                </div>

                <!-- Unitaire -->
                <div class="pricing-card pricing-featured reveal" style="transition-delay: 0.2s;">
                    <div class="badge">Populaire</div>
                    
                    <div class="mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[var(--accent-secondary)] to-indigo-500 flex items-center justify-center mb-4">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-3xl mb-2">UNITAIRE</h3>
                        <p class="text-[var(--muted)] text-sm">A la carte</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-5xl font-bold">15€</span>
                        <span class="text-[var(--muted)]">/ seance</span>
                    </div>

                    <ul class="feature-list mb-8 text-sm">
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>1 seance de 1h</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Choix du creneau libre</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Suivi personnalise</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Flexibilite totale</span>
                        </li>
                    </ul>

                    <a href="reservation.php?type=unitaire" class="btn-primary w-full justify-center">
                        Choisir cette offre
                    </a>
                </div>

                <!-- Abonnement -->
                <div class="pricing-card reveal" style="transition-delay: 0.3s;">
                    <div class="mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-4">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-3xl mb-2">ABONNEMENT</h3>
                        <p class="text-[var(--muted)] text-sm">Le meilleur rapport qualite/prix</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-5xl font-bold">55€</span>
                        <span class="text-[var(--muted)]">/ 4 seances</span>
                        <div class="text-sm text-green-400 mt-1">Economise 5€</div>
                    </div>

                    <ul class="feature-list mb-8 text-sm">
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>4 seances de 1h</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Choix des creneaux prioritaires</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Suivi avance</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Support prioritaire</span>
                        </li>
                        <li>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Validite 30 jours</span>
                        </li>
                    </ul>

                    <a href="reservation.php?type=abonnement" class="btn-primary w-full justify-center">
                        Choisir cette offre
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="font-display text-3xl text-center mb-12 reveal">COMPARATIF DES OFFRES</h2>
            
            <div class="overflow-x-auto reveal">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--border)]">
                            <th class="text-left py-4 font-medium text-[var(--muted)]">Fonctionnalites</th>
                            <th class="text-center py-4 font-medium">Decouverte</th>
                            <th class="text-center py-4 font-medium text-[var(--accent)]">Unitaire</th>
                            <th class="text-center py-4 font-medium">Abonnement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-[var(--border)]">
                            <td class="py-4">Seances incluses</td>
                            <td class="text-center py-4">1</td>
                            <td class="text-center py-4">1</td>
                            <td class="text-center py-4">4</td>
                        </tr>
                        <tr class="border-b border-[var(--border)]">
                            <td class="py-4">Bilan initial</td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                        </tr>
                        <tr class="border-b border-[var(--border)]">
                            <td class="py-4">Programme personnalise</td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                        </tr>
                        <tr class="border-b border-[var(--border)]">
                            <td class="py-4">Choix creneau prioritaire</td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                        </tr>
                        <tr class="border-b border-[var(--border)]">
                            <td class="py-4">Suivi avance</td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                        </tr>
                        <tr>
                            <td class="py-4">Support prioritaire</td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" class="mx-auto"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></td>
                            <td class="text-center py-4"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" class="mx-auto"><polyline points="20 6 9 17 4 12"/></svg></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="font-display text-3xl text-center mb-12 reveal">QUESTIONS FREQUENTES</h2>

            <div class="space-y-4 reveal">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Comment se deroule une seance ?</span>
                        <svg class="faq-icon transition-transform" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    <div class="faq-answer text-[var(--muted)]">
                        Chaque seance commence par un echauffement, suivi d'exercices adaptes a vos objectifs. Le coach vous guide tout au long de la seance et ajuste les exercices selon votre progression.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Puis-je annuler ou reporter une seance ?</span>
                        <svg class="faq-icon transition-transform" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    <div class="faq-answer text-[var(--muted)]">
                        Oui, vous pouvez annuler ou reporter votre seance jusqu'a 24h avant le creneau prevu. Au-dela, la seance sera debiteee de votre forfait.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Quels moyens de paiement acceptez-vous ?</span>
                        <svg class="faq-icon transition-transform" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    <div class="faq-answer text-[var(--muted)]">
                        Nous acceptons les paiements par carte bancaire via Stripe (securise), ainsi que les virements bancaires pour les abonnements.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Y a-t-il un engagement ?</span>
                        <svg class="faq-icon transition-transform" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>
                    <div class="faq-answer text-[var(--var(--muted))]">
                        Aucun engagement ! Les seances unitaires et l'abonnement de 4 seances sont sans engagement. Vous etes libre de renouveler ou non.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24">
        <div class="max-w-4xl mx-auto px-6 text-center reveal">
            <h2 class="font-display text-4xl sm:text-5xl mb-6">PRETE A COMMENCER ?</h2>
            <p class="text-lg text-[var(--muted)] mb-8 max-w-2xl mx-auto">
                Reserve ta premiere seance des maintenant et commence ta transformation.
            </p>
            <a href="reservation.php" class="btn-primary text-lg">
                Reserver une seance
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-[var(--bg-secondary)] border-t border-[var(--border)]">
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
                        Coaching sportif feminin personnalise.
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
                </div>
            </div>

    <?php include 'footer.php'; ?>

    <!-- Toast -->
    <div id="toast" class="toast">
        <p id="toast-message"></p>
    </div>

    <script>
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

        // ===== FAQ TOGGLE =====
        function toggleFaq(element) {
            const item = element.parentElement;
            item.classList.toggle('open');
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