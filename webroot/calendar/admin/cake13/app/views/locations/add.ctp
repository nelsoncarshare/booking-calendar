<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
		<legend><?php __('Add Location'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('address1');
		echo $this->Form->input('city');
		echo $this->Form->input('comment');
		echo $this->Form->input('URL');
		echo $this->Form->input('GPS_coord_x');
		echo $this->Form->input('GPS_coord_y');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Locations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>