<?php
$flash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($nom && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ici, vous pouvez ajouter l'envoi d'email ou l'enregistrement en BDD
        $flash = [
            'type' => 'success',
            'msg' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement !'
        ];
    } else {
        $flash = [
            'type' => 'error',
            'msg' => 'Merci de remplir tous les champs correctement.'
        ];
    }
}
?>
<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<link rel="stylesheet" href="/assets/css/public.css">

<main class="public-contact-main">
    <section class="public-contact-section">
        <h1 class="public-contact-title">Contactez-nous</h1>
        <p class="public-contact-desc">Une question, une demande ? Remplissez le formulaire ci-dessous, notre équipe vous répondra rapidement.</p>
        <?php if (!empty($flash)): ?>
            <div class="public-contact-flash <?= $flash['type'] ?>">
                <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>
        <form class="public-contact-form" method="post" action="">
            <div class="public-contact-form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required value="<?= isset($old['nom']) ? htmlspecialchars($old['nom']) : '' ?>">
            </div>
            <div class="public-contact-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>">
            </div>
            <div class="public-contact-form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required><?= isset($old['message']) ? htmlspecialchars($old['message']) : '' ?></textarea>
            </div>
            <button type="submit" class="public-contact-btn">Envoyer</button>
        </form>
    </section>
</main>

<?php require_once FOOTER_PATH; ?>
