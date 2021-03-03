<?php 
ob_start(); 
?> 


<form action="<?= URL ?>livres/av" method="POST" enctype="multipart/form-data">

    <div class="form-group mt-5">
        <label for="titre">Titre : </label>
        <input type="text" name="titre" id="titre" class="form-control" placeholder="Saisir le titre d'un livre">
    </div>
    <div class="form-group mt-5">
        <label for="nbPages">Nombre de Pages : </label>
        <input type="number" name="nbPages" id="nbPages" class="form-control" placeholder="Saisir le nombre de pages">
    </div>
    <div class="form-group mt-5">
        <label for="image">Image : </label>
        <input type="file" name="image" id="image" class="form-control-file">
    </div>

    <button type="submit" class="btn btn-primary">Valider</button>

</form>


<?php 
$titre = "Ajout d'un livre";
$content = ob_get_clean();

require 'template.view.php'; 
?>
