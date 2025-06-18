<?php
namespace controllers;

use controllers\Controllers;
use model\Manager;
use model\ManagerBDD;

class ManagerControllers extends Controllers {
    private $managerBDD;

    public function __construct() {
        $this->managerBDD = new ManagerBDD();
    }

    // Ajouter un manager via POST
    public function addManager() {
        if (isset($_SESSION['id_manager'])) {
            // Si déjà connecté, rediriger vers tableau de bord
            $this->render("manager/accueil");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $password = htmlspecialchars(trim($_POST['password'] ?? ''));
            $confirmPassword = htmlspecialchars(trim($_POST['password_confirm'] ?? ''));

            if (!$nom || !$prenom || !$email || !$password || !$confirmPassword) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                $this->render('manager/auth/inscription', ['error' => $_SESSION['error']]);
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                $this->render('manager/auth/inscription', ['error' => $_SESSION['error']]);
                exit;
            }

            // Hasher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $manager = new Manager($nom, $prenom, $email, $hashedPassword);

            if ($this->managerBDD->addManager($manager)) {
                $_SESSION['success'] = "Manager ajouté avec succès. Vous pouvez maintenant vous connecter.";
                $this->render('manager/auth/connexion', ['success' => $_SESSION['success']]);
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du manager.";
                $this->render('manager/auth/inscription', ['error' => $_SESSION['error']]);
                exit;
            }
        } else {
            // Afficher formulaire d'inscription
            $this->render('manager/auth/inscription');
        }
    }

    // Connexion manager via POST
    public function loginManager() {
        if (isset($_SESSION['id_manager'])) {
            // Si déjà connecté, rediriger vers tableau de bord
            $this->render("manager/accueil");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $password = htmlspecialchars(trim($_POST['password'] ?? ''));

            if (!$email || !$password) {
                $_SESSION['error'] = "Email et mot de passe requis.";
                $this->render('manager/auth/connexion', ['error' => $_SESSION['error']]);
                exit;
            }

            $managers = $this->managerBDD->getManagerByEmail($email);
            if (count($managers) === 0) {
                $_SESSION['error'] = "Email incorrect.";
                $this->render('manager/auth/connexion', ['error' => $_SESSION['error']]);
                exit;
            }

            $manager = $managers[0]['objet'];
            if (password_verify($password, $manager->getPassword())) {
                $_SESSION['id_manager'] = $managers[0]['id'];
                $_SESSION['nom_manager'] = $manager->getNom();
                $_SESSION['prenom_manager'] = $manager->getPrenom();
                $_SESSION['email_manager'] = $manager->getEmail();

                $this->render('manager/accueil');
                exit;
            } else {
                $_SESSION['error'] = "Mot de passe incorrect.";
                $this->render('manager/auth/connexion', ['error' => $_SESSION['error']]);
                exit;
            }
        } else {
            // Afficher formulaire de connexion
            $this->render('manager/auth/connexion');
        }
    }

    // Déconnexion manager
    public function logoutManager() {
        unset($_SESSION['id_manager']);
        $this->render('manager/auth/connexion', ['msg' => "Vous avez été déconnecté avec succès."]);
        exit;
    }

    // Récupérer manager par ID via GET
    public function getManagerById($id) {
        $managers = $this->managerBDD->getManagerById((int)$id);
        if (count($managers) > 0) {
            $manager = $managers[0]['objet'];
            $this->render('manager/profile/vue', ['manager' => $manager]);
        } else {
            $this->render('error/404');
        }
    }

    // Supprimer un client via POST
    public function deleteClient() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                if ($this->managerBDD->supprimerClient($id)) {
                    $_SESSION['success'] = "Client supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression du client.";
                }
            } else {
                $_SESSION['error'] = "ID client invalide.";
            }
            $this->render('manager/client/list');
            exit;
        }
        $this->render('error/404');
    }

    // Supprimer un bailleur via POST
    public function deleteBailleur() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                if ($this->managerBDD->supprimerBailleur($id)) {
                    $_SESSION['success'] = "Bailleur supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression du bailleur.";
                }
            } else {
                $_SESSION['error'] = "ID bailleur invalide.";
            }
            $this->render('manager/bailleur/list');
            exit;
        }
        $this->render('error/404');
    }

    // Supprimer un agent via POST
    public function deleteAgent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0) {
                if ($this->managerBDD->supprimerAgent($id)) {
                    $_SESSION['success'] = "Agent supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de l'agent.";
                }
            } else {
                $_SESSION['error'] = "ID agent invalide.";
            }
            $this->render('manager/agent/list');
            exit;
        }
        $this->render('error/404');
    }

    // Ajouter un agent via POST
    public function addAgent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
            $password = htmlspecialchars(trim($_POST['password'] ?? ''));
            $confirmPassword = htmlspecialchars(trim($_POST['password_confirm'] ?? ''));

            if (!$nom || !$prenom || !$email || !$telephone || !$password || !$confirmPassword) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                $this->render('manager/agent/add', ['error' => $_SESSION['error']]);
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                $this->render('manager/agent/add', ['error' => $_SESSION['error']]);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $agent = new \model\Agent($nom, $prenom, $email, $telephone, $hashedPassword);

            if ($this->managerBDD->addAgent($agent)) {
                $_SESSION['success'] = "Agent ajouté avec succès.";
                $this->render('manager/agent/list', ['success' => $_SESSION['success']]);
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'agent.";
                $this->render('manager/agent/add', ['error' => $_SESSION['error']]);
                exit;
            }
        } else {
            $this->render('manager/agent/add');
        }
    }

    // Lister les propriétés avec pagination
    public function listProprietes() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $proprietes = $this->managerBDD->getProprietes($limit, $offset);
        $total = $this->managerBDD->countProprietes();
        $totalPages = ceil($total / $limit);

        $this->render('manager/propriete/liste', [
            'proprietes' => $proprietes,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
        // Dashboard/statistiques manager
    public function dashboard() {
        $this->requireManagerAuth();
        $nb_clients = $this->managerBDD->countClients();
        $nb_bailleurs = $this->managerBDD->countBailleurs();
        $nb_agents = $this->managerBDD->countAgents();
        $nb_proprietes = $this->managerBDD->countProprietes();
        $this->render('manager/accueil', [
            'nb_clients' => $nb_clients,
            'nb_bailleurs' => $nb_bailleurs,
            'nb_agents' => $nb_agents,
            'nb_proprietes' => $nb_proprietes
        ]);
    }

    // Sécurisation accès manager
    private function requireManagerAuth() {
        if (empty($_SESSION['id_manager'])) {
            header('Location: /manager');
            exit;
        }
    }

    // Lister tous les clients
    public function listClients() {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $clients = $this->managerBDD->getClients($limit, $offset);
        $total = $this->managerBDD->countClients();
        $totalPages = ceil($total / $limit);
        $this->render('manager/client/liste', [
            'clients' => $clients,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Lister tous les bailleurs
    public function listBailleurs() {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $bailleurs = $this->managerBDD->getBailleurs($limit, $offset);
        $total = $this->managerBDD->countBailleurs();
        $totalPages = ceil($total / $limit);
        $this->render('manager/bailleur/list', [
            'bailleurs' => $bailleurs,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Lister tous les agents
    public function listAgents() {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $agents = $this->managerBDD->getAgents($limit, $offset);
        $total = $this->managerBDD->countAgents();
        $totalPages = ceil($total / $limit);
        $this->render('manager/agent/list', [
            'agents' => $agents,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Voir/éditer son propre profil
    public function monProfil() {
        $this->requireManagerAuth();
        $id = $_SESSION['id_manager'];
        $managers = $this->managerBDD->getManagerById($id);
        if (count($managers) > 0) {
            $manager = $managers[0]['objet'];
            $this->render('manager/profile/vue', ['manager' => $manager]);
        } else {
            $this->render('error/404');
        }
    }

    // Modifier son profil manager
    public function updateProfil() {
        $this->requireManagerAuth();
        $id = $_SESSION['id_manager'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
            $manager = $this->managerBDD->getManagerById($id)[0]['objet'];
            $manager->setNom($nom);
            $manager->setPrenom($prenom);
            $manager->setEmail($email);
            if ($password) $manager->setPassword($password);
            // À adapter selon la méthode d'update en BDD
            // $this->managerBDD->updateManager($id, $manager);
            $_SESSION['success'] = "Profil mis à jour.";
            $this->render('manager/profile/vue', ['manager' => $manager]);
            exit;
        }
        $this->render('manager/profile/edit', ['manager' => $this->managerBDD->getManagerById($id)[0]['objet']]);
    }

    // Lister les contrats
    public function listContrats() {
        $this->requireManagerAuth();
        $contratBDD = new \model\ContratBDD();
        $contrats = $contratBDD->getAllContrats();
        $this->render('manager/contrat/list', ['contrats' => $contrats]);
    }

    // Lister les paiements
    public function listPaiements() {
        $this->requireManagerAuth();
        $paiementBDD = new \model\PaiementBDD();
        $paiements = $paiementBDD->getAllPaiements();
        $this->render('manager/paiement/list', ['paiements' => $paiements]);
    }
}
