<?php

class SavingController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'saving_index' );
	}
};

?>
