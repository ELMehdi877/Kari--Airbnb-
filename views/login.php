<?php
session_start();
$password = password_hash('123',PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay | Connexion Privée</title>
    
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

        /* --- NOUVELLE ANIMATION D'OUVERTURE (RIDEAUX) --- */
        
        /* L'image qui dézoome au chargement */
        @keyframes imageZoomOut {
            0% { transform: scale(1.3); opacity: 0; }
            100% { transform: scale(1); opacity: 0.5; }
        }

        /* Les deux panneaux qui s'écartent */
        @keyframes curtainLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        @keyframes curtainRight {
            0% { transform: translateX(0); }
            100% { transform: translateX(100%); }
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

        /* Apparition du formulaire */
        .glass-auth {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            opacity: 0;
            animation: formFadeIn 1.2s ease 1.8s forwards;
            z-index: 10;
        }

        @keyframes formFadeIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* --- STYLES INPUTS & BOUTON --- */
        input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.4s ease;
        }
        input:focus { border-color: var(--accent) !important; background: rgba(255, 255, 255, 0.1) !important; outline: none; }

        .btn-luxe {
            position: relative; overflow: hidden; z-index: 1;
            transition: transform 0.3s ease;
        }
        .btn-luxe::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 0;
            background: var(--accent); transition: all 0.5s cubic-bezier(0.7, 0, 0.2, 1); z-index: -1;
        }
        .btn-luxe:hover::after { height: 100%; }
        .btn-luxe:hover { transform: translateY(-2px); }
    </style>
</head>
<body>

    <!-- RIDEAUX D'OUVERTURE (Z-INDEX 100) -->
    <div class="curtain curtain-l"></div>
    <div class="curtain curtain-r"></div>

    <!-- IMAGE DE FOND -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&q=80&w=2070" 
             class="w-full h-full object-cover img-bg" alt="Luxury Mansion">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-transparent to-black"></div>
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

    <!-- CARD CONNEXION -->
    <main class="relative z-10 w-full max-w-[460px] px-6">
        <div class="glass-auth p-10 md:p-14 rounded-[3rem] shadow-2xl">
            
            <div class="text-center mb-12">
                <h1 class="serif text-5xl mb-4 italic">Bienvenue.</h1>
                <p class="text-[10px] uppercase tracking-[0.5em] text-white/30 font-bold">Cercle Privé LuxeStay</p>
                <?php
                    if (!empty($_SESSION["message"])) {
                        echo $_SESSION["message"];
                        unset($_SESSION["message"]);
                    }
                ?>
            </div>

            <form class="space-y-6" method="POST" action="./../login_process.php">
                <div class="space-y-2">
                    <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold ml-1">Email Personnel</label>
                    <input type="email" name="email" required placeholder="nom@prestige.com" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20">
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-[10px] uppercase tracking-widest text-white/50 font-bold">Code d'accès</label>
                        <a href="#" class="text-[9px] uppercase tracking-widest text-rose-500 font-bold">Oublié ?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••••••" class="w-full p-4 rounded-2xl text-sm placeholder:text-white/20">
                </div>

                <button type="submit" class="w-full py-5 bg-white text-black font-bold rounded-2xl text-[10px] uppercase tracking-[0.3em] btn-luxe shadow-xl mt-6">
                    S'identifier
                </button>
            </form>

            <div class="mt-12 text-center">
                <p class="text-[11px] text-white/20 mb-8 uppercase tracking-[0.3em]">Authentification sécurisée</p>
                <p class="text-[11px] text-white/40">
                    Pas encore membre ? 
                    <a href="./register.php" class="text-white font-bold border-b border-rose-600 pb-1 ml-1">Crée un compte</a>
                </p>
            </div>

        </div>
    </main>

    <script>
        // Fallback si l'image ne charge pas
        document.querySelector('img').onerror = function() {
            this.style.display = 'none';
            document.body.style.background = "#0a0a0a";
        };
    </script>
</body>
</html>