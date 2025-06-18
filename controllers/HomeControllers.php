<?php 
namespace controllers;
use model\clientBDD;
use model\Propriete;
use model\ProprieteBDD;
class HomeControllers extends Controllers{
    public function home() {
              /*if (isset($_SESSION['id'])) {
        $this->render('bailleur/accueil');
        return;
    }
        */
        $proprietes = new ProprieteBDD();
        $ProprieteBDD = new ProprieteBDD();
        $limit = 3;
        $ofset = 0;
        $proprietes = $proprietes->getAlldataforpropriete($limit,$ofset);
        $bannieres = new ProprieteBDD(); // ou autre classe dédiée aux bannières
       $bannieres = $bannieres->getBannieresAccueil(); 
           
           $nb_ventes = $ProprieteBDD->nbProprietesVendu(isset($_SESSION['id']) ? $_SESSION['id'] : null);
                $_SESSION['nb_ventes'] = $nb_ventes;
        if($proprietes){
            $this->render('public/home', ['proprietes' => $proprietes, 'bannieres' => $bannieres,'nb_ventes'=>$nb_ventes]);

        }
        else{
            $this->render('error/404');
        }
        
    }
    public function detail() {
        $propriete = new ProprieteBDD();
        $id = $_GET['id'];
        $id = base64_decode($id);
        $proprietes = $propriete->getProprieteById($id);

        if($proprietes){
            $this->render('propriete/detail', ['proprietes' => $proprietes]);
        }
        else{
            $this->render('error/404');
        }
    }
     public function connexion_baileur() {
          if (isset($_SESSION['id'])) {
              $proprieteBDD = new ProprieteBDD();
              $nb_ventes= $proprieteBDD->nbProprietesVendu($_SESSION['id']);
    
                    $nbreProprietes = $proprieteBDD->getNbProprieteByBailleurID(isset($_SESSION['id']) ? $_SESSION['id'] : null);
                $_SESSION['nbreProprietes'] = $nbreProprietes;
                $this->render('bailleur/accueil', ['nbreProprietes' => $nbreProprietes,'nb_ventes'=>$nb_ventes]);
             // $this->render('bailleur/accueil');
        return;
    }
        $this->render('bailleur/auth/connexion');

    }
    public function connexion_client() {
        if (isset($_SESSION['id_client'])) {
             $proprietes = new ProprieteBDD();
        $ProprieteBDD = new ProprieteBDD();
        $clientBDD= new clientBDD();
        $limit = 3;
        $ofset = 0;
        $proprietes = $proprietes->getAlldataforpropriete($limit,$ofset);
        $bannieres = new ProprieteBDD(); // ou autre classe dédiée aux bannières
       $bannieres = $bannieres->getBannieresAccueil(); 
           
           $nb_ventes = $ProprieteBDD->nbProprietesVendu(isset($_SESSION['id']) ? $_SESSION['id'] : null);
            $nombresAchat = $clientBDD->nbr_acheter($_SESSION['id_client']);
                $_SESSION['nb_ventes'] = $nb_ventes;
        if($proprietes){
            $this->render('client/accueil', ['proprietes' => $proprietes, 'bannieres' => $bannieres,'nb_ventes'=>$nb_ventes,'nombresAchat'=>$nombresAchat]);
            exit;

        }
        }
        else{
            $this->render('client/auth/connexion');
            exit;

        }
       
    }
    
    public function inscription_client() {
        if (isset($_SESSION['id_client'])) {
            $this->render('client/accueil');
            return;
        }
        $this->render('client/auth/inscription');
    }
    public function connexion_bail() {
        $this->render('bailleur/auth/inscription');
    }
    public function about() {
        // Possibilité d'ajouter des données dynamiques à la page à propos
        $infos = [
            'version' => '1.0',
            'date' => date('Y'),
            // Ajoutez ici d'autres infos si besoin
        ];
        $this->render('public/about', $infos);
    }

    public function contact() {
        $flash = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');
            if ($nom && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Ici, vous pouvez ajouter l'envoi d'email ou l'enregistrement en BDD
                $flash = [
                    'type' => 'success',
                    'msg' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement !'
                ];
            } else {
                $flash = [
                    'type' => 'error',
                    'msg' => 'Merci de remplir tous les champs correctement.'
                ];
            }
        }
        $this->render('public/contact', [
            'flash' => $flash,
            'old' => $_POST ?? []
        ]);
    }
public function listes_prorpietes_home() {

    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;
    $propriete = new ProprieteBDD();
    $total_props = $propriete->countProprietesLibres();
    $total_pages = ceil($total_props / $limit);
    $proprietes = $propriete->getAlldataforpropriete($limit, ofset: $offset);

  
    if ($proprietes && is_array($proprietes)) {
        $this->render('propriete/liste', [
            'proprietes' => $proprietes,
            'page' => $page,
            'total_pages' => $total_pages
        ]);
    } else {
        $this->render('error/404');
    }
}

    public function error404() {
        $this->render('error/404');
    }
}