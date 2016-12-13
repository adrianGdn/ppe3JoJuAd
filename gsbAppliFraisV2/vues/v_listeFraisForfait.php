<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<div class="panel-title"><h2></h2></div>
			</br></br>
		    <legend>Eléments forfaitisés</legend>
		</div>
		<div class="panel-body">
<<<<<<< HEAD

            <label name="lblElemForf">Eléments forfaitisés (synthèse du mois)</label><br/>

=======
>>>>>>> origin/gsbAppliFrais-2.1.2
			<form class="form-horizontal" role="form" method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">

			    <div class="form-group">

                    <table>
                        <thead>
                    <?php
<<<<<<< HEAD
                        foreach ($lesFraisForfait as $unFrais) { //récupère libelle/quantite de chaque frais et stocke dans $libelle et $quantite
                            echo'<td>',$unFrais['libelle'],'</td>';
                        }
                    ?>
                        </thead>
                    </table>
                    <label>Total des frais forfaitisés engagés pour le mois : <?php echo " " ?>
                    </label>
                    <br/>



                    <input class="btn btn-primary" id="ok" type="submit" value="Valider" size="20" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>/>

=======
                        foreach ($lesFraisForfait as $unFrais)
                        {
                            $idFrais = $unFrais['idfrais'];
                            $libelle = $unFrais['libelle'];
                            $quantite = $unFrais['quantite'];
                    ?>
>>>>>>> origin/gsbAppliFrais-2.1.2
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
