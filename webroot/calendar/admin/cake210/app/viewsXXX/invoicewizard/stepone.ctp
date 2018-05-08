<div class="users">
<div>
<h2>Hello World</h2>
<form action="<?php echo $html->url('/invoicewizard/wizard/stepone/'); ?>" id="stepone" method="post">
    <div class="submit">
    	<?php echo $form->label('myquery/bookable', 'Vehicle booked');?>
        <?php echo $html->selectTag('myquery/bookable', $bookables, $html->tagValue('myquery/bookable'), array(), array(), true);?><br/>
        
        <?php echo $form->label('myquery/vehicle', 'Vehicle used');?>
        <?php echo $html->selectTag('myquery/vehicle', $vehicles, $html->tagValue('myquery/vehicle'), array(), array(), true);?><br/>
        
        <?php echo $form->label('myquery/user', 'Booking Is For Member');?>
        <?php echo $html->selectTag('myquery/user', $users, $html->tagValue('myquery/user'), array(), array(), true);?><br/>
        
        <?php echo $html->submit('Previous',array('div'=>false,'name'=>'Previous'));?>
        <?php echo $html->submit('Continue',array('div'=>false));?>
    </div>
</form> 
</div>