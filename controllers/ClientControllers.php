<?php


namespace controllers;

use controllers\Controllers;
use model\Client;
use model\clientBDD;
use model\Agent;
use model\AgentBDD;
use model\ProprieteBDD;
use model\Propriete;
use model\Achat;


class ClientControllers extends Controllers
{

    public function NouveauClient()
    {
             if (isset($_SESSION['id_client'])) {
            // Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
            $this->render("client/accueil");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $motDePasse = htmlspecialchars(trim($_POST['mot_de_passe']));
            $confirmMotDePasse = htmlspecialchars(trim($_POST['mot_de_passe2']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));

            $agentBDD = new AgentBDD();
            $agent = $agentBDD->agent_not_affected();

            if (!empty($agent)) {
                $id_agent = $agent[0]['id'];
            } else {
                 $id_agent = 0;
            }
            
            }

            if ($motDePasse !== $confirmMotDePasse) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                $this->render('client/auth/connexion', ['error' => $_SESSION['error']]);
                exit;
            }

            $mdp = password_hash($motDePasse, PASSWORD_DEFAULT);

            // Ajuste ici l'ordre et nombre d'arguments selon ton constructeur Client
            $client = new Client($nom, $prenom, $adresse, $email, $telephone, $mdp, $id_agent);

            $clientBDD = new ClientBDD();

            if ($clientBDD->insertClient($client)) {
                $_SESSION['success'] = "un agent vous sera affilie dans les brefs delais <br> pour vous aider à trouver votre prochain appartement et acceder a certaines fonctionnalités.";
                $this->render('client/auth/connexion', ['success' => $_SESSION['success']]);
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du client.";
                $this->render('client/auth/inscription', ['error' => $_SESSION['error']]);
               
                exit;
            }
        }
    



    public function LoginClient()

    {
       if (isset($_SESSION['id_client'])) {
    // Si l'utilisateur est déjà connecté, récupérer les données pour affichage
    $proprieteB = new ProprieteBDD();
    $bannieres = $proprieteB->getBannieresAccueil();
    $limit = 3;
    $ofset = 0;
    $proprietes = $proprieteB->getAlldataforpropriete($limit, $ofset);

    $this->render("client/accueil", [
        'bannieres' => $bannieres ,
        'proprietes' => $proprietes,
    ]);
    exit;
}       if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $telephone = htmlspecialchars(trim($_POST['tel']));
            $motDePasse = htmlspecialchars(trim($_POST['mdp']));

            $clientBDD = new ClientBDD();
            $client = $clientBDD->LoginClient($telephone, $motDePasse);
             $proprieteB = new ProprieteBDD();
                $bannieres = $proprieteB->getBannieresAccueil(); 
                $limit = 3;
                $ofset = 0;
                $proprietes = $proprieteB->getAlldataforpropriete($limit, $ofset);

            if ($client) {
                 $clientBDD = new clientBDD();
           $id_client = isset($_SESSION['id_client']) ?$_SESSION['id_client'] : null ;

        // Récupérer le nombre de favoris
           $nombreFavoris = $clientBDD->nbres_favoris($id_client);
           $nombresAchat = $clientBDD->nbr_acheter($id_client);
                $_SESSION['id_client'] = $client['id'];
                $_SESSION['nom_client'] = $client['objet']->getNom();
                $_SESSION['prenom_client'] = $client['objet']->getPrenom();
                $_SESSION['telephone_client'] = $client['objet']->getNumero_telephone();
                $_SESSION['email_client'] = $client['objet']->getEmail();
                $_SESSION['adresse_client'] = $client['objet']->getAdresse();
               
               // ou autre classe dédiée aux bannières


                    $this->render('client/accueil', ['proprietes' => $proprietes, 'bannieres' => $bannieres, 'nombre_favoris' => $nombreFavoris,' nombresAchat'=> $nombresAchat]);

                
                
                exit;
            } else {
             
                $this->render('client/auth/connexion', ['error' => "Mot de passe incorrect."]);
            }
        } else { 
              
            $this->render('client/auth/connexion', ['error' => "Aucun client trouvé avec ce numéro de téléphone."]);
        }



    }
    public function dash(){
        if (isset($_SESSION['id_client'])) {
            // Si l'utilisateur est déjà connecté, redirige vers la page d'accueil
                   $clientBDD = new clientBDD();
                   $nombreFavoris = $clientBDD->nbres_favoris($_SESSION['id_client']);
                   $nbr_proprietes_louer = $clientBDD->nbr_louer();
                  $rdvAvenir = $clientBDD->nbr_rdv($_SESSION['id_client']);
                     $nombresAchat = $clientBDD->nbr_acheter($_SESSION['id_client']);
                     
                  

            $this->render("client/dasb", [
                'nombreFavoris' => $nombreFavoris,
                'nbr_proprietes_louer' => $nbr_proprietes_louer,
                'rdvAvenir' => $rdvAvenir,
                'nombresAchat' => $nombresAchat
            ]);
            exit;
        } else {
            // Sinon, redirige vers la page de connexion
            $this->render('client/auth/connexion');
        }
    }
    public function detail_propriete(){
    $propriete = new ProprieteBDD();
        $id = $_GET['id'];
        $id = base64_decode($id);
        $proprietes = $propriete->getProprieteById($id);

        if($proprietes){
        
            $this->render('client/propriete/detail', ['proprietes' => $proprietes]);
        }
        else{
            $this->render('error/404');
        }
    }


    public function proprietes(){
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;
    $propriete = new ProprieteBDD();
    $total_props = $propriete->countProprietesLibres();
    $total_pages = ceil($total_props / $limit);
    $proprietes = $propriete->getAlldataforpropriete($limit, ofset: $offset);

  
    if ($proprietes && is_array($proprietes)) {
        $this->render('client/propriete/list_propriete', [
            'proprietes' => $proprietes,
            'page' => $page,
            'total_pages' => $total_pages
        ]);
    } else {
        $this->render('error/404');
    }
    }

    public function add_favoris(){
            $propriete = new ProprieteBDD();
            if(isset($_SESSION['id_client'])){
                $id_propriete = base64_decode(string: $_GET['id']);
                $id_client =  $_SESSION['id_client'];
                $date_ajout = date('Y-m-d H:i:s');

                
                $favoris = new clientBDD();
                // Vérifie si la propriété est déjà dans les favoris
                if($favoris->dejaFavoris($id_client, $id_propriete)){
                    $_SESSION['msg'] = "Cette propriété est déjà dans vos favoris.";
                    $proprietes = $propriete->getProprieteById($id_propriete);
                    $this->render('client/propriete/detail', ['msg' => $_SESSION['msg'], 'proprietes' => $proprietes]);
                    return;
                }
                else
                if($favoris->favoriserPropriete($id_client,$id_propriete, $date_ajout)){
                    $_SESSION['msg'] = "Propriété ajoutée aux favoris.";
                     
                    
                    $proprietes = $propriete->getProprieteById($id_propriete);
                    $this->render('client/propriete/detail', ['msg' => $_SESSION['msg'], 'proprietes' => $proprietes]);
                } else {
                    $_SESSION['msg'] = "Erreur lors de l'ajout aux favoris.";
                    $this->render('client/propriete/detail', ['msg' => $_SESSION['msg']]);
                }
            } else {
                $_SESSION['msg'] = "Veuillez vous connecter pour ajouter aux favoris.";
                $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
            }
        

    }
public function list_favoris()
{
    if (empty($_SESSION['id_client'])) {
        $_SESSION['msg'] = "Veuillez vous connecter pour voir vos favoris.";
        $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
        return;
    }

    $clientBDD = new clientBDD();
    $id_client = $_SESSION['id_client'];

    // Pagination
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $perPage     = 2;
    $offset      = ($currentPage - 1) * $perPage;

    // Total
    $totalFavoris = $clientBDD->countFavorisByClient($id_client);
    $totalPages   = ceil($totalFavoris / $perPage);

    // Favoris paginés
    $favoris = $clientBDD->getFavorisByClient($id_client, $perPage, $offset);

    $this->render('client/propriete/list_favoris', [
        'favoris'     => $favoris,
        'currentPage' => $currentPage,
        'totalPages'  => $totalPages
    ]);
}

public function supprimer_favoris(){
    if (empty($_SESSION['id_client'])) {
        $_SESSION['msg'] = "Veuillez vous connecter pour supprimer un favori.";
        $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
        return;
    }

    $clientBDD = new clientBDD();
    $id_client = $_SESSION['id_client'];
    $id_favoris = $_SESSION['id_favoris'];

    if ($clientBDD->supprimerFavoris($id_client, $id_favoris)) {
        $_SESSION['msg'] = "Favori supprimé avec succès.";
    } else {
        $_SESSION['msg'] = "Erreur lors de la suppression du favori.";
    }


    $this->redirect('/propriete/mes-proprietes-favoris');
}

  
public function  rdv(){
    if (isset($_GET['id'])) {
        $id_propriete = base64_decode($_GET['id']);
        
        $propriete = new ProprieteBDD();
    $proprietes = $propriete->getProprieteById($id_propriete);
    $this->render('client/propriete/rdv/add', ['proprietes' => $proprietes]);

    } else {
        $_SESSION['msg'] = "Aucune propriété sélectionnée.";
        $this->render('client/propriete/list_propriete', ['msg' => $_SESSION['msg']]);
        return;
    }
    
}

public function PrendreRendezVous(){
    if($_SERVER['REQUEST_METHOD']=== "POST"){
          $clientBDD = new clientBDD();
        $id_client = $_SESSION['id_client'];
        $id_propriete = htmlspecialchars(trim($_POST['propriete_id']));
        $date_rendez_vous = htmlspecialchars(trim($_POST['date']));
        $heure_rendez_vous = htmlspecialchars(trim($_POST['heure']));
        $descriptions = htmlspecialchars(trim($_POST['descriptions']));
        $test = new ProprieteBDD();
        $id_bailleur= $test->getId_bailleur($id_propriete);

        // Convertir la date et l'heure en un format compatible avec la base de données
        
        $aujourd = date('Y-m-d');
        // Vérifier si la date du rendez-vous est dans le futur
        if (strtotime($date_rendez_vous) < strtotime($aujourd)) {
            $_SESSION['msg'] = "La date du rendez-vous ne peut pas être dans le passé.";
            $this->render('client/propriete/rdv/add', ['msg' => $_SESSION['msg']]);
            return;
        }
        // verifier si le client a déjà un rendez-vous pour cette propriété à la même date
      

        else
        if ($clientBDD->verifierRendezVous($id_client, $id_propriete)) {
            $_SESSION['msg'] = "Vous avez déjà un rendez-vous pour cette propriété.";
            $this->redirect('/Espace-client/proprietes/detail?id=' . base64_encode($id_propriete));
            return;
            }
         else {
            $id_statut = $clientBDD->IdRdv('En Attente');
            if ($id_statut === null) {
                $_SESSION['msg'] = "Erreur lors de la récupération du statut de rendez-vous.";
                $this->render('client/propriete/rdv/add', ['msg' => $_SESSION['msg']]);
                return;
            }

            if ($clientBDD->Prendre_rendevez($id_client, $id_propriete, $id_bailleur,$date_rendez_vous,$heure_rendez_vous, $id_statut, $descriptions)) {
                $_SESSION['msg'] = "Rendez-vous pris avec succès.";
                $this->render('client/propriete/rdv/add', ['msg' => $_SESSION['msg']]);
            } else {
                $_SESSION['msg'] = "Erreur lors de la prise de rendez-vous.";
                $this->render('client/propriete/rdv/add', ['msg' => $_SESSION['msg']]);
            }
        }
    } else {
        $_SESSION['msg'] = "Méthode non autorisée.";
        $this->render('error/404', ['msg' => $_SESSION['msg']]);
    }
}


    public function ListeRendezVous()
    {
        if (empty($_SESSION['id_client'])) {
            $_SESSION['msg'] = "Veuillez vous connecter pour voir vos rendez-vous.";
            $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
            return;
        }

        $clientBDD = new clientBDD();
        $id_client = $_SESSION['id_client'];

        // Pagination
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage     = 10;
        $offset      = ($currentPage - 1) * $perPage;
 /*
        // Total
        $totalRendezVous = $clientBDD->countRendezVousByClient($id_client);
        $totalPages     = ceil($totalRendezVous / $perPage);
*/
        // Rendez-vous paginés
        $rdvs = $clientBDD->listes_rdvs($id_client, $perPage, $offset);

        $this->render('client/propriete/rdv/list', [
            'rdvs' => $rdvs,
            'currentPage' => $currentPage,
            
        ]);
    }


    public function mon_profil()
    {
        if (empty($_SESSION['id_client'])) {
            $_SESSION['msg'] = "Veuillez vous connecter pour voir votre profil.";
            $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
            return;
        }

        $clientBDD = new clientBDD();
        $id_client = $_SESSION['id_client'];
        $client = $clientBDD->getClientById($id_client);

        if ($client) {
            $this->render('client/profile/vue', ['client' => $client]);
        } else {
            $_SESSION['msg'] = "Client non trouvé.";
            $this->render('error/404', ['msg' => $_SESSION['msg']]);
        }
    }

    public function profile_modifier(){
        if (isset($_SESSION['id_client'])) {
            
        $clientBDD = new clientBDD();
        $id_client = $_SESSION['id_client'];
        $client = $clientBDD->getClientById($id_client);
            $this->render('client/profile/edit',
                ['client' => $client]);
            return;
        }

    }


    public function modifier_profil()
    {
        if (empty($_SESSION['id_client'])) {
            $_SESSION['msg'] = "Veuillez vous connecter pour modifier votre profil.";
            $this->render('client/auth/connexion', ['msg' => $_SESSION['msg']]);
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $geto=new clientBDD();
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $motDePasse = $geto->get_password_by_id();
            $id_agent= $geto->get_agent_by_id();
            $client = new Client($nom, $prenom, $adresse, $email, $telephone, $motDePasse, $id_agent);
            if ($geto->update_client($client,$_SESSION['id_client'])) {
                $_SESSION['msg'] = "Profil modifié avec succès.";
                $this->redirect('/mon-profil');
                exit;
            } else {
                $_SESSION['msg'] = "Erreur lors de la modification du profil.";
                $this->redirect('/mon-profile');
                exit;
            }
        } else {
            $this->render('client/profile/edit');
        }
    }
            



    
    public function sup_rdv(){
        if(isset($_SESSION['id_client'])){
                $clientBDD = new clientBDD();
                $id= $_SESSION['id_client'];
                $id_rdv = $_SESSION['id_rdv'];
                $clientBDD = new clientBDD();
             if($clientBDD->supprimerRdv($id_rdv,$id)){
                $_SESSION['msg']="Rendez-vous supprimé avec succès";
                $this->redirect('mes-rendez-vous');
                exit;
             }else{
                $_SESSION['msg']="Erreur lors de la suppression du rendez-vous";
                 $this->redirect('mes-rendez-vous');

                exit;
             }
                
            }
        
    }


public function messages() {
    if (!isset($_SESSION['id_client'])) {
        $this->redirect('connexion');
        return;
    }

    $clientBDD = new clientBDD();
    $id_client = $_SESSION['id_client'];

    // Récupération de la liste des conversations
    $messages = $clientBDD->get_messages_client($id_client);

    // Vérifie si un bailleur est sélectionné
    $id_bailleur = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
    $message_bailleurs = [];

    if ($id_bailleur) {
        $message_bailleurs = $clientBDD->get_messages($id_bailleur);
    }

    // On envoie tout à la vue
    $this->render('client/discussions/messages', [
        'messages' => $messages,
        'message_bailleurs' => $message_bailleurs
    ]);
}


public function conversations() {
    if (!isset($_SESSION['id_client'])) {
        $this->redirect('connexion');
        return;
    }

    $clientBDD = new clientBDD();
    $id_client = $_SESSION['id_client'];

    // Liste des bailleurs avec leurs derniers messages
    $messages = $clientBDD->get_messages_client($id_client);

    // Si un bailleur est sélectionné
    $id_bailleur = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
    $message_bailleurs = [];

    if ($id_bailleur) {
        // Récupération des deux types de messages
        $messages_client = $clientBDD->getMessagesClient($id_client, $id_bailleur);
        $messages_bailleur = $clientBDD->getMessagesBailleur($id_client, $id_bailleur);

        // Normalisation des messages client
        foreach ($messages_client as &$msg) {
            $msg['expediteur'] = 'client';
            $msg['contenu'] = $msg['message_client'];
            $msg['date_envoi'] = $msg['date_message_client'] . ' ' . $msg['heur_message_client'];
            unset($msg['message_client'], $msg['date_message_client'], $msg['heur_message_client']);
        }

        // Normalisation des messages bailleur
        foreach ($messages_bailleur as &$msg) {
            $msg['expediteur'] = 'bailleur';
            $msg['contenu'] = $msg['message_bailleur'];
            $msg['date_envoi'] = $msg['date_message_bailleur'] . ' ' . $msg['heur_message_bailleur'];
            unset($msg['message_bailleur'], $msg['date_message_bailleur'], $msg['heur_message_bailleur']);
        }

        // Fusion + tri chronologique
        $message_bailleurs = array_merge($messages_client, $messages_bailleur);
        usort($message_bailleurs, function($a, $b) {
            return strtotime($a['date_envoi']) <=> strtotime($b['date_envoi']);
        });
    }

    // Rendu de la vue
    $this->render('client/discussions/messages', [
        'messages' => $messages,
        'message_bailleurs' => $message_bailleurs,
        'id_bailleur' => $_GET['id'] ?? null
    ]);
}

public function NouveauMessage() {
    if (!isset($_SESSION['id_client'])) {
        // Redirige vers la page de connexion si non connecté
        $this->redirect('connexion');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_client = $_SESSION['id_client'];
        $id_bailleur = base64_decode($_POST['id_bailleur']);
        $message = htmlspecialchars(trim($_POST['contenu']));

        if (!empty($message)) {
            $clientBDD = new clientBDD();
            $clientBDD->nouveau_Message($id_client, $id_bailleur, $message);
        }

        // Redirection vers la discussion mise à jour
        $this->redirect('/client/messages_bailleurs?id=' . $_POST['id_bailleur']);
        exit;
    }

    // Si la requête n’est pas POST, rediriger
    $this->redirect('client/conversations');
}

public function NouveauMessageBailleur(){
    if (isset($_SESSION['id_client'])) {
        $client = new ClientBDD();
        $message='';
        $client->nouvelle_discussion($_SESSION['id_client'], base64_decode($_GET['id']), $message);
        $this->redirect('/client/messages_bailleurs?id=' .base64_decode($_GET['id']));
        exit;
    }
    
}

    public function acheter_cette_propriete(){
        if(isset($_SESSION['id_client'])){
             $id_propriete = base64_decode($_GET['id']);
        
            $propriete = new ProprieteBDD();
            $proprietes = $propriete->getProprieteById($id_propriete);
            $this->render('client/propriete/achloc/achat', ['proprietes' => $proprietes]);

    } else {
        $_SESSION['msg'] = "Erreur lier a l'achat merci de ressayer.";
        $this->render('client/rdv/list_favoris', ['msg' => $_SESSION['msg']]);
        return;
    }
            
        }

    
    public function louer_cette_propriete(){
               if(isset($_SESSION['id_client'])){
             $id_propriete = base64_decode($_GET['id']);
        
            $propriete = new ProprieteBDD();
            $proprietes = $propriete->getProprieteById($id_propriete);
            $this->render('client/propriete/achloc/achat', ['proprietes' => $proprietes]);

    } else {
        $_SESSION['msg'] = "Erreur lier a l'achat merci de ressayer.";
        $this->render('client/rdv/list_favoris', ['msg' => $_SESSION['msg']]);
        return;
    }
    }

    
        public function proceder_Achat(){
            if(isset($_SESSION['id_client'])){
                $id_propriete = $_SESSION['id_propriete'];
                $id_bailleur = 0;
                $id_agent = 0;
                $date_achat = date('Y-m-d H:i:s');
                $cl= new clientBDD();
                if($cl->dejaAcheter($_SESSION['id_client'], $id_propriete) == 1){
                    $_SESSION['msg'] = "Vous avez deja acheter cette propriete merci de ressayer.";
                    $this->redirect('/propriete/mes-proprietes-favoris');
                    exit;
                }
          
                $achat = new achat($id_bailleur,$id_propriete, $_SESSION['id_client'], $id_agent, $date_achat);
                $ach= $cl->acheterPropriete($achat);
                if($ach){
                    $_SESSION['msg'] = "Votre requete d'achat a été transmis au service d'achat.";

                    $this->redirect('/propriete/mes-proprietes-favoris');
                }else{
                    $_SESSION['msg'] = "Erreur lors de l'achat merci de ressayer.";
                    $this->redirect('/acheter-cette-propriete');
                }
                exit;
            }else{
                $_SESSION['msg'] = "Erreur lier a l'achat merci de ressayer.";
                $this->redirect('/acheter-cette-propriete');
                exit;
            }
        }

    public function LogoutClient()
    {
        // Détruire la session pour déconnecter l'utilisateur
        unset($_SESSION['id_client']);
     
        
        // Rediriger vers la page de connexion ou d'accueil
        $this->render('client/auth/connexion', ['msg' => "Vous avez été déconnecté avec succès."]);
        exit;
    }



}