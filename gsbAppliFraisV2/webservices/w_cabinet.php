<?php
include("../include/class.pdogsb.inc.php");

/**
 * Permet d'encoder les cabinets récupérer via une requête
 *
 * @return string Retourne du JSON
 */
function w_getLesCabinets()
{
    return json_encode($pdo->getLesCabinets());
}

?>
