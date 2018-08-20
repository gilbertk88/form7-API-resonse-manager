<div style="background:white; border:1px #90a8ce solid; border-radius:5px;padding:30px;margin:20px;">

<h2>Edit Error Message</h2>

<?php echo $this->form->create($model->name); ?>
<hr>
<?php 
	echo "<a class='button-primary' href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'index',)).">All Response Codes</a>";
	echo " <a class='button-primary' href=".mvc_admin_url(array('controller' => 'traffic_links', 'action' => 'index',)).">Redirect URL</a>";
	
	//if($model->code_type == 2){
		$display_l="block";
	//}
	//else{$display_l="none";}
?>
<hr>

<div>Is the code an Error</div>
<div><?php echo $this->form->select_from_model('code_type',$TraficType, array(), array('label' => ''));?> </div>
<div>Code Name</div>
<div><?php echo $this->form->input('error_link', array('label' => ''),  array('style' => 'width: 200px;'));?></div>
<div>The Code</div>
<div><?php echo $this->form->input('error_id', array('label' => '')); ?></div>
<div style="display:<?php echo $display_l; ?>;" class="code_m_select_div">Code Error Message</div>
<div style="display:<?php echo $display_l; ?>;" class="code_m_select_div"><?php echo $this->form->input('error_message', array('label' => '')); ?></div>

<hr>
<?php echo $this->form->end('Update');  ?>
<?php echo " <a href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'delete', 'id' => $object->__id)).">Delete</a>"; ?>

</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#TrafficManager_code_type_select').change(function(){
	if($('#TrafficManager_code_type_select').val() == 1)
		$('.code_m_select_div').show();
	else{
		$('.code_m_select_div').hide();
		$('#TrafficManagerErrorMessage').val('');
		}
	});});
</script>