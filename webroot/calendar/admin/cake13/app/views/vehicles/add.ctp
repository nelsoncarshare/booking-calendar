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
		<legend><?php __('Add Vehicle'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->select('vehicle_type', $vehicletypes);
        echo $this->Form->input('vehicle_number');
		/*
		echo $this->Form->input('acnt_code_gas');
		echo $this->Form->input('acnt_code_admin');
		echo $this->Form->input('acnt_code_repair');
		echo $this->Form->input('acnt_code_insurance');
		echo $this->Form->input('acnt_code_misc_1', array('label' => 'Acnt Code Fines'));
		echo $this->Form->input('acnt_code_misc_2');
		echo $this->Form->input('acnt_code_misc_3');
		echo $this->Form->input('acnt_code_misc_4');
		echo $this->Form->input('acnt_code_hours');
		echo $this->Form->input('acnt_code_blocked_time');
		echo $this->Form->input('acnt_code_km');
		*/

		echo $this->Form->label('Accnt Code Gas');
		echo $this->Form->select('acnt_new_code_gas', $chartofaccounts);
		echo $this->Form->label('Accnt Code Admin');
		echo $this->Form->select('acnt_new_code_admin', $chartofaccounts);
		echo $this->Form->label('Accnt Code Repair');
		echo $this->Form->select('acnt_new_code_repair', $chartofaccounts);
		echo $this->Form->label('Accnt Code Insurance');
		echo $this->Form->select('acnt_new_code_insurance', $chartofaccounts);
		echo $this->Form->label('Accnt Code Fines');
		echo $this->Form->select('acnt_new_code_fines', $chartofaccounts);
		echo $this->Form->label('Accnt Code Misc 2');
		echo $this->Form->select('acnt_new_code_misc_2', $chartofaccounts);
		echo $this->Form->label('Accnt Code Misc 3');
		echo $this->Form->select('acnt_new_code_misc_3', $chartofaccounts);
		echo $this->Form->label('Accnt Code Misc 4');
		echo $this->Form->select('acnt_new_code_misc_4', $chartofaccounts);
		echo $this->Form->label('Accnt Code Hours');
		echo $this->Form->select('acnt_new_code_hours', $chartofaccounts);
		echo $this->Form->label('Accnt Code Blocked Time');
		echo $this->Form->select('acnt_new_code_blocked_time', $chartofaccounts);
		echo $this->Form->label('Accnt Code KM');
		echo $this->Form->select('acnt_new_code_km', $chartofaccounts);
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vehicles', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>