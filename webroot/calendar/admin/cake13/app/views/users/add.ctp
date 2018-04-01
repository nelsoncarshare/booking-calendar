<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('displayname');
		echo $this->Form->input('username');
		echo $this->Form->label('Accnt Code Customer');
		echo $this->Form->select('acnt_code_customer', $chartofaccounts);
		echo $this->Form->input('password');
		echo $this->Form->input('permission');
		echo $this->Form->input('email');
		echo $this->Form->input('phone');
		echo $this->Form->input('address1');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('province');
		echo $this->Form->input('postalcode');
		echo $this->Form->input('disabled');
		echo $this->Form->input('activated');
		echo $this->Form->input('group_id');
		echo $this->Form->input('lastNoticeSentOn');
		echo $this->Form->input('licenseExpiresOn');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions', true), array('controller' => 'permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission', true), array('controller' => 'permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>