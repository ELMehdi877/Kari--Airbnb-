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
                    <i class="fa-solid fa-location-dot text-rose-500"></i> Lyon, France
                </span>
                <span>•</span>
                <span class="text-sm">Annonce publiée le 12 Mai 2023</span>
            </div>
        </header>

        <!-- Image Unique (Format Cinématique) -->
        <div class="w-full h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-12">
            <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&q=80&w=1600" 
                 alt="Intérieur du logement" 
                 class="w-full h-full object-cover">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Colonne de Gauche : Infos Détails -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Infos Hôte & Disponibilité -->
                <div class="flex justify-between items-center border-b pb-8">
                    <div>
                        <h2 class="text-2xl font-bold">Logement entier proposé par Marc</h2>
                        <p class="text-gray-500">2 voyageurs · 1 chambre · 1 salle de bain</p>
                    </div>
                    <img src="https://i.pravatar.cc/150?u=marc" class="w-14 h-14 rounded-full border-2 border-white shadow-md">
                </div>

                <!-- Section Calendrier / Disponibilité -->
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4">
                    <i class="fa-solid fa-calendar-check text-blue-600 text-2xl mt-1"></i>
                    <div>
                        <h3 class="font-bold text-blue-900">Période de disponibilité</h3>
                        <p class="text-blue-800/80">
                            Ce logement est disponible du 
                            <span class="font-semibold underline">15 Juin 2024</span> au 
                            <span class="font-semibold underline">30 Août 2024</span>.
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-xl font-bold mb-4">À propos de ce logement</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Niché au cœur du quartier historique, ce loft allie le charme de l'ancien avec une décoration industrielle moderne. 
                        Entièrement équipé avec des matériaux haut de gamme, il offre un espace de vie spacieux et lumineux, idéal pour les couples 
                        ou les voyageurs d'affaires cherchant une expérience authentique.
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
                <div class="sticky top-24 bg-white border border-gray-200 rounded-3xl p-8 shadow-xl">
                    <div class="flex justify-between items-baseline mb-6">
                        <div>
                            <span class="text-3xl font-black">120 €</span>
                            <span class="text-gray-500"> / nuit</span>
                        </div>
                        <div class="flex items-center gap-1 text-sm font-bold">
                            <i class="fa-solid fa-star text-rose-500"></i> 4.95
                        </div>
                    </div>

                    <!-- Sélecteurs de dates factices -->
                    <div class="border rounded-xl mb-6">
                        <div class="grid grid-cols-2 border-b">
                            <div class="p-3 border-r">
                                <label class="block text-[10px] font-bold uppercase">Arrivée</label>
                                <input type="date" class="w-full text-sm outline-none bg-transparent" >
                            </div>
                            <div class="p-3">
                                <label class="block text-[10px] font-bold uppercase">Départ</label>
                                <input type="date" class="w-full text-sm outline-none bg-transparent" >
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

                    <button class="w-full btn-reserve text-white py-4 rounded-xl font-bold text-lg mb-4">
                        Réserver maintenant
                    </button>

                    <p class="text-center text-sm text-gray-500 mb-6">Aucun débit pour le moment</p>

                    <div class="space-y-3 border-t pt-6 text-gray-600">
                        <div class="flex justify-between">
                            <span class="underline">120 € x 7 nuits</span>
                            <span>840 €</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="underline">Frais de service</span>
                            <span>45 €</span>
                        </div>
                        <div class="flex justify-between font-bold text-gray-900 text-lg border-t pt-3">
                            <span>Total</span>
                            <span>885 €</span>
                        </div>
                    </div>
                </div>
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