<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php require_once VIEW_PATH . 'agent/layout/header.php'; ?>
<body class="bg-gray-100 font-sans">

<?php if (isset($_SESSION['id_agent'])) : ?>
    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <header class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Bienvenue, <?= $_SESSION['nom'].' ' .$_SESSION['prenom'] ?? 'Agent' ?> 👋</h1>
            <p class="text-gray-600">Voici votre tableau de bord.</p>
        </header>

        <?php if (isset($_SESSION['success_maj'])) : ?>
            <div id="flashMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-out">
                <?= htmlspecialchars($_SESSION['success_maj']) ?>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('flashMessage');
                    if (msg) msg.style.display = 'none';
                }, 5000);
            </script>
            <style>
                @keyframes fadeInOut {
                    0% { opacity: 0; transform: translateY(-10px); }
                    10% { opacity: 1; transform: translateY(0); }
                    90% { opacity: 1; transform: translateY(0); }
                    100% { opacity: 0; transform: translateY(-10px); }
                }
                .animate-fade-in-out {
                    animation: fadeInOut 5s ease-in-out forwards;
                }
            </style>
            <?php unset($_SESSION['success_maj']); ?>
        <?php endif; ?>

        <!-- Statistiques (exemples dynamiques à adapter) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-gray-700 text-lg font-bold mb-2">Demandes en attente</h3>
                <p class="text-3xl font-semibold text-red-600"><?= $nb_demandes ?? 0 ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-gray-700 text-lg font-bold mb-2">Clients attribués</h3>
                <p class="text-3xl font-semibold text-blue-600"><?= $nb_clients ?? 0 ?></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-gray-700 text-lg font-bold mb-2">Rendez-vous planifiés</h3>
                <p class="text-3xl font-semibold text-green-600"><?= $nb_rdv ?? 0 ?></p>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Actions rapides</h2>
            <div class="space-x-4">
                <a href="/demandes-validation" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Voir les demandes à valider</a>
                <a href="/clients-attribues" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Liste des clients</a>
                <a href="/clients-rdv-bailleurs" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Voir les rendez-vous</a>
                <a href="/mon-profile" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Mon profil</a>
            </div>
            <p class="text-sm text-red-600 mt-2">⚠️ Modification du profil soumise à l'approbation du manager.</p>
        </div>
    </main>

<?php else : ?>
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-red-600">Erreur</h2>
            <p class="text-gray-700">Vous devez être connecté pour accéder à cette page.</p>
            <a href="/agent" class="text-blue-600 hover:underline">Se connecter</a>
        </div>
    </div>
<?php endif; ?>

</body>
</html>

