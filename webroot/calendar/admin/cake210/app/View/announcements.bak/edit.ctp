<div class="announcements form">
<?php echo $this->Form->create('Announcement');?>
	<fieldset>
		<legend><?php echo __('Edit Announcement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
        echo $this->Form->textarea('text');
		echo $this->Form->input('disabled');
		echo $this->Form->input('display_on_day');
		echo $this->Form->input('Calendar');
		echo $this->Form->input('Bookable');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Announcement.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Announcement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcementdates'), array('controller' => 'announcementdates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate'), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables'), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable'), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>