<?php 
    foreach ($data as $row){
		$csv->addRow($row[$tableName]); 
    }
	print_r($csv);
	echo $csv->render($tableName . '.csv');
?>