<?php 
namespace routes;

use controllers\HomeControllers;

class Router {
    private array $routes = [
        '/' => ['controllers\HomeControllers', 'home'],
        '/index.php' => ['controllers\HomeControllers', 'home'],

        //public routes
        '/public/about' => ['controllers\HomeControllers', 'about'],
        '/public/contact' => ['controllers\HomeControllers', 'contact'],
        '/public/search' => ['controllers\HomeControllers', 'search'],
        '/public/search/result' => ['controllers\HomeControllers', 'searchResult'],

        //propriete routes
        '/propriete/liste' => ['controllers\HomeControllers', 'listes_proprietes_home'],
        '/propriete/detail' => ['controllers\HomeControllers', 'detail'],

        //bailleur routes
        '/bailleur' => ['controllers\BailleurControllers','login_bailleur'],
        '/bailleur/inscription' => ['controllers\BailleurControllers', 'register'],
        '/bailleur/logout' => ['controllers\BailleurControllers', 'logout'],
        '/bailleur/dashboard' => ['controllers\BailleurControllers', 'dashboard'],
        '/bailleur/propriete' => ['controllers\BailleurControllers', 'liste'],
        '/bailleur/contrats' => ['controllers\BailleurControllers', 'listContrats'],
        '/bailleur/paiements' => ['controllers\BailleurControllers', 'listPaiements'],
        '/bailleur/messages' => ['controllers\BailleurControllers', 'listMessages'],

        //client routes
        '/client' => ['controllers\ClientControllers', 'LoginClient'],
        '/client/inscription' => ['controllers\ClientControllers', 'register'],
        '/client/logout' => ['controllers\ClientControllers', 'logout'],
        '/client/dashboard' => ['controllers\ClientControllers', 'dashboard'],
        '/client/locations' => ['controllers\ClientControllers', 'listLocations'],
        '/client/paiements' => ['controllers\ClientControllers', 'listPaiements'],
        '/client/messages' => ['controllers\ClientControllers', 'listMessages'],

        //manager routes
        '/manager' => ['controllers\ManagerControllers', 'loginManager'],
        '/manager/inscription' => ['controllers\ManagerControllers', 'addManager'],
        '/manager/logout' => ['controllers\ManagerControllers', 'logoutManager'],
        '/manager/dashboard' => ['controllers\ManagerControllers', 'dashboard'],
        // Agents CRUD
        '/manager/agents' => ['controllers\ManagerControllers', 'listAgents'],
        '/manager/agent/ajouter' => ['controllers\ManagerControllers', 'ajouterAgent'],
        '/manager/agent/editer' => ['controllers\ManagerControllers', 'editerAgent'],
        '/manager/agent/voir' => ['controllers\ManagerControllers', 'voirAgent'],
        '/manager/agent/supprimer' => ['controllers\ManagerControllers', 'supprimerAgent'],
        // Clients CRUD
        '/manager/clients' => ['controllers\ManagerControllers', 'listClients'],
        '/manager/client/ajouter' => ['controllers\ManagerControllers', 'ajouterClient'],
        '/manager/client/editer' => ['controllers\ManagerControllers', 'editerClient'],
        '/manager/client/voir' => ['controllers\ManagerControllers', 'voirClient'],
        '/manager/client/supprimer' => ['controllers\ManagerControllers', 'supprimerClient'],
        // Bailleurs CRUD
        '/manager/bailleurs' => ['controllers\ManagerControllers', 'listBailleurs'],
        '/manager/bailleur/ajouter' => ['controllers\ManagerControllers', 'ajouterBailleur'],
        '/manager/bailleur/editer' => ['controllers\ManagerControllers', 'editerBailleur'],
        '/manager/bailleur/voir' => ['controllers\ManagerControllers', 'voirBailleur'],
        '/manager/bailleur/supprimer' => ['controllers\ManagerControllers', 'supprimerBailleur'],
        // Propriétés CRUD
        '/manager/proprietes' => ['controllers\ManagerControllers', 'listProprietes'],
        '/manager/propriete/ajouter' => ['controllers\ManagerControllers', 'ajouterPropriete'],
        '/manager/propriete/editer' => ['controllers\ManagerControllers', 'editerPropriete'],
        '/manager/propriete/voir' => ['controllers\ManagerControllers', 'voirPropriete'],
        '/manager/propriete/supprimer' => ['controllers\ManagerControllers', 'supprimerPropriete'],
        // Contrats, paiements, messages
        '/manager/contrats' => ['controllers\ManagerControllers', 'listContrats'],
        '/manager/paiements' => ['controllers\ManagerControllers', 'listPaiements'],
        '/manager/messages' => ['controllers\ManagerControllers', 'listMessages'],
        // Affectation client à agent
        '/manager/client/affecter' => ['controllers\ManagerControllers', 'affecterClientAgent'],
        // Profil manager
        '/manager/profile' => ['controllers\ManagerControllers', 'Profile'],
        '/manager/profile/edit' => ['controllers\ManagerControllers', 'updateProfile'],

        //agent routes
        '/agent' => ['controllers\AgentControllers', 'login_Agent'],
    ];

    public function register(string $path, callable|array $action): void {
        $this->routes[$path] = $action;
    }

    public function resolve(string $uri) {
        $path = explode("?", $uri)[0];
        $action = $this->routes[$path] ?? null;

        if (!$action) {
            $home = new HomeControllers();
            $home->error404();
            throw new \Exception("Route introuvable : $path");
        }

        if (is_callable($action)) {
            return $action();
        }

        if (is_array($action)) {
            list($classname, $method) = $action;

            if (class_exists($classname) && method_exists($classname, $method)) {
                $class = new $classname();
                return call_user_func_array([$class, $method], []);
            } else {
                throw new \Exception("Classe ou méthode introuvable : $classname::$method");
            }
        }

        throw new \Exception("Route introuvable ou mal définie : $path");
    }
}