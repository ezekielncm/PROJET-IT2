<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<div class="client-login-container">
    <div class="client-login-card">
        <h2 class="client-login-title">Connexion Client</h2>
        <form method="POST" action="/se-connecter" class="client-login-form">
            <div class="client-login-field">
                <label for="telephone">Numéro de téléphone</label>
                <input type="text" name="tel" id="telephone" required autocomplete="username">
            </div>
            <div class="client-login-field">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" required autocomplete="current-password">
            </div>
            <button type="submit" class="client-login-btn">Se connecter</button>
        </form>
        <div class="client-login-bottom">
            <p>Pas de compte ?
                <a href="/inscription-client" class="client-login-link">S'inscrire</a>
            </p>
            <p style="margin-top:1rem;">
                <a href="/client/forgot_mdp" class="client-login-link">Mot de passe oublié ?</a>
            </p>
        </div>
    </div>
</div>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>
