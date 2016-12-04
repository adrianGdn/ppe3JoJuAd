<?php
include("vues/v_sommaireAdmin.php");
$action = $_REQUEST['action'];
switch($action){
    case 'selectionnerCRUD': {
        include("vues/v_adminCRUD.php");

    } break;

    case 'ajoutFraisForfait': {
        $idFrais = $_POST['ID'];
        $libelleFrais = $_POST['libelle'];
        $montantFrais = $_POST['montant'];
        $pdo->addFraisForfait($idFrais, $libelleFrais, $montantFrais);

    } break;

    case 'choixCRUD': {
        switch ($_POST['choixCRUD']) {
            case 'create': {
                include("vues/vuesCRUD/v_create.php");
            }
                break;
            case 'read': {
                include("vues/vuesCRUD/v_read.php");
            }
                break;
            case 'update': {
                include("vues/vuesCRUD/v_update.php");
            }
                break;
            case 'delete': {
                include("vues/vuesCRUD/v_delete.php");
            }
                break;

        }
        break;

    }
}