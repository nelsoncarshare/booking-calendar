<?php
class InvoicewizardController extends AppController{

	var $uses = array();
	var $components = array('Wizard');
	var $helpers = array('Html', 'Form' );

	function beforeFilter() {
		//$this->data['User']['password'] = md5( $this->data['User']['password'] );
		$this->Wizard->wizardAction = "administerbookings/wizard";
	    $this->Wizard->steps = array('stepone');
	    $this->set('taxcodes', array( 1 => "PST Only", 2 => "GST Only", 3 => "PST/GST", 4 => "Tax Exempt" ));
		//$this->set('bookables', $this->Bookable->getBookablesForSelectBox());
		//$this->set('vehicles', $this->Vehicle->find('list'));
		//$this->set('users', $this->User->find('list'));
	}
	
	function wizard($step=null) {
		//echo ("in wizerd $step");
	    $this->Wizard->process($step);
	} 

    function processStepone() {
    	//echo("p step one.");
        # do some validation stuff here
        return true;
    } 
    
    function receipt(){
    	print_r($this->data);
    	echo "in recipt";	
    }
    
    function processRecipt() {
    	echo "in process Recipt";
    }
    
    function index (){    
        //$this->set('posts', $this->Post->find('all', array( 'conditions' => array('is_published'=>1,'is_public'=>'1'), 'fields' => array('date_modified','id'))));
        //$this->set('pages', $this->Info->find('all', array( 'conditions' => array('ispublished' => 1 ), 'fields' => array('date_modified','id','url'))));
		//debug logs will destroy xml format, make sure were not in drbug mode
		//Configure::write ('debug', 0);
    }
}
?>