<?php
App::uses('AppController', 'Controller');

class ChartofaccountsController extends AppController {


	public $helpers = array('Html', 'Form' );
	public $uses = array("Chartofaccounts");

    function beforeFilter()
    {
        $this->checkSession();
    }
    
	function index() {
		$this->Chartofaccounts->recursive = 0;
		$this->set('Chartofaccounts', $this->Paginate());
	}
	
	function save($id, $value){
		$this->layout = "json";	
		$this->Chartofaccounts->Read(null,$id);
		$this->Chartofaccounts->Set(Array("show_in_lists" => $value));
		$this->Chartofaccounts->Save();
	}
	
	//normal add
	function add(){
		$lines = Array();
		$file_handle = fopen($this->request->data['File']['image']['tmp_name'], "r");
		while (!feof($file_handle)) {
		   $lines[] = fgets($file_handle);
		}
		fclose($file_handle);
		
		$newAccounts = Array();
		$errors = Array();
		if (Count($lines) < 4) {
			$errors[] = "No accounts in chart of accounts";
		} else if (strncmp($lines[0], "!HDR", strlen("!HDR")) ||
			strncmp($lines[1], "HDR", strlen("HDR")) ||
			strncmp($lines[2], "!ACCNT", strlen("!ACCNT"))){
			$errors[] = "This doesn't look like a valid chart of accounts file ";
		} else {
			for ($i = 3; $i < Count($lines); $i++){
				$line = explode("\t", $lines[$i]);
				if (Count($line) > 1){
					if ($line[0] == "ACCNT"){
						$newAccounts[] = Array('account' => $line[1], 'type' => 2);
						//$newAccountsAcnt[] = $line[1];
					}
					
					if ($line[0] == "CUST"){
						$newAccounts[] = Array('account' => $line[1], 'type' => 1);
						//$newAccountsCust[] = $line[1];
					}
				}
			}
		}

		$accountsOnlyInDB = Array();
		$accountsInBoth = Array();
		$accountsOnlyInNew = Array();
		
		
		if (Count($errors) > 0){
			//echo "There were errors " . $errors[0];
		} else {
			$chartOfAccounts = $this->Chartofaccounts->find('all', Array('fields' => Array('Chartofaccounts.account', 'Chartofaccounts.type')));
			
			//print_r($chartOfAccounts);
			
			$accountsInDB = Array();
			foreach ($chartOfAccounts as $key => $value){
				$accountsInDB[] = $value['Chartofaccounts'];
			}
			
			for ($i = 0; $i < Count($accountsInDB); $i++){
				if (!$this->is_in_array($accountsInDB[$i], $newAccounts)){
					$accountsOnlyInDB[] = $accountsInDB[$i];
				}
			}

			for ($i = 0; $i < Count($newAccounts); $i++){
				if (!$this->is_in_array($newAccounts[$i], $accountsInDB)){
					$accountsOnlyInNew[] = $newAccounts[$i];
				} else {
					$accountsInBoth[] = $newAccounts[$i];
				}
			}
		}
		
		if (Count($errors) == 0){
			for($i=0; $i < Count($accountsOnlyInNew); $i++){
				$this->Chartofaccounts->Create();
				$this->Chartofaccounts->Set(Array('account' => $accountsOnlyInNew[$i]['account'], 
												  'type' => $accountsOnlyInNew[$i]['type'],
												  'refnum' => 1));
				$this->Chartofaccounts->Save();
			}
		}
		
		$this->Set("accountsOnlyInDB", $accountsOnlyInDB);
		$this->Set("accountsInBoth", $accountsInBoth);
		$this->Set("accountsOnlyInNew", $accountsOnlyInNew);
		$this->Set("errors", $errors);
	}
	
	function is_in_array($consider, $Accounts){
		foreach($Accounts as $acnt){
			if ($acnt['account'] == $consider['account'] && 
				intval($acnt['type']) == intval($consider['type'])){
					return true;
			} 
		}
		return false;
	}
	
	//eliminate duplicates
	function add3(){
		$this->Chartofaccounts->EliminateDuplicates();
	}
}
?>