<?php

class TemplateController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'template_index' );
	}
};

?>
