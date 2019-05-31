<!doctype html>
<html>
  <head>
    <title>Map Examples</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="lib/ol3/ol.css" type="text/css" />
    <!-- <link href="lib/fontawesome/css/fontawesome.css" rel="stylesheet"> -->
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
  </head>
  <body>
    <div id="map" class="full-map"></div>
    <div id="location" class="marker"><span class="icon-arrow-up"></span></div>
    <script src="lib/ol3/ol.js"></script>
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

      // Centre sur la ville de Bram
      var bram = ol.proj.transform([2.114182, 43.243327], 'EPSG:4326', 'EPSG:3857');
      var view = new ol.View({
        center: bram,
        zoom: 16
      });
      var map = new ol.Map({
        target: 'map',
        layers: [baseLayer, trackLayer],
        view: view
      });
      // set up the geolocation api to track our position
      var geolocation = new ol.Geolocation({
        tracking: true
      });
      // bind the view's projection
      geolocation.bindTo('projection', view);
      projection: view.getProjection();
      // when we get a position update, add the coordinate to the track's
      // geometry and recenter the view
      geolocation.on('change:position', function() {
        var coordinate = geolocation.getPosition();
        view.setCenter(coordinate);
        trackFeature.getGeometry().appendCoordinate(coordinate);
      });
      // put a marker at our current position
      var marker = new ol.Overlay({
        element: document.getElementById('location'),
        positioning: 'center-center'
      });
      map.addOverlay(marker);
      marker.bindTo('position', geolocation);
      // rotate the view to match the device orientation
      var deviceOrientation = new ol.DeviceOrientation({
        tracking: true
      });
      deviceOrientation.on('change:heading', onChangeHeading);
      function onChangeHeading(event) {
        var heading = event.target.getHeading();
        view.setRotation(-heading);
      }

    </script>
  </body>
</html>
