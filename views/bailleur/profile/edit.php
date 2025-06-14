<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="flex items-center justify-center min-h-screen bg-gray-100 px-4 pt-24 pb-24">
    <div class="bg-white shadow-lg rounded-2xl px-8 pt-10 pb-8 w-full max-w-3xl">
        <h2 class="text-2xl font-bold text-blue-700 text-center mb-8">Mes Informations</h2>

        <form method="POST" action="/maj-mon-profil" class="grid grid-cols-1 md:grid-cols-2 gap-4" onsubmit="return validateForm()">
            <?php foreach ($bail as $bl): ?>

                <div>
                    <label for="nom" class="block text-gray-700 font-medium text-sm">Nom</label>
                    <input type="text" name="nom" id="nom" value="<?= $bl['objet']->getNom() ?>" required
                        class="w-full mt-1 p-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="family-name">
                </div>

                <div>
                    <label for="prenom" class="block text-gray-700 font-medium text-sm">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="<?= $bl['objet']->getPrenom() ?>" required
                        class="w-full mt-1 p-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="given-name">
                </div>

                <div>
                    <label for="raison_social" class="block text-gray-700 font-medium">Raison sociale</label>
                    <input type="text" name="raison_social" id="raison_social " value="<?= $bl['objet']->getRaisonSocial() ?>" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400">
                </div>

                <div class="md:col-span-2">
                    <label for="adresse" class="block text-gray-700 font-medium text-sm">Adresse</label>
                    <input type="text" name="adresse" id="adresse" value="<?= $bl['objet']->getAdresse() ?>" required
                        class="w-full mt-1 p-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="street-address">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium text-sm">Email</label>
                    <input type="email" name="email" id="email" value="<?= $bl['objet']->getEmail() ?>" required
                        class="w-full mt-1 p-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="email">
                </div>

                <div>
                    <label for="telephone" class="block text-gray-700 font-medium text-sm">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone" value="<?= $bl['objet']->getTelephone() ?>" pattern="^\+?\d{8,15}$"
                        required
                        class="w-full mt-1 p-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="+226xxxxxxxx" autocomplete="tel">
                </div>

            <?php endforeach; ?>

            <div class="md:col-span-2">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-3 rounded-lg transition duration-200">
                    Mettre à jour mes informations
                </button>
            </div>

            <div class="md:col-span-2">
                <a href="/Mon-profil?id=<?=base64_encode ($_SESSION['id'])?>"
                    class="w-full inline-block text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold text-sm py-3 rounded-lg transition duration-200">
                    Retour
                </a>
            </div>
        </form>

        <script>
            function validateForm() {
                const tel = document.getElementById('telephone').value;
                const telRegex = /^\+?\d{8,15}$/;
                if (!telRegex.test(tel)) {
                    alert("Veuillez entrer un numéro de téléphone valide (8 à 15 chiffres, avec ou sans '+').");
                    return false;
                }
                return true;
            }
        </script>
    </div>
</div>