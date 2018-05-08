<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_for_layout;?></title>
<link rel="icon" href="<?php echo $this->webroot . 'favicon.ico';?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->webroot . 'favicon.ico';?>" type="image/x-icon" />
<?php echo $this->Html->css('cake.generic'); ?>
</head>
<body>
	<div id="container">
		<div id="content">
			<?php if ($session->check('Message.flash'))
					{
						$session->flash();
					}
					echo $content_for_layout;
			?>
		</div>
	</div>
</body>
</html>