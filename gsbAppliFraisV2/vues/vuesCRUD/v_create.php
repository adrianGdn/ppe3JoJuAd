<?php
include("vues/v_adminCRUD.php");
?>
<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Créer un frais forfaitisé</legend>
        </div>
        <form method="post" action="index.php?uc=admin&action=ajoutFraisForfait">

            <p>
                <label>Entrer les données</label><br />
                <label>ID : </label><input type="text" name="ID" id="id" placeholder="Ex : ABC" maxlength="3" required /><br />
                <label>Libelle : </label><input type="text" name="libelle" id="libelle" placeholder="Ex : Nuit à l'hôtel" required/><br />
                <label>Montant : </label><input type="number" step="any" name="montant" id="montant" placeholder="Ex : 23,42" required/><br />
            </p>

            <div class="form-horizontal">
                <input class="btn btn-primary" id="ok" type="submit" value="Valider"/>
            </div>

        </form>
    </div>
</div>