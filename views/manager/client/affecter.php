<?php
// Vue : Affecter ou réaffecter un client à un agent
require_once __DIR__ . '/../../layout/header.php';
?>
<main class="manager-affecter">
    <h1 class="manager-listes-title">Affecter un client à un agent</h1>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="flash-message success"> <?= htmlspecialchars($_SESSION['success']) ?> </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flash-message error"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="manager-affecter-form">
        <form method="post">
            <input type="hidden" name="client_id" value="<?= $client ? htmlspecialchars($client->getId()) : '' ?>">
            <div class="form-group">
                <label>Client :</label>
                <span><b><?= $client ? htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()) : 'Sélectionnez un client' ?></b></span>
            </div>
            <div class="form-group">
                <label for="agent_id">Agent à affecter :</label>
                <select name="agent_id" id="agent_id" required>
                    <option value="">-- Sélectionner un agent --</option>
                    <?php foreach ($agents as $agent): ?>
                        <option value="<?= htmlspecialchars($agent->getId()) ?>">
                            <?= htmlspecialchars($agent->getNom() . ' ' . $agent->getPrenom()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="manager-btn manager-btn-success">Affecter</button>
            <a href="/manager/clients" class="manager-btn">Annuler</a>
        </form>
    </div>
</main>
<?php require_once __DIR__ . '/../../layout/footer.php'; ?>
