<?php ob_start() ?>


<table class="table text-center mt-5">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/html.jpeg" alt="livre Html" width="70px;"></td>
        <td class="align-middle">Html & Css pour les nuls</td>
        <td class="align-middle">300</td>
        <td class="align-middle"><a href="" class="btn btn-warning">Modifier</a></td>
        <td class="align-middle"><a href="" class="btn btn-danger">Supprimer</a></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/javascript.jpg" alt="livre Html" width="70px;"></td>
        <td class="align-middle">Javascript et Jquery</td>
        <td class="align-middle">180</td>
        <td class="align-middle"><a href="" class="btn btn-warning">Modifier</a></td>
        <td class="align-middle"><a href="" class="btn btn-danger">Supprimer</a></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/react.jpg" alt="livre Html" width="70px;"></td>
        <td class="align-middle">Apprendre react</td>
        <td class="align-middle">220</td>
        <td class="align-middle"><a href="" class="btn btn-warning">Modifier</a></td>
        <td class="align-middle"><a href="" class="btn btn-danger">Supprimer</a></td>
    </tr>
    <tr>
        <td class="align-middle"><img src="public/images/uxdesign.jpg" alt="livre Html" width="70px;"></td>
        <td class="align-middle">Les bases de l'UX design</td>
        <td class="align-middle">170</td>
        <td class="align-middle"><a href="" class="btn btn-warning">Modifier</a></td>
        <td class="align-middle"><a href="" class="btn btn-danger">Supprimer</a></td>
    </tr>
</table>

<a href="" class="btn btn-success d-block mt-5">Ajouter</a>


<?php 
$titre = "Liste des livres";
$content = ob_get_clean();

require 'template.php'; 
?>