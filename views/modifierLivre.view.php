<?php 
ob_start(); 
?> 


<form action="<?= URL ?>livres/mv" method="POST" enctype="multipart/form-data">

    <div class="form-group mt-5">
        <label for="titre">Titre : </label>
        <input type="text" name="titre" id="titre" class="form-control" value="<?= $livre->getTitre() ?>">
    </div>

    <div class="form-group mt-5">
        <label for="nbPages">Nombre de Pages : </label>
        <input type="number" name="nbPages" id="nbPages" class="form-control" value="<?= $livre->getNbPages() ?>" >
    </div>

    <div class="row mt-5">
    
        <div class="col-6">
            <h3>Image : </h3>
            <img src="<?= URL ?>public/images/<?= $livre->getImage() ?>" class="w-50">
        </div>

        <div class="col-6 form-group d-flex flex-column align-items-start justify-content-center">
            <div>
                <label for="image">Changer l'image : </label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>
            <input type="hidden" name="identifiant" value="<?= $livre->getId() ?>">
            <button type="submit" class="mt-5 btn btn-primary">Valider</button>
        </div>
    </div>


</form>



<?php 
$titre = "Modification du livre : " . $livre->getTitre();
$content = ob_get_clean();

require 'template.view.php'; 
?>
