<?php
require_once("../gsbAppliFraisV2/include/fct.inc.php");
require_once ("../gsbAppliFraisV2/include/class.pdogsb.inc.php");

session_start();
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
                        <legend>Saissisez votre login</legend>
                        <form method="post" action="index.php?uc=connexion&action=valideConnexion">
                            <input name="login" class="form-control" type="text" placeholder="Login">
                            </br>
                            <input type="submit" class="btn btn-primary signup" value="Réinitialiser le mot de passe">
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
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
<?php
echo "SCHEISS !";

// Utiliser sendmail et fonction mail() pour envoyer un mail à l'utilisateur lors de l'envoie du mail
// Comprendre pour redirection WTF lors du clic sur le bouton

?>