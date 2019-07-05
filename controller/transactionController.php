<?php

class TransactionController extends BaseController
{
	public function index()
	{
		$Trans= new TransactionService();
		$transactions=$Trans->getAllTransactions($_SESSION['oib']);
		$this->registry->template->transactions = $transactions;
		$this->registry->template->show( 'transaction_index' );
	}
};

?>
