<?php

class AccountController extends BaseController
{
	public function index()
	{
		$as = new AccountService();
		$us = new UserService();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);
		$punomocni_ids = $as->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$punomocni = array();
		$vlasnici = array();
		for($i=0;$i<count($punomocni_ids);$i++)
		{
			$punomocni[] = $as->getAccountById($punomocni_ids[$i]);
			$temp = $as->getAccountById($punomocni_ids[$i]);
			$temp_oib = $temp->oib;
			$vlasnici[] = $us->getUserByOIB($temp_oib);
		}
		$op_racuni = array();
		$korisnici = array();
		foreach ($racuni as $racun)
		{
			$oibi=$as->getAllAccountAssigneesOIB($racun->id);
			$opunomocenici = array();
			foreach ($oibi as $oib)
				$opunomocenici[] = $us->getUserByOIB($oib);

			if(!empty($opunomocenici))
			{
				$op_racuni[]=$racun;
				$korisnici[]=$opunomocenici;
			}
		}
		$this->registry->template->racuni = $racuni;
		$this->registry->template->op_racuni = $op_racuni;
		$this->registry->template->punomocni = $punomocni;
		$this->registry->template->vlasnici = $vlasnici;
		$this->registry->template->korisnici = $korisnici;
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
		$minus = -1 * $_POST['minus'];
		$oib = $_SESSION['oib'];
		$pocetni_iznos = $_POST['pocetni_iznos'];

		$as->openAccount($oib, $vrsta, $valuta, $pocetni_iznos, $minus);


		$this->registry->template->racuni = $as->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->show( 'account_index' );

	}

	public function punomoc()
	{
		$as = new AccountService();
		$this->registry->template->racun = $as->getAccountById( $_GET['id_racun'] );
		$this->registry->template->naslov = 'Zahtjev za davanje punomoći';
		$this->registry->template->message = '';
		$this->registry->template->show( 'account_punomoc' );
	}

	public function provjera()
	{
		$as = new AccountService();
		$us = new UserService();
		$svi = $us->getAllUsers();
		$id_racuna = $_GET['id_racun'];
		$oib_opunomocenika = $_POST['oib'];
		$oibi = $as->getAllAccountAssigneesOIB($id_racuna);
		if($_SESSION['oib'] == $oib_opunomocenika)
		{
			$this->registry->template->racun = $as->getAccountById( $_GET['id_racun'] );
			$this->registry->template->naslov = 'Zahtjev za davanje punomoći';
			$this->registry->template->message = 'Ne možete sami sebi biti opunomoćenik!';
			$this->registry->template->show( 'account_punomoc' );
		}
		else if(in_array($oib_opunomocenika, $oibi))
		{
			$this->registry->template->racun = $as->getAccountById( $_GET['id_racun'] );
			$this->registry->template->naslov = 'Zahtjev za davanje punomoći';
			$this->registry->template->message = 'Osoba s unesenim OIB-om već ima punomoć nad Vašim računom!';
			$this->registry->template->show( 'account_punomoc' );
		}
		else
		{
			$test = false;
			foreach($svi as $korisnik)
			{
				if($korisnik->oib == $oib_opunomocenika)
				{
					$test = true;
					break;
				}
			}
			if(!$test)
			{
				$this->registry->template->racun = $as->getAccountById( $_GET['id_racun'] );
				$this->registry->template->naslov = 'Zahtjev za davanje punomoći';
				$this->registry->template->message = 'Uneseni OIB nije u evidenciji naše banke!';
				$this->registry->template->show( 'account_punomoc' );
			}
			else
			{
				$as->insertNewAssignee($id_racuna, $oib_opunomocenika);
				$this->registry->template->naslov = 'Zahtjev za davanje punomoći';
				$this->registry->template->message = 'Uspješno ste predali zahtjev za punomoć!';
				$this->registry->template->show( 'account_kraj' );
			}
		}

	}

};

?>
