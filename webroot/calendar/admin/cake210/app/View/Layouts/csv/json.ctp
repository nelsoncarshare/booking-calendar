<?php 
if ($this->Session->check('Message.flash')){
						$this->Session->flash();
}
echo $content_for_layout;
?>