<?php
session_start();
include 'include/header.inc';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Zoom sur la géolocalisation</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<meta charset="utf-8">
		<link rel="stylesheet" href="libs/ol3/ol.css" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="libs/bootstrap/css/bouton-cercle.css">
		<link rel="stylesheet" href="css/navbar.css">
		<link rel="stylesheet" href="css/centerdiv.css">
		<link rel="stylesheet" href = "libs/fontawesome/css/all.min.css">
		<script src="libs/easytimer/easytimer.min.js"></script>
		<script src="libs/jquery/jquery-3.3.1.min.js"></script>
		<script src="libs/ol3/ol.js"></script>

		<script src="libs/bootstrap/js/bootstrap.min.js"></script>
		<script src="cookie.js"></script>

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

		<div class="row stats-gen-libelle">
		   <div class="col-md-4 center-text">Durée <i class="far fa-clock"></i></div>
		   <div class="col-md-4 center-text">Distance <i class="fas fa-ruler-horizontal"></i></div>
		   <div class="col-md-4 center-text">Allure <i class="fas fa-running"></i></div>
   		</div>
		<div class="row stats-gen">
		   <div id="durée" class="durée col-md-4 center-text"><h4>00:00:00</h4></div>
		   <div id="distance" class="distance col-md-4 center-text"><h4>0 m</h4></div>
		   <div id="allure" class="allure col-md-4 center-text"><h4>00"00</h4></div>
   		</div>
		<br>
		<div class="row stats-vitesse-libelle">
		   <div class="col-md-3 center-text">Vitesse <img src="css/speedometer.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Max <img src="css/fast.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Min <img src="css/slow.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Moy <img src="css/speedometer_avg.svg" height="20px" width="20px"></div>
   		</div>
   		<div class="row stats-vitesse">
		   <div id="vitesse" class="vitesse col-md-3 center-text"><h4>0 km/h</h4></div>
		   <div id="vmax" class="vmax col-md-3 center-text"><h4>0 km/h</h4></div>
		   <div id="vmin" class="vmin col-md-3 center-text"><h4>0 km/h</h4></div>
		   <div id="vmoy" class="vmoy col-md-3 center-text"><h4>0 km/h</h4></div>
   		</div>
		<br>
		<div class="row stats-altitude-libelle">
		   <div class="col-md-3 center-text">Altitude <i class="fa fa-tachometer-alt"></i></div>
		   <div class="col-md-3 center-text">Altitude Min <i class="fas fa-arrow-down"></i></div>
		   <div class="col-md-3 center-text">Altitude Max <i class="fas fa-arrow-up"></i></div>
		   <div class="col-md-3 center-text">Altitude Moy <i class="fas fa-arrow-right"></i></div>
	   	</div>
	   	<div class="row stats-altitude">
		   <div id="alt" class="alt col-md-3 center-text"><h4>0 m</h4></div>
		   <div id="altmin" class="altmin col-md-3 center-text"><h4>0 m</h4></div>
		   <div id="altmax" class="altmax col-md-3 center-text"><h4>0 m</h4></div>
		   <div id="altmoy" class="altmoy col-md-3 center-text"><h4>0 m</h4></div>
	   	</div>
		<br>
		<div class="row bouttons">
			<div id="start" class="start col-md-3">
				<button type="button" class="btn btn-success btn-circle btn-xl">
					<i class="fa fa-play"></i>
                </button>
			</div>
			<div id="pause" class="pause col-md-6">
				<button type="button" class="btn btn-warning btn-circle btn-xl">
					<span style="color: white;">
  						<i class="fa fa-pause"></i>
					</span>
                </button>
			</div>
			<div id="stop" class="stop col-md-3">
				<button type="button" class="btn btn-danger btn-circle btn-xl onclick=">
					<i class="fa fa-stop"></i>
                </button>
			</div>
		</div>
	</div>

		<script>


			var cpt = 0; // initialisation compteur tableau start;
			var cptDist = 0;
			var tabDate = []; // initialisation tableau dateHeure
			var lat = 0.0;
			var long = 0.0;
			var latOld = 0.0;
			var longOld = 0.0;
			var distance = [];
			var total = 0.0;
			var totalKM = 0.0;
			var hr;
			var min;
			var sec;
			var tabSpeed = [];
			var cptSpeed = 0;
			var speed = 0;
			var vmax = speed;
			var vmin = 9999;
			var vmoy = 0;
			var tabAlt = [];
			var cptAlt = 0;
			var alt = 0;
			var altmax = alt;
			var altmin = 9999;
			var altmoy = 0;
			var timerInstance = new easytimer.Timer();
			var online;
			var dateFin;
			var dateDeb;
			var etat ="";




			function calcCrow(lat1, lon1, lat2, lon2)
    		{
			    var R = 6371; // km
			    var dLat = toRad(lat2-lat1);
			    var dLon = toRad(lon2-lon1);
				var lat1 = toRad(lat1);
			    var lat2 = toRad(lat2);

			    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
			    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
			    var d = R * c * 1000; // Mètres
				var dKM = d / 1000; // Kilomètres
			    return d;
    		}

			// Converts numeric degrees to radians
			function toRad(Value)
			{
				return Value * Math.PI / 180;
			}

			function calculatePace(dist, hrs, mins, secs) {
			    //console.log(dist, hrs, mins, secs);
			    dist = parseFloat(dist), hrs = parseFloat(hrs), mins = parseFloat(mins), secs = parseFloat(secs);
			    //console.log(dist);
			    var pace;
			    var timeElapsed = 0;
			    timeElapsed += hrs*60*60;
			    timeElapsed += mins*60;
			    timeElapsed += secs;
			    var calculatedPace = Math.floor(timeElapsed/dist*1000);
			    //console.log(calculatedPace);
			    var paceMins = Math.floor(calculatedPace/60);
			    var paceSecs = calculatedPace - (paceMins*60);
			    pace = paceMins + '"' + paceSecs;
			    return pace;
			}
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
				zoom: 19,
				maxZoom: 23,
			});
			// Carte avec un fond de carte
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


			// Géolocalisation
			var geolocation = new ol.Geolocation({
			  // On déclenche la géolocalisation
			  tracking: true,
			  // enableHighAccuracy: true, // fout la merde
			  // Important : Projection de la carte
			  projection: view.getProjection()
			});

			$( "#start" ).click(function() {

				trackLayer.getSource().removeFeature(trackFeature);
				trackFeature = new ol.Feature({
					geometry: new ol.geom.LineString([])
				});
				trackLayer.getSource().addFeature(trackFeature);


  				//requetes
				if (online = "deconnecte") {
					cpt = 0;
					cptDist = 0;
					tabDate = []; // initialisation tableau dateHeure
					lat = 0.0;
					long = 0.0;
					latOld = 0.0;
					longOld = 0.0;
					distance = [];
					total = 0.0;
					totalKM = 0.0;
					hr = 0;
					min = 0;
					sec = 0;
					tabSpeed = [];
					cptSpeed = 0;
					speed = 0;
					vmax = speed;
					vmin = 9999;
					vmoy = 0;
					tabAlt = [];
					cptAlt = 0;
					alt = 0;
					altmax = alt;
					altmin = 9999;
					altmoy = 0;
					dateFin = 0;
					dateDeb = 0;
					etat = "";
					allureCalc=0;
				}
				online = "connecte";
				$.post('requetes/setonline.php',
					{
						online: online,
					},
					function(data) {
					}
				);




				timerInstance.start();
				etat = "start";


				geolocation.setTracking(true);
				// On scrute les changements des propriétés
				geolocation.on('change', function(evt) {

					online = "connecte";
					$.post('requetes/setonline.php',
						{
							online: online,
						},
						function(data) {
						}
					);

					position = geolocation.getPosition();

					// On transforme la projection des coordonnées
					var newPosition=ol.proj.transform(position, 'EPSG:3857', 'EPSG:4326');
					// $("#latitude").html(newPosition[1]);
					// $("#longitude").html(newPosition[0]);

					// Attribution de la géométrie de ObjPosition avec les coordonnées de la position
					ObjPosition.setGeometry( position ? new ol.geom.Point(position) : null );
					var precision = geolocation.getAccuracy();
					//$("#precision").html(precision);

					lat = newPosition[1];
					long = newPosition[0];

					// On affiche les stats sur la page
					// vitesse instant vmax et vmin et vmoy
					speed = 3.6 * geolocation.getSpeed() || 0;
					$(".vitesse").html("<h4>"+ speed.toFixed(2) + " km/h</h4>");
					$(".vmax").html("<h4>"+vmax.toFixed(2)+" km/h</h4");
					$(".vmin").html("<h4>"+vmin.toFixed(2)+" km/h</h4");
					$(".vmoy").html("<h4>"+vmoy.toFixed(2)+" km/h</h4");
					if (vmin > speed){
						vmin = speed;
					}
					if (vmax < speed) {
						vmax = speed;
					}
					tabSpeed[cptSpeed] = speed;
					cptSpeed++;

					for (var i = 0; i<tabSpeed.length;i++) {
						vmoy += tabSpeed[i];
					}
					vmoy = vmoy / tabSpeed.length;

					//Distance parcourue
					if (latOld == 0 || longOld == 0) {
						$(".distance").html("<h4>0 m</h4>");
					}
					else if (lat != latOld || long != longOld){
						//This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
						distance[cptDist] = parseFloat(calcCrow(lat, long, latOld, longOld).toFixed(1));
						total += distance[cptDist];
						totalKM += distance[cptDist] /1000;
						cptDist++;
					}
					if(total < 1000) {
						$(".distance").html("<h4>"+total.toFixed(0)+" m</h4>");
					}
					else {
						$(".distance").html("<h4>"+totalKM.toFixed(1)+" km</h4>");
					}
					latOld = lat;
					longOld = long;

					//allure
					//hr = parseInt($(".durée").html().substring(0,3));
					hr = $(".durée").html().substring(4,6);
					//min = parseInt($(".durée").html().substring(3,5));
					min = $(".durée").html().substring(7,9);
					//sec = parseInt($(".durée").html().substring(6,8));
					sec = $(".durée").html().substring(10,12);
					console.log(hr + "&"+ min + "&" + sec);
					allureCalc = calculatePace(total, hr, min,sec);
					$(".allure").html("<h4>"+allureCalc+ "</h4>");

					// altitude act, min, max, moy
					alt = geolocation.getAltitude() || 0;
					$(".alt").html("<h4>"+alt.toFixed(0)+" m</h4");
					$(".altmax").html("<h4>"+altmax.toFixed(0)+" m</h4");
					$(".altmin").html("<h4>"+altmin.toFixed(0)+" m</h4");
					$(".altmoy").html("<h4>"+altmoy.toFixed(0)+" m</h4");
					if (altmin > alt){
						altmin = alt;
					}
					if (altmax < alt) {
						altmax = alt;
					}
					tabAlt[cptAlt] = alt;
					cptAlt++;

					for (var i = 0; i<tabAlt.length;i++) {
						altmoy += tabAlt[i];
					}
					altmoy = altmoy / tabAlt.length;

					// Centre la carte sur notre position
					view.setCenter(position);
					trackFeature.getGeometry().appendCoordinate(position);
					var type_point;
					if (cpt <1) {
						type_point = "start";
					}
					else {
						type_point = "intermediaire";
					}
					cpt++;
					// Envoi des infos de géolocalisation
					$.post('requetes/insertgeocoord.php',
						{

							type_point: type_point,
							lat: lat,
							long: long,
							precision: geolocation.getAccuracy(),
							direction: geolocation.getHeading() || 0,
							altitude: alt || 0,
							vitesse: speed || 0,
							chrono: timerInstance.getTimeValues().toString(),
						},
						function(data) {
							tabDate.push(data);
							if (tabDate.length < 2) {
								$.post('requetes/insertperformance.php',
									{
										etat: etat,
										dateDeb : tabDate[0],
									},
									function(data) {
									}
								);
							}


						}
					);
				// Source du vecteur contenant l'objet géographique
				sourceVecteur = new ol.source.Vector({
						features: [ObjPosition]
				});
				// Couche vectorielle
				vecteur = new ol.layer.Vector({
					map: map,
					source: sourceVecteur
				});

				});

				// On alerte si une erreur est trouvée
				geolocation.on('error', function(erreur) {
					alert('Echec de la géolocalisation : ' +erreur.message);
				});

			});

			$( "#pause" ).click(function() {
				timerInstance.pause();
				geolocation.setTracking(false);
				online = "pause";
				$.post('requetes/setonline.php',
					{
						online: online,
					},
					function(data) {
					}
				);
			});

			$("#stop").click(function() {
				etat = "stop";
				timerInstance.stop();
				geolocation.setTracking(false);
				online = "deconnecte";
				dateFin = tabDate[tabDate.length-1];
				dateDeb = tabDate[0];
				hr1 = $(".durée").html().substring(4,6);
				min1 = $(".durée").html().substring(7,9);
				sec1 = $(".durée").html().substring(10,12);
				chronoRaw = (hr1+":"+min1+":"+sec1);
				$.post('requetes/setonline.php',
					{
						online: online,
					},
					function(data) {
					}
				);
				chrono = $(".durée").html();
				$.post('requetes/insertperformance.php',
					{
						etat: etat,
						dateFin : dateFin,
						dateDeb : dateDeb,
						chrono : chronoRaw,
					},
					function(data) {
					}
				);
				// Vérification qu'une performance a bien été enregistrée
				if (dateFin != null) {
					// Boite de dialogue
					var msg = "Félicitations !\nVous allez maintenant être"
					 	     +" redirigé vers le résumé de vos performances.";
					if (confirm(msg)) {
		    			// Code à éxécuter si le l'utilisateur clique sur "OK"
						creerCookie('tabSpeed',tabSpeed,1);
						creerCookie('tabAlt',tabAlt,1);
						creerCookie('allure',allureCalc,1);
						creerCookie('distanceTot',totalKM,1);
						hr1 = $(".durée").html().substring(4,6);
						min1 = $(".durée").html().substring(7,9);
						sec1 = $(".durée").html().substring(10,12);
						chronoRaw = (hr1+":"+min1+":"+sec1);
						creerCookie('duree',chronoRaw,1);
						creerCookie('distance',distance,1);

						window.location.replace("resultattrack.php");
					}
					else {

					}
				}

			});

			// Timer
			timerInstance.addEventListener('secondsUpdated', function (e) {
    			$('.durée').html("<h4>"+timerInstance.getTimeValues().toString()+"</h4>");
			});
			timerInstance.addEventListener('started', function (e) {
    			$('.durée').html("<h4>"+timerInstance.getTimeValues().toString()+"</h4>");
			});
			timerInstance.addEventListener('reset', function (e) {
			    $('.durée').html("<h4>"+timerInstance.getTimeValues().toString()+"</h4>");
			});

		</script>
	</body>
</html>
