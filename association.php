<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Association</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <?php
        $nomassoc = "";
        $adrassoc = "";
        $cpassoc = "";
        $villeassoc = "";
        $descrassoc = "";
        $telassoc = "";
        $dirassoc = "";
        include('./includes/connect.inc');
        $idc = connect();

        $sql = 'select nom_asso, adresse_asso, cp_asso, ville_asso, description_asso,tel_asso, nom_directeur_asso from association where asso_check = true';
        $resultat = pg_exec($idc, $sql);
        while($ligne = pg_fetch_assoc($resultat)) {
            $nomassoc = $ligne['nom_asso'];
            $adrassoc = $ligne['adresse_asso'];
            $cpassoc = $ligne['cp_asso'];
            $villeassoc = $ligne['ville_asso'];
            $descrassoc = $ligne['description_asso'];
            $telassoc = $ligne['tel_asso'];
            $dirassoc = $ligne['nom_directeur_asso'];
        }


    ?>

    <p> Cette année, c'est l'association <?php echo $nomassoc;?> présidé par <?php echo $dirassoc ?> qui est la bénéficiaire de notre course</p>
    <p> Voici quelques mots laissés par l'association </p>
    <?php echo $descrassoc;?>
    <p> Vous trouverez les coordonnées ci-dessous </p>
    <?php
        echo $adrassoc. "<br>";
        echo $cpassoc. " ". $villeassoc."<br>";
        echo $telassoc;
    ?>
</body>
</html>
