<?php
if($_SESSION['typeActeur'] == 'Administrateur') {
    include("vues/v_sommaireAdmin.php");
}
else {
    include("vues/v_sommaire.php");
}
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = $_REQUEST['action'];
switch($action){
	case 'saisirFrais':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
		break;
	}
	case 'validerMajFraisForfait':{

		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		} break;
	}
        case 'creationFraisForfait':{
            
            $typeDuFraisForfait = $_REQUEST['typeDuFrais'];
            $idFrais = donneIdTypeFrais($typeDuFraisForfait);
            $dateDeLaDepense = $_REQUEST['dateDepense'];
            $description = $_REQUEST['description'];
            $quantite = $_REQUEST['quantite'];
            $tableauMontant=$pdo->getMontantFraisID($idFrais);
            $montant = $tableauMontant[0];
            
            $pdo->creeNouveauFraisForfait($idVisiteur,$mois,$idFrais,$quantite,$description,$dateDeLaDepense);
    }break;
}

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois); // tableau des fraisForfait initiaux (id,libelle,quantite)
$lesFraisForfaitInitiaux= $pdo->getInfosFraisForfaitInitiaux(); // retourne un tableau de frais forfaits uniques avec id,libelle,montant nominal
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
$testMethodeEstFicheForfaitExistante = $pdo->estFicheForfaitExistante('a17','201705','ETP');
include("vues/v_listeFraisForfait.php");
?>
