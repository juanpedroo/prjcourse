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

			.centre {
     		margin: 0 auto;
     		width: 100px;
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
        <select id="online" name="online" onchange="showOnline(this.value); recupDonnees();" class="form-control">
			<option value = "0" >Veuillez selectionnez un particpant actuellement en ligne</option>
            <?php
                while($ligne = pg_fetch_assoc($resultat)) {
                    print('<option value="'.$ligne['id_individu'].'">'.$ligne['prenom_p'].' '.$ligne['nom_p'].'</option>');
                }
            ?>
        </select>
        <br>
		<div id="etat" class = "centre"></div>
		<div id ="carte" class ="carte"></div>

		<div class="row stats-gen-libelle">
		   <div class="col-md-4 center-text">Durée <i class="far fa-clock"></i></div>
		   <div class="col-md-4 center-text">Distance <i class="fas fa-ruler-horizontal"></i></div>
		   <div class="col-md-4 center-text">Allure <i class="fas fa-running"></i></div>
   		</div>
		<div class="row stats-gen">
		   <div id="durée" class="durée col-md-4 center-text"><h5>00:00:00</h5></div>
		   <div id="distance" class="distance col-md-4 center-text"><h5>0 m</h5></div>
		   <div id="allure" class="allure col-md-4 center-text"><h5>00"00</h5></div>
   		</div>
		<br>
		<div class="row stats-vitesse-libelle">
		   <div class="col-md-3 center-text">Vitesse <img src="styles/speedometer.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Max <img src="styles/fast.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Min <img src="styles/slow.svg" height="20px" width="20px"></div>
		   <div class="col-md-3 center-text">Vitesse Moy <img src="styles/speedometer_avg.svg" height="20px" width="20px"></div>
   		</div>
   		<div class="row stats-vitesse">
		   <div id="vitesse" class="vitesse col-md-3 center-text"><h5>0 km/h</h5></div>
		   <div id="vmax" class="vmax col-md-3 center-text"><h5>0 km/h</h5></div>
		   <div id="vmin" class="vmin col-md-3 center-text"><h5>0 km/h</h5></div>
		   <div id="vmoy" class="vmoy col-md-3 center-text"><h5>0 km/h</h5></div>
   		</div>
		<br>
		<div class="row stats-altitude-libelle">
		   <div class="col-md-3 center-text">Altitude <i class="fa fa-tachometer-alt"></i></div>
		   <div class="col-md-3 center-text">Altitude Min <i class="fas fa-arrow-down"></i></div>
		   <div class="col-md-3 center-text">Altitude Max <i class="fas fa-arrow-up"></i></div>
		   <div class="col-md-3 center-text">Altitude Moy <i class="fas fa-arrow-right"></i></div>
	   	</div>
	   	<div class="row stats-altitude">
		   <div id="alt" class="alt col-md-3 center-text"><h5>0 m</h5></div>
		   <div id="altmin" class="altmin col-md-3 center-text"><h5>0 m</h5></div>
		   <div id="altmax" class="altmax col-md-3 center-text"><h5>0 m</h5></div>
		   <div id="altmoy" class="altmoy col-md-3 center-text"><h5>0 m</h5></div>
	   	</div>
        <script>
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

				dist = parseFloat(dist), hrs = parseFloat(hrs), mins = parseFloat(mins), secs = parseFloat(secs);
				var pace;
				var timeElapsed = 0;
				timeElapsed += hrs*60*60;
				timeElapsed += mins*60;
				timeElapsed += secs;
				var calculatedPace = Math.floor(timeElapsed/dist*1000);
				var paceMins = Math.floor(calculatedPace/60);
				var paceSecs = calculatedPace - (paceMins*60);
				pace = paceMins + ":" + paceSecs;
				return pace;
			}
			// VAR stats
			cptDist = 0;
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


			var id_individu = 0;
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
			var id_point = 0;
			// var coordonnees = [];

			function showOnline(option) {
				id_point = 0;
				coordonnees = [];
				points = [];
				id_individu = parseInt(option);
				temps = [];
				$(".durée").html("00:00:00");
				$(".distance").html("0 m");
				$(".allure").html('00"00');
				$(".vitesse").html("0 km/h");
				$(".vmax").html("0 km/h");
				$(".vmin").html("0 km/h");
				$(".vmoy").html("0 km/h");
				$(".alt").html("0 m");
				$(".altmin").html("0 m");
				$(".altmax").html("0 m");
				$(".altmoy").html("0 m");
				trackFeature = new ol.Feature({
					geometry: new ol.geom.LineString([])
				});
				trackLayer = new ol.layer.Vector({
					source: new ol.source.Vector({
						features: [trackFeature]
					}),
					style: trackStyle
				});
			}
			function recupDonnees() {
				$.post('./actions/get_online.php',
	                {
					    option: id_individu,
					    id_point: id_point,

					},
	                function (data) {
	                    // Décode du JSON le résultat
						if (id_individu != 0 && data != "Offline" && data != "false") {
							JSON.parse(data).forEach((ligne) => {
								// console.log(ligne);
								coordonnees[0] = (parseFloat(ligne.longitude));
								coordonnees[1] = (parseFloat(ligne.latitude));
								points.push(parseInt(ligne.id_point));
								view.setCenter(coordonnees);
								ObjPosition.setGeometry( coordonnees ? new ol.geom.Point(coordonnees) : null );
		        				trackFeature.getGeometry().appendCoordinate(coordonnees);
								lat = coordonnees[1];
								long = coordonnees[0];

								temps.push(ligne.chrono);
								// On affiche les stats sur la page
								$(".durée").html(temps[temps.length-1]);
								// vitesse instant vmax et vmin et vmoy
								speed = 3.6 * parseFloat(ligne.vitesse);
								$(".vitesse").html(speed.toFixed(2));
								$(".vmax").html(vmax.toFixed(2));
								$(".vmin").html(vmin.toFixed(2));
								$(".vmoy").html(vmoy.toFixed(2));
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
									$(".distance").html("0");
								}
								else if (lat != latOld || long != longOld){
									//This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
									distance[cptDist] = parseFloat(calcCrow(lat, long, latOld, longOld).toFixed(1));
									total += distance[cptDist];
									totalKM += distance[cptDist] /1000;
									cptDist++;
								}
								if(total < 1000) {
									$(".distance").html(total.toFixed(0) + " Mètres");
								}
								else {
									$(".distance").html(totalKM.toFixed(1) + " KM");
								}
								latOld = lat;
								longOld = long;

								//allure
								//hr = parseInt($(".durée").html().substring(0,3));
								hr = $(".durée").html().substring(0,2);
								//min = parseInt($(".durée").html().substring(3,5));
								min = $(".durée").html().substring(3,5);
								//sec = parseInt($(".durée").html().substring(6,8));
								sec = $(".durée").html().substring(6,8);
								var allure = calculatePace(total, hr, min,sec);
								$(".allure").html(allure + " KM/Min");

								// altitude act, min, max, moy
								alt = parseFloat(ligne.altitude);
								$(".alt").html(alt.toFixed(0));
								$(".altmax").html(altmax.toFixed(0));
								$(".altmin").html(altmin.toFixed(0));
								$(".altmoy").html(altmoy.toFixed(0));
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

							});
							id_point = points[points.length-1];
							$("#etat").html("En ligne");

						}
						else {
							$("#etat").html("Hors-ligne");
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

			setInterval("recupDonnees()",5000);

        </script>

    </body>
</html>
