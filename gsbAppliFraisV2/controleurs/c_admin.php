<?php
include("vues/v_sommaireAdmin.php");
$action = $_REQUEST['action'];
switch($action){
    case 'selectionnerCRUD': {
        include("vues/v_adminCRUD.php");
        ;break;
    }
    case 'choixCRUD': {
                    if ($_POST['CRUD'] = "create")
                    {
                        include("vues/vuesCRUD/v_create.php");
                    } else if ($_POST['CRUD'] = "read")
                    {
                        include("vues/vuesCRUD/v_read.php");
                    } else if ($_POST['CRUD'] = "update")
                    {
                        include("vues/vuesCRUD/v_update.php");
                    }else if ($_POST['CRUD'] = "delete")
                    {
                        include("vues/vuesCRUD/v_delete.php");
                    }
        ;break;

    }

}