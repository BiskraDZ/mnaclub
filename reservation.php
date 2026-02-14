<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - MNA Club</title>
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
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--fg); }
        .font-display { font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.02em; }

        .nav-glass { background: rgba(10,10,15,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
        .nav-link { position: relative; color: var(--muted); transition: color 0.3s ease; }
        .nav-link:hover { color: var(--fg); }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, var(--accent), var(--accent-secondary)); transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: var(--fg); }
        .nav-link.active::after { width: 100%; }

        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 14px 32px; border-radius: 50px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px var(--glow); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px var(--glow); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .btn-secondary { background: transparent; color: var(--fg); padding: 14px 32px; border-radius: 50px; font-weight: 600; border: 1px solid var(--border); cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: var(--accent); }

        .form-card { background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid var(--border); border-radius: 24px; padding: 32px; }
        .form-input { width: 100%; padding: 14px 20px; background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 12px; color: var(--fg); font-size: 16px; transition: all 0.3s ease; }
        .form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,107,157,0.1); }
        .form-label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; }

        .offer-card { background: var(--card); border: 2px solid var(--border); border-radius: 20px; padding: 24px; cursor: pointer; transition: all 0.3s ease; position: relative; }
        .offer-card:hover { border-color: rgba(255,107,157,0.5); }
        .offer-card.selected { border-color: var(--accent); background: rgba(255,107,157,0.05); }
        .offer-card.popular::before { content: 'Populaire'; position: absolute; top: -10px; right: 20px; background: linear-gradient(135deg, var(--accent), var(--accent-secondary)); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

        .slot-option { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.3s ease; }
        .slot-option:hover { border-color: var(--accent); }
        .slot-option.selected { border-color: var(--accent); background: rgba(255,107,157,0.1); }
        .slot-option.unavailable { opacity: 0.5; cursor: not-allowed; }

        .step-indicator { display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 32px; }
        .step-item { display: flex; align-items: center; gap: 8px; }
        .step-number { width: 36px; height: 36px; border-radius: 50%; border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; transition: all 0.3s ease; }
        .step-item.active .step-number { background: var(--accent); border-color: var(--accent); }
        .step-item.completed .step-number { background: var(--success); border-color: var(--success); }
        .step-text { font-size: 14px; color: var(--muted); }
        .step-item.active .step-text { color: var(--fg); font-weight: 500; }
        .step-line { width: 60px; height: 2px; background: var(--border); }

        .summary-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border); }
        .summary-total { font-size: 20px; font-weight: 700; }

        .abonnement-preview { background: rgba(196,76,255,0.1); border: 1px solid rgba(196,76,255,0.3); border-radius: 16px; padding: 20px; margin-top: 20px; }
        .session-tag { display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: rgba(255,255,255,0.05); border-radius: 8px; font-size: 13px; }
        .session-tag.locked { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); }
        .session-tag.available { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); }

        .error-banner { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px; display: flex; align-items: gap-3; }
        .warning-banner { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px; }

        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-secondary); border: 1px solid var(--border); border-radius: 12px; padding: 16px 24px; z-index: 1000; transform: translateX(150%); transition: transform 0.3s ease; display: flex; align-items: center; gap: 12px; }
        .toast.show { transform: translateX(0); }
        .toast.success { border-color: var(--success); }
        .toast.error { border-color: var(--error); }
        .toast.warning { border-color: var(--warning); }

        .gradient-bg { position: fixed; inset: 0; overflow: hidden; z-index: -1; }
        .gradient-orb { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.3; }

        a:focus-visible, button:focus-visible { outline: 2px solid var(--accent); outline-offset: 4px; }

        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.4s ease forwards; }
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
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="font-display text-5xl sm:text-6xl mb-4">RESERVATION</h1>
                <p class="text-[var(--muted)]">Reserve ta seance en quelques etapes simples</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator flex-wrap">
                <div class="step-item active" id="step-indicator-1">
                    <div class="step-number">1</div>
                    <span class="step-text hidden sm:inline">Offre</span>
                </div>
                <div class="step-line hidden sm:block"></div>
                <div class="step-item" id="step-indicator-2">
                    <div class="step-number">2</div>
                    <span class="step-text hidden sm:inline">Creneau</span>
                </div>
                <div class="step-line hidden sm:block"></div>
                <div class="step-item" id="step-indicator-3">
                    <div class="step-number">3</div>
                    <span class="step-text hidden sm:inline">Confirmation</span>
                </div>
            </div>

            <!-- Step 1: Choose Offer -->
            <div id="step-1" class="form-card">
                <h2 class="font-display text-2xl mb-2">CHOISIS TON OFFRE</h2>
                <p class="text-[var(--muted)] text-sm mb-6">Selectionne la formule qui te correspond</p>
                
                <div class="grid md:grid-cols-3 gap-4 mb-8">
                    <div class="offer-card" onclick="selectOffer('decouverte', 10, 1)" id="offer-decouverte">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--accent)] to-[var(--accent-secondary)] flex items-center justify-center mb-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>
                        </div>
                        <h3 class="font-display text-xl mb-1">DECOUVERTE</h3>
                        <p class="text-xs text-[var(--muted)] mb-4">Premiere seance</p>
                        <p class="text-3xl font-bold">10€</p>
                        <p class="text-xs text-[var(--muted)] mt-2">1 seance</p>
                    </div>

                    <div class="offer-card popular" onclick="selectOffer('unitaire', 15, 1)" id="offer-unitaire">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[var(--accent-secondary)] to-indigo-500 flex items-center justify-center mb-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <h3 class="font-display text-xl mb-1">UNITAIRE</h3>
                        <p class="text-xs text-[var(--muted)] mb-4">A la carte</p>
                        <p class="text-3xl font-bold">15€</p>
                        <p class="text-xs text-[var(--muted)] mt-2">1 seance</p>
                    </div>

                    <div class="offer-card" onclick="selectOffer('abonnement', 55, 4)" id="offer-abonnement">
                        <span class="inline-block px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-medium mb-2">-5€</span>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <h3 class="font-display text-xl mb-1">ABONNEMENT</h3>
                        <p class="text-xs text-[var(--muted)] mb-4">4 seances mensuelles</p>
                        <p class="text-3xl font-bold">55€</p>
                        <p class="text-xs text-[var(--muted)] mt-2">4 seances sur 4 semaines</p>
                    </div>
                </div>

                <!-- Offer Info -->
                <div id="offer-info" style="display: none;" class="bg-[var(--card)] border border-[var(--border)] rounded-xl p-4 mb-6 fade-in">
                    <p class="text-sm" id="offer-description"></p>
                </div>

                <button onclick="goToStep(2)" class="btn-primary w-full justify-center" id="btn-step-1" disabled>
                    Continuer
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </div>

            <!-- Step 2: Choose Slot -->
            <div id="step-2" class="form-card" style="display: none;">
                <h2 class="font-display text-2xl mb-2">CHOISIS TON CRENEAU</h2>
                <p class="text-[var(--muted)] text-sm mb-6" id="slot-subtitle">Selectionne un creneau disponible</p>

                <!-- Error Banner -->
                <div id="error-banner" style="display: none;" class="error-banner">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--error)" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <p id="error-message" class="text-sm text-[var(--error)]"></p>
                </div>

                <!-- Warning for abonnement -->
                <div id="abonnement-warning" style="display: none;" class="warning-banner">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--warning)" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <div>
                        <p class="text-sm text-[var(--warning)] font-medium">Abonnement : Selection du premier creneau uniquement</p>
                        <p class="text-xs text-[var(--muted)] mt-1">Les 3 seances suivantes seront generees automatiquement sur le meme jour et la meme heure les 3 semaines consecutives.</p>
                    </div>
                </div>
                
                <div class="space-y-3 mb-8" id="slots-container">
                    <!-- Filled by JS -->
                </div>

                <!-- Abonnement Preview -->
                <div id="abonnement-preview" style="display: none;" class="abonnement-preview">
                    <h3 class="font-semibold mb-3 flex items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-secondary)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Apercu de votre abonnement
                    </h3>
                    <div id="sessions-preview" class="space-y-2">
                        <!-- Filled by JS -->
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button onclick="goToStep(1)" class="btn-secondary flex-1 justify-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Retour
                    </button>
                    <button onclick="goToStep(3)" class="btn-primary flex-1 justify-center" id="btn-step-2" disabled>
                        Continuer
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </div>

            <!-- Step 3: Confirmation & Payment -->
            <div id="step-3" class="form-card" style="display: none;">
                <h2 class="font-display text-2xl mb-6">CONFIRMATION</h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Summary -->
                    <div>
                        <h3 class="font-semibold mb-4">Recapitulatif</h3>
                        <div class="bg-[var(--card)] rounded-xl p-6">
                            <div class="summary-item">
                                <span class="text-[var(--muted)]">Offre</span>
                                <span id="summary-offer" class="font-medium">-</span>
                            </div>
                            <div id="summary-sessions-container">
                                <!-- Filled by JS for abonnement -->
                            </div>
                            <div class="summary-item">
                                <span class="text-[var(--muted)]">Premiere seance</span>
                                <span id="summary-date">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="text-[var(--muted)]">Horaire</span>
                                <span id="summary-time">-</span>
                            </div>
                            <div class="summary-item border-none">
                                <span class="text-[var(--muted)]">Lieu</span>
                                <span class="text-right text-sm">63 BD Stalingrad<br>Vitry-sur-Seine</span>
                            </div>
                            <div class="mt-6 pt-4 border-t border-[var(--border)]">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">Total</span>
                                    <span class="summary-total text-[var(--accent)]" id="summary-total">0€</span>
                                </div>
                            </div>
                        </div>

                        <!-- Locked sessions info for abonnement -->
                        <div id="locked-info" style="display: none;" class="mt-4 p-4 bg-[rgba(239,68,68,0.1)] border border-[rgba(239,68,68,0.3)] rounded-xl">
                            <p class="text-sm text-[var(--error)]">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="inline mr-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Les seances d'abonnement sont verrouillees et ne peuvent pas etre modifiees ou annulees.
                            </p>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div>
                        <h3 class="font-semibold mb-4">Paiement securise</h3>
                        <div class="bg-[var(--card)] rounded-xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex gap-2">
                                    <svg width="40" height="24" viewBox="0 0 40 24" fill="none">
                                        <rect width="40" height="24" rx="4" fill="#635BFF"/>
                                        <text x="20" y="16" text-anchor="middle" fill="white" font-size="10" font-weight="bold">stripe</text>
                                    </svg>
                                </div>
                                <span class="text-xs text-[var(--muted)]">Paiement 100% securise</span>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="form-label">Numero de carte</label>
                                    <input type="text" class="form-input" placeholder="4242 4242 4242 4242" id="card-number" maxlength="19">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="form-label">Expiration</label>
                                        <input type="text" class="form-input" placeholder="MM/AA" id="card-expiry" maxlength="5">
                                    </div>
                                    <div>
                                        <label class="form-label">CVC</label>
                                        <input type="text" class="form-input" placeholder="123" id="card-cvc" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs text-[var(--muted)] mt-4">
                            En confirmant, vous acceptez nos <a href="#" class="text-[var(--accent)] hover:underline">conditions generales</a> et <a href="#" class="text-[var(--accent)] hover:underline">politique d'annulation</a>.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button onclick="goToStep(2)" class="btn-secondary flex-1 justify-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Retour
                    </button>
                    <button onclick="processPayment()" class="btn-primary flex-1 justify-center" id="btn-pay">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        Payer <span id="pay-amount">0€</span>
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            <div id="success-message" class="form-card text-center" style="display: none;">
                <div class="w-20 h-20 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-6">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h2 class="font-display text-3xl mb-4">RESERVATION CONFIRMEE</h2>
                <p class="text-[var(--muted)] mb-8">Votre reservation a ete enregistree avec succes. Un email de confirmation vous a ete envoye.</p>
                
                <div class="bg-[var(--card)] rounded-xl p-6 text-left mb-8">
                    <h3 class="font-semibold mb-4">Details de la reservation</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-[var(--muted)]">Numero :</span> <span id="reservation-id" class="font-mono">-</span></p>
                        <p><span class="text-[var(--muted)]">Offre :</span> <span id="reservation-offer">-</span></p>
                        <div id="reservation-sessions-list"></div>
                        <p><span class="text-[var(--muted)]">Lieu :</span> 63 BD Stalingrad, Vitry-sur-Seine, 94400</p>
                    </div>
                </div>

                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="dashboard-client.php" class="btn-primary">Mon espace</a>
                    <a href="index.php" class="btn-secondary">Retour a l'accueil</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Toast -->
    <div id="toast" class="toast">
        <svg id="toast-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"></svg>
        <p id="toast-message"></p>
    </div>

    <script>
        // ===== DATA & STATE =====
        const availableSlots = [
            { id: 1, dayIndex: 1, dayName: 'Lundi', date: '20 Janvier', fullDate: new Date('2025-01-20'), time: '18:00', endTime: '19:00', places: 8, maxPlaces: 10 },
            { id: 2, dayIndex: 3, dayName: 'Mercredi', date: '22 Janvier', fullDate: new Date('2025-01-22'), time: '10:00', endTime: '11:00', places: 5, maxPlaces: 10 },
            { id: 3, dayIndex: 3, dayName: 'Mercredi', date: '22 Janvier', fullDate: new Date('2025-01-22'), time: '18:00', endTime: '19:00', places: 7, maxPlaces: 10 },
            { id: 4, dayIndex: 5, dayName: 'Vendredi', date: '24 Janvier', fullDate: new Date('2025-01-24'), time: '18:00', endTime: '19:00', places: 2, maxPlaces: 10 },
            { id: 5, dayIndex: 6, dayName: 'Samedi', date: '25 Janvier', fullDate: new Date('2025-01-25'), time: '10:00', endTime: '11:00', places: 0, maxPlaces: 10 },
            { id: 6, dayIndex: 6, dayName: 'Samedi', date: '25 Janvier', fullDate: new Date('2025-01-25'), time: '14:00', endTime: '15:00', places: 4, maxPlaces: 10 },
            { id: 7, dayIndex: 7, dayName: 'Dimanche', date: '26 Janvier', fullDate: new Date('2025-01-26'), time: '10:00', endTime: '11:00', places: 6, maxPlaces: 10 },
            { id: 8, dayIndex: 7, dayName: 'Dimanche', date: '26 Janvier', fullDate: new Date('2025-01-26'), time: '14:00', endTime: '15:00', places: 3, maxPlaces: 10 },
        ];

        // Merge admin-managed slots from localStorage and server so admin additions are available for reservation
        (function mergeAdminSlotsIntoAvailable() {
            const fullDays = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];

            function nextDateForDay(dayIndex) {
                const today = new Date();
                // convert 1..7 (Mon..Sun) to JS 1..0..6 where Sunday=0
                const targetJsDay = (dayIndex % 7);
                const delta = (targetJsDay - today.getDay() + 7) % 7;
                const d = new Date(today);
                d.setDate(today.getDate() + (delta === 0 ? 0 : delta));
                return d;
            }

            // helper to push slot if not already present
            function pushIfNew(slot) {
                if (!availableSlots.find(s => String(s.id) === String(slot.id) && s.time === slot.time && ((s.fullDate && slot.fullDate && s.fullDate.toDateString() === slot.fullDate.toDateString()) || s.date === slot.date))) {
                    availableSlots.push(slot);
                }
            }

            // merge from localStorage admin slots
            try {
                const adminSlots = JSON.parse(localStorage.getItem('mna_slots') || '[]');
                if (Array.isArray(adminSlots) && adminSlots.length) {
                    adminSlots.forEach(s => {
                        if (s.kind === 'recurring') {
                            const d = nextDateForDay(Number(s.day) || 1);
                            const dayIdx = d.getDay() === 0 ? 7 : d.getDay();
                            pushIfNew({
                                id: s.id,
                                dayIndex: dayIdx,
                                dayName: fullDays[dayIdx % 7],
                                date: d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                                fullDate: d,
                                time: s.time || s.start || '18:00',
                                endTime: s.endTime || '',
                                places: s.places || s.capacity || 10,
                                maxPlaces: s.capacity || s.max || 10
                            });
                        } else if (s.kind === 'single' && s.date) {
                            const d = new Date(s.date);
                            const dayIdx = d.getDay() === 0 ? 7 : d.getDay();
                            pushIfNew({
                                id: s.id,
                                dayIndex: dayIdx,
                                dayName: fullDays[dayIdx % 7],
                                date: d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                                fullDate: d,
                                time: s.time || '18:00',
                                endTime: '',
                                places: s.places || s.capacity || 10,
                                maxPlaces: s.capacity || s.max || 10
                            });
                        }
                    });
                }
            } catch (e) { console.warn('Could not merge admin local slots into reservation:', e); }

            // try to merge server-side slots (public endpoint)
            try {
                fetch('slots_list.php').then(r => r.ok ? r.json() : []).then(rows => {
                    if (!Array.isArray(rows)) return;
                    rows.forEach(row => {
                        const kind = row.kind || 'recurring';
                        const capacity = row.capacity || row.max || 10;
                        if (kind === 'recurring' && row.day) {
                            const next = nextDateForDay(Number(row.day));
                            const dayIdx = next.getDay() === 0 ? 7 : next.getDay();
                            pushIfNew({
                                id: row.id,
                                dayIndex: dayIdx,
                                dayName: fullDays[dayIdx % 7],
                                date: next.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                                fullDate: next,
                                time: row.time || '18:00',
                                endTime: '',
                                places: capacity,
                                maxPlaces: capacity
                            });
                        } else if (kind === 'single' && row.date) {
                            const d = new Date(row.date);
                            const dayIdx = d.getDay() === 0 ? 7 : d.getDay();
                            pushIfNew({
                                id: row.id,
                                dayIndex: dayIdx,
                                dayName: fullDays[dayIdx % 7],
                                date: d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' }),
                                fullDate: d,
                                time: row.time || '18:00',
                                endTime: '',
                                places: capacity,
                                maxPlaces: capacity
                            });
                        }
                    });
                }).catch(err => console.warn('Could not fetch server slots for reservation:', err));
            } catch (e) { /* ignore */ }
        })();

        let currentStep = 1;
        let selectedOffer = null;
        let selectedPrice = 0;
        let selectedSessions = 1;
        let selectedSlot = null;
        let generatedSessions = [];

        // ===== URL PARAMS =====
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        if (typeParam) {
            const offerConfig = { 
                decouverte: { price: 10, sessions: 1 }, 
                unitaire: { price: 15, sessions: 1 }, 
                abonnement: { price: 55, sessions: 4 } 
            };
            if (offerConfig[typeParam]) {
                selectOffer(typeParam, offerConfig[typeParam].price, offerConfig[typeParam].sessions);
            }
        }

        // ===== OFFER SELECTION =====
        function selectOffer(offer, price, sessions) {
            selectedOffer = offer;
            selectedPrice = price;
            selectedSessions = sessions;
            
            document.querySelectorAll('.offer-card').forEach(card => card.classList.remove('selected'));
            const selectedCard = document.getElementById('offer-' + offer);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }
            
            document.getElementById('btn-step-1').disabled = false;
            
            // Show offer info
            const offerInfo = document.getElementById('offer-info');
            const offerDesc = document.getElementById('offer-description');
            offerInfo.style.display = 'block';
            
            const descriptions = {
                decouverte: 'Decouvre notre approche avec une seance d\'initiation. Ideal pour debuter.',
                unitaire: 'Une seance a la carte pour travailler vos objectifs specifiques.',
                abonnement: '4 seances sur 4 semaines consecutives. Vous choisissez le premier creneau, les 3 suivants sont generes automatiquement (meme jour, meme heure).'
            };
            offerDesc.textContent = descriptions[offer];
        }

        // ===== SLOT RENDERING =====
        function renderSlots() {
            const container = document.getElementById('slots-container');
            
            // Update subtitle based on offer
            const subtitle = document.getElementById('slot-subtitle');
            const warning = document.getElementById('abonnement-warning');
            
            if (selectedOffer === 'abonnement') {
                subtitle.textContent = 'Selectionnez votre premier creneau (les 3 suivants seront generees automatiquement)';
                warning.style.display = 'flex';
            } else {
                subtitle.textContent = 'Selectionnez un creneau disponible';
                warning.style.display = 'none';
            }

            // Group slots by day
            const groupedSlots = {};
            availableSlots.forEach(slot => {
                if (!groupedSlots[slot.dayName]) {
                    groupedSlots[slot.dayName] = [];
                }
                groupedSlots[slot.dayName].push(slot);
            });

            let html = '';
            Object.entries(groupedSlots).forEach(([dayName, slots]) => {
                html += `<div class="mb-4">
                    <p class="text-sm text-[var(--muted)] mb-2 font-medium">${dayName}</p>
                    <div class="grid sm:grid-cols-2 gap-3">
                        ${slots.map(slot => {
                            const isUnavailable = slot.places === 0;
                            const statusClass = slot.places === 0 ? 'unavailable' : '';
                            const placesText = slot.places === 0 ? 'Complet' : 
                                              slot.places <= 3 ? `${slot.places} places restantes` : 
                                              `${slot.places} places`;
                            const placesClass = slot.places === 0 ? 'text-red-400' : 
                                               slot.places <= 3 ? 'text-yellow-400' : 'text-green-400';
                            
                            return `
                                <div class="slot-option ${statusClass}" 
                                     onclick="${isUnavailable ? `showToast('Ce creneau est complet', 'error')` : `selectSlot(${slot.id})`}"
                                     id="slot-${slot.id}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium">${slot.time} - ${slot.endTime}</p>
                                            <p class="text-xs text-[var(--muted)]">${slot.date}</p>
                                        </div>
                                        <span class="text-xs font-medium ${placesClass}">${placesText}</span>
                                    </div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>`;
            });

            container.innerHTML = html;
        }

        function selectSlot(id) {
            const slot = availableSlots.find(s => s.id === id);
            if (!slot || slot.places === 0) return;

            selectedSlot = slot;
            
            document.querySelectorAll('.slot-option').forEach(opt => opt.classList.remove('selected'));
            document.getElementById('slot-' + id).classList.add('selected');
            
            // Hide error banner
            document.getElementById('error-banner').style.display = 'none';
            
            // For abonnement, generate and validate sessions
            if (selectedOffer === 'abonnement') {
                const validation = generateAbonnementSessions(slot);
                if (!validation.valid) {
                    document.getElementById('error-banner').style.display = 'flex';
                    document.getElementById('error-message').textContent = validation.message;
                    document.getElementById('btn-step-2').disabled = true;
                    document.getElementById('abonnement-preview').style.display = 'none';
                    return;
                }
                showAbonnementPreview();
            } else {
                document.getElementById('abonnement-preview').style.display = 'none';
            }
            
            document.getElementById('btn-step-2').disabled = false;
        }

        // ===== ABONNEMENT SESSIONS GENERATION =====
        function generateAbonnementSessions(firstSlot) {
            generatedSessions = [firstSlot];
            
            const dayIndex = firstSlot.dayIndex;
            const time = firstSlot.time;
            const endTime = firstSlot.endTime;
            
            // Find 3 consecutive weeks
            for (let week = 1; week <= 3; week++) {
                const nextDate = new Date(firstSlot.fullDate);
                nextDate.setDate(nextDate.getDate() + (week * 7));
                
                const dateStr = nextDate.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' });
                const dayName = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'][nextDate.getDay()];
                
                // Simulate availability check (in real app, this would be an API call)
                const simulatedPlaces = Math.floor(Math.random() * 10);
                
                // Check if slot exists and has capacity
                const existingSlot = availableSlots.find(s => 
                    s.dayIndex === dayIndex && 
                    s.time === time &&
                    s.fullDate.toDateString() === nextDate.toDateString()
                );
                
                if (existingSlot && existingSlot.places === 0) {
                    return {
                        valid: false,
                        message: `Le creneau du ${dayName} ${dateStr} a ${time} est complet. Veuillez choisir un autre creneau.`
                    };
                }
                
                // Simulate random unavailability for demo
                if (week === 2 && Math.random() > 0.7) {
                    return {
                        valid: false,
                        message: `Le creneau du ${dayName} ${dateStr} n'est pas disponible. Veuillez choisir un autre jour ou horaire.`
                    };
                }
                
                generatedSessions.push({
                    id: firstSlot.id + 100 + week,
                    dayIndex: dayIndex,
                    dayName: dayName,
                    date: dateStr,
                    fullDate: nextDate,
                    time: time,
                    endTime: endTime,
                    places: simulatedPlaces,
                    maxPlaces: 10,
                    locked: true,
                    weekNumber: week + 1
                });
            }
            
            return { valid: true };
        }

        function showAbonnementPreview() {
            const preview = document.getElementById('abonnement-preview');
            const sessionsContainer = document.getElementById('sessions-preview');
            
            sessionsContainer.innerHTML = generatedSessions.map((session, index) => `
                <div class="session-tag ${index > 0 ? 'locked' : 'available'}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        ${index === 0 ? 
                            '<circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/>' : 
                            '<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'}
                    </svg>
                    <span>Seance ${index + 1}: ${session.dayName} ${session.date} - ${session.time}</span>
                    ${index > 0 ? '<span class="text-xs text-[var(--error)]">(Verrouillee)</span>' : ''}
                </div>
            `).join('');
            
            preview.style.display = 'block';
        }

        // ===== STEP NAVIGATION =====
        function goToStep(step) {
            // Hide current step
            document.getElementById('step-' + currentStep).style.display = 'none';
            
            // Update indicators
            const currentIndicator = document.getElementById('step-indicator-' + currentStep);
            currentIndicator.classList.remove('active');
            if (step > currentStep) {
                currentIndicator.classList.add('completed');
            } else {
                currentIndicator.classList.remove('completed');
            }

            currentStep = step;
            
            // Show new step
            document.getElementById('step-' + currentStep).style.display = 'block';
            const newIndicator = document.getElementById('step-indicator-' + currentStep);
            newIndicator.classList.add('active');
            newIndicator.classList.remove('completed');

            if (step === 2) {
                renderSlots();
            }

            if (step === 3) {
                updateSummary();
            }

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateSummary() {
            const offerNames = { 
                decouverte: 'Seance Decouverte', 
                unitaire: 'Seance Unitaire', 
                abonnement: 'Abonnement 4 seances' 
            };
            
            document.getElementById('summary-offer').textContent = offerNames[selectedOffer];
            document.getElementById('summary-date').textContent = selectedSlot ? selectedSlot.date : '-';
            document.getElementById('summary-time').textContent = selectedSlot ? `${selectedSlot.time} - ${selectedSlot.endTime}` : '-';
            document.getElementById('summary-total').textContent = selectedPrice + '€';
            document.getElementById('pay-amount').textContent = selectedPrice + '€';
            
            // Show locked info for abonnement
            const lockedInfo = document.getElementById('locked-info');
            const sessionsContainer = document.getElementById('summary-sessions-container');
            
            if (selectedOffer === 'abonnement') {
                lockedInfo.style.display = 'block';
                sessionsContainer.innerHTML = `
                    <div class="summary-item">
                        <span class="text-[var(--muted)]">Seances</span>
                        <div class="text-right text-sm">
                            ${generatedSessions.map((s, i) => `
                                <div class="${i > 0 ? 'text-[var(--muted)]' : ''}">${s.dayName} ${s.date} ${i > 0 ? '(verrouillee)' : ''}</div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                lockedInfo.style.display = 'none';
                sessionsContainer.innerHTML = '';
            }
        }

        // ===== PAYMENT =====
        function processPayment() {
            const cardNumber = document.getElementById('card-number').value;
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvc = document.getElementById('card-cvc').value;

            if (!cardNumber || !cardExpiry || !cardCvc) {
                showToast('Veuillez remplir tous les champs de paiement', 'error');
                return;
            }

            if (cardNumber.replace(/\s/g, '').length < 16) {
                showToast('Numero de carte invalide', 'error');
                return;
            }

            const payBtn = document.getElementById('btn-pay');
            payBtn.disabled = true;
            payBtn.innerHTML = `
                <svg class="animate-spin" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 0 1 10 10" stroke-opacity="1"/>
                </svg>
                Traitement...
            `;

            // Simulate payment processing
            setTimeout(() => {
                // Create reservation(s)
                const reservationId = 'MNA-' + Date.now();
                const reservation = {
                    id: reservationId,
                    offer: selectedOffer,
                    price: selectedPrice,
                    sessions: selectedOffer === 'abonnement' ? generatedSessions : [selectedSlot],
                    slot: selectedSlot,
                    date: new Date().toISOString(),
                    status: 'confirmed',
                    locked: selectedOffer === 'abonnement'
                };

                const reservations = JSON.parse(localStorage.getItem('mna_reservations') || '[]');
                reservations.push(reservation);
                localStorage.setItem('mna_reservations', JSON.stringify(reservations));

                // Show success
                document.getElementById('step-3').style.display = 'none';
                document.getElementById('success-message').style.display = 'block';
                
                document.getElementById('reservation-id').textContent = reservationId;
                document.getElementById('reservation-offer').textContent = 
                    selectedOffer === 'abonnement' ? 'Abonnement 4 seances' : 
                    selectedOffer === 'decouverte' ? 'Seance Decouverte' : 'Seance Unitaire';
                
                // Show all sessions for abonnement
                const sessionsList = document.getElementById('reservation-sessions-list');
                if (selectedOffer === 'abonnement') {
                    sessionsList.innerHTML = generatedSessions.map((s, i) => `
                        <p><span class="text-[var(--muted)]">Seance ${i + 1}:</span> ${s.dayName} ${s.date} a ${s.time} ${i > 0 ? '<span class="text-xs text-[var(--error)]">(verrouillee)</span>' : ''}</p>
                    `).join('');
                } else {
                    sessionsList.innerHTML = `<p><span class="text-[var(--muted)]">Date:</span> ${selectedSlot.dayName} ${selectedSlot.date} a ${selectedSlot.time}</p>`;
                }

                showToast('Paiement reussi !', 'success');
            }, 2500);
        }

        // ===== CARD FORMATTING =====
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formatted;
        });

        document.getElementById('card-expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            e.target.value = value;
        });

        // ===== TOAST =====
        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            
            toast.className = 'toast ' + type;
            toastMessage.textContent = message;
            
            // Set icon based on type
            if (type === 'success') {
                toastIcon.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            } else if (type === 'error') {
                toastIcon.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>';
            } else {
                toastIcon.innerHTML = '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
            }
            
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        // ===== AUTH CHECK =====
        const currentUser = localStorage.getItem('mna_user');
        if (!window.__MNA_SERVER_USER && currentUser) {
            const user = JSON.parse(currentUser);
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