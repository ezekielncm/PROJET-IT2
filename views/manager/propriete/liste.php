<?php require_once VIEW_PATH . 'manager/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/manager.css">

<main class="manager-main-content">
    <section class="manager-section-proprietes">
        <h2 class="manager-title">Liste des propriétés</h2>
        <div class="manager-grid-proprietes">
            <?php foreach ($proprietes as $propriete): ?>
                <div class="manager-card-propriete">
                    <div class="manager-card-img-wrapper">
                        <img src="/assets/images/<?= htmlspecialchars($propriete['objet']->getImage1()) ?>" alt="Propriété" class="manager-card-img" loading="lazy">
                    </div>
                    <div class="manager-card-body">
                        <h5 class="manager-card-price">
                            <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> FCFA
                        </h5>
                        <p class="manager-card-desc"><?= htmlspecialchars(substr($propriete['objet']->getDescription(), 0, 100)) ?>...</p>
                        <p class="manager-card-info">Mise en : <span><?= htmlspecialchars($propriete['objet']->getOpt()) ?></span></p>
                        <p class="manager-card-info">Type : <span><?= htmlspecialchars($propriete['type']->getlibele()) ?></span></p>
                        <p class="manager-card-info">Etat : <span><?= htmlspecialchars($propriete['objet']->getEtat()) ?></span></p>
                        <a href="/detail?id=<?= base64_encode($propriete['id']) ?>" class="manager-btn manager-btn-primary">Voir plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php
    // Variables par défaut si elles ne sont pas déjà définies
    $page = $page ?? 1;
    $total_pages = $total_pages ?? 1;
?>

<div class="manager-pagination-wrapper">
    <nav class="manager-pagination" aria-label="Pagination">
        <!-- Page précédente -->
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="manager-pagination-btn manager-pagination-prev">Précédent</a>
        <?php else : ?>
            <span class="manager-pagination-btn manager-pagination-disabled">Précédent</span>
        <?php endif; ?>

        <!-- Pages numérotées -->
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a href="?page=<?= $i ?>" class="manager-pagination-btn <?= $i == $page ? 'manager-pagination-active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Page suivante -->
        <?php if ($page < $total_pages) : ?>
            <a href="?page=<?= $page + 1 ?>" class="manager-pagination-btn manager-pagination-next">Suivant</a>
        <?php else : ?>
            <span class="manager-pagination-btn manager-pagination-disabled">Suivant</span>
        <?php endif; ?>
    </nav>
</div>

<?php require_once VIEW_PATH . 'manager/layout/footer.php'; ?>