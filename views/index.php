<?php 
require_once __DIR__ . "/../repositories/LogementRepository.php";
require_once __DIR__ ."/../config/database.php";

session_start();
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

    <!-- HEADER -->
    <header class="sticky top-0 z-50 bg-white border-b px-6 py-4 flex items-center justify-between">
        <div class="text-rose-500 text-3xl font-bold flex items-center gap-1 cursor-pointer">
            <i class="fa-brands fa-airbnb"></i>
            <span class="hidden md:inline tracking-tighter">airbnb</span>
        </div>

        <!-- Menu Desktop -->
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

    <!-- MENU MOBILE OVERLAY -->
    <div id="mobileMenu" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/50" onclick="toggleMobileMenu()"></div>
        <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-xl p-6 animate-slide-in">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-bold text-xl">Menu</h2>
                <button onclick="toggleMobileMenu()"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>
            <nav class="flex flex-col gap-6 font-medium text-lg">
                <a href="#" class="hover:text-rose-500">Inscription</a>
                <a href="#" class="hover:text-rose-500">Connexion</a>
                <hr>
                <a href="#" class="text-base text-gray-600">Mettre mon logement</a>
                <a href="#" class="text-base text-gray-600">Aide</a>
            </nav>
        </div>
    </div>

    <!-- CATEGORIES -->
    <div class="flex overflow-x-auto no-scrollbar gap-8 px-6 md:px-16 py-4 bg-white sticky top-[73px] z-40">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            
            <?php
                $pdo = Database::connect();
                $logeRepo = new LogementRepository($pdo);
                $results = $logeRepo->afficheLogement();

                foreach($results as $logement){
                    echo '
                    <!-- LOGEMENT -->
                    <div class="animate-card" style="animation-delay: 0.1s;">
                        <!-- Conteneur Image avec Aspect Ratio -->
                        <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-sm">
                            
                            <!-- FORMULAIRE ENVELOPPANT -->
                            <form action="detailLogement.php" method="POST" class="h-full w-full">
                                <!-- On transforme le bouton en conteneur invisible qui prend toute la place -->
                                <button type="submit" name="detailLogement" class="w-full h-full p-0 border-none bg-transparent cursor-pointer block overflow-hidden">
                                    <img src="/KARI/image/logement/' . $logement['image_path'].'" 
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                        alt="'.$logement["title"].'">
                                </button>

                                <!-- CHAMPS CACHÉS -->
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

                            <!-- BOUTON LIKE (Placé en dehors du bouton de soumission pour éviter les conflits de clic) -->
                            <label class="absolute top-3 right-3 cursor-pointer z-20 p-2">
                                <input type="checkbox" class="sr-only peer">
                                <i class="fa-regular fa-heart text-2xl text-white drop-shadow-md peer-checked:hidden"></i>
                                <i class="fa-solid fa-heart text-2xl text-rose-500 drop-shadow-md hidden peer-checked:inline"></i>
                            </label>
                        </div>

                        <!-- INFOS LOGEMENT -->
                        <div class="mt-3">
                            <div class="flex justify-between font-bold">
                                <span class="text-gray-900">'.htmlspecialchars($logement['ville']).'</span>
                                <span><i class="fa-solid fa-star text-xs"></i> 4.9</span>
                            </div>
                            <p class="text-gray-500 text-sm">'.htmlspecialchars($logement['title']).'</p>
                            <p class="text-gray-500 text-sm">'.$logement['date_start'].' au '.$logement['date_end'].'</p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="font-bold">'.$logement['prix'].' DH <span class="font-normal text-gray-600">/ nuit</span></p>
                                <span class="text-xs text-gray-400">Hôte : '.$logement['fullname'].'</span>
                            </div>
                        </div>
                    </div>';
                }
            ?>
            <!-- LOGEMENT 1 -->
            <div class="animate-card" style="animation-delay: 0.1s;">
                <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    
                    <!-- BOUTON LIKE (SANS JS & SANS DATABASE) -->
                    <label class="absolute top-3 right-3 cursor-pointer z-10 p-2">
                        <input type="checkbox" class="sr-only peer"> <!-- Input invisible -->
                        <!-- Coeur vide (par défaut) -->
                        <i class="fa-regular fa-heart text-2xl text-white drop-shadow-md peer-checked:hidden"></i>
                        <!-- Coeur plein (quand coché) -->
                        <i class="fa-solid fa-heart text-2xl text-rose-500 drop-shadow-md hidden peer-checked:inline"></i>
                    </label>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between font-bold">
                        <span>Paris, France</span>
                        <span><i class="fa-solid fa-star text-xs"></i> 4,9</span>
                    </div>
                    <p class="text-gray-500 text-sm">Vue sur Seine</p>
                    <p class="text-gray-500 text-sm">10-15 Oct.</p>
                    <p class="mt-2 font-bold">240 € <span class="font-normal">nuit</span></p>
                </div>
            </div>

            <!-- LOGEMENT 2 -->
            <div class="animate-card" style="animation-delay: 0.2s;">
                <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <!-- BOUTON LIKE MODIFIÉ -->
                    <label class="absolute top-3 right-3 cursor-pointer z-10 p-2">
                        <!-- On ajoute un 'name', une 'value' par défaut à 0, et un 'onchange' -->
                        <input type="checkbox" 
                            name="like_status" 
                            value="0" 
                            onclick="this.value = this.checked ? '1' : '0'" 
                            class="sr-only peer"> 
                        
                        <!-- Coeur vide (par défaut) -->
                        <i class="fa-regular fa-heart text-2xl text-white drop-shadow-md peer-checked:hidden"></i>
                        <!-- Coeur plein (quand coché) -->
                        <i class="fa-solid fa-heart text-2xl text-rose-500 drop-shadow-md hidden peer-checked:inline"></i>
                    </label>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between font-bold">
                        <span>Santorin, Grèce</span>
                        <span><i class="fa-solid fa-star text-xs"></i> 4,8</span>
                    </div>
                    <p class="text-gray-500 text-sm">Bord de mer</p>
                    <p class="text-gray-500 text-sm">05-12 Nov.</p>
                    <p class="mt-2 font-bold">410 € <span class="font-normal">nuit</span></p>
                </div>
            </div>

            <!-- LOGEMENT 3 -->
            <div class="animate-card" style="animation-delay: 0.3s;">
                <div class="relative group aspect-square rounded-2xl overflow-hidden bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <label class="absolute top-3 right-3 cursor-pointer z-10 p-2">
                        <input type="checkbox" class="sr-only peer">
                        <i class="fa-regular fa-heart text-2xl text-white drop-shadow-md peer-checked:hidden"></i>
                        <i class="fa-solid fa-heart text-2xl text-rose-500 drop-shadow-md hidden peer-checked:inline"></i>
                    </label>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between font-bold">
                        <span>Bali, Indonésie</span>
                        <span><i class="fa-solid fa-star text-xs"></i> 4,95</span>
                    </div>
                    <p class="text-gray-500 text-sm">Villa privée</p>
                    <p class="text-gray-500 text-sm">20-25 Déc.</p>
                    <p class="mt-2 font-bold">125 € <span class="font-normal">nuit</span></p>
                </div>
            </div>

        </div>
    </main>

    <script>
        // JS uniquement pour l'ouverture du menu mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>