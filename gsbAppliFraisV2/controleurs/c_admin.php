<?php
include("vues/v_sommaireAdmin.php");
$action = $_REQUEST['action'];
switch($action){
    case 'selectionnerCRUD': {
        include("vues/v_adminCRUD.php");

    }

}