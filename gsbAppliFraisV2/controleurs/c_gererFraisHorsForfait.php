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
    case 'validerCreationFrais':{
        $dateFrais = $_REQUEST['dateFrais'];
        $libelle = $_REQUEST['libelle'];
        $montant = $_REQUEST['montant'];
        valideInfosFrais($dateFrais,$libelle,$montant);
        if (nbErreurs() != 0 ){
            include("vues/v_erreurs.php");
        }
        else{
            $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
        } break;
    }

    case 'supprimerFrais':{
        $idFrais = $_REQUEST['idFrais'];
        $pdo->supprimerFraisHorsForfait($idFrais);
        break;
    }
}

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
include("vues/v_listeFraisHorsForfait.php");
?>
