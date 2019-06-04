<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajout Association</title>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <script src="libs/jquery/jquery-3.3.1.min.js"></script>
	<script src="libs/bootstrap/js/bootstrap.min.js"></script>



    <style>
        .btn-vert {
            color: #FFFFFF;
            background-color: #33CABB;
            border-color: #33CABB;
        }

        .btn-vert:hover,
        .btn-vert:focus,
        .btn-vert:active,
        .btn-vert.active,
        .open .dropdown-toggle.btn-vert {
            color: #FFFFFF;
            background-color: #31BFB1;
            border-color: #33CABB;
        }

        .btn-vert:active,
        .btn-vert.active,
        .open .dropdown-toggle.btn-vert {
            background-image: none;
        }

		.centre {
		margin: 0 auto;
		width: 1000px;
		}
    </style>
</head>

<body>
	<?php
        include('include/header.inc');
        include('./include/connect.inc');
        $idc = connect();
    ?>
	<br>
	<div class="description_page centre">
		<p>Cette page vous permettra d'ajouter en base de données une association. Veillez à bien remplir tous les champs</p>
	</div>
	<br>
	<div class="container">
		<div class="row formulaire">
		    <div class="col-sm">
			<!-- Gauche -->
		    </div>
			<div class="col-sm">
			<!-- Millieu -->
			<form id="ajout_assoc">
				<div class="form-group">
					<label for="nomAssociation">Nom de l'association</label>
					<input type="text" class="form-control" id="nom" placeholder="nom@example.fr">
				</div>
				<div class="form-group">
					<label for="addresseAssociation">Adresse</label>
					<input type="text" class="form-control" id="addresse" placeholder="1 rue des églantiers">
				</div>
				<div class="form-group">
					<label for="cpAssociation">Code postal</label>
					<input type="number" class="form-control" id="codepostal" placeholder="11300">
				</div>
				<div class="form-group">
					<label for="villeAssociation">Ville</label>
					<input type="text" class="form-control" id="ville" placeholder="Bram">
				</div>
				<div class="form-group">
					<label for="descriptionAssociation">Description de l'association</label>
					<textarea class="form-control" id="description" rows="3"></textarea>
				</div>
				<div class="form-group">
					<label for="telephoneAssociation">N° de téléphone</label>
					<input type="tel" class="form-control" id="telephone" placeholder="0606480648">
				</div>
				<div class="form-group">
					<label for="directeurAssociation">Identité du directeur</label>
					<input type="text" class="form-control" id="directeur" placeholder="Claude Dupont">
				</div>
				<div class = "form-group">
					<input type="submit" name="submit" class=" btn btn-vert btn-block" value="Valider">
				</div>
			</form>
			</div>
			<div class="col-sm">
			<!-- Droite -->
			</div>
		</div>
	</div>
    <script type="text/javascript">
        $.post('requetes/add_association.php',
            {
                nom : $("#nom").html(),
                adresse: $("#adresse").html(),
                cp : $("#codepostal").html(),
                ville : $("#ville").html(),
                desc : $("#description").html(),
                tel : $("telephone").html(),
                directeur : $("#directeur").html(),
            },
            function data() {
                if (data == 'ok') {
                    alert("Ajout effectué");
                }
                else {
                    alert("Erreur !");
                }
            }
        );
        if (1 == 1)
        {

        }
    </script>

</body>

</html>
