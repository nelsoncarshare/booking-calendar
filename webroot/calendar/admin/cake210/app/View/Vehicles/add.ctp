<div class="vehicles form">
<font color='red'><b>
WARNING! The account names entered here must match the account names in quickbooks EXACTLY. 
If they do not then Quickbooks
creates "bank" accounts when the IIF files are imported. The best way to ensure the accounts match is to copy them from quickbooks:
<ul>
	<li>Create the accounts in Quickbooks
	<li>In Quickbooks go to to File -> Utilities -> Export -> Lists to IIF files
	<li>Check "Chart of Accounts" and click O.K.
	<li>Save the iif file to a convenient place (Desktop is good)
	<li>Open the iif file you just saved using Excell or Wordpad
	<li>The second column is the name of the accounts. Find the right ones and copy and paste them into the website
</ul>
</b></font>

<?php echo $this->Form->create('Vehicle');?>
	<fieldset>
		<legend><?php echo __('Add Vehicle'); ?></legend>
	<?php
		echo $this->Form->input('name');
        echo $this->Form->input('vehicle_number');
		echo $this->Form->input('vehicle_type', array('type' => 'select', 'options' => $vehicletypes));
		echo $this->Form->input('acnt_new_code_gas', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_admin', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_repair', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_insurance', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_fines', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_misc_2', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_misc_3', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_misc_4', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_hours', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_blocked_time', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_km', array('type' => 'select', 'options' => $chartofaccounts));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vehicles'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>