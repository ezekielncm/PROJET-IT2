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
        <h2 class="client-login-title">Nouveau mot de passe</h2>
        <form method="POST" action="/client/reset_mdp" class="client-login-form">
            <div class="client-login-field">
                <label for="mdp">Nouveau mot de passe</label>
                <input type="password" name="mdp" id="mdp" required minlength="6">
            </div>
            <div class="client-login-field">
                <label for="mdp2">Confirmer le mot de passe</label>
                <input type="password" name="mdp2" id="mdp2" required minlength="6">
            </div>
            <button type="submit" class="client-login-btn">Réinitialiser</button>
        </form>
        <div class="client-login-bottom">
            <a href="/client" class="client-login-link">Retour à la connexion</a>
        </div>
    </div>
</div>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>
