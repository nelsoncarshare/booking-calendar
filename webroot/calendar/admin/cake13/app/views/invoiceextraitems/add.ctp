<div class="invoiceextraitems form">
<?php echo $this->Form->create('Invoiceextraitem');?>
	<fieldset>
		<legend><?php __('Add Invoiceextraitem'); ?></legend>
	<?php
		echo $this->Form->input('billing_id');
		echo $this->Form->input('invoicable_id');        
		echo $this->Form->input('item');
//		echo $this->Form->input('acnt_code');

		echo $this->Form->label('Accnt Code');
		echo $this->Form->select('acnt_code_new', $chartofaccounts);

		echo $this->Form->input('taxcode');
		echo $this->Form->input('ammount');
		echo $this->Form->input('comment');
		echo $this->Form->input('cost_per_unit');
		echo $this->Form->input('number_of_units');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Invoiceextraitems', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Billings', true), array('controller' => 'billings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing', true), array('controller' => 'billings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
	</ul>
</div>