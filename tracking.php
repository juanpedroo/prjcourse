<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page1</title>
    <link rel="stylesheet" href="lib/leaflet/leaflet.css"/>

</head>
<body>

    <div id="mapid" style="width: 700px; height: 800px;"></div>

    <!-- script here -->
    <script src="lib/leaflet/leaflet.js"></script>
    <script src="map.js"></script>
    <script>
        //Create the map
        var map = createMap("mapid");
        var couches = L.layerGroup();
        //Create the osm layer tiles
        var osmLayer = createLayer("https://{s}.tile.openstreetmap.org",{});
        var otmLayer = createLayer("https://{s}.tile.opentopomap.org",{});
        var hydda = createLayer("https://{s}.tile.openstreetmap.se/hydda/base",{});

        var baseMaps = {
            "OSM" : osmLayer,
            "OTM" : otmLayer,
            "Hydda" : hydda
        };
        //Add the layer on the map
        L.control.layers(baseMaps).addTo(map);
        addOnMap(map,osmLayer);
    </script>

</body>
</html>
