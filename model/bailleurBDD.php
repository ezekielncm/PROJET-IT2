<?php
namespace model;
use config\Config;
use PDO;
use model\Location;
class BailleurBDD extends Bailleur
{
    private $pdo;
    public function __construct()
    {
        // on instancie la classe Config pour avoir accés à la base de données
        // et on l'initialise
        $this->pdo = Config::getpdo()->getconnexion();
    }
    public function insertBailleur(Bailleur $bailleur): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO bailleur (nom, prenom, adresse,email,telephone,mot_de_passe,raison_social) VALUES (:nom, :prenom, :adresse,:email, :telephone,:mot_de_passe,:raison_social)");
        return $stmt->execute([
            'nom' => $bailleur->getNom(),
            'prenom' => $bailleur->getPrenom(),
            'email' => $bailleur->getEmail(),
            'mot_de_passe' => $bailleur->getPassword(),
            'telephone' => $bailleur->getTelephone(),
            'adresse' => $bailleur->getAdresse(),
            'raison_social' => $bailleur->getRaisonSocial(),
        ]);
    }

    public function getBailleurByEmail(string $email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bailleur WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $bailleurs = [];
        foreach ($row as $data) {
            $bailleurs[] = [
                'id' => $data['id_bailleur'],
                'objet' => new Bailleur($data['nom'], $data['prenom'], $data['raison_social'], $data['adresse'], $data['email'], $data['telephone'], $data['mot_de_passe']),
            ];
        }
        return $bailleurs;
    }

    public function getBailleurById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bailleur WHERE id_bailleur = :id");
        $stmt->execute([
            ':id' => $id
        ]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $bailleurs = [];
        foreach ($data as $row) {
            $bailleurs[] = [
                'id' => $row['id_bailleur'],
                'objet' => new Bailleur($row['nom'], $row['prenom'], $row['raison_social'], $row['adresse'], $row['email'], $row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $bailleurs;
    }

    public function getAllBailleurs()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bailleur");
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $bailleurs = [];
        foreach ($data as $row) {
            $bailleurs[] = [
                'id' => $row['id_bailleur'],
                'objet' => new Bailleur($row['nom'], $row['prenom'], $row['raison_social'], $row['adresse'], $row['email'], $row['telephone'], $row['mot_de_passe']),
            ];
        }
        return $bailleurs;
    }


    public function updateBailleur($id, $nom, $prenom, $email, $mot_de_passe, $telephone, $adresse, $raison_social): bool
    {
        $stmt = $this->pdo->prepare("UPDATE bailleur SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?, telephone = ?, adresse = ?, raison_social = ? WHERE id_bailleur = ?");
        return $stmt->execute([
            $nom,
            $prenom,
            $email,
            $mot_de_passe,
            $telephone,
            $adresse,
            $raison_social,
            $id
        ]);
    }
    public function deleteBailleur($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM bailleur WHERE id_bailleur = :id");
        return $stmt->execute([':id' => $id]);

    }

    // pas de medthode pour l'instant

    
public function loginBailleur($email, $password)
{
    $stmt = $this->pdo->prepare("SELECT * FROM bailleur WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($data as $row) {
        if (password_verify($password, $row['mot_de_passe'])) {
        // Connexion réussie, on retourne les données utiles
        return [
            'id' => $row['id_bailleur'],
            'objet' => new Bailleur(
                $row['nom'],
                $row['prenom'],
                $row['raison_social'],
                $row['adresse'],
                $row['email'],
                $row['telephone'],
                $row['mot_de_passe']
            )
        ];
    } else {
        // Mauvais mot de passe ou email inexistant
        return false;
    }
    }


}


   public function listes_rdv($id_bailleur){
        $sql= "SELECT c.nom,c.prenom,c.telephone,r.id_propriete,r.date_rdv,r.heur_rdv,r.descriptions,r.id_rdv,s.statut 
        FROM rendezvous r
        INNER JOIN client c ON r.id_client=c.id_client
        INNER JOIN statut_rendezvous s ON r.id_statut=s.id_statut
        WHERE r.id_bailleur=:id_bailleur
        ORDER BY r.date_rdv DESC";

        $smt = $this->pdo->prepare($sql);
        $smt->execute([':id_bailleur' => $id_bailleur]);
        return $smt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function nbr_rdv($id_bailleur){
        $sql= "SELECT COUNT(*) as total FROM rendezvous WHERE id_bailleur=:id_bailleur";
        $smt = $this->pdo->prepare($sql);
        $smt->execute([':id_bailleur' => $id_bailleur]);
        return (int)$smt->fetchColumn();
    }
    
    public function statut(){
        $sql= "SELECT * FROM statut_rendezvous";
        $smt = $this->pdo->prepare($sql);
        $smt->execute();
        return $smt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function changerEtat($id_rdv,$id_statut){
        $sql= "UPDATE rendezvous SET id_statut= :id_statut WHERE id_rdv=:id_rdv";
        $smt = $this->pdo->prepare($sql);
        $smt->execute([':id_rdv' => $id_rdv,
            ':id_statut' => $id_statut
            
    ]);
        return true;
    }
        
  
  public function rdv_by_id() {
    $sql = "SELECT c.nom, c.prenom, c.telephone, r.id_propriete, r.date_rdv, r.heur_rdv, r.descriptions, r.id_rdv, r.id_statut, s.statut 
            FROM rendezvous r
            INNER JOIN client c ON r.id_client = c.id_client
            INNER JOIN statut_rendezvous s ON r.id_statut = s.id_statut 
            WHERE r.id_rdv = :id_rdv";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id_rdv' => $_SESSION['id_rdv']]);
    return $stmt->fetch(\PDO::FETCH_ASSOC); // CHANGEMENT : fetch() au lieu de fetchAll()
}

public function update_statut() {
    $sql = "UPDATE rendezvous SET id_statut= :id_statut WHERE id_rdv=:id_rdv";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id_rdv' => $_SESSION['id_rdv'],
        ':id_statut' => $_SESSION['id_statut']
    ]);
    return true;
}

    public function verifierEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bailleur WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return count($row) > 0;
    }


    public function maj_profil(Bailleur $bailleur,$id_bailleur): bool
    {
        $stmt = $this->pdo->prepare("UPDATE bailleur SET nom = :nom, prenom = :prenom, adresse = :adresse, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe, raison_social = :raison_social WHERE id_bailleur = :id_bailleur");
        return $stmt->execute([
            'nom' => $bailleur->getNom(),
            'prenom' => $bailleur->getPrenom(),
            'email' => $bailleur->getEmail(),
            'telephone' => $bailleur->getTelephone(),
            'mot_de_passe' => $bailleur->getPassword(),
            'adresse' => $bailleur->getAdresse(),
            'raison_social' => $bailleur->getRaisonSocial(),
            'id_bailleur' => $id_bailleur
        ]);
    }



    public function get_mdp_by_id($id){
        $sql = "SELECT mot_de_passe FROM bailleur WHERE id_bailleur = :id_bailleur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_bailleur' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['mot_de_passe'];
    }

     public function get_messages_bailleur($id_bailleur) {
        $sql = "
            SELECT m1.*, cl.nom, cl.prenom
            FROM messages_bailleur m1
            INNER JOIN client cl ON m1.id_client = cl.id_client
            INNER JOIN (
                SELECT id_client, MAX(CONCAT(date_message_bailleur, ' ', heur_message_bailleur)) AS max_datetime
                FROM messages_bailleur
                WHERE id_bailleur = :id_bailleur
                GROUP BY id_client
            ) m2 ON m1.id_client = m2.id_client 
               AND CONCAT(m1.date_message_bailleur, ' ', m1.heur_message_bailleur) = m2.max_datetime
            WHERE m1.id_bailleur = :id_bailleur
            ORDER BY m1.date_message_bailleur DESC, m1.heur_message_bailleur DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_bailleur' => $id_bailleur]);
        return $stmt->fetchAll();
    }

    // Récupère tous les messages échangés entre un client et le bailleur (messages clients + bailleur)
    public function get_messages($id_client) {
        $sql = "SELECT mc.message_client, mc.date_message_client, mc.heur_message_client, 
                       mb.message_bailleur, mb.date_message_bailleur, mb.heur_message_bailleur, 
                       cl.nom, cl.prenom
                FROM messages_client mc
                INNER JOIN messages_bailleur mb ON mc.id_msg_bailleur = mb.id_msg_bailleur
                INNER JOIN client cl ON mc.id_client = cl.id_client
                INNER JOIN bailleur b ON mc.id_bailleur = b.id_bailleur
                WHERE mc.id_client = :id_client
                ORDER BY mc.date_message_client DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_client' => $id_client]);
        return $stmt->fetchAll();
    }

    // Messages envoyés par le client à ce bailleur
    public function getMessagesClient($id_client, $id_bailleur) {
        $sql = "SELECT message_client, date_message_client, heur_message_client 
                FROM messages_client 
                WHERE id_client = :id_client AND id_bailleur = :id_bailleur 
                ORDER BY date_message_client, heur_message_client DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_client' => $id_client,
            'id_bailleur' => $id_bailleur
        ]);
        return $stmt->fetchAll();
    }

    // Messages envoyés par le bailleur au client
    public function getMessagesBailleur($id_client, $id_bailleur) {
        $sql = "SELECT message_bailleur, date_message_bailleur, heur_message_bailleur 
                FROM messages_bailleur 
                WHERE id_client = :id_client AND id_bailleur = :id_bailleur 
                ORDER BY date_message_bailleur, heur_message_bailleur DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_client' => $id_client,
            'id_bailleur' => $id_bailleur
        ]);
        return $stmt->fetchAll();
    }

    // Enregistre un nouveau message envoyé par le bailleur au client
    public function nouveau_Message($id_bailleur, $id_client, $message_bailleur) {
        $sql = "INSERT INTO messages_bailleur (id_client, id_bailleur, message_bailleur, date_message_bailleur, heur_message_bailleur)
                VALUES (:id_client, :id_bailleur, :message_bailleur, :date, :heure)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id_client' => $id_client,
            'id_bailleur' => $id_bailleur,
            'message_bailleur' => $message_bailleur,
            'date' => date('Y-m-d'),
            'heure' => date('H:i:s')
        ]);
    }


    // listes des achats par id_protpriete

    public function getAchats($id_propriete){
        $sql = "SELECT a.*,p.image1,p.libelle,p.description,p.prix 
        FROM achat a
        INNER JOIN propriete p ON p.id_propiete = a.id_propriete
        WHERE a.id_propriete = p.id_propiete
        ORDER BY a.date_achat DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_propriete' => $id_propriete
        ]);
        return $stmt->fetchAll();
    }

public function listes_achat($id_bailleur){
    $sql = "SELECT a.*, p.*,a.id_bailleur as id_bail
            FROM achat a
            INNER JOIN propriete p ON p.id_propiete = a.id_propriete
            WHERE p.id_bailleur = :id_bailleur
          
            ORDER BY a.date_achat DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_bailleur' => $id_bailleur]);
    $data = $stmt->fetchAll();

    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'achat' => new Achat($row['id_bail'], $row['id_propriete'], $row['id_client'], $row['id_agent'], $row['date_achat']),
            'propriete' => new Propriete($row['id_type'], $row['etat'], $row['opt'], $row['situation_geo'], $row['prix'], $row['image1'], $row['image2'], $row['image3'], $row['descriptions'], $row['id_bailleur'], $row['date_ajout'])
        ];
    }

    return $result;


    }


    public function listes_locations($id_bailleur){
    $sql = "SELECT a.*, p.*,a.id_bailleur as id_bail
            FROM locations a
            INNER JOIN propriete p ON p.id_propiete = a.id_propriete
            WHERE p.id_bailleur = :id_bailleur
          
            ORDER BY a.date_achat DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_bailleur' => $id_bailleur]);
    $data = $stmt->fetchAll();

    $result = [];
    foreach ($data as $row) {
        $result[] = [
            'location' => new Location($row['id_bail'], $row['id_propriete'], $row['id_client'], $row['id_agent'], $row['montant_location'],$row['date_debut'],$row['date_fin'],$row['date_locations']),
            'propriete' => new Propriete($row['id_type'], $row['etat'], $row['opt'], $row['situation_geo'], $row['prix'], $row['image1'], $row['image2'], $row['image3'], $row['descriptions'], $row['id_bailleur'], $row['date_ajout'])
        ];
    }

    return $result;


    }
    public function Bailleur_vailder_achat($id_bailleur,$id_propriete){
            $stmt = $this->pdo->prepare("UPDATE  achat SET id_bailleur = :id_bailleur WHERE id_propriete = :id_propriete");

        return $stmt->execute([
          
            'id_propriete' => $id_propriete,
            
            'id_bailleur' => $id_bailleur


        ]);
    }

}
