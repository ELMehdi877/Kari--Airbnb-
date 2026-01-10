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
            <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-house w-5"></i> Accueil
            </a>
            <a href="reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
            </a>
            <!-- ACTIF -->
            <a href="favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-heart w-5"></i> Favoris
            </a>

            <hr class="my-4">
            <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>

            <a href="profil.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                <i class="fa-solid fa-user w-5"></i> Mon Profil
            </a>            
            <!-- <?php if ($_SESSION["role"] === "Hote"): ?>
                <a href="logementsHost.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                    <i class="fa-solid fa-list-check w-5"></i> Mes annonces
                </a>
                <a href="host-dashboard.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-lg transition font-medium">
                    <i class="fa-solid fa-plus-circle w-5"></i> Ajouter un logement
                </a>
            <?php endif; ?> -->
        </nav>
        <form action="logout.php" method="POST" class="p-4 border-t">
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
            <a href="logements.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-house-chimney"></i> Logements
            </a>
            <a href="annulations.php" class="nav-item-top px-6 py-4 flex items-center gap-2 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-calendar-xmark"></i> Annulations
            </a>
        </nav>

        <section id="annulations">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Réclamations & Annulations</h1>
            <div class="bg-white p-6 rounded-3xl border shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=100&auto=format&fit=crop" class="w-12 h-12 rounded-xl object-cover">
                    <div>
                        <h4 class="font-bold">#RES-9921 - Studio Casa</h4>
                        <p class="text-xs text-slate-500">Client: Adam Smith</p>
                    </div>
                </div>
                <button class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold text-xs hover:bg-red-600 transition shadow-lg">
                    ANNULER RÉSERVATION
                </button>
            </div>
        </section>
    </main>
</body>
</html>