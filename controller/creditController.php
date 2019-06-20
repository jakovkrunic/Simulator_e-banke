<?php

class CreditController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'credit_index' );
	}
};

?>
