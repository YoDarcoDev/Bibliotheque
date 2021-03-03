<?php
require_once "models/LivreManager.class.php";

class LivresController {
    
    private $livreManager;
    

    /**
     * Constructeur instancie directement un objet LivreManager
     *
     * @return void
     */
    public function __construct() {
        $this->livreManager = new LivreManager;
        $this->livreManager->chargementLivres();
    }
    

    /**
     * Affiche tous les livres 
     *
     * @return void
     */
    public function afficherLivres() {
        $livres = $this->livreManager->getLivres();
        require "views/livres.view.php";
    }


    
    /**
     * Affiche un livre en fonction de son id
     *
     * @param  int $id
     * @return void
     */
    public function afficherLivre($id) {
        $livre = $this->livreManager->getLivreById($id);
        require "views/afficherLivre.view.php";
    }


        
    /**
     * Affiche le formulaire d'ajout
     *
     * @return void
     */
    public function ajoutLivre() {
        require "views/ajoutLivre.view.php";
    }


    
    /**
     * Intègre l'image transferée dans le formulaire directement dans public/images
     * Enregistre l'image en BD, redirige sur la pages "livres"
     * 
     * @return void
     */
    public function ajoutLivreValidation() {

        $file = $_FILES['image'];
        
        // echo "<pre>";
        // print_r($_FILES);
        
        $repertoire = "public/images/";
        $nomImageAjoutee = $this->ajoutImage($file, $repertoire);
        $this->livreManager->ajoutLivreBD($_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);

        // AFFICHER ALERT 
        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Vous venez d'ajouter un nouveau livre"
        ];


        header('Location: ' . URL . 'livres');
    }


    
    /**
     * Supprime un livre en fonction de son id
     *
     * @param int $id
     */
    public function suppressionLivre($id) {

        // SUPPRIME IMAGE DU LIVRE DANS LE DOSSIER PUBLIC/IMAGES
        $monImage = $this->livreManager->getLivreById($id)->getImage();
        unlink("public/images/" . $monImage);

        // SUPPRIME EN BD 
        $this->livreManager->suppressionLivreBD($id);

        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Vous venez de supprimer un livre"
        ];

        header('Location: ' . URL . 'livres');
    }



    
    /**
     * Affiche la page de modification d'un livre en fonction de son id
     *
     * @param  int $id
     * @return void
     */
    public function modificationLivre($id) {

        $livre = $this->livreManager->getLivreById($id);
        require 'views/modifierLivre.view.php';
    }



    public function modificationLivreValidation() {

        $imageActuelle = $this->livreManager->getLivreById($_POST['identifiant'])->getImage();

        $file = $_FILES['image'];

        // CHANGER L'IMAGE 
        if ($file['size'] > 0) {

            // Supprime l'ancienne image dans le dossier images
            unlink("public/images/" . $imageActuelle); 

            // Ajoute la nouvelle image
            $repertoire = "public/images/";
            $nomImageAjoutee = $this->ajoutImage($file, $repertoire);
        }

        else {
            $nomImageAjoutee = $imageActuelle;
        }

        // Modification en BD 
        $this->livreManager->modificationLivreBD($_POST['identifiant'], $_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);

        $_SESSION['alert'] = [
            "type" => "success",
            "message" => "Vous venez de modifier un livre"
        ];

        header('Location: ' . URL . 'livres');
    }




    
    /**
     * Ajoute l'image dans le dossier public/images
     * Effectue tous les test liés à l'image
     * 
     * @param  mixed $file
     * @param  mixed $dir
     * @return $nomImage
     */
    private function ajoutImage($file, $dir) {

        // VERFIIE SI L'IMAGE TRANSFÉRÉE VIA LE FORM EXISTE ET SI ELLE CONTIENT UNE IMAGE
        if (!isset($file['name']) || empty($file['name'])) {
            throw new Exception("Vous devez ajouter une image");
        }

        // VERIFIE SI LE REPERTOIRE EXISTE
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $random = rand(0, 99999);
        $target_file = $dir . $random . "_" . $file['name'];

        // VERIFIE SI LE FICHIER EST UNE IMAGE
        if (!getimagesize($file["tmp_name"])) {
            throw new Exception("Le fichier n'est pas une image");
        }

        // VERIFIE EXTENSION DE L'IMAGE
        if ($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif") {
            throw new Exception("Le fichier n'est pas au bon format");
        }

        // VERIFIE SI LE FICHIER EXISTE DÉJÀ
        if (file_exists($target_file)) {
            throw new Exception("Le fichier existe déjà");
        }

        // VERIFIE
        if ($file['size'] > 500000) {
            throw new Exception("Le fichier est trop volumineux");
        }

        // VERIFIE SI L'IMAGE A ETE AJOUTÉ DIRECTEMENT DANS LE DOSSIER ("images")
        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            throw new Exception("L'ajout de l'image n'a pas fonctionné");
        }
        else {
            return ($random . "_" . $file['name']);
        }
    }
}