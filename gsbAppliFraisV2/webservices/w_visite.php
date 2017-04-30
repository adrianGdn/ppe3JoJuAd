<?php

/**
 * 
 * Retourne un json de toutes les visites attribuées au visiteur dont l'id est passé en paramètre 
 * 
 * @param type $idVisiteur
 * @return json
 */
function w_getLesVisites($idVisiteur)
{
    return json_encode($pdo->getLesVisiteur($idVisiteur));
}

