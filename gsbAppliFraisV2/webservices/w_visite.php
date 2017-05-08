<?php


/**
 * Retourne un json de toutes les visites
 *
 * @return string Retourne du JSON
 */
include("../include/class.pdogsb.inc.php");

if(isset($_GET['user']))//requière l'id de l'utilisateur en paramètre
    $idActeur = ($_GET['user']);//assigne l'id de l'utilisateur à la variable pour la requête sql
//définit une instance de classe pdo de façon à pouvoir appeler les méthodes de la classe pdo
//une instaniation classique avec new est impossible à cause de l'implémentation de singleton dans pdogsb
$pdo = PdoGsb::getPdoGsb();

//récupère les medecins de la BDD
$tabVisites = $pdo->getLesVisites($idActeur);


//renvoi en json

echo json_encode(array('visite'=>$tabVisites));

?>