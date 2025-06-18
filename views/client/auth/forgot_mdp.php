<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<?php if (isset($_SESSION['msg'])): ?>
    <div id="flash-message" class="client-flash-message">
        <?= $_SESSION['msg'] ?>
        <?php unset($_SESSION['msg']); ?>
    </div>
    <script>
        setTimeout(() => {
            const msg = document.getElementById('flash-message');
            if (msg) {
                msg.classList.add('client-flash-out');
                setTimeout(() => msg.remove(), 500);
            }
        }, 3500);
    </script>
<?php endif; ?>
<div class="client-login-container">
    <div class="client-login-card">
        <h2 class="client-login-title">Récupération de compte</h2>
        <form method="POST" action="/client/recuperation" class="client-login-form">
            <div class="client-login-field">
                <label for="recup">Email ou téléphone</label>
                <input type="text" name="recup" id="recup" required placeholder="Votre email ou téléphone">
            </div>
            <button type="submit" class="client-login-btn">Recevoir le lien/code</button>
        </form>
        <div class="client-login-bottom">
            <a href="/client" class="client-login-link">Retour à la connexion</a>
        </div>
    </div>
</div>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>
