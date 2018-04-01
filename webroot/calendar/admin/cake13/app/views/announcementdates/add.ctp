<div class="announcementdates form">
<?php echo $this->Form->create('Announcementdate');?>
	<fieldset>
		<legend><?php __('Add Announcementdate'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Announcementdates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>