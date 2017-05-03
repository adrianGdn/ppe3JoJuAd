<?php

/**
 * Classe d'accès aux données.
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * @package default
 * @author Cheri Bibi C'est Pas Fini !
 * @version    4.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsbapplifrais';
    private static $user = 'jojuad'; // Pour générer en local sous Windows, utiliser en user 'root' sinon 'jojuad'
    private static $mdp = 'AzertY!59000'; // Pour générer en local sous Windows, laisser mdp vide sinon 'AzertY!59000'
    private static $monPdo;
    private static $monPdoGsb = null;


    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct()
    {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     *
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return mixed l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un acteur
     *
     * @param $login string Le login de l'acteur
     * @param $mdp string Le mot de passe de l'acteur
     * @return mixed l'id, le nom, le prénom et le type d'acteur sous la forme d'un tableau associatif
     */
    public function getInfosActeur($login, $mdp)
    {
        $req = "SELECT acteur.id as id, acteur.nom as nom, acteur.prenom as prenom, typeacteur.leTypeActeur as typeActeur FROM acteur
		INNER JOIN typeacteur ON acteur.idTypeActeur = typeacteur.id
		WHERE acteur.login='$login' AND acteur.mdp='$mdp'";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concernées par les deux arguments
     *
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-
     *
     * @param $idVisiteur
     * @param $mois String sous la forme aaaamm
     * @return mixed tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois)
    {
        $req = "SELECT * FROM lignefraishorsforfait WHERE lignefraishorsforfait.idvisiteur ='$idVisiteur'
		AND lignefraishorsforfait.mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Retourne le nombre de justificatif d'un acteur pour un mois donné
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @return mixed le nombre entier de justificatifs
     */
    public function getNbjustificatifs($idVisiteur, $mois)
    {
        $req = "SELECT fichefrais.nbjustificatifs AS nb FROM  fichefrais WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
     * concernées par les deux arguments
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @return mixed l'id, le libelle et la quantité sous la forme d'un tableau associatif
     */
    public function getLesFraisForfait($idVisiteur, $mois)
    {
        $req = "SELECT fraisforfait.id AS idfrais, fraisforfait.libelle AS libelle, lignefraisforfait.quantite AS quantite
        FROM lignefraisforfait INNER JOIN fraisforfait
		ON fraisforfait.id = lignefraisforfait.idfraisforfait
		WHERE lignefraisforfait.idvisiteur ='$idVisiteur' AND lignefraisforfait.mois='$mois'
		ORDER BY lignefraisforfait.idfraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Permet de récupérer les ID des frais forfaits existant en BDD
     *
     * @return $lesIdFrais mixed Les ID des frais forfaits existant
     */
    public function getLesIdFrais()
    {
        $req = "SELECT id FROM fraisforfait;";
        $res = PdoGsb::$monPdo->query($req);
        $lesIdFrais = $res->fetch();
        return $lesIdFrais;
    }

    /**
     * Retourne tous les ID de la table FraisForfait
     *
     * @return array un tableau associatif
     */
    public function getInfosFraisForfaitInitiaux()
    {
        $req = "SELECT * FROM fraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Retourne les mois pour lesquels un acteur a une fiche de frais
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @return array un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur)
    {
        $req = "SELECT fichefrais.mois AS mois FROM  fichefrais WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.idEtat IN ('CR', 'VA')
		ORDER BY fichefrais.mois DESC ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un acteur pour un mois donné
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @return array un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois)
    {
        $req = "SELECT fichefrais.idEtat AS idEtat, fichefrais.dateModif AS dateModif, fichefrais.nbJustificatifs AS nbJustificatifs,
			fichefrais.montantValide AS montantValide, etat.libelle AS libEtat from  fichefrais INNER JOIN etat ON fichefrais.idEtat = etat.id
			WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

    /**
     * Retourne tous les frais forfait qui sont sur la base de données
     *
     * @return mixed L'id, le libelle et le montant sous la forme d'un tableau associatif
     */
    public function getFraisForfait()
    {
        $req = "SELECT id, libelle, montant FROM fraisforfait;";
        $res = PdoGsb::$monPdo->query($req);
        $lesDonnees = $res->fetchALl();
        return $lesDonnees;
    }

    /**
     * Permet de récupérer l'adresse mail de l'utilisateur qui a oublié son mot de passe,
     * si le login saisi est correct
     *
     * @param $login string Le login de l'utilisateur qui a oublié son mot de passe
     * @return $leMailActeur mixed L'adresse mail de l'utilisateur qui a oublié son mot de passe
     */
    public function getMailActeurSelonLogin($login)
    {
        $req = "SELECT mail FROM acteur WHERE login='$login'";
        $res = PdoGsb::$monPdo->query($req);
        $leMailActeur = $res->fetch();
        return $leMailActeur;
    }

    /**
     * Retourne un visiteur de la base de données en fonction du login et mdp passé en paramètre
     *
     * @param $login string Le login du Visiteur
     * @param $mdp string Le mot de passe du visiteur
     * @return $lesVisiteurs mixed Les attributs de la table visiteur sous forme d'un tableau associatif
     */
    public function getLeVisiteur($login, $mdp)
    {
        // Création de la requête (sélectionne un visiteur en fction du login/mdp et de son id = 2 (visiteur)
        $req = "SELECT * FROM acteur WHERE acteur.idTypeActeur = '2'AND WHERE acteur.login='$login' AND WHERE acteur.mdp='$mdp'";
        // Exécution de la requête
        $res = PdoGsb::$monPdo->query($req);
        // Stockage de la requête dans $lesVisiteurs
        $lesVisiteurs = $res->fetchAll();
        // Retourne $lesVisiteurs
        return $lesVisiteurs;
    }

    /**
     * Permet de récupérer les cabinets
     *
     * @return $lesCabinets mixed Les attributs de la table cabinet sous forme d'un tableau associatif
     */
    public function getLesCabinets()
    {
        // Création requête
        $req = "SELECT * FROM cabinet";
        // Exécution de la requête
        $res = PdoGsb::$monPdo->query($req);
        // On stocke l'intégralité des résultats dans la variables $lesCabinets
        $lesCabinets = $res->fetchAll();
        // On retourne les cabinets
        return $lesCabinets;
    }

    /**
     * Permet de récupérer les médecins
     *
     * @param $idActeur string L'ID de l'acteur associé aux médecins recherchés
     * @return $lesMedecins mixed Les attributs de la table médecin sous forme d'un tableau associatif
     */
    public function getLesMedecins($idActeur)
    {
        // Création requête
        $req = "SELECT * FROM medecin WHERE medecin.idActeur = '$idActeur'";
        // Exécution de la requête
        $res = PdoGsb::$monPdo->query($req);
        // Stockage de la requête dans la variable $lesMedecins
        $lesMedecins = $res->fetchAll();
        // Retourne les médecins
        return $lesMedecins;
    }

    /**
     * Permet de récupérer les visites
     *
     * @param $idActeur string L'ID de l'acteur associé aux visites recherchés
     * @return $lesVisites mixed Les attributs de la table visite sous forme d'un tableau associatif
     */
    public function getLesVisites($idActeur)
    {
        // Création requête
        $req = "SELECT * FROM visite WHERE visite.idActeur = '$idActeur'";
        // Exécution de la requête
        $res = PdoGsb::$monPdo->query($req);
        // Stockage de la requête dans la variable $lesVisites
        $lesVisites = $res->fetchAll();
        // Retourne les visites
        return $lesVisites;
    }

    /**
     * Recupère le montant du frais  en fonction de l'id du frais
     *
     * @param $idFrais string L'identifiant de la fiche de frais
     * @return $montant double Montant de la fiche de frais
     */
    public function getMontantFraisID($idFrais)
    {
        $req = "SELECT montant from fraisforfait WHERE fraisforfait.id = '$idFrais'";
        $res = PdoGsb::$monPdo->query($req);
        $montant = $res->fetch();
        return $montant;
    }

    /**
     * Recupère la quantité totale de frais en fonction de l'identifiant du frais
     *
     * @param $idVisiteur int L'identifiant de l'acteur
     * @param $idFrais string L'identifiant de la fiche de frais
     * @param $mois string Le mois où la fiche de frais a été créée
     * @return $quantiteTotale double La quantité de fiche de frais existante
     */
    public function getQuantiteTotaleParIdFrais($idVisiteur, $idFrais, $mois)
    {
        $req = "SELECT SUM(quantite) FROM lignefraisforfait.quantite WHERE lignefraisforfait.idvisiteur = '$idVisiteur' AND lignefraisforfait.idfraisforfait = '$idFrais' and lignefraisforfait.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $quantiteTotale = $res->fetch();
        return $quantiteTotale;
    }

    /**
     * Retourne un tableau contenant toutes les lignes de frais forfait
     *
     * @param $idVisiteur string L'ID du visiteur associé à la fiche de frais
     * @return $tableauLigneFraisForfait array Un tableau contenant les lignes de frais forfait
     */
    public function getLigneFraisForfait($idVisiteur)
    {
        $req = "SELECT * FROM lignefraisforfait WHERE idVisiteur = '$idVisiteur';";
        $res = PdoGsb::$monPdo->query($req);
        $tableauLigneFraisForfait = $res->fetchAll();
        return $tableauLigneFraisForfait;
    }

    /**
     * Permet de récupérer les libelles des frais forfait existants en BDD
     *
     * @return $lesLibelles mixed Les libelles des frais forfait existants
     */
    public function getLesLibelleFraisForfait()
    {
        $req = "SELECT libelle FROM fraisforfait;";
        $res = PdoGsb::$monPdo->query($req);
        $lesLibelles = $res->fetchAll();
        return $lesLibelles;
    }

    /**
     * Permet de récupérer le montant total des fiches de frais forfait existant en BDD
     *
     * @param $libelleFraisForfait string Le libelle du frais forfait
     * @param $quantiteTotaleDesLignesDeFraisForfait int La quantite des lignes de frais forfait
     * @return $montant int Le montant total des fiches de frais forfait
     */
    public function getLeMontantLigneFraisForfait($libelleFraisForfait, $quantiteTotaleDesLignesDeFraisForfait)
    {
        $montant = 0;
        $req = "SELECT montant FROM fraisforfait WHERE libelle = '$libelleFraisForfait';";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignesDeMontant = $res->fetchAll();

        $montant = $lesLignesDeMontant[0][0]; // Première valeur de la première ligne
        $montant = $quantiteTotaleDesLignesDeFraisForfait * $montant;

        return $montant;
    }

    /**
     * Met à jour la table lignefraisforfait pour un acteur et un mois donné en enregistrant les nouveaux montants
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @param $lesFrais array tableau associatif de clé idFrais et de valeur la quantité pour ce frais
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais)
    {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $req = "UPDATE lignefraisforfait SET lignefraisforfait.quantite = $qte
			WHERE lignefraisforfait.idvisiteur = '$idVisiteur' AND lignefraisforfait.mois = '$mois'
			AND lignefraisforfait.idfraisforfait = '$unIdFrais'";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * Met à jour le nombre de justificatifs de la table fichefrais
     * pour le mois et l'acteur concerné
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @param $nbJustificatifs int Le nombre de justificatif
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs)
    {
        $req = "UPDATE fichefrais SET nbjustificatifs = $nbJustificatifs
		WHERE fichefrais.idvisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais
     *
     * Modifie le champ idEtat et met la date de modif à aujourd'hui
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat)
    {
        $req = "UPDATE fichefrais SET idEtat = '$etat', dateModif = now()
		WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Permet de mettre à jour un frais forfaitisé
     *
     * @param $idFraisBase mixed L'ID du frais de base
     * @param $idForfait mixed L'ID du frais forfait
     * @param $libelleForfait mixed Le libelle du frais forfait
     * @param $montantForfait mixed Le montant du frais forfait
     */
    public function updateFraisForfait($idFraisBase, $idForfait, $libelleForfait, $montantForfait)
    {
        $req = "UPDATE fraisforfait SET id = '$idForfait', libelle = '$libelleForfait', montant = '$montantForfait'
		WHERE fraisforfait.id ='$idFraisBase'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Permet de modifier le mot de passe de l'utilisateur en base de données
     * On modifie la colonne "oldMdp" afin de pouvoir dans le cadre du développement du site, ne pas oublier les mot de passe..
     *
     * @param $login string Le login de l'utilisateur qui veut modifier son mot de passe
     * @param $mdp string Le nouveau mot de passe de l'utilisateur (pas encore crypté)
     */
    public function updateMDP($login, $mdp)
    {
        $mdpCrypte = sha1($mdp);
        $req = "UPDATE acteur SET oldMdp = '$mdp', mdp = '$mdpCrypte' WHERE login = '$login'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument
     *
     * @param $idFrais int L'ID de la fiche de frais
     */
    public function supprimerFraisHorsForfait($idFrais)
    {
        $req = "DELETE FROM lignefraishorsforfait WHERE lignefraishorsforfait.id =$idFrais ";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Permet de supprimer un frais forfaitisé
     *
     * @param $id mixed L'ID du frais forfait
     */
    public function deleteFraisForfait($id)
    {
        $req = "DELETE FROM fraisforfait WHERE fraisforfait.id = '$id'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Supprime le frais forfait dont l'id est passé en argument
     *
     * @param $idFrais int L'ID de la fiche de frais
     */
    public function supprimerLigneFraisForfait($idFrais)
    {
        $req = "DELETE FROM lignefraisforfait WHERE lignefraisforfait.id =$idFrais ";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Créée une nouvelle fiche de frais et les lignes de frais au forfait pour un acteur et un mois donné
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
     * avec un idEtat à 'CR'
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois)
    {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $req = "INSERT INTO fichefrais(idvisiteur, mois, nbJustificatifs, montantValide, dateModif, idEtat)
		VALUES('$idVisiteur', '$mois', 0, 0, now(), 'CR')";
        PdoGsb::$monPdo->exec($req);

        /*$lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idfrais'];
            $req = "INSERT INTO lignefraisforfait(idvisiteur, mois, idFraisForfait, quantite)
			VALUES('$idVisiteur', '$mois', '$unIdFrais', 0)";
            PdoGsb::$monPdo->exec($req);
        }*/
    }

    /**
     * Créée un nouveau frais hors forfait pour un acteur et un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @param $libelle : le libelle du frais
     * @param $date : la date du frais au format français jj//mm/aaaa
     * @param $montant : le montant
     */
    public function creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant)
    {
        $dateEn = dateFrancaisVersAnglais($date);
        $req = "INSERT INTO lignefraishorsforfait
		VALUES(DEFAULT,'$idVisiteur','$mois','$libelle','$dateEn','$montant')";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Créée un nouveau frais forfaitisé pour un acteur et un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param $idVisiteur int L'identifiany du visiteur
     * @param $mois string Le mois de la fiche de frais
     * @param $idFrais int L'identifiant de la fiche de frais
     * @param $description string La description de la fiche de frais
     * @param $quantite int La quantité de la fiche de frais
     */
    public function creeNouveauFraisForfait($idVisiteur, $mois, $idFrais, $quantite, $description, $dateDeLaDepense)
    {
        $dateEn = dateFrancaisVersAnglais($dateDeLaDepense);
        $req = "INSERT INTO lignefraisforfait(idVisiteur,mois,idFraisForfait,quantite,description,dateFraisForfait)
		VALUES('$idVisiteur',$mois,'$idFrais',$quantite,'$description','$dateEn')";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Permet l'ajout d'un frais forfait
     *
     * @param $idForfait String L'id du frais forfait
     * @param $libelleForfait String Le libelle du frais forfait
     * @param $montantForfait Float(5,2) Le montant du frais forfait
     */
    public function addFraisForfait($idForfait, $libelleForfait, $montantForfait)
    {
        $req = "INSERT INTO fraisforfait(id, libelle, montant) VALUES ('$idForfait','$libelleForfait','$montantForfait')";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Teste si un acteur possède une fiche de frais pour le mois passé en argument
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @param $mois String sous la forme aaaamm
     * @return Boolean Vrai ou faux
     */
    public function estPremierFraisMois($idVisiteur, $mois)
    {
        $ok = false;
        $req = "SELECT count(*) AS nblignesfrais FROM fichefrais
		WHERE fichefrais.mois = '$mois' AND fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        if ($laLigne['nblignesfrais'] == 0) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Retourne le dernier mois en cours d'un acteur
     *
     * @param $idVisiteur int L'ID de l'acteur
     * @return String le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur)
    {
        $req = "SELECT max(mois) AS dernierMois FROM fichefrais WHERE fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Permet de savoir si le login saisi par l'utilisateur est correct
     *
     * @param $login string Le login de l'utilisateur
     * @return $estLoginExistant bool Vrai si le login existe, faux dans le cas contraire
     */
    public function estLoginExistant($login)
    {
        // Création de la requête
        $req = "SELECT login FROM acteur WHERE login='$login'";
        // Exécution de la requête
        $res = PdoGsb::$monPdo->query($req);
        // Stockage de la requête
        $leLogin = $res->fetch();
        // Déclaration et initialisation de la variable qui sera retournée par la fonction
        $estLoginExistant = false;
        // On vérifie que le login passé en paramètre correspond à celui retourné par la base de données
        if ($leLogin['login'] == $login) {
            $estLoginExistant = true;
        }
        // On retourne vrai si le login a été trouvé ou faux dans le cas contraire
        return $estLoginExistant;
    }

    /**
     * Permet de savoir si la réponse à la question secrete données est correct ou non
     *
     * @param $login string Le login de l'utilsateur
     * @param $repQuestion string La réponse à la question secrète données par l'utilisateur
     * @return $estReponseCorrect bool Vrai si la réponse saisi est celle présente en BDD, faux dans le cas contraire
     */
    public function estReponseCorrect($login, $repQuestion)
    {
        $req = "SELECT questionSecrete FROM acteur WHERE login='$login'";
        $res = PdoGsb::$monPdo->query($req);
        $laQuestionSecrete = $res->fetch();
        $estReponseCorrect = false;
        if ($laQuestionSecrete['questionSecrete'] == $repQuestion) {
            $estReponseCorrect = true;
        }
        return $estReponseCorrect;
    }

    /**
     * Permet de vérifier si une fiche de frais existe en base de données
     *
     * @param $idVisiteur string L'ID du visiteur associé à la fiche de frais
     * @param $mois string Le mois où la fiche de frais a été créée
     * @param $idFrais string L'ID de la fiche de frais
     * @return $resultat bool Vrai si la fiche de frais existe, faux dans le cas contraire
     */
    public function estFicheForfaitExistante($idVisiteur, $mois, $idFrais)
    {
        $req = "SELECT idVisiteur, mois, idFraisForfait FROM ligneFraisForfait WHERE idVisiteur ='$idVisiteur' AND mois = '$mois' AND idFraisForfait = '$idFrais'";
        $res = PdoGsb::$monPdo->query($req);
        $resultat = $res->fetch();
        if ($resultat != false)
            $resultat = true;
        return $resultat;
    }
}
