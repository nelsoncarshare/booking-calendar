<div class="announcementdates view">
<h2><?php echo __('Announcementdate');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcementdate['Announcementdate']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Announcement'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($announcementdate['Announcement']['title'], array('controller' => 'announcements', 'action' => 'view', $announcementdate['Announcement']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcementdate['Announcementdate']['startdate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Enddate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $announcementdate['Announcementdate']['enddate']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Announcementdate'), array('action' => 'edit', $announcementdate['Announcementdate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Announcementdate'), array('action' => 'delete', $announcementdate['Announcementdate']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $announcementdate['Announcementdate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcementdates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>
