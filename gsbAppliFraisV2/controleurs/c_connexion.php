<?php


if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){

	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = sha1($_REQUEST ['mdp']);
		$visiteur = $pdo->getInfosActeur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else { 
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			$typeActeur = $visiteur['typeActeur'];
			connecter($id, $nom, $prenom, $typeActeur);

            if($typeActeur == "Administrateur")
                include("vues/v_sommaireAdmin.php");
            else
                include("vues/v_sommaire.php");

        } break;
	}
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>