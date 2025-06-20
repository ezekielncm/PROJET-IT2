<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<main class="manager-profile-container" aria-label="Profil du manager">
    <h1>Profil du manager</h1>
    <section class="manager-profile-card">
        <ul class="manager-profile-details">
            <li><span class="profile-label">Nom :</span> <b><?= htmlspecialchars($manager->getNom()) ?></b></li>
            <li><span class="profile-label">Prénom :</span> <b><?= htmlspecialchars($manager->getPrenom()) ?></b></li>
            <li><span class="profile-label">Email :</span> <b><?= htmlspecialchars($manager->getEmail()) ?></b></li>
            <li><span class="profile-label">Rôle :</span> <b>Manager</b></li>
        </ul>
        <a href="/manager/editer-profile" class="btn btn-edit">Modifier mon profil</a>
    </section>
</main>
<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>
