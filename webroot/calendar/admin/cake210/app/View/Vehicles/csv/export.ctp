<?php 
foreach ($data as $row):
	foreach ($row['Vehicle'] as &$cell):
		// Escape double quotation marks
		$cell = '"' . preg_replace('/"/','""',$cell) . '"';
	endforeach;
	echo implode(',', $row['Vehicle']) . "\n";
endforeach;
?>