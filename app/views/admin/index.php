<h2>Traffic Managers</h2>
<table style="background:white; border:1px #90a8ce solid; border-radius:5px;">

<tr>

    <?php echo $this->html->traffic_manager_link($objects); ?>
	<td style="padding:20px;
	float:left;
	font-size:18px;
	">
		<b>Error Code</b>
	</td>
	
	</td>
	<td style="padding:15px;
	float:left;
	font-size:18px;">
	<?php 
	echo "<a class='button-primary' href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'add',)).">New Error Message</a>";
	?>
		
	</td>
</tr>

<?php foreach ($objects as $object): ?>

    <?php $this->render_view('_item', array('locals' => array('object' => $object))); ?>

<?php endforeach; ?>
</table>

<?php //echo $this->pagination(); ?>