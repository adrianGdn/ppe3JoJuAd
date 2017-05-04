<?php
include("../include/class.pdogsb.inc.php");

/**
 * Retourne un json du Visiteur en fonction du login et du mdp passés en paramètre.
 *
 * @param type $login
 * @param type $mdp
 * @return json
 */
if(isset($_GET['login'])&& isset($_GET['pass']))//requière l'id de l'utilisateur en paramètre
{
    $login = ($_GET['login']);//assigne l'id de l'utilisateur à la variable pour la requête sql
    $mdpActeur = sha1($_GET['pass']); //Assigne le mdp du user à la variable
}

//définit une instance de classe pdo de façon à pouvoir appeler les méthodes de la classe pdo
//une instaniation classique avec new est impossible à cause de l'implémentation de singleton dans pdogsb
$pdo = PdoGsb::getPdoGsb();

//récupère les medecins de la BDD
$tabVisiteur = $pdo->getLeVisiteur($login,$mdpActeur);
//renvoi en json

header('Content-type: application/json');
echo json_encode(array('visiteur'=>$tabVisiteur));

?>