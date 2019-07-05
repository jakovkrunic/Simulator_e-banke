var map = new ol.Map({
  target: 'map',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.OSM()
    })
  ],
  view: new ol.View({
    center: ol.proj.fromLonLat([15.98, 45.81]),
    zoom: 14
  })
});

var marker1 = new ol.Feature({
  geometry: new ol.geom.Point(ol.proj.transform([15.9855263, 45.8268578], 'EPSG:4326', 'EPSG:3857')),
});

var marker2 = new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([15.9792622, 45.8146018], 'EPSG:4326', 'EPSG:3857')),
});



var marker3 = new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([16.0026761, 45.8006604], 'EPSG:4326', 'EPSG:3857')),
});

var marker4 = new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([16.011292, 45.7914713], 'EPSG:4326', 'EPSG:3857')),
});


var marker5 = new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([15.9733318, 45.8151955], 'EPSG:4326', 'EPSG:3857')),
});

var marker6 = new ol.Feature({
geometry: new ol.geom.Point(ol.proj.transform([90, 0], 'EPSG:4326', 'EPSG:3857')),
});
var markers = new ol.source.Vector({
  features: [marker1, marker2, marker3, marker4, marker5, marker6]
});

var markerVectorLayer = new ol.layer.Vector({
  source: markers,
});
map.addLayer(markerVectorLayer);
