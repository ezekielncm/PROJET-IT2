<?php 
namespace model;

class Agent{
    private string $nom;
    private string $prenom;
    private   string $username;  
    private string $telephone;
    private string $mot_de_passe;
    

    public function __construct(string $nom, string $prenom, string $username ,string $telephone, string $mot_de_passe)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->username=$username;
        $this->telephone = $telephone;
        $this->mot_de_passe = $mot_de_passe;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->mot_de_passe;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }
    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    public function setPassword(string $mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }
}