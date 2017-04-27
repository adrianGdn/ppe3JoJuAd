<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<div class="panel-title"><h2></h2></div>
			</br></br>
		    <legend>Eléments forfaitisés</legend>
                    <legend>Eléments forfaitisés</legend>
		</div>
		<div class="panel-body">

            <label>Renseigner ma fiche de frais du mois de: </label>

            <form action="index.php?uc=gererFrais&action=creationFraisForfait" method="post"></form>



<?php
echo(var_dump($lesInfosFicheFrais));
?>

        <div>
            <label name="lblElemForf">Eléments forfaitisés (synthèse du mois)</label> <br/>

            <form class="form-horizontal" role="form" action="index.php?uc=gererFrais&action=creationFraisForfait" method="post">
                <div class="form-group">
                    <div class="form-group">
                        <label>Saisie d'un nouveau frais forfaitisé :</label>
                        </br>
                        <label for="slct_TypeFraisFF"> Type du frais : </label>
                        </br>
                        <select id="dd_typeDuFraisFF" name="typeDuFrais">
                            <option value=""/>

                            <?php foreach($lesFraisForfaitInitiaux AS $unFrais)
                            {
                                echo '<option>', $unFrais['libelle'],'</option>';
                            }                                                        
                            ?>
                            </option>
                        </select>                        
                        </br>
                        <label for="txtDateHF"> Date de l'engagement de la dépense : (jj/mm/aaaa): </label>
                        </br>
                        <input class="form-control" type="text" id="txtDateDepenseFF" name="dateDepense" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                        <label for="txtLibelleHF">Description</label>
                        </br>
                        <input class="form-control" type="text" id="txtDescriptionFF" name="description"  <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                        <label for="txtMontantHF">Quantite : </label>
                        </br>
                        <input class="form-control" type="number" id="NumQuantiteFF" name="quantite"  <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                    </div>
                </div>
                <!-- bouton validation de la creation de frais forfait -->
                <div class="horizontal-form">
                    <input class="btn btn-primary" id="btn_valider" type="submit" value="Valider" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?> />
                </div>
            </form>
        </div>      
    </div>

		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
			    <div class="form-group">
                    <?php
                        foreach ($lesFraisForfait as $unFrais)
                        {
                            $idFrais = $unFrais['idfrais'];
                            $libelle = $unFrais['libelle'];
                            $quantite = $unFrais['quantite'];
                    ?>
                    <div class="form-group">
					    <label for="idFrais"><?php echo $libelle ?></label>
					    <input class="form-control" placeholder="<?php echo $quantite?>" type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]""<?php echo $quantite?>"<?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?> />
					</div>
					<?php
						}
					?>
				</div>
				<input class="btn btn-primary" id="ok" type="submit" value="Valider" size="20" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>/>
            </form>
        </div>
    </div>
</div>
