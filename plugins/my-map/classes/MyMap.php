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
  
    $html = "<h3>My Map</h3>";
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
	  
	  // Add a marker
	  
/*
Fetured image
<?php if (has_post_thumbnail( $post->ID ) ): ?>
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
  <div id="custom-bg" style="background-image: url('<?php echo $image[0]; ?>')">

  </div>
<?php endif; ?>

/*

 anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
*/
    foreach($this->points as $point){
    $html .= "alert('".$point->getImageUrl()."');";
    $html .="var vectorLayer = new ol.layer.Vector({".
	    "source:new ol.source.Vector({".
	      "features: [new ol.Feature({".
		"geometry: new ol.geom.Point(ol.proj.transform([parseFloat(".$point->getLon()."), parseFloat('".$point->getLat()."')], 'EPSG:4326', 'EPSG:3857')),".
		"my_data_title: '". $point->getTitle() ."',".
		"my_data_url: '". $point->getURL() ."',".
	      "})]".
	    "}),".
	    "style: new ol.style.Style({".
	      "image: new ol.style.Icon({";
      if($point->getImageUrl() != ""){
        $html .=
		//"anchor: [0.5, 0.5],".
		//"anchorXUnits: 'fraction',".
		//"anchorYUnits: 'fraction',".
		//"size: [40,40],".
		"scale: 0.25,".
		
		"src: '".$point->getImageUrl()."'";
      }else{
	$html .=
		"anchor: [0.5, 0.5],".
		"anchorXUnits: 'fraction',".
		"anchorYUnits: 'fraction',".
		"src: '".plugins_url('my-map/public/images/RedDot.svg')."'";
      }
	$html .=
	      "})".
	    "})".
	  "});".
	  "map.addLayer(vectorLayer);";
    }  
    
    /*$html .= "var extent = source.getExtent();".
	     "map.getView().fit(extent, map.getSize());";*/ 
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
		"return feature;".
	    "});".
	    "if (feature) {".
	     // "var text = document.createTextNode('This just got added');".
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
