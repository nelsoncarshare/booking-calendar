<div class="grouptypes">
<h2>List Grouptypes</h2>

<table cellpadding="0" cellspacing="0">
<tr>
	<th>Id</th>
	<th>Type</th>
	<th>Actions</th>
</tr>
<?php foreach ($grouptypes as $grouptype): ?>
<tr>
	<td><?php echo $grouptype['Grouptype']['id']; ?></td>
	<td>&nbsp;<?php echo $this->html->link($grouptype['Group']['grp_displayname'], '/groups/view/' .$grouptype['Group']['id'])?></td>
	<td class="actions">
		<?php echo $this->html->link('View','/grouptypes/view/' . $grouptype['Grouptype']['id'])?>
		<?php echo $this->html->link('Edit','/grouptypes/edit/' . $grouptype['Grouptype']['id'])?>
		<?php echo $this->html->link('Delete','/grouptypes/delete/' . $grouptype['Grouptype']['id'], null, 'Are you sure you want to delete id ' . $grouptype['Grouptype']['id'])?>
	</td>
</tr>
<?php endforeach; ?>
</table>

<ul class="actions">
	<li><?php echo $this->html->link('New Grouptype', '/grouptypes/add'); ?></li>
</ul>
</div>