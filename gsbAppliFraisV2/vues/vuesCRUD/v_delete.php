<?php
include("vues/v_adminCRUD.php");
?>
<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Mettre à jour un frais forfaitisé</legend>
        </div>
        <form method="post" action="index.php?uc=admin&action=deleteLesFraisForfait">

            <p>
                <label>Entrer l'ID du frais à supprimer</label><br />
                <label>ID : </label><input type="text" name="ID" id="id" placeholder="Ex : ABC" maxlength="3" /><br />

            </p>

            <div class="form-horizontal">
                <input class="btn btn-primary" id="ok" type="submit" value="Valider"/>
            </div>

        </form>
    </div>
</div>