<div class="announcementdates index">
	<h2><?php __('Announcementdates');?></h2>
    <div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php __('Actions');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('announcement_id');?></th>
			<th><?php echo $this->Paginator->sort('startdate');?></th>
			<th><?php echo $this->Paginator->sort('enddate');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($announcementdates as $announcementdate):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $announcementdate['Announcementdate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $announcementdate['Announcementdate']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $announcementdate['Announcementdate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $announcementdate['Announcementdate']['id'])); ?>
		</td>
    <td><?php echo $announcementdate['Announcementdate']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($announcementdate['Announcement']['title'], array('controller' => 'announcements', 'action' => 'view', $announcementdate['Announcement']['id'])); ?>
		</td>
		<td><?php echo $announcementdate['Announcementdate']['startdate']; ?>&nbsp;</td>
		<td><?php echo $announcementdate['Announcementdate']['enddate']; ?>&nbsp;</td>

	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Announcementdate', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Announcements', true), array('controller' => 'announcements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Announcement', true), array('controller' => 'announcements', 'action' => 'add')); ?> </li>
	</ul>
</div>