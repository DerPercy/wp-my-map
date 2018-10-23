<?php

require_once plugin_dir_path( __FILE__ ) . 'MyMapPoint.php';

class MyMap {
  protected $points = array();
  function __construct() {
  }
  
  
  public function addPoint(MyMapPoint $point){
    array_push($this->points,$point);
  }
  function buildHTMLCode(){
  
    $html .= "<style>"
	    . ".map {"
	    . "height: 400px;"
	    . "width:100%;"
	    . "}" 
	    ."</style>";
    $html .= "<div id='map' class='map'></div>".
	    "<div id='my-map-popup' class='my-map-popup'>".
	      "<a id='my-map-popup-link' class='my-map-popup-link'>Hallo".
	      
	      "</a>".
	    "</div>";
    $html .= "<script type='text/javascript'>";
    $html .= "var map = new ol.Map({".
	  	"target: 'map',"
	  .	"layers: ["
	  .	  "new ol.layer.Tile({"
	  .	    "source: new ol.source.OSM()"
	  .	  "})"
	  .	"],"
	  .	"view: new ol.View({center: ol.proj.fromLonLat([37.41,8.82]),zoom: 2})"
	  .  "});";
	  
    // Add marker
    $html .="var features = [];";
    
    // Insert features
    foreach($this->points as $point){
    $html .="features.push(".
	      "new ol.Feature({".
		"geometry: new ol.geom.Point(ol.proj.transform([parseFloat(".$point->getLon()."), parseFloat('".$point->getLat()."')], 'EPSG:4326', 'EPSG:3857')),".
		"my_data_title: '". $point->getTitle() ."',".
		"my_data_url: '". $point->getURL() ."',".
		"my_data_image_url: '". $point->getImageURL() ."',".
	      "})".
	    ");";
    }
    
    // SourceVector
    $html .="var source = new ol.source.Vector({".
	      "features: features".
	    "});";
    
    // Feature style
    $html .="\nfunction vectorLayerStyleFunction(feature){".
	      "var style;".
	      "if (feature.get('my_data_image_url') != ''){".
		"style = new ol.style.Style({".
		  "image: new ol.style.Icon({".
		    "scale: 0.25,".
		    "src: feature.get('my_data_image_url'),".
		  "}),".
		 // "text: new ol.style.Text({".
		 //   "text: 'Hello',".
		 //   "fill: new ol.style.Fill({".
		 //     "color: '#fff'".
		 //   "}),".
		 //   "stroke: new ol.style.Stroke({".
		 //     "color: '#333'".
		 //   "}),".
		 //   "backgroundFill: new ol.style.Fill({".
		 //     "color: '#333'".
		 //   "}),".
		 //   "padding: [2,2,2,2],".
		 // "})".
		"});".
	      "}else{".
		"style = new ol.style.Style({".
		  //"image: new ol.style.Icon({".
		  //  "anchor: [0.5, 0.5],".
		  //  "anchorXUnits: 'fraction',".
		  //  "anchorYUnits: 'fraction',".
		  //  "src: '".plugins_url('my-map/public/images/RedDot.svg')."'".
		  //"}),".
		  "image: new ol.style.Circle({".
		    "radius: 5,".
		    "stroke: new ol.style.Stroke({".
		      "color: '#000'".
		    "}),".
		    "fill: new ol.style.Fill({".
		      "color: '#C00'".
		    "})".
		  "}),".
		  //"text: new ol.style.Text({".
		  //  "text: 'Hello',".
		  //  "fill: new ol.style.Fill({".
		  //    "color: '#fff'".
		  //  "}),".
		  //  "backgroundFill: new ol.style.Fill({".
		  //    "color: '#333'".
		  //  "}),".
		  //  "padding: [2,2,2,2],".
		  //"})".
		"});".
	      "}".
	      "return style;".
	    "};";
    // ClusterSource
    $html .="\nvar clusterSource = new ol.source.Cluster({".
	      "distance: 40,".
	      "source: source".
	    "});";
    // ClusterSourceStyle
    $html .="\nfunction clusterSourceStyleFunction(feature){".
	      "var style;".
	      "var size = feature.get('features').length;".
	      
	      "if(size == 1){".
		"return vectorLayerStyleFunction(feature.get('features')[0]);".
	      "}".
	      "style = new ol.style.Style({".
		"image: new ol.style.Circle({".
		  "radius: 10,".
		  "stroke: new ol.style.Stroke({".
		    "color: '#000'".
		  "}),".
		  "fill: new ol.style.Fill({".
		    "color: '#C00'".
		  "})".
		"}),".
		"text: new ol.style.Text({".
		  "text: ''+size,".
		  "fill: new ol.style.Fill({".
		    "color: '#fff'".
		  "}),".
		  //"backgroundFill: new ol.style.Fill({".
		  //  "color: '#333'".
		  //"}),".
		  "padding: [2,2,2,2],".
		"})".
	      "});".
	      "return style;".
	    "};";
    // Vector Layer
    $html .="\nvar vectorLayer = new ol.layer.Vector({".
	      "source: clusterSource,".
	      "style: clusterSourceStyleFunction".
	    "});";
    $html .="map.addLayer(vectorLayer);";
	  
    // Click overlay
    $html .= "var element = document.getElementById('my-map-popup');".

	  "var popup = new ol.Overlay({".
	    "element: element,".
	    "positioning: 'bottom-center',".
	    "stopEvent: false,".
	    "offset: [0, -10]".
	  "});".
	  "map.addOverlay(popup);".

	  // display popup on click
	  "map.on('click', function(evt) {".
	    "var coordinate = evt.coordinate;".
	    
	    "var feature = map.forEachFeatureAtPixel(evt.pixel,".
	      "function(feature) {".
		// For ClusterSource
		"if(feature.get('features') != null){".
		  "if(feature.get('features').size > 1){".
		    "return null;".
		  "}else{".
		    "return feature.get('features')[0];".
		  "}".
		"}".
		"return feature;".
	    "});".
	    "if (feature) {".
	      "var popupLink = jQuery(element).find('#my-map-popup-link');".
	      "popupLink.attr('href',feature.get('my_data_url'));".
	      "popupLink.text(feature.get('my_data_title'));".
	      "popup.setPosition(coordinate);".
	    "} else {".
	      "popup.setPosition(null);".
	    "}".
	  "});".
	  
	  // change mouse cursor when over marker
	  "map.on('pointermove', function(e) {".
	    "if (e.dragging) {".
	      "return;".
	    "}".
	    "var pixel = map.getEventPixel(e.originalEvent);".
	    "var hit = map.hasFeatureAtPixel(pixel);".
	    "map.getTargetElement().style.cursor = hit ? 'pointer' : '';".
	  "});".
      
      
	  "</script>";
    return $html;
  }
}


?>
