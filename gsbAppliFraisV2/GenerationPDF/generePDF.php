<?php

require('fpdf.php');
include('../include/class.pdogsb.inc.php');
include('../include/fct.inc.php');

ob_start();

$pdo = PdoGsb::getPdoGsb();
$nom=$_GET['nom'];
$prenom=$_GET['prenom'];
$idVisiteur=$_GET['idVisiteur'];
$leMois = $_GET['leMois'];
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
$lesLibellesFrais = $pdo->getLesLibelleFraisForfait();

$numMois =substr( $leMois,4,2);
$numAnnee = $_GET['numAnnee'];
$nomMois = getNomMois($numMois);


// Création de la fiche PDF
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// LE TITRE
$titre = 'Frais de '.$nom.' '.$prenom.' pour le mois de '.$nomMois.' '.$numAnnee;
$pdf->SetFont('Arial','B',15);
// Calcul de la largeur du titre et positionnement
$w = $pdf->GetStringWidth($titre)+6;
$pdf->SetX((210-$w)/2);
// Couleurs du cadre, du fond et du texte
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(206,206,206);
$pdf->SetTextColor(0,0,0);
// Epaisseur du cadre (1 mm)
$pdf->SetLineWidth(1);
// Titre
$pdf->Cell($w,9,$titre,1,1,'C',true);
// Saut de ligne
$pdf->Ln(10);
// FIN DU TITRE


$pdf->SetTextColor(0,0,0);
$pdf->SetTitle('Fiche des Frais Forfaits et Hors Forfaits de '.$nom.' '.$prenom.' '.$nomMois.' '.$numAnnee);


// FRAIS FORFAIT
$pdf->SetFont('Arial','B',13);
$pdf->Cell(1,15,utf8_decode('Voici la liste des Frais Forfaits :'));
$pdf->SetFont('Arial','',11);
$pdf->Ln();

foreach ( $lesLibellesFrais as $unLibelleFrais ) {
    $libelle = $unLibelleFrais['libelle'];
    $quantite = $laQuantiteDuFraisForfait = getQuantiteParTypeFrais($unLibelleFrais['libelle'], $lesFraisForfait);
    $pdf->Cell(0,10,utf8_decode($libelle.'      '.$quantite),0,1);
}


// FRAIS HORS FORFAIT
$pdf->Ln();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(1,15,utf8_decode('Voici la liste des Frais Hors Forfaits :'));
$pdf->SetFont('Arial','',11);
$pdf->Ln();


foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
    $date = $unFraisHorsForfait['date'];
    $libelle = $unFraisHorsForfait['libelle'];
    $montant = $unFraisHorsForfait['montant'];
    $detail = 'Date : '.$date.' Montant : '.$montant;
    $pdf->Cell(0,10,($libelle.'      '.$detail),0,1);
}




$pdf->Output();

ob_end_flush();
?>
