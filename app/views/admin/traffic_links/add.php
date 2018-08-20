<div style="background:white; border:1px #90a8ce solid; border-radius:5px; padding:30px;margin:20px;">

<h2>Redirect URL</h2>

<?php echo $this->form->create($model->name); ?>
<hr>
<?php echo "<a class='button-primary' href=".mvc_admin_url(array('controller' => 'traffic_managers', 'action' => 'index',)).">All Error Messages</a>";	?>	
<hr>

<div>Enter link URL after API submission</div>
<div><?php echo $this->form->input('url', array('label' => ''),  array());?></div>

<hr>
<?php echo $this->form->end('Save',array('class' => 'button-primary')); ?>
</div>