<?php 
namespace model;

class Location {
    private int $id_propriete;
    private int  $id_client;
    private int  $id_agent;

      private int  $id_bailleur;
        private int  $montant_locations;
    private  $date_debut;

    private  $date_fin;
    private $date_locations;

    public function __construct(int $id_bailleur,int $id_propriete, int $id_client, int $id_agent,float $montant_location,  $date_debut,  $date_fin,$date_location) {
        $this->id_propriete = $id_propriete;
        $this->id_bailleur= $id_bailleur;
        $this->id_client = $id_client;
        $this->id_agent = $id_agent;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->montant_locations=$montant_location;
        $this->date_locations= $date_location;
    }

    public function getIdPropriete(): string {
        return $this->id_propriete;
    }
      public function getIdbailleur(): string {
        return $this->id_bailleur;
    }
    public function getIdClient(): string {
        return $this->id_client;
    }

     public function getDate_locations(): string {
        return $this->id_client;
    }
    public function getIdAgent(): string {
        return $this->id_agent;
    }
    public function getDateDebut(): string {
        return $this->date_debut;
    }
    public function getDateFin(): string {
        return $this->date_fin;
    }
    public function setIdPropriete( $id_propriete): void {
        $this->id_propriete = $id_propriete;
    }
    public function setIdClient( $id_client): void {
        $this->id_client = $id_client;
    }
    public function setIdAgent( $id_agent): void {
        $this->id_agent = $id_agent;
    }
}