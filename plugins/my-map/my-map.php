<?php 
/*
Plugin Name: My Map
*/


/*
if( ! defined('WBINC')){
  die;
}
*/


// Shortcode
function my_map_show_map($atts){
  require_once plugin_dir_path( __FILE__ ) . 'classes/MyMap.php';
  
  // Get all relevant posts
  
  $map = new MyMap();
  global $post;
  $content = "Hello Map:";
  $args = array( "nopaging" => true ); // Post filter arguments
  
  $posts = get_posts($args);
  
  foreach( $posts as $post):
    setup_postdata($post);
    $content .= "post found:";
    //$content .= print_r($post);
    
    $mkey_values = get_post_custom_values( 'geo_latitude');
    $mkey_val_lon = get_post_custom_values( 'geo_longitude');
    $title 	= get_the_title($post);
    $url 	= get_permalink($post);
    //$content .= print_r($mkey_values);
    
    if($mkey_values != null && $mkey_val_lon != null){
      foreach($mkey_values as $key => $value){
	foreach($mkey_val_lon as $key_lon => $val_lon){
	  $point = new MyMapPoint($value,$val_lon);
	  $point->setTitle( $title );
	  $point->setURL( $url );
	  
	  $map->addPoint($point);
	  $content .= "<b>".$value."</b>";
	}
      }
    }
  endforeach;
  wp_reset_postdata();
  return $map->buildHTMLCode();
}

add_shortcode( 'my-map', 'my_map_show_map');


// Binding mimes
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

function register_plugin_styles() {
  wp_register_style('my-map', plugins_url('my-map/public/css/ol.css'));
  wp_register_style('my-map-1', plugins_url('my-map/public/css/my-map.css'));
  
  wp_enqueue_style( 'my-map' );
  wp_enqueue_style( 'my-map-1' );
  
  wp_register_script('my-map', plugins_url('my-map/public/js/ol.js'));
  
  wp_enqueue_script( 'my-map' );
  
}

