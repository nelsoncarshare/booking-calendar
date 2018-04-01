<div class="users index">
    <div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>

	<h2><?php __('Users');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php __('Actions');?></th>
            <th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('displayname');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<th><?php echo $this->Paginator->sort('account code');?></th>
			<th><?php echo $this->Paginator->sort('lic. Expire');?></th>
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
			<th><?php echo $this->Paginator->sort('group_id');?></th>
			<th><?php echo $this->Paginator->sort('lastNoticeSentOn');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
		</td>
        <td><?php echo $user['User']['id']; ?>&nbsp;</td>
		<td><?php echo $user['User']['displayname']; ?>&nbsp;</td>
		<td><?php echo $user['User']['username']; ?>&nbsp;</td>
		<td><?php echo $user['User']['acnt_code_customer']; ?>&nbsp;</td>
		<td><?php echo $user['User']['licenseExpiresOn']; ?>&nbsp;</td>		
		<td><?php echo $user['User']['email']; ?>&nbsp;</td>
		<td><?php echo $user['User']['phone']; ?>&nbsp;</td>
		<td><?php echo $user['User']['address1']; ?>&nbsp;</td>
		<td><?php echo $user['User']['address2']; ?>&nbsp;</td>
		<td><?php echo $user['User']['city']; ?>&nbsp;</td>
		<td><?php echo $user['User']['province']; ?>&nbsp;</td>
		<td><?php echo $user['User']['postalcode']; ?>&nbsp;</td>
		<td><?php echo $user['User']['disabled']; ?>&nbsp;</td>
		<td><?php echo $user['User']['created']; ?>&nbsp;</td>
		<td><?php echo $user['User']['modified']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['Group']['grp_displayname'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
		</td>
		<td><?php echo $user['User']['lastNoticeSentOn']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
<br/>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Download All', true), array('action' => 'export.csv')); ?></li>	
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions', true), array('controller' => 'permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission', true), array('controller' => 'permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>