<?php 
namespace model;
use config\Config;
use model\Agent;
use model\Client;

class AgentBDD extends Config{
    private $pdo;
    public function __construct()
    {
        $this->pdo=Config::getPdo()->getconnexion();
    }

    //ajouter un agent
    public function addAgent(Agent $agent): bool
    {
        $conx = "INSERT INTO agent (nom, prenom, username, telephone, mot_de_passe) VALUES (:nom, :prenom, :username, :telephone, :mot_de_passe)";
        $stmt = $this->pdo->prepare($conx);
        $stmt->bindValue(':nom', $agent->getNom());
        $stmt->bindValue(':prenom', $agent->getPrenom());
        $stmt->bindValue(':username', $agent->getUsername());
        $stmt->bindValue(':telephone', $agent->getTelephone());
        $stmt->bindValue(':mot_de_passe', ($agent->getPassword()));
        return $stmt->execute();
    }
    // function pour recuperer un agent par son email
    public function getAgentByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agent WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = [
                'id' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],  $row['username'],$row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $agents;
    }
    // function pour recuperer un agent par son id
    public function getAgentById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agent WHERE id_agent = :id");
        $stmt->execute([':id'=>$id]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = [
                'id' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],  $row['username'],$row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $agents;
    }
    // function pour recuperer tous les agents
    public function getAllAgents($limit,$ofset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agent 
        LIMIT :limit OFFSET :ofset");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = [
                'id' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],  $row['username'], $row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $agents;
    }

    public function agent_not_affected(){
        $stmt = $this->pdo->prepare("SELECT * FROM agent WHERE id_agent NOT IN (SELECT id_agent FROM client)");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = [
                'id' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],  $row['username'], $row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $agents;
    }

  
    public function LoginAgent($username,$password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agent WHERE username = ? AND mot_de_passe = ?");
        $stmt->execute([$username,$password]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            if($password===$row['mot_de_passe']){
                  return [
                'id_agent' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],   $row['username'],$row['telephone'], $row['mot_de_passe']),
            ];
            }
          
        }
         
    }
public function client_affecter($id_agent, $limit, $offset) {
    $sql = "SELECT * FROM client 
            WHERE id_agent = :id_agent 
            LIMIT :limit OFFSET :offset";
    
    $smt = $this->pdo->prepare($sql);
    $smt->bindValue(':id_agent', $id_agent, \PDO::PARAM_INT);
    $smt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $smt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $smt->execute();

    return $smt->fetchAll(\PDO::FETCH_ASSOC);
}


public function listes_valider_propriete($limit,$offset) {
    $sql = "SELECT p.*, t.libelle 
            FROM propriete p
            INNER JOIN type_propriete t ON p.id_type = t.id_type
            WHERE p.id_agent = 0
            LIMIT :limit 
            OFFSET :offset";
    $smt = $this->pdo->prepare($sql);
    $smt->bindParam(':limit', $limit, \PDO::PARAM_INT);
    $smt->bindParam(':offset', $offset, \PDO::PARAM_INT);
 
    $smt->execute();
    $data = $smt->fetchAll(\PDO::FETCH_ASSOC);

    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'id_propriete'=>$row['id_propiete'],
            'objet' => new Propriete(
                $row['id_type'], $row['etat'], $row['opt'], $row['situation_geo'],
                $row['prix'], $row['image1'], $row['image2'], $row['image3'],
                $row['descriptions'], $row['id_bailleur'], $row['date_ajout']
                
            ),
            'type' => new Typepropiete($row['libelle'])
        ];
    }

    return $result;
}

public function valider_Demande($id_agent,$id_propriete){
    $sql="UPDATE propriete set id_agent= :id_agent 
    WHERE id_propiete= :id_propriete";
    $smt=$this->pdo->prepare($sql);
    return $smt->execute([
        ':id_agent'=>$id_agent,
        'id_propriete'=>$id_propriete
    ]);
}

public function count_proprietes_non_validees() {
    $sql = "SELECT COUNT(*) FROM propriete WHERE id_agent = 0";
    return (int)$this->pdo->query($sql)->fetchColumn();
}





    public function nbre_client_affecter($id_agent){
        $sql="SELECT COUNT(*) as total_affecter FROM client WHERE id_agent= :id_agent";
        $smt=$this->pdo->prepare($sql);
        $smt->bindValue(':id_agent',$id_agent,\PDO::PARAM_INT);
        $smt->execute();
       return (int)$smt->fetchColumn();
    }


    public function nb_rdv(){
         $sql="SELECT COUNT(*) as total_rdv FROM rendezvous";
        $smt=$this->pdo->prepare($sql);
      
        $smt->execute();
       return (int)$smt->fetchColumn();
    }

    
 public function listes_rdv($limit, $offset)
{
    $sql = "SELECT 
                CONCAT(UPPER(c.nom), ' ', c.prenom) AS nomclient,
                CONCAT(UPPER(b.nom), ' ', b.prenom) AS nombailleur,
                r.date_rdv,
                r.heur_rdv,
                sr.statut AS etat
            FROM rendezvous r
            INNER JOIN bailleur b ON b.id_bailleur = r.id_bailleur
            INNER JOIN statut_rendezvous sr ON sr.id_statut = r.id_statut
            INNER JOIN client c ON c.id_client = r.id_client
            LIMIT :limit OFFSET :offset";

    $smt = $this->pdo->prepare($sql);
    $smt->bindParam(':limit', $limit, \PDO::PARAM_INT);
    $smt->bindParam(':offset', $offset, \PDO::PARAM_INT);
    $smt->execute();

    return $smt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function nombre_demande(){
         $sql="SELECT COUNT(*) as total_demande FROM propriete WHERE id_agent=0";
        $smt=$this->pdo->prepare($sql);
        $smt->execute();
       return (int)$smt->fetchColumn();
    }

    public function profile($id_agent){
        $sql="SELECT * FROM agent WHERE id_agent= :id_agent";
        $smt=$this->pdo->prepare($sql);
        
         $smt->execute([
            ':id_agent'=>$id_agent
         ]);
        $data = $smt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = [
                'id' => $row['id_agent'],
                'objet'=> new Agent($row['nom'], $row['prenom'],  $row['username'], $row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $agents;

    }


public function listes_achat($id_agent, $limit, $offset)
{
    $sql = "SELECT a.*, p.*, a.id_agent as id_ag, c.*
            FROM achat a
            INNER JOIN propriete p ON p.id_propiete = a.id_propriete
            INNER JOIN client c ON c.id_client = a.id_client
            WHERE c.id_agent = :id_agent 
              AND a.id_bailleur <> 0
            ORDER BY a.date_achat DESC
            LIMIT :limit OFFSET :offset";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_agent', $id_agent, \PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);

    $stmt->execute();
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'achat' => new Achat(
                $row['id_bailleur'],
                $row['id_propriete'],
                $row['id_client'],
                $row['id_ag'], 
                $row['date_achat']
            ),
            'client' => new Client(
                $row['nom'],
                $row['prenom'],
                $row['adresse'],
                $row['email'],
                $row['telephone'],
                $row['mot_de_passe'],
                $row['id_agent']
            ),
            'propriete' => new Propriete(
                $row['id_type'],
                $row['etat'],
                $row['opt'],
                $row['situation_geo'],
                $row['prix'],
                $row['image1'],
                $row['image2'],
                $row['image3'],
                $row['descriptions'],
                $row['id_bailleur'],
                $row['date_ajout']
            )
        ];
    }

    return $result;
}


public function listes_locations($id_agent, $limit, $offset)
{
    $sql = "SELECT a.*, p.*, a.id_agent as id_ag, c.*
            FROM locations a
            INNER JOIN propriete p ON p.id_propiete = a.id_propriete
            INNER JOIN client c ON c.id_client = a.id_client
            WHERE c.id_agent = :id_agent 
              AND a.id_bailleur <> 0
            ORDER BY a.date_achat DESC
            LIMIT :limit OFFSET :offset";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_agent', $id_agent, \PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);

    $stmt->execute();
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'location' => new Location($row['id_bailleur'], $row['id_propriete'], $row['id_client'], $row['id_agent'], $row['montant_location'],$row['date_debut'],$row['date_fin'],$row['date_locations']),
            'client' => new Client(
                $row['nom'],
                $row['prenom'],
                $row['adresse'],
                $row['email'],
                $row['telephone'],
                $row['mot_de_passe'],
                $row['id_agent']
            ),
            'propriete' => new Propriete(
                $row['id_type'],
                $row['etat'],
                $row['opt'],
                $row['situation_geo'],
                $row['prix'],
                $row['image1'],
                $row['image2'],
                $row['image3'],
                $row['descriptions'],
                $row['id_bailleur'],
                $row['date_ajout']
            )
        ];
    }

    return $result;
}
public function count_achats_by_agent($id_agent)
{
    $sql = "SELECT COUNT(*) FROM achat a
            INNER JOIN client c ON c.id_client = a.id_client
            WHERE c.id_agent = :id_agent AND a.id_bailleur <> 0";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_agent' => $id_agent]);
    return $stmt->fetchColumn();
}


   public function Bailleur_vailder_achat($id_agent,$id_propriete){
            $stmt = $this->pdo->prepare("UPDATE  achat SET id_agent = :id_agent WHERE id_propriete = :id_propriete");

        return $stmt->execute([
          
            'id_propriete' => $id_propriete,
            
            'id_agent' => $id_agent


        ]);
    }

    
    public function get_typepaiment(){
        $stmt = $this->pdo->prepare("SELECT * FROM moyen_paiement");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function get_typepaiment_id($id){
        $stmt = $this->pdo->prepare("SELECT * FROM type_paiment WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result;
    }


    public function valider_paiment(paiement $paiement){
        $sql= "INSERT INTO paiement (id_client,id_agent,id_propriete,id_moyen_paiement,id_bailleur,montant,date_paiement) VALUES (:id_client,:id_agent,:id_propriete,:id_moyen_paiement,:id_bailleur,:montant,:date_paiement)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_client', $paiement->getId_client());
        $stmt->bindValue( ':id_agent',$paiement->getId_agent());
        $stmt->bindValue(':id_propriete', $paiement->getId_propriete());
        $stmt->bindValue(':id_moyen_paiement', $paiement->getId_type_paiement());
        $stmt->bindValue(':id_bailleur', $paiement->getId_bailleur());
        $stmt->bindValue(':montant', $paiement->getMontant());
        $stmt->bindValue(':date_paiement', $paiement->getDate_paiement());
        return $stmt->execute();
    }

      public function valider_Locations(paiement $paiement){
        $sql= "INSERT INTO paiement (id_client,id_agent,id_propriete,id_moyen_paiement,id_bailleur,montant,date_paiement) VALUES (:id_client,:id_agent,:id_propriete,:id_moyen_paiement,:id_bailleur,:montant,:date_paiement)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_client', $paiement->getId_client());
        $stmt->bindValue( ':id_agent',$paiement->getId_agent());
        $stmt->bindValue(':id_propriete', $paiement->getId_propriete());
        $stmt->bindValue(':id_moyen_paiement', $paiement->getId_type_paiement());
        $stmt->bindValue(':id_bailleur', $paiement->getId_bailleur());
        $stmt->bindValue(':montant', $paiement->getMontant());
        $stmt->bindValue(':date_paiement', $paiement->getDate_paiement());
        return $stmt->execute();
    }


    public function deja_payer($id_agent,$id_propriete){
        $sql = "SELECT * FROM paiement WHERE id_agent = :id_agent AND id_propriete = :id_propriete";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_agent' => $id_agent, 'id_propriete' => $id_propriete]);
        $result = $stmt->fetch();
        return $result;
    }

public function get_Id_paiment_true($id_propriete) {
    $sql = "SELECT 1 FROM paiement WHERE id_propriete = :id_propriete LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_propriete' => $id_propriete]);
    return (bool) $stmt->fetchColumn(); 
}
public function maj_etat($id_propiete){
    $sql = "UPDATE propriete SET etat = 'Vendu' WHERE id_propiete = :id_propiete";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([':id_propiete' => $id_propiete]);
}

}