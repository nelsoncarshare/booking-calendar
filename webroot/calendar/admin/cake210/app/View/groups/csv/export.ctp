<?php 
foreach ($data as $row):
	foreach ($row['Group'] as &$cell):
		// Escape double quotation marks
		$cell = '"' . preg_replace('/"/','""',$cell) . '"';
	endforeach;
	echo implode(',', $row['Group']) . "\n";
endforeach;
?>