<?php require_once VIEW_PATH . 'client/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/client.css">

<div class="client-favoris-flash-wrapper">
    <?php if (isset($_SESSION['msg'])): ?>
        <div id="flash-message" class="client-flash-success animate-slide-in">
            <?= htmlspecialchars($_SESSION['msg']) ?>
            <?php unset($_SESSION['msg']); ?>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('flash-message');
                if (msg) {
                    msg.classList.add('animate-slide-out');
                    setTimeout(() => msg.remove(), 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>
</div>
<div class="client-favoris-retour">
    <a href="/client" class="client-link-retour">← Retour</a>
</div>

<main class="client-favoris-main">
    <h1 class="client-favoris-title">Mes favoris</h1>

    <?php if (!empty($msg)): ?>
        <div class="client-flash-warning">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($favoris)): ?>
        <ul class="client-favoris-list">
            <?php foreach ($favoris as $fav): ?>
                <li class="client-favoris-card">
                    <img src="/assets/images/<?= htmlspecialchars($fav['image1']) ?>" alt="Image" class="client-favoris-img" loading="lazy">
                    <div class="client-favoris-card-body">
                        <p class="client-favoris-card-title"><?= htmlspecialchars($fav['libelle']) ?></p>
                        <p class="client-favoris-card-price"><?= number_format($fav['prix'], 0, ',', ' ') ?> FCFA</p>
                        <div class="client-favoris-card-actions">
                            <a href="/Espace-client/proprietes/detail?id=<?= base64_encode($fav['id_propiete']) ?>" class="client-btn client-btn-primary">Voir la propriété</a>
                            <?php isset($fav['id_favoris']) ? $_SESSION['id_favoris'] = $fav['id_favoris'] : null ?>
                            <a href="/supprimer-favoris" class="client-btn client-btn-danger">Supprimer</a>
                            <?php if ($fav['opt'] === 'Vente') : ?>
                                <a href="/acheter-cette-propriete?id=<?= base64_encode($fav['id_propiete']) ?>" class="client-btn client-btn-success">Acheter</a>
                            <?php else: ?>
                                <a href="/louer-cette-propriete?id=<?= base64_encode($fav['id_propiete']) ?>" class="client-btn client-btn-success">Louer</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="client-favoris-empty">
            <p>Vous n'avez pas encore de propriétés favorites.</p>
        </div>
    <?php endif; ?>

    <?php if (!empty($totalPages) && $totalPages > 1): ?>
        <div class="client-favoris-pagination-wrapper">
            <nav class="client-favoris-pagination" aria-label="Pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=<?= $currentPage - 1 ?>" class="client-pagination-btn client-pagination-prev">Précédent</a>
                <?php else: ?>
                    <span class="client-pagination-btn client-pagination-disabled">Précédent</span>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="client-pagination-btn <?= $i == $currentPage ? 'client-pagination-active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?= $currentPage + 1 ?>" class="client-pagination-btn client-pagination-next">Suivant</a>
                <?php else: ?>
                    <span class="client-pagination-btn client-pagination-disabled">Suivant</span>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</main>