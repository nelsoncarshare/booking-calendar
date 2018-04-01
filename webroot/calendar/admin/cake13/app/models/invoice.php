<?php

class Invoice extends AppModel
{
    var $name = 'Invoice';
    var $displayField = 'user_id'; 
    
    function getInvoicesForBilling($billing_id) {
    	//echo(ConnectionManager::config);
    	$res = $this->query("select * from phpc_users left outer join phpc_invoices on phpc_users.id=phpc_invoices.user_id where billing_id IS NULL or billing_id='$billing_id'");
    	//$res = $this->find('all');
    	//$out = array();
    	//foreach ($res as $r){
    	//	$mname = date("F", mktime(0,0,0,$r['Billing']['month'],1));
    	//	$out[ $r['Billing']['id'] ] = $mname . " " . $r['Billing']['year'];
    	//}
    	return $res;
	}
}

?>