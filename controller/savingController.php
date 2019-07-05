<?php

class SavingController extends BaseController
{
	public function index()
	{
		$savings= new SavingService();
		$savingaccs=$savings->getAllSavings($_SESSION['oib']);
		$this->registry->template->stednje = $savingaccs;
		$this->registry->template->show( 'saving_index' );
	}
	public function dodaj(){
		$ac = new AccountService();
		$racuni=$ac->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->accts = $racuni;

		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);

		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$ac->getAccountById($op_racuni[$i]);
		}
		$this->registry->template->assigneeaccts= $arr;

		$this->registry->template->show( 'saving_uplata' );
	}

	public function save()
	{
		$posiljatelj=$_POST["koji"];
		$racun_primatelj=$_POST["racun_primatelj"];
		$iznos=$_POST["iznos"];
		$ss=new SavingService();
		$ac=new AccountService();
		$racun=$ac->getAccountById($posiljatelj);
		if( ($racun->stanje_racuna-$racun->dozvoljeni_minus)>$iznos){
			$valuta=$racun->valuta_racuna;
			$ss->updateAmount($racun_primatelj,$iznos);
			$ac->updateAmount($posiljatelj,$iznos);
			$this->registry->template->poruka= "Uspjesno ste uplatili odabrani iznos u štednju!";
		}
		else{
			$this->registry->template->poruka= "Nemate toliko novaca na računu!";
		}

		$savingaccs=$ss->getAllSavings($_SESSION['oib']);
		$this->registry->template->stednje = $savingaccs;
		$this->registry->template->show( 'saving_index' );

	}
};

?>
