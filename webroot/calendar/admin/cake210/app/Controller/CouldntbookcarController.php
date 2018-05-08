<?php
class CouldntbookcarController extends AppController {


	public $helpers = array('Html', 'Form' );
	public $uses = array("Bookable", "User", "CouldntBookVehicle");
	//public $components = array('json');

    function beforeFilter()
    {
        $this->checkSession();
    }
    
    function index(){
        $us = $this->User->find('all',null,'displayname');
        $this->set('users',$us);

        $books = $this->Bookable->find('all',null,'Bookable.name');
        $this->set('bookables',$books);
                
    	$this->layout = "grid";
    }
		
		function get(){
			$this->layout = "json";		
			//print_r($this->request);
            $mod_nm = $bookable = -1;
            $creation_a_dt = $creation_b_dt = '';
            
            if (array_key_exists('mod_nm', $this->request['url'])){  
                $mod_nm   =    $this->request->query('mod_nm');
                $for_nm   =    $this->request->query('for_nm');   
                $sta_a_dt   =    $this->request->query('sta_a_dt');
                $sta_b_dt   =    $this->request->query('sta_b_dt');
                $end_a_dt   =    $this->request->query('end_a_dt');
                $end_b_dt   =    $this->request->query('end_b_dt');
                $cre_a_dt   =    $this->request->query('cre_a_dt');
                $cre_b_dt   =    $this->request->query('cre_b_dt');     
                $bookable =  $this->request->query('bookable'); 
                $ev_type  =   $this->request->query('ev_type');  
            }             
			$totalRows = Array();
			$myArr = $this->CouldntBookVehicle->getDataForGrid($this->request->query('rows'), 
			                                         $this->request->query('page'), 
			                                         $mod_nm ,
			                                         $creation_a_dt  ,
			                                         $creation_b_dt ,
			                                         $bookable
			                                         );
			$out = Array("data" => $myArr['data'], "num" => count($myArr['data']), "total" => $myArr['totalpages'], "page"=> $this->request->query('page'));
			$this->set("myArr", json_encode($out)  );
		}

/*
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
*/

}
?>