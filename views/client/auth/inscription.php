<?php require_once VIEW_PATH . 'public/layout/header.php'; ?>
<div class="client-register-container">
    <div class="client-register-card">
        <h2 class="client-register-title">Inscription Client</h2>
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
        <form method="POST" action="Mon-inscription" class="client-register-form" onsubmit="return validateForm()">
            <div class="client-register-fields">
                <div class="client-register-field">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" required autocomplete="family-name">
                </div>
                <div class="client-register-field">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" required autocomplete="given-name">
                </div>
                <div class="client-register-field client-register-field-full">
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" required autocomplete="street-address">
                </div>
                <div class="client-register-field">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required autocomplete="email">
                </div>
                <div class="client-register-field">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone" pattern="^\+?\d{8,15}$" required placeholder="+226xxxxxxxx" autocomplete="tel">
                </div>
                <div class="client-register-field">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" minlength="6" required autocomplete="new-password">
                </div>
                <div class="client-register-field">
                    <label for="mot_de_passe2">Confirmer mot de passe</label>
                    <input type="password" name="mot_de_passe2" id="mot_de_passe2" minlength="6" required autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="client-register-btn">S'inscrire</button>
        </form>
        <div class="client-register-bottom">
            <p>Déjà un compte ?
                <a href="/client" class="client-register-link">Se connecter</a>
            </p>
        </div>
    </div>
</div>
<script>
    function validateForm() {
        const tel = document.getElementById('telephone').value;
        const telRegex = /^\+?\d{8,15}$/;
        if (!telRegex.test(tel)) {
            alert("Veuillez entrer un numéro de téléphone valide (8 à 15 chiffres, avec ou sans '+').");
            return false;
        }
        return true;
    }
</script>
<?php require_once VIEW_PATH . 'public/layout/footer.php'; ?>