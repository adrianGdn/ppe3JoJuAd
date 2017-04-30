<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<div class="panel-title">
                <h2></h2>
            </div>
			</br>
		    <legend>Eléments forfaitisés</legend>
		</div>
		<div class="panel-body">
            <form class="form-horizontal" role="form" action="index.php?uc=gererFrais&action=creationFraisForfait" method="post">
                <div class="form-group">
                    <div class="form-group">
                        <h4>Saisie d'un nouveau frais forfaitisé :</h4>
                        </br>
                        <label for="slct_TypeFraisFF"> Type du frais : </label>
                        </br>
                        <select id="dd_typeDuFraisFF" name="typeDuFrais">
                            <option value=""/>
                                <?php foreach($lesFraisForfaitInitiaux AS $unFrais){
                                          echo '<option>', $unFrais['libelle'],'</option>';
                                      }
                                ?>
                            </option>
                        </select>                        
                        </br>
                        <label for="txtDateHF"> Date de l'engagement de la dépense (jour uniquement) :</label>
                        </br>
                        <input class="form-control" type="number" id="txtDateDepenseFF" name="dateDepense" maxlength="2" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
                        </br></br>
                        <label for="txtLibelleHF">Description :</label>
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
                    <button class="btn btn-primary" id="btn_valider" type="submit"<?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>>Valider</button>
                </div>
            </form>
        </div>

        </br>
        </br>

        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><!-- Colonne vide pour éviter un décallage des données --></th>
                        <?php
                            foreach ($lesLibelleFraisForfait as $leLibelle){
                                echo '<th>';
                                    echo $leLibelle['libelle'];
                                echo '</th>';
                            }
                        ?>
                    </tr>
                </thead>
                <tr>
                    <th>Quantité Totale :</th>
                    <?php
                        foreach ($lesLibelleFraisForfait as $leLibelle){
                            $laQuantiteDuFraisForfait = getQuantiteParTypeFrais($leLibelle['libelle'], $lesFraisForfait);
                            echo '<td>';
                                echo $laQuantiteDuFraisForfait;
                            echo '</td>';
                        }
                    ?>
                </tr>
                <tr>
                    <th>Montant Total :</th>
                    <?php
                        foreach ($lesLibelleFraisForfait as $leLibelle){
                            $laQuantiteDuFraisForfait = getQuantiteParTypeFrais($leLibelle['libelle'], $lesFraisForfait);
                            $montantFraisForfait = $pdo->getLeMontantLigneFraisForfait($leLibelle['libelle'], $laQuantiteDuFraisForfait);

                            echo '<td>';
                                echo $montantFraisForfait;
                            echo '</td>';
                        }
                    ?>
                </tr>
            </table>
            <label>Total des frais forfaitisées pour le mois :</label>
            <?php
                $montantDeToutLesFraisForfait = 0;
                foreach ($lesLibelleFraisForfait as $leLibelle){
                    $laQuantiteDuFraisForfait = getQuantiteParTypeFrais($leLibelle['libelle'], $lesFraisForfait);
                    $montantFraisForfait = $pdo->getLeMontantLigneFraisForfait($leLibelle['libelle'], $laQuantiteDuFraisForfait);

                    $montantDeToutLesFraisForfait += $montantFraisForfait;
                }
                echo $montantDeToutLesFraisForfait;
            ?>
        </div>
        <div class="panel-body">
            <br/>
            <label> Eléments forfaitisés (détails du mois) :</label>
            <table class="table">
                <thead>
                    <?php
                        echo"<tr>";
                            echo "<th>";
                                echo "Description";
                            echo "</th>";

                            echo "<th>";
                                echo "Type du frais";
                            echo "</th>";

                            echo "<th>";
                                echo "Montant";
                            echo "</th>";

                            echo "<th>";
                                echo "Quantité";
                            echo "</th>";

                            echo "<th>";
                                echo ""; // Pour garder une ligne grasse
                            echo "</th>";
                        echo"</tr>";
                        foreach ($tabLigneFraisForfait as $laFicheFrais){
                            echo"<tr>";
                                echo "<td>";
                                    echo $laFicheFrais[7];
                                echo "</td>";

                                echo "<td>";
                                    echo $laFicheFrais[3];
                                echo "</td>";

                                echo "<td>";
                                    echo $laFicheFrais[5];
                                echo "</td>";

                                echo "<td>";
                                    echo $laFicheFrais[4];
                                echo "</td>";

                                $idFicheFrais = $laFicheFrais[0];

                                echo "<td>";
                                    echo '<a href="index.php?uc=gererFrais&action=supprimerFrais&id='.$idFicheFrais.'"onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais?\');">Supprimer ce frais</a></td>';
                                echo "</td>";
                            echo"</tr>";
                        }
                    ?>
                </thead>
            </table>
        </div>
    </div>
</div>
