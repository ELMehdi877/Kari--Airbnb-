<?php
session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["detailLogement"]) && isset($_SESSION["user_id"])) { 
        $id = (int) ($_POST['id']);
        $user_id = (int) ($_POST["user_id"]);
        $fullname = $_POST["fullname"];
        $title = $_POST['title'];
        $prix = $_POST['prix'];
        $description = $_POST['description'];
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $ville = $_POST['ville'];
        $image_path = $_POST['image_path'];
        $created_at = $_POST['created_at'];
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

    <div class="max-w-6xl mx-auto px-6 py-12">
        
        <!-- En-tête -->
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold tracking-tight mb-2">Loft Industriel avec Vue Panoramique</h1>
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
                    <img src="/KARI/image/logement/<?php echo $image_path ?>" class="w-14 h-14 rounded-full border-2 border-white shadow-md">
                </div>

                <!-- Section Calendrier / Disponibilité -->
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4">
                    <i class="fa-solid fa-calendar-check text-blue-600 text-2xl mt-1"></i>
                    <div>
                        <h3 class="font-bold text-blue-900">Période de disponibilité</h3>
                        <p class="text-blue-800/80">
                            Ce logement est disponible du 
                            <span class="font-semibold underline"><?php echo $date_start ?></span> au 
                            <span class="font-semibold underline"><?php echo $date_end ?></span>.
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
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-4 border rounded-xl">
                        <i class="fa-solid fa-wifi text-gray-400"></i>
                        <span>Fibre optique</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 border rounded-xl">
                        <i class="fa-solid fa-snowflake text-gray-400"></i>
                        <span>Climatisation</span>
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
                        <div class="flex items-center gap-1 text-sm font-bold">
                            <i class="fa-solid fa-star text-rose-500"></i> 4.95
                        </div>
                    </div>

                    <!-- Sélecteurs de dates factices -->
                    <div  class="border rounded-xl mb-6">
                        <div class="grid grid-cols-2 border-b">
                            <div class="p-3 border-r">
                                <label class="block text-[10px] font-bold uppercase">Arrivée</label>
                                <input type="date" name="date_start" class="w-full text-sm outline-none bg-transparent" >
                                <input type="hidden" name="id" value= "<?php echo $di; ?>">
                            </div>
                            <div class="p-3">
                                <label class="block text-[10px] font-bold uppercase">Départ</label>
                                <input type="date" name="date_end" class="w-full text-sm outline-none bg-transparent" >
                            </div>
                        </div>
                        <div class="p-3">
                            <label class="block text-[10px] font-bold uppercase">Voyageurs</label>
                            <select class="w-full text-sm outline-none bg-transparent">
                                <option>1 voyageur</option>
                                <option>2 voyageurs</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-reserve text-white py-4 rounded-xl font-bold text-lg mb-4">
                        Réserver maintenant
                    </button>

                </fomr>
            </div>

        </div>

        <!-- Footer / Meta -->
        <footer class="mt-16 pt-8 border-t text-gray-400 text-sm flex justify-between">
            <p>ID Logement : #LY-45092</p>
            <p>Créé le : 12 Mai 2023</p>
        </footer>
    </div>

</body>
</html>