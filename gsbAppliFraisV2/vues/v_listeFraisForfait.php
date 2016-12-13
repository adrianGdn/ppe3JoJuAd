<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<div class="panel-title"><h2></h2></div>
			</br></br>
            <p> Renseigner la fiche du mois de :
                <select method="POST" name="fromSelectMois">
                    <option value="Janvier">Janvier</option>
                    <option value="Fevrier">Fevrier</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mais">Mai</option>
                    <option value="Juin">Juillet</option>
                    <option value="Aout">Aout</option>
                    <option value="Septembre">Septembre</option>
                    <option value="Octobre">Octobre</option>
                    <option value="Novembre">Novembre</option>
                    <option value="Decembre">Decembre</option>
                </select>
            </p>
		</div>

        <div class="panel-body">

            <!-- le formulaire pass les informations entrées au controleur -->

            <form class="form-horizontal" role="form" method="POST"  action="index.php?uc=gererFrais&action=validerCreationFrais">
                <label>Saisie d'un nouveau frais forfaitisé :</label><br/>

                <!-- passe la valeur sélectionnée dans le drop down au controleur gererFrais-->
                <label>Type de frais :</label>
                <select name="libelle" id="typeFrais"><option selected="choix-Option"> Choisissez un type de frais
                        <!-- pour chaque $libelle stockés dans le tableau $lesFraisForfait
                         afficher le libelle dans le drop-down -->
                        <?php foreach ($lesLibellesForfait as $libelleFrais)
                        { ?>
                    <option>
                        <?php echo $libelleFrais['libelle'] ?>
                    </option>
                    <?php
                        }
                        ?>
                </select> <br/>

                <label>Date de l'engagement de la dépense :</label>
                    <input type="date" name="dateAjout" value="<?php echo date('Y-m-d'); ?>" />
            <br/>
            <label>Description :</label> <input name="description" type="text"><br/>
            <label>Quantité :</label> <input name="quantite" type="number"><br/>

                <!-- Bouton de Validation -->
                <input class="btn btn-primary" id="ok" type="submit" value="Valider" size="20" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>/> <br/>
            </form>
        </div>

        <!-- Generation du tableau -->
		<div class="panel-body">

            <label name="lblElemForf">Eléments forfaitisés (synthèse du mois)</label><br/>

			<form class="form-horizontal" role="form" method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">

			    <div class="form-group">

                    <table>
                        <thead>
                    <?php
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

                    <div class="form-group">




				</div>

            </form>
        </div>
    </div>
</div>
