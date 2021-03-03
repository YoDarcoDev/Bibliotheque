<?php

session_start();

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));


require_once 'controllers/LivresController.controller.php';
$livreController = new LivresController;


try {

    if (empty($_GET['page'])) {
    
        require 'views/accueil.view.php';
    }
    
    else {
    
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        
        // echo "<pre>";
        // print_r($url);
    
        switch ($url[0]) {
            
            case "accueil" : require 'views/accueil.view.php';
            break;
    
            case "livres" : 
                // Si url[1] est vide
                if(empty($url[1])) {
                    $livreController->afficherLivres();
                }

                // Afficher livre
                elseif ($url[1] === "l") {
                    $livreController->afficherLivre($url[2]);
                }

                // Ajouter un livre
                elseif ($url[1] === "a") {
                    $livreController->ajoutLivre();
                }

                // Validation de l'ajout d'un livre
                elseif ($url[1] === "av") {
                    $livreController->ajoutLivreValidation();
                }

                // Modifier un livre
                elseif ($url[1] === "m") {
                    $livreController->modificationLivre($url[2]);
                }

                // Validation de la modification d'un livre (image et données)
                elseif ($url[1] === "mv") {
                    $livreController->modificationLivreValidation($url[2]);
                }

                // Supprimer un livre 
                elseif ($url[1] === "s") {
                    $livreController->suppressionLivre($url[2]);
                }

                else {
                    throw new Exception("La page demandée n'existe pas");
                }
            break;

            default : throw new Exception("La page demandée n'existe pas");
                     
        }
    }
}
catch(Exception $e) {
    $msgErreur = $e->getMessage();
    require 'views/error.view.php';
}







// EXPLODE => SEPARE A PARTIR DU /