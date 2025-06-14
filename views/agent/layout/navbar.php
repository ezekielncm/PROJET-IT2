<script src="https://cdn.tailwindcss.com"></script>

<!-- Sidebar Agent -->
<div class="flex min-h-screen">
  <aside class="w-64 bg-blue-700 text-white p-6 space-y-6">
    <h2 class="text-2xl font-bold">Espace Agent</h2>
    <nav class="space-y-2">
      <a href="/connexion-agent" class="block px-4 py-2 rounded hover:bg-blue-600">Tableau de bord</a>

      <a href="/demandes-validation" class="block px-4 py-2 rounded hover:bg-blue-600">Demandes à valider</a>

      <a href="/clients-attribues" class="block px-4 py-2 rounded hover:bg-blue-600">Clients attribués</a>
      <a href="/listes-achat-valider" class="block px-4 py-2 rounded hover:bg-blue-600">Valider les d'achat</a>
      <a href="/clients-rdv-bailleurs" class="block px-4 py-2 rounded hover:bg-blue-600">Rendez-vous</a>

      <a href="/mon-profile" class="block px-4 py-2 rounded hover:bg-blue-600">Mon profil</a>

      <a href="#"
        onclick="openLogoutModal()"
        class="block px-4 py-2 rounded hover:bg-red-600 text-red-200">
        Déconnexion
      </a>
      <!-- Modal de confirmation -->
      <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirmer la déconnexion</h2>
          <p class="text-sm text-gray-600 mb-6">Êtes-vous sûr de vouloir vous déconnecter ?</p>
          <div class="flex justify-end space-x-3">
            <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
              Annuler
            </button>
            <a href="/se-deconnecter" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
              Se déconnecter
            </a>
          </div>
        </div>
      </div>



    </nav>
  </aside>

  <script>
    function openLogoutModal() {
      document.getElementById('logoutModal').classList.remove('hidden');
    }

    function closeLogoutModal() {
      document.getElementById('logoutModal').classList.add('hidden');
    }
  </script>