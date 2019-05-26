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
        var vectorSource = new ol.source.Vector({});
        var vectorSourcePoint = new ol.source.Vector({});
            var style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 4,
                    fill: new ol.style.Fill({
                        color: '#ffa500'
                    }),
                    stroke: new ol.style.Stroke({
                        color: 'red',
                        width: 0.5
                    })
                })
            });

        var map = new ol.Map({
            layers: [
              new ol.layer.Tile({
                  source: new ol.source.OSM()
              }),
              new ol.layer.Vector({
                  source: vectorSource
              }),
              new ol.layer.Vector({
                  source: vectorSourcePoint,
                  style: style
              })
            ],
            target: 'carte',
            view: new ol.View({
                center: [2.113409, 43.243515],
                zoom:5,
                projection : 'EPSG:4326'

            })
        });

        points = [];
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
                            test.push(ligne.longitude);
                            coordonnees[1] = (ligne.latitude);
                            console.log(coordonnees);
                            test.push(ligne.latitude);
                            points.push(ol.proj.transform([ligne.longitude,ligne.latitude],'EPSG:4326', 'EPSG:4326'));
                            point = new ol.geom.Point([coordonnees[0],coordonnees[1]]).transform('EPSG:4326', 'EPSG:4326');
                            fea = new ol.Feature({geometry:point});
                            vectorSourcePoint.addFeature(fea);

							// view.setCenter(coordonnees);
                            var thing = new ol.geom.LineString(points);
                            var featurething = new ol.Feature({
                                name: "Thing",
                                geometry: thing,
                                style : new ol.style.Style({
                                    stroke : new ol.style.Stroke({
                                        color : 'red'
                                    })
                                })
                            });
                            vectorSource.addFeature( featurething );
						});

					}
				}
        	);
		}

        </script>

    </body>
</html>
