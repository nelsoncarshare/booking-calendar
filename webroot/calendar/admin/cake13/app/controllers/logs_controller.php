<?php
class LogsController extends AppController {

	var $name = 'logs';
	var $helpers = array('Html', 'Form' );
	var $uses = array("Bookable", "User", "Eventlog");
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
            $mod_nm = $for_nm = $bookable = $ev_type = -1;
            $sta_a_dt = $sta_b_dt = $end_a_dt = $end_b_dt = $cre_a_dt = $cre_b_dt = '';
            
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
			$myArr = $this->Eventlog->getDataForGrid($this->params['url']['rows'], 
			                                         $this->params['url']['page'], 
			                                         $mod_nm  ,
			                                         $for_nm  ,
			                                         $sta_a_dt  ,
			                                         $sta_b_dt  ,
			                                         $end_a_dt  ,
			                                         $end_b_dt  ,
			                                         $cre_a_dt  ,
			                                         $cre_b_dt  ,
			                                         $bookable,
			                                         $ev_type
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