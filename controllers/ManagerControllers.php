<?php

namespace controllers;

use controllers\Controllers;
use model\Manager;
use model\ManagerBDD;
use model\AgentBDD;
use model\BailleurBDD;
use model\clientBDD;
use model\ProprieteBDD;
use model\ContratBDD;
use model\PaiementBDD;

class ManagerControllers extends Controllers
{
    // Voir une propriété (détail)
    public function voirPropriete()
    {
        $this->requireManagerAuth();
        $id = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
        if (!$id) {
            $this->render('error/404');
            return;
        }
        $proprieteBDD = new \model\ProprieteBDD();
        $proprietes = $proprieteBDD->getProprieteById($id);
        if (!$proprietes || count($proprietes) === 0) {
            $this->render('error/404');
            return;
        }
        $this->render('manager/propriete/detail', ['proprietes' => $proprietes]);
    }

    // Ajouter une propriété (formulaire + traitement)
    public function ajouterPropriete()
    {
        $this->requireManagerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer et valider les champs du formulaire
            $data = [
                'id_type' => $_POST['id_type'] ?? null,
                'etat' => $_POST['etat'] ?? '',
                'opt' => $_POST['opt'] ?? '',
                'situation_geo' => $_POST['adresse'] ?? '',
                'prix' => $_POST['prix'] ?? 0,
                'image1' => $_POST['image1'] ?? '',
                'image2' => $_POST['image2'] ?? '',
                'image3' => $_POST['image3'] ?? '',
                'descriptions' => $_POST['description'] ?? '',
                'id_bailleur' => $_POST['id_bailleur'] ?? null,
                'date_ajout' => date('Y-m-d'),
            ];
            $propriete = new \model\Propriete(
                0, // id auto-incrémenté
                (int)$data['id_type'],
                $data['etat'],
                $data['opt'],
                $data['situation_geo'],
                (float)$data['prix'],
                $data['image1'],
                $data['image2'],
                $data['image3'],
                $data['descriptions'],
                $data['id_bailleur'],
                $data['date_ajout']
            );
            $proprieteBDD = new \model\ProprieteBDD();
            if ($proprieteBDD->insertPropriete($propriete)) {
                $_SESSION['success'] = "Propriété ajoutée avec succès.";
                header('Location: /manager/propriete');
                exit;
            } else {
                $error = "Erreur lors de l'ajout de la propriété.";
                $this->render('manager/propriete/ajouter', ['error' => $error]);
                return;
            }
        }
        $this->render('manager/propriete/ajouter');
    }

    // Editer une propriété (formulaire + traitement)
    public function editerPropriete()
    {
        $this->requireManagerAuth();
        $id = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
        $proprieteBDD = new \model\ProprieteBDD();
        if (!$id) {
            $this->render('error/404');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'] ?? $id,
                'id_type' => $_POST['id_type'] ?? null,
                'etat' => $_POST['etat'] ?? '',
                'opt' => $_POST['opt'] ?? '',
                'situation_geo' => $_POST['adresse'] ?? '',
                'prix' => $_POST['prix'] ?? 0,
                'image1' => $_POST['image1'] ?? '',
                'image2' => $_POST['image2'] ?? '',
                'image3' => $_POST['image3'] ?? '',
                'descriptions' => $_POST['description'] ?? '',
                'id_bailleur' => $_POST['id_bailleur'] ?? null,
                'date_ajout' => $_POST['date_ajout'] ?? date('Y-m-d'),
            ];
            $propriete = new \model\Propriete(
                (int)$data['id'],
                (int)$data['id_type'],
                $data['etat'],
                $data['opt'],
                $data['situation_geo'],
                (float)$data['prix'],
                $data['image1'],
                $data['image2'],
                $data['image3'],
                $data['descriptions'],
                $data['id_bailleur'],
                $data['date_ajout']
            );
            if ($proprieteBDD->UpdateProprieteById($data['id'], $propriete)) {
                $_SESSION['success'] = "Propriété modifiée avec succès.";
                header('Location: /manager/propriete');
                exit;
            } else {
                $error = "Erreur lors de la modification de la propriété.";
                $proprietes = $proprieteBDD->getProprieteById($data['id']);
                $this->render('manager/propriete/editer', ['error' => $error, 'proprietes' => $proprietes]);
                return;
            }
        }
        $proprietes = $proprieteBDD->getProprieteById($id);
        $this->render('manager/propriete/editer', ['proprietes' => $proprietes]);
    }

    // Supprimer une propriété
    public function supprimerPropriete()
    {
        $this->requireManagerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $proprieteBDD = new \model\ProprieteBDD();
                $deleted = $proprieteBDD->deletePropriete($id);
                if ($deleted) {
                    $_SESSION['success'] = "Propriété supprimée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de la propriété.";
                }
                header('Location: /manager/proprietes');
                exit;
            }
        }
        $this->render('error/404');
    }


    private $managerBDD,$agentBDD,$bailleurBDD,$clientBDD,$proprieteBDD,$contratBDD,$paiementBDD;

    public function __construct()
    {
        $this->managerBDD = new ManagerBDD();
        $this->bailleurBDD = new BailleurBDD();
        $this->clientBDD = new clientBDD();
        $this->proprieteBDD = new ProprieteBDD();
        $this->contratBDD = new ContratBDD();
        $this->paiementBDD = new PaiementBDD();
        $this->agentBDD = new AgentBDD();
    }


    // Ajouter un manager via POST
    public function addManager()
    {
        if (isset($_SESSION['id_manager'])) {
            // Si déjà connecté, rediriger vers tableau de bord
            $this->render("manager/dash");
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
    public function loginManager()
    {
        if (isset($_SESSION['id_manager'])) {
            // Si déjà connecté, rediriger vers tableau de bord
            $this->render("manager/dash");
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

                $this->render('manager/dash');
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
    public function logoutManager()
    {
        unset($_SESSION['id_manager']);
        $this->render('manager/auth/connexion', ['msg' => "Vous avez été déconnecté avec succès."]);
        exit;
    }

    // Récupérer manager par ID via GET
    public function getManagerById($id)
    {
        $managers = $this->managerBDD->getManagerById((int)$id);
        if (count($managers) > 0) {
            $manager = $managers[0]['objet'];
            $this->render('manager/profile/vue', ['manager' => $manager]);
        } else {
            $this->render('error/404');
        }
    }

    // Supprimer un client via POST
    public function supprimerClient()
    {
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
            $this->render('manager/client/liste');
            exit;
        }
        $this->render('error/404');
    }

    // Supprimer un bailleur via POST
    public function supprimerBailleur()
    {
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
            $this->render('manager/bailleur/liste');
            exit;
        }
        $this->render('error/404');
    }

    // Supprimer un agent via POST
    public function supprimerAgent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_agent = intval($_POST['id'] ?? 0);
            if ($id_agent > 0) {
                if ($this->managerBDD->supprimerAgent($id_agent)) {
                    $_SESSION['success'] = "Agent supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de l'agent.";
                }
            } else {
                $_SESSION['error'] = "ID agent invalide.";
            }
            header('Location: /manager/agents');
            exit;
        }
        $this->render('error/404');
    }

    // Ajouter un agent via POST
    public function ajouterAgent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
            $password = htmlspecialchars(trim($_POST['password'] ?? ''));
            $confirmPassword = htmlspecialchars(trim($_POST['password_confirm'] ?? ''));

            if (!$nom || !$prenom || !$username || !$telephone || !$password || !$confirmPassword) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                $this->render('manager/agent/ajouter', ['error' => $_SESSION['error']]);
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                $this->render('manager/agent/ajouter', ['error' => $_SESSION['error']]);
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $agent = new \model\Agent($nom, $prenom, $username, $telephone, $hashedPassword);

            if ($this->managerBDD->addAgent($agent)) {
                $_SESSION['success'] = "Agent ajouté avec succès.";
                header('Location: /manager/agents');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'agent.";
                $this->render('manager/agent/ajouter', ['error' => $_SESSION['error']]);
                exit;
            }
        } else {
            $this->render('manager/agent/ajouter');
        }
    }

    // Lister les propriétés avec pagination
    public function listProprietes()
    {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $proprietes = $this->proprieteBDD->getAlldataforpropriete($limit, $offset);
        $total = $this->managerBDD->countProprietes();
        $totalPages = ceil($total / $limit);
        $this->render('manager/propriete/liste', [
            'proprietes' => $proprietes,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Dashboard/statistiques manager
    public function dashboard()
    {
        $this->requireManagerAuth();
        $nb_clients = $this->managerBDD->countClients();
        $nb_bailleurs = $this->managerBDD->countBailleurs();
        $nb_agents = $this->managerBDD->countAgents();
        $nb_proprietes = $this->managerBDD->countProprietes();
        $nb_paiements = $this->managerBDD->countPaiements();
        $nb_users = $nb_agents + $nb_bailleurs + $nb_clients;
        $this->render('manager/dash', [
            'nb_clients' => $nb_clients,
            'nb_bailleurs' => $nb_bailleurs,
            'nb_agents' => $nb_agents,
            'nb_proprietes' => $nb_proprietes,
            'nb_users' => $nb_users,
            'nb_paiements' => $nb_paiements
        ]);
    }

    // Sécurisation accès manager
    private function requireManagerAuth()
    {
        if (empty($_SESSION['id_manager'])) {
            header('Location: /manager');
            exit;
        }
    }

    // Lister tous les clients
    public function listClients()
    {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $clients = $this->clientBDD->getAllClients($limit, $offset);
        $total = $this->managerBDD->countClients();
        $totalPages = ceil($total / $limit);
        $this->render('manager/client/liste', [
            'clients' => $clients,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Lister tous les bailleurs
    public function listBailleurs()
    {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $bailleurs = $this->bailleurBDD->getAllBailleurs($limit, $offset);
        $total = $this->managerBDD->countBailleurs();
        $totalPages = ceil($total / $limit);
        $this->render('manager/bailleur/liste', [
            'bailleurs' => $bailleurs,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Lister tous les agents
    public function listAgents()
    {
        $this->requireManagerAuth();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $agents = $this->agentBDD->getAllAgents($limit, $offset);
        $total = $this->managerBDD->countAgents();
        $totalPages = ceil($total / $limit);
        $this->render('manager/agent/liste', [
            'agents' => $agents,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // Voir/éditer son propre profil
    public function Profile()
    {
        $this->requireManagerAuth();
        $id = $_SESSION['id_manager'];
        $managers = $this->managerBDD->getManagerById($id);
        if (count($managers) > 0) {
            $manager = $managers[0]['objet'];
            $this->render('manager/profile', ['manager' => $manager]);
        } else {
            $this->render('error/404');
        }
    }

    // Modifier son profil manager
    public function updateProfile()
    {
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
    public function listContrats()
    {
        $this->requireManagerAuth();
        $contratBDD = new \model\ContratBDD();
        $contrats = $contratBDD->getAllContrats();
        $this->render('manager/contrats', ['contrats' => $contrats]);
    }

    // Lister les paiements
    public function listPaiements()
    {
        $this->requireManagerAuth();
        $paiementBDD = new \model\PaiementBDD();
        $paiements = $paiementBDD->getAllPaiements();
        $this->render('manager/paiement/liste', ['paiements' => $paiements]);
    }
    // Affecter ou réaffecter un client à un agent
    public function affecterClientAgent()
    {
        $this->requireManagerAuth();
        $clientId = isset($_GET['client_id']) ? (int)$_GET['client_id'] : 0;
        $agents = $this->managerBDD->getAllAgents();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)($_POST['client_id'] ?? 0);
            $agentId = (int)($_POST['agent_id'] ?? 0);
            if ($clientId > 0 && $agentId > 0) {
                if ($this->managerBDD->affecterClientAAgent($clientId, $agentId)) {
                    $_SESSION['success'] = "Client affecté à l'agent avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'affectation du client à l'agent.";
                }
                header('Location: /manager/clients');
                exit;
            } else {
                $_SESSION['error'] = "Client ou agent invalide.";
            }
        }
        // Récupérer le client à affecter si besoin pour affichage
        $client = null;
        if ($clientId > 0) {
            $client = $this->managerBDD->getClientById($clientId);
        }
        $this->render('manager/client/affecter', [
            'client' => $client,
            'agents' => $agents
        ]);
    }
    // Ajouter un bailleur via POST
    /* public function ajouterBailleur()
    {
        $this->requireManagerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
            if (!$nom || !$prenom || !$email || !$telephone) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                $this->render('manager/bailleur/ajouter', ['error' => $_SESSION['error']]);
                exit;
            }
            $bailleur = new \model\Bailleur($nom, $prenom, $email, $telephone);
            if ($this->managerBDD->addBailleur($bailleur)) {
                $_SESSION['success'] = "Bailleur ajouté avec succès.";
                $this->render('manager/bailleur/liste', ['success' => $_SESSION['success']]);
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du bailleur.";
                $this->render('manager/bailleur/ajouter', ['error' => $_SESSION['error']]);
                exit;
            }
        } else {
            $this->render('manager/bailleur/ajouter');
        }
    }*/

    // Éditer un bailleur via POST
    /*public function editerBailleur()
    {
        $this->requireManagerAuth();
        $id = isset($_GET['id_bailleur']) ? (int)$_GET['id_bailleur'] : (int)($_POST['id_bailleur'] ?? 0);
        $bailleurs = $this->managerBDD->getBailleurById($id);
        if (count($bailleurs) === 0) {
            $this->render('error/404');
            exit;
        }
        $bailleur = $bailleurs[0]['objet'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
            $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
            if (!$nom || !$prenom || !$email || !$telephone) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                $this->render('manager/bailleur/editer', ['bailleur' => $bailleur, 'error' => $_SESSION['error']]);
                exit;
            }
            $bailleur->setNom($nom);
            $bailleur->setPrenom($prenom);
            $bailleur->setEmail($email);
            $bailleur->setTelephone($telephone);
            if ($this->managerBDD->updateBailleur($id, $bailleur)) {
                $_SESSION['success'] = "Bailleur modifié avec succès.";
                $this->render('manager/bailleur/liste', ['success' => $_SESSION['success']]);
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la modification du bailleur.";
                $this->render('manager/bailleur/editer', ['bailleur' => $bailleur, 'error' => $_SESSION['error']]);
                exit;
            }
        } else {
            $this->render('manager/bailleur/editer', ['bailleur' => $bailleur]);
        }
    }*/

    // Voir un bailleur (GET)
    /* public function voirBailleur()
    {
        $this->requireManagerAuth();
        $id = isset($_GET['id_bailleur']) ? (int)$_GET['id_bailleur'] : 0;
        $bailleurs = $this->managerBDD->getBailleurById($id);
        if (count($bailleurs) === 0) {
            $this->render('error/404');
            exit;
        }
        $bailleur = $bailleurs[0]['objet'];
        $this->render('manager/bailleur/voir', ['bailleur' => $bailleur]);
    }*/
}
