<div class="grouptype">
<h2>View Grouptype</h2>

<dl>
	<dt>Id</dt>
	<dd>&nbsp;<?php echo $grouptype['Grouptype']['id']?></dd>
	<dt>Type</dt>
	<dd>&nbsp;<?php echo $html->link($grouptype['Group']['grp_displayname'], '/groups/view/' .$grouptype['Group']['id'])?></dd>
</dl>
<ul class="actions">
	<li><?php echo $html->link('Edit Grouptype',   '/grouptypes/edit/' . $grouptype['Grouptype']['id']) ?> </li>
	<li><?php echo $html->link('Delete Grouptype', '/grouptypes/delete/' . $grouptype['Grouptype']['id'], null, 'Are you sure you want to delete: id ' . $grouptype['Grouptype']['id'] . '?') ?> </li>
	<li><?php echo $html->link('List Grouptypes',   '/grouptypes/index') ?> </li>
	<li><?php echo $html->link('New Grouptype',	'/grouptypes/add') ?> </li>
	<li><?php echo $html->link('List Group', '/groups/index/')?> </li>
	<li><?php echo $html->link('New Groups', '/groups/add/')?> </li>
</ul>

</div>
