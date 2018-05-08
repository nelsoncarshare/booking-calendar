<?php

class Event extends AppModel
{
    public $name = 'Event';
    public $displayField = 'month';
    
    public $validate = array(
      //'rental_tax_acnt_code' => VALID_NOT_EMPTY,
      //"acnt_code_pst" => "/^ | \$|\\t/"
    );

	/*
    public $belongsTo = array('Bookable' =>
                        array('className'    => 'Bookable',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'id'
                        ),
                        'User' =>
                        array('className'    => 'User',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  true,
                              'foreignKey'   => 'id'
                        )
                  );
     */
    
    function get_car_month_usage($startstamp,$endstamp,$bookableid,$userid,$vehicleid)
{
	global $CANCELED;
	
	
    $dbstartdatetime = "DATE_FORMAT(starttime,'%Y-%m-%d-%H-%i')";
    
    $conditions = "";
    if ($bookableid != 0){
    	$conditions = $conditions . " AND bookableobject=$bookableid ";
    }

    if ($userid != 0){
    	$conditions = $conditions . " AND uid=$userid ";
    }    
    
    if ($vehicleid != 0){
    	$conditions = $conditions . " AND vehicle_used_id=$vehicleid ";
    }
    echo("'$startstamp  $endstamp'");
    if ($startstamp != -1){
    	$mystartdatetime = "DATE '" . date('Y-m-d-H-i', $startstamp). "'";
    	$conditions = $conditions . " AND ($mystartdatetime <= $dbstartdatetime) \n";
    }
    
    if ($endstamp != -1){
    	$myenddatetime = "DATE '" . date('Y-m-d-H-i', $endstamp). "'";
    	$conditions = $conditions . " AND ($myenddatetime >= $dbstartdatetime) \n";
    }    
    
    $events_table = SQL_PREFIX . 'events';
    
	$query = 'SELECT '.SQL_PREFIX.'events.id as id, username, displayname, endkm - startkm as distance, canceled,'.SQL_PREFIX.'vehicles.name as name, vehicle_used_id, starttime, endtime, startkm, endkm, expense_gas, expense_admin, expense_repair, expense_insurance, expense_misc_1, expense_misc_2, expense_misc_3, expense_misc_4, admin_comment, admin_ignore_this_booking, admin_ignore_km_hours, '
		
		."DATE_FORMAT(phpc_events.starttime,'%Y') AS year,\n"
		."DATE_FORMAT(phpc_events.starttime,'%m') AS month,\n"
		."DATE_FORMAT(phpc_events.starttime,'%d') AS day,\n"
		."DATE_FORMAT(phpc_events.starttime,'%H') AS hour,\n"
		."DATE_FORMAT(phpc_events.starttime,'%i') AS minute,\n"
		
		."DATE_FORMAT(phpc_events.endtime,'%Y') AS end_year,\n"
		."DATE_FORMAT(phpc_events.endtime,'%m') AS end_month,\n"
		."DATE_FORMAT(phpc_events.endtime,'%d') AS end_day,\n"
		."DATE_FORMAT(phpc_events.endtime,'%H') AS end_hour,\n"
		."DATE_FORMAT(phpc_events.endtime,'%i') AS end_minute\n"		
	
		.' FROM '.SQL_PREFIX."events\n"
		.'INNER JOIN '.SQL_PREFIX."bookables ON ".SQL_PREFIX."bookables.id = ".SQL_PREFIX."events.bookableobject "
		."INNER JOIN ".SQL_PREFIX."vehicles ON ".SQL_PREFIX."vehicles.id = ".SQL_PREFIX."bookables.vehicle_id\n"
		."INNER JOIN ".SQL_PREFIX."users ON ".SQL_PREFIX."users.id = ".SQL_PREFIX."events.uid\n"
		."WHERE (canceled = '".$CANCELED['NORMAL']."' OR canceled = '".$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']."')\n"
		.$conditions
		." ORDER BY starttime";
    echo($query);
	$result = $this->query($query);
	
	//print_r($result);

	return $result;
	}
                  
    function getNumExtraQuarterHourIntervalsFromCancelAndModifications($eventid, $wascanceled, $startstamp, $endstamp){
    	return 115;
    }
    
    /*
    public $hasMany = array('Invoiceextraitem' =>
            array('className'     => 'Invoiceextraitem',
                      'conditions'    => '',
                           'order'         => '',
                           'limit'         => '',
                           'foreignKey'    => 'billing_id',
                           'dependent'     => true,
                           'exclusive'     => false,
                           'finderQuery'   => '',
                           'fields'        => '',
                           'offset'        => '',
                           'counterQuery'  => ''
                     )
              );

    function getDataForSelectList() {
    	$res = $this->find('all');
    	$out = array();
    	foreach ($res as $r){
    		$mname = date("F", mktime(0,0,0,$r['Billing']['month']));
    		$out[ $r['Billing']['id'] ] = $mname . " " . $r['Billing']['year'];
    	}
    	return $out;
	}
	
	
	function beforeValidate($options = Array()){
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_pst'])){
			$this->invalidate('acnt_code_pst');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['rental_tax_acnt_code'])){
			$this->invalidate('rental_tax_acnt_code');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_gas_surcharge'])){
			$this->invalidate('acnt_code_gas_surcharge');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_self_insurance'])){
			$this->invalidate('acnt_code_self_insurance');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_carbon_offset'])){
			$this->invalidate('acnt_code_carbon_offset');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_low'])){
			$this->invalidate('acnt_code_member_plan_low');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_med'])){
			$this->invalidate('acnt_code_member_plan_med');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_high'])){
			$this->invalidate('acnt_code_member_plan_high');
		}							
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_member_plan_organization'])){
			$this->invalidate('acnt_code_member_plan_organization');
		}		
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_accounts_receivable'])){
			$this->invalidate('acnt_code_accounts_receivable');
		}
		if ( preg_match( "/^ | \$|\t/"  , $this->data['Billing']['acnt_code_long_term_member_discount'])){
			$this->invalidate('acnt_code_long_term_member_discount');
		}												
		return true;
	}      
	*/    
}

?>