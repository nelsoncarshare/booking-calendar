<div class="announcementdates form">
<?php echo $this->Form->create('Announcementdate');?>
	<fieldset>
		<legend><?php echo __('Add Announcementdate'); ?></legend>
	<?php
		echo $this->Form->input('announcement_id');
		echo $this->Form->input('startdate');
		echo $this->Form->input('enddate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Announcementdates'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Announcements'), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement'), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>