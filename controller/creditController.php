<?php

class CreditController extends BaseController
{
	public function index()
	{
		$credit= new CreditService();
		$credits=$credit->getAllCredits($_SESSION['oib']);
		$this->registry->template->krediti = $credits;
		$this->registry->template->show( 'credit_index' );
	}
	public function open(){

	}
};

?>
