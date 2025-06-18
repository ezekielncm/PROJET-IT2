<?php 
namespace model;
use config\Config;
use model\Manager;

class ManagerBDD extends Manager {
    private $pdo;
    public function __construct()
    {
        $this->pdo =Config::getpdo()->getconnexion();
    }
    
    public function addManager(Manager $manager) {
        $stmt = $this->pdo->prepare("INSERT INTO manager (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)");
        $stmt->bindValue(':nom', $manager->getNom());
        $stmt->bindValue(':prenom', $manager->getPrenom());
        $stmt->bindValue(':email', $manager->getEmail());
        $stmt->bindValue(':password', $manager->getPassword());
        return $stmt->execute();
    }

    public function getManagerByEmail(string $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM manager WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $managers = [];
        foreach ($data as $row) {
            $managers[] = [
                'id' => $row['id_manager'],
                'objet' => new Manager($row['nom'], $row['prenom'], $row['email'], $row['password']),
            ];
        }
        return $managers;
    }

    public function LoginManager(string $email, string $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM manager WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $managers = [];
        foreach ($data as $row) {
            $managers[] = [
                'id' => $row['id_manager'],
                'objet' => new Manager($row['nom'], $row['prenom'], $row['email'], $row['password']),
            ];
        }
        return $managers;
    }

    public function getManager($limit, $ofset) {
        $stmt = $this->pdo->prepare("SELECT * FROM manager LIMIT :limit OFFSET :ofset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':ofset', $ofset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $managers = [];
        foreach ($data as $row) {
            $managers[] = [
                'id' => $row['id_manager'],
                'objet' => new Manager($row['nom'], $row['prenom'], $row['email'], $row['password']),
            ];
        }
        return $managers;

    }

    public function getManagerById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM manager WHERE id_manager = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $managers = [];
        foreach ($data as $row) {
            $managers[] = [
                'id' => $row['id_manager'],
                'objet' => new Manager($row['nom'], $row['prenom'], $row['email'], $row['password']),
            ];
        }
        return $managers;
    }

    // Suppression client
    public function supprimerClient(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM client WHERE id_client = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Suppression bailleur
    public function supprimerBailleur(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM bailleur WHERE id_bailleur = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Suppression agent
    public function supprimerAgent(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM agent WHERE id_agent = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Suppression propriete
    public function supprimerPropriete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM propriete WHERE id_propiete = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Liste clients avec pagination
    public function getClients(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare("SELECT * FROM client LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $clients = [];
        foreach ($data as $row) {
            $clients[] = new \model\Client($row['nom'], $row['prenom'], $row['adresse'], $row['email'], $row['telephone'], $row['mot_de_passe'], $row['id_agent']);
        }
        return $clients;
    }

    // Liste bailleurs avec pagination
    public function getBailleurs(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare("SELECT * FROM bailleur LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $bailleurs = [];
        foreach ($data as $row) {
            $bailleurs[] = new \model\Bailleur($row['nom'], $row['prenom'], $row['raison_social'], $row['adresse'], $row['email'], $row['telephone'], $row['mot_de_passe']);
        }
        return $bailleurs;
    }

    // Liste agents avec pagination
    public function getAgents(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare("SELECT * FROM agent LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $agents = [];
        foreach ($data as $row) {
            $agents[] = new \model\Agent($row['nom'], $row['prenom'], $row['email'], $row['telephone'], $row['mot_de_passe']);
        }
        return $agents;
    }

    // Liste proprietes avec pagination
    public function getProprietes(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare("SELECT * FROM propriete LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $proprietes = [];
        foreach ($data as $row) {
            $proprietes[] = new \model\Propriete($row['id_type'], $row['etat'], $row['opt'], $row['situation_geo'], $row['prix'], $row['image1'], $row['image2'], $row['image3'], $row['descriptions'], $row['id_bailleur'], $row['date_ajout']);
        }
        return $proprietes;
    }

    // Compter clients
    public function countClients(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM client");
        return (int)$stmt->fetchColumn();
    }

    // Compter bailleurs
    public function countBailleurs(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM bailleur");
        return (int)$stmt->fetchColumn();
    }

    // Compter agents
    public function countAgents(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM agent");
        return (int)$stmt->fetchColumn();
    }

    // Compter proprietes
    public function countProprietes(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM propriete");
        return (int)$stmt->fetchColumn();
    }

    // Ajouter un agent
    public function addAgent(\model\Agent $agent): bool {
        $stmt = $this->pdo->prepare("INSERT INTO agent (nom, prenom, email, telephone, mot_de_passe) VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe)");
        $stmt->bindValue(':nom', $agent->getNom());
        $stmt->bindValue(':prenom', $agent->getPrenom());
        $stmt->bindValue(':telephone', $agent->getTelephone());
        $stmt->bindValue(':mot_de_passe', $agent->getPassword());
        return $stmt->execute();
    }

    // Modifier un agent
    public function updateAgent(int $id, \model\Agent $agent): bool {
        $stmt = $this->pdo->prepare("UPDATE agent SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, mot_de_passe = :mot_de_passe WHERE id_agent = :id");
        $stmt->bindValue(':nom', $agent->getNom());
        $stmt->bindValue(':prenom', $agent->getPrenom());
        $stmt->bindValue(':telephone', $agent->getTelephone());
        $stmt->bindValue(':mot_de_passe', $agent->getPassword());
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

}