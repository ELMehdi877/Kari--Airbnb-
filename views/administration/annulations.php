<?php
session_start();
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../repositories/AdminRepository.php";
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
    <main class="ml-64 flex-1 p-10">
        <!-- NAVBAR HORIZONTALE (Annulations actif) -->
        <nav class="flex bg-white border rounded-2xl mb-10 shadow-sm overflow-hidden">
            <a href="dashboard.php" class="nav-item-top active px-6 py-4 flex items-center gap-2 font-bold transition">
                <i class="fa-solid fa-chart-line"></i> Stats
            </a>
            <a href="utilisateurs.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-user-gear"></i> Utilisateurs
            </a>
            <a href="logements.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition group">
                <i class="fa-solid fa-couch w-5 text-lg group-hover:-rotate-3 transition-transform"></i> 
                Logements
            </a>
            <a href="annulations.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-calendar-xmark"></i> Annulations
            </a>
        </nav>

        <section id="annulations" class="py-8">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Réclamations & Annulations</h1>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Hébergement</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Réservateur</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Date Début</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Date Fin</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Prix</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600">Localisation</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-slate-600 ">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $result = $AdminRepo->getAllReservation(); ?>
                            <?php foreach($result as $reservation) :  ?>
                                <!-- Ligne 1 -->
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <img src="/KARI/image/logement/<?= $reservation["image_path"] ?>"
                                                class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                            <div>
                                                <p class="font-bold text-slate-900 text-sm"><?= $reservation["title"] ?></p>
                                                <p class="text-xs text-slate-500">#RES-9921</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-medium text-slate-700"><?= $reservation["fullname"] ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600"><?= $reservation["date_start"] ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600"><?= $reservation["date_end"] ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600"><?= $reservation["prix"] ?> DH</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1 text-slate-500">
                                            <i class="fa-solid fa-location-dot text-xs"></i>
                                            <span class="text-xs italic"><?= $reservation["ville"] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <form action="./../../Admin_process.php" method="POST">
                                            <button class="bg-slate-900 text-white px-4 py-2 rounded-xl font-bold text-[10px] uppercase tracking-wider hover:bg-red-600 transition-all shadow-md active:scale-95">
                                                Annuler
                                                <input type="hidden" name="annulation" value="<?= $reservation["id"] ?>">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
</html>