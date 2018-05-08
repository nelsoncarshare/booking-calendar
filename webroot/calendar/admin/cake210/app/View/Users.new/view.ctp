<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Displayname'); ?></dt>
		<dd>
			<?php echo h($user['User']['displayname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accountingname'); ?></dt>
		<dd>
			<?php echo h($user['User']['accountingname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Permission'); ?></dt>
		<dd>
			<?php echo h($user['User']['permission']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($user['User']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address1'); ?></dt>
		<dd>
			<?php echo h($user['User']['address1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($user['User']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($user['User']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Province'); ?></dt>
		<dd>
			<?php echo h($user['User']['province']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postalcode'); ?></dt>
		<dd>
			<?php echo h($user['User']['postalcode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disabled'); ?></dt>
		<dd>
			<?php echo h($user['User']['disabled']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activated'); ?></dt>
		<dd>
			<?php echo h($user['User']['activated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['grp_displayname'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LastNoticeSentOn'); ?></dt>
		<dd>
			<?php echo h($user['User']['lastNoticeSentOn']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LicenseExpiresOn'); ?></dt>
		<dd>
			<?php echo h($user['User']['licenseExpiresOn']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acnt Code Customer'); ?></dt>
		<dd>
			<?php echo h($user['User']['acnt_code_customer']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables'), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable'), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions'), array('controller' => 'permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission'), array('controller' => 'permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Invoicables'); ?></h3>
	<?php if (!empty($user['Invoicable'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Force User Member Plan'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Invoicable'] as $invoicable): ?>
		<tr>
			<td><?php echo $invoicable['id']; ?></td>
			<td><?php echo $invoicable['user_id']; ?></td>
			<td><?php echo $invoicable['group_id']; ?></td>
			<td><?php echo $invoicable['type']; ?></td>
			<td><?php echo $invoicable['force_user_member_plan']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'invoicables', 'action' => 'view', $invoicable['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'invoicables', 'action' => 'edit', $invoicable['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'invoicables', 'action' => 'delete', $invoicable['id']), array('confirm' => __('Are you sure you want to delete # %s?', $invoicable['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Invoicable'), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Permissions'); ?></h3>
	<?php if (!empty($user['Permission'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Permission'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Permission'] as $permission): ?>
		<tr>
			<td><?php echo $permission['id']; ?></td>
			<td><?php echo $permission['permission']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'permissions', 'action' => 'view', $permission['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'permissions', 'action' => 'edit', $permission['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'permissions', 'action' => 'delete', $permission['id']), array('confirm' => __('Are you sure you want to delete # %s?', $permission['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Permission'), array('controller' => 'permissions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
