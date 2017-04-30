<?php
/**
 * Teste si un quelconque visiteur est connecté
 *
 * @return bool Vrai ou faux
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}

/**
 * Enregistre dans une variable session les infos d'un visiteur
 *
 * @param $id int ID du visiteur
 * @param $nom string Nom du visiteur
 * @param $prenom string Prénom du visiteur
 * @param $typeActeur int Type d'acteur
 */
function connecter($id, $nom, $prenom, $typeActeur){
	$_SESSION['idVisiteur']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
	$_SESSION['typeActeur'] = $typeActeur;
}

/**
 * Détruit la session active
 */
function deconnecter(){
    session_destroy();
}

/**
 * Transforme une date au format Français (jj/mm/aaaa) vers le format Anglais (aaaa-mm-jj)
 *
 * @param $maDate DateTime La date au format Français (jj/mm/aaa)
 * @return false|string La date au format Anglais (aaaa-mm-jj)
 */
function dateFrancaisVersAnglais($maDate){
    @list($jour,$mois,$annee) = explode('/',$maDate);
    return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}

/**
 * Transforme une date au format format Anglais (aaaa-mm-jj) vers le format Français (jj/mm/aaaa)
 *
 * @param $maDate DateTime La date au format Aglais (aaaa-mm-jj)
 * @return string La date au format Français (jj/mm/aaaa)
 */
function dateAnglaisVersFrancais($maDate){
    @list($annee,$mois,$jour)=explode('-',$maDate);
    $date="$jour"."/".$mois."/".$annee;
    return $date;
}

/**
 * Retourne le mois au format aaaamm selon le jour dans le mois
 *
 * @param $date DateTime La date au format Français (jj/mm/aaaa)
 * @return string Le mois au format aaaamm
 */
function getMois($date){
    @list($jour,$mois,$annee) = explode('/',$date);
    if(strlen($mois) == 1){
        $mois = "0".$mois;
    }
    return $annee.$mois;
}

/* Gestion des erreurs */
/**
 * Indique si une valeur est un entier positif ou nul
 *
 * @param $valeur int L'entier que l'on veut tester
 * @return bool Vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 *
 * @param $tabEntiers : le tableau
 * @return bool Vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	if (isset($unEntier) ){
		foreach($tabEntiers as $unEntier){
			if(!estEntierPositif($unEntier)){
		 		$ok=false; 
			}
		}	
	}
	return $ok;
}

/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 *
 * @param DateTime $dateTestee La date que l'on veut tester
 * @return bool Vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}

/**
 * Vérifie la validité du format d'une date Française (jj/mm/aaaa)
 *
 * @param $date DateTime La date que l'on veut tester
 * @return bool Vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques
 *
 * @param $lesFrais mixed Le tableau de frais que l'on veut tester
 * @return bool Vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}

/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant,
 * des message d'erreurs sont ajoutés au tableau des erreurs
 *
 * @param $dateFrais DateTime La date
 * @param $libelle string Le libellé du frais
 * @param $montant double Le montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDateValide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("Date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	} else
		if(!is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs
 *
 * @param $msg string Le libellé du message d'erreur à ajouter
 */
function ajouterErreur($msg){
    if (! isset($_REQUEST['erreurs'])){
        $_REQUEST['erreurs']=array();
    }
    $_REQUEST['erreurs'][]=$msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs
 *
 * @return int Le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}

/**
 * Permet d'obtenir le mois désiré sous la forme d'une chaîne de caractères
 *
 * @param $numMois string Le numéro du mois désiré, sous forme d'entier
 * @return string Le mois (sous forme de chaîne de caractères)
 */
function getNomMois($numMois){
    $nomMois = array(
        '01' => "Janvier",
        '02' => "Février",
        '03' => "Mars",
        '04' => "Avril",
        '05' => "Mai",
        '06' => "Juin",
        '07' => "Juillet",
        '08' => "Août",
        '09' => "Septembre",
        '10' => "Octobre",
        '11' => "Novembre",
        '12' => "Décembre"
    );
    return $nomMois[$numMois];
}

/**
 * Fonction inutilisé pour le moment, devait servir pour la réinitialisation de mot de passe mais une autre méthode à été trouvé
 *
 * @param $adresseMail string L'adresse mail de l'acteur
 */
function envoieUnMail($adresseMail){
	$sujet = "Lien de réinitialisation de votre mot de passe";
	$message = "Bonjour Madame, Monsieurs, \n \n Le lien de réinitialisation de votre mot de passe est le suivant : \n liensBlop \n \n Cordialement,\n L'équipe GSB.";
	mail($adresseMail, $sujet, $message);
}

/**
 * Retourne l'identifiant du frais en fonction de son libellé
 * 
 * @param string $description La description de la fiche de frais
 * @return string L'identifiant de la fiche de frais
 */
function donneIdTypeFrais($description)
{
    switch($description){
		case "Forfait Etape":
			return  $idConverti = "ETP";
			break;
		case "Frais Kilométrique":
			return $idConverti = "KM";
			break;
		case "Nuitée Hôtel":
			return $idConverti = "NUI";
			break;
		case "Repas Restaurant":
			return $idConverti = "REP";
			break;
    }
}
?>
