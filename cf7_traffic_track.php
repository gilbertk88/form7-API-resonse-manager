<?php
/*
Plugin Name: Cf7 API Response Manager
Plugin URI: http://akibapp.com
Version: 1.0.0
Author: Akibapp Solutions
Description: API response manager for contact form 7 for your Wordpress. It also capture incoming parameters(sourceid, campaignid) and pass them to the API destination. Tested with Postman API.
Author URI: http://akibapp.com
*/
if (!class_exists('MvcPublicLoader')){
    //require_once dirname(__FILE__).'/wp_mvc.php';
}

register_activation_hook(__FILE__, 'cf7_traffic_track_activate');
register_deactivation_hook(__FILE__, 'cf7_traffic_track_deactivate');

function cf7_traffic_track_activate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/cf7_traffic_track_loader.php';
    $loader = new Cf7TrafficTrackLoader();
    $loader->activate();
    $wp_rewrite->flush_rules( true );
}

function cf7_traffic_track_deactivate() {
    global $wp_rewrite;
    require_once dirname(__FILE__).'/cf7_traffic_track_loader.php';
    $loader = new Cf7TrafficTrackLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules( true ); 
}

require_once dirname(__FILE__).'/app/functions/functions.php';

$api_cf7 = new api_cf7();
$api_cf7->load_hooks();

?>