<?php 
namespace model;
class paiement{
    private $id_client;
    private $id_bailleur;
    private $montant;
    private $date_paiement;

    private $id_propriete;
    private $id_type_paiement;
    private $id_agent;
    

    public function __construct($id_client,$id_agent,$id_propriete,$id_type_paiement,$id_bailleur,$montant, $date_paiement){
        $this->id_client = $id_client;
        $this->id_bailleur = $id_bailleur;
        $this->id_agent = $id_agent;
        $this->montant = $montant;
        $this->date_paiement = $date_paiement;
        $this->id_propriete = $id_propriete;
        $this->id_type_paiement = $id_type_paiement;
        
    }

    public function getId_agent(){
        return $this->id_agent;
    }
    public function setId_agent($id_agent) {
        $this->id_agent = $id_agent;
    }
    public function getId_client(){
        return $this->id_client;
    }
    public function setId_client($id_client) {
        $this->id_client = $id_client;
    }

    public function getId_bailleur() {
        return $this->id_bailleur;
    }

    public function setId_bailleur($id_bailleur) {
        $this->id_bailleur = $id_bailleur;
    }
    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
    }
    public function getDate_paiement() {
        return $this->date_paiement;
    }

    public function setDate_paiement($date_paiement) {
        $this->date_paiement = $date_paiement;
    }
    public function getId_propriete() {
        return $this->id_propriete;
    }

    public function setId_propriete($id_propriete) {
        $this->id_propriete = $id_propriete;
    }
    public function getId_type_paiement() {
        return $this->id_type_paiement;
    }

}