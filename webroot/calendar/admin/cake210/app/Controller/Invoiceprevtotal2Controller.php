<?php
App::uses('AppController', 'Controller');

class Invoiceprevtotal2Controller extends AppController {


	public $helpers = array('Html', 'Form' );
	public $uses = array("Invoicable", "Invoice", "Billing");

    function beforeFilter()
    {
        $this->checkSession();
    }
    
    function index($billing_id){
		$this->layout = "grid";
		$this->set("billing_id", $billing_id  );
		if (!empty($this->request->data)) {
			$this->Invoicable->initializePrevOwing($billing_id);
		}
    }
		
		function get($billingid=-1){
			$this->layout = "json";		
			//print_r($this->request->params['url']);
			//$this->Billing->findCount(array('Billing.id' => $billingid)) == 1
			if ($billingid){
				$totalRows = Array();
				$myArr = $this->Invoicable->getDataForGrid($this->request->query('rows'), $this->request->query('page'), $totalRows);
				$myArr['data'] = $this->Invoicable->appendPrevOwingAndPayment($myArr['data'],$billingid);
				$out = Array("data" => $myArr['data'], "num" => count($myArr['data']), "total" => $myArr['totalpages'], "page"=> $this->request->query('page'));
				$this->set("myArr", json_encode($out)  );
			} else {
				$this->set("myArr", json_encode(array())  );
			}
		}

		function post(){
			$this->layout = "json";	
			$saveMe = Array( 'Invoice' => $this->request->data );
			if ($this->Invoice->save($saveMe)){
				$myArr = array("success" => true, "data" => $saveMe['Invoice']);
			} else {
				$myArr = array("success" => false);						
			}
			$this->set("myArr", $this->json->encode($myArr)  );
		}
}
?>