<?php 
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
    <title>Ajouter un logement - Mode Hôte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .btn-premium { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-premium:hover { transform: scale(1.02); filter: brightness(1.1); }
        
        /* Ajustement sidebar mobile */
        #sidebar.active { transform: translateX(0); }
    </style>
</head>
<body class="bg-gray-50">

    <!-- SIDEBAR FIXE (Desktop) / COULISSANTE (Mobile) -->
    <aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-white border-r z-[60] transition-transform -translate-x-full lg:translate-x-0 flex flex-col">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center justify-between border-b">
            <div class="flex items-center gap-1">
                <i class="fa-brands fa-airbnb"></i>
                <span class="tracking-tighter">airbnb</span>
            </div>
            <!-- Bouton fermer (Mobile seulement) -->
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
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
                        <a href="mes_reservations.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-calendar-check w-5"></i> Réservations
                        </a>
                        <hr class="my-4">
                        
                        <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

                        <a href="host-dashboard.php" class="flex items-center gap-3 p-3 text-rose-500 bg-rose-50 rounded-lg transition font-bold">
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
                        <a href="mes_reservations.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                            <i class="fa-solid fa-calendar-check w-5"></i> Réservations
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

    <!-- OVERLAY MOBILE -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[55] hidden"></div>

    <!-- WRAPPER PRINCIPAL -->
    <div class="lg:ml-64 min-h-screen flex flex-col">

        <!-- HEADER MOBILE -->
        <header class="lg:hidden bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="text-gray-600 text-xl p-2">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <span class="font-bold text-rose-500">Mode Hôte</span>
            </div>
            <a href="index.php" class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Quitter</a>
        </header>

        <!-- CONTENU -->
        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-rose-100 text-rose-600 w-12 h-12 rounded-2xl flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-house-medical"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Ajouter un nouveau logement</h1>
                        <p class="text-gray-500 text-sm">Remplissez les informations pour publier votre annonce</p>
                    </div>
                </div>
                
                <?php
                    if (!empty($_SESSION["message"])) {
                        echo $_SESSION["message"];
                        unset($_SESSION["message"]);
                    }
                ?>
                
                <form id="logement-form" method="POST" enctype="multipart/form-data" action="./../logement_process.php" class="bg-white p-6 md:p-8 rounded-3xl border shadow-sm space-y-6 transition-colors duration-300">
                    
                    <div>
                        <label class="block font-medium mb-2 text-gray-700">Titre de l'annonce</label>
                        <input type="text" name="title" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none transition" placeholder="Ex: Maison de campagne paisible">
                    </div>

                    <div>
                        <label class="block font-medium mb-2 text-gray-700">Description</label>
                        <textarea name="description" required rows="4" class="resize-none w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none transition" placeholder="Décrivez votre logement..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium mb-2 text-gray-700">Ville</label>
                            <input type="text" name="ville" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Ex: Paris">
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700">Prix par nuit (DH)</label>
                            <div class="relative">
                                <input type="number" name="prix" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none pl-12">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">DH</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium mb-2 text-gray-700">Date de début</label>
                            <input id="input_date_debut" type="date" name="date_start" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700">Date de fin</label>
                            <input id="input_date_fin" type="date" name="date_end" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium mb-2 text-gray-700">Photo du logement</label>
                        <label for="file-upload" class="mt-2 flex justify-center rounded-2xl border-2 border-dashed border-gray-200 px-6 pt-10 pb-12 hover:border-rose-400 transition bg-gray-50 cursor-pointer group hover:bg-white">
                            <div class="text-center space-y-2">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 group-hover:text-rose-500 transition"></i>
                                <div class="flex text-sm text-gray-600">
                                    <span class="font-medium text-rose-600">Uploader un fichier</span>
                                </div>
                                <p class="text-xs text-gray-400 font-medium">PNG, JPG jusqu'à 5MB</p>
                            </div>
                            <input required id="file-upload" name="image" type="file" class="sr-only" accept="image/*">
                        </label>
                    </div>
                    <button type="submit" name="addLogement" class="w-full bg-black text-white px-8 py-4 rounded-xl font-bold btn-premium text-lg shadow-xl shadow-gray-200">
                        Publier l'annonce
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Gestion Sidebar Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // --- GESTION DES DATES (Conservée) ---
        const dateDebut = document.getElementById('input_date_debut');
        const dateFin = document.getElementById('input_date_fin');
        const form = document.getElementById('logement-form');

        const today = new Date().toISOString().split('T')[0];
        dateDebut.setAttribute('min', today);

        dateDebut.addEventListener('change', () => {
            dateFin.setAttribute('min', dateDebut.value);
            if (dateFin.value && dateFin.value < dateDebut.value) {
                dateFin.value = '';
                showErrorToast("La date de fin doit être après le début");
            }
        });

        function showErrorToast(message) {
            Toastify({
                text: message,
                duration: 4000,
                gravity: "top",
                position: "center",
                style: {
                    background: "#ef4444",
                    borderRadius: "12px",
                    fontWeight: "600"
                }
            }).showToast();
            form.classList.add("bg-red-50");
            setTimeout(() => form.classList.remove("bg-red-50"), 500);
        }
    </script>
</body>
</html>