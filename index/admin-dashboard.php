<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Luxe & Confort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .nav-link.active { background: #fff1f2; color: #e11d48; border-right: 4px solid #e11d48; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* Style du Toggle Switch */
        .switch { position: relative; display: inline-block; width: 40px; height: 20px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 20px; }
        .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #10b981; }
        input:checked + .slider:before { transform: translateX(20px); }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r z-50 flex flex-col shadow-sm">
        <div class="p-8 text-rose-500 text-3xl font-extrabold flex items-center gap-2 border-b">
            <i class="fa-brands fa-airbnb"></i> admin.
        </div>
        <nav class="mt-6 flex-1">
            <button onclick="openTab('stats')" class="tab-link nav-link active w-full flex items-center gap-3 px-6 py-4 font-bold transition">
                <i class="fa-solid fa-chart-line w-5"></i> Vue d'ensemble
            </button>
            <button onclick="openTab('utilisateurs')" class="tab-link nav-link w-full flex items-center gap-3 px-6 py-4 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-user-gear w-5"></i> Utilisateurs
            </button>
            <button onclick="openTab('logements')" class="tab-link nav-link w-full flex items-center gap-3 px-6 py-4 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-house-chimney"></i> Logements
            </button>
            <button onclick="openTab('annulations')" class="tab-link nav-link w-full flex items-center gap-3 px-6 py-4 font-bold text-slate-500 hover:bg-gray-50 transition">
                <i class="fa-solid fa-calendar-xmark w-5"></i> Annulations
            </button>
        </nav>
        <div class="p-6 border-t">
            <button class="flex items-center gap-3 text-red-500 font-bold hover:bg-red-50 w-full p-3 rounded-xl transition">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="ml-64 flex-1 p-10">

        <!-- SECTION 1 : VUE D'ENSEMBLE -->
        <section id="stats" class="tab-content active">
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900">Dashboard de Gestion</h1>
                <p class="text-slate-500">Statistiques globales et revenus.</p>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white p-6 rounded-3xl border shadow-sm">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-2">Total Utilisateurs</p>
                    <h3 class="text-3xl font-black text-slate-800">1,542</h3>
                </div>
                <div class="bg-white p-6 rounded-3xl border shadow-sm">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-2">Total Logements</p>
                    <h3 class="text-3xl font-black text-slate-800">624</h3>
                </div>
                <div class="bg-white p-6 rounded-3xl border shadow-sm">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-2">Réservations</p>
                    <h3 class="text-3xl font-black text-slate-800">14,210</h3>
                </div>
                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-2">Revenus Totaux</p>
                    <h3 class="text-3xl font-black text-white">458,900 <span class="text-sm text-rose-500 italic">DH</span></h3>
                </div>
            </div>

            <!-- TABLEAU TOP 10 RENTABILITÉ -->
            <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
                <div class="p-6 border-b bg-slate-50/50">
                    <h2 class="font-extrabold text-lg text-slate-800"><i class="fa-solid fa-crown text-amber-400 mr-2"></i> Top 10 Logements Rentables</h2>
                </div>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase font-black border-b">
                            <th class="p-5 text-center">Rang</th>
                            <th class="p-5">Logement</th>
                            <th class="p-5">Hôte</th>
                            <th class="p-5 text-right">Revenu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-5 text-center font-black text-rose-500 text-lg">1</td>
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=200&auto=format&fit=crop" class="w-14 h-10 rounded-lg object-cover shadow-sm">
                                    <span class="font-bold text-slate-800">Villa Atlas Marrakech</span>
                                </div>
                            </td>
                            <td class="p-5 text-slate-500">Youssef B.</td>
                            <td class="p-5 text-right font-black text-emerald-600">82,400 DH</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-5 text-center font-black text-slate-400 text-lg">2</td>
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=200&auto=format&fit=crop" class="w-14 h-10 rounded-lg object-cover shadow-sm">
                                    <span class="font-bold text-slate-800">Penthouse Marina Agadir</span>
                                </div>
                            </td>
                            <td class="p-5 text-slate-500">Sanaa I.</td>
                            <td class="p-5 text-right font-black text-emerald-600">64,150 DH</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2 : UTILISATEURS -->
        <section id="utilisateurs" class="tab-content">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Utilisateurs</h1>
            <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="p-6 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold">YA</div>
                                <div><p class="font-bold text-slate-800">Yassine Alaoui</p><p class="text-xs text-slate-400">yassine@example.com</p></div>
                            </td>
                            <td class="p-6 font-semibold text-sm">Hôte</td>
                            <td class="p-6 text-right">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 3 : LOGEMENTS (AVEC PHOTOS) -->
        <section id="logements" class="tab-content">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Catalogue Logements</h1>
            <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b">
                        <tr class="text-slate-400 text-[10px] font-black uppercase">
                            <th class="p-6">Visuel & Nom</th>
                            <th class="p-6">Localisation</th>
                            <th class="p-6">Prix</th>
                            <th class="p-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="p-6 flex items-center gap-4">
                                <!-- IMAGE FONCTIONNELLE ICI -->
                                <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=300&auto=format&fit=crop" class="w-16 h-12 rounded-xl object-cover border">
                                <span class="font-bold text-slate-800">Appartement Vue Mer</span>
                            </td>
                            <td class="p-6 text-sm">Tanger, Malabata</td>
                            <td class="p-6 font-black">950 DH</td>
                            <td class="p-6 text-right">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-6 flex items-center gap-4">
                                <img src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=300&auto=format&fit=crop" class="w-16 h-12 rounded-xl object-cover border">
                                <span class="font-bold text-slate-800">Cabane Forestière Ifrane</span>
                            </td>
                            <td class="p-6 text-sm">Ifrane</td>
                            <td class="p-6 font-black">1,200 DH</td>
                            <td class="p-6 text-right">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 4 : ANNULATIONS -->
        <section id="annulations" class="tab-content">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Réclamations</h1>
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

    <script>
        function openTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-link').forEach(link => link.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>