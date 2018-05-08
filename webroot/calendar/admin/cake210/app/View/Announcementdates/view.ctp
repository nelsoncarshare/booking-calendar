<div class="announcementdates view">
<h2><?php echo __('Announcementdate'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($announcementdate['Announcementdate']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Announcement'); ?></dt>
		<dd>
			<?php echo $this->Html->link($announcementdate['Announcement']['title'], array('controller' => 'announcements', 'action' => 'view', $announcementdate['Announcement']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Startdate'); ?></dt>
		<dd>
			<?php echo h($announcementdate['Announcementdate']['startdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enddate'); ?></dt>
		<dd>
			<?php echo h($announcementdate['Announcementdate']['enddate']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcementdate'), array('action' => 'edit', $announcementdate['Announcementdate']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Announcementdate'), array('action' => 'delete', $announcementdate['Announcementdate']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $announcementdate['Announcementdate']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcementdates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
