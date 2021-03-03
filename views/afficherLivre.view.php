<?php 
ob_start(); 
?> 

<div class="row">
    <div class="col-6 mt-5 d-flex justify-content-center">
        <img src="<?= URL ?>/public/images/<?= $livre->getImage()?>">
    </div>
    <div class="col-6 mt-5 d-flex flex-column align-items-center">
        <h3>Titre : <?= $livre->getTitre()?></h3>
        <p>Nombre de Pages : <?= $livre->getNbPages()?></p>
    </div>
</div>


<?php 
$titre = $livre->getTitre();
$content = ob_get_clean();

require 'template.view.php'; 
?>
