<div class="announcementdates form">
<?php echo $this->Form->create('Announcementdate');?>
	<fieldset>
		<legend><?php __('Edit Announcementdate'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('announcement_id');
		echo $this->Form->input('startdate');
		echo $this->Form->input('enddate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Announcementdate.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Announcementdate.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Announcementdates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>