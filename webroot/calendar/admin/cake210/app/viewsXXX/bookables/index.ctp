<div class="bookables index">
	<h2><?php echo __('Bookables');?></h2>
    <div>[Back To Admin]</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php echo __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('vehicle_id');?></th>
			<th><?php echo $this->Paginator->sort('location_id');?></th>
			<th><?php echo $this->Paginator->sort('color');?></th>
			<th><?php echo $this->Paginator->sort('disabled');?></th>
			<th><?php echo $this->Paginator->sort('hourly_rate_low');?></th>
			<th><?php echo $this->Paginator->sort('hourly_rate_high');?></th>
			<th><?php echo $this->Paginator->sort('rate_cutoff');?></th>
			<th><?php echo $this->Paginator->sort('is_flat_daily_rate');?></th>
			<th><?php echo $this->Paginator->sort('daily_rate_low');?></th>
			<th><?php echo $this->Paginator->sort('daily_rate');?></th>
			<th><?php echo $this->Paginator->sort('km_rate_low');?></th>
			<th><?php echo $this->Paginator->sort('km_rate_med');?></th>
			<th><?php echo $this->Paginator->sort('km_rate_high');?></th>
			<th><?php echo $this->Paginator->sort('charge_bc_rental_tax');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($bookables as $bookable):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $bookable['Bookable']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bookable['Bookable']['id'])); ?>
		</td>
        <td><?php echo $bookable['Bookable']['id']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bookable['Vehicle']['name'], array('controller' => 'vehicles', 'action' => 'view', $bookable['Vehicle']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($bookable['Location']['name'], array('controller' => 'locations', 'action' => 'view', $bookable['Location']['id'])); ?>
		</td>
		<td><?php echo $bookable['Bookable']['color']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['disabled']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['hourly_rate_low']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['hourly_rate_high']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['rate_cutoff']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['is_flat_daily_rate']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['daily_rate_low']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['daily_rate']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['km_rate_low']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['km_rate_med']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['km_rate_high']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['charge_bc_rental_tax']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['created']; ?>&nbsp;</td>
		<td><?php echo $bookable['Bookable']['modified']; ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Download All'), array('action' => 'export.csv')); ?></li>	
		<li><?php echo $this->Html->link(__('New Bookable'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vehicles'), array('controller' => 'vehicles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle'), array('controller' => 'vehicles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>