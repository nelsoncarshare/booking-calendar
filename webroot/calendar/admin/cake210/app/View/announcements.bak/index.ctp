<div class="announcements index">
	<div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<h2><?php echo __('Announcements');?></h2>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php echo __('Actions');?></th>    
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('text');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('disabled');?></th>
			<th><?php echo $this->Paginator->sort('display_on_day');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($announcements as $announcement):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $announcement['Announcement']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $announcement['Announcement']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $announcement['Announcement']['id'])); ?>
		</td>
        <td><?php echo $announcement['Announcement']['id']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['text']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['title']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['disabled']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['display_on_day']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['created']; ?>&nbsp;</td>
		<td><?php echo $announcement['Announcement']['modified']; ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>

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