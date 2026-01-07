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
    <title>Admin - Gestion Immobilière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- NAV -->
    <nav class="bg-white border-b px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-2 text-rose-500 font-bold text-2xl">
            <i class="fa-brands fa-airbnb"></i>
            <span class="text-black text-lg tracking-tight">Admin Logements</span>
        </div>
        <button class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
            <i class="fa-solid fa-plus mr-2"></i>Nouveau logement
        </button>
    </nav>

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
                                    <tr class="hover:bg-gray-50/50 transition"">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="/KARI/image/logement/' . $logement['image_path'].'" class="w-14 h-14 object-cover rounded-lg shadow-sm border">
                                                <div>
                                                    <div class="font-bold text-gray-900">'.$logement['title'].'</div>
                                                    <div class="text-gray-500 text-sm flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-xs"></i> <span>'.$logement['ville'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-600 text-sm line-clamp-1 w-48">'.$logement['description'].'</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <div>Du <span class="font-medium">'.$logement['date_start'].'</span></div>
                                            <div>Au <span class="font-medium">'.$logement['date_end'].'</span></div>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            '.$logement['prix'].'DH <span class="text-[10px] text-gray-400 font-normal">/nuit</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button onclick="openEditModal(this)" 
                                                    data-id="'.$logement['id'].'" 
                                                    data-title="'.$logement['title'].'" 
                                                    data-prix="'.$logement['prix'].'" 
                                                    data-description="'.$logement['description'].'" 
                                                    data-date_start="'.$logement['date_start'].'" 
                                                    data-date_end="'.$logement['date_end'].'" 
                                                    data-ville="'.$logement['ville'].'" 
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <form action="./../logement_process.php" method="POST">
                                                    <input type = "hidden" name="id" value="'.$logement['id'].'">
                                                    <button type="submit" name="deleteLogement" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition">
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

    <!-- MODAL DE MODIFICATION -->
    <div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                <h3 class="text-xl font-bold">Modifier les détails du logement</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-black text-2xl">&times;</button>
            </div>
            
            <form action="./../logement_process.php" method="POST" enctype="multipart/form-data" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Champ caché pour l'ID -->
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Prix par nuit (€)</label>
                    <input required type="number" name="prix" id="edit-prix" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Date de début</label>
                    <input required type="date" name="date_start" id="edit-start" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Date de fin</label>
                    <input required type="date" name="date_end" id="edit-end" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-500 outline-none transition">
                </div>


                <div class="md:col-span-2 pt-4 flex gap-4">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-100 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Annuler</button>
                    <button type="submit" name="updateLogement" class="flex-1 bg-rose-500 text-white py-3 rounded-xl font-bold hover:bg-rose-600 shadow-lg shadow-rose-200 transition">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // La fonction reçoit 'btn' qui est l'élément <button> cliqué
        function openEditModal(btn) {
            // On accède aux données via dataset
            const id = btn.dataset.id;
            const title = btn.dataset.title;
            const prix = btn.dataset.prix;
            const description = btn.dataset.description;
            const start = btn.dataset.date_start;
            const end = btn.dataset.date_end;
            const ville = btn.dataset.ville;

            // On remplit les champs du formulaire
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-prix').value = prix;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-start').value = start;
            document.getElementById('edit-end').value = end;
            document.getElementById('edit-ville').value = ville;

            // On affiche le modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

    
    </script>
</body>
</html>