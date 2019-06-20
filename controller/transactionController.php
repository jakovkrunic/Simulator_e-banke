<?php

class TransactionController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'transaction_index' );
	}
};

?>
