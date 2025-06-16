<?php require_once VIEW_PATH . 'client/layout/header.php'; ?>

<div class="dashboard-container">
  <div class="dashboard-header">
    <h1>Bienvenue sur votre Dashboard, <strong><?= isset($_SESSION['prenom_client']) ? htmlspecialchars($_SESSION['prenom_client'].' '.$_SESSION['nom_client'] ): ''  ?> </strong>👋</h1>
    <p>Voici votre tableau de bord.</p>
</div>
  <div class="dashboard-cards">
    <!-- Mes propriétés -->
    <a href="/mes-proprietes" class="dashboard-card">
      <h2>Mes propriétés louées | achetées</h2>
      <p class="dashboard-card-nb dashboard-blue"><?= isset($nbr_proprietes_louer)? htmlspecialchars($nbr_proprietes_louer ): 0 ?> | <?= isset($nombresAchat)? htmlspecialchars($nombresAchat ): 0 ?></p>
      <span>Voir mes annonces publiées</span>
    </a>
    <!-- Mes rendez-vous -->
    <a href="/mes-rendez-vous" class="dashboard-card">
      <h2>Rendez-vous à venir</h2>
      <p class="dashboard-card-nb dashboard-green"><?= isset($rdvAvenir)?$rdvAvenir :0?></p>
      <span>Voir le planning</span>
    </a>
    <!-- Mes favoris -->
    <a href="/propriete/mes-proprietes-favoris" class="dashboard-card">
      <h2>Favoris</h2>
      <p class="dashboard-card-nb dashboard-pink"><?= isset($nombreFavoris) ?  $nombreFavoris :0 ?></p>
      <span>Voir les biens enregistrés</span>
    </a>
  </div>
</div>

<!-- Modal de déconnexion -->
<div id="logoutModal" class="logout-modal hidden">
  <div class="logout-modal-content">
    <h2>Confirmer la déconnexion</h2>
    <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
    <div class="logout-modal-actions">
      <button onclick="closeLogoutModal()" class="logout-cancel">Annuler</button>
      <a href="/logout" class="logout-confirm">Se déconnecter</a>
    </div>
  </div>
</div>

<script>
  function openLogoutModal() {
    document.getElementById('logoutModal').classList.remove('hidden');
  }
  function closeLogoutModal() {
    document.getElementById('logoutModal').classList.add('hidden');
  }
</script>
