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
        <link rel="stylesheet" href = "libs/chartjs/Chart.min.css">
		<script src="libs/easytimer/easytimer.min.js"></script>
		<script src="libs/ol3/ol.js"></script>
		<script src="libs/jquery/jquery-3.3.1.min.js"></script>
		<script src="libs/bootstrap/js/bootstrap.min.js"></script>
		<script src="cookie.js"></script>
        <script src = "libs/chartjs/Chart.bundle.min.js"></script>

	</head>
    <body>
        <div class="container">
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
    		   <div class="col-md-3 center-text">Vitesse Max <img src="css/fast.svg" height="20px" width="20px"></div>
    		   <div class="col-md-3 center-text">Vitesse Min <img src="css/slow.svg" height="20px" width="20px"></div>
    		   <div class="col-md-3 center-text">Vitesse Moy <img src="css/speedometer_avg.svg" height="20px" width="20px"></div>
       		</div>
       		<div class="row stats-vitesse">
    		   <div id="vmax" class="vmax col-md-3 center-text"><h4>0 km/h</h4></div>
    		   <div id="vmin" class="vmin col-md-3 center-text"><h4>0 km/h</h4></div>
    		   <div id="vmoy" class="vmoy col-md-3 center-text"><h4>0 km/h</h4></div>
       		</div>
    		<br>
    		<div class="row stats-altitude-libelle">
    		   <div class="col-md-3 center-text">Altitude Min <i class="fas fa-arrow-down"></i></div>
    		   <div class="col-md-3 center-text">Altitude Max <i class="fas fa-arrow-up"></i></div>
    		   <div class="col-md-3 center-text">Altitude Moy <i class="fas fa-arrow-right"></i></div>
    	   	</div>
    	   	<div class="row stats-altitude">
    		   <div id="altmin" class="altmin col-md-3 center-text"><h4>0 m</h4></div>
    		   <div id="altmax" class="altmax col-md-3 center-text"><h4>0 m</h4></div>
    		   <div id="altmoy" class="altmoy col-md-3 center-text"><h4>0 m</h4></div>
    	   	</div>
    		<br>
    		<!-- Graphique -->
            <canvas id="chartVitesse" width="400" height="250"></canvas>
            <canvas id="chartAltitude" width="400" height="250"></canvas>

    	</div>

        <script type="text/javascript">

        //Distance tot
        distanceTot = lireCookie("distanceTot");
        distanceTot = parseInt(distanceTot);

        // Tableau des vitesses
        chaineSpeed = lireCookie("tabSpeed");
        tabSpeed = chaineSpeed.split(',');
        //tableau des altitudes
        chaineAlt = lireCookie("tabAlt");
        tabAlt = chaineAlt.split(',');


        chaineDist = lireCookie("distance")
        tabDist = chaineDist.split(',')
        allure = lireCookie("allure");
        distance = parseInt(lireCookie("distanceTot"));
        duree = lireCookie("duree");
        vmax = 0;
        vmin = 9999;
        vmoy = 0;
        altmax = 0;
        altmin = 9999;
        altmoy = 0;
        // Obtention vmax
        for (i=0; i < tabSpeed[tabSpeed.length-1]; i++) {
            if (vmax < tabSpeed[i]) {
                vmax = tabSpeed[i];
            }
        }

        // Obtention vmin
        for (i=0; i < tabSpeed[tabSpeed.length-1]; i++) {
            if (vmin > tabSpeed[i]) {
                vmin = tabSpeed[i];
            }
        }

        // Obtention vmoy
        for (i=0; i < tabAlt[tabAlt.length-1]; i++) {
            vmoy = vmoy + tabSpeed[i];
        }

        // Obtention altmax
        for (i=0; i < tabAlt[tabAlt.length-1]; i++) {
            if (altmax < tabAlt[i]) {
                altmax = tabAlt[i];
            }
        }

        // Obtention altmin
        for (i=0; i < tabAlt[tabAlt.length-1]; i++) {
            if (altmin > tabAlt[i]) {
                altmin = tabAlt[i];
            }
        }

        // Obtention altmoy
        for (i=0; i < tabAlt[tabAlt.length-1]; i++) {
            altmoy = altmoy + tabAlt[i];
        }
        $(".durée").html("<h4>"+duree+"</h4");
        $(".distance").html("<h4>"+distance.toFixed(1)+"</h4");
        $(".allure").html("<h4>"+allure+"</h4");
        $(".vmax").html("<h4>"+parseInt(vmax).toFixed(2)+" km/h</h4");
        $(".vmin").html("<h4>"+parseInt(vmin).toFixed(2)+" km/h</h4");
        $(".vmoy").html("<h4>"+parseInt(vmoy).toFixed(2)+" km/h</h4");
        $(".altmax").html("<h4>"+parseInt(altmax).toFixed(0)+" m</h4");
        $(".altmin").html("<h4>"+parseInt(altmin).toFixed(0)+" m</h4");
        $(".altmoy").html("<h4>"+parseInt(altmoy).toFixed(0)+" m</h4");
        // Chart vitesse
        var ctx = $('#chartVitesse')[0].getContext('2d');
        var vitesse = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Vitesse',
                    data: tabSpeed,
                    borderWidth: 2,
                    borderColor: "rgb(230, 10, 1)",
                    borderCapStyle : 'round',
                }]
            }
        });

        // Chart altitude
        var ctx1 = $('#chartAltitude')[0].getContext('2d');
        var altitude = new Chart(ctx1, {
            type: 'line',
            data: {
                datasets: [{
                    label: "Altitude",
                    data: tabAlt,
                    borderWidth: 2,
                    borderColor: "rgb(75, 192, 192)",
                    borderCapStyle : 'round',

                }]
            }
        });

        </script>

    </body>
</html>
