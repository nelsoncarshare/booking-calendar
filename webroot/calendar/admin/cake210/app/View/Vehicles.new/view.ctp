<div class="vehicles view">
<h2><?php echo __('Vehicle'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vehicle Number'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['vehicle_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vehicle Type'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['vehicle_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Gas'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_gas']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Admin'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_admin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Repair'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_repair']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Insurance'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_insurance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Misc 1'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_misc_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Misc 2'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_misc_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Misc 3'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_misc_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Misc 4'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_misc_4']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Hours'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_hours']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Blocked Time'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_blocked_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Km'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_code_km']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Gas'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_gas']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Admin'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_admin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Repair'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_repair']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Insurance'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_insurance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Fines'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_fines']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Misc 2'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_misc_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Misc 3'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_misc_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Misc 4'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_misc_4']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Hours'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_hours']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Blocked Time'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_blocked_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt New Code Km'); ?></dt>
		<dd>
			<?php echo h($vehicle['Vehicle']['acnt_new_code_km']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vehicle'), array('action' => 'edit', $vehicle['Vehicle']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vehicle'), array('action' => 'delete', $vehicle['Vehicle']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $vehicle['Vehicle']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicletypes'), array('controller' => 'vehicletypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicletype'), array('controller' => 'vehicletypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Vehicletypes'); ?></h3>
	<?php if (!empty($vehicle['Vehicletype'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $vehicle['Vehicletype']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
	<?php echo $vehicle['Vehicletype']['type']; ?>
&nbsp;</dd>
		<dt><?php echo __('Imagefile'); ?></dt>
		<dd>
	<?php echo $vehicle['Vehicletype']['imagefile']; ?>
&nbsp;</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
	<?php echo $vehicle['Vehicletype']['modified']; ?>
&nbsp;</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
	<?php echo $vehicle['Vehicletype']['created']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Vehicletype'), array('controller' => 'vehicletypes', 'action' => 'edit', $vehicle['Vehicletype']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php echo __('Related Bookables'); ?></h3>
	<?php if (!empty($vehicle['Bookable'])): ?>
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
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($vehicle['Bookable'] as $bookable): ?>
		<tr>
			<td><?php echo $bookable['id']; ?></td>
			<td><?php echo $bookable['name']; ?></td>
			<td><?php echo $bookable['vehicle_id']; ?></td>
			<td><?php echo $bookable['location_id']; ?></td>
			<td><?php echo $bookable['color']; ?></td>
			<td><?php echo $bookable['disabled']; ?></td>
			<td><?php echo $bookable['hourly_rate_low']; ?></td>
			<td><?php echo $bookable['hourly_rate_high']; ?></td>
			<td><?php echo $bookable['rate_cutoff']; ?></td>
			<td><?php echo $bookable['is_flat_daily_rate']; ?></td>
			<td><?php echo $bookable['daily_rate_low']; ?></td>
			<td><?php echo $bookable['daily_rate']; ?></td>
			<td><?php echo $bookable['km_rate_low']; ?></td>
			<td><?php echo $bookable['km_rate_med']; ?></td>
			<td><?php echo $bookable['km_rate_high']; ?></td>
			<td><?php echo $bookable['charge_bc_rental_tax']; ?></td>
			<td><?php echo $bookable['created']; ?></td>
			<td><?php echo $bookable['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bookables', 'action' => 'view', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bookables', 'action' => 'edit', $bookable['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bookables', 'action' => 'delete', $bookable['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bookable['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
