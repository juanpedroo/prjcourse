<?php
session_start();
include 'includes/header.inc';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Zoom sur la géolocalisation</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<meta charset="utf-8">
		<link rel="stylesheet" href="lib/ol3/ol.css" type="text/css">
		<script src="lib/ol3/ol.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="styles/navbar.css">
		<script src="lib/jquery/jquery-3.3.1.min.js"></script>
		<script src="lib/bootstrap/js/bootstrap.min.js"></script>
		<script src="chrono.js"></script>
		<style>
			.carte {
			height: 400px;
			width: 100%;
			}
  		</style>
	</head>
	<body>
	<div class="container">

		<div class="row map">
			<div class="col-md-3"></div>
			<div class="col-md-6"></div>
				<div id ="carte" class ="carte"></div>
			<div class="col-md-3"></div>
		</div>

		<div id="stats"class="row stats">
	        <div id="durée" class="durée col-md-offset-1 col-md-1">0:00:00</div>
	        <div id="distance" class="distance col-md-1"></div>
	        <div id="allure" class="allure col-md-1"></div>
	        <div id="vitesse" class="vitesse col-md-1"></div>
	        <div id="vmax" class="vmax col-md-1"></div>
	        <div id="vmin" class="vmin col-md-1"></div>
	        <div id="vmoy" class="vmoy col-md-1"></div>
	        <div id="altmin" class="altmin col-md-1"></div>
	        <div id="altmax" class="altmax col-md-1"></div>
	        <div id="altmoy" class="altmoy col-md-1"></div>
    	</div>

		<div class="row bouttons">
			<div class="col-md-3"></div>
			<div class="col-md-6"></div>
			<div class="col-md-3"></div>
		</div>
	</div>

		<script>

			var cpt = 0; // initialisation compteur tableau start;
			var start = []; // initialisation tableau dateHeure
			var latOld;
			var longOld;
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
			});
			// Carte avec un fonds de carte
			var map = new ol.Map({
				layers: [baseLayer, trackLayer],
				target: 'carte',
				view: view
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

			window.onload = chronoStart(); /* TIMER TODO : Quand clic sur start démarrrer */

			// Géolocalisation

			var geolocation = new ol.Geolocation({
			  // On déclenche la géolocalisation
			  tracking: true,
			  // enableHighAccuracy: true, // fout la merde
			  // Important : Projection de la carte
			  projection: view.getProjection()
			});
			// On scrute les changements des propriétés
			geolocation.on('change', function(evt) {

				var position = geolocation.getPosition();
				// On transforme la projection des coordonnées
				var newPosition=ol.proj.transform(position, 'EPSG:3857', 'EPSG:4326');
				$("#latitude").html(newPosition[1]);
				$("#longitude").html(newPosition[0]);

				// Attribution de la géométrie de ObjPosition avec les coordonnées de la position
				ObjPosition.setGeometry( position ? new ol.geom.Point(position) : null );
				var precision = geolocation.getAccuracy();
				$("#precision").html(precision);


				var lat = newPosition[1];
				var long = newPosition[0];

				// On affiche les stats sur la page
				// vitesse
				var speed = 3.6 * geolocation.getSpeed() || 0;
				$(".vitesse").html(speed);

				//Distance parcourue
				if (cpt > 2) {
				$(".distance").html(distance)
				console.log("Ancien lat : " + latOld + " Nv lat : "+ lat
				+ "\nAncien long : " + longOld + " Nv long : " + long);
				}
				latOld = lat;
				longOld = long;





				// Centre la carte sur notre position
				view.setCenter(position);
				trackFeature.getGeometry().appendCoordinate(position);



				// Envoi des infos de géolocalisation
				$.post('actions/insertgeocoord.php',
					{
						lat: lat,
						long: long,
						precision: geolocation.getAccuracy(),
						direction: geolocation.getHeading() || 0,
						altitude: geolocation.getAltitude() || 0,
						vitesse: (3.6 * geolocation.getSpeed()) || 0,
					},
					function(data) {
						start[cpt] = data;

						cpt = cpt + 1;

					}

				);

			});
			// On alerte si une erreur est trouvée
			geolocation.on('error', function(erreur) {
				alert('Echec de la géolocalisation : ' +erreur.message);
			});
			// Source du vecteur contenant l'objet géographique
			var sourceVecteur = new ol.source.Vector({
					features: [ObjPosition]
			});
			// Couche vectorielle
			var vecteur = new ol.layer.Vector({
				map: map,
				source: sourceVecteur
			});
			// // Zoom sur l'emprise du vecteur
			// sourceVecteur.once('change', function(evt){
			// 	// On vérifie que la source du vecteur sont chargés
			// 	if (sourceVecteur.getState() === 'ready') {
			// 		// On vérifie que le veteur contient au moins un objet géographique
			// 		if (sourceVecteur.getFeatures().length >0) {
			// 			// On adapte la vue de la carte à l'emprise du vecteur
			// 			map.getView().fit(sourceVecteur.getExtent(), map.getSize());
			// 		}
			// 	}
			// });
		</script>
	</body>
</html>
