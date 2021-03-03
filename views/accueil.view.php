<?php // BUFFER QUI SE REMPLIT ET SE DEVERSE DANS $CONTENT

ob_start(); ?> 


<?php 
$titre = "Accueil";
$content = ob_get_clean();

require 'template.view.php'; 
?>
