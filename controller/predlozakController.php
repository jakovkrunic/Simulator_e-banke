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
		$ps = new PredlozakService();
		$as = new AccountService();
		$svi_predlosci = array();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);
		foreach( $racuni as $racun )
		{
			$predlozak = $ps->getTemplatesByOwnerAccountId( $racun->id );
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
		$ps = new PredlozakService();
		$as = new AccountService();
		$svi_predlosci = array();
		$racuni = $as->getAllUserAccounts($_SESSION['oib']);
		foreach( $racuni as $racun )
		{
			$predlozak = $ps->getTemplatesByOwnerAccountId( $racun->id );
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
	public function stvori()
	{
		$this->registry->template->naslov = 'Stvaranje novog predloška';
		$this->registry->template->message = '';
		$this->registry->template->show( 'predlozak_stvori' );
	}
	public function provjeri()
	{
		$akcija = $_GET['akcija'];
		if($akcija == 'stvori')
		{
			$title = 'Stvaranje novog predloška';
			$str = 'predlozak_stvori';
		}
		else
		{
			$title = 'Izmjena novog predloška';
			$str = 'predlozak_izmijeni';
		}
		$ps = new PredlozakService();
		$as = new AccountService();

		if( !isset( $_POST['ime'] ) || !isset( $_POST['moj'] ) || !isset( $_POST['primatelj'] ) || !isset( $_POST['valuta'] ) )
		{
			$this->registry->template->naslov = $title;
			$this->registry->template->message = 'Niste unijeli sve podatke!';
			$this->registry->template->show( $str );
			exit();
		}
		else if (!preg_match( '/^[0-9]+$/', $_POST['moj'] ) || !preg_match( '/^[0-9]+$/', $_POST['primatelj'] )  )
		{
			$this->registry->template->naslov = $title;
			$this->registry->template->message = 'Računi smiju sadržavati samo brojeve!';
			$this->registry->template->show( $str );
			exit();
		}
		else if (!preg_match( '/^[A-Z]{3}$/', $_POST['valuta'] ) )
		{
			$this->registry->template->naslov = $title;
			$this->registry->template->message = 'Valuta je niz od 3 velika slova!';
			$this->registry->template->show( $str );
			exit();
		}
    else
		{
      $racuni = $as->getAllUserAccounts($_SESSION['oib']);
			$test = false;
			foreach( $racuni as $racun )
			{
				if($_POST['moj'] == $racun->id)
				{
					$test = true;
					break;
				}
			}
			if(!$test)
			{
				$this->registry->template->naslov = $title;
				$this->registry->template->message = 'U rubrici Broj mog računa ste unijeli račun koji nije Vaš!';
				$this->registry->template->show( $str );
				exit();
			}
			if($_POST['moj'] == $_POST['primatelj'])
			{
				$this->registry->template->naslov = $title;
				$this->registry->template->message = 'Račun primatelja mora biti različit od računa s kojeg šaljete!';
				$this->registry->template->show( $str );
				exit();
			}
			if($akcija == 'stvori')
			{
				$ps->insertNewTemplate($_POST['ime'], $_POST['moj'], $_POST['primatelj'], $_POST['valuta'] );
				$this->registry->template->naslov = $title;
				$this->registry->template->message = 'Uspješno ste stvorili novi predložak!';
				$this->registry->template->show( 'predlozak_kraj' );
			}
			else
			{
				$ps->changeTemplate($_GET['akcija'], $_POST['ime'], $_POST['moj'], $_POST['primatelj'], $_POST['valuta'] );
				$this->registry->template->naslov = $title;
				$this->registry->template->message = 'Uspješno ste izmijenili predložak!';
				$this->registry->template->show( 'predlozak_kraj' );
			}

    }
  }

	public function plati()
	{
		$ps = new PredlozakService();
		$this->registry->template->predlozak = $ps->getTemplateById( $_GET['id_predlozak'] );
		$this->registry->template->naslov = 'Plaćanje putem predloška';
		$this->registry->template->message = '';
		$this->registry->template->show( 'predlozak_plati' );
	}

	public function transakcija()
	{
		$ps = new PredlozakService();
		$ts = new TransactionService();
		$predlozak = $ps->getTemplateById( $_GET['id_predlozak'] );
		$ts->insertNewTransaction($predlozak->ime, $predlozak->racun_posiljatelj, $predlozak->racun_primatelj, $predlozak->valuta, $_POST['iznos'] );
		$this->registry->template->naslov = 'Uspješno ste poslali zahtjev za transakcijom!';
		$this->registry->template->message = '';
		$this->registry->template->show( 'predlozak_kraj' );
	}

	public function izmijeni()
	{
		$ps = new PredlozakService();
		$this->registry->template->predlozak = $ps->getTemplateById( $_GET['id_predlozak'] );
		$this->registry->template->naslov = 'Izmjena predloška';
		$this->registry->template->message = '';
		$this->registry->template->show( 'predlozak_izmijeni' );
	}

	public function obrisi()
	{
		$ps = new PredlozakService();
		$ps->deleteTemplate($_GET['id_predlozak']);
		$this->registry->template->naslov = 'Obrisan predložak!';
		$this->registry->template->message = '';
		$this->registry->template->show( 'predlozak_kraj' );
	}

};

?>
