<?php 
if ($this->session->check('Message.flash')){
						$this->session->flash();
}
echo $content_for_layout;
?>