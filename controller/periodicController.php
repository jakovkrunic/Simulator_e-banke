<?php

class PeriodicController extends BaseController
{
  public function index() {
    $as = new AccountService();
		$ps= new PeriodicService();
		$periodic_transactions=$ps->getAllTransactions($_SESSION['oib']);
		$this->registry->template->periodic_transactions = $periodic_transactions;


		$op_racuni = $as->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$ps->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assignee_periodic_trans= $arr;




		$this->registry->template->show( 'periodic_index' );
  }

  public function novi()
	{
		$ac = new AccountService();
		$racuni=$ac->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->accts = $racuni;

		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);

		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$ac->getAccountById($op_racuni[$i]);
		}
		$this->registry->template->assigneeaccts= $arr;

		$this->registry->template->show( 'periodic_new' );


	}
	public function save()
	{
		$Trans= new PeriodicService();
		$posiljatelj=$_POST["koji"];
		$racun_primatelj=$_POST["racun_primatelj"];
		$opis=$_POST["opis"];
		$iznos=$_POST["iznos"];
    $period = $_POST['period'];

		$ac=new AccountService();
		$racun=$ac->getAccountById($posiljatelj);
		$prim=$ac->getAccountById($racun_primatelj);
		if($prim===null){
			$transactions=$Trans->getAllTransactions($_SESSION['oib']);
			$this->registry->template->poruka= "Primatelj ne postoji";
		}
		else if( $prim!==null){
			$valuta=$racun->valuta_racuna;

			$Trans->insertNewTransaction($opis,$posiljatelj,$racun_primatelj,$valuta,$iznos,$period);
			$this->registry->template->poruka= "Uspjesno ste poslali zahtjev za transakcijom! Transakcija će biti odobrena ili odbijena za 3-5 dana.";
		}

    $periodic_transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$this->registry->template->periodic_transactions = $periodic_transactions;


		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assignee_periodic_trans= $arr;




		$this->registry->template->show( 'periodic_index' );

	}

	public function undo(){
		$Trans= new PeriodicService();
		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$id_trans=$_POST["ponisti"];
		echo $id_trans;
		$ac=new AccountService();
		$transaction=$Trans->getTransactionById($id_trans);
		$Trans->removePeriodicTransaction($id_trans);
		$this->registry->template->poruka= "Uspješno ste poništili transakciju!";

		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$this->registry->template->periodic_transactions = $transactions;

		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assignee_periodic_trans= $arr;

		$this->registry->template->show( 'periodic_index' );
	}
}
