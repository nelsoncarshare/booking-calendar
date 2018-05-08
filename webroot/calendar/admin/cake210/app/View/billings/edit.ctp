<div class="billings form">
<?php echo $this->Form->create('Billing');?>
	<fieldset>
		<legend><?php echo __('Edit Billing'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('year');
		echo $this->Form->input('month');
		echo $this->Form->input('gas_surcharge_per_km_rate');
		echo $this->Form->input('member_plan_low_rate');
		echo $this->Form->input('member_plan_med_rate');
		echo $this->Form->input('member_plan_high_rate');
		echo $this->Form->input('member_plan_organization_rate');
		echo $this->Form->input('member_plan_low_cutoff');
		echo $this->Form->input('member_plan_med_cutoff');
		echo $this->Form->input('carbon_offset_per_km_rate');
		echo $this->Form->input('self_insurance_per_km_rate');
		echo $this->Form->input('pst');
		echo $this->Form->input('gst');
		echo $this->Form->input('rental_tax_per_day');
		echo $this->Form->input('dont_charge_interest_below');
		echo $this->Form->input('late_payment_interest');
		echo $this->Form->input('long_time_member_discount_percent');
		echo $this->Form->input('long_time_member_discount_max');

		echo $this->Form->input('day_rate_start_hour');
		echo $this->Form->input('day_rate_end_hour');		
		
		echo $this->Form->input('acnt_new_code_pst', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_code_gst', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_rental_tax', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_gas_surcharge', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_self_insurance', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_carbon_offset', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_member_plan_low', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_member_plan_med', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_member_plan_high', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_member_plan_organization', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_accounts_receivable', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_long_term_member_discount', array('type' => 'select', 'options' => $chartofaccounts));
		echo $this->Form->input('acnt_new_interest_charged', array('type' => 'select', 'options' => $chartofaccounts));		
		
		echo $this->Form->input('invoice_num_to_start_at');
		echo $this->Form->input('invoice_date');
		echo $this->Form->input('invoice_due_date');
		echo $this->Form->input('long_term_discount_year');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Billing.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Billing.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Billings'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Invoiceextraitems'), array('controller' => 'invoiceextraitems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoiceextraitem'), array('controller' => 'invoiceextraitems', 'action' => 'add')); ?> </li>
	</ul>
</div>