<?php
session_start();
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../repositories/ReservationRepository.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: ./../index.html");
    exit;
}
$user_id = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - Airbnb</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Animation pour le menu mobile */
        #sidebar.active { transform: translateX(0); }
    </style>
</head>
<body class="bg-gray-50">

    <!-- SIDEBAR (Fixe sur Desktop lg:w-64) -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r hidden lg:flex flex-col z-[60]">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center gap-1 border-b">
            <i class="fa-brands fa-airbnb"></i>
            <span class="tracking-tighter">airbnb</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 mt-4">
            <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-house w-5"></i> Accueil
            </a>
            <!-- ACTIF -->
            <a href="reservation.php" class="flex items-center gap-3 p-3 bg-rose-50 text-rose-500 rounded-lg transition font-bold">
                <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
            </a>
            <a href="favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
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

    <!-- OVERLAY MOBILE (Fond sombre quand le menu est ouvert) -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[55] hidden lg:hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="lg:ml-64 min-h-screen">
        
        <!-- HEADER MOBILE -->
        <header class="lg:hidden bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <button onclick="toggleSidebar()" class="text-gray-600 text-xl p-2">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <span class="font-bold text-gray-800">Mes Voyages</span>
            <div class="w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center font-bold text-xs shadow-md">
                JD
            </div>
        </header>

        <!-- CONTENU DE LA PAGE -->
        <main class="p-6 lg:p-10 max-w-5xl mx-auto">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Voyages</h1>
                <p class="text-gray-500">Gérez vos réservations et préparez vos prochains départs.</p>
            </header>

            <!-- LISTE DES RÉSERVATIONS -->
            <div class="space-y-6">
                
                <?php
                    $pdo = DATABASE::connect();
                    $reserRepo = new ReservationRepository($pdo);
                    $user_id = $_SESSION["user_id"];
                    $resultat = $reserRepo->afficheReservation($user_id);
                    if (!$resultat) {
                        
                    }

                    else {
                        foreach($resultat as $reservation){
                            echo ' <!-- RÉSERVATION 1 -->
                            <div class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row">
                                <!-- Image -->
                                <div class="md:w-72 h-48 md:h-auto overflow-hidden">
                                    <img src="/KARI/image/logement/'.$reservation["image_path"].'" class="w-full h-full object-cover" alt="Logement">
                                </div>
                                <!-- Détails -->
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900">'.$reservation["title"].'</h3>
                                                <p class="text-gray-500 text-sm flex items-center gap-1">
                                                    <i class="fa-solid fa-location-dot text-rose-500"></i> '.$reservation["ville"].'
                                                </p>
                                            </div>
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                                Confirmé
                                            </span>
                                        </div>
                                        
                                        <!-- Dates -->
                                        <div class="grid grid-cols-2 gap-4 mt-4 py-4 border-y border-gray-50">
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase">Arrivée</p>
                                                <p class="font-semibold text-gray-800">'.$reservation["date_start"].'</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase">Départ</p>
                                                <p class="font-semibold text-gray-800">'.$reservation["date_end"].'</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions & Prix -->
                                    <div class="mt-6 flex items-center justify-between">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Total payé</p>
                                            <p class="text-xl font-black text-gray-900">'.$reservation["prix"].' DH</p>
                                        </div>
                                        <form action="./../reservation_process.php" method="POST" class="flex gap-2">
                                            <button class="px-4 py-2 text-sm font-bold text-gray-700 border rounded-lg hover:bg-gray-50 transition">Détails</button>
                                            <button type="submit" name="delete_reservation" value="'.$reservation["id"].'" class="px-4 py-2 text-sm font-bold text-rose-500 border border-rose-100 rounded-lg hover:bg-rose-50 transition">
                                                Annuler
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                ?>
                <!-- RÉSERVATION 1 -->
                <div class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row">
                    <!-- Image -->
                    <div class="md:w-72 h-48 md:h-auto overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800" class="w-full h-full object-cover" alt="Logement">
                    </div>
                    <!-- Détails -->
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Loft Industriel avec Vue</h3>
                                    <p class="text-gray-500 text-sm flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-rose-500"></i> Paris, France
                                    </p>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Confirmé
                                </span>
                            </div>
                            
                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-4 mt-4 py-4 border-y border-gray-50">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Arrivée</p>
                                    <p class="font-semibold text-gray-800">12 Juin 2026</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Départ</p>
                                    <p class="font-semibold text-gray-800">18 Juin 2026</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions & Prix -->
                        <div class="mt-6 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Total payé</p>
                                <p class="text-xl font-black text-gray-900">1,250 DH</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 text-sm font-bold text-gray-700 border rounded-lg hover:bg-gray-50 transition">Détails</button>
                                <button onclick="confirmCancel()" class="px-4 py-2 text-sm font-bold text-rose-500 border border-rose-100 rounded-lg hover:bg-rose-50 transition">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RÉSERVATION 2 -->
                <div class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row opacity-80">
                    <!-- Image -->
                    <div class="md:w-72 h-48 md:h-auto overflow-hidden grayscale">
                        <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800" class="w-full h-full object-cover" alt="Logement">
                    </div>
                    <!-- Détails -->
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Villa avec piscine privée</h3>
                                    <p class="text-gray-500 text-sm flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-rose-500"></i> Marrakech, Maroc
                                    </p>
                                </div>
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                    Terminé
                                </span>
                            </div>
                            <p class="text-sm text-gray-400 mt-2 italic">Vous avez séjourné ici en Janvier 2024</p>
                        </div>
                        <div class="mt-6">
                            <button class="px-4 py-2 text-sm font-bold text-rose-500 border border-rose-200 rounded-lg hover:bg-rose-50 transition">Laisser un avis</button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- SCRIPT POUR LE MENU -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function confirmCancel() {
            if(confirm("Êtes-vous sûr de vouloir annuler cette réservation ? Cette action est irréversible.")) {
                alert("Réservation annulée avec succès.");
            }
        }
    </script>
</body>
</html>