<?php
// Point d'entrée principal (front controller)
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App.php';

use src\App;
use routes\Router;
use controllers\HomeControllers;
use controllers\BailleurControllers;
use controllers\ClientControllers;
use controllers\AgentControllers;

App::init();
// Gestion du chemin des assets pour test local (sans -t public) ou production
if (php_sapi_name() === 'cli-server' && basename(__DIR__) !== 'public') {
    // Mode test local sans -t public
    define('ASSET_PATH', '/public/assets/');
} else {
    // Production ou test avec -t public
    define('ASSET_PATH', '/assets/');
}
// Pour la production, on utilise un chemin absolu sécurisé pour les vues
define('VIEW_PATH', realpath(__DIR__ . '/../views/') . DIRECTORY_SEPARATOR);

$router = new Router();
// point d'entrée pour les routes
$router->register('/', ['controllers\HomeControllers', 'home']);

//espaces bailleur
$router->register('/propriete', ['controllers\HomeControllers', 'listes_prorpietes_home']);
$router->register('/register', ['controllers\BailleurControllers', 'register']);
$router->register('/add', ['controllers\BailleurControllers', 'add']);
$router->register('/mes-proprietes', ['controllers\BailleurControllers', 'mes_propietes']);
$router->register('/Mon-profil', ['controllers\BailleurControllers', 'profile']);
$router->register('/maj-profil', ['controllers\BailleurControllers', 'maj_profile']);
$router->register('/maj-mon-profil', ['controllers\BailleurControllers', 'update_profile']);
$router->register('/modifier-propriete', ['controllers\BailleurControllers', 'modifier_propriete']);
$router->register('/modifier', ['controllers\BailleurControllers', 'update_propriete']);
$router->register('/detail_propriete', ['controllers\BailleurControllers', 'detail']);  
$router->register('/supprimer-propriete', ['controllers\BailleurControllers', 'supprimer_propriete']);
$router->register('/logout', ['controllers\BailleurControllers', 'logout']);
$router->register('/voir-mes-demande-de-visite', ['controllers\BailleurControllers', 'mes_rdv']);
$router->register('/voir-rendez-vous', ['controllers\BailleurControllers', 'detail_rdv']);
$router->register('/changer-statut-rdv', ['controllers\BailleurControllers', 'modifier_etat_rdv']);
$router->register('/Accepter-le-rendez-vous', ['controllers\BailleurControllers', 'accpeter_rdv']);
$router->register('/home-bailleur', ['controllers\BailleurControllers', 'login_Bailleur']);
$router->register('/nouvelle-propiete', ['controllers\BailleurControllers', 'NouvellePropiete']);
$router->register('/bailleur', ['controllers\HomeControllers', 'connexion_baileur']);
$router->register('/detail', ['controllers\HomeControllers', 'detail']);
$router->register('/Inscription', ['controllers\HomeControllers', 'connexion_bail']);
$router->register('/bailleur/conversations', ['controllers\BailleurControllers', 'messages']);
$router->register('/bailleur/messages_clients', ['controllers\BailleurControllers', 'conversations']);
$router->register('/bailleur/NouveauMessage', ['controllers\BailleurControllers', 'NouveauMessage']);
$router->register('/ventes-locations', ['controllers\BailleurControllers', 'listes_demandeAchat']);
$router->register('/bailleur/validerAchat', ['controllers\BailleurControllers', 'valider_achat']);





//espaces client
$router->register('/client', ['controllers\HomeControllers', 'connexion_client']);
$router->register('/Mon-inscription', ['controllers\ClientControllers', 'NouveauClient']);
$router->register('/Espace-client/proprietes/detail', ['controllers\ClientControllers', 'detail_propriete']);
$router->register('/se-connecter', ['controllers\ClientControllers', 'LoginClient']);
$router->register('/listes-proprietes', ['controllers\ClientControllers', 'proprietes']);
$router->register('/ajouter-favoris', ['controllers\ClientControllers', 'add_favoris']);
$router->register('/tableau-de-bord', ['controllers\ClientControllers', 'dash']);
$router->register('/mes-rendez-vous', ['controllers\ClientControllers', 'ListeRendezVous']);
$router->register('/supprimer-favoris', ['controllers\ClientControllers', 'supprimer_favoris']);
$router->register('/Espace-client/proprietes/rdv/add', ['controllers\ClientControllers', 'PrendreRendezVous']);
$router->register('/rendez-vous', ['controllers\ClientControllers', 'rdv']);
$router->register('/propriete/mes-proprietes-favoris', ['controllers\ClientControllers', 'list_favoris']);
$router->register('/mon-profil', ['controllers\ClientControllers', 'mon_profil']);
$router->register('/modifier-profil', ['controllers\ClientControllers', 'profile_modifier']);
$router->register('/me-deconnecter', ['controllers\ClientControllers', 'LogoutClient']);
$router->register('/modifier-mes-rendez-vous', ['controllers\ClientControllers', 'modifier_rdv']);
$router->register('/Annuler-mon-rendez-vous', ['controllers\ClientControllers', 'sup_rdv']  );   
$router->register('/modifier-mon-profil', ['controllers\ClientControllers', 'modifier_profil']);
$router->register('/inscription-client', ['controllers\HomeControllers', 'inscription_client']);
$router->register('/fil-de-discussion', ['controllers\ClientControllers', 'messages']);
$router->register('/client/messages_bailleurs', ['controllers\ClientControllers', 'conversations']);
$router->register('/client/envoyer_message', ['controllers\ClientControllers', 'NouveauMessage']);
$router->register('/client/discusion/proprio', ['controllers\ClientControllers', 'NouveauMessageBailleur']);  
$router->register('/acheter-cette-propriete', ['controllers\ClientControllers', 'acheter_cette_propriete']);
$router->register('/Acheter-proprietes', ['controllers\ClientControllers', 'proceder_Achat']);


//espaces agent 
$router->register('/connexion-agent', ['controllers\AgentControllers', 'page_login']);
$router->register('/home-agent', ['controllers\AgentControllers', 'login_agent']);
$router->register('/demandes-validation', ['controllers\AgentControllers', 'listes_proprieter_ava']);
$router->register('/valider-propriete', ['controllers\AgentControllers', 'valider_propriete']);
$router->register('/clients-attribues', ['controllers\AgentControllers', 'listes_mes_clients']);
$router->register('/clients-rdv-bailleurs', ['controllers\AgentControllers', 'listes_rdv']);
$router->register('/mon-profile', ['controllers\AgentControllers', 'profile_agent']);
$router->register('/se-deconnecter', ['controllers\AgentControllers', 'LogoutAgent']);
$router->register('/listes-achat-valider', ['controllers\AgentControllers', 'listes_achatv']);
$router->register('/agent-valider-achat', ['controllers\AgentControllers', 'valider_achat']);
$router->register('/reception-de-paiement', ['controllers\AgentControllers', 'reception_paiement']);
$router->register('/valider-paiement', ['controllers\AgentControllers', 'reception_paiement_valider']);









try {
    $router->resolve($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    echo $e->getMessage();
}
