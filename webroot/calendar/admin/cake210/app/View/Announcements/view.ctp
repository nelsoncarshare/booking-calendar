<div class="announcements view">
<h2><?php echo __('Announcement'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disabled'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['disabled']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display On Day'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['display_on_day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($announcement['Announcement']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcement'), array('action' => 'edit', $announcement['Announcement']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Announcement'), array('action' => 'delete', $announcement['Announcement']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $announcement['Announcement']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcementdates'), array('controller' => 'announcementdates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Announcementdates'); ?></h3>
	<?php if (!empty($announcement['Announcementdate'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Announcement Id'); ?></th>
		<th><?php echo __('Startdate'); ?></th>
		<th><?php echo __('Enddate'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($announcement['Announcementdate'] as $announcementdate): ?>
		<tr>
			<td><?php echo $announcementdate['id']; ?></td>
			<td><?php echo $announcementdate['announcement_id']; ?></td>
			<td><?php echo $announcementdate['startdate']; ?></td>
			<td><?php echo $announcementdate['enddate']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'announcementdates', 'action' => 'view', $announcementdate['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'announcementdates', 'action' => 'edit', $announcementdate['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'announcementdates', 'action' => 'delete', $announcementdate['id']), array('confirm' => __('Are you sure you want to delete # %s?', $announcementdate['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Announcementdate'), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Calendars'); ?></h3>
	<?php if (!empty($announcement['Calendar'])): ?>
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
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($announcement['Calendar'] as $calendar): ?>
		<tr>
			<td><?php echo $calendar['id']; ?></td>
			<td><?php echo $calendar['calendar']; ?></td>
			<td><?php echo $calendar['hours_24']; ?></td>
			<td><?php echo $calendar['start_monday']; ?></td>
			<td><?php echo $calendar['translate']; ?></td>
			<td><?php echo $calendar['anon_permission']; ?></td>
			<td><?php echo $calendar['subject_max']; ?></td>
			<td><?php echo $calendar['contact_name']; ?></td>
			<td><?php echo $calendar['contact_email']; ?></td>
			<td><?php echo $calendar['calendar_title']; ?></td>
			<td><?php echo $calendar['url']; ?></td>
			<td><?php echo $calendar['calendar_file_name']; ?></td>
			<td><?php echo $calendar['latitude']; ?></td>
			<td><?php echo $calendar['longitude']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'calendars', 'action' => 'view', $calendar['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'calendars', 'action' => 'edit', $calendar['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'calendars', 'action' => 'delete', $calendar['id']), array('confirm' => __('Are you sure you want to delete # %s?', $calendar['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Bookables'); ?></h3>
	<?php if (!empty($announcement['Bookable'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Vehicle Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Disabled'); ?></th>
		<th><?php echo __('Hourly Rate Low'); ?></th>
		<th><?php echo __('Hourly Rate High'); ?></th>
		<th><?php echo __('Rate Cutoff'); ?></th>
		<th><?php echo __('Is Flat Daily Rate'); ?></th>
		<th><?php echo __('Daily Rate Low'); ?></th>
		<th><?php echo __('Daily Rate'); ?></th>
		<th><?php echo __('Km Rate Low'); ?></th>
		<th><?php echo __('Km Rate Med'); ?></th>
		<th><?php echo __('Km Rate High'); ?></th>
		<th><?php echo __('Charge Bc Rental Tax'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($announcement['Bookable'] as $bookable): ?>
		<tr>
			<td><?php echo $bookable['id']; ?></td>
			<td><?php echo $bookable['name']; ?></td>
			<td><?php echo $bookable['vehicle_id']; ?></td>
			<td><?php echo $bookable['location_id']; ?></td>
			<td><?php echo $bookable['color']; ?></td>
			<td><?php echo $bookable['disabled']; ?></td>
			<td><?php echo $bookable['hourly_rate_low']; ?></td>
			<td><?php echo $bookable['hourly_rate_high']; ?></td>
			<td><?php echo $bookable['rate_cutoff']; ?></td>
			<td><?php echo $bookable['is_flat_daily_rate']; ?></td>
			<td><?php echo $bookable['daily_rate_low']; ?></td>
			<td><?php echo $bookable['daily_rate']; ?></td>
			<td><?php echo $bookable['km_rate_low']; ?></td>
			<td><?php echo $bookable['km_rate_med']; ?></td>
			<td><?php echo $bookable['km_rate_high']; ?></td>
			<td><?php echo $bookable['charge_bc_rental_tax']; ?></td>
			<td><?php echo $bookable['created']; ?></td>
			<td><?php echo $bookable['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bookables', 'action' => 'view', $bookable['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bookables', 'action' => 'edit', $bookable['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bookables', 'action' => 'delete', $bookable['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bookable['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
