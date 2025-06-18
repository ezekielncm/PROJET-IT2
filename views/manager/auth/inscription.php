<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<main class="manager-auth-container">
    <div class="manager-auth-box">
        <h2 class="manager-auth-title">Inscription Manager</h2>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="flash-message success"> <?= htmlspecialchars($_SESSION['success']) ?> </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="flash-message error"> <?= htmlspecialchars($_SESSION['error']) ?> </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form method="POST" action="/manager/inscription">
            <div class="manager-form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required placeholder="Votre nom">
            </div>
            <div class="manager-form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required placeholder="Votre prénom">
            </div>
            <div class="manager-form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" name="email" id="email" required placeholder="Votre email">
            </div>
            <div class="manager-form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="Mot de passe">
            </div>
            <div class="manager-form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm" required placeholder="Confirmez le mot de passe">
            </div>
            <button type="submit" class="manager-btn-auth">Créer le compte</button>
        </form>
        <div class="manager-auth-links">
            <p>Déjà un compte ?<a href="/manager"> Se connecter</a></p>
        </div>
    </div>
</main>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>
