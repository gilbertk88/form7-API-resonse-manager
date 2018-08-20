
<tr style="width:100%;min-height:;">
    <?php echo $this->html->traffic_manager_link($object); ?>
	
	<td style="padding:20px 30px; font-size:15px;">
		<?php 
			if (isset($object->error_link))
				echo $object->error_link;
			else
				echo '---';
		?>
	</td>
	<td style="padding:20px 30px; font-size:15px;">
		<?php 
			if (isset($object->error_id))
				echo $object->error_id;
			else
				echo '---';
		?>
	</td>
	<td style="padding:20px; font-size:13px;">
		<?php 
			if (isset($object->__id))
					echo "<a class='' href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'edit', 'id' => $object->__id)).">Manage</a>";
				else
					echo '---';
		?>
	</td>
</tr>