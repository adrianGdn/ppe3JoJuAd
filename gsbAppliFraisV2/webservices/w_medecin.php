<?php

include("../include/class.pdogsb.inc.php");
/**
 * 
 * Retourne un json contenant la liste des medecins attitrés aux visiteurs
 * 
 * @param type $idVisiteur
 * @return json
 */
function w_getLesMedecins($idVisiteur)
{
    return json_encode($pdo->getLesMedecins($idVisiteur));
}