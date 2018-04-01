<div class="invoiceextraitems view">
<h2><?php  __('Invoiceextraitem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Billing'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($invoiceextraitem['Billing']['month'], array('controller' => 'billings', 'action' => 'view', $invoiceextraitem['Billing']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id Depricated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['user_id_depricated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['item']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acnt Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['acnt_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Taxcode'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['taxcode']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ammount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['ammount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['comment']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cost Per Unit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['cost_per_unit']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number Of Units'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['number_of_units']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $invoiceextraitem['Invoiceextraitem']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Invoicable'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($invoiceextraitem['Invoicable']['id'], array('controller' => 'invoicables', 'action' => 'view', $invoiceextraitem['Invoicable']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoiceextraitem', true), array('action' => 'edit', $invoiceextraitem['Invoiceextraitem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Invoiceextraitem', true), array('action' => 'delete', $invoiceextraitem['Invoiceextraitem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $invoiceextraitem['Invoiceextraitem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoiceextraitems', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoiceextraitem', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Billings', true), array('controller' => 'billings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Billing', true), array('controller' => 'billings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoicables', true), array('controller' => 'invoicables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoicable', true), array('controller' => 'invoicables', 'action' => 'add')); ?> </li>
	</ul>
</div>
