<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('displayname');
		echo $this->Form->input('username');
		echo $this->Form->input('accountingname');
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
		echo $this->Form->input('acnt_code_customer');
		echo $this->Form->input('Permission');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables'), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable'), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions'), array('controller' => 'permissions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission'), array('controller' => 'permissions', 'action' => 'add')); ?> </li>
	</ul>
</div>
