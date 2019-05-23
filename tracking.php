<?php
session_start();
include('includes/header.inc');
include('./includes/connect.inc');
$idc = connect();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TRacking des participants</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<meta charset="utf-8">
		<link rel="stylesheet" href="lib/ol3/ol.css" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="lib/bootstrap/css/bouton-cercle.css">
		<link rel="stylesheet" href="styles/navbar.css">
		<link rel="stylesheet" href="styles/centerdiv.css">
		<link rel="stylesheet" href = "lib/fontawesome/css/all.min.css">
		<script src="lib/easytimer/easytimer.min.js"></script>
		<script src="lib/ol3/ol.js"></script>
		<script src="lib/jquery/jquery-3.3.1.min.js"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js"></script>

		<style>
			.carte {
			height: 400px;
			width: 100%;
			}
  		</style>
	</head>
	<body>
        <?php
						$sql0= "UPDATE public.individu
										SET online = 'deconnecte'
										WHERE now() - last_activity > '00:01:00.00'";
						pg_exec($idc,$sql0);

            $sql = "SELECT id_individu, nom_p, prenom_p
            FROM public.individu
            WHERE online = 'connecte' or online = 'pause'";
            $resultat = pg_exec($idc, $sql);
        ?>
        <select id="online" name="online" onchange="showOnline(this.value)" class="form-control">
            <?php
                while($ligne = pg_fetch_assoc($resultat)) {
                    print('<option value="'.$ligne['id_individu'].'">'.$ligne['prenom_p'].' '.$ligne['nom_p'].'</option>');
                }
            ?>
        </select>
        <br>
        <script>
				function showAssos(option) {
            $.post('./actions/get_online.php',
                { id_indvidu: option },

                // Fonction quand success
                function(data) {
                    // Décode du JSON le résultat
                    var res = JSON.parse(data);
                    // Affectation des nouvelles valeurs
                    $('#nom_asso')[0].innerHTML = res['nom_asso'];
                    $('#adresse_asso')[0].innerHTML = res['adresse_asso'];
                    $('#cp_asso')[0].innerHTML = res['cp_asso'];
                    $('#ville_asso')[0].innerHTML = res['ville_asso'];
                    $('#description_asso')[0].innerHTML = res['description_asso'].substring(0, 25) + ' ';
                    $('#tel_asso')[0].innerHTML = res['tel_asso'];
                    $('#nom_directeur_asso')[0].innerHTML = res['nom_directeur_asso'];
								}
        		);
				}

        </script>

    </body>
</html>
