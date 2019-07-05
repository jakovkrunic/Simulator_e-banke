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
};

?>
