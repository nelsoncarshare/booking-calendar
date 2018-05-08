<div class="vehicles form">
<?php echo $this->Form->create('Vehicle'); ?>
	<fieldset>
		<legend><?php echo __('Add Vehicle'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('vehicle_number');
		echo $this->Form->input('vehicle_type');
		echo $this->Form->input('acnt_code_gas');
		echo $this->Form->input('acnt_code_admin');
		echo $this->Form->input('acnt_code_repair');
		echo $this->Form->input('acnt_code_insurance');
		echo $this->Form->input('acnt_code_misc_1');
		echo $this->Form->input('acnt_code_misc_2');
		echo $this->Form->input('acnt_code_misc_3');
		echo $this->Form->input('acnt_code_misc_4');
		echo $this->Form->input('acnt_code_hours');
		echo $this->Form->input('acnt_code_blocked_time');
		echo $this->Form->input('acnt_code_km');
		echo $this->Form->input('acnt_new_code_gas');
		echo $this->Form->input('acnt_new_code_admin');
		echo $this->Form->input('acnt_new_code_repair');
		echo $this->Form->input('acnt_new_code_insurance');
		echo $this->Form->input('acnt_new_code_fines');
		echo $this->Form->input('acnt_new_code_misc_2');
		echo $this->Form->input('acnt_new_code_misc_3');
		echo $this->Form->input('acnt_new_code_misc_4');
		echo $this->Form->input('acnt_new_code_hours');
		echo $this->Form->input('acnt_new_code_blocked_time');
		echo $this->Form->input('acnt_new_code_km');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vehicles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Vehicletypes'), array('controller' => 'vehicletypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicletype'), array('controller' => 'vehicletypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
