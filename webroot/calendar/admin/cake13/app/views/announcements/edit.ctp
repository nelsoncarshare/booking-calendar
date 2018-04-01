<div class="announcements form">
<?php echo $this->Form->create('Announcement');?>
	<fieldset>
		<legend><?php __('Edit Announcement'); ?></legend>
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Announcement.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Announcement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcementdates', true), array('controller' => 'announcementdates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcementdate', true), array('controller' => 'announcementdates', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>