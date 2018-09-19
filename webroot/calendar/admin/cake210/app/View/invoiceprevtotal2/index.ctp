<div>
<div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?></div>

<?php echo $this->Html->css('themes/sand/grid'); ?>

<?php echo $this->Html->css('jqModal'); ?>

<!-- Of course we should load the jquery library -->
<?php echo $this->Html->script('jqGrid-3.4.3/jquery'); ?>

<?php echo $this->Html->script('jqModal/jqModal'); ?>

<?php echo $this->Html->script('jqModal/jqDnR'); ?>

<?php echo $this->Html->script('jqGrid-3.4.3/all'); ?>

<?php 
echo $this->Form->create(false, array('url' => 'index/' . $billing_id));	
echo $this->Form->hidden('billing_id'); 
echo $this->Form->end("Grab Previous Owing From Previous Months Invioces"); 
?>

<script type="text/javascript">
	CAKE_ROOT = '<?php echo( Router::url('/') ) ?>';
	CAKE_GET_URL = '<?php echo($this->Html->url(array("controller" => "invoiceprevtotal2","action" => "get",$billing_id)));?>';
</script>
<?php echo $this->Html->script('invoice_prev_total'); ?>

To edit a value click on the row. Use [enter] to save a row. Use [esc] or click on a different row to cancel changes.

<!-- the grid definition in html is a table tag with class 'scroll' -->
<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table>

<!-- pager definition. class scroll tels that we want to use the same theme as grid -->
<div id="pager2" class="scroll" style="text-align:center;"></div>

</div>