<?php
/*if($_SESSION['typeActeur'] == 'Administrateur') {
    include("vues/v_sommaireAdmin.php");
}
else {
    include("vues/v_sommaire.php");
}*/
?>
<div class="col-md-6">
    <div class="content-box">
        <div class="panel-heading">
            <div class="panel-title"><h2></h2></div>
            </br></br>
            <legend>Ajouter un véhicule</legend>
        </div>
        <form method="post" action="index.php?uc=vehicule&action=creerVehicule">

            <p>
                <label>Entrer les données</label><br />
                <label>Libelle : </label><input type="text" name="libelle" id="libelle" placeholder="Ex : 306" required/><br />
                <label>Immatriculation : </label><input type="text" step="any" name="immatriculation" id="immatriculation" placeholder="Ex : 123AZ123" required/><br />
                <select id="puissanceVehicule" name="puissanceVehicule">
                    <option value=""/>
                        <?php foreach($lesPuissances AS $unePuissance){
                                  echo '<option value>', $unePuissance['puissance'],'</option>';
                              }
                        ?>
                    </option>
                </select>
            </p>

            <div class="form-horizontal">
                <input class="btn btn-primary" id="ok" type="submit" value="Valider"/>
            </div>

        </form>
    </div>
</div>