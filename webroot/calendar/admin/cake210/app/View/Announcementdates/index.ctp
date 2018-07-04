<div class="announcementdates index">
<div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<h2><?php echo __('Announcementdates'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('announcement_id'); ?></th>
			<th><?php echo $this->Paginator->sort('startdate'); ?></th>
			<th><?php echo $this->Paginator->sort('enddate'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($announcementdates as $announcementdate): ?>
	<tr>
		<td><?php echo h($announcementdate['Announcementdate']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($announcementdate['Announcement']['title'], array('controller' => 'announcements', 'action' => 'view', $announcementdate['Announcement']['id'])); ?>
		</td>
		<td><?php echo h($announcementdate['Announcementdate']['startdate']); ?>&nbsp;</td>
		<td><?php echo h($announcementdate['Announcementdate']['enddate']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $announcementdate['Announcementdate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcementdate['Announcementdate']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $announcementdate['Announcementdate']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $announcementdate['Announcementdate']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
