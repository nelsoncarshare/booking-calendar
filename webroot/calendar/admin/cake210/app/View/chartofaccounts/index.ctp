<div>
<?php echo $this->Html->script('jqGrid-3.4.3/jquery'); ?>

<script type="text/javascript">

jQuery(document).ready(function(){
		$('input[type="checkbox"]').change(function() {
			var checkVal;
			if(this.checked) {
				checkVal = 1;
			} else {
				checkVal = 0;
			}
			
			$.ajax({
			  type: "GET",
			  url: "save/" + this.id + "/" + checkVal,
			  error: function() {
				  alert( "Failed: " + msg );
			  },
			  success: function( msg ) {}
			});
		});
	});
</script>


<div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?></div>

<form action="<?php echo $this->Html->url('/chartofaccounts/add'); ?>" method="post" enctype="multipart/form-data">
	<label for="FileImage">Upload Chart Of Accounts IIF File</label>
	<input type="file" name="data[File][image]" id="FileImage" />
	<?php echo $this->form->submit('Upload');?>
</form>

<h2>List Chart Of Accounts</h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Id</th>
	<th>Account</th>
	<th>Show In Lists</th>
</tr>
<?php foreach ($Chartofaccounts as $account): ?>
<tr>
	<td><?php echo $account['Chartofaccounts']['id']; ?></td>
	<td><?php echo $account['Chartofaccounts']['account']; ?></td>
	<td><input type="checkbox" id="<?php echo $account['Chartofaccounts']['id']; ?>" 
			<?php
				if ($account['Chartofaccounts']['show_in_lists']) echo "checked";
			?>
		>
	</td>
</tr>
<?php endforeach; ?>
</table>

</div>