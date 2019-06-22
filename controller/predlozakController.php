<?php

class PredlozakController extends BaseController
{
	public function index()
	{
		$this->registry->template->naslov = 'Glavni izbornik';
		$this->registry->template->show( 'predlozak_index' );
	}

	public function pregledplatni()
	{
		$ts = new PredlozakService();
		$as = new AccountService();
		$svi_predlosci = array();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);
		foreach( $racuni as $racun )
		{
			$predlozak = $ts->getTemplatesByOwnerAccountId( $racun->id );
			$svi_predlosci = array_merge($svi_predlosci, $predlozak);
		}
		$platni_nalozi = array();
		for($i=0;$i<count($svi_predlosci);$i++)
		{
			$test=true;
			foreach( $racuni as $racun )
			{
				if($svi_predlosci[$i]->racun_primatelj == $racun->id)
				{
					$test=false;
					break;
				}
			}
			if($test)
				$platni_nalozi[] = $svi_predlosci[$i];
		}
		$tipovi_mojih_racuna = array();
		for($i=0;$i<count($platni_nalozi);$i++)
		{
			$tipovi_mojih_racuna[] = $as->getAccountById($platni_nalozi[$i]->racun_posiljatelj)->tip_racuna;
		}
		$this->registry->template->naslov = 'Pregled predložaka platnih naloga';
		$this->registry->template->platni = $platni_nalozi;
		$this->registry->template->tipovi = $tipovi_mojih_racuna;
		$this->registry->template->show( 'predlozak_pregledplatni' );
	}

	public function pregledinterni()
	{
		$ts = new PredlozakService();
		$as = new AccountService();
		$svi_predlosci = array();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);
		foreach( $racuni as $racun )
		{
			$predlozak = $ts->getTemplatesByOwnerAccountId( $racun->id );
			$svi_predlosci = array_merge($svi_predlosci, $predlozak);
		}
		$interni_prijenosi = array();
		for($i=0;$i<count($svi_predlosci);$i++)
		{
			$test=true;
			foreach( $racuni as $racun )
			{
				if($svi_predlosci[$i]->racun_primatelj == $racun->id)
				{
					$test=false;
					break;
				}
			}
			if(!$test)
				$interni_prijenosi[] = $svi_predlosci[$i];
		}
		$tipovi_mojih_racuna_posiljatelja = array();
		$tipovi_mojih_racuna_primatelja = array();
		for($i=0;$i<count($interni_prijenosi);$i++)
		{
			$tipovi_mojih_racuna_posiljatelja[] = $as->getAccountById($interni_prijenosi[$i]->racun_posiljatelj)->tip_racuna;
			$tipovi_mojih_racuna_primatelja[] = $as->getAccountById($interni_prijenosi[$i]->racun_primatelj)->tip_racuna;
		}
		$this->registry->template->naslov = 'Pregled predložaka internih prijenosa';
		$this->registry->template->interni = $interni_prijenosi;
		$this->registry->template->tipovi1 = $tipovi_mojih_racuna_posiljatelja;
		$this->registry->template->tipovi2 = $tipovi_mojih_racuna_primatelja;
		$this->registry->template->show( 'predlozak_pregledinterni' );
	}
};

?>
