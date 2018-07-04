<div>
<div align="center"><?php echo $this->Html->link('[Back To Admin]', '/staticpages/'); ?></div>

	<?php
	if (Count($errors) > 0){
		echo( "<div style='color:red'><b>There were errors:</b></div><br>" );
		for ($i = 0; $i < Count($errors); $i++){
			echo($errors[$i] . "<br>");
		}
		echo("<br><br><br>");
	}
	?>

	<b>New accounts from quickbooks that were added:</b><br><br>
	<?php
	for ($i = 0; $i < Count($accountsOnlyInNew); $i++){
		echo($accountsOnlyInNew[$i]['account'] . "<br>");
	}
	?>

	<br><br><br><b>Accounts on website but not in Quickbooks:</b><br><br>
	<?php
	for ($i = 0; $i < Count($accountsOnlyInDB); $i++){
		echo("<font color='red'>" . $accountsOnlyInDB[$i]['account'] . "</font><br>");
	}
	?>
	
	<br><br><br><b>Unchanged Accounts:</b><br><br>
	<?php
	for ($i = 0; $i < Count($accountsInBoth); $i++){
		echo($accountsInBoth[$i]['account'] . "<br>");
	}
	?>
	

</div>