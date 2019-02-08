<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page1</title>
    <link rel="stylesheet" href="lib/leaflet/leaflet.css"/>
    <style type="text/css">
    body { width: 800px; margin: 0 auto; }
    .gpx { border: 2px #aaa solid; border-radius: 5px;
        box-shadow: 0 0 3px 3px #ccc;
        width: 800px; margin: 1em auto; }
    .gpx header { padding: 0.5em; }
    .gpx h3 { margin: 0; padding: 0; font-weight: bold; }
    .gpx .start { font-size: smaller; color: #444; }
    .gpx .map { border: 1px #888 solid; border-left: none; border-right: none;
        width: 800px; height: 500px; margin: 0; }
    .gpx footer { background: #f0f0f0; padding: 0.5em; }
    .gpx ul.info { list-style: none; margin: 0; padding: 0; font-size: smaller; }
    .gpx ul.info li { color: #666; padding: 2px; display: inline; }
    .gpx ul.info li span { color: black; }
    </style>
</head>
<body>
    <body>
        <section id="demo" class="gpx" data-gpx-source="voit.gpx" data-map-target="demo-map">
            <header>
                <h3>Loading...</h3>
                <span class="start"></span>
            </header>

            <article>
                <div class="map" id="demo-map"></div>
            </article>

            <footer>
                <ul class="info">
                    <li>Distance : &nbsp;<span class="distance"></span>&nbsp;mètres</li> &mdash;
                    <li>Durée : &nbsp;<span class="duration"></span></li> &mdash;
                    <li>Allure : &nbsp;<span class="pace"></span>/mètres</li> &mdash;
                    <li>Elévation : &nbsp;+<span class="elevation-gain"></span>&nbsp;mètres,
                        -<span class="elevation-loss"></span>&nbsp;m
                        (net:&nbsp;<span class="elevation-net"></span>&nbsp;m)</li>
                </ul>
                </footer>
            </section>

            <!-- script here -->
            <script src="lib/leaflet/leaflet.js"></script>
            <script src="lib/leaflet-gpx/gpx.js"></script>
            <script src="map.js"></script>
            <script>

            function display_gpx(elt) {
                if (!elt) return;

                var url = elt.getAttribute('data-gpx-source');
                var mapid = elt.getAttribute('data-map-target');
                if (!url || !mapid) return;

                function _t(t) { return elt.getElementsByTagName(t)[0]; }
                function _c(c) { return elt.getElementsByClassName(c)[0]; }

                var map = L.map(mapid);
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="http://www.osm.org">OpenStreetMap</a>'
                }).addTo(map);

                var control = L.control.layers(null, null).addTo(map);

                new L.GPX(url, {
                    async: true,
                    marker_options: {
                        startIconUrl: 'http://github.com/mpetazzoni/leaflet-gpx/raw/master/pin-icon-start.png',
                        endIconUrl:   'http://github.com/mpetazzoni/leaflet-gpx/raw/master/pin-icon-end.png',
                        shadowUrl:    'http://github.com/mpetazzoni/leaflet-gpx/raw/master/pin-shadow.png',
                    },
                }).on('loaded', function(e) {
                    var gpx = e.target;
                    map.fitBounds(gpx.getBounds());
                    control.addOverlay(gpx, gpx.get_name());

                    /*
                    * Note: the code below relies on the fact that the demo GPX file is
                    * an actual GPS track with timing and heartrate information.
                    */
                    console.log(gpx.get_start_time().toDateString() + ', '
                    + gpx.get_start_time().toLocaleTimeString());
                    console.log(gpx.get_duration_string());
                    console.log(gpx.get_duration_string(gpx.get_moving_time())+" : moving time");
                    console.log(gpx.get_duration_string(gpx.get_moving_pace(), true) + " : moving pace");

                    _t('h3').textContent = gpx.get_name(); // nom du fichier
                    _c('start').textContent = gpx.get_start_time().toDateString() + ', '
                    + gpx.get_start_time().toLocaleTimeString();
                    _c('distance').textContent = gpx.get_distance().toFixed(2);
                    _c('duration').textContent = gpx.get_duration_string(gpx.get_moving_time());
                    _c('pace').textContent     = gpx.get_duration_string(gpx.get_moving_pace(), true);
                    _c('elevation-gain').textContent = gpx.get_elevation_gain().toFixed(0);
                    _c('elevation-loss').textContent = gpx.get_elevation_loss().toFixed(0);
                    _c('elevation-net').textContent  = gpx.get_elevation_gain().toFixed(0) - gpx.get_elevation_loss().toFixed(0);
                }).addTo(map);
            }

            display_gpx(document.getElementById('demo'));
            </script>

        </body>
        </html>
