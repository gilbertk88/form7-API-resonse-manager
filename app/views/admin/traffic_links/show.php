<h2><?php echo $object->__name; ?></h2>

<p>
    <?php echo $this->html->link('&#8592; All Traffic Managers', array('controller' => 'traffic_managers')); ?>
	
	<?php
	  echo '<div>'.$object->error_id.'</div>';	  
	  echo '<div>'.$object->error_message.'</div>';
	?>

<p>
  <?php echo $this->html->link('All Venues', array('controller' => 'venues')); ?>
</p>
</p>