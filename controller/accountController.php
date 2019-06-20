<?php

class AccountController extends BaseController
{
	public function index()
	{
		$as = new AccountService();
		$this->registry->template->racuni = $as->getAllUserAccounts($_SESSION['oib']);
		$this->registry->template->show( 'account_index' );
	}
};

?>
