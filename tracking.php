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
			height: 800px;
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
			<option value = "0" >Veuillez selectionnez un particpant actuellement en ligne</option>
            <?php
                while($ligne = pg_fetch_assoc($resultat)) {
                    print('<option value="'.$ligne['id_individu'].'">'.$ligne['prenom_p'].' '.$ligne['nom_p'].'</option>');
                }
            ?>
        </select>
        <br>
		<div id ="carte" class ="carte"></div>
        <script>

			// create a style to display our position history (track)
			var trackStyle = new ol.style.Style({
				stroke: new ol.style.Stroke({
				color: 'rgba(0,0,255,1.0)',
				width: 3,
				lineCap: 'round'
				})
			});
			// use a single feature with a linestring geometry to display our track
			var trackFeature = new ol.Feature({
				geometry: new ol.geom.LineString([])
			});
			// we'll need a vector layer to render it
			var trackLayer = new ol.layer.Vector({
				source: new ol.source.Vector({
					features: [trackFeature]
				}),
				style: trackStyle
				});

			var baseLayer = new ol.layer.Tile({
				source: new ol.source.OSM()
			});

			// Vue
			var view = new ol.View({
				center: [2.113409, 43.243515],
				zoom: 17,
				maxZoom: 19,
				projection: 'EPSG:4326',
			});
			// Carte avec un fonds de carte
			var map = new ol.Map({
				layers: [baseLayer, trackLayer],
				target: 'carte',
				view: view,
			});
			// Objet géographique de la position de géolocalisation
			var ObjPosition = new ol.Feature();
			// Attribution d'un style à l'objet
			ObjPosition.setStyle(new ol.style.Style({
				image: new ol.style.Circle({
					radius: 6,
					fill: new ol.style.Fill({
						color: '#3399CC'
					}),
					stroke: new ol.style.Stroke({
						color: '#fff',
						width: 2
					})
				})
			}));

			//Obtention des infos de tracking
			// var id_point = 0;
			// var coordonnees = [];

			function showOnline(option) {
				var id_point = 0;
				coordonnees = [];
				test = [];
	            $.post('./actions/get_online.php',
	                {
					    option: option,
					    id_point: id_point,
					},
	                function(data) {
	                    // Décode du JSON le résultat
						if (option != 0) {
							JSON.parse(data).forEach((ligne) => {
								// console.log(ligne);
								coordonnees[0] = (ligne.longitude);
								coordonnees[1] = (ligne.latitude);
								view.setCenter(coordonnees);
								ObjPosition.setGeometry( coordonnees ? new ol.geom.Point(coordonnees) : null );
		        				trackFeature.getGeometry().appendCoordinate(coordonnees);


							});

						}
					}
	        	);
			}
			// Source du vecteur contenant l'objet géographique
			var sourceVecteur = new ol.source.Vector({
					features: [ObjPosition]
			});
			// Couche vectorielle
			var vecteur = new ol.layer.Vector({
				map: map,
				source: sourceVecteur
			});

        </script>

    </body>
</html>
