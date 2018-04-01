<div>
<div align="center"><?php echo $html->link('[Back To Admin]', '/staticpages/'); ?></div>

<?php echo $html->css('themes/sand/grid'); ?>
<?php echo $html->css('jqModal'); ?>

<!-- Of course we should load the jquery library -->
<script>
	CAKE_ROOT = '<?php echo( Router::url('/') ) ?>';
</script>
<?php echo $this->Html->script('jqGrid-3.4.3/jquery'); ?>
<?php echo $this->Html->script('generate_invoices'); ?>

<a name='validate_invoices' href="#">validate invoices</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a name='gen_invoices' href="#">generate invoices</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a name='mail_invoices' href="#">mail invoices</a><br/>

Year: <input type='text' name='year'><br/>
Month: <input type='text' name='month'><br/>

<a id='checkAll' href="#">Check All</a> | <a id='checkNone' href="#">Check None</a><br/>
<br/>
<div id='progressMessage' style="color:blue; font-weight: bold;"></div>
<div id='clearAllUsersIIFMessage'></div>
<?php
    
	foreach ($invoicables as $key => $value){
        echo("<div id='invoicable_message_$key' class='message'></div>");
        echo("<input name='invoicable_$key' id='$key' type='checkbox' > $value<br/><br/>");
	}
?>