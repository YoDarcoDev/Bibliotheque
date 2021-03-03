<?php // BUFFER QUI SE REMPLIT ET SE DEVERSE DANS $CONTENT

ob_start(); ?> 

<div class="container text-center mt-5">
    <h2>Bibliothèque pattern MVC </h2>
    <h2>CRUD et base de données MySQL </h2>
    <h2>POO </h2>
</div>
<?php 
$titre = "Accueil";
$content = ob_get_clean();

require 'template.view.php'; 
?>
