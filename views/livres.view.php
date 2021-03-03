<?php 
ob_start();

if (!empty($_SESSION['alert'])) { ?>

    <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
        <?= $_SESSION['alert']['message'] ?>
    </div> 

<?php
// Supprimer variable de session (effacer alert)
unset($_SESSION['alert']);
} ?>


<table class="table text-center mt-5">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions</th>
    </tr>

    <?php   

    for($i = 0; $i < count($livres); $i++) { ?>

    <tr>
        <td class="align-middle"><img src="public/images/<?= $livres[$i]->getImage() ?>" width="70px;"></td>
        <td class="align-middle"><a href="<?= URL ?>livres/l/<?= $livres[$i]->getId() ?>"><?= $livres[$i]->getTitre() ?></a></td>
        <td class="align-middle"><?= $livres[$i]->getNbPages() ?></td>
        <td class="align-middle"><a href="<?= URL ?>livres/m/<?= $livres[$i]->getId() ?>" class="btn btn-warning">Modifier</a></td>
        
        <td class="align-middle">
            <form action="<?= URL ?>livres/s/<?= $livres[$i]->getId() ?>" method="POST" onSubmit="return confirm('Voulez-vous vraiment supprimer ce livre')">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </td>

    </tr>
    <?php } ?>

</table>

<a href="<?= URL ?>livres/a" class="btn btn-success d-block mt-5">Ajouter</a>



<?php 
$titre = "Liste des livres";
$content = ob_get_clean();

require 'template.view.php'; 
?>