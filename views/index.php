<?php 
require_once __DIR__ . "/../repositories/LogementRepository.php";
require_once __DIR__ ."/../config/database.php";

session_start();
if (!isset($_SESSION["user_id"])) { 
    header("Location: ./../index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb Concept - Like sans JS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-card { opacity: 0; animation: fadeInUp 0.6s ease-out forwards; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white">

    <!-- SIDEBAR (Visible seulement sur Desktop lg:flex) -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r hidden lg:flex flex-col z-[60]">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center gap-1 border-b">
            <i class="fa-brands fa-airbnb"></i>
            <span class="tracking-tighter">airbnb</span>
        </div>
        <?php
            if (!empty($_SESSION["role"])) {
                if ($_SESSION["role"] === "Hote") {
                    echo '<nav class="flex-1 p-4 space-y-2 mt-4">
                        <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>
                        <a href="index.php" class="flex items-center gap-3 p-3 text-rose-500 bg-rose-50 rounded-lg transition font-bold">
                            <i class="fa-solid fa-house w-5"></i> Accueil
                        </a>
                        
                        <a href="logementsHost.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-list-check w-5"></i> Mes annonces
                        </a>
                        <a href="reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-calendar-check w-5"></i> Réservations
                        </a>
                        <hr class="my-4">
                        
                        <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

                        <a href="host-dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-plus-circle w-5"></i> Ajouter un logement
                        </a>

                        <a href="profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-user w-5"></i> Mon Profil
                        </a>
                            
                    </nav>';
                }
                elseif($_SESSION["role"] === "voyageur"){
                    echo '<nav class="flex-1 p-4 space-y-2 mt-4">
                        <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-house w-5"></i> Accueil
                        </a>
                        <a href="reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
                        </a>
                        <a href="favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-heart w-5"></i> Favoris
                        </a>
                        <a href="profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-user w-5"></i> Mon Profil
                        </a>            
                    </nav>';
                }
            }
        ?>
        <form action="logout.php" method="POST" class="p-4 border-t">
            <button name="logout" class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-lg transition font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
            </button>
        </form>
    </aside>

    <!-- WRAPPER PRINCIPAL (On ajoute lg:ml-64 pour laisser la place à la sidebar) -->
    <div class="lg:ml-64 transition-all duration-300">

        <!-- HEADER -->
        <header class="sticky top-0 z-50 bg-white border-b px-6 py-4 flex items-center justify-between">
            <!-- Logo (Caché sur desktop car déjà dans la sidebar) -->
            <div class="text-rose-500 text-3xl font-bold flex items-center gap-1 cursor-pointer lg:invisible">
                <i class="fa-brands fa-airbnb"></i>
                <span class="hidden md:inline tracking-tighter">airbnb</span>
            </div>

            <?php
                if (!empty($_SESSION["message"])) {
                    echo $_SESSION["message"];
                    unset($_SESSION["message"]);
                }
            ?>
            <!-- Menu Desktop Search -->
            <div class="hidden md:flex border rounded-full px-4 py-2 shadow-sm hover:shadow-md transition cursor-pointer gap-4 items-center">
                <span class="text-sm font-semibold">N'importe où</span>
                <span class="border-l h-4"></span>
                <span class="text-sm font-semibold">Une semaine</span>
                <span class="border-l h-4"></span>
                <span class="text-sm text-gray-500">Ajouter...</span>
                <div class="bg-rose-500 text-white p-2 rounded-full"><i class="fa-solid fa-magnifying-glass text-xs"></i></div>
            </div>

            <!-- Bouton Menu Mobile/User -->
            <button onclick="toggleMobileMenu()" class="flex items-center gap-3 border p-2 px-3 rounded-full hover:shadow-md transition">
                <i class="fa-solid fa-bars text-gray-600"></i>
                <div class="bg-gray-500 text-white rounded-full w-7 h-7 flex items-center justify-center">
                    <i class="fa-solid fa-user text-[10px]"></i>
                </div>
            </button>
        </header>

        <!-- MENU MOBILE OVERLAY (Reste inchangé) -->
        <div id="mobileMenu" class="fixed inset-0 z-[70] hidden">
            <div class="absolute inset-0 bg-black/50" onclick="toggleMobileMenu()"></div>
            <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-xl p-6">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="font-bold text-xl">Menu</h2>
                    <button onclick="toggleMobileMenu()"><i class="fa-solid fa-xmark text-2xl"></i></button>
                </div>
                <nav class="flex flex-col gap-6 font-medium text-lg">
                    <a href="index.php" class="hover:text-rose-500">Accueil</a>
                    <a href="#" class="hover:text-rose-500">Inscription</a>
                    <a href="#" class="hover:text-rose-500">Connexion</a>
                    <hr>
                    <a href="#" class="text-base text-gray-600">Mettre mon logement</a>
                    <a href="#" class="text-base text-gray-600">Aide</a>
                </nav>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="flex overflow-x-auto no-scrollbar gap-8 px-6 md:px-16 py-4 bg-white sticky top-[73px] z-40 border-b">
            <div class="flex flex-col items-center gap-2 border-b-2 border-black pb-2 min-w-max">
                <i class="fa-solid fa-umbrella-beach text-xl"></i>
                <span class="text-xs font-bold">Plages</span>
            </div>
            <div class="flex flex-col items-center gap-2 text-gray-500 hover:text-black pb-2 min-w-max cursor-pointer">
                <i class="fa-solid fa-mountain text-xl"></i>
                <span class="text-xs font-bold">Montagne</span>
            </div>
            <div class="flex flex-col items-center gap-2 text-gray-500 hover:text-black pb-2 min-w-max cursor-pointer">
                <i class="fa-solid fa-campground text-xl"></i>
                <span class="text-xs font-bold">Camping</span>
            </div>
        </div>

        <!-- GRID LOGEMENTS -->
        <main class="px-6 md:px-16 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                
                <?php
                    $pdo = Database::connect();
                    $logeRepo = new LogementRepository($pdo);
                    $resultat = $logeRepo->afficheLogement();

                    foreach($resultat as $logement){
                        $statut = $logement["statut"];
                        if ($statut === 0) {
                            $disponibiliter = " occupé";
                            $color = "text-red-500";
                        }
                        else{
                            $disponibiliter = "disponible";
                            $color = "text-green-500";

                        }
                        echo '
                        <!-- LOGEMENT -->
                        <div class="animate-card" style="animation-delay: 0.1s;">
                            <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-sm">
                                
                                <!-- FORMULAIRE ENVELOPPANT POUR DÉTAILS -->
                                <form action="detailLogement.php" method="POST" class="h-full w-full">
                                    <button type="submit" name="detailLogement" class="w-full h-full p-0 border-none bg-transparent cursor-pointer block overflow-hidden">
                                        <img src="/KARI/image/logement/' . $logement['image_path'].'" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                            alt="'.$logement["title"].'">
                                    </button>

                                    <input type="hidden" name="id" value="'.$logement["id"].'" >
                                    <input type="hidden" name="user_id" value="'.$logement["user_id"].'" >
                                    <input type="hidden" name="fullname" value="'.htmlspecialchars($logement["fullname"]).'" >
                                    <input type="hidden" name="title" value="'.htmlspecialchars($logement["title"]).'"  >
                                    <input type="hidden" name="prix" value="'.$logement["prix"].'" >
                                    <input type="hidden" name="description" value="'.htmlspecialchars($logement["description"]).'" >
                                    <input type="hidden" name="statut" value="'.$logement["statut"].'" >
                                    <input type="hidden" name="date_start" value="'.$logement["date_start"].'" >
                                    <input type="hidden" name="date_end" value="'.$logement["date_end"].'" >
                                    <input type="hidden" name="ville" value="'.htmlspecialchars($logement["ville"]).'" >
                                    <input type="hidden" name="image_path" value="'.$logement["image_path"].'" >
                                    <input type="hidden" name="created_at" value="'.$logement["created_at"].'" >
                                </form>

                                <!-- NOUVEAU : FORMULAIRE LIKE POUR SAUVEGARDER EN DATABASE -->
                                <form action="./../favoris_process.php" method="POST" class="absolute top-3 right-3 z-30">
                                    <input type="hidden" name="logement_id" value="'.$logement["id"].'">
                                    <button type="submit" name="ajoute_favoris" class="cursor-pointer p-2 group outline-none bg-transparent border-none">
                                        <!-- Coeur vide par défaut, devient rose au survol -->
                                        <i class="fa-regular fa-heart text-2xl text-white drop-shadow-md group-hover:text-rose-500 transition"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="mt-3">
                                <div class="flex justify-between font-bold">
                                    <span class="text-gray-900">'.htmlspecialchars($logement['ville']).'</span>
                                    <span><i class="fa-solid fa-star text-xs"></i> 4.9</span>
                                </div>
                                <p class="text-gray-500 text-sm">'.htmlspecialchars($logement['title']).'</p>
                                <p class="text-gray-500 text-sm">'.$logement['date_start'].' au '.$logement['date_end'].'</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="font-bold">'.$logement['prix'].' DH <span class="font-normal text-gray-600">/ nuit</span></p>
                                    <span class="text-xs '.$color.'">'.$disponibiliter.'</span>
                                </div>
                            </div>
                        </div>';
                    }
                ?>
                <!-- LOGEMENTS STATIQUES EXEMPLES (GARDÉS COMME DEMANDÉ) -->
                <!-- ... (Vos cartes statiques ici) ... -->
            </div>
        </main>
    </div> <!-- FIN DU WRAPPER -->

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>