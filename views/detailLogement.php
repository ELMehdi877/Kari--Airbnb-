<?php
session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["detailLogement"]) && isset($_SESSION["user_id"])) { 
        $logement_id = (int) ($_POST['id']);
        $user_id = (int) ($_POST["user_id"]);
        $fullname = $_POST["fullname"];
        $title = $_POST['title'];
        $statut = (int) ($_POST['statut']);
        $prix = $_POST['prix'];
        $description = $_POST['description'];
        $ville = $_POST['ville'];
        $image_path = $_POST['image_path'];
        $created_at = $_POST['created_at'];
    }
    else {
        header("Location: ./../index.html");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du Logement - Luxe & Confort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
        .btn-reserve {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            transition: transform 0.2s;
        }
        .btn-reserve:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- SIDEBAR (Identique à l'index) -->
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
                        <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
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

    <!-- WRAPPER PRINCIPAL -->
    <div class="lg:ml-64 min-h-screen">
        
        <!-- HEADER MOBILE (Pour pouvoir revenir au menu sur petit écran) -->
        <header class="lg:hidden bg-white border-b px-6 py-4 flex items-center justify-between sticky top-0 z-50">
            <a href="index.php" class="text-rose-500 text-2xl font-bold">
                <i class="fa-brands fa-airbnb"></i>
            </a>
            <button onclick="history.back()" class="p-2 hover:bg-gray-100 rounded-full">
                <i class="fa-solid fa-chevron-left"></i> Retour
            </button>
        </header>

        <div class="max-w-6xl mx-auto px-6 py-12">
            
            <!-- En-tête -->
            <header class="mb-8">
                <h1 class="text-4xl font-extrabold tracking-tight mb-2"><?php echo $title ?></h1>
                <div class="flex items-center gap-4 text-gray-600">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-rose-500"></i> <?php echo $ville ?>
                    </span>
                    <span>•</span>
                    <span class="text-sm">Annonce publiée le <?php echo $created_at ?></span>
                </div>
            </header>

            <!-- Image Unique (Format Cinématique) -->
            <div class="w-full h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-12">
                <img src="/KARI/image/logement/<?php echo $image_path ?>"
                     alt="Intérieur du logement" 
                     class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Colonne de Gauche : Infos Détails -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Infos Hôte & Disponibilité -->
                    <div class="flex justify-between items-center border-b pb-8">
                        <div>
                            <h2 class="text-2xl font-bold">Logement entier proposé par <?php echo $fullname ?></h2>
                            <p class="text-gray-500">2 voyageurs · 1 chambre · 1 salle de bain</p>
                        </div>
                        <div class="w-14 h-14 bg-rose-500 text-white rounded-full flex items-center justify-center font-bold text-xl shadow-md">
                            <?php echo substr($fullname, 0, 1); ?>
                        </div>
                    </div>

                    <!-- Section Calendrier / Disponibilité -->
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4">
                        <i class="fa-solid fa-calendar-check text-blue-600 text-2xl mt-1"></i>
                        <div>
                            <h3 class="font-bold text-blue-900">Période de disponibilité</h3>
                            <p class="text-blue-800/80">
                                Ce logement est disponible du 
                                <span class="font-semibold underline">2/6/2020</span> au 
                                <span class="font-semibold underline">2/6/2020</span>.
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">À propos de ce logement</h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo $description ?>
                        </p>
                    </div>

                    <!-- Équipements rapides -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-4 border rounded-xl">
                            <i class="fa-solid fa-wifi text-gray-400"></i>
                            <span>Fibre optique ultra-rapide</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 border rounded-xl">
                            <i class="fa-solid fa-snowflake text-gray-400"></i>
                            <span>Climatisation réversible</span>
                        </div>
                    </div>
                </div>

                <!-- Colonne de Droite : Widget Réservation -->
                <div class="relative">
                    <form action="./../reservation_process.php" method="POST" class="sticky top-24 bg-white border border-gray-200 rounded-3xl p-8 shadow-xl">
                        <div class="flex justify-between items-baseline mb-6">
                            <div>
                                <span class="text-3xl font-black"><?php echo $prix ?> DH</span>
                                <span class="text-gray-500"> / nuit</span>
                            </div>
                            <div class="flex items-center gap-1 text-sm font-bold text-rose-500">
                                <i class="fa-solid fa-star"></i> 4.95
                            </div>
                        </div>

                        <!-- Sélecteurs de dates -->
                        <div class="border rounded-xl mb-6 overflow-hidden">
                            <div class="grid grid-cols-2 border-b">
                                <div class="p-3 border-r hover:bg-gray-50 transition">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">Arrivée</label>
                                    <input type="date" required name="date_start" class="w-full text-sm outline-none bg-transparent">
                                    <input type="hidden" name="logement_id" value="<?php echo $logement_id; ?>">
                                    <input type="hidden" name="title" value="<?php echo $title; ?>">
                                </div>
                                <div class="p-3 hover:bg-gray-50 transition">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">Départ</label>
                                    <input type="date" required name="date_end" class="w-full text-sm outline-none bg-transparent">
                                </div>
                            </div>
                            <div class="p-3 hover:bg-gray-50 transition">
                                <label class="block text-[10px] font-bold uppercase text-gray-500">Voyageurs</label>
                                <select class="w-full text-sm outline-none bg-transparent cursor-pointer">
                                    <option>1 voyageur</option>
                                    <option>2 voyageurs</option>
                                </select>
                            </div>
                        </div>

                        <?php
                            if ($statut === 0) {
                                echo '
                                <p class="text-center text-xs text-gray-400">Ce logement pas disponible</p>
                                ';
                            }
                            else {
                                echo '<button type="submit" name="ajoute_reservation" class="w-full btn-reserve text-white py-4 rounded-xl font-bold text-lg mb-4 shadow-lg shadow-rose-200">
                                    Réserver maintenant
                                </button>
                                ';
                            }
                        ?>
                        
                    </form>
                </div>

            </div>

            <!-- Footer / Meta -->
            <footer class="mt-16 pt-8 border-t text-gray-400 text-sm flex flex-col md:flex-row justify-between gap-4">
                <p>Référence Logement : #LOG-<?php echo $logement_id ?><?php echo substr(md5($title), 0, 5) ?></p>
                <div class="flex gap-6">
                    <a href="#" class="hover:underline">Signaler cette annonce</a>
                    <a href="#" class="hover:underline">Conditions d'annulation</a>
                </div>
            </footer>
        </div>
    </div> <!-- FIN DU WRAPPER -->

</body>
</html>