<?php

class TransactionController extends BaseController
{
	public function index()
	{
		$as = new AccountService();
		$Trans= new TransactionService();
		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$this->registry->template->transactions = $transactions;

		$incomingtransactions=$Trans->getAllIncomingTransactions($_SESSION['oib']);
		$this->registry->template->incomingtransactions = $incomingtransactions;


		$op_racuni = $as->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assigneetrans= $arr;

		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getIncomingTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->incomingassigneetrans= $arr;




		$this->registry->template->show( 'transaction_index' );


	}

	public function new()
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

		$this->registry->template->show( 'transaction_new' );


	}
	public function save()
	{
		$Trans= new TransactionService();
		$posiljatelj=$_POST["koji"];
		$racun_primatelj=$_POST["racun_primatelj"];
		$opis=$_POST["opis"];
		$iznos=$_POST["iznos"];

		$ac=new AccountService();
		$racun=$ac->getAccountById($posiljatelj);
		$prim=$ac->getAccountById($racun_primatelj);
		if($prim===null){
			$transactions=$Trans->getAllTransactions($_SESSION['oib']);
			$this->registry->template->poruka= "Primatelj ne postoji";
		}
		else if( $prim!==null && ($racun->stanje_racuna-$racun->dozvoljeni_minus)>$iznos){
			$valuta=$racun->valuta_racuna;

			$ac->updateAmount($posiljatelj,$iznos);
			$Trans->insertNewTransaction($opis,$posiljatelj,$racun_primatelj,$valuta,$iznos);
			$transactions=$Trans->getAllTransactions($_SESSION['oib']);
			$this->registry->template->poruka= "Uspjesno ste poslali zahtjev za transakcijom! Transakcija će biti odobrena ili odbijena za 3-5 dana.";
		}
		else{
			$transactions=$Trans->getAllTransactions($_SESSION['oib']);
			$this->registry->template->poruka= "Nemate toliko novaca na računu!";
		}
		$this->registry->template->transactions = $transactions;
		$incomingtransactions=$Trans->getAllIncomingTransactions($_SESSION['oib']);
		$this->registry->template->incomingtransactions = $incomingtransactions;

		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assigneetrans= $arr;

		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getIncomingTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->incomingassigneetrans= $arr;

		$this->registry->template->show( 'transaction_index' );

	}

	public function undo(){
		$Trans= new TransactionService();
		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$id_trans=$_POST["ponisti"];
		echo $id_trans;
		$ac=new AccountService();
		$transaction=$Trans->getTransactionById($id_trans);
		if($transaction->odobrena != 0){
				$this->registry->template->poruka= "Transakcija je u međuvremenu updateana!";
				}
		else {
			$Trans->removependingTransaction($id_trans);
			$ac->updateAmount($transaction->racun_posiljatelj,-$transaction->iznos);
			$this->registry->template->poruka= "Uspješno ste poništili transakciju!";
		}

		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$this->registry->template->transactions = $transactions;
		$incomingtransactions=$Trans->getAllIncomingTransactions($_SESSION['oib']);
		$this->registry->template->incomingtransactions = $incomingtransactions;

		$op_racuni = $ac->getAllAssigneeAccountsFromOIB($_SESSION['oib']);
		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->assigneetrans= $arr;

		$arr= [];
		for($i=0;$i<count($op_racuni);$i++){
			$arr[]=$Trans->getIncomingTransactionsBySenderId($op_racuni[$i]);
		}
		$this->registry->template->incomingassigneetrans= $arr;

		$this->registry->template->show( 'transaction_index' );
	}
};

?>
