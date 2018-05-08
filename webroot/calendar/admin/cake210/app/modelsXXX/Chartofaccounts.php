<?php

class Chartofaccounts extends AppModel
{
    public $name = 'Chartofaccounts';
    public $displayField = 'account';

		function AddRefNum($a,$r){
			echo "update phpc_chartofaccounts set refnum = " . str_replace("'", "\\'",$r) . "' where account LIKE '" .  str_replace("'", "\\'",$a) . "'<br>";
			print_r( $this->query("update phpc_chartofaccounts set refnum = '" . str_replace("'", "\\'",$r) . "' where account LIKE '" .  str_replace("'", "\\'",$a) . "'") );
		}
	
		public $accntFields = Array(
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_gas"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_admin"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_repair"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_insurance"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_fines"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_misc_2"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_misc_3"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_misc_4"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_hours"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_blocked_time"),
			Array("t" => "phpc_vehicles", "a" => "acnt_new_code_km"),

			Array("t" => "phpc_billings", "a" => "acnt_new_code_gst"),
			Array("t" => "phpc_billings", "a" => "acnt_new_code_pst"),
			Array("t" => "phpc_billings", "a" => "acnt_new_rental_tax"),
			Array("t" => "phpc_billings", "a" => "acnt_new_gas_surcharge"),
			Array("t" => "phpc_billings", "a" => "acnt_new_self_insurance"),
			Array("t" => "phpc_billings", "a" => "acnt_new_carbon_offset"),
			Array("t" => "phpc_billings", "a" => "acnt_new_member_plan_low"),
			Array("t" => "phpc_billings", "a" => "acnt_new_member_plan_med"),
			Array("t" => "phpc_billings", "a" => "acnt_new_member_plan_high"),
			Array("t" => "phpc_billings", "a" => "acnt_new_member_plan_organization"),
			Array("t" => "phpc_billings", "a" => "acnt_new_accounts_receivable"),
			Array("t" => "phpc_billings", "a" => "acnt_new_accounts_receivable"),
			Array("t" => "phpc_billings", "a" => "acnt_new_long_term_member_discount"),
			Array("t" => "phpc_billings", "a" => "acnt_new_interest_charged"),
			
			Array("t" => "phpc_users", "a" => "acnt_code_customer"),
			Array("t" => "phpc_groups", "a" => "acnt_code_group_customer"),
			Array("t" => "phpc_invoiceextraitems", "a" => "acnt_code_new")
		);
		
		function EliminateDuplicates(){
			// get chart of accounts order by refnum
			$chartofaccounts = $this->find('all', array("order" => "Chartofaccounts.type, Chartofaccounts.refnum"));
			//print_r($chartofaccounts);
			$previousAccount = Array('refnum' => -1);
			foreach($chartofaccounts as $a){
				$a = $a['Chartofaccounts'];
				if ($previousAccount['refnum'] == $a['refnum']){
					echo("previous match " . $a['account'] . " " . $a['refnum'] . "<br>");
					//map all accounts to prev
					foreach($this->accntFields as $b){
						$query = "update " . $b['t'] . " set " . $b['a'] . "='" . $previousAccount['id'] . "' where " . $b['a'] . "='" . $a['id'] . "';";
						$this->query($query);
						echo($query . "<br>");
					}
					$this->query( "delete from phpc_chartofaccounts where id=" . $a['id'] );
					//$this->query("update phpc_vehicles set acnt_new_code_gas='" . $previousAccount['id'] . "' where acnt_new_code_gas='" . $a['id'] . "'");
					
				} else {
					echo("no match " . $a['account'] . " " . $a['refnum'] . "<br>");
					$previousAccount = $a;
				}
			}
		}
	}

?>