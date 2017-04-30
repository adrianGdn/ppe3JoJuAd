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
    case 'reinitialisationMDP':{
        // On récupère le login de l'utilisateur saisi précédemment
        $login = $_SESSION['login'];
        // On récupère les mot de passe saisi par l'utilisateur et on vérifie qu'ils sont identiques
        $mdp = $_REQUEST['mdp'];
        $mdpResaisi = $_REQUEST['mdpResaisi'];
        if($mdp == $mdpResaisi){
            $pdo->updateMDP($login, $mdp);
            ajouterErreur("Votre mot de passe a été modifié avec succès. Vous allez maintenant être redirigé sur l'écran principal.");
            include("vues/v_erreurs.php");
            include("vues/v_connexion.php");
        }
        else{
            // Cas où les deux mot de passe saisi sont différents
            ajouterErreur("Les mots de passe saisi sont différents, ils doivent être strictement identique.");
            include("vues/v_erreurs.php");
            include("../reinitialiserMDP/v_reinitialisationMDP.php");
        }
        break;
    }
    case 'repQuesionSecrete':{
        // On récupère le login de l'utilisateur saisi précédemment
        $login = $_SESSION['login'];
        // On récupère la réponse à la question donnée par l'utilisateur
        $repQuestionSecrete = $_REQUEST['laReponse'];
        // On utilise une fonction qui va communiquer avec la base de données pour vérifier que la réponse est correct
        $estReponseCorrect = $pdo->estReponseCorrect($login, $repQuestionSecrete);
        if($estReponseCorrect == true){
            // Cas où la réponse donné est correct
            ajouterErreur("La réponse saisie est correcte.");
            include("vues/v_erreurs.php");
            include("../reinitialiserMDP/v_reinitialisationMDP.php");
        }
        else{
            // Cas où la réponse donné est incorrect
            ajouterErreur("La réponse saisie est incorrecte, vous allez être redirigé sur l'écran principal.");
            include("vues/v_erreurs.php");
            include("vues/v_connexion.php");
        }
        break;
    }
    case 'redirigeQuestionSecrete':{
        // Permet de vérifier que le login de l'utilisateur saisi existe
        $login = $_REQUEST['leLogin'];
        // On utilise une fonction (une requête SQL) pour savoir si le login existe en BDD
        $estLoginExistant = $pdo->estLoginExistant($login);
        if($estLoginExistant == true){
            // Cas où le login existe
            // On met le login de l'utilisateur en session
            $_SESSION['login'] = $login;
            ajouterErreur("Le login saisi est correcte.");
            include("vues/v_erreurs.php");
            include("../reinitialiserMDP/v_questionSecrete.php");
        }
        else{
            // Cas où le login n'existe pas
            ajouterErreur("Le login saisi est incorrect, vous allez être redirigé sur l'écran principal.");
            include("vues/v_erreurs.php");
            include("vues/v_connexion.php");
        }
        break;
    }
    case 'changerMDP':{ // Ancienne méthode, tentative d'envoi d'un mail
        // Le login saisi dans "changerMDP"
        $login = $_REQUEST['leLogin'];
        // On récupère l'adresse mail de l'utilsateur ayant tenté de changer son MDP
        $mail = $pdo->getMailActeurSelonLogin($login);
        $mail = "cody17@me.com";
        // On vérifie que le login saisi par l'utilisateur est correct (on vérifiant que "$mail" n'est pas nul)
        if ($mail != null){
            // On envoi le mail
            envoieUnMail($mail);
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

