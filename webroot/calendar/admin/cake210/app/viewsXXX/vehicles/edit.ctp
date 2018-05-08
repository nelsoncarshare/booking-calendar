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
		<legend><?php echo __('Edit Vehicle'); ?></legend>
	<?php
        
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('vehicle_number');
		echo $this->Form->select('vehicle_type', $vehicletypes, $data['Vehicle']['vehicle_type']);

		echo $this->Form->label('Accnt Code Gas');
		echo $this->Form->select('acnt_new_code_gas', $chartofaccounts, $data['Vehicle']['acnt_new_code_gas']);
		echo $this->Form->label('Accnt Code Admin');
		echo $this->Form->select('acnt_new_code_admin', $chartofaccounts, $data['Vehicle']['acnt_new_code_admin']);
		echo $this->Form->label('Accnt Code Repair');
		echo $this->Form->select('acnt_new_code_repair', $chartofaccounts, $data['Vehicle']['acnt_new_code_repair']);
		echo $this->Form->label('Accnt Code Insurance');
		echo $this->Form->select('acnt_new_code_insurance', $chartofaccounts, $data['Vehicle']['acnt_new_code_insurance']);
		echo $this->Form->label('Accnt Code Fines');
		echo $this->Form->select('acnt_new_code_fines', $chartofaccounts, $data['Vehicle']['acnt_new_code_fines']);
		echo $this->Form->label('Accnt Code Misc 2');
		echo $this->Form->select('acnt_new_code_misc_2', $chartofaccounts, $data['Vehicle']['acnt_new_code_misc_2']);
		echo $this->Form->label('Accnt Code Misc 3');
		echo $this->Form->select('acnt_new_code_misc_3', $chartofaccounts, $data['Vehicle']['acnt_new_code_misc_3']);
		echo $this->Form->label('Accnt Code Misc 4');
		echo $this->Form->select('acnt_new_code_misc_4', $chartofaccounts, $data['Vehicle']['acnt_new_code_misc_4']);
		echo $this->Form->label('Accnt Code Hours');
		echo $this->Form->select('acnt_new_code_hours', $chartofaccounts, $data['Vehicle']['acnt_new_code_hours']);
		echo $this->Form->label('Accnt Code Blocked Time');
		echo $this->Form->select('acnt_new_code_blocked_time', $chartofaccounts, $data['Vehicle']['acnt_new_code_blocked_time']);
		echo $this->Form->label('Accnt Code KM');
		echo $this->Form->select('acnt_new_code_km', $chartofaccounts, $data['Vehicle']['acnt_new_code_km']);
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Vehicle.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Vehicle.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Vehicles'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>