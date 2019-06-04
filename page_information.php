
<!DOCTYPE html>
<?php
	session_start();
	include 'include/header.inc';
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Informations de la course</title>
		<meta name="description" content="">
		<meta name="author" content="anais.grignon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="apple-touch-icon" href="images/regroup.png">
		<link rel="apple-touch-icon" href="images/restaurant.png">
		<link rel="apple-touch-icon" href="images/lodging-2.png">
		<link rel="stylesheet" href="libs/leaflet/leaflet.css">
		<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="libs/leaflet_marker_cluster/dist/MarkerCluster.Default.css">
		<link rel="stylesheet" href="libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.css">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="css/navbar.css">
		<link rel="stylesheet" href="css/centerdiv.css">
		<link rel="stylesheet" href="libs/leaflet_routing_machine/dist/leaflet-routing-machine.css" />

		<script src="libs/leaflet/leaflet.js"> </script>
		<script src="libs/jquery/jquery-3.3.1.min.js"> </script>
		<script src="libs/bootstrap/js/bootstrap.min.js"> </script>
		<script src="libs/leaflet_marker_cluster/dist/leaflet.markercluster.js"></script>
		<script src="libs/leaflet_routing_machine/dist/leaflet-routing-machine.min.js"></script>
	</head>

	<body>
		</br>
		<div class="container">
			<div class="row">
				<div class="col">
					<p class="text-center h4">Informations pratiques</p>
				</div>
			</div>
			</br>
		</div>
		</br>
		<div class="row">
			<div class="col">
				<p class="text-center h6">Vous trouverez ici toutes les informations nécessaires pour que votre séjour à Bram se passe au mieux</p></br>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div id="cont_14224c2feb0916c5c1ffc4c6b4257405"><script type="text/javascript" async src="https://www.tameteo.com/wid_loader/14224c2feb0916c5c1ffc4c6b4257405"></script></div>
			</div>
			<div class="col-10">
				<div>
					<button id="myLocation" class="mylocation" onclick="currentLocation()">Ma position</button>
				</div>
				<div id="macarte" style="width:80%; height:500px"></div>
			</div>

			<script>
				//icons waypoints
				var start= new L.Icon({
					iconSize: [30, 30],
					iconAnchor: [15, 15],
					popupAnchor:  [0,-10],
					iconUrl: 'images/startpoint_routing.png'
				});

				var end= new L.Icon({
					iconSize: [30, 30],
					iconAnchor: [15, 15],
					popupAnchor:  [15, 15],
					iconUrl: 'images/endpoint_routing.png'
				});

				var other= new L.Icon({
					iconSize: [30, 30],
					iconAnchor: [15, 15],
					popupAnchor:  [15, 15],
					iconUrl: 'images/otherpoint_routing.png'
				});

				//icon point de regroupement
				var gp= new L.Icon({
					iconSize: [40, 40],
					iconAnchor: [22, 25],
					popupAnchor:  [-2, -18],
					iconUrl: 'images/regroup.png'
				});

				//clusters hébergement et restauration
				var markersClusterheb = new L.markerClusterGroup({
					maxClusterRadius:30
				});

				var markersClusterrest = new L.markerClusterGroup({
					maxClusterRadius:30
				});

				//fonds de plan
				var Osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'});
				var Sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
					maxZoom: 19
				});

				//couche hébergement
				//1-icon hébergement
				var heb_icon = new L.Icon({
					iconSize: [30, 30],
					iconAnchor: [15, 15],
					popupAnchor:  [0, -10],
					iconUrl: 'images/lodging-2.png'
				});

				//2-marker vide hébergement
				var heb = new L.geoJson(null, {
					pointToLayer: function(feature, latlng) {
						var n = L.marker([latlng.lat, latlng.lng],{icon: heb_icon}).bindPopup(feature.properties.nom);
						markersClusterheb.addLayer(n);
					},
				});

				//3-récup datas couche geojson hébergement
				$.ajax({
					dataType: "json",
					url: "geojson/heb.geojson",
					success: function(data) {
						$(data.features).each(function(key, data) {
							heb.addData(data);
						});
					}
				});

				//couche restauration
				//1-icon restauration
				var rest_icon = new L.Icon({
					iconSize: [30, 30],
					iconAnchor: [15, 15],
					popupAnchor:  [0, -10],
					iconUrl: 'images/restaurant.png'
				});

				//2-marker vide restauration
				var rest= new L.geoJson(null,{
					pointToLayer: function(feature, latlng) {
						var m = L.marker([latlng.lat, latlng.lng],{icon: rest_icon}).bindPopup(feature.properties.nom);
						markersClusterrest.addLayer(m);
					}
				});

				//3-récup datas couche geojson restauration
				$.ajax({
					dataType: "json",
					url: "geojson/rest.geojson",
					success: function(data) {
						$(data.features).each(function(key, data) {
							rest.addData(data);
						});
					}
				});

				//create the map
				var carte = L.map('macarte', {
					center: [43.2438, 2.1134],
					zoom: 12,
					layers: [Osm, markersClusterrest, markersClusterheb]
				});

				var gpm= new L.marker([43.240193, 2.112281],{icon: gp}).addTo(carte).bindPopup("Venez-nous retrouver ici!!");

				carte.addLayer(markersClusterrest);
				carte.addLayer(markersClusterheb);

				// MENU DES CARTES
				var plans = {
					'Plan': Osm,
					'Satellite': Sat,
				};

				// MENU DES CALQUES
				var couches = {
					'Restauration': markersClusterrest,
					'Hébergement': markersClusterheb,
					'Point de regroupement': gpm,
				};

				// Pour appliquer le controle à la carte
				L.control.layers(plans, couches).addTo(carte);

				//geolocalisation
				function currentLocation() {
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition((function (position) {
							var latgeo=position.coords.latitude;
							var lnggeo=position.coords.longitude;
							var marker = L.marker([latgeo,lnggeo], {icon:start}).addTo(carte);
							marker.bindPopup("Vous êtes ici :<br> Latitude : " + latgeo + ',<br>Longitude ' + lnggeo).openPopup();
							if (latgeo && lnggeo){
								var startpoint=L.latLng(latgeo,lnggeo);
							}
							else {
								var startpoint=L.latLng(43.240193,2.112281);//sur le pt de regroupement par défaut position 0 dans l'index
							}
							var endpoint=L.latLng(43.243, 2.1019);//position n-1 dans l'index'
							//changement de langue, création de fonction pour affecter de nouvelles icones aux marqueurs des waypoints en fonction de leur type
							var control = L.Routing.control({
								language:'fr', collapsible:true,
								plan: new L.Routing.Plan([startpoint, endpoint], {
									createMarker: function(i, wp, n) {
										var marker_icon=null;
										if (i == 0) {
											marker_icon = start;
										}
										else if (i == n-1) {
											marker_icon = end;
										}
										else {
											marker_icon = other;
										}

										return L.marker(wp.latLng, {
											draggable: true,
											icon: marker_icon
										});
									},
								})
							});
							control.addTo(carte);}), function(error){
								console.log(error);
								alert(error.message);
							});
						}
						else {alert("La géolocalisation n'est pas supportée par ce navigateur.");
					}
				};
				console.log(navigator.geolocation);

		</script>
	</body>
</html>
