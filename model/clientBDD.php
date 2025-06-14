<?php
namespace model;
//require_once __DIR__ . '/../vendor/autoload.php';
use config\Config;
use PDO;
use model\Client;
use model\Achat;
use model\Location;
use model\Propriete;
use model\ProprieteBDD;

class clientBDD extends Client
{

    private $pdo;
    public function __construct()
    {
        // on instancie la classe Config pour avoir accés à la base de données
        // et on l'initialise
        $this->pdo = Config::getpdo()->getconnexion();


    }

    // function pour inserer un nouveau client
    public function insertClient(Client $client): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO client (nom, prenom, adresse,email,telephone,mot_de_passe,id_agent ) VALUES (:nom, :prenom, :adresse,:email, :telephone,:mot_de_passe,:id_agent )");
        return $stmt->execute([
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'email' => $client->getEmail(),
            'mot_de_passe' => $client->getPassword(),
            'telephone' => $client->getNumero_telephone(),

            'adresse' => $client->getAdresse(),
            'id_agent' => $client->getId_agent(),
        ]);
    }

    // function pour recuperer un client par son email
    public function getClientTelephone(string $telephone)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM client WHERE telephone = ?");
        $stmt->execute([$telephone]);
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];

        foreach ($data as $row) {
            $clients[] = [
                'id' => $row['id_client'],
                'objet' => new Client($row['nom'], $row['prenom'], $row['adresse'], $row['email'], $row['numero_telephone'], $row['motd_de_passe'], $row['id_agent']),

            ];
        }
        return $clients;
    }
    // function pour recuperer un client par son id
    public function getClientById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT c.* ,a.nom AS nom_agent ,a.prenom as prenom_agent
        FROM client c
        INNER JOIN agent a ON c.id_agent = a.id_agent
        WHERE id_client = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];

        foreach ($data as $row) {
            $clients[] = [
                'id' => $row['id_client'],
                'nom_agent'=>$row['nom_agent'],
                'prenom_agent'=> $row['prenom_agent'],
                'objet' => new Client($row['nom'], $row['prenom'], $row['adresse'], $row['email'], $row['telephone'], $row['mot_de_passe'], $row['id_agent']),

            ];
        }
        return $clients;
    }

    // function pour recuperer un client par son id

    public function updateClient($id, Client $client): bool
    {
        $stmt = $this->pdo->prepare("UPDATE client SET nom = ?, prenom = ?, email = ?, password = ?, numero_telephone = ?, username = ?, adresse = ? WHERE id = ?");
        return $stmt->execute([
            $client->getNom(),
            $client->getPrenom(),
            $client->getEmail(),
            $client->getPassword(),
            $client->getNumero_telephone(),

            $client->getAdresse(),


        ]);
    }
    // function pour supprimer un client

    public function deleteClient($id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM client WHERE id_client = :id");
        return $stmt->execute([
            ':id' => $id
        ]);
    }

    // function pour recuperer tous les clients
    public function getAllClients($limit, $ofset)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM client 
        LIMIT :limit OFFSET :ofset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':ofset', $ofset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];

        foreach ($data as $row) {
            $clients[] = [
                'id' => $row['id_client'],
                'objet' => new Client($row['nom'], $row['prenom'], $row['adresse'], $row['email'], $row['numero_telephone'], $row['motd_de_passe'], $row['id_agent']),

            ];
        }
        return $clients;
    }

    // foction pour se connecter
    public function LoginClient($telephone, $password)
    {
    $stmt = $this->pdo->prepare("SELECT * FROM client WHERE telephone = :telephone");
    $stmt->execute([':telephone'=>$telephone]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $data) {
        if (password_verify($password, $data['mot_de_passe'])) {
            return [
                'id' => $data['id_client'],

                'objet' => new Client($data['nom'], $data['prenom'], $data['adresse'], $data['email'], $data['telephone'], $data['mot_de_passe'], $data['id_agent']),
            ];
        }
}
        return null; // Si aucun client trouvé ou mot de passe incorrect
    }
    


      

    // function pour acheter une propriete
    public function acheterPropriete(Achat $achat): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO achat (id_bailleur,id_propriete,id_client,id_agent,date_achat) VALUES (:id_bailleur,:id_propriete,:id_client,:id_agent,:date_achat)");
        return $stmt->execute([
            'id_bailleur' => $achat->getIdBailleur(),
            'id_client' => $achat->getIdClient(),
            'id_propriete' => $achat->getIdPropriete(),
            'id_agent' => $achat->getIdAgent(),
            'date_achat' => $achat->getDateAchat(),


        ]);

    }


    // deja louerrrrrrrrrrrr???
 
    public function dejaLouer($id_client, $id_propriete): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM locationd WHERE id_client = :id_client AND id_propriete = :id_propriete");
        $stmt->execute([':id_client' => $id_client, ':id_propriete' => $id_propriete]);
        return $stmt->rowCount() > 0;
    }

    // deja acheter ?????
    public function dejaAcheter($id_client, $id_propriete): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM achat WHERE id_client = :id_client AND id_propriete = :id_propriete");
        $stmt->execute([':id_client' => $id_client, ':id_propriete' => $id_propriete]);
        return $stmt->rowCount() > 0;
    }

    
    //fonctoion pour louer des appartements

    public function louerpropriete(Location $location): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO location (id_propriete,id_client,id_agent,date_debut,date_fin) VALUES (:id_propriete,:id_client,:id_agent,:date_location)");
        return $stmt->execute([
            'id_client' => $location->getIdClient(),
            'id_propriete' => $location->getIdPropriete(),
            'id_agent' => $location->getIdAgent(),
            'date_debut' => $location->getDateDebut(),
            'date_fin' => $location->getDateFin(),
        ]);

    }


    public function dejaFavoris($id_client, $id_propriete): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM favoris WHERE id_client = :id_client AND id_propiete = :id_propiete");
        $stmt->execute([
            ':id_client' => $id_client,
            ':id_propiete' => $id_propriete
        ]);
        return $stmt->rowCount() > 0; // Retourne true si déjà favorisé, false sinon
    }   

    public function favoriserPropriete($id_client, $id_propriete, $date_ajout)
    {
        $stmt = $this->pdo->prepare("INSERT INTO favoris (id_client, id_propiete,date_ajout) VALUES (:id_client, :id_propiete, :date_ajout)");
        return $stmt->execute([
            ':id_client' => $id_client,
            ':id_propiete' => $id_propriete,
            ':date_ajout' => $date_ajout
        ]);
    }

public function getFavorisByClient($id_client, $limit, $offset): array
{
    $sql = "
        SELECT 
            f.id_favoris,
            f.id_client,
            f.id_propiete,
            f.date_ajout,
            p.opt,
            p.image1,
            p.prix,
            t.libelle
        FROM favoris f
        JOIN propriete p ON p.id_propiete = f.id_propiete
        JOIN type_propriete t ON t.id_type = p.id_type
        WHERE f.id_client = :id_client
        ORDER BY f.date_ajout DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_client', $id_client, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function update_client(Client $client,$id_client){
    $sql= "UPDATE client SET nom = :nom, prenom = :prenom, adresse = :adresse, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe WHERE id_client = :id_client
    ";
    $smt=$this->pdo->prepare($sql);
    return $smt->execute([
        ':nom' => $client->getNom(),
        ':prenom' => $client->getPrenom(),
        ':adresse' => $client->getAdresse(),
        ':email' => $client->getEmail(),
        ':telephone' => $client->getNumero_telephone(),
        ':mot_de_passe' => $client->getPassword(),
        ':id_client' => $id_client
    ]);
}

   public function get_password_by_id(){
    $sql= "SELECT mot_de_passe FROM client WHERE id_client = :id_client";
      $stmt=$this->pdo->prepare($sql);
      $stmt->execute([':id_client' => $_SESSION['id_client']]);
      return $stmt->fetchColumn();
   }

   public function get_agent_by_id(){
     $sql= "SELECT id_agent FROM client WHERE id_client = :id_client";
      $stmt=$this->pdo->prepare($sql);
      $stmt->execute([':id_client' => $_SESSION['id_client']]);
      return $stmt->fetchColumn();
   }
    public function supprimerFavoris($id_client, $favoris): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM favoris WHERE id_client = :id_client AND id_favoris = :id_favoris");
        return $stmt->execute([
            ':id_client' => $id_client,
            ':id_favoris' => $favoris 
        ]);
    }
    public function countFavorisByClient($id_client): int
{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM favoris WHERE id_client = :id");
    $stmt->execute([':id' => $id_client]);
    return (int) $stmt->fetchColumn();
}

public function Prendre_rendevez( $id_client, $id_propriete, $id_bailleur,$date_rendez_vous, $heur_rdv, $id_statut,$descriptions): bool
{
    $stmt = $this->pdo->prepare("INSERT INTO rendezvous (id_client, id_propriete,id_bailleur, date_rdv,heur_rdv,id_statut,descriptions) VALUES (:id_client, :id_propriete,:id_bailleur ,:date_rdv,:heur_rdv, :id_statut, :descriptions)");
    return $stmt->execute([
        ':id_client' => $id_client,
        ':id_propriete' => $id_propriete,
        ':id_bailleur'=>$id_bailleur,
        ':date_rdv' => $date_rendez_vous,
        ':heur_rdv' => $heur_rdv,
        ':id_statut' => $id_statut,
        ':descriptions' => $descriptions
    ]);

}

public function IdRdv($statut){
    $stmt = $this->pdo->prepare("SELECT id_statut FROM statut_rendezvous WHERE statut = :statut");
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($data) {
        return $data['id_statut'];
    }
    
    return null; // Si aucun rendez-vous trouvé avec ce statut
}

public function verifierRendezVous($id_client, $id_propriete): bool {
    $stmt = $this->pdo->prepare("SELECT * FROM rendezvous WHERE id_client = :id_client AND id_propriete = :id_propriete ");
    $stmt->execute([
        ':id_client' => $id_client,
        ':id_propriete' => $id_propriete,
       
    ]);
    return $stmt->rowCount() > 0;
}
public function listes_rdvs($id_client,$limit,$offset){
    $sql= "SELECT r.id_rdv ,r.id_client, r.id_propriete, r.date_rdv,r.id_statut,r.descriptions,r.heur_rdv,sr.statut,b.raison_social
    FROM rendezvous r
    JOIN statut_rendezvous sr
    on r.id_statut = sr.id_statut
    join propriete p 
    on p.id_propiete = r.id_propriete
    join bailleur b 
    on b.id_bailleur= p.id_bailleur
    WHERE r.id_client = :id_client
    ORDER BY r.date_rdv DESC
    LIMIT :limit
    OFFSET :offset
    ";
    $stmt=$this->pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':id_client',$id_client);
   
    $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function nbres_favoris($id){
    $sql = "SELECT COUNT(*) as total FROM favoris WHERE id_client = :id_client";    
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_client', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

public function nbr_louer(){
    $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM locations 
    WHERE id_client = :id_client AND 
      id_agent <>0 AND
    id_bailleur <>0
    ");
    $stmt->bindValue(':id_client', $_SESSION['id_client'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

public function nbr_acheter($id){
    $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM achat 
    WHERE id_client = :id_client  AND 
    id_agent <>0 AND
    id_bailleur <>0
    ");
    $stmt->bindValue(':id_client', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}

public function nbr_rdv($id){
    $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM rendezvous WHERE id_client = :id_client");
    $stmt->bindValue(':id_client', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;

}

public function supprimerRdv($id_rdv, $id_client){
    $sql = "DELETE FROM rendezvous WHERE id_rdv= :id_rdv AND id_client = :id_client";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        'id_rdv' => $id_rdv,
        'id_client' => $id_client
    ]);
    
}

    public function get_messages($id_bailleur){
        $sql= "SELECT mc.message_client,mc.date_message_client,mc.heur_message_client,mb.message_bailleur,mb.message_bailleur,mb.heur_message_bailleur ,b.raison_social 
        from messages_client mc
        INNER JOIN messages_bailleur mb ON mc.id_msg_bailleur = mb.id_msg_bailleur
        INNER JOIN bailleur b ON mc.id_bailleur = b.id_bailleur
        INNER JOIN client cl ON mc.id_client = cl.id_client
        WHERE mc.id_bailleur = :id_bailleur
        ORDER BY mc.date_message_client DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_bailleur'=> $id_bailleur]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function get_dernier_message_bailleur($id_bailleur){
    $sql = "SELECT message_bailleur 
            FROM messages_bailleur 
            WHERE id_bailleur = :id_bailleur 
            ORDER BY date_message_bailleur DESC, heur_message_bailleur DESC
            LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
            'id_bailleur' => $id_bailleur
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}


public function nouvelle_discussion($id_client,$id_bailleur,$message_bailleur){
    $sql = "INSERT INTO messages_bailleur (id_client, id_bailleur, message_bailleur, date_message_bailleur, heur_message_bailleur) VALUES (:id_client, :id_bailleur, :message_bailleur, :date_message_bailleur, :heur_message_bailleur)";
    $stmt = $this->pdo->prepare($sql);
  return  $stmt->execute([
        'id_client' => $id_client,
        'id_bailleur' => $id_bailleur,
        'message_bailleur' => $message_bailleur,
        'date_message_bailleur' => date('Y-m-d'),
        'heur_message_bailleur' => date('H:i:s')
    ]);
   
}

public function get_messages_client($id_client) {
    $sql = "
        SELECT m1.*, b.raison_social
        FROM messages_bailleur m1
        INNER JOIN bailleur b ON m1.id_bailleur = b.id_bailleur
        INNER JOIN (
            SELECT id_bailleur, MAX(CONCAT(date_message_bailleur, ' ', heur_message_bailleur)) AS max_datetime
            FROM messages_bailleur
            WHERE id_client = :id_client
            GROUP BY id_bailleur
        ) m2 ON m1.id_bailleur = m2.id_bailleur 
           AND CONCAT(m1.date_message_bailleur, ' ', m1.heur_message_bailleur) = m2.max_datetime
        WHERE m1.id_client = :id_client
        ORDER BY m1.date_message_bailleur DESC, m1.heur_message_bailleur DESC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_client' => $id_client]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function nouveau_Message($id_client, $id_bailleur, $messages_client){
    $sql = "INSERT INTO messages_client (id_client, id_bailleur, message_client,date_message_client,heur_message_client) VALUES (:id_client, :id_bailleur,:message_client,:date_message_client,:heur_message_client)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        'id_client' => $id_client,
        'id_bailleur' => $id_bailleur,
            'message_client' => $messages_client,
        'date_message_client' => date('Y-m-d'),
        'heur_message_client' => date('H:i:s')
    
    ]);
    
}


public function getProprieteClients($id_client) {
    $sql = "SELECT a.*, p.*,a.id_bailleur as id_bail,
                   c.nom as nom_client, c.prenom as pr_client,
                   c.telephone as telephone_client, c.email as email_client
            FROM achat a
            INNER JOIN propriete p ON p.id_propiete = a.id_propriete
            INNER JOIN client c ON c.id_client = a.id_client
            WHERE a.id_client = :id_client
            ORDER BY a.date_achat DESC
            LIMIT 1"; // 👈 récupérer le plus récent seulement

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_client' => $id_client]);
    $row = $stmt->fetch();

    if ($row) {
        return [
            'achat' => new Achat($row['id_bail'], $row['id_propriete'], $row['id_client'], $row['id_agent'], $row['date_achat']),
            'nom_client' => $row['nom_client'],
            'prenom_client' => $row['pr_client'],
            'email_client' => $row['email_client'],
            'telephone_client' => $row['telephone_client'],
            'id_client'=> $row['id_client'],
            'id_bailleur'=> $row['id_bail'],
            'id_propriete'=> $row['id_propriete'],
            'propriete' => new Propriete($row['id_type'], $row['etat'], $row['opt'], $row['situation_geo'], $row['prix'], $row['image1'], $row['image2'], $row['image3'], $row['descriptions'], $row['id_bailleur'], $row['date_ajout'])
        ];
    }

    return null; // Aucun achat trouvé
}




public function get_moyen_paiement(){
    $sql = "SELECT * FROM moyen_paiement";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}




}
