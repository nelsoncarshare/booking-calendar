<div class="bookables view">
<h2><?php echo __('Bookable');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Vehicle'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bookable['Vehicle']['name'], array('controller' => 'vehicles', 'action' => 'view', $bookable['Vehicle']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bookable['Location']['name'], array('controller' => 'locations', 'action' => 'view', $bookable['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Color'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['color']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Hourly Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['hourly_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Hourly Rate High'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['hourly_rate_high']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rate Cutoff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['rate_cutoff']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Is Flat Daily Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['is_flat_daily_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Daily Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['daily_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Daily Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['daily_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Km Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Km Rate Med'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_med']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Km Rate High'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_high']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Charge Bc Rental Tax'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['charge_bc_rental_tax']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bookable'), array('action' => 'edit', $bookable['Bookable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Bookable'), array('action' => 'delete', $bookable['Bookable']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $bookable['Bookable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicles'), array('controller' => 'vehicles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle'), array('controller' => 'vehicles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Calendars');?></h3>
	<?php if (!empty($bookable['Calendar'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Calendar'); ?></th>
		<th><?php echo __('Hours 24'); ?></th>
		<th><?php echo __('Start Monday'); ?></th>
		<th><?php echo __('Translate'); ?></th>
		<th><?php echo __('Anon Permission'); ?></th>
		<th><?php echo __('Subject Max'); ?></th>
		<th><?php echo __('Contact Name'); ?></th>
		<th><?php echo __('Contact Email'); ?></th>
		<th><?php echo __('Calendar Title'); ?></th>
		<th><?php echo __('Url'); ?></th>
		<th><?php echo __('Calendar File Name'); ?></th>
		<th><?php echo __('Latitude'); ?></th>
		<th><?php echo __('Longitude'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bookable['Calendar'] as $calendar):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $calendar['id'];?></td>
			<td><?php echo $calendar['calendar'];?></td>
			<td><?php echo $calendar['hours_24'];?></td>
			<td><?php echo $calendar['start_monday'];?></td>
			<td><?php echo $calendar['translate'];?></td>
			<td><?php echo $calendar['anon_permission'];?></td>
			<td><?php echo $calendar['subject_max'];?></td>
			<td><?php echo $calendar['contact_name'];?></td>
			<td><?php echo $calendar['contact_email'];?></td>
			<td><?php echo $calendar['calendar_title'];?></td>
			<td><?php echo $calendar['url'];?></td>
			<td><?php echo $calendar['calendar_file_name'];?></td>
			<td><?php echo $calendar['latitude'];?></td>
			<td><?php echo $calendar['longitude'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'calendars', 'action' => 'view', $calendar['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'calendars', 'action' => 'edit', $calendar['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'calendars', 'action' => 'delete', $calendar['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $calendar['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Announcements');?></h3>
	<?php if (!empty($bookable['Announcement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Disabled'); ?></th>
		<th><?php echo __('Display On Day'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($bookable['Announcement'] as $announcement):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $announcement['id'];?></td>
			<td><?php echo $announcement['text'];?></td>
			<td><?php echo $announcement['title'];?></td>
			<td><?php echo $announcement['disabled'];?></td>
			<td><?php echo $announcement['display_on_day'];?></td>
			<td><?php echo $announcement['created'];?></td>
			<td><?php echo $announcement['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'announcements', 'action' => 'view', $announcement['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'announcements', 'action' => 'edit', $announcement['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'announcements', 'action' => 'delete', $announcement['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $announcement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
