var config = {};
config.zoom = 13;
config.lat = 43.198168;
config.lng = 2.313995;

var options = {};
options.maxZoom = 18;
options.attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
var map;//leaflet map object

/**
 *  @function createMap
 *  @param string html container
 *  @return leaflet map object
 */
function createMap(containerId){
    var map = L.map(containerId).setView([config.lat, config.lng], config.zoom);
    return map;
}

/**
 *  @function createLayer
 *  @param string url
 *  @param json options
 *  @return Leaflet layer object
 */
function createLayer(url, options){
    var layerOptions= {};
    if(typeof options.maxZoom !== "undefined") {
        layerOptions.maxZoom = options.maxZoom;
    }
    if(typeof options.attribution !== "undefined"){
        layerOptions.attribution = options.attribution;
    }
    var layer = L.tileLayer(url+"/{z}/{x}/{y}.png", layerOptions);


    return layer;
}

/**
 *  @function addOnMap
 *  @param Leaflet map
 *  @param Leaflet object
 *  @return null
 */
function addOnMap(map, object){
    object.addTo(map);
}

function addMarker(map, lat, lng, popupContent){
    var m = L.marker([lat,lng]);
    m.addTo(map);
    if(typeof popupContent !=="undefined") {
        m.bindPopup(popupContent);
    }
    return m;
}


// var marker = L.marker([51.5, -0.09]).addTo(map); //creer marqueur
// var circle = L.circle([51.508, -0.11], {    //creer cercle
//     color: 'red',
//     fillColor: '#f03',
//     fillOpacity: 0.5,
//     radius: 500
// }).addTo(map);
// var polygon = L.polygon([   // creer polygone
//     [51.509, -0.08],
//     [51.503, -0.06],
//     [51.51, -0.047]
// ]).addTo(map);
//
// marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup(); //popup quand on clique sur le marqueur et quand la page s'affiche s'ouvre grâce à openPopup()
// circle.bindPopup("I am a circle."); // affiche popup quand on clique sur le cerlce
// polygon.bindPopup("I am a polygon.") // affiche popup quand on clique sur le polygone
//
// var popup = L.popup();
//
// function onMapClick(e) {
//     popup
//         .setLatLng(e.latlng)
//         .setContent("You clicked the map at " + e.latlng.toString())
//         .openOn(map);
// }
// map.on('click', onMapClick);
