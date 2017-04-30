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
            // On récupère le type du frais
            $typeDuFraisForfait = $_REQUEST['typeDuFrais'];
            $idFrais = donneIdTypeFrais($typeDuFraisForfait);
            // On récupère le jour saisi puis on y ajoute le mois et l'année actuelle
            $dateDeLaDepense = date($_REQUEST['dateDepense'] . "/m/Y");
            // On remplace l'objet "dateFrais" actuellement en session
            $_SESSION['dateDepense'] = $dateDeLaDepense;
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
$tabQuantitéMonatantTotaleFrais = $pdo->recupQteEtMontTotalFF($mois);
$tabLigneFraisForfait = $pdo->getLigneFraisForfait(); // récupère tout les frais forfait existant en BDD
include("vues/v_listeFraisForfait.php");
?>
