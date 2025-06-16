<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="messagerie-layout">
    <!-- Liste des bailleurs -->
    <aside class="messagerie-bailleurs">
        <div class="messagerie-bailleurs-title">📋 Bailleurs</div>
        <?php foreach ($messages as $msg): ?>
            <a href="/client/messages_bailleurs?id=<?= base64_encode($msg['id_bailleur']) ?>" class="messagerie-bailleur-item">
                <div class="messagerie-bailleur-nom"><?= strtoupper($msg['raison_social']) ?></div>
                <div class="messagerie-bailleur-last">
                    <?= !empty($msg['message_bailleur']) ? $msg['message_bailleur'] : ($msg['message_client'] ?? 'Aucun message') ?>
                </div>
            </a>
        <?php endforeach; ?>
    </aside>

    <!-- Zone de discussion -->
    <section class="messagerie-discussion">
        <header class="messagerie-discussion-header">
            <h2>💬 Discussion</h2>
            <a href="/client" class="messagerie-retour">Retour</a>
        </header>
        <div id="messages-container" class="messagerie-messages">
            <?php if (!empty($message_bailleurs)): ?>
                <?php foreach ($message_bailleurs as $msg): ?>
                    <?php if ($msg['expediteur'] === 'client'): ?>
                        <div class="messagerie-message messagerie-message-client">
                            <div class="messagerie-bulle messagerie-bulle-client">
                                <p><?= htmlspecialchars($msg['contenu']) ?></p>
                                <span class="messagerie-date"><?= $msg['date_envoi'] ?> • Vous</span>
                            </div>
                        </div>
                    <?php elseif ($msg['expediteur'] === 'bailleur'): ?>
                        <div class="messagerie-message messagerie-message-bailleur">
                            <div class="messagerie-bulle messagerie-bulle-bailleur">
                                <p><?= htmlspecialchars($msg['contenu']) ?></p>
                                <span class="messagerie-date"><?= $msg['date_envoi'] ?> • Bailleur</span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="messagerie-empty">
                    <?= isset($id_bailleur) ? "Aucun message pour le moment. Soyez le premier à écrire." : "Sélectionnez un bailleur pour commencer à discuter." ?>
                </p>
            <?php endif; ?>
        </div>
        <button id="scrollTopBtn" class="messagerie-scrolltop" style="display:none;">⬆️</button>
        <?php if (isset($id_bailleur) && !empty($id_bailleur)): ?>
            <form action="/client/envoyer_message" method="POST" class="messagerie-form">
                <input type="hidden" name="id_bailleur" value="<?= htmlspecialchars($id_bailleur) ?>">
                <input type="text" name="contenu" placeholder="Écrivez un message..." required class="messagerie-input">
                <button type="submit" class="messagerie-btn">Envoyer</button>
            </form>
        <?php endif; ?>
    </section>
</div>

<script>
    const container = document.getElementById("messages-container");
    const scrollBtn = document.getElementById("scrollTopBtn");
    if(container && scrollBtn) {
        container.scrollTop = container.scrollHeight;
        container.addEventListener("scroll", () => {
            if (container.scrollTop > 200) {
                scrollBtn.style.display = '';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        scrollBtn.addEventListener("click", () => {
            container.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
