<?php

define('IN_PHPC', true);
$phpc_root_path = './';

require_once($phpc_root_path . 'includes/calendar.php');
require_once($phpc_root_path . 'includes/setup.php');
require_once($phpc_root_path . 'includes/globals.php');
session_start();
?>

<html>
	<head>
		<script>
//			self.resizeTo(500,600);
		</script>
		<title></title>
		<link rel="stylesheet" type="text/css" href="index.php?action=style" />
	</head>
	<body>
		<?php
		$q=$_GET["id"];
		
		$query= "SELECT * FROM ".SQL_PREFIX."announcements WHERE id=$q";
		
		$result = $db->Execute($query)
	                or db_error("error ", $query);
                		
        $row = $result->FetchRow();
		echo ("<h2>" . $row['title'] . "</h2>");
		echo ($row['text']);
		?>
	</body>
</html>