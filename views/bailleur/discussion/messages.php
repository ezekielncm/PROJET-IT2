<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messagerie Bailleur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-100">

<div class="flex h-screen">

    <!-- Liste des clients -->
    <aside class="w-1/3 bg-white border-r shadow overflow-y-auto">
        <div class="p-4 border-b bg-indigo-600 text-white font-bold text-xl">
            📋 Clients
        </div>

        <?php foreach ($messages as $msg): ?>
            <?php 
                $encoded_id = base64_encode($msg['id_client']); 
                // Choix du message à afficher dans la liste (dernier message du bailleur ou du client)
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
               class="block px-4 py-3 hover:bg-indigo-100 border-b cursor-pointer <?= (isset($id_client) && $id_client === $encoded_id) ? 'bg-indigo-50 font-semibold' : '' ?>">
                <div class="font-semibold text-gray-800">
                    <?= strtoupper(htmlspecialchars($msg['nom_client'] ?? ($msg['nom'] ?? 'Client'))) ?>
                </div>
                <div class="text-sm text-gray-500 truncate">
                    <?= htmlspecialchars($last_message) ?>
                </div>
            </a>
        <?php endforeach; ?>
    </aside>

    <!-- Zone de discussion -->
    <section class="w-2/3 flex flex-col h-full relative">
        <header class="p-4 bg-indigo-600 text-white flex items-center justify-between shadow">
            <h2 class="text-lg font-semibold">💬 Discussion</h2>
            <a href="/home-bailleur"
                class="text-red-500 hover:text-red-700">Retour</a>
        </header>

        <!-- Messages avec scroll -->
        <div id="messages-container" class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-50">
            <?php if (!empty($message_clients)): ?>
                <?php foreach ($message_clients as $msg): ?>
                    <?php if ($msg['expediteur'] === 'bailleur'): ?>
                        <div class="text-right">
                            <div class="inline-block bg-white text-black px-4 py-2 rounded-xl shadow max-w-md">
                                <p class="text-sm"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                <p class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?> • Vous</p>
                            </div>
                        </div>
                    <?php elseif ($msg['expediteur'] === 'client'): ?>
                        <div class="text-left">
                            <div class="inline-block bg-indigo-100 text-indigo-900 px-4 py-2 rounded-xl shadow max-w-md">
                                <p class="text-sm"><?= nl2br(htmlspecialchars($msg['contenu'])) ?></p>
                                <p class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($msg['date_envoi'])) ?> • Client</p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-400 mt-20">
                    <?= isset($id_client) ? "Aucun message pour le moment. Soyez le premier à écrire." : "Sélectionnez un client pour commencer à discuter." ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Bouton de retour en haut -->
        <button id="scrollTopBtn"
                class="hidden fixed bottom-6 right-6 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full shadow-lg focus:outline-none z-50">
            ⬆️
        </button>

        <!-- Champ d’envoi -->
        <?php if (isset($id_client) && !empty($id_client)): ?>
            <form action="/bailleur/NouveauMessage" method="POST" class="flex p-4 border-t bg-white">
                <input type="hidden" name="id_client" value="<?= htmlspecialchars($id_client) ?>">
                <input type="text" name="contenu" placeholder="Écrivez un message..." required
                       class="flex-1 border border-gray-300 rounded-full px-4 py-2 mr-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700">
                    Envoyer
                </button>
            </form>
        <?php endif; ?>
    </section>
</div>

<!-- JS auto-scroll + scroll-to-top -->
<script>
    const container = document.getElementById("messages-container");
    const scrollBtn = document.getElementById("scrollTopBtn");

    // Scroll vers le bas au chargement
    container.scrollTop = container.scrollHeight;

    container.addEventListener("scroll", () => {
        if (container.scrollTop > 200) {
            scrollBtn.classList.remove("hidden");
        } else {
            scrollBtn.classList.add("hidden");
        }
    });

    scrollBtn.addEventListener("click", () => {
        container.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

</body>
</html>
