<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
session_start();
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
}
?>
