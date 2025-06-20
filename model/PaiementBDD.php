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
        $sql = "SELECT p.*, c.nom AS client_nom, c.prenom AS client_prenom, m.libelle AS moyen_paiement
                FROM paiement p
                LEFT JOIN client c ON p.id_client = c.id_client
                LEFT JOIN moyen_paiement m ON p.id_moyen_paiement = m.id_moyen_paiement
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $paiements = [];
        foreach ($data as $row) {
            $paiements[] = [
                'id' => $row['id_paiement'],
                'objet' => new Paiement(
                    $row['id_client'],
                    $row['id_agent'],
                    $row['id_propriete'],
                    $row['id_paiement'],
                    $row['id_bailleur'],
                    $row['montant'],
                    $row['date_paiement'],
                    
                ),
                'client_nom' => $row['client_nom'] . ' ' . $row['client_prenom'],
                'moyen_paiement' => $row['moyen_paiement']
            ];
        }
        return $paiements;
    }
}
