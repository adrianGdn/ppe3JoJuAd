<?php
if($_SESSION['typeActeur'] == 'Administrateur') {
    include("vues/v_sommaireAdmin.php");
}
else {
    include("vues/v_sommaire.php");
}

echo "TEST1";
$lesPuissances = $pdo->getLesPuissances();
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
    case 'CRUDVehicule':{
            include("vues/v_createVehicule.php");
            echo "TEST2";
            break;
    }
    case 'creerVehicule': {
        $libelleFrais = $_POST['libelle'];
        $immatriculation = $_POST['immatriculation'];
        $puissanceVehicule = $_POST['puissanceVehicule'];
        $pdo->createVehicule($libelleFrais, $immatriculation, $puissanceVehicule, $idVisiteur);
        echo "TEST3";
        break;
    }
}

echo "TEST4";DIE;
?>
