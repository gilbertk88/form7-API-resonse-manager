<div style="background:white; border:1px #90a8ce solid; border-radius:5px;padding:30px;margin:20px;">
<h2>Traffic Managers</h2>
<hr>
<?php echo "<a class='button-primary' href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'add',)).">New Error Message</a>";	?>	
<hr>
<table>
<tr>
	<td style="padding:20px; font-size:18px;"><b>Error Name</b></td>
	<td style="padding:20px; font-size:18px;"><b>Error Code</b>	</td>	
	<td></td>
</tr>

<?php foreach ($objects as $object): ?>

    <?php $this->render_view('_item', array('locals' => array('object' => $object))); ?>

<?php endforeach; ?>

</table>
<hr>
</div>
<?php //echo $this->pagination(); ?>