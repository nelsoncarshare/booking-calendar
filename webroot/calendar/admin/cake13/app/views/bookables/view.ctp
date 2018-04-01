<div class="bookables view">
<h2><?php  __('Bookable');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Vehicle'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bookable['Vehicle']['name'], array('controller' => 'vehicles', 'action' => 'view', $bookable['Vehicle']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bookable['Location']['name'], array('controller' => 'locations', 'action' => 'view', $bookable['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Color'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['color']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hourly Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['hourly_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hourly Rate High'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['hourly_rate_high']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rate Cutoff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['rate_cutoff']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Flat Daily Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['is_flat_daily_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Daily Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['daily_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Daily Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['daily_rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Km Rate Low'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_low']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Km Rate Med'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_med']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Km Rate High'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['km_rate_high']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charge Bc Rental Tax'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['charge_bc_rental_tax']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bookable['Bookable']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bookable', true), array('action' => 'edit', $bookable['Bookable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Bookable', true), array('action' => 'delete', $bookable['Bookable']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bookable['Bookable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicles', true), array('controller' => 'vehicles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle', true), array('controller' => 'vehicles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations', true), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location', true), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Calendars');?></h3>
	<?php if (!empty($bookable['Calendar'])):?>
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
	<h3><?php __('Related Announcements');?></h3>
	<?php if (!empty($bookable['Announcement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Text'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Disabled'); ?></th>
		<th><?php __('Display On Day'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'announcements', 'action' => 'view', $announcement['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'announcements', 'action' => 'edit', $announcement['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'announcements', 'action' => 'delete', $announcement['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $announcement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
