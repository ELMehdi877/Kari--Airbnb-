<?php 
require_once __DIR__ . "/../repositories/LogementRepository.php";
require_once __DIR__ ."/../config/database.php";

session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["statut"] === 0) { 
    header("Location: ./../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Immobilière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* Animation Sidebar Mobile */
        #sidebar.active { transform: translateX(0); }
    </style>
</head>
<body class="bg-gray-50">

    <!-- SIDEBAR (Fixe sur Desktop) -->
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
            <a href="favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-heart w-5"></i> Favoris
            </a>

            <hr class="my-4">
            <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

            <a href="profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-user w-5"></i> Mon Profil
            </a>            
            <?php if ($_SESSION["role"] === "Hote"): ?>
                <!-- ACTIF -->
                <a href="logementsHost.php" class="flex items-center gap-3 p-3 bg-rose-50 text-rose-500 rounded-lg transition font-bold">
                    <i class="fa-solid fa-list-check w-5"></i> Mes annonces
                </a>

                <a href="host-dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                    <i class="fa-solid fa-plus-circle w-5"></i> Ajouter un logement
                </a>
            <?php endif; ?>

            <?php if ($_SESSION["role"] === "admin"): ?>
                <a href="./administration/dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium group">
                    <i class="fa-solid fa-sliders w-5 text-lg group-hover:scale-110 transition-transform"></i>Administration
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
    <div class="lg:ml-64 min-h-screen transition-all duration-300">

        <!-- HEADER / TOP NAV -->
        <header class="bg-white border-b px-8 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 text-xl">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h1 class="font-bold text-xl text-gray-800">Gestion de mes logements</h1>
            </div>
            
            <a href="ajouter_logement.php" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> <span>Nouveau logement</span>
            </a>
        </header>

        <!-- MAIN TABLE AREA -->
        <main class="max-w-7xl mx-auto px-4 py-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b text-gray-500 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Logement / Ville</th>
                                <th class="px-6 py-4 font-semibold">Description</th>
                                <th class="px-6 py-4 font-semibold">Disponibilité</th>
                                <th class="px-6 py-4 font-semibold">Prix</th>
                                <th class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="logement-list">
                            <?php
                                $pdo = DATABASE::connect();
                                $logeRepo = new LogementRepository($pdo);
                                $user_id = $_SESSION["user_id"];
                                $results = $logeRepo->afficheLogementByUser($user_id);
                                
                                foreach($results as $logement){
                                    echo '
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <img src="/KARI/image/logement/' . $logement['image_path'].'" class="w-14 h-14 object-cover rounded-lg shadow-sm border">
                                                    <div>
                                                        <div class="font-bold text-gray-900">'.$logement['title'].'</div>
                                                        <div class="text-gray-500 text-sm flex items-center gap-1">
                                                            <i class="fa-solid fa-location-dot text-xs text-rose-500"></i> <span>'.$logement['ville'].'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-gray-600 text-sm line-clamp-1 w-48">'.$logement['description'].'</p>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                <div class="flex flex-col">
                                                    <span class="text-[10px] text-gray-400 font-bold uppercase">Période</span>
                                                    <span>date_start <i class="fa-solid fa-arrow-right text-[10px] mx-1 text-gray-300"></i> date_end</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 font-bold text-gray-900">
                                                '.$logement['prix'].' DH <span class="text-[10px] text-gray-400 font-normal">/nuit</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <button onclick="openEditModal(this)" 
                                                        data-id="'.$logement['id'].'" 
                                                        data-title="'.$logement['title'].'" 
                                                        data-prix="'.$logement['prix'].'" 
                                                        data-description="'.$logement['description'].'" 
                                                        data-ville="'.$logement['ville'].'" 
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Modifier">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <form action="./../logement_process.php" method="POST" onsubmit="return confirm(\'Voulez-vous vraiment supprimer ce logement ?\')">
                                                        <input type="hidden" name="id" value="'.$logement['id'].'">
                                                        <button type="submit" name="deleteLogement" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Supprimer">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL DE MODIFICATION (Inchangé mais z-index augmenté) -->
    <div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <!-- ... (Contenu du modal identique au vôtre) ... -->
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-xl font-bold">Modifier les détails du logement</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-black text-2xl">&times;</button>
            </div>
            
            <form action="./../logement_process.php" method="POST" enctype="multipart/form-data" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" name="id" id="edit-id">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Titre de l'annonce</label>
                    <input type="text" name="title" id="edit-title" required class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                    <textarea required name="description" id="edit-description" rows="3" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Ville</label>
                    <input required type="text" name="ville" id="edit-ville" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Prix par nuit (DH)</label>
                    <input required type="number" name="prix" id="edit-prix" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>
                
                <div class="md:col-span-2 pt-4 flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-100 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Annuler</button>
                    <button type="submit" name="updateLogement" class="flex-1 bg-rose-500 text-white py-3 rounded-xl font-bold hover:bg-rose-600 shadow-lg shadow-rose-200 transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openEditModal(btn) {
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-title').value = btn.dataset.title;
            document.getElementById('edit-prix').value = btn.dataset.prix;
            document.getElementById('edit-description').value = btn.dataset.description;
            document.getElementById('edit-ville').value = btn.dataset.ville;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>