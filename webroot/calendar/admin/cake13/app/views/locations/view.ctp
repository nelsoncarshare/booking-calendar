<div class="locations view">
<h2><?php  __('Location');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['address1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['comment']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('URL'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['URL']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('GPS Coord X'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['GPS_coord_x']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('GPS Coord Y'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['GPS_coord_y']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Location', true), array('action' => 'edit', $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Location', true), array('action' => 'delete', $location['Location']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $location['Location']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Bookables');?></h3>
	<?php if (!empty($location['Bookable'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Vehicle Id'); ?></th>
		<th><?php __('Location Id'); ?></th>
		<th><?php __('Color'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<th><?php __('Hourly Rate Low'); ?></th>
		<th><?php __('Hourly Rate High'); ?></th>
		<th><?php __('Rate Cutoff'); ?></th>
		<th><?php __('Is Flat Daily Rate'); ?></th>
		<th><?php __('Daily Rate Low'); ?></th>
		<th><?php __('Daily Rate'); ?></th>
		<th><?php __('Km Rate Low'); ?></th>
		<th><?php __('Km Rate Med'); ?></th>
		<th><?php __('Km Rate High'); ?></th>
		<th><?php __('Charge Bc Rental Tax'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'bookables', 'action' => 'view', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'bookables', 'action' => 'edit', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'bookables', 'action' => 'delete', $bookable['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bookable['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
