<div class="invoiceextraitems index">
	<h2><?php echo __('Invoiceextraitems');?></h2>
    <div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php echo __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('billing_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id_depricated');?></th>
			<th><?php echo $this->Paginator->sort('item');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code');?></th>
			<th><?php echo $this->Paginator->sort('taxcode');?></th>
			<th><?php echo $this->Paginator->sort('ammount');?></th>
			<th><?php echo $this->Paginator->sort('comment');?></th>
			<th><?php echo $this->Paginator->sort('cost_per_unit');?></th>
			<th><?php echo $this->Paginator->sort('number_of_units');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('invoicable_id');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($invoiceextraitems as $invoiceextraitem):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $invoiceextraitem['Invoiceextraitem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invoiceextraitem['Invoiceextraitem']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $invoiceextraitem['Invoiceextraitem']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $invoiceextraitem['Invoiceextraitem']['id'])); ?>
		</td>
        <td><?php echo $invoiceextraitem['Invoiceextraitem']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($invoiceextraitem['Billing']['month'], array('controller' => 'billings', 'action' => 'view', $invoiceextraitem['Billing']['id'])); ?>
		</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['user_id_depricated']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['item']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['acnt_code']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['taxcode']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['ammount']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['comment']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['cost_per_unit']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['number_of_units']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['name']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['modified']; ?>&nbsp;</td>
		<td><?php echo $invoiceextraitem['Invoiceextraitem']['created']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($invoiceextraitem['Invoicable']['id'], array('controller' => 'invoicables', 'action' => 'view', $invoiceextraitem['Invoicable']['id'])); ?>
		</td>

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
		<li><?php echo $this->Html->link(__('New Invoiceextraitem'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Billings'), array('controller' => 'billings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing'), array('controller' => 'billings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables'), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable'), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
	</ul>
</div>