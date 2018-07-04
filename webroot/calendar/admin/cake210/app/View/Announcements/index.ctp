<div class="announcements index">
<div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<h2><?php echo __('Announcements'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('text'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('disabled'); ?></th>
			<th><?php echo $this->Paginator->sort('display_on_day'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($announcements as $announcement): ?>
	<tr>
		<td><?php echo h($announcement['Announcement']['id']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['text']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['title']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['disabled']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['display_on_day']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['created']); ?>&nbsp;</td>
		<td><?php echo h($announcement['Announcement']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $announcement['Announcement']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $announcement['Announcement']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Announcement'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Announcementdates'), array('controller' => 'announcementdates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>
