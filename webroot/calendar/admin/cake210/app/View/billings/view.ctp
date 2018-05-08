<div class="billings view">
<h2><?php echo __('Billing');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Month'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['month']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Gas Surcharge Per Km Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['gas_surcharge_per_km_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan Low Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_low_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan Med Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_med_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan High Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_high_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan Organization Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_organization_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan Low Cutoff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_low_cutoff']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Member Plan Med Cutoff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['member_plan_med_cutoff']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Carbon Offset Per Km Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['carbon_offset_per_km_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Self Insurance Per Km Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['self_insurance_per_km_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Pst'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['pst']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Gst'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['gst']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rental Tax Per Day'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['rental_tax_per_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Dont Charge Interest Below'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['dont_charge_interest_below']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Late Payment Interest'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['late_payment_interest']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Long Time Member Discount Percent'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['long_time_member_discount_percent']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Long Time Member Discount Max'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['long_time_member_discount_max']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Pst'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_pst']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Gst'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_gst']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rental Tax Acnt Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['rental_tax_acnt_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Gas Surcharge'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_gas_surcharge']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Self Insurance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_self_insurance']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Carbon Offset'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_carbon_offset']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Member Plan Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_member_plan_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Member Plan Med'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_member_plan_med']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Member Plan High'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_member_plan_high']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Member Plan Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_member_plan_organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Accounts Receivable'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_accounts_receivable']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Long Term Member Discount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_long_term_member_discount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Acnt Code Interest Charged'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['acnt_code_interest_charged']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Invoice Num To Start At'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['invoice_num_to_start_at']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Invoice Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['invoice_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Invoice Due Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['invoice_due_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Long Term Discount Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $billing['Billing']['long_term_discount_year']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Billing'), array('action' => 'edit', $billing['Billing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Billing'), array('action' => 'delete', $billing['Billing']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $billing['Billing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Billings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoiceextraitems'), array('controller' => 'invoiceextraitems', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoiceextraitem'), array('controller' => 'invoiceextraitems', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Invoiceextraitems');?></h3>
	<?php if (!empty($billing['Invoiceextraitem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Billing Id'); ?></th>
		<th><?php echo __('User Id Depricated'); ?></th>
		<th><?php echo __('Item'); ?></th>
		<th><?php echo __('Acnt Code'); ?></th>
		<th><?php echo __('Taxcode'); ?></th>
		<th><?php echo __('Ammount'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Cost Per Unit'); ?></th>
		<th><?php echo __('Number Of Units'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Invoicable Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($billing['Invoiceextraitem'] as $invoiceextraitem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $invoiceextraitem['id'];?></td>
			<td><?php echo $invoiceextraitem['billing_id'];?></td>
			<td><?php echo $invoiceextraitem['user_id_depricated'];?></td>
			<td><?php echo $invoiceextraitem['item'];?></td>
			<td><?php echo $invoiceextraitem['acnt_code'];?></td>
			<td><?php echo $invoiceextraitem['taxcode'];?></td>
			<td><?php echo $invoiceextraitem['ammount'];?></td>
			<td><?php echo $invoiceextraitem['comment'];?></td>
			<td><?php echo $invoiceextraitem['cost_per_unit'];?></td>
			<td><?php echo $invoiceextraitem['number_of_units'];?></td>
			<td><?php echo $invoiceextraitem['name'];?></td>
			<td><?php echo $invoiceextraitem['modified'];?></td>
			<td><?php echo $invoiceextraitem['created'];?></td>
			<td><?php echo $invoiceextraitem['invoicable_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'invoiceextraitems', 'action' => 'view', $invoiceextraitem['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'invoiceextraitems', 'action' => 'edit', $invoiceextraitem['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'invoiceextraitems', 'action' => 'delete', $invoiceextraitem['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $invoiceextraitem['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Invoiceextraitem'), array('controller' => 'invoiceextraitems', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
