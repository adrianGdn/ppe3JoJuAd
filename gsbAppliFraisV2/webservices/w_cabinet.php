<?php


/**
 * Retourne un json de tous les cabinets
 *
 * @return string Retourne du JSON
 */
include("../include/class.pdogsb.inc.php");


//d�finit une instance de classe pdo de fa�on � pouvoir appeler les m�thodes de la classe pdo
//une instaniation classique avec new est impossible � cause de l'impl�mentation de singleton dans pdogsb
$pdo = PdoGsb::getPdoGsb();

//r�cup�re les cabinets de la BDD
$tabCabinets = $pdo->getLesCabinets();

//renvoi en json

    header('Content-type: application/json');
    echo json_encode(array('cabinets'=>$tabCabinets));

?>