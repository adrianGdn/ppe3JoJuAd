<?php
include("../include/class.pdogsb.inc.php");

/**
 * Retourne un json du Visiteur en fonction du login et du mdp passés en paramètre.
 * 
 * @param type $login
 * @param type $mdp
 * @return json
 */
function w_getLeVisiteur($login,$mdp)
{
    return json_encode($pdo->getLesVisiteurs($login,$mdp));
}

?>