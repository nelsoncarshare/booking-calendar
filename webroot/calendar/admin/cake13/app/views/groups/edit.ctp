<div class="groups form">
<?php echo $this->Form->create('Group');?>
	<fieldset>
		<legend><?php __('Edit Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
        echo $this->Form->input('force_user_member_plan', array('type'=>'checkbox'));
		echo $this->Form->input('type', array('type'=>'hidden'));
		echo $this->Form->input('grp_displayname');
		echo $this->Form->label('Accnt Code Customer');
		echo $this->Form->select('acnt_code_group_customer', $chartofaccounts);
		echo $this->Form->input('email');
		echo $this->Form->input('phone');
		echo $this->Form->input('address1');
		echo $this->Form->input('address2');
		echo $this->Form->input('city');
		echo $this->Form->input('province');
		echo $this->Form->input('postalcode');
		echo $this->Form->input('disabled');
		echo $this->Form->input('activated');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Group.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Grouptypes', true), array('controller' => 'grouptypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grouptype', true), array('controller' => 'grouptypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>