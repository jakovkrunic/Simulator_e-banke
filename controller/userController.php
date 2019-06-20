<?php

class UserController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'user_index' );
	}
};

?>
