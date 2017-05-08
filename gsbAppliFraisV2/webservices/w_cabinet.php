<?php


/**
 * Retourne un json de tous les cabinets
 *
 * @return string Retourne du JSON
 */
include("../include/class.pdogsb.inc.php");



//une instaniation classique avec new est impossible ï¿½ cause de l'implï¿½mentation de singleton dans pdogsb
$pdo = PdoGsb::getPdoGsb();

//rï¿½cupï¿½re les cabinets de la BDD
$tabCabinets = $pdo->getLesCabinets();

//renvoi en json
//définit une instance de classe pdo de façon à pouvoir appeler les méthodes de la classe pdo
//une instaniation classique avec new est impossible à cause de l'implémentation de singleton dans pdogsb
$pdo = PdoGsb::getPdoGsb();

//récupère les cabinets de la BDD
$tabCabinets = $pdo->getLesCabinets();

//renvoi en json
    echo json_encode(array('cabinets'=>$tabCabinets));

?>