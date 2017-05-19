<?php
// Afin de pouvoir indiquer que le site est en maintenance, une variable booléenne est initialisée
// On la met à vrai lorsque le site passe en maintenant et à fausse dans le cas contraire
$estEnMaintenance = false;
if($estEnMaintenance == false){
    require_once("include/fct.inc.php");
    require_once("include/class.pdogsb.inc.php");
    session_start();
    $pdo = PdoGsb::getPdoGsb();
    $estConnecte = estConnecte();
    if(!isset($_REQUEST['uc']) || !$estConnecte){
         $_REQUEST['uc'] = 'connexion';
    }
    $uc = $_REQUEST['uc'];
    switch($uc){
        case 'connexion':{
            include("controleurs/c_connexion.php");break;
        }
        case 'gererFrais' :{
            include("controleurs/c_gererFrais.php");break;
        }
        case 'gererFraisHorsForfait' :{
            include("controleurs/c_gererFraisHorsForfait.php");break;
        }
        case 'etatFrais' :{
            include("controleurs/c_etatFrais.php");break;
        }
        case 'admin' :{
            include("controleurs/c_admin.php");break;
        }
        case 'vehicule' :{
            include("controleurs/c_vehicule.php");break;
        }
    }
}
else {
    include("vues/v_maintenance.php");
}
?>
