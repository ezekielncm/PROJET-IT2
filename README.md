# UrbanHome

UrbanHome est une application web de gestion immobilière moderne, développée en PHP avec une architecture MVC complète. Elle permet la gestion de biens, utilisateurs (clients, bailleurs, agents, managers), transactions, rendez-vous, messagerie et bien plus, avec une interface responsive, accessible et sécurisée.

## 🚀 Fonctionnalités principales

- Architecture MVC stricte (Model, View, Controller)
- Gestion multi-profils : client, bailleur, agent, manager
- Authentification sécurisée, gestion des sessions, tokens CSRF
- PHPMailer pour l'envoi d'e-mails (inscription, réinitialisation de mot de passe)
- Interface utilisateur moderne, responsive et accessible (HTML5, CSS3, JS)
- Séparation stricte des CSS par espace (`main.css`, `client.css`, `bailleur.css`, `manager.css`, `agent.css`, `public.css`)
- Suppression totale de Tailwind et des styles inline, code CSS maintenable et préfixé
- Gestion des propriétés : ajout, modification, suppression, consultation, validation
- Tableaux de bord personnalisés selon le profil utilisateur
- Système de messagerie interne (clients ↔ bailleurs, clients ↔ agents)
- Gestion des rendez-vous, favoris, achats, paiements
- Pages d'erreur personnalisées (404, 500)
- Sécurité renforcée : redirection HTTPS, validation des entrées, gestion des droits d'accès
- Rafraîchissement automatique, menu responsive, gestion du drawer/burger menu
- Expérience utilisateur améliorée : flash messages animés, formulaires accessibles, pagination, cards, responsive, cohérence visuelle UrbanHome


## 🛠️ Installation rapide (local ou Docker)

### ▶️ Avec Docker Compose (recommandé)

1. **Cloner ou télécharger le projet** dans un dossier de votre choix.
2. **Configurer les variables d'environnement** dans le fichier `.env` à la racine :

   ```env
   DB_HOST=db
   DB_NAME=urbanhome
   DB_USER=root
   DB_PASS=urbanhomepass
   ```

3. **Lancer l'environnement Docker Compose** :

   ```powershell
   docker compose up -d
   ```

   - Le service web (PHP/Apache) sera accessible sur [http://localhost:8000](http://localhost:8000)
   - Le service MySQL écoute sur le port 3307 de l’hôte (utile pour se connecter avec un client externe)
   - La base de données sera automatiquement initialisée avec le script `urbanhome.sql` (tables, données de démo si présentes)

4. **(Optionnel) Import manuel de la base**
   Si besoin de réimporter le SQL :
   ```powershell
   docker compose exec db bash
   mysql -u root -purbanhomepass urbanhome < /docker-entrypoint-initdb.d/urbanhome.sql
   ```

5. **Arrêter l’environnement** :
   ```powershell
   docker compose down
   ```

#### 📦 Volumes et persistance
- Les données MySQL sont persistées dans le volume `db-data`.
- Pour réinitialiser complètement la base (attention, perte de données) :
  ```powershell
  docker compose down -v
  docker compose up -d
  ```

#### 🐳 Remarques Docker
- Le fichier `compose.yaml` ne nécessite plus la clé `version:` (obsolète).
- Le script SQL est monté dans le conteneur MySQL pour un import automatique à la première initialisation.
- Les variables d’environnement sont injectées dans le conteneur web et accessibles via `getenv()` ou Dotenv.

### ▶️ Installation manuelle (WAMP/XAMPP)

1. **Cloner ou télécharger le projet** dans un dossier de votre serveur local (WAMP, XAMPP, etc.) supportant PHP >= 7.4 et MySQL.
2. **Importer la base de données** :
   - Fichier : `urbanhome.sql`
   - Utilisez phpMyAdmin ou la ligne de commande MySQL :
     ```sql
     source urbanhome.sql;
     ```
3. **Configurer les variables d'environnement** dans le fichier `.env` à la racine :
   ```env
   DB_HOST='localhost'
   DB_NAME='urbanhome'
   DB_USER='root'
   DB_PASS=''
   ```
4. **Installer les dépendances Composer** :
   ```powershell
   composer install
   composer dump-autoload
   composer require vlucas/phpdotenv
   ```
5. **Lancer le serveur PHP intégré** (ou configurer Apache/Nginx) :
   ```powershell
   php -S localhost:8000 -t public
   ```
6. **Accéder à l'application** : [http://localhost:8000](http://localhost:8000)

## 🗂️ Structure des dossiers

- `public/` : point d'entrée de l'application (front controller, index.php)
- `views/` : vues et layouts (header, footer, navbar, erreurs, etc.)
- `controllers/` : contrôleurs pour chaque rôle (Bailleur, Client, Agent, Manager, Home)
- `model/` : modèles et accès base de données (propriétés, utilisateurs, paiements, etc.)
- `config/` : configuration (connexion PDO, chargement .env)
- `routes/` : gestion des routes (`Router.php`)
- `public/assets/` : ressources statiques (CSS, JS, images)
- `css/` : fichiers CSS séparés par espace (`main.css`, `client.css`, `bailleur.css`, `manager.css`, `agent.css`, `public.css`) - `js/` : scripts dédiés (ex : animation flash messages)
- `src/` : initialisation de l'application (App.php)

## 🌐 Exemples de routes principales

### Public

- `/` : Page d'accueil
- `/public/about` : À propos
- `/public/contact` : Contact
- `/public/search` : Recherche

### Propriétés

- `/propriete/liste` : Liste des propriétés
- `/propriete/detail` : Détail d'une propriété

### Bailleur

- `/bailleur` : Connexion bailleur
- `/bailleur/inscription` : Inscription bailleur
- `/bailleur/dashboard` : Tableau de bord du bailleur
- `/bailleur/propriete` : Liste des biens
- `/bailleur/contrats` : Contrats
- `/bailleur/paiements` : Paiements
- `/bailleur/messages` : Messagerie
- `/bailleur/conversations` : Discussions
- `/bailleur/NouveauMessage` : Nouveau message
- `/ventes-locations` : Demandes d'achat/location

### Client

- `/client` : Connexion client
- `/Mon-inscription` : Inscription client
- `/tableau-de-bord` : Tableau de bord
- `/listes-proprietes` : Liste des propriétés
- `/propriete/mes-proprietes-favoris` : Favoris
- `/mes-rendez-vous` : Rendez-vous
- `/fil-de-discussion` : Messagerie
- `/Acheter-proprietes` : Achat de propriété

### Agent

- `/connexion-agent` : Connexion agent
- `/home-agent` : Tableau de bord agent
- `/demandes-validation` : Propriétés à valider
- `/clients-attribues` : Clients attribués
- `/clients-rdv-bailleurs` : Rendez-vous clients/bailleurs
- `/listes-achat-valider` : Achats à valider

### Manager

- `/manager` : Connexion manager
- `/manager/dashboard` : Tableau de bord manager
- `/manager/clients` : Gestion des clients
- `/manager/biens` : Gestion des biens
- `/manager/contrats` : Contrats
- `/manager/paiements` : Paiements
- `/manager/messages` : Messagerie

## ✨ Fonctionnalités avancées

- Gestion avancée des propriétés (CRUD, validation, affectation)
- Messages flash animés et accessibles pour les retours utilisateur
- Formulaires dynamiques et accessibles pour chaque profil
- Tableaux de bord interactifs avec indicateurs clés (KPI)
- Système de messagerie interne multi-profils
- Gestion des rendez-vous et notifications
- Sécurité : CSRF, HTTPS, validation, gestion des droits
- Rafraîchissement automatique, menu responsive, drawer/burger menu JS
- Accessibilité renforcée (contrastes, navigation clavier, ARIA)

## 💡 Conseils d'utilisation & contribution

- Adaptez les fichiers de configuration à votre environnement (BDD, mail, etc.)
- Pour la production, configurez votre serveur pour que seul le dossier `public/` soit accessible publiquement
- Personnalisez les pages d'erreur dans `views/error/`
- Séparez vos styles CSS par espace pour une meilleure maintenabilité
- Utilisez les classes préfixées (`.client-`, `.bailleur-`, `.manager-`, `.agent-`, `.public-`) pour éviter les conflits
- Pensez à sécuriser vos accès et à mettre à jour vos dépendances
- Pour contribuer, ouvrez une issue ou une pull request sur le dépôt


## 📊 Exemples de configuration `.env`

### Pour Docker Compose
```env
DB_HOST=db
DB_NAME=urbanhome
DB_USER=root
DB_PASS=urbanhomepass
```

### Pour un environnement local classique (WAMP/XAMPP)
```env
DB_HOST=localhost
DB_NAME=urbanhome
DB_USER=root
DB_PASS=
```

## 🗄️ Exemple d'import de la base de données

- Fichier fourni : `urbanhome.sql`
- Compatible MySQL/MariaDB
- Contient toutes les tables nécessaires (propriétés, utilisateurs, paiements, rendez-vous, etc.)

## 📊 Tableaux de bord & UX

- **Bailleur** : gestion des biens, contrats, paiements, messagerie, indicateurs clés
- **Client** : gestion des locations, favoris, paiements, messagerie, rendez-vous
- **Agent** : validation de propriétés, gestion des clients, rendez-vous, paiements
- **Manager** : supervision globale, gestion des utilisateurs, biens, contrats, paiements

## 🧩 Technologies utilisées

- PHP 7.4+
- MySQL/MariaDB
- Composer (autoload PSR-4, dotenv)
- HTML5, CSS3, JavaScript (menu responsive, auto-refresh)
- PHPMailer

---

**Bonne utilisation de UrbanHome !**

Pour toute question ou contribution, n'hésitez pas à ouvrir une issue ou une pull request.
