<?php

class Invoicable extends AppModel
{
    var $name = 'Invoicable';
    var $uses = 'Invoice';

	function getName($myId){
    		$query= "SELECT ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."invoicables.user_id ".
	             ", ".SQL_PREFIX."invoicables.group_id ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."users.disabled ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	             ", ".SQL_PREFIX."groups.disabled as grp_disabled ".
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE ((".SQL_PREFIX."grouptypes.type='INDIVIDUAL') ".
	         "OR (".SQL_PREFIX."grouptypes.type<>'INDIVIDUAL'))".
	         "AND ".SQL_PREFIX."invoicables.id=$myId ".
	         "ORDER BY type, displayname, grp_displayname ";
	         $res = $this->query( $query );
	         $out = "";
	         if (!array_key_exists(0,$res)){
	         	echo $query;
	         }
	         if ($res[0][SQL_PREFIX."grouptypes"]['type'] == 'INDIVIDUAL') {
	         	$out = $res[0][SQL_PREFIX."users"]['displayname'];
	         } else {
	        	$out = $res[0][SQL_PREFIX."groups"]['grp_displayname'];
	         }
	         
	         return $out;
	}

	function getDataForSelectList(){
		$out = $this->getDataForGrid();
		return $out['data'];
	}
	
    function getDataForGrid($numrows = -1, $page = 1) {
			$query= "SELECT ". 
				"SQL_CALC_FOUND_ROWS ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."invoicables.user_id ".
	             ", ".SQL_PREFIX."invoicables.group_id ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."users.disabled ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	             ", ".SQL_PREFIX."groups.disabled as grp_disabled ".
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE (".SQL_PREFIX."grouptypes.type='INDIVIDUAL' and ".SQL_PREFIX."users.disabled=0) ".
	         "OR (".SQL_PREFIX."grouptypes.type<>'INDIVIDUAL' and ".SQL_PREFIX."groups.disabled=0)".
	         "ORDER BY type, displayname, grp_displayname ";
				if ($numrows > 0){
					$query .= " LIMIT " . ($numrows * ($page -1)) . ", " . ($numrows * $page);
				}
    	$res = $this->query( $query );
    	$totalRowsArr = $this->query( "select found_rows()" );
    	$totalRows = $totalRowsArr[0][0]['found_rows()'];
    	
    	$out = array();

		foreach ($res as $row1) {
			if ($row1[SQL_PREFIX.'grouptypes']['type'] == 'INDIVIDUAL'){
				$out[$row1[SQL_PREFIX.'invoicables']['id']] = $row1[SQL_PREFIX.'users']['displayname'];	
			} else {
				$out[$row1[SQL_PREFIX.'invoicables']['id']] = $row1[SQL_PREFIX.'groups']['grp_displayname'];
			}		
		}
			$out = array("totalpages" => ceil($totalRows/$numrows), "data" => $out);
    	return $out;
	}	    
	
	
	function appendPrevOwingAndPayment($invoicables,$billingid){
			//print_r($invoicables);
			$outdata = Array();
			foreach(array_keys($invoicables) as $inv_id){
				//echo($inv_id . "<br/>");
				$query = "select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $inv_id. " and billing_id=" . $billingid;
				$res = $this->query( $query );
				if (count($res) == 0){
					$query = $query = "insert into ". SQL_PREFIX . "invoices (billing_id, invoicable_id, previous_owing, payment_made) VALUES ($billingid, $inv_id, 0, 0)";
					$this->query( $query );
					$id = mysql_insert_id();
					$payment = 0;
					$prev_owing = 0;
				} else {
					$id = $res[0][SQL_PREFIX . 'invoices']['id'];
					$payment = $res[0][SQL_PREFIX . 'invoices']['payment_made'];
					$prev_owing = $res[0][SQL_PREFIX . 'invoices']['previous_owing'];					
				}
				$outdata[] = Array( "id" => $id, "billing_id" => $billingid, "invoicable_id" => $inv_id, "name" => $invoicables[$inv_id], "previous_owing" => $prev_owing, "payment_made" => $payment );
			}
			return $outdata;
		}

	function initializePrevOwing($billingID){
	    App::import('model','Billing');
		$billing = new Billing();
		$currBilling = $billing->find('first', array('conditions' => array('Billing.id' => $billingID),
													 'recursive' => false));
		if (empty($currBilling)) return array("success" => false, "message" => "No billing for the given month");
		$prevMonth = $currBilling['Billing']['month'] - 1;
		$prevYear = $currBilling['Billing']['year'];
		if ($prevMonth == 0) {
			$prevMonth = 12;
			$prevYear--;
		}
		$prevBilling = $billing->find('first', array('conditions' => array('Billing.month' => $prevMonth, 'Billing.year' => $prevYear),
													 'recursive' => false));
		
		if (empty($prevBilling)) return array("success" => true, "message" => "No previous billing for this month. No invoice records were changed.");

		$prevBillingID = $prevBilling['Billing']['id'];
		
		//todo need to get all not just a page
		$invoicables = $this->getDataForGrid();
		//get the current billing id
		//get the previous billing id
		//print_r($invoicables['data']);
		foreach(array_keys($invoicables['data']) as $inv_id => $inv_name){
			$query = "select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $inv_name . " and billing_id=" . $prevBillingID;
			$res = $this->query( $query );
			if (count($res) == 0){
				//no previous invoice do nothing
			} else {
				//get the old invoice total
				$inv_total = $res[0][SQL_PREFIX . 'invoices']['amt_owing'];
				//check to see if current invoice exists
				$query = "select * from " . SQL_PREFIX . "invoices WHERE invoicable_id=" . $inv_name . " and billing_id=" . $billingID;
				$res = $this->query( $query );
				if (count($res) == 0){ // do insert
					$query = "INSERT INTO ". SQL_PREFIX . "invoices (billing_id, invoice_num, previous_owing, invoicable_id) values (" . $billingID . ", -1," . $inv_total. "," . $inv_name . ")";
					$this->query( $query );
				} else { // do update
					$query = "UPDATE ". SQL_PREFIX . "invoices SET previous_owing='" . $inv_total . "' 	WHERE  invoicable_id=" . $inv_name . " and billing_id=" . $billingID;
					$this->query( $query );
				}
				$this->commit();
			}
		}
	} 		
		
	/*
	function get_invoicable_users_and_groups(){
    		$query= "SELECT ".SQL_PREFIX."invoicables.id ".
	             ", ".SQL_PREFIX."invoicables.user_id ".
	             ", ".SQL_PREFIX."invoicables.group_id ".
	             ", ".SQL_PREFIX."grouptypes.type as type".
	             ", ".SQL_PREFIX."users.displayname ".
	             ", ".SQL_PREFIX."users.disabled ".
	             ", ".SQL_PREFIX."groups.grp_displayname ".
	             ", ".SQL_PREFIX."groups.disabled as grp_disabled ".
	         "FROM ".SQL_PREFIX."invoicables ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."users on user_id=".SQL_PREFIX."users.id ".
	         "LEFT OUTER JOIN ".SQL_PREFIX."groups on ".SQL_PREFIX."invoicables.group_id=".SQL_PREFIX."groups.id ".
	         "INNER JOIN ".SQL_PREFIX."grouptypes on ".SQL_PREFIX."invoicables.type=".SQL_PREFIX."grouptypes.id ".
	         "WHERE (".SQL_PREFIX."grouptypes.type='INDIVIDUAL' and ".SQL_PREFIX."users.disabled=0) ".
	         "OR (".SQL_PREFIX."grouptypes.type<>'INDIVIDUAL' and ".SQL_PREFIX."groups.disabled=0)".
	         "ORDER BY type, displayname, grp_displayname ";
			echo($query);
    	$res = $this->query( $query );		
			print_r($res);
			return $res;
	}
	*/
}

?>