<div class="vehicles index">
	<h2><?php echo __('Vehicles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('vehicle_number'); ?></th>
			<th><?php echo $this->Paginator->sort('vehicle_type'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_gas'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_admin'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_repair'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_insurance'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_misc_1'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_misc_2'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_misc_3'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_misc_4'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_hours'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_blocked_time'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_km'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_gas'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_admin'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_repair'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_insurance'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_fines'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_misc_2'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_misc_3'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_misc_4'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_hours'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_blocked_time'); ?></th>
			<th><?php echo $this->Paginator->sort('acnt_new_code_km'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($vehicles as $vehicle): ?>
	<tr>
		<td><?php echo h($vehicle['Vehicle']['id']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['name']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['vehicle_number']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['vehicle_type']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_gas']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_admin']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_repair']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_insurance']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_misc_1']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_misc_2']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_misc_3']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_misc_4']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_hours']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_blocked_time']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_code_km']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['modified']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['created']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_gas']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_admin']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_repair']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_insurance']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_fines']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_misc_2']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_misc_3']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_misc_4']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_hours']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_blocked_time']); ?>&nbsp;</td>
		<td><?php echo h($vehicle['Vehicle']['acnt_new_code_km']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $vehicle['Vehicle']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vehicle['Vehicle']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vehicle['Vehicle']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $vehicle['Vehicle']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Vehicle'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vehicletypes'), array('controller' => 'vehicletypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicletype'), array('controller' => 'vehicletypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
