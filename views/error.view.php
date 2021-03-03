<?php
ob_start(); ?> 

<?= $msgErreur ?>

<?php 
$titre = "Erreur 404";
$content = ob_get_clean();

require 'template.view.php'; 
?>
