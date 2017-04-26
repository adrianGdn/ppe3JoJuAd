<?php

require('fpdf.php');
include_once '../include/class.pdogsb.inc.php';

$pdo = PdoGsb::getPdoGsb();
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$idActeur = $_SESSION['idVisiteur'];
$moisChoisi = $_SESSION[''];

$lesMois = $pdo->getLesMoisDisponibles($idActeur);

