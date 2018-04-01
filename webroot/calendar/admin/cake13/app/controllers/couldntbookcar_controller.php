<?php
class CouldntbookcarController extends AppController {

	var $name = 'couldntbookcar';
	var $helpers = array('Html', 'Form' );
	var $uses = array("Bookable", "User", "CouldntBookVehicle");
	var $components = array('json');

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
//			print_r($this->params['url']);
            $mod_nm = $bookable = -1;
            $creation_a_dt = $creation_b_dt = '';
            
            if (array_key_exists('mod_nm', $this->params['url'])){  
                $mod_nm   =    $this->params['url']['mod_nm'];
                $for_nm   =    $this->params['url']['for_nm'];   
                $sta_a_dt   =    $this->params['url']['sta_a_dt'];
                $sta_b_dt   =    $this->params['url']['sta_b_dt'];
                $end_a_dt   =    $this->params['url']['end_a_dt'];
                $end_b_dt   =    $this->params['url']['end_b_dt'];
                $cre_a_dt   =    $this->params['url']['cre_a_dt'];
                $cre_b_dt   =    $this->params['url']['cre_b_dt'];     
                $bookable =  $this->params['url']['bookable']; 
                $ev_type  =   $this->params['url']['ev_type'];  
            }             
			$totalRows = Array();
			$myArr = $this->CouldntBookVehicle->getDataForGrid($this->params['url']['rows'], 
			                                         $this->params['url']['page'], 
			                                         $mod_nm ,
			                                         $creation_a_dt  ,
			                                         $creation_b_dt ,
			                                         $bookable
			                                         );
			$out = Array("data" => $myArr['data'], "num" => count($myArr['data']), "total" => $myArr['totalpages'], "page"=> $this->params['url']['page']);
			$this->set("myArr", $this->json->encode($out)  );
		}

/*
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
*/

}
?>