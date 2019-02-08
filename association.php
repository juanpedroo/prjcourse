<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Navbar Dropdown Login and Signup Form with Social Buttons</title>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="styles/navbar.css">
<script src="lib/jquery/jquery-3.3.1.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
	// Prevent dropdown menu from closing when click inside the form
	$(document).on("click", ".navbar-right .dropdown-menu", function(e){
		e.stopPropagation();
	});
</script>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <?php
        include 'includes/header.inc';
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
