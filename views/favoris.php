<?php 
require_once __DIR__ . "/../repositories/FavorisRepository.php";
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
    <title>Mes Favoris - Airbnb</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white">

    <!-- SIDEBAR (Fixe Desktop) -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r hidden lg:flex flex-col z-[60]">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center gap-1 border-b">
            <i class="fa-brands fa-airbnb"></i>
            <span class="tracking-tighter">airbnb</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 mt-4">
            <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-house w-5"></i> Accueil
            </a>
            <a href="reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
            </a>
            <!-- ACTIF -->
            <a href="favoris.php" class="flex items-center gap-3 p-3 bg-rose-50 text-rose-500 rounded-lg transition font-bold">
                <i class="fa-solid fa-heart w-5"></i> Favoris
            </a>

            <hr class="my-4">
            <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

            <a href="profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-user w-5"></i> Mon Profil
            </a>            
            <?php if ($_SESSION["role"] === "Hote"): ?>
                <a href="logementsHost.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                    <i class="fa-solid fa-list-check w-5"></i> Mes annonces
                </a>
                <a href="host-dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                    <i class="fa-solid fa-plus-circle w-5"></i> Ajouter un logement
                </a>
            <?php endif; ?>
        </nav>
        <form action="logout.php" method="POST" class="p-4 border-t">
            <button name="logout" class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-lg transition font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
            </button>
        </form>
    </aside>

    <!-- OVERLAY MOBILE -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[55] hidden lg:hidden"></div>

    <!-- WRAPPER CONTENT -->
    <div class="lg:ml-64 min-h-screen">
        
        <!-- HEADER MOBILE -->
        <header class="lg:hidden bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <button onclick="toggleSidebar()" class="text-gray-600 text-xl p-2">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <span class="font-bold text-gray-800">Mes Favoris</span>
            <div class="w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center font-bold text-xs shadow-md">
                <i class="fa-solid fa-user"></i>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="p-6 lg:p-10">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Favoris</h1>
                <p class="text-gray-500 mt-2">Vous avez <span class="font-bold text-gray-800">3 logements</span> enregistrés.</p>
            </header>

            <!-- GRILLE DE LOGEMENTS FAVORIS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
                
                <?php
                    $pdo = Database::connect();
                    $favRepo = new FavorisRepository($pdo);
                    $user_id = $_SESSION["user_id"];
                    $resultat = $favRepo->afficheFavoris($user_id);

                    if ($resultat) {
                        foreach($resultat as $favoris){
                            $statut = $favoris["statut"];
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
                                    <form action="detailLogement.php" method="POST" class="h-full w-full">
                                        <button type="submit" name="detailLogement" class="w-full h-full p-0 border-none bg-transparent cursor-pointer block overflow-hidden">
                                            <img src="/KARI/image/logement/' . $favoris['image_path'].'" 
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                                alt="'.$favoris["title"].'">
                                        </button>
    
                                        <input type="hidden" name="id" value="'.$favoris["id"].'" >
                                        <input type="hidden" name="user_id" value="'.$favoris["user_id"].'" >
                                        <input type="hidden" name="fullname" value="'.htmlspecialchars($favoris["fullname"]).'" >
                                        <input type="hidden" name="title" value="'.htmlspecialchars($favoris["title"]).'"  >
                                        <input type="hidden" name="prix" value="'.$favoris["prix"].'" >
                                        <input type="hidden" name="description" value="'.htmlspecialchars($favoris["description"]).'" >
                                        <input type="hidden" name="statut" value="'.$favoris["statut"].'" >
                                        <input type="hidden" name="ville" value="'.htmlspecialchars($favoris["ville"]).'" >
                                        <input type="hidden" name="image_path" value="'.$favoris["image_path"].'" >
                                        <input type="hidden" name="created_at" value="'.$favoris["created_at"].'" >
                                    </form>
    
                                    <form action="./../favoris_process.php" method="POST" class="absolute top-3 right-3 z-30">
                                        <input type="hidden" name="favoris_id" value="'.$favoris["favoris_id"].'">
                                        <button type="submit" name="delete_favoris" class="cursor-pointer p-2 group outline-none bg-transparent border-none">
                                            <!-- Coeur vide par défaut, devient rose au survol -->
                                            <i class="fa-solid fa-heart text-2xl text-rose-500 drop-shadow-md"></i>

                                        </button>
                                    </form>
                                </div>
    
                                <div class="mt-3">
                                    <div class="flex justify-between font-bold">
                                        <span class="text-gray-900">'.htmlspecialchars($favoris['ville']).'</span>
                                        <span><i class="fa-solid fa-star text-xs"></i> 4.9</span>
                                    </div>
                                    <p class="text-gray-500 text-sm">'.htmlspecialchars($favoris['title']).'</p>
                                    <p class="text-gray-500 text-sm">date_start au date_end</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <p class="font-bold">'.$favoris['prix'].' DH <span class="font-normal text-gray-600">/ nuit</span></p>
                                        <span class="text-xs '.$color.'">'.$disponibiliter.'</span>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                ?>
                

            </div>

            <!-- SECTION VIDE (Optionnelle, si l'utilisateur n'a rien) -->
            <!--
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 p-6 rounded-full mb-4">
                    <i class="fa-regular fa-heart text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-xl font-bold">Créez votre première liste de favoris</h2>
                <p class="text-gray-500 mt-2">Lorsque vous parcourez les logements, cliquez sur l'icône en forme de cœur pour enregistrer ceux qui vous plaisent.</p>
                <a href="index.html" class="mt-6 bg-black text-white px-6 py-3 rounded-lg font-bold">Lancer la recherche</a>
            </div>
            -->

        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>