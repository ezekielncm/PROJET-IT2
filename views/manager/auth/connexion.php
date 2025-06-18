<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<main class="manager-auth-container">
    <div class="manager-auth-box">
        <h2 class="manager-auth-title">Connexion Manager</h2>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="flash-message success"> <?= htmlspecialchars($_SESSION['success']) ?> </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="flash-message error"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form method="POST" action="/manager">
            <div class="manager-form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email" id="email" required autocomplete="username" placeholder="Votre email">
            </div>
            <div class="manager-form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="Votre mot de passe">
            </div>
            <button type="submit" class="manager-btn-auth">Se connecter</button>
        </form>
        <div class="manager-auth-links">
            <a href="/manager/inscription">Créer un compte manager</a>
        </div>
    </div>
</main>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>
