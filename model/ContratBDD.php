<?php
namespace model;
use config\Config;
use PDO;

class ContratBDD {
    private $pdo;
    public function __construct() {
        $this->pdo = Config::getpdo()->getconnexion();
    }

    /**
     * Récupère tous les contrats (avec jointures si besoin)
     */
    public function getAllContrats($limit = 50, $offset = 0) {
        $stmt = $this->pdo->prepare("SELECT * FROM contrat LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contrats = [];
        foreach ($data as $row) {
            $contrats[] = $row;
        }
        return $contrats;
    }
}
