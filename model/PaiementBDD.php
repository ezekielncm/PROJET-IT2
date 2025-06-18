<?php
namespace model;
use config\Config;
use PDO;

class PaiementBDD {
    private $pdo;
    public function __construct() {
        $this->pdo = Config::getpdo()->getconnexion();
    }

    /**
     * Récupère tous les paiements (avec jointures pour enrichir si besoin)
     */
    public function getAllPaiements($limit = 50, $offset = 0) {
        $stmt = $this->pdo->prepare("SELECT * FROM paiement LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $paiements = [];
        foreach ($data as $row) {
            $paiements[] = $row;
        }
        return $paiements;
    }
}
