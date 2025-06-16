<?php require_once VIEW_PATH . '/bailleur/layout/header.php'; ?>
<div class="bailleur-messagerie-layout">
    <!-- Liste des clients -->
    <aside class="bailleur-messagerie-clients">
        <div class="bailleur-messagerie-clients-title">📋 Clients</div>
        <?php foreach ($messages as $msg): ?>
            <?php
            $encoded_id = base64_encode($msg['id_client']);
            $last_message = '';
            if (!empty($msg['message_bailleur'])) {
                $last_message = $msg['message_bailleur'];
            } elseif (!empty($msg['message_client'])) {
                $last_message = $msg['message_client'];
            } else {
                $last_message = 'Aucun message';
            }
            ?>
            <a href="/bailleur/messages_clients?id=<?= htmlspecialchars($encoded_id) ?>"
                class="bailleur-messagerie-client-item<?= (isset($id_client) && $id_client === $encoded_id) ? ' active' : '' ?>">
                <div class="bailleur-messagerie-client-nom">
                    <?= strtoupper(htmlspecialchars($msg['nom_client'] ?? ($msg['nom'] ?? 'Client'))) ?>
                </div>
                <div class="bailleur-messagerie-client-last">
                    <?= htmlspecialchars($last_message) ?>
                </div>
            </a>
        <?php endforeach; ?>
    </aside>
    <!-- Zone de discussion -->
    <section class="bailleur-messagerie-discussion">
        <div class="bailleur-messagerie-header">
            <h2>💬 Discussion</h2>
            <a href="/home-bailleur" class="bailleur-messagerie-retour">Retour</a>
        </div>
        <div id="messages-container" class="bailleur-messagerie-messages">
            <?php if (!empty($message_clients)): ?>
                <?php foreach ($message_clients as $msg): ?>
                    <?php if ($msg['expediteur'] === 'bailleur'): ?>
                        <div class="bailleur-messagerie-message bailleur-messagerie-message-bailleur">
                            <div class="bailleur-messagerie-bulle bailleur-messagerie-bulle-bailleur">
                                <p><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                <span class="bailleur-messagerie-date"><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?> • Vous</span>
                            </div>
                        </div>
                    <?php elseif ($msg['expediteur'] === 'client'): ?>
                        <div class="bailleur-messagerie-message bailleur-messagerie-message-client">
                            <div class="bailleur-messagerie-bulle bailleur-messagerie-bulle-client">
                                <p><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                <span class="bailleur-messagerie-date"><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?> • Client</span>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="bailleur-messagerie-empty">
                    <?= isset($id_client) ? "Aucun message pour le moment. Soyez le premier à écrire." : "Sélectionnez un client pour commencer à discuter." ?>
                </p>
            <?php endif; ?>
        </div>
        <button id="scrollTopBtn" class="bailleur-messagerie-scrolltop" style="display:none;">⬆️</button>
        <?php if (isset($id_client) && !empty($id_client)): ?>
            <form action="/bailleur/NouveauMessage" method="POST" class="bailleur-messagerie-form">
                <input type="hidden" name="id_client" value="<?= htmlspecialchars($id_client) ?>">
                <input type="text" name="contenu" placeholder="Écrivez un message..." required class="bailleur-messagerie-input">
                <button type="submit" class="bailleur-messagerie-btn">Envoyer</button>
            </form>
        <?php endif; ?>
    </section>
</div>
<script>
    const container = document.getElementById("messages-container");
    const scrollBtn = document.getElementById("scrollTopBtn");
    if (container) {
        container.scrollTop = container.scrollHeight;
        container.addEventListener("scroll", () => {
            if (container.scrollTop > 200) {
                scrollBtn.style.display = "flex";
            } else {
                scrollBtn.style.display = "none";
            }
        });
        scrollBtn.addEventListener("click", () => {
            container.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
</script>
<?php require_once VIEW_PATH . '/bailleur/layout/footer.php'; ?>