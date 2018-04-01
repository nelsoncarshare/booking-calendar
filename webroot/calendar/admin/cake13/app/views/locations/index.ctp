<div class="locations index">
	<h2><?php __('Locations');?></h2>
    <div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?><br/></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th class="actions"><?php __('Actions');?></th>
            <th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('address1');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('comment');?></th>
			<th><?php echo $this->Paginator->sort('URL');?></th>
			<th><?php echo $this->Paginator->sort('GPS_coord_x');?></th>
			<th><?php echo $this->Paginator->sort('GPS_coord_y');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($locations as $location):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $location['Location']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $location['Location']['id'])); ?>
		</td>
        <td><?php echo $location['Location']['id']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['name']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['address1']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['city']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['comment']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['URL']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['GPS_coord_x']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['GPS_coord_y']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['modified']; ?>&nbsp;</td>
		<td><?php echo $location['Location']['created']; ?>&nbsp;</td>

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
		<li><?php echo $this->Html->link(__('Download All', true), array('action' => 'export.csv')); ?></li>	
		<li><?php echo $this->Html->link(__('New Location', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Bookables', true), array('controller' => 'bookables', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bookable', true), array('controller' => 'bookables', 'action' => 'add')); ?> </li>
	</ul>
</div>