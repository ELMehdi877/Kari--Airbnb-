<?php 
require_once __DIR__ . "/../config/database.php";
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["statut"] === 0) { 
    header("Location: ./../index.html");
    exit;
}

// Récupération des données utilisateur en temps réel
$pdo = Database::connect();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Définition des couleurs de statut
$statusLabel = ($user['statut'] == 1) ? 'Compte Actif' : 'Compte Restreint';
$statusColor = ($user['statut'] == 1) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';

// Gestion de la photo (chemin par défaut si vide)
$userPhoto = !empty($user['photo']) ? "../uploads/profiles/" . $user['photo'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil Premium - Airbnb</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .input-premium { transition: all 0.3s ease; border: 1px solid #e2e8f0; }
        .input-premium:focus { border-color: #f43f5e; box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.1); outline: none; }
        .profile-gradient { background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%); }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r hidden lg:flex flex-col z-[60]">
        <div class="p-6 text-rose-500 text-3xl font-bold flex items-center gap-1 border-b">
            <i class="fa-brands fa-airbnb"></i>
            <span class="tracking-tighter text-black">airbnb</span>
        </div>
        <nav class="flex-1 p-4 space-y-2 mt-4">
            <a href="index.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-xl transition font-medium">
                <i class="fa-solid fa-house w-5"></i> Accueil
            </a>
            <a href="reservation.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-xl transition font-medium">
                <i class="fa-solid fa-calendar-check w-5"></i> Mes Réservations
            </a>
            <a href="favoris.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-xl transition font-medium">
                <i class="fa-solid fa-heart w-5"></i> Favoris
            </a>
            <hr class="my-4 border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase px-3 mb-2">Gestion</p>
            <a href="profil.php" class="flex items-center gap-3 p-3 bg-rose-50 text-rose-500 rounded-xl transition font-bold">
                <i class="fa-solid fa-user w-5"></i> Mon Profil
            </a>            
            <?php if ($_SESSION["role"] === "Hote"): ?>
                <a href="logementsHost.php" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-rose-50 hover:text-rose-500 rounded-xl transition font-medium">
                    <i class="fa-solid fa-list-check w-5"></i> Mes annonces
                </a>
            <?php endif; ?>
        </nav>
        <form action="logout.php" method="POST" class="p-4 border-t">
            <button name="logout" class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded-xl transition font-medium w-full text-left">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Déconnexion
            </button>
        </form>
    </aside>

    <!-- WRAPPER PRINCIPAL -->
    <div class="lg:ml-64 min-h-screen">
        
        <main class="p-6 lg:p-12 max-w-6xl mx-auto">
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Mon Profil</h1>
                <p class="text-gray-500 mt-1">Personnalisez votre présence sur la plateforme.</p>
            </div>

            <form action="process_update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- COLONNE GAUCHE : PHOTO & STATUT -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/60 border border-slate-100 text-center relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-24 profile-gradient"></div>
                            
                            <!-- PHOTO DE PROFIL AVEC OVERLAY MODIFICATION -->
                            <div class="relative mt-4 inline-block group">
                                <div class="w-32 h-32 bg-white rounded-full mx-auto p-1 shadow-lg overflow-hidden border-4 border-white">
                                    <?php if($userPhoto): ?>
                                        <img id="preview" src="<?= $userPhoto ?>" class="w-full h-full object-cover rounded-full">
                                    <?php else: ?>
                                        <div id="placeholder" class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-4xl font-bold text-rose-500 uppercase">
                                            <?= substr($user['fullname'], 0, 1) ?>
                                        </div>
                                        <img id="preview" src="#" class="hidden w-full h-full object-cover rounded-full">
                                    <?php endif; ?>
                                </div>
                                <!-- Bouton Caméra -->
                                <label for="photo" class="absolute bottom-1 right-1 bg-white w-10 h-10 rounded-full shadow-md flex items-center justify-center text-rose-500 cursor-pointer hover:scale-110 transition active:scale-95 border border-gray-100">
                                    <i class="fa-solid fa-camera"></i>
                                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>

                            <div class="mt-4">
                                <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($user['fullname']) ?></h2>
                                <p class="text-sm text-gray-400 font-medium italic">@<?= strtolower(str_replace(' ', '', $user['fullname'])) ?></p>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <div class="flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    <span class="text-xs font-bold text-gray-600 uppercase tracking-wider"><?= $user['role'] ?></span>
                                </div>
                                <div class="flex items-center justify-center gap-2 px-4 py-2 rounded-2xl <?= $statusColor ?> border border-current opacity-80">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                    <span class="text-xs font-bold uppercase tracking-wider"><?= $statusLabel ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- STATS RAPIDES -->
                        <div class="bg-white rounded-[2rem] p-6 shadow-lg border border-slate-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-widest">Activité</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-slate-50 rounded-2xl">
                                    <p class="text-xl font-black text-gray-800">12</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">Séjours</p>
                                </div>
                                <div class="text-center p-4 bg-slate-50 rounded-2xl">
                                    <p class="text-xl font-black text-gray-800">4.9</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">Note</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COLONNE DROITE : FORMULAIRE -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-[2.5rem] p-8 lg:p-10 shadow-xl shadow-slate-200/60 border border-slate-100">
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Informations personnelles</h3>
                                    <p class="text-sm text-gray-500">Ces informations seront visibles par les hôtes lors de vos réservations.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- NOM -->
                                <div class="space-y-3">
                                    <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                        <i class="fa-solid fa-signature text-rose-500 text-xs"></i> Nom complet
                                    </label>
                                    <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" 
                                    class="input-premium w-full px-5 py-4 bg-slate-50/50 rounded-2xl focus:bg-white transition-all font-medium text-gray-700">
                                </div>

                                <!-- EMAIL -->
                                <div class="space-y-3">
                                    <label class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                        <i class="fa-solid fa-envelope text-rose-500 text-xs"></i> Adresse Email
                                    </label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                    class="input-premium w-full px-5 py-4 bg-slate-50/50 rounded-2xl focus:bg-white transition-all font-medium text-gray-700">
                                </div>

                                
                                <!-- ROLE (LECTURE SEULE) -->
                                <div class="space-y-3">
                                    <label class="text-sm font-bold text-gray-400 flex items-center gap-2">
                                        <i class="fa-solid fa-lock text-xs"></i> Type de compte
                                    </label>
                                    <div class="w-full px-5 py-4 bg-gray-100 text-gray-500 rounded-2xl border border-transparent font-bold cursor-not-allowed">
                                        <?= $user['role'] ?>
                                    </div>
                                </div>

                                <!-- DATE INSCRIPTION -->
                                <div class="space-y-3">
                                    <label class="text-sm font-bold text-gray-400 flex items-center gap-2">
                                        <i class="fa-solid fa-calendar text-xs"></i> Date d'inscription
                                    </label>
                                    <div class="w-full px-5 py-4 bg-gray-100 text-gray-500 rounded-2xl border border-transparent font-bold cursor-not-allowed">
                                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                                    </div>
                                </div>
                                <!-- PASSWORD -->
                              <div class="space-y-2 col-span-2">
                                  <label class="text-sm font-bold text-gray-700 ml-1">Changer le mot de passe</label>
                                  <div class="relative">
                                      <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                      <input type="password" name="new_password" 
                                      class="input-premium w-full pl-11 pr-4 py-3.5 bg-gray-50/50 rounded-2xl focus:bg-white transition-all" placeholder="Laisser vide pour ne pas modifier">
                                  </div>
                              </div>
                            </div>

                            <div class="mt-10 pt-10 border-t border-slate-100">
                                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                    <div class="flex items-center gap-3 text-amber-600 bg-amber-50 px-4 py-2 rounded-xl">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <p class="text-xs font-bold">Vérifiez vos données avant d'enregistrer.</p>
                                    </div>
                                    <div class="flex gap-4 w-full md:w-auto">
                                        <button type="reset" class="flex-1 md:flex-none px-8 py-4 rounded-2xl text-sm font-bold text-gray-500 hover:bg-slate-100 transition">
                                            Annuler
                                        </button>
                                        <button type="submit" name="update_profile" class="flex-1 md:flex-none px-10 py-4 bg-gray-900 text-white rounded-2xl text-sm font-bold shadow-xl hover:bg-rose-500 transition-all active:scale-95 shadow-gray-200">
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Fonction pour prévisualiser l'image avant l'upload
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>