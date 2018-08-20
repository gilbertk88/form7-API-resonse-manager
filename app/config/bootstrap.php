<?php

MvcConfiguration::set(array(
    'Debug' => false 
));

MvcConfiguration::append(array(
    'AdminPages' => array(
        'traffic_managers' => array(
            'add'=> array(
                'label' => 'Deletemm',
                'in_menu' => false,
            ),
            'delete'=> array(
                'label' => __('Delete', 'wpmvc'),
                'in_menu' => false
            ),
            'edit'=> array(
                'label' => __('Delete', 'wpmvc'),
                'in_menu' => false
            ),
			'parent_slug'=>'options-general.php',
			'label'=>'API Response Code',
        ),
		'traffic_links' => array(
            'add'=> array(
                'label' => 'Deletemm',
                'in_menu' => false,
            ),
            'delete'=> array(
                'label' => __('Delete', 'wpmvc'),
                'in_menu' => false
            ),
            'edit'=> array(
                'label' => __('Delete', 'wpmvc'),
                'in_menu' => false
            ),
			'parent_slug'=>'options-generalsn.php',
			'label'=>'API Redirect Link',
        ),
		
    ),
	
));
?>