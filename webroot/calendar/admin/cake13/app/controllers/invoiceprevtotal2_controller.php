<?php
class Invoiceprevtotal2Controller extends AppController {

	var $name = 'Invoiceprevtotal2';
	var $helpers = array('Html', 'Form' );
	var $uses = array("Invoicable", "Invoice", "Billing");
	var $components = array('json');

    function beforeFilter()
    {
        $this->checkSession();
    }
    
    function index($billing_id){
		$this->layout = "grid";
		$this->set("billing_id", $billing_id  );
		if (!empty($this->data)) {
			$this->Invoicable->initializePrevOwing($billing_id);
		}
    }
		
		function get($billingid=-1){
			$this->layout = "json";		
			//print_r($this->params['url']);
			//$this->Billing->findCount(array('Billing.id' => $billingid)) == 1
			if ($billingid){
				$totalRows = Array();
				$myArr = $this->Invoicable->getDataForGrid($this->params['url']['rows'], $this->params['url']['page'], $totalRows);
				$myArr['data'] = $this->Invoicable->appendPrevOwingAndPayment($myArr['data'],$billingid);
				$out = Array("data" => $myArr['data'], "num" => count($myArr['data']), "total" => $myArr['totalpages'], "page"=> $this->params['url']['page']);
				$this->set("myArr", $this->json->encode($out)  );
			} else {
				$this->set("myArr", $this->json->encode(array())  );
			}
		}

		function post(){
			$this->layout = "json";	
			$saveMe = Array( 'Invoice' => $this->params['form'] );
			if ($this->Invoice->save($saveMe)){
				$myArr = array("success" => true, "data" => $saveMe['Invoice']);
			} else {
				$myArr = array("success" => false);						
			}
			$this->set("myArr", $this->json->encode($myArr)  );
		}
}
?>