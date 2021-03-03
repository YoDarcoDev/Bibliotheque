<?php 
require_once 'Model.class.php';
require_once 'Livre.class.php';


class LivreManager extends Model
{
    private $livres; // TABLEAU DE LIVRES
    
    
    /**
     * Ajoute un livre dans le tableau de livres
     *
     * @param  object $livre
     * @return void
     */
    public function ajoutLivre(Livre $livre) {
        $this->livres[] = $livre;
    }

    
    
    /**
     * Récupère tous les livres du tableau livres
     *
     * @return array $livres
     */
    public function getLivres()
    {
        return $this->livres;
    }

    
    
    /**
     * Connexion à la BD, requete BD, récupère un tableau de livres
     * Transforme le tableau en objet et les ajoute dans le tableau
     * 
     * @return void
     */
    public function chargementLivres()
    {
        // RECUPERE UN TBALEAU ASSOCIATIF
        $req = $this->getBdd()->prepare("SELECT * FROM livres");
        $req-> execute();
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);   // SUPPRIME LES DOUBLONS
        $req->closeCursor();

        // CREER DES OBJETS DE TYPE LIVRE A PARTIR DE NOTRE TABLEAU ASSOCIATIF
        foreach ($mesLivres as $livre) {
            $l = new Livre($livre['id'], $livre['titre'], $livre['nbPages'], $livre['image']);
            $this->ajoutLivre($l);
        }
    }

    

    /**
     * Récupère livre en fonction de son id dans le tableau livres
     *
     * @param int $id
     * @return object $livres[$i]
     */
    public function getLivreById($id) {

        for ($i = 0; $i < count($this->livres); $i++) {
            
            if($this->livres[$i]->getId() === $id) {
                return $this->livres[$i];
            }
        }
        throw new Exception("Le livre n'existe pas");
    }


    
    
    /**
     * Ajoute un livre en BD 
     * Crée un objet Livre et l'ajoute dans la BD
     *
     * @param  string $titre
     * @param  int $nbPages
     * @param  string $image
     * @return void
     */
    public function ajoutLivreBD($titre, $nbPages, $image) {

        $req = "INSERT INTO livres (titre, nbPages, image) VALUES (:titre, :nbPages, :image)";
        $stmt = $this->getBdd()->prepare($req);

        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);

        $resultat = $stmt->execute();

        $stmt->closeCursor();

        // SI RESULTAT > 0, ON RECUPÈRE LE DERNIER ID, TITRE, NBPAGES, IMAGE ET ON LES INSERT DANS NOTRE TABLEAU
        if ($resultat > 0) {
            $livre = new Livre($this->getBdd()->lastInsertId(), $titre, $nbPages, $image);
            $this->ajoutLivre($livre);
        }
    }
    


    
    /**
     * Supprime un livre dans la BD en fonction de sn id
     *
     * @param  int $id
     * @return void
     */
    public function suppressionLivreBD($id) {

        $req = "DELETE FROM livres WHERE id = :idLivre";    // (idLivre => variable temporaire)
        $stmt = $this->getBdd()->prepare($req);

        $stmt->bindValue(":idLivre", $id, PDO::PARAM_INT);                  //  Lie variable temporaire à variable passée en paramètre de fonction

        $resultat = $stmt->execute();
        $stmt->closeCursor();

        
        // Supprime le livre dans le tableau livres
        if ($resultat > 0) {

            $livreASupprimer = $this->getLivreById($id);
            unset($livreASupprimer);
        }        
    }



    public function modificationLivreBD($id, $titre, $nbPages, $image) {

        $req = "UPDATE livres set titre = :titre, nbPages = :nbPages, image = :image WHERE id = :id";
        $stmt = $this->getBdd()->prepare($req);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);

        $resultat = $stmt->execute();
        $stmt->closeCursor();

        // Modifie chaque livre
        if ($resultat > 0) {

            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setNbPages($nbPages);
            $this->getLivreById($id)->setImage($image);
        }
    }
}