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
switch($action) {
    case 'saisirFrais': {
        if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
            $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        }
        break;
    }
    case 'validerCreationFrais':{
        $dateFrais = $_REQUEST['dateAjout'];
        $libelle = $_REQUEST['libelle'];
        $description = $_REQUEST['description'];
        $quantite = $_REQUEST['quantite'];
        $dateFrais = dateAnglaisVersFrancais($dateFrais);
        $idFraisForfait = donneIdFrais($libelle);
        valideInfosFrais($dateFrais,$libelle,$quantite);
        if (nbErreurs() != 0 ){
            include("vues/v_erreurs.php");
        }
        else{
            $pdo->addNouveauFraisForfait($idVisiteur,$mois,$libelle,$description,$dateFrais,$quantite,$idFraisForfait);
        } break;
    }
    case 'supprimerFrais':{
        $idFrais = $_REQUEST['idFrais'];
        $pdo->supprimerFraisHorsForfait($idFrais);
        break;
    }
}


$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
$lesLibellesForfait = $pdo->getLibelleForfait();
include("vues/v_listeFraisForfait.php");
?>
