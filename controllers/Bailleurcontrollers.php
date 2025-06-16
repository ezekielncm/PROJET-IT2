<?php

namespace controllers;

use model\Bailleur;
use model\BailleurBDD;
use model\Manager;
use model\Propriete;
use model\ProprieteBDD;
use model\TypepropieteBDD;
use controllers\HomeControllers;
use model\clientBDD;

class BailleurControllers extends Controllers
{
    public function register()
    {
        //session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupération et sécurisation des données
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $mot_de_passe = htmlspecialchars(trim($_POST['mot_de_passe']));
            $mot_de_passe2 = htmlspecialchars(trim($_POST['confirm_mot_de_passe']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $raison_social = htmlspecialchars(trim($_POST['raison_social']));

            $bailleurBDD = new BailleurBDD();

            // Vérifier si l'email existe déjà
            if ($bailleurBDD->getBailleurByEmail($email)) {
                $_SESSION['msg'] = "Cet email est déjà utilisé.";

                $this->render('bailleur/auth/inscription', ['error' => $_SESSION['msg']]);
                return;
            }

            // Vérification des mots de passe
            if ($mot_de_passe !== $mot_de_passe2) {
                $_SESSION['msg'] = "Les mots de passe ne correspondent pas.";
                $this->render('bailleur/auth/inscription', ['error' => $_SESSION['msg']]);
                return;
            }

            // Hachage du mot de passe
            $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
            $bailleur = new Bailleur($nom, $prenom, $raison_social, $adresse, $email, $telephone, $mot_de_passe_hache);
            $bail = $bailleurBDD->insertBailleur($bailleur);
            if (!$bail) {
                $_SESSION['msg'] = "Erreur lors de l'inscription. Veuillez réessayer.";
                $this->render('bailleur/auth/inscription', ['error' => $_SESSION['msg']]);
                return;
            } else {
                $_SESSION['msg'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";

                $this->render('bailleur/auth/connexion', ['success' => $_SESSION['msg']]);
                return;
            }
        } else {
            $this->render('public/home');
        }
    }

    public function home()
    {
        if (isset($_SESSION['id'])) {

            $bailleurpropr = new ProprieteBDD();

            // ENVOYER la variable à la vue
            $nbreProprietes = $bailleurpropr->getNbProprieteByBailleurID($_SESSION['id']);
            $_SESSION['nbreProprietes'] = $nbreProprietes;
            $nb_ventes = $bailleurpropr->nbProprietesVendu($_SESSION['id']);
            $rdv = new BailleurBDD();
            $rdv_ = $rdv->nbr_rdv($_SESSION['id']);


            $this->render('bailleur/accueil', ['success' => $_SESSION['msg'], 'nbreProprietes' => $nbreProprietes, 'nb_ventes' => $nb_ventes, 'rdv_' => $rdv_]);

            //$this->render('bailleur/accueil');
            return;
        } else {
            $this->render('bailleur/auth/connexion');
        }
    }



    // functiomn pour recuperer les donnes du bailleur et se connecter
    public function login_Bailleur()
    {
        // Si l'utilisateur est déjà connecté, on redirige vers l'accueil bailleur
        if (isset($_SESSION['id'])) {
            $bailleurpropr = new ProprieteBDD();
            $nbreProprietes = $bailleurpropr->getNbProprieteByBailleurID($_SESSION['id']);
            $_SESSION['nbreProprietes'] = $nbreProprietes;
            $rdv = new BailleurBDD();
            $rdv_ = $rdv->nbr_rdv($_SESSION['id']);
            $this->render('bailleur/accueil', ['success' => $_SESSION['msg'], 'nbreProprietes' => $nbreProprietes, 'rdv_' => $rdv_]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars(trim($_POST['email']));
            $mot_de_passe = htmlspecialchars(trim($_POST['mot_de_passe']));

            $bailleurBDD = new BailleurBDD();
            $bailleurpropr = new ProprieteBDD();

            $bailleurs = $bailleurBDD->loginBailleur($email, $mot_de_passe);
            if ($bailleurs) {
                $_SESSION['msg'] = 'connexion reussie ';

                $_SESSION['nom'] = $bailleurs['objet']->getNom();
                $_SESSION['prenom'] = $bailleurs['objet']->getPrenom();
                $_SESSION['email'] = $bailleurs['objet']->getEmail();
                $_SESSION['telephone'] = $bailleurs['objet']->getTelephone();
                $_SESSION['adresse'] = $bailleurs['objet']->getAdresse();
                $_SESSION['raison_social'] = $bailleurs['objet']->getRaisonSocial();
                $_SESSION['id'] = $bailleurs['id'];
                $id_bailleur = $_SESSION['id'];
                $nbreProprietes = $bailleurpropr->getNbProprieteByBailleurID($id_bailleur);
                $_SESSION['nbreProprietes'] = $nbreProprietes;
                $rdv_ = $bailleurBDD->nbr_rdv(
                    $id_bailleur
                );
                $nb_ventes = $bailleurpropr->nbProprietesVendu($id_bailleur);
                $_SESSION['nb_ventes'] = $nb_ventes;
                $this->render('bailleur/accueil', [
                    'success' => $_SESSION['msg'],
                    'nbreProprietes' => $nbreProprietes,
                    'nb_ventes' => $nb_ventes,
                    'rdv_' => $rdv_
                ]);
                exit();
            } else {
                $_SESSION['msg'] = 'email ou mot de passe incorrect';
                $this->render('bailleur/auth/connexion', ['error' => $_SESSION['msg']]);
                return;
            }
        } else {
            // Si ce n'est pas une requête POST (ex : accès direct à la page), afficher le formulaire
            $this->render('bailleur/auth/connexion');
        }
    }


    // controler pour creer de nouvelles insertions de proprietes

    public function NouvellePropiete()
    {
        $typepropiete = new TypepropieteBDD();
        $types = $typepropiete->getTypepropiete();
        $this->render('bailleur/propriete/add', ['types' => $types]);
    }
    // CONTROLLER

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $description = htmlspecialchars(trim($_POST['description']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $prix = htmlspecialchars(trim($_POST['prix']));
            $id_type = htmlspecialchars(trim($_POST['type']));
            $opt = htmlspecialchars(trim($_POST['opt']));
            $etat = "libre";
            $id_bailleur = $_SESSION['id'];

            // Chemin absolu vers le dossier public/assets/images/
            $uploadDir = realpath('assets/images');
            if (!$uploadDir) {
                $_SESSION['msg'] = "Erreur : le dossier d'images n'existe pas.";
                $this->render('bailleur/propriete/add');
                exit();
            }

            $uploadDir = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            // Fonction d'upload d'image sans condition
            function uploadImage($file, $uploadDir)
            {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $fileName = $file['name'];
                    $fileTmp = $file['tmp_name'];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $uniqueName = uniqid('img_', true) . '.' . $fileExt;
                    $destination = $uploadDir . $uniqueName;

                    if (move_uploaded_file($fileTmp, $destination)) {
                        return $uniqueName;
                    }
                }
                return null;
            }

            // Upload des images (im1 obligatoire, les autres facultatives)
            $image1 = uploadImage($_FILES['im1'], $uploadDir);
            $image2 = uploadImage($_FILES['im2'], $uploadDir);
            $image3 = uploadImage($_FILES['im3'], $uploadDir);

            if (!$image1) {
                $_SESSION['msg'] = "Erreur : L'image principale est obligatoire.";
                $this->render('bailleur/propriete/add');
                exit();
            }
            $date_ajout = date("Y-m-d");

            $propriete = new Propriete(
                $id_type,
                $etat,
                $opt,
                $adresse,
                $prix,
                $image1,
                $image2,
                $image3,
                $description,
                $id_bailleur,
                $date_ajout

            );

            $proprieteBDD = new ProprieteBDD();
            if ($proprieteBDD->insertPropriete($propriete)) {
                $_SESSION['msg'] = "Propriété ajoutée avec succès.";
                $nbreProprietes = $proprieteBDD->getNbProprieteByBailleurID($id_bailleur);
                $nb_ventes = $proprieteBDD->nbProprietesVendu($id_bailleur);
                $_SESSION['nbreProprietes'] = $nbreProprietes;
                $rdv = new BailleurBDD();
                $rdv_ = $rdv->nbr_rdv($id_bailleur);
                $this->render('bailleur/accueil', ['success' => $_SESSION['msg'], 'nbreProprietes' => $nbreProprietes, 'nb_ventes' => $nb_ventes, 'rdv_' => $rdv_]);
            } else {
                $_SESSION['msg'] = "Erreur lors de l'ajout de la propriété.";
                $this->render('bailleur/propriete/add');
            }
            exit();
        } else {
            $_SESSION['msg'] = "Erreur : requête invalide.";
            $this->render('bailleur/propriete/add');
        }
    }



    //controller pour affciher les proprietes du bailleur
    public function mes_propietes()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $limit = 6;
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $offset = ($page - 1) * $limit;

            $proprieteBDD = new ProprieteBDD();
            $total_props = $proprieteBDD->getNbProprieteByBailleurId($id);
            $total_pages = ceil($total_props / $limit);

            $proprietes = $proprieteBDD->getProprieteByBailleurId($id, $limit, $offset);
            $nb_ventes = $proprieteBDD->nbProprietesVendu($id);
            $rdv = new BailleurBDD();
            $rdv_ = $rdv->nbr_rdv($id);
            $this->render('bailleur/propriete/list', [
                'proprietes' => $proprietes,
                'total_pages' => $total_pages,
                'current_page' => $page,
                'nb_ventes' => $nb_ventes,
                'rdv_' => $rdv_
            ]);
        } else {
            $_SESSION['msg'] = 'Vous devez être connecté pour voir vos propriétés.';
            $this->render('bailleur/auth/connexion', ['error' => $_SESSION['msg']]);
        }
    }
    public function profile()
    {
        if (isset($_GET['id'])) {
            $id = base64_decode($_GET['id']);
            $bailleur = new BailleurBDD();
            $bail = $bailleur->getBailleurById($id);
            if ($bail) {
                $this->render('bailleur/profile/vue', ['bail' => $bail]);
            }
        }
    }


    public function detail()
    {
        $propriete = new ProprieteBDD();
        $id = $_GET['id'];
        $id = base64_decode($id);
        $proprietes = $propriete->getProprieteById($id);

        if ($proprietes) {
            $this->render('bailleur/propriete/detail', ['proprietes' => $proprietes]);
        } else {
            $this->render('error/404');
        }
    }
    // controller pour afficher les details d'une propriete



    public function supprimer_propriete()
    {
        $id = base64_decode($_GET['id']);
        $proprieteBDD = new ProprieteBDD();

        if ($proprieteBDD->deletePropriete($id)) {
            $_SESSION['supp'] = "Propriété supprimée avec succès.";
            $nbreProprietes = $proprieteBDD->getNbProprieteByBailleurID($_SESSION['id']);
            $nb_ventes = $proprieteBDD->nbProprietesVendu($_SESSION['id']);
            $_SESSION['nbreProprietes'] = $nbreProprietes;
            $rdv = new BailleurBDD();
            $rdv_ = $rdv->nbr_rdv($_SESSION['id']);
            $this->render('bailleur/accueil', ['success' => $_SESSION['msg'], 'nbreProprietes' => $nbreProprietes, 'nb_ventes' => $nb_ventes, 'rdv_' => $rdv_]);
        } else {
            $_SESSION['msg'] = "Erreur lors de la suppression de la propriété.";
            $this->render('bailleur/propriete/list', ['error' => $_SESSION['msg']]);
        }
    }



    public function modifier_propriete()
    {
        if ($_GET['id']) {
            $id = base64_decode($_GET['id']);
            $proprieteBDD = new ProprieteBDD();

            $propriete = $proprieteBDD->getProprieteById($id);
            $typepropiete = new TypepropieteBDD();
            $types = $typepropiete->getTypepropiete();


            if ($propriete) {

                $this->render('bailleur/propriete/edit', ['propriete' => $propriete, 'types' => $types]);
            } else {
                $_SESSION['error_modif'] = "Propriété non trouvée.";
                $this->render('bailleur/propriete/list', ['error' => $_SESSION['msg']]);
            }
        } else {
            $_SESSION['error_modif'] = "ID de propriété invalide.";
            $this->render('bailleur/propriete/list', ['error' => $_SESSION['msg']]);
        }
    }

    public function update_propriete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $description = htmlspecialchars(trim($_POST['description']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $prix = htmlspecialchars(trim($_POST['prix']));
            $id_type = htmlspecialchars(trim($_POST['type']));
            $opt = htmlspecialchars(trim($_POST['opt']));
            $etat = "libre";
            $id_bailleur = $_SESSION['id'];
            $id_propriete = $_SESSION['id_prop'];

            // Chemin absolu vers le dossier public/assets/images/
            $uploadDir = realpath('assets/images');
            if (!$uploadDir) {
                $_SESSION['error_modif'] = "Erreur : le dossier d'images n'existe pas.";
                $this->render('bailleur/propriete/add');
                exit();
            }

            $uploadDir = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            // Fonction d'upload d'image sans condition
            function uploadImage($file, $uploadDir)
            {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $fileName = $file['name'];
                    $fileTmp = $file['tmp_name'];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $uniqueName = uniqid('img_', true) . '.' . $fileExt;
                    $destination = $uploadDir . $uniqueName;

                    if (move_uploaded_file($fileTmp, $destination)) {
                        return $uniqueName;
                    }
                }
                return null;
            }

            $images = new ProprieteBDD();
            // Upload des images (im1 obligatoire, les autres facultatives)

            $image1 = uploadImage($_FILES['im1'], $uploadDir) ?? $images->getimagesById($id_propriete)['image1'];
            $image2 = uploadImage($_FILES['im2'], $uploadDir) ?? $images->getimagesById($id_propriete)['image2'];
            $image3 = uploadImage($_FILES['im3'], $uploadDir) ?? $images->getimagesById($id_propriete)['image3'];


            /*
            if(!isset($image1) ){
               
                $files= $images->getimagesById($id_propriete)['image1'];
                $image1 = uploadImage($files, $uploadDir);
            }
            if(!isset($image2) ){
                $files= $images->getimagesById($id_propriete)['image2'];
                $image2 = uploadImage($files, $uploadDir);
            }
            if(!isset($image3) ){
                $files= $images->getimagesById($id_propriete)['image3'];
                $image3 = uploadImage($files, $uploadDir);
            }
            */
            if (!$image1) {
                $_SESSION['error_modif'] = "Erreur : L'image principale est obligatoire.";
                $this->render('bailleur/propriete/add');
                exit();
            }
            $date_ajout = date("Y-m-d");

            $propriete = new Propriete(
                $id_type,
                $etat,
                $opt,
                $adresse,
                $prix,
                $image1,
                $image2,
                $image3,
                $description,
                $id_bailleur,
                $date_ajout

            );

            $proprieteBDD = new ProprieteBDD();
            if ($proprieteBDD->UpdateProprieteById($id_propriete, $propriete)) {
                $_SESSION['success_maj'] = "Propriéte mise a jour avec succès.";
                $nbreProprietes = $proprieteBDD->getNbProprieteByBailleurID($id_bailleur);
                $nb_ventes = $proprieteBDD->nbProprietesVendu($id_bailleur);
                $_SESSION['nbreProprietes'] = $nbreProprietes;
                $rdv = new BailleurBDD();
                $rdv_ = $rdv->nbr_rdv($id_bailleur);
                $this->render('bailleur/accueil', ['success' => $_SESSION['success_maj'], 'nbreProprietes' => $nbreProprietes, 'nb_ventes' => $nb_ventes, 'rdv_' => $rdv_]);
            } else {
                $_SESSION['msg'] = "Erreur lors de l'ajout de la propriété.";
                $this->render('bailleur/propriete/add');
            }
            exit();
        } else {
            $_SESSION['msg'] = "Erreur : requête invalide.";
            $this->render('bailleur/propriete/add');
        }
    }


    public function mes_rdv()
    {
        if (isset($_SESSION['id'])) {
            $rdv = new BailleurBDD();

            if ($rdv->listes_rdv($_SESSION['id'])) {
                $rdvs = $rdv->listes_rdv($_SESSION['id']);
                $statuts = $rdv->statut();
                $_SESSION['msg'] = 'Vos rendez-vous';
                $this->render('bailleur/rdv/list', ['rdvs' => $rdvs, 'statuts' => $statuts]);
            }
        }
    }



    public function accpeter_rdv()
    {
        $etardv = new clientBDD();
        $id_conf = $etardv->IdRdv('Confirme');
        if (isset($_SESSION['id'])) {
            $rdv = new BailleurBDD();
            if ($rdv->changerEtat($_SESSION['id_rdv'], $id_conf)) {
                $_SESSION['msg'] = 'Rendez-vous accepté';
                $this->redirect('/voir-mes-demande-de-visite');
            }
        }
    }

    public function changerEtat()
    {
        if (isset($_SESSION['id'])) {
            $statut = $_POST['statut'];
            $id_rdv = $_SESSION['id_rdv'];
            $rdv = new BailleurBDD();
            if ($rdv->changerEtat($statut, $id_rdv)) {
                $_SESSION['msg'] = 'Rendez-vous accepté';
                $this->redirect('/voir-mes-demande-de-visite');
            }
        }
    }

    public function detail_rdv()
    {
        if (isset($_SESSION['id_rdv'])) {
            $rdvModel = new BailleurBDD();
            $rdv = $rdvModel->rdv_by_id();
            $statuts = $rdvModel->statut();

            $_SESSION['msg'] = 'Vos rendez-vous';
            $this->render('bailleur/rdv/detail', [
                'rdv' => $rdv,
                'statuts' => $statuts
            ]);
        }
    }

    public function modifier_etat_rdv()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $_SESSION['id_statut'] = $_POST['nouveau_statut'];

            if (isset($_SESSION['id_rdv'])) {
                $rdv = new BailleurBDD();
                $modfi = $rdv->update_statut();
                if ($modfi) {
                    $_SESSION['msg'] = 'Statut modifié avec succès';
                    $this->redirect('/voir-mes-demande-de-visite');
                }
            }
        }
    }

    public function maj_profile()
    {
        if (isset($_SESSION['id'])) {
            $maj = new BailleurBDD();
            $bail = $maj->getBailleurById($_SESSION['id']);
            $this->render('bailleur/profile/edit', [
                'bail' => $bail
            ]);
        }
    }



    public function update_profile()
    {
        if (isset($_SESSION['id'])) {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $nom = htmlspecialchars(trim($_POST['nom']));
                $prenom = htmlspecialchars(trim($_POST['prenom']));
                $email = htmlspecialchars(trim($_POST['email']));
                //      $mot_de_passe = htmlspecialchars(trim($_POST['mot_de_passe']));

                $telephone = htmlspecialchars(trim($_POST['telephone']));
                $adresse = htmlspecialchars(trim($_POST['adresse']));
                $raison_social = htmlspecialchars(trim($_POST['raison_social']));
                $bailleurBDD = new BailleurBDD();

                $mdp = $bailleurBDD->get_mdp_by_id($_SESSION['id']);
                $bailleur = new  Bailleur($nom, $prenom, $raison_social, $adresse, $email, $telephone, $mdp);

                if ($bailleurBDD->maj_profil($bailleur, $_SESSION['id'])) {
                    $_SESSION['msg'] = 'Profil modifié avec succès';
                    $this->redirect('/Mon-profil?id=' . base64_encode($_SESSION['id']));
                }
            }
        }
    }

    public function messages()
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect('connexion');
            return;
        }

        $bailleurBDD = new bailleurBDD();
        $id_bailleur = $_SESSION['id'];

        // Liste des clients avec leurs derniers messages
        $messages = $bailleurBDD->get_messages_bailleur($id_bailleur);

        // Vérifie si un client est sélectionné
        $id_client = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
        $message_clients = [];

        if ($id_client) {
            $message_clients = $bailleurBDD->get_messages($id_client);
        }

        // Vue côté bailleur
        $this->render('bailleur/discussion/messages', [
            'messages' => $messages,
            'message_clients' => $message_clients
        ]);
    }
    public function conversations()
    {
        if (!isset($_SESSION['id_bailleur'])) {
            $this->redirect('connexion');
            return;
        }

        $bailleurBDD = new bailleurBDD();
        $id_bailleur = $_SESSION['id_bailleur'];

        // Liste des clients avec leurs derniers messages
        $messages = $bailleurBDD->get_messages_bailleur($id_bailleur);

        // Vérifie si un client est sélectionné
        $id_client = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
        $message_clients = [];

        if ($id_client) {
            // Messages envoyés par le bailleur et par le client
            $messages_client = $bailleurBDD->getMessagesClient($id_client, $id_bailleur);
            $messages_bailleur = $bailleurBDD->getMessagesBailleur($id_client, $id_bailleur);

            // Normalisation des messages du client
            foreach ($messages_client as &$msg) {
                $msg['expediteur'] = 'client';
                $msg['contenu'] = $msg['message_client'];
                $msg['date_envoi'] = $msg['date_message_client'] . ' ' . $msg['heur_message_client'];
                unset($msg['message_client'], $msg['date_message_client'], $msg['heur_message_client']);
            }

            // Normalisation des messages du bailleur
            foreach ($messages_bailleur as &$msg) {
                $msg['expediteur'] = 'bailleur';
                $msg['contenu'] = $msg['message_bailleur'];
                $msg['date_envoi'] = $msg['date_message_bailleur'] . ' ' . $msg['heur_message_bailleur'];
                unset($msg['message_bailleur'], $msg['date_message_bailleur'], $msg['heur_message_bailleur']);
            }

            // Fusion et tri
            $message_clients = array_merge($messages_client, $messages_bailleur);
            usort($message_clients, function ($a, $b) {
                return strtotime($a['date_envoi']) <=> strtotime($b['date_envoi']);
            });
        }

        // Vue
        $this->render('bailleur/discussion/messages', [
            'messages' => $messages,
            'message_clients' => $message_clients,
            'id_client' => $_GET['id'] ?? null
        ]);
    }

    public function NouveauMessage()
    {
        if (!isset($_SESSION['id_bailleur'])) {
            $this->redirect('connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_bailleur = $_SESSION['id_bailleur'];
            $id_client = base64_decode($_POST['id_client']);
            $message = htmlspecialchars(trim($_POST['contenu']));

            if (!empty($message)) {
                $bailleurBDD = new bailleurBDD();
                $bailleurBDD->nouveau_Message($id_bailleur, $id_client, $message);
            }

            $this->redirect('/bailleur/messages_clients?id=' . $_POST['id_client']);
            exit;
        }

        $this->redirect('bailleur/conversations');
    }


    public function listes_demandeAchat()
    {
        if (isset($_SESSION['id_bailleur'])) {
            $achat = new BailleurBDD();
            $ach = $achat->listes_achat($_SESSION['id_bailleur']);
            $this->render('bailleur/propriete/achloc/achat', [
                'ach' => $ach
            ]);
        } else {
            $this->redirect('connexion');
            exit;
        }
    }

    public function valider_achat()
    {
        if (isset($_SESSION['id_bailleur'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_propriete = htmlspecialchars($_POST['id_propriete']);
                $bailleurBDD = new BailleurBDD();
                $validated = $bailleurBDD->Bailleur_vailder_achat($_SESSION['id_bailleur'], $id_propriete);
                if ($validated) {
                    $_SESSION['msg'] = "propriete valider avec succes l'agent confirmera le paiement";
                    $this->redirect('/ventes-locations');
                } else {
                    $_SESSION['msg'] = "erreur lors de la validation de la vente";
                    $this->redirect('/ventes-locations');
                }


                exit;
            }
        } else {
            $this->redirect('connexion');
            exit;
        }
    }




    public function logout()
    {

        unset($_SESSION['id']);
        header('Location: /');


        exit();
    }
}
