<?php 
    foreach ($data as $row){
		$csv->addRow($row[$tableName]); 
    }
	echo $csv->render($tableName . '.csv');
?>