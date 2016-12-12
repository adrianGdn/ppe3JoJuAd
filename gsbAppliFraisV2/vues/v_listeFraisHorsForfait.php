<div class="col-md-6">
    <div class="content-box-large">
        <div class="panel-heading">
            <legend>Nouvel élément hors forfait</legend>
        </div>
        <div class="panel-body">

            <!-- Code Avant modification interface graphique -->

          <!--  <form class="form-horizontal" role="form" action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
                <div class="form-group">
                    <div class="form-group">
                        <label for="txtDateHF"> Date (jj/mm/aaaa): </label>
                        </br>
                        <input class="form-control" type="text" id="txtDateHF" name="dateFrais" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                        <label for="txtLibelleHF">Libellé</label>
                        </br>
                        <input class="form-control" type="text" id="txtLibelleHF" name="libelle"  <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                        <label for="txtMontantHF">Montant : </label>
                        </br>
                        <input class="form-control" type="text" id="txtMontantHF" name="montant"  <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                    </div>
                </div>
                <div class="horizontal-form">
                    <input class="btn btn-primary" id="ajouter" type="submit" value="Ajouter" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?> />
                    <input class="btn btn-primary" id="effacer" type="reset" value="Effacer"/>
                </div>
            </form> -->

            <!-- fin code original -->

            </br>
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

        <!--- ajout maquette frais hors forfait --->
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
                <label>Saisie d'un nouveau frais forfaitisé :</label><br/>
                <label>Type de frais :</label>
                <select method="POST" name="lstFrais" id="typeFrais"><option selected="choix-Option"> Choisissez un type de frais
                    <?php foreach ($lesFraisForfait as $libelleFrais)
                        { ?>
                    <option value="<? echo $libelleFrais['libelle']?>"><?php echo $libelleFrais['libelle'] ?></option>
                    <?php
                    }
                    ?>
                </select> <br/>

                <label>Date de l'engagement de la dépense :</label>
                <form name="Filter" method="POST">
                    <input type="date" name="dateAjout" value="<?php echo date('Y-m-d'); ?>" />
                </form>
                <br/>
                <label>Description :</label> <input method="POST" name="descriptionInput" type="text"><br/>
                <label>Quantité :</label> <input method="POST" name="quantitéInput" type="number"><br/>
                <input class="btn btn-primary" id="ok" type="submit" value="Valider" size="20" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>/> <br/>
            </form>
        </div>

        <!-- fin maquette frais hors forfait -->

        </div>
    </div>




</div>

<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<legend>Elément hors forfait</legend>
		</div>
		<div class="panel-body">
			<table class="table">
			     <thead>
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>
                        <th class="montant">Montant</th>
                        <th class="action">&nbsp;</th>
                    </tr>
				    <?php
					    foreach( $lesFraisHorsForfait as $unFraisHorsForfait)
                        {
                            $libelle = $unFraisHorsForfait['libelle'];
                            $date = $unFraisHorsForfait['date'];
                            $montant = $unFraisHorsForfait['montant'];
                            $id = $unFraisHorsForfait['id'];
                    ?>
                            <tr>
							<td> <?php echo $date ?></td>
							<td><?php echo $libelle ?></td>
							<td><?php echo $montant ?></td>
							<td> <?php
                            if ($lesInfosFicheFrais['idEtat']!='CR')
							{
							    echo htmlspecialchars('Voulez-vous vraiment supprimer ce frais ?', ENT_QUOTES);
                            } else {
                                    echo htmlspecialchars('Voulez-vous vraiment supprimer ce frais ?', ENT_QUOTES);
									echo '<a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais='.$id.'"
								onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais ?\');"> Supprimer ce frais</a></td>';
								    }
						?></tr><?php		 }  ?>	  
			 </table>
		</div> 
	</div>
</div>
