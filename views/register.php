<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay | Créer un Accès Privé</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --accent: #e11d48; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #000; 
            margin: 0; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; color: white;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }

        /* --- ANIMATION RIDEAUX (IDENTIQUE LOGIN) --- */
        @keyframes curtainLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        @keyframes curtainRight {
            0% { transform: translateX(0); }
            100% { transform: translateX(100%); }
        }
        @keyframes imageZoomOut {
            0% { transform: scale(1.3); opacity: 0; }
            100% { transform: scale(1); opacity: 0.5; }
        }

        .curtain {
            position: fixed; top: 0; width: 50.5%; height: 100%;
            background: #050505; z-index: 100; pointer-events: none;
        }
        .curtain-l { left: 0; animation: curtainLeft 1.8s cubic-bezier(0.77, 0, 0.175, 1) 0.5s forwards; }
        .curtain-r { right: 0; animation: curtainRight 1.8s cubic-bezier(0.77, 0, 0.175, 1) 0.5s forwards; }

        .img-bg {
            animation: imageZoomOut 2.5s cubic-bezier(0.7, 0, 0.2, 1) forwards;
        }

        /* Apparition progressive du formulaire */
        .glass-auth {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            opacity: 0;
            animation: formFadeIn 1.2s ease 1.8s forwards;
            z-index: 10;
        }

        @keyframes formFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- INPUTS & BOUTONS --- */
        input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.4s ease;
        }
        input:focus { border-color: var(--accent) !important; background: rgba(255, 255, 255, 0.1) !important; outline: none; }

        .btn-luxe {
            position: relative; overflow: hidden; z-index: 1;
        }
        .btn-luxe::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 0;
            background: var(--accent); transition: all 0.5s cubic-bezier(0.7, 0, 0.2, 1); z-index: -1;
        }
        .btn-luxe:hover::after { height: 100%; }
    </style>
</head>
<body>

    <!-- RIDEAUX D'OUVERTURE -->
    <div class="curtain curtain-l"></div>
    <div class="curtain curtain-r"></div>

    <!-- IMAGE DE FOND (Intérieur de luxe) -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&q=80&w=2070" 
             class="w-full h-full object-cover img-bg" alt="Luxury Interior">
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black"></div>
    </div>

    <!-- NAVBAR LOGO -->
    <nav class="fixed top-0 w-full z-50 px-10 py-8 flex justify-between items-center">
        <div class="flex items-center gap-2 cursor-pointer" onclick="window.history.back()">
            <div class="w-10 h-10 bg-rose-600 rounded-full flex items-center justify-center text-white shadow-2xl">
                <i class="fa-solid fa-crown text-xs"></i>
            </div>
            <span class="text-2xl font-bold tracking-tighter uppercase text-white">LuxeStay</span>
        </div>
        <a href="./../index.html" class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/40 hover:text-white transition">Accueil</a>
    </nav>

    <!-- CARD INSCRIPTION -->
    <main class="relative z-10 w-full max-w-[500px] px-6">
        <div class="glass-auth p-10 md:p-12 rounded-[3rem] shadow-2xl">
            
            <div class="text-center mb-10">
                <h1 class="serif text-5xl mb-3 italic">Rejoindre.</h1>
                <p class="text-[10px] uppercase tracking-[0.5em] text-white/30 font-bold">L'exception à votre portée</p>
                <?php
                    if (!empty($_SESSION["message"])) {
                        echo $_SESSION["message"];
                        unset($_SESSION["message"]);
                    }
                ?>
            </div>

            <form class="space-y-5" method="POST" action="./../register_process.php">
                <!-- Nom Complet -->
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold ml-1">Nom Complet</label>
                    <input type="text" required name="fullname" placeholder="Jean de Luxe" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20">
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold ml-1">Adresse Email</label>
                    <input type="email" required name="email" placeholder="nom@prestige.com" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20">
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold ml-1">Choix du Role</label>
                    <!-- <input type="email" placeholder="nom@prestige.com" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20"> -->
                    <select name="role" required class="w-full bg-white/5 p-4 rounded-2xl text-sm text-white">
                        <option value="" disabled selected>Role</option>
                        <option value="Hote" desible>Hote</option>
                        <option value="voyageur" desible>Voyageur</option>
                    </select>
                </div>

                <!-- Mot de passe -->
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold ml-1">Créer un mot de passe</label>
                    <input type="password" required name="password" placeholder="••••••••••••" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20">
                </div>

                <!-- Bouton Validation -->
                <button type="submit" name="sign_up" class="w-full py-5 bg-white text-black font-bold rounded-2xl text-[10px] uppercase tracking-[0.3em] btn-luxe shadow-xl mt-6">
                    Créer mon accès
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-[11px] text-white/40">
                    Déjà membre du cercle ? 
                    <a href="./login.php" class="text-white font-bold border-b border-rose-600 pb-1 ml-1">Connexion</a>
                </p>
            </div>

        </div>
    </main>

    <script>
        // Fallback image
        document.querySelector('img').onerror = function() {
            this.style.display = 'none';
            document.body.style.background = "#050505";
        };
    </script>
</body>
</html>