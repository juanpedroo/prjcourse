<!DOCTYPE html>

<?php
	session_start();
	include 'include/header.inc';
?>

<html lang="fr" dir="ltr">
    <head>
        <title>La Solidaria Bram</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            include("include/bootstrap_parcours.inc");
            include("include/fontawesome.inc");
            include("include/scripts_draw.php");
            include("include/easybutton.inc");
        ?>
        <link rel="stylesheet" href="css/navbar.css">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    </head>

    <body>
        <?php
            include('include/connect.php');
            $idc = connect();
        ?>
        <div style="text-align:center;">
            <h2 class="display-4" style="color: #303030">Les parcours de l'edition 2019 !</h2>
            <p class="lead" style="color: #585858;">Choisissez un parcours et inscrivez vous dès aujourd'hui ! </p>
        </div>

        <div>
            <?php
                $sql="SELECT p.id_p, longueur_p, date_p, heure_p, p.id_parcours_carte, forme_p FROM parcours p INNER JOIN c_parcours cp ON p.id_p = cp.id_p WHERE date_p LIKE '2019%' ORDER BY id_p";
                $rs=pg_exec($idc,$sql);
                $num = 0;
                $textNum = '';
                $geojson = [];
                while($ligne=pg_fetch_assoc($rs)){
                    $numparcours = $ligne['id_p'];
                    $geojson[] = $ligne['forme_p'];

                    print('<div class="col-md-4">
                        <div class="panel-group">
                        <div class="panel panel-default">
                        <div class="panel-heading">');
                    print('<b>Parcours n°'. ($num + 1) .':</b> Distance : '.$ligne['longueur_p'].'km - Heure du départ: '.$ligne['heure_p']);
                    print('</div>
                        <div class="panel-body" style="height:500px;">
                        <div id="map'.$num.'" style ="height: 470px; width: 590px;">
                        </div>
                        </div>
                        <div class="panel-footer">
                        <form class="" action="page_inscription.php" method="post">
                        <button type="submit" class="btn" name="parcours" value='.$numparcours.' style="background:#33cabb; color:#FFF;">🏃 Inscription au Parcours n°'.($num + 1).'</button>
                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
                    ');
                    $textNum .= $num . ', ';
                    $num++;
                }
            ?>
        </div>

        <script>
            listNum = [<?= $textNum ?>];
            tabGeoJSON = <?php echo json_encode($geojson); ?>;

            listNum.forEach((num) => {
                var map = createMap(num, tabGeoJSON[num]);
            });

            function createMap(num, geojson){
                var nomCarte = "map" + num;

                var laCarte = L.map(nomCarte).setView([43.24, 2.1134], 15);
                // add an OpenStreetMap tile layer
                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(laCarte);

                L.geoJson(JSON.parse(geojson), {
                    onEachFeature: function (feature, layer) {
                        if (layer instanceof L.Polyline) {
                            layer.setStyle({
                                'color': "#08B995"
                            });
                        }
                    }
                }).addTo(laCarte);

                return (laCarte);
            };
        </script>
    </body>
</html>
