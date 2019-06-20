<?php

class AccountController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'account_index' );
	}
};

?>
