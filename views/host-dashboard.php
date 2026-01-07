<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un logement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Ajout de Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .btn-premium { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-premium:hover { transform: scale(1.02); filter: brightness(1.1); }
        #mobile-sidebar { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- NAVIGATION MOBILE -->
    <div class="md:hidden bg-white border-b px-4 py-4 flex justify-between items-center sticky top-0 z-50">
        <h2 class="text-xl font-bold text-rose-500">Mode Hôte</h2>
        <div class="flex items-center gap-4">
            <a href="index.html" class="text-sm font-medium text-gray-600 border-r pr-4">Quitter</a>
            <button id="open-menu" class="text-gray-800 text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>

    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r p-6 transform -translate-x-full md:translate-x-0 md:relative md:flex flex-col transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-xl font-bold text-rose-500">Menu</h2>
                <button id="close-menu" class="md:hidden text-gray-500">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <nav class="space-y-4 flex-1">
                <a href="#" class="flex items-center gap-3 p-3 bg-rose-50 text-rose-600 rounded-xl font-bold">
                    <i class="fa-solid fa-house-chimney"></i> Mes annonces
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition">
                    <i class="fa-solid fa-calendar-check"></i> Réservations
                </a>
                <a href="index.html" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition mt-auto">
                    <i class="fa-solid fa-arrow-left-long"></i> Retour Voyageur
                </a>
            </nav>
        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden md:hidden"></div>

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-2xl md:text-3xl font-bold mb-8">Ajouter un nouveau logement</h1>
                
                <?php
                    if (!empty($_SESSION["message"])) {
                        echo $_SESSION["message"];
                        unset($_SESSION["message"]);
                    }
                ?>
                
                <form id="logement-form" method="POST" enctype="multipart/form-data" action="./../logement_process.php" class="bg-white p-6 md:p-8 rounded-3xl border shadow-sm space-y-6 transition-colors duration-300">
                    
                    <div>
                        <label class="block font-medium mb-2">Titre de l'annonce</label>
                        <input type="text" name="title" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Ex: Maison de campagne paisible">
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Description</label>
                        <textarea name="description" required rows="4" class="resize-none w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Décrivez votre logement..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-2">Ville</label>
                            <input type="text" name="ville" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Prix par nuit (€)</label>
                            <input type="number" name="prix" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-2">Date de début</label>
                            <input id="input_date_debut" type="date" name="date_start" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Date de fin</label>
                            <input id="input_date_fin" type="date" name="date_end" required class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-rose-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium mb-2">Photo du logement</label>
                        <label for="file-upload" class="mt-2 flex justify-center rounded-xl border-2 border-dashed border-gray-300 px-6 pt-10 pb-12 hover:border-rose-400 transition bg-gray-50 cursor-pointer group">
                            <div class="text-center space-y-2">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-rose-500 transition"></i>
                                <div class="flex text-sm text-gray-600">
                                    <span class="font-medium text-rose-600">Uploader un fichier</span>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG jusqu'à 5MB</p>
                            </div>
                            <input required id="file-upload" name="image" type="file" class="sr-only" accept="image/*">
                        </label>
                    </div>

                    <button type="submit" name="addLogement" class="w-full bg-black text-white px-8 py-4 rounded-xl font-bold btn-premium text-lg">
                        Publier l'annonce
                    </button>
                </form>
            </div>
        </main>
    </div>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        // Gestion Menu Mobile
        const openBtn = document.getElementById('open-menu');
        const closeBtn = document.getElementById('close-menu');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        openBtn.addEventListener('click', toggleMenu);
        closeBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // --- GESTION DES DATES ---
        const dateDebut = document.getElementById('input_date_debut');
        const dateFin = document.getElementById('input_date_fin');
        const form = document.getElementById('logement-form');

        // 1. Empêcher de choisir une date passée pour le début
        const today = new Date().toISOString().split('T')[0];
        dateDebut.setAttribute('min', today);

        // 2. Quand la date de début change
        dateDebut.addEventListener('change', () => {
            // La date de fin doit être au minimum la date de début
            dateFin.setAttribute('min', dateDebut.value);
            
            // Si la date de fin était déjà saisie et qu'elle est maintenant invalide
            if (dateFin.value && dateFin.value < dateDebut.value) {
                dateFin.value = ''; // On vide la date de fin
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
            
            // Petit flash rouge visuel sur le formulaire
            form.classList.add("bg-red-50");
            setTimeout(() => form.classList.remove("bg-red-50"), 500);
        }
    </script>
</body>
</html>