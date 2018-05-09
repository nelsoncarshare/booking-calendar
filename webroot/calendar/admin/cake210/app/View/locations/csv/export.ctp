<?php 
foreach ($data as $row):
	foreach ($row['Location'] as &$cell):
		// Escape double quotation marks
		$cell = '"' . preg_replace('/"/','""',$cell) . '"';
	endforeach;
	echo implode(',', $row['Location']) . "\n";
endforeach;
?>