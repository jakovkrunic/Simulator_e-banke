<?php

class AccountController extends BaseController
{
	public function index()
	{
		$as = new AccountService();
		$this->registry->template->racuni = $as->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->show( 'account_index' );
	}

	public function open(){

		$as = new AccountService();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);

		$vrsteRacuna = array("tekuci", "ziro", "devizni");

		foreach ($racuni as $key) {
			$vrsta = $key->tip_racuna;
			if($vrsta == 'tekuci'){
 				$vrsteRacuna = array_diff($vrsteRacuna, array("tekuci"));
			}
			else if($vrsta == 'ziro'){
 				$vrsteRacuna = array_diff($vrsteRacuna, array("ziro"));				
			}
			else if($vrsta == 'devizni'){				
 				$vrsteRacuna = array_diff($vrsteRacuna, array("devizni"));
			}
		}

		$this->registry->template->vrste = $vrsteRacuna;
		$this->registry->template->naslov = "Otvaranje računa";
		$this->registry->template->show( 'otvaranje_racuna' );

	}
	
	public function save()
	{		
		$as = new AccountService();

		$vrsta = $_POST['vrsta'];
		$valuta = $_POST['valuta'];
		$minus = $_POST['minus'];
		$oib = $_SESSION['oib'];

		$as->openAccount($oib, $vrsta, $valuta, $minus);
		
		
		$this->registry->template->racuni = $as->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->show( 'account_index' );

	}



};

?>
