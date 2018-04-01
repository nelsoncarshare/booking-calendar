<div class="groups index">
	<h2><?php __('Groups');?></h2>
    <div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('grp_displayname');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_group_customer');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('address1');?></th>
			<th><?php echo $this->Paginator->sort('address2');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('province');?></th>
			<th><?php echo $this->Paginator->sort('postalcode');?></th>
			<th><?php echo $this->Paginator->sort('disabled');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('activated');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($groups as $group):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $group['Group']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $group['Group']['id'])); ?>
		</td>
		<td><?php echo $group['Group']['id']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['type']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['grp_displayname']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['acnt_code_group_customer']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['email']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['phone']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['address1']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['address2']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['city']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['province']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['postalcode']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['disabled']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['created']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['modified']; ?>&nbsp;</td>
		<td><?php echo $group['Group']['activated']; ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Download All', true), array('action' => 'export.csv')); ?></li>	
		<li><?php echo $this->Html->link(__('New Group', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Grouptypes', true), array('controller' => 'grouptypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grouptype', true), array('controller' => 'grouptypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>