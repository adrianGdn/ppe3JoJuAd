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
    case 'changerMDP':{
        // Le login saisi dans "changerMDP"
        $login = $_REQUEST['leLogin'];
        var_dump($login);
        // On récupère l'adresse mail de l'utilsateur ayant tenté de changer son MDP
        $mail = $pdo->getActeurSelonLogin($login);
        var_dump($mail);
        $mail = "cody17@me.com";
        // On vérifie que le login saisi par l'utilisateur est correct (on vérifiant que "$mail" n'est pas nul)
        if ($mail != null){
            // On envoi le mail
            envoieUnMail($mail);
            var_dump($mail);
            ajouterErreur("Un mail vient d'être envoyé sur votre boîte mail.");
            include("vues/v_erreurs.php");
        }
        elseif ($mail == null){
            // On indique à l'utilisateur que le login saisi est incorrect
            ajouterErreur("Le login saisi est incorrect.");
            include("vues/v_erreurs.php");
        }
        else{
            // Cas où une erreur inconnu est survenue
            ajouterErreur("Une erreur inconnu est survenue.");
            include("vues/v_erreurs.php");
        }
        // On redirige l'utilisateur vers la page de connexion
        include("vues/v_erreurs.php");
        include("vues/v_connexion.php");
        break;
    }
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = sha1($_REQUEST ['mdp']);
		$visiteur = $pdo->getInfosActeur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect.");
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

