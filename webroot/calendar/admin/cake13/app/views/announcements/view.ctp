<div class="announcements view">
<h2><?php  __('Announcement');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Display On Day'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['display_on_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcement['Announcement']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement', true), array('action' => 'edit', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Announcement', true), array('action' => 'delete', $announcement['Announcement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcementdates', true), array('controller' => 'announcementdates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate', true), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Announcementdates');?></h3>
	<?php if (!empty($announcement['Announcementdate'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Announcement Id'); ?></th>
		<th><?php __('Startdate'); ?></th>
		<th><?php __('Enddate'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($announcement['Announcementdate'] as $announcementdate):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $announcementdate['id'];?></td>
			<td><?php echo $announcementdate['announcement_id'];?></td>
			<td><?php echo $announcementdate['startdate'];?></td>
			<td><?php echo $announcementdate['enddate'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'announcementdates', 'action' => 'view', $announcementdate['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'announcementdates', 'action' => 'edit', $announcementdate['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'announcementdates', 'action' => 'delete', $announcementdate['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $announcementdate['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Announcementdate', true), array('controller' => 'announcementdates', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Calendars');?></h3>
	<?php if (!empty($announcement['Calendar'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Calendar'); ?></th>
		<th><?php __('Hours 24'); ?></th>
		<th><?php __('Start Monday'); ?></th>
		<th><?php __('Translate'); ?></th>
		<th><?php __('Anon Permission'); ?></th>
		<th><?php __('Subject Max'); ?></th>
		<th><?php __('Contact Name'); ?></th>
		<th><?php __('Contact Email'); ?></th>
		<th><?php __('Calendar Title'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Calendar File Name'); ?></th>
		<th><?php __('Latitude'); ?></th>
		<th><?php __('Longitude'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($announcement['Calendar'] as $calendar):
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'calendars', 'action' => 'view', $calendar['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'calendars', 'action' => 'edit', $calendar['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'calendars', 'action' => 'delete', $calendar['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $calendar['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Bookables');?></h3>
	<?php if (!empty($announcement['Bookable'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Vehicle Id'); ?></th>
		<th><?php __('Location Id'); ?></th>
		<th><?php __('Color'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<th><?php __('Hourly Rate Low'); ?></th>
		<th><?php __('Hourly Rate High'); ?></th>
		<th><?php __('Rate Cutoff'); ?></th>
		<th><?php __('Is Flat Daily Rate'); ?></th>
		<th><?php __('Daily Rate Low'); ?></th>
		<th><?php __('Daily Rate'); ?></th>
		<th><?php __('Km Rate Low'); ?></th>
		<th><?php __('Km Rate Med'); ?></th>
		<th><?php __('Km Rate High'); ?></th>
		<th><?php __('Charge Bc Rental Tax'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($announcement['Bookable'] as $bookable):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $bookable['id'];?></td>
			<td><?php echo $bookable['name'];?></td>
			<td><?php echo $bookable['vehicle_id'];?></td>
			<td><?php echo $bookable['location_id'];?></td>
			<td><?php echo $bookable['color'];?></td>
			<td><?php echo $bookable['disabled'];?></td>
			<td><?php echo $bookable['hourly_rate_low'];?></td>
			<td><?php echo $bookable['hourly_rate_high'];?></td>
			<td><?php echo $bookable['rate_cutoff'];?></td>
			<td><?php echo $bookable['is_flat_daily_rate'];?></td>
			<td><?php echo $bookable['daily_rate_low'];?></td>
			<td><?php echo $bookable['daily_rate'];?></td>
			<td><?php echo $bookable['km_rate_low'];?></td>
			<td><?php echo $bookable['km_rate_med'];?></td>
			<td><?php echo $bookable['km_rate_high'];?></td>
			<td><?php echo $bookable['charge_bc_rental_tax'];?></td>
			<td><?php echo $bookable['created'];?></td>
			<td><?php echo $bookable['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'bookables', 'action' => 'view', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'bookables', 'action' => 'edit', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'bookables', 'action' => 'delete', $bookable['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bookable['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
