<div class="locations view">
<h2><?php echo __('Location');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Address1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['address1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Comment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['comment']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('URL'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['URL']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('GPS Coord X'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['GPS_coord_x']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('GPS Coord Y'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['GPS_coord_y']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Location'), array('action' => 'edit', $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Location'), array('action' => 'delete', $location['Location']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Bookables');?></h3>
	<?php if (!empty($location['Bookable'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Vehicle Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Disabled'); ?></th>
		<th><?php echo __('Hourly Rate Low'); ?></th>
		<th><?php echo __('Hourly Rate High'); ?></th>
		<th><?php echo __('Rate Cutoff'); ?></th>
		<th><?php echo __('Is Flat Daily Rate'); ?></th>
		<th><?php echo __('Daily Rate Low'); ?></th>
		<th><?php echo __('Daily Rate'); ?></th>
		<th><?php echo __('Km Rate Low'); ?></th>
		<th><?php echo __('Km Rate Med'); ?></th>
		<th><?php echo __('Km Rate High'); ?></th>
		<th><?php echo __('Charge Bc Rental Tax'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($location['Bookable'] as $bookable):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $bookable['id'];?></td>
			<td><?php echo $bookable['name'];?></td>
			<td><?php echo $bookable['vehicle_id'];?></td>
			<td><?php echo $bookable['location_id'];?></td>
			<td><?php echo $bookable['color'];?></td>
			<td><?php echo $bookable['disabled'];?></td>
			<td><?php echo $bookable['hourly_rate_low'];?></td>
			<td><?php echo $bookable['hourly_rate_high'];?></td>
			<td><?php echo $bookable['rate_cutoff'];?></td>
			<td><?php echo $bookable['is_flat_daily_rate'];?></td>
			<td><?php echo $bookable['daily_rate_low'];?></td>
			<td><?php echo $bookable['daily_rate'];?></td>
			<td><?php echo $bookable['km_rate_low'];?></td>
			<td><?php echo $bookable['km_rate_med'];?></td>
			<td><?php echo $bookable['km_rate_high'];?></td>
			<td><?php echo $bookable['charge_bc_rental_tax'];?></td>
			<td><?php echo $bookable['created'];?></td>
			<td><?php echo $bookable['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bookables', 'action' => 'view', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bookables', 'action' => 'edit', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'bookables', 'action' => 'delete', $bookable['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $bookable['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
