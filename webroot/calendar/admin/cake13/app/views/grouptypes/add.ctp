<h2>New Grouptype</h2>
<form action="<?php echo $html->url('/grouptypes/add'); ?>" method="post">
<div class="optional"> 
	<?php echo $form->label('Grouptype/type', 'Type');?>
 	<?php echo $html->selectTag('Grouptype/type', $groups, $html->tagValue('Grouptype/type'), array(), array(), true);?>
	<?php echo $html->tagErrorMsg('Grouptype/type', 'Please select the Type.') ?>
</div>
<div class="submit">
	<?php echo $html->submit('Add');?>
</div>
</form>
<ul class="actions">
<li><?php echo $html->link('List Grouptypes', '/grouptypes/index')?></li>
<li><?php echo $html->link('View Groups', '/groups/index/');?></li>
<li><?php echo $html->link('Add Groups', '/groups/add/');?></li>
</ul>
