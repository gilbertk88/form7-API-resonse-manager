<?php

class Cf7TrafficTrackLoader extends MvcPluginLoader {
	

    var $db_version = '1.0';
    var $tables = array(
		'traffic_manager' => "wp_traffic_managers_error_message",
		'traffic_link' => "wp_traffic_managers_redirect_url",
		'traffic_log' => "wp_traffic_managers_error_log",);	

    function activate() {
		global $wpdb;
    
        // This call needs to be made to activate this app within WP MVC
        
        $this->activate_app(__FILE__);
        
        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';
    
        add_option('cf7_traffic_track_db_version', $this->db_version);
        
        // Use dbDelta() to create the tables for the app here
		$sql = '
			
				CREATE TABLE `wp_traffic_managers_error_log` (
				  `id` int(11) NOT NULL,
				  `error_id` varchar(11) NOT NULL,
				  `form_id` int(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				
				CREATE TABLE `wp_traffic_managers_error_message` (
				  `id` int(11) NOT NULL,
				  `error_id` varchar(11) DEFAULT NULL,
				  `error_message` varchar(250) DEFAULT NULL ,
				  `error_link` varchar(250) DEFAULT NULL,
				  `code_type` int(11) NOT NULL DEFAULT "1"
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
				
				CREATE TABLE `wp_traffic_managers_error_type` (
				  `id` int(11) NOT NULL,
				  `name` varchar(25) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;

				INSERT INTO `wp_traffic_managers_error_type` (`id`, `name`) VALUES
				(1, "Yes"),
				(2, "No");

				CREATE TABLE `wp_traffic_managers_redirect_url` (
				  `id` int(11) NOT NULL,
				  `url` varchar(250) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;

				INSERT INTO `wp_traffic_managers_redirect_url` (`id`, `url`) VALUES
				(1, "http://redirect_url.com"); ';

		dbDelta($sql);
		
		global $wpdb;
		
		$sql2=array(
		'ALTER TABLE `wp_traffic_managers_error_message` ADD PRIMARY KEY (`id`);',
		'ALTER TABLE `wp_traffic_managers_error_message`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;',
		'ALTER TABLE `wp_traffic_managers_error_log` ADD PRIMARY KEY (`id`);',
		'ALTER TABLE `wp_traffic_managers_error_type` ADD PRIMARY KEY (`id`);',
		'ALTER TABLE `wp_traffic_managers_redirect_url`  ADD PRIMARY KEY (`id`);',
		'ALTER TABLE `wp_traffic_managers_error_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;',
		'ALTER TABLE `wp_traffic_managers_error_type` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;',
		'ALTER TABLE `wp_traffic_managers_redirect_url` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');

		foreach($sql2 as $sq){
			$wpdb->query($sq);
		}
    }

    function deactivate() {
    
        // This call needs to be made to deactivate this app within WP MVC
        
        $this->deactivate_app(__FILE__);
        
        // Perform any databases modifications related to plugin deactivation here, if necessary
    
    }

}

?>