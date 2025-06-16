<?php require_once VIEW_PATH . 'client/layout/header.php'; ?>

<!-- Message flash -->
<?php if (isset($_SESSION['msg'])): ?>
    <div id="flash-message" class="detail-flash-message">
        <?= $_SESSION['msg'] ?>
        <?php unset($_SESSION['msg']); ?>
    </div>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('flash-message');
            if (msg) {
                msg.classList.add('detail-flash-out');
                setTimeout(() => msg.remove(), 500);
            }
        }, 3000);
    </script>
<?php endif; ?>

<div class="detail-prop-container">
    <?php foreach ($proprietes as $propriete): ?>
        <div class="detail-prop-card">
            <!-- Galerie d'images -->
            <div class="detail-prop-gallery">
                <div class="detail-prop-mainimg">
                    <img src="/assets/images/<?= $propriete['objet']->getImage1() ?>" alt="Image 1">
                </div>
                <div class="detail-prop-sideimgs">
                    <img src="/assets/images/<?= $propriete['objet']->getImage2() ?>" alt="Image 2">
                    <img src="/assets/images/<?= $propriete['objet']->getImage3() ?>" alt="Image 3">
                </div>
            </div>
            <!-- Détails de la propriété -->
            <div class="detail-prop-infos">
                <div class="detail-prop-desc">
                    <p><?= $propriete['objet']->getDescription() ?></p>
                    <?php if( $propriete['objet']->getOpt() =="Vente"):?>
                    <p><strong>Prix :</strong> <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</p>
                    <?php else: ?>
                        <p><strong>Montant Mensuel:</strong> <?= number_format($propriete['objet']->getPrix(), 0, ',', ' ') ?> CFA</p>
                    <?php endif; ?>
                    <p><strong>Adresse :</strong> <?= $propriete['objet']->getAdresse() ?></p>
                    <p><strong>Type :</strong> <?= $propriete['type']->getlibele() ?></p>
                    <p><strong>Statut :</strong> <?= $propriete['objet']->getEtat() ?></p>
                    <p><strong>Option :</strong> <?= $propriete['objet']->getOpt() ?></p>
                    <p><strong>Date de publication :</strong> <?= date('d/m/Y', strtotime($propriete['objet']->getDate())) ?></p>
                    <?php $_SESSION['id_bailleur']= $propriete['objet']->getIdbailleur() ?>
                </div>
                <!-- Actions -->
                <?php $_SESSION['id_proprietes']= $propriete['id'] ?>
                <div class="detail-prop-actions">
                    <a href="/rendez-vous?id=<?= base64_encode($propriete['id']) ?>" class="detail-btn detail-btn-blue">Demander une visite</a>
                    <?php if ($_SESSION['id_client']): ?>
                        <a href="/ajouter-favoris?id=<?= base64_encode($propriete['id']) ?>" class="detail-btn detail-btn-green">Ajouter aux favoris</a>
                        <a href="/client/discusion/proprio?id=<?= base64_encode($propriete['objet']->getIdbailleur()) ?>" class="detail-btn detail-btn-grey">Discuter avec le propriétaire</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


