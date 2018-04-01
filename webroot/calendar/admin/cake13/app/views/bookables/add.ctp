<div class="bookables form">
<?php echo $this->Form->create('Bookable');?>
	<fieldset>
		<legend><?php __('Add Bookable'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('vehicle_id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('color');
		echo $this->Form->input('disabled');
		echo $this->Form->input('hourly_rate_low');
		echo $this->Form->input('hourly_rate_high');
		echo $this->Form->input('rate_cutoff');
		echo $this->Form->input('is_flat_daily_rate');
		echo $this->Form->input('daily_rate_low');
		echo $this->Form->input('daily_rate');
		echo $this->Form->input('km_rate_low');
		echo $this->Form->input('km_rate_med');
		echo $this->Form->input('km_rate_high');
		echo $this->Form->input('charge_bc_rental_tax');
		echo $this->Form->input('Calendar');
		echo $this->Form->input('Announcement');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Bookables', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Vehicles', true), array('controller' => 'vehicles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle', true), array('controller' => 'vehicles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations', true), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location', true), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>