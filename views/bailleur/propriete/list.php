<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>


<div class="max-w-7xl mx-auto px-4 pt-12">
    <a href="/bailleur" class="bailleur-prop-back">← Retour</a>

    <section>
        <!-- Grille des propriétés -->
        <div class="bailleur-prop-grid">
            <?php foreach ($proprietes as $propriete): ?>
                <div class="bailleur-prop-card">
                    <img src="assets/images/<?= htmlspecialchars($propriete['objet']->getImage1()) ?>" alt="Propriété" class="bailleur-prop-img">
                    <div class="bailleur-prop-card-body">
                        <h5 class="bailleur-prop-price">
                            <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> FCFA
                        </h5>
                        <p class="bailleur-prop-info">
                            Mise en : <span><?= $propriete['objet']->getOpt() ?></span>
                        </p>
                        <p class="bailleur-prop-info">
                            Type : <span><?= $propriete['type']->getlibele() ?></span>
                        </p>
                        <p class="bailleur-prop-info">
                            Etat : <span><?= $propriete['objet']->getEtat() ?></span>
                        </p>
                        <a href="/detail_propriete?id=<?= base64_encode($propriete['id']) ?>" class="bailleur-prop-btn">Voir plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php
        $page = $page ?? 1;
        $total_pages = $total_pages ?? 1;
    ?>

    <!-- Pagination -->
    <div class="bailleur-prop-pagination">
        <nav aria-label="Pagination">
            <!-- Page précédente -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="bailleur-prop-page-btn">Précédent</a>
            <?php else: ?>
                <span class="bailleur-prop-page-btn disabled">Précédent</span>
            <?php endif; ?>

            <!-- Pages numérotées -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="bailleur-prop-page-btn<?= $i == $page ? ' active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <!-- Page suivante -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="bailleur-prop-page-btn">Suivant</a>
            <?php else: ?>
                <span class="bailleur-prop-page-btn disabled">Suivant</span>
            <?php endif; ?>
        </nav>
    </div>
</div>
