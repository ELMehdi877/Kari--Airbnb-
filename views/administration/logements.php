<?php
session_start();
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../repositories/AdminRepository.php";
// require_once __DIR__ . "/service/AdminService.php";
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ./index.html");
    exit;
}
$pdo = Database::connect();
$AdminRepo = new AdminRepository($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Vue d'ensemble</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .nav-link.active { background: #fff1f2; color: #e11d48; border-right: 4px solid #e11d48; }
        .nav-item-top.active { border-bottom: 3px solid #e11d48; color: #e11d48; background: #fff1f2; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR (Identique à l'index) -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r hidden lg:flex flex-col z-[60]">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center gap-1 border-b">
            <i class="fa-brands fa-airbnb"></i>
            <span class="tracking-tighter">airbnb</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 mt-4">
            <a href="./../index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-house w-5"></i> Accueil
            </a>
            <a href="./../reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
            </a>
            <!-- ACTIF -->
            <a href="./../favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-heart w-5"></i> Favoris
            </a>

            <hr class="my-4">
            <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

            <a href="./../profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-user w-5"></i> Mon Profil
            </a>            
            <a href="dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium group">
                <i class="fa-solid fa-sliders w-5 text-lg group-hover:scale-110 transition-transform"></i>Administration
            </a>
        </nav>
        <form action="./../logout.php" method="POST" class="p-4 border-t">
            <button name="logout" class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-lg transition font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT -->
    <!-- Garder le même HEAD et le même SIDEBAR -->

    <main class="ml-64 flex-1 p-10">
        <!-- NAVBAR HORIZONTALE (Logements actif) -->
        <nav class="flex bg-white border rounded-2xl mb-10 shadow-sm overflow-hidden">
            <a href="dashboard.php" class="nav-item-top active px-6 py-4 flex items-center gap-2 font-bold transition">
                <i class="fa-solid fa-chart-line"></i> Stats
            </a>
            <a href="utilisateurs.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-user-gear"></i> Utilisateurs
            </a>
            <a href="logements.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition group">
                <i class="fa-solid fa-couch w-5 text-lg group-hover:-rotate-3 transition-transform"></i> Logements
            </a>
            <a href="annulations.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-calendar-xmark"></i> Annulations
            </a>
        </nav>

        <section id="logements">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Catalogue Logements</h1>
            <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b">
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase text-slate-600">
                            <th class="px-6 py-4">Visuel & Nom</th>
                            <th class="px-6 py-4">Localisation</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">statut</th>
                            <th class="px-6 py-4">date de creation</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $result = $AdminRepo->afficheLogement(); ?>
                        <?php foreach($result as $logement) :  ?>
                        
                            <tr>
                                <td class="p-6 flex items-center gap-4">
                                    <img src="/KARI/image/logement/<?= $logement["image_path"] ?>" class="w-16 h-12 rounded-xl object-cover border">
                                    <span class="font-bold text-slate-800"><?= $logement["title"] ?></span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <i class="fa-solid fa-location-dot text-xs"></i>
                                    <?= $logement["ville"] ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?= $logement["prix"] ?> DH</td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?= $logement["statut"] === 1 ? "Active" : "Inactive" ?></td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?= $logement["created_at"] ?></td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <form action="./../../Admin_process.php" method="POST">
                                    <button type="submit" name="button_active" value="1" class="cursor-pointer p-2 group outline-none bg-transparent border-none">
                                            <!-- Icône pleine, verte, avec un effet de lueur au survol -->
                                            <input type="hidden" name="logement_id_statut" value = <?= $logement["id"] ?> >
                                            <i class="fa-solid fa-circle-check text-2xl text-emerald-500 drop-shadow-md group-hover:text-emerald-400 transition-colors"></i>
                                        </button>

                                        <button type="submit" name="button_desactive" value="0" class="cursor-pointer p-2 group outline-none bg-transparent border-none">
                                            <!-- Icône vide, grise, qui devient verte au survol de la souris -->
                                            <input type="hidden" name="logement_id_statut" value =  <?= $logement["id"] ?> >
                                            <i class="fa-regular fa-circle-check text-2xl text-red-600 drop-shadow-sm group-hover:text-red-300 group-hover:fa-solid transition-all"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>