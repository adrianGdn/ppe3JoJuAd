<?php
include("vues/v_adminCRUD.php"); ?>
<!doctype html>
<html>
<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Les frais forfaitisés</legend>
        </div>
        <form method="post" action="index.php?uc=admin&action=getLesFraisForfait">

            <?php
            $reponse = $pdo->getFraisForfait();
            while ($donnees = $reponse->fetch())
            {
            ?>
            <p>
                <strong>ID :</strong> <?php echo $donnees['id']; ?><br />
                <strong>Libelle :</strong><?php echo $donnees['libelle']; ?><br />
                <strong>Montant :</strong><?php echo $donnees['montant']; ?> <br />
            </p>
            <?php
            }

            $reponse->closeCursor();

            ?>

    </div>
</div>