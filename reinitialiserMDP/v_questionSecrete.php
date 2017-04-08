<?php
/**
 * Cette page permet à l'utilisateur de saisir la réponse à sa question secrète, qui lui permettra
 * de réinitialiser son mot de passe
 */

require_once("../gsbAppliFraisV2/include/fct.inc.php");
require_once("../gsbAppliFraisV2/include/class.pdogsb.inc.php");


$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Admin Theme v3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../gsbAppliFraisV2/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="../gsbAppliFraisV2/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body background="../gsbAppliFraisV2/assets/img/laboratoire.jpg">
<div class="page-content container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-wrapper">
                <div class="box">
                    <div class="content-wrap">
                        <legend>Quel est le nom de la meilleure entreprise du monde ?</legend>
                        <!-- On indique l'action qui doit suivre l'action de cliquer sur le bouton -->
                        <form method="post" action="../gsbAppliFraisV2/index.php?uc=connexion&action=repQuesionSecrete" role='form'>
                            <input name="laReponse" id="laReponse" class="form-control" type="text" placeholder="La réponse à votre question secrète">
                            </br>
                            <input type="submit" class="btn btn-primary" name="repQuestion" value="Valider votre réponse">
                            </br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../gsbAppliFraisV2/bootstrap/js/bootstrap.min.js"></script>
<script src="../gsbAppliFraisV2/js/custom.js"></script>
</body>
</html>
