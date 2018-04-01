<div class="vehicles view">
<h2><?php  __('Vehicle');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Vehicle Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['vehicle_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Vehicle Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['vehicle_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Gas'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_gas']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Admin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_admin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Repair'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_repair']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Insurance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_insurance']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Fines'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_misc_1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Misc 2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_misc_2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Misc 3'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_misc_3']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Misc 4'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_misc_4']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Hours'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_hours']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Blocked Time'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_blocked_time']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code Km'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['acnt_code_km']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $vehicle['Vehicle']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vehicle', true), array('action' => 'edit', $vehicle['Vehicle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Vehicle', true), array('action' => 'delete', $vehicle['Vehicle']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vehicle['Vehicle']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicles', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Bookables');?></h3>
	<?php if (!empty($vehicle['Bookable'])):?>
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
		foreach ($vehicle['Bookable'] as $bookable):
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
