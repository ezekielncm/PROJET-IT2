<?php
// Vue : Liste des clients, bailleurs et agents pour le manager UrbanHome
require_once __DIR__ . '/../layout/header.php';
?>
<main class="manager-listes">
    <h1 class="manager-listes-title">Utilisateurs de la plateforme</h1>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-message success"> <?= htmlspecialchars($_SESSION['success']) ?> </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-message error"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="manager-listes-sections">
        <section class="manager-listes-block">
            <h2>Clients</h2>
            <div class="manager-cards">
                <?php if (!empty($clients)) : foreach ($clients as $c) : $client = $c['objet']; ?>
                <div class="manager-card">
                    <div class="manager-card-header">
                        <span class="manager-card-title"><?= htmlspecialchars($client->getNom()) ?> <?= htmlspecialchars($client->getPrenom()) ?></span>
                    </div>
                    <div class="manager-card-body">
                        <p>Email : <b><?= htmlspecialchars($client->getEmail()) ?></b></p>
                        <p>Téléphone : <b><?= htmlspecialchars($client->getNumero_telephone()) ?></b></p>
                        <p>Adresse : <b><?= htmlspecialchars($client->getAdresse()) ?></b></p>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <p class="manager-empty">Aucun client trouvé.</p>
                <?php endif; ?>
            </div>
        </section>
        <section class="manager-listes-block">
            <h2>Bailleurs</h2>
            <div class="manager-cards">
                <?php if (!empty($bailleurs)) : foreach ($bailleurs as $b) : $bailleur = $b['objet']; ?>
                <div class="manager-card">
                    <div class="manager-card-header">
                        <span class="manager-card-title"><?= htmlspecialchars($bailleur->getNom()) ?> <?= htmlspecialchars($bailleur->getPrenom()) ?></span>
                    </div>
                    <div class="manager-card-body">
                        <p>Email : <b><?= htmlspecialchars($bailleur->getEmail()) ?></b></p>
                        <p>Téléphone : <b><?= htmlspecialchars($bailleur->getTelephone()) ?></b></p>
                        <p>Adresse : <b><?= htmlspecialchars($bailleur->getAdresse()) ?></b></p>
                        <p>Raison sociale : <b><?= htmlspecialchars($bailleur->getRaisonSocial()) ?></b></p>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <p class="manager-empty">Aucun bailleur trouvé.</p>
                <?php endif; ?>
            </div>
        </section>
        <section class="manager-listes-block">
            <h2>Agents</h2>
            <div class="manager-cards">
                <?php if (!empty($agents)) : foreach ($agents as $a) : $agent = $a['objet']; ?>
                <div class="manager-card">
                    <div class="manager-card-header">
                        <span class="manager-card-title"><?= htmlspecialchars($agent->getNom()) ?> <?= htmlspecialchars($agent->getPrenom()) ?></span>
                    </div>
                    <div class="manager-card-body">
                        <p>Username : <b><?= htmlspecialchars($agent->getUsername()) ?></b></p>
                        <p>Téléphone : <b><?= htmlspecialchars($agent->getTelephone()) ?></b></p>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <p class="manager-empty">Aucun agent trouvé.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
