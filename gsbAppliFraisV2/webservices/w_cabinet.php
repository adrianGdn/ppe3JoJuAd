<?php
include("../include/class.pdogsb.inc.php");

/**
 * Retourne un json de tous les cabinets
 *
 * @return string Retourne du JSON
 */
function w_getLesCabinets()
{
    return json_encode($pdo->getLesCabinets());
}

?>
