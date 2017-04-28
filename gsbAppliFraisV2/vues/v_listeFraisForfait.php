<div class="col-md-6">
	<div class="content-box-large">
		<div class="panel-heading">
			<div class="panel-title"><h2></h2></div>
			</br></br>
		    <legend>Eléments forfaitisés</legend>
		</div>
		<div class="panel-body">

            <label>Renseigner ma fiche de frais du mois de: </label>

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
                        <input class="form-control" type="datetime" id="txtDateDepenseFF" name="dateDepense" <?php if ($lesInfosFicheFrais['idEtat']!='CR') { 		echo 'disabled';};   ?>/>
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
                    <button class="btn btn-primary" id="btn_valider" type="submit"<?php if ($lesInfosFicheFrais['idEtat']!='CR') { echo 'disabled';} ?>>Valider</button>
                </div>
            </form>
        </div>


        <table style="width:80%" border="1">
        <tr><td>&nbsp;</td><td>Forfait Etape &nbsp;</td><td>Frais Kilometrique&nbsp;</td><td>Nuitée Hôtel&nbsp;</td><td>Repas Restaurant&nbsp;</td></tr>
        <tr>
           <td>Quantité Totale :</td>
               <?php   foreach ($tabQuantitéMonatantTotaleFrais as $uneQuantité)
                       {
                           echo ("<td>");
                           echo $uneQuantité[0];
                           echo ("</td>");
                       }
               ?>
      </tr>
      <tr>
            <td>Montant Totale :</td>
            <?php   foreach ($tabQuantitéMonatantTotaleFrais as $unMontant)
                    {
                        echo ("<td>");
                        echo $unMontant[2];
                        echo ("</td>");
                    }
            ?>
            </tr>
        </table>
    </div>
    <div>

    </div>
</div>