<?php

namespace controllers;

use model\Bailleur;
use model\BailleurBDD;
use model\Manager;
use model\paiement;
use model\Propriete;
use model\ProprieteBDD;
use model\TypepropieteBDD;
use controllers\HomeControllers;
use model\clientBDD;
use model\AgentBDD;
use model\Agent;

class AgentControllers extends Controllers
{
 public function page_login(){
        if (isset($_SESSION['id_agent'])) {
            $agentBDD = new AgentBDD();
            $nb_demandes = $agentBDD->nombre_demande();
            $nb_clients = $agentBDD->nbre_client_affecter($_SESSION['id_agent']);
            $nb_rdv = $agentBDD->nb_rdv();

            $this->render('agent/accueil', [
                'nb_demandes' => $nb_demandes,
                'nb_clients' => $nb_clients,
                'nb_rdv' => $nb_rdv
            ]);
        } else {
            $this->render('agent/auth/connexion');
        }
    }
    public function  login_agent(){
        if (isset($_SESSION['id_agent'])) {
            $agentBDD = new AgentBDD();
            $nb_demandes = $agentBDD->nombre_demande();
            $nb_clients = $agentBDD->nbre_client_affecter($_SESSION['id_agent']);
            $nb_rdv = $agentBDD->nb_rdv();

            $this->render('agent/accueil', [
                'nb_demandes' => $nb_demandes,
                'nb_clients' => $nb_clients,
                'nb_rdv' => $nb_rdv
            ]);
        }
        else
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $username= htmlspecialchars(trim($_POST['username']));
            $mdp = htmlspecialchars(trim($_POST['mot_de_passe']));
            $login= new AgentBDD();
            $connexion=$login->LoginAgent($username,$mdp);
            if($connexion){
                $_SESSION['msg']="connexion reussie";
                $_SESSION['id_agent']=$connexion['id_agent'];
                $_SESSION['nom']=$connexion['objet']->getNom();
                $_SESSION['prenom']=$connexion['objet']->getPrenom();
                $_SESSION['telephone']=$connexion['objet']->getTelephone();
                $_SESSION['username']=$connexion['objet']->getUsername();
                  $nb_demandes = $login->nombre_demande();
            $nb_clients = $login->nbre_client_affecter($_SESSION['id_agent']);
            $nb_rdv = $login->nb_rdv();

                    $this->render('agent/accueil', [
                'nb_demandes' => $nb_demandes,
                'nb_clients' => $nb_clients,
                'nb_rdv' => $nb_rdv
            ]);
            }
            else{
                $_SESSION['msg']="Erreur de connexion";
             $this->redirect('/connexion-agent');   
            }
            
        }

    }

    public function listes_proprieter_ava()
    {
        if (isset($_SESSION['id_agent'])) {


            $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
            $limit = 6;
            $offset = ($page - 1) * $limit;

            $list = new AgentBDD();
            $proprietes = $list->listes_valider_propriete($limit, $offset);
            $total = $list->count_proprietes_non_validees();
            $totalPages = ceil($total / $limit);

          
                $this->render('agent/propriete/demande_validation', [
                    'proprietes' => $proprietes,
                    'page' => $page,
                    'totalPages' => $totalPages
                ]);
            

        }
    }

  
    public function valider_propriete(){
        if(isset($_SESSION['id_agent'])){
            $list = new AgentBDD();
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $id=base64_decode($_POST['id_propriete']);
                $valider=$list->valider_Demande($_SESSION['id_agent'],$id);

                if($valider){
                    $_SESSION['msg']="propriete valider";
                    $this->redirect('/connexion-agent');
                }
            }

        }

    }

    public function listes_mes_clients()
    {
        if (isset($_SESSION['id_agent'])) {
            $list = new AgentBDD();
            $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $clients = $list->client_affecter($_SESSION['id_agent'], $limit, $offset);
            $total = $list->nbre_client_affecter($_SESSION['id_agent']);
            $totalPages = ceil($total / $limit);

            $this->render('agent/propriete/listes_client',['clients'=>$clients,'totalPages'=>$totalPages,'page'=>$page]);

        }
    }

public function listes_rdv()
{
    if (isset($_SESSION['id_agent'])) {
        $list = new AgentBDD();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $listes_rdv = $list->listes_rdv($limit, $offset);
        $total = $list->nb_rdv();
        $totalPages = ceil($total / $limit);
        $this->render('agent/propriete/rdv', [
            'listes_rdv' => $listes_rdv,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    } 
}


public function profile_agent() {
    if(isset($_SESSION['id_agent'])){
        $profil = new AgentBDD();
        $vue= $profil->profile($_SESSION['id_agent']);
        $this->render('agent/profile/vue',['vue'=>$vue]);
    }
    
}

    public function nouveau_agent(){

    }



    public function client_affilier(){

    }


        public function LogoutAgent()
    {
        // Détruire la session pour déconnecter l'utilisateur
        unset($_SESSION['id_agent']);
        $_SESSION['msg']="Vous avez été déconnecté avec succès.";
        // Rediriger vers la page de connexion ou d'accueil
        $this->render('agent/auth/connexion', ['msg' => $_SESSION['msg'] ]);
        exit;
    }

 
public function listes_achatv() {
    if (isset($_SESSION['id_agent'])) {
        $achat = new AgentBDD();

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

      
        
        $ach = $achat->listes_achat($_SESSION['id_agent'], $limit, $offset);
        
        $total = $achat->count_achats_by_agent($_SESSION['id_agent']);
        $totalPages = ceil($total / $limit);

        $this->render('agent/propriete/achloc/achat', [
            'ach' => $ach,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    } else {
        $this->redirect('connexion');
        exit;
    }
}

public function deja_payer(){

}

public function valider_achat(){
    if (isset($_SESSION['id_agent'])){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id_propriete= htmlspecialchars($_POST['id_propriete']);
         
                $bailleurBDD = new AgentBDD();
                
                $validated = $bailleurBDD->Bailleur_vailder_achat($_SESSION['id_agent'],$id_propriete);
                if($validated){
                    $_SESSION['msg']= "propriete valider avec succes l'agent confirmera le paiement";
                     $this->redirect('/listes-achat-valider');
                }
                else{
                    $_SESSION['msg']= "erreur lors de la validation de la vente";
                    $this->redirect('/listes-achat-valider');
                }

       
        exit;

        }
      
   
    }
    else{
        $this->redirect('connexion');
        exit;
    }
}


public function reception_paiement() {
    if (!isset($_GET['id'])) {
        $this->redirect('/listes-achat-valider');
        exit;
    }

    $id_client = base64_decode($_GET['id']);
    $cl= new clientBDD();
    $client = $cl->getClientById($id_client);
    $propriete = $cl->getProprieteClients($id_client);
    $agentBDD = new AgentBDD();
    $typepaiment = $agentBDD->get_typepaiment();

    $this->render('agent/propriete/achloc/paiement', [
        'client' => $client,
        'propriete' => $propriete,
        'typepaiment' => $typepaiment
    ]);
}


public function reception_paiement_valider() {
    if (isset($_SESSION['id_agent'])) {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id_client= htmlspecialchars($_POST['id_client']);
            $id_propriete= htmlspecialchars($_POST['id_propriete']);
            $montant = htmlspecialchars($_POST['montant']);
            $id_bailleur= htmlspecialchars($_POST['id_bailleur']);
            $id_moyenpaiement= htmlspecialchars($_POST['type']);
            $montant_pro= htmlspecialchars($_POST['montant_pro']);
            $montant = floatval($montant);
            $id_agent= $_SESSION['id_agent'];
            $date_paiment = date('Y-m-d H:i:s');
            if($montant>$montant_pro){
                $_SESSION['msg']= "Le montant de la facture est supérieur au montant de paiement";
                $this->redirect('/listes-achat-valider');
                exit;
            }
            $paimentBDD = new AgentBDD();
            if($paimentBDD->deja_payer($id_agent,$id_propriete)){
                $_SESSION['msg']= "Ce client a déjà payé cette propriété";
                $this->redirect('/listes-achat-valider');
                exit;
            }
            $paiemnt = new paiement($id_client,$id_agent,$id_propriete,$id_moyenpaiement,$id_bailleur,$montant, $date_paiment);
       
            $validation = $paimentBDD->valider_paiment($paiemnt);
            if ($validation) {
                 $_SESSION['test']= $paimentBDD->get_Id_paiment_true($id_propriete);
                 $valid=$paimentBDD->maj_etat($id_propriete);
                    if ($valid) {
                        $_SESSION['msg']= "Le paiement a été validé";
                        $this->redirect('/reception-de-paiement');

                    }
                
          
        }
        else{
            $this->redirect('/listes-achat-valider');
        }
    }
    else{
        $this->redirect('connexion');
        exit;
    }
}
       

}
}
       
