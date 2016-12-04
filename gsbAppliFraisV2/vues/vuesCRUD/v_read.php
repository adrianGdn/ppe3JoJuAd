<?php
/**
 * Created by PhpStorm.
 * User: Adrian Gandon
 * Date: 04/12/2016
 * Time: 18:07
 */
include("vues/v_adminCRUD.php"); ?>
<!doctype html>
<html>
<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Les frais forfaitisé</legend>
        </div>
        <form method="post" action="index.php?uc=admin&action=getLesFraitForfait">
        <p>
            <label>Les données :</label><br/>
            <label>ID : <?php
                $leTab = $pdo->getFraisForfait(); // Le tableau qui est censé contenir touts frais forfait
                /*echo $leTab[0];
                echo $leTab[1];
                echo $leTab[2];
                echo "<br/>";*/
                echo "<pre>"; // Mise en forme du "var_dump"
                var_dump($leTab);
                echo "</pre>";
                ?></label><br/>
            <label>Libelle :</label><br/>
            <label>Montant :</label><br/>

        </p>
    </div>
</div

<?php

echo 'testicule';

?>