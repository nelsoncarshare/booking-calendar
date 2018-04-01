<div class="billings index">
	<h2><?php __('Billings');?></h2>
    <div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th class="actions"><?php __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('year');?></th>
			<th><?php echo $this->Paginator->sort('month');?></th>
			<th><?php echo $this->Paginator->sort('gas_surcharge_per_km_rate');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_low_rate');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_med_rate');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_high_rate');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_organization_rate');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_low_cutoff');?></th>
			<th><?php echo $this->Paginator->sort('member_plan_med_cutoff');?></th>
			<th><?php echo $this->Paginator->sort('carbon_offset_per_km_rate');?></th>
			<th><?php echo $this->Paginator->sort('self_insurance_per_km_rate');?></th>
			<th><?php echo $this->Paginator->sort('pst');?></th>
			<th><?php echo $this->Paginator->sort('gst');?></th>
			<th><?php echo $this->Paginator->sort('rental_tax_per_day');?></th>
			<th><?php echo $this->Paginator->sort('dont_charge_interest_below');?></th>
			<th><?php echo $this->Paginator->sort('late_payment_interest');?></th>
			<th><?php echo $this->Paginator->sort('day_rate_start_hour');?></th>
			<th><?php echo $this->Paginator->sort('day_rate_end_hour');?></th>

			<th><?php echo $this->Paginator->sort('acnt_code_pst');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_gst');?></th>
			<th><?php echo $this->Paginator->sort('rental_tax_acnt_code');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_gas_surcharge');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_self_insurance');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_carbon_offset');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_member_plan_low');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_member_plan_med');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_member_plan_high');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_member_plan_organization');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_accounts_receivable');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_long_term_member_discount');?></th>
			<th><?php echo $this->Paginator->sort('acnt_code_interest_charged');?></th>
			<th><?php echo $this->Paginator->sort('invoice_num_to_start_at');?></th>
			<th><?php echo $this->Paginator->sort('invoice_date');?></th>
			<th><?php echo $this->Paginator->sort('invoice_due_date');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			
	</tr>
	<?php
	$i = 0;
	foreach ($billings as $billing):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $billing['Billing']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $billing['Billing']['id'])); ?>
            <?php echo $this->Html->link('Prev Owing', array('controller' => 'invoiceprevtotal2', 'action' => 'index', $billing['Billing']['id']) )?>
		</td>    
		<td><?php echo $billing['Billing']['id']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['year']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['month']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['gas_surcharge_per_km_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_low_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_med_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_high_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_organization_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_low_cutoff']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['member_plan_med_cutoff']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['carbon_offset_per_km_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['self_insurance_per_km_rate']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['pst']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['gst']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['rental_tax_per_day']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['dont_charge_interest_below']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['late_payment_interest']; ?>&nbsp;</td>
		
		<td><?php echo $billing['Billing']['day_rate_start_hour']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['day_rate_end_hour']; ?>&nbsp;</td>
		
		<td><?php echo $billing['Billing']['acnt_code_pst']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_gst']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['rental_tax_acnt_code']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_gas_surcharge']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_self_insurance']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_carbon_offset']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_member_plan_low']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_member_plan_med']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_member_plan_high']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_member_plan_organization']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_accounts_receivable']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_long_term_member_discount']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['acnt_code_interest_charged']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['invoice_num_to_start_at']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['invoice_date']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['invoice_due_date']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['modified']; ?>&nbsp;</td>
		<td><?php echo $billing['Billing']['created']; ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
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
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Download All', true), array('action' => 'export.csv')); ?></li>	
		<li><?php echo $this->Html->link(__('New Billing', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Invoiceextraitems', true), array('controller' => 'invoiceextraitems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoiceextraitem', true), array('controller' => 'invoiceextraitems', 'action' => 'add')); ?> </li>
	</ul>
</div>