<?php

class AdminController extends BaseController
{
    public function index()
    {
        $as = new AdminService();
        $korisnici = $as-> getUnapprovedUsers();
        $racuni = $as -> getAllUnapprovedAccounts();
        $transakcije = $as -> getAllUnapprovedTransactions();
        $punomoci = $as -> getUnapprovedPunomoc();
        $periodicne = $as -> getAllUnapprovedPeriodic();
        $br_punomoci = count($punomoci);
        $br_korisnika = count($korisnici);
        $br_racuna = count($racuni);
        $br_transakcija = count($transakcije) + count($periodicne);
        $this->registry->template->br_korisnika = $br_korisnika;
        $this->registry->template->br_racuna = $br_racuna;
        $this->registry->template->br_punomoci = $br_punomoci;
        $this->registry->template->br_transakcija = $br_transakcija;
		$this->registry->template->show( 'admin_index' );
    }

	public function unapprovedUsers()
	{
        $as = new AdminService();
        $this->registry->template->zahtjevi = $as->getUnapprovedUsers();
        $this->registry->template->title = "Administracija korisnika";
        $this->registry->template->show( 'admin_requests' );
    }

    public function approve(){ //approve User
        if( !isset( $_GET['oib'])) {
            $this->registry->template->title = "Administracija korisnika";
            $this->registry->template->message = "Nije odabran OIB!";
            $this->registry->template->show( 'admin_requests' );
        }

        $db = DB::getConnection();

        $registriran = $_GET['registriran'];
        $oib = $_GET['oib'];

        try
			{
				$st = $db->prepare( 'UPDATE projekt_korisnik SET odobren=1 WHERE oib=:oib' );
				$st->execute( array( 'oib' => $oib ) );
			}
            catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

        $as = new AdminService();
        if($registriran = 0){
            //posalji mail da je odobren ali jos nije aktivirao racun
            $poruka = $as->sendEmail($oib, 'nije_aktiviran');
        }else{
            $poruka = $as->sendEmail($oib, 'aktiviran');
        }
        if ( $poruka !== 'ok' ) $this->registry->template->poruka = $poruka;
        else  $this->registry->template->poruka = '';
        $this->registry->template->zahtjevi = $as->getUnapprovedUsers();
        $this->registry->template->title = "Administracija korisnika";
        $this->registry->template->show( 'admin_requests' );


    }

    public function reject() //reject User
    {
        if( !isset( $_GET['oib']))
        {
            $this->registry->template->title = "Administracija korisnika";
            $this->registry->template->message = "Nije odabran OIB!";
            $this->registry->template->show( 'admin_requests' );
        }

        $as = new AdminService();

		$oib = $_GET['oib'];

		$poruka = $as->rejectUser($oib);

        $this->registry->template->poruka = '';
        $this->registry->template->zahtjevi = $as->getUnapprovedUsers();
        $this->registry->template->title = "Administracija korisnika";
        $this->registry->template->show( 'admin_requests' );
    }

    public function unapprovedAcc()
    {

		$as = new AdminService();

		$this->registry->template->racuni = $as->getAllUnapprovedAccounts();
		$this->registry->template->naslov = "Odobravanje računa";
		$this->registry->template->show( 'odobrenje_racuna' );
    }


	public function approveAcc()
	{
		$as = new AdminService();

		$id = $_GET['id'];

		$as->approveAccount($id);

		$this->registry->template->racuni = $as->getAllUnapprovedAccounts();
		$this->registry->template->naslov = "Odobravanje računa";
		$this->registry->template->show( 'odobrenje_racuna' );
    }

    public function rejectAcc()
    {
        $as = new AdminService();

		$id = $_GET['id'];

        $poruka = $as->rejectAccount($id);

        $this->registry->template->poruka = $poruka;

		$this->registry->template->racuni = $as->getAllUnapprovedAccounts();
		$this->registry->template->naslov = "Odobravanje računa";
		$this->registry->template->show( 'odobrenje_racuna' );
    }

    public function transactions()
    {
        $as = new AdminService();

		$this->registry->template->transakcije = $as->getAllUnapprovedTransactions();
    $this->registry->template->periodic = $as->getAllUnapprovedPeriodic();
		$this->registry->template->naslov = "Odobravanje transakcija";
		$this->registry->template->show( 'admin_transakcije' );
    }

    public function openSavingForm()
    {
        $this->registry->template->show( 'admin_openSavingUser' );
    }

    public function openSavingUser()
    {
        if( !isset( $_POST['oib']) || !isset($_POST['ime']) || !isset($_POST['prezime'])) {
            $this->registry->template->title = "Otvaranje štednje";
            $this->registry->template->poruka = "Nisu upisani svi podaci";
            $this->registry->template->show( 'admin_openSavingUser' );
        }
        else
        {

            $ime = $_POST['ime'];
            $oib = $_POST['oib'];
            $prezime = $_POST['prezime'];

            $_SESSION['oib_korisnika'] = $oib;
            $_SESSION['ime_korisnika'] = $ime;
            $_SESSION['prezime_korisnika'] = $prezime;

            $as = new AdminService();
            $poruka = $as -> checkUser($ime, $prezime, $oib);

            if($poruka === 'OK')
            {
                $this->registry->template->oib_korisnika = $oib;
                $this->registry->template->ime_korisnika = $ime;
                $this->registry->template->prezime_korisnika = $prezime;
                $this->registry->template->naslov = "Otvaranje štednje";
                $this->registry->template->show( 'admin_openSavingForm' );
            }
            else
            {
                $this->registry->template->poruka = "Podaci se ne poklapaju ili korisnik ne postoji.";
                $this->registry->template->naslov = "Otvaranje štednje";
                $this->registry->template->show( 'admin_openSavingUser' );
            }


        }

    }

    public function openSavingOpen()
    {
        if(!isset($_POST['iznos']) || !is_numeric($_POST['iznos']) || !isset($_POST['kamatna_stopa']) || !is_numeric($_POST['kamatna_stopa']))
        {
            $this->registry->template->oib_korisnika = $_SESSION['oib_korisnika'];
            $this->registry->template->ime_korisnika = $_SESSION['ime_korisnika'];
            $this->registry->template->prezime_korisnika = $_SESSION['prezime_korisnika'];

            $this->registry->template->poruka = "Niste unijeli potrebne podatke ili ste ih unijeli neispravno.";
            $this->registry->template->naslov = "Otvaranje štednje";
            $this->registry->template->show( 'admin_openSavingForm' );
        }
        else
        {
            $ime = $_SESSION['ime_korisnika'];
            $oib = $_SESSION['oib_korisnika'];
            $prezime = $_SESSION['prezime_korisnika'];
            $iznos = floatval($_POST['iznos']);
            $kamatna_stopa = floatval($_POST['kamatna_stopa']);
            $valuta = $_POST['valuta'];

            $as = new AdminService();
            $poruka = $as -> addSaving($oib, $iznos, $kamatna_stopa, $valuta);

            unset($_SESSION['oib_korisnika']);
            unset($_SESSION['ime_korisnika']);
            unset($_SESSION['prezime_korisnika']);

            $this->registry->template->poruka = $poruka;
            $this->registry->template->naslov = "Otvaranje štednje";
            $this->registry->template->show( 'admin_openSavingUser' );
        }
    }

    public function openCreditForm()
    {
        $this->registry->template->show( 'admin_openCreditUser' );
    }

    public function openCreditUser()
    {
        if( !isset( $_POST['oib']) || !isset($_POST['ime']) || !isset($_POST['prezime'])) {
            $this->registry->template->title = "Otvaranje kredita";
            $this->registry->template->poruka = "Nisu upisani svi podaci";
            $this->registry->template->show( 'admin_openCreditUser' );
        }
        else
        {

            $ime = $_POST['ime'];
            $oib = $_POST['oib'];
            $prezime = $_POST['prezime'];

            $_SESSION['oib_korisnika'] = $oib;
            $_SESSION['ime_korisnika'] = $ime;
            $_SESSION['prezime_korisnika'] = $prezime;

            $as = new AdminService();
            $poruka = $as -> checkUser($ime, $prezime, $oib);

            if($poruka === 'OK')
            {
                //ako je ok, trebamo njegove račune
                $racuni = $as -> getUserAccounts($oib);

                $this->registry->template->racuni = $racuni;
                $this->registry->template->oib_korisnika = $oib;
                $this->registry->template->ime_korisnika = $ime;
                $this->registry->template->prezime_korisnika = $prezime;
                $this->registry->template->naslov = "Otvaranje kredita";
                $this->registry->template->show( 'admin_openCreditForm' );
            }
            else
            {
                $this->registry->template->poruka = "Podaci se ne poklapaju ili korisnik ne postoji.";
                $this->registry->template->naslov = "Otvaranje kredita";
                $this->registry->template->show( 'admin_openCreditUser' );
            }


        }

    }

    public function openCreditOpen()
    {
        if(!isset($_POST['iznos']) || !is_numeric($_POST['iznos']) || !isset($_POST['kamatna_stopa']) || !is_numeric($_POST['kamatna_stopa']) || !isset($_POST['rata']) || !is_numeric($_POST['rata']))
        {
            $this->registry->template->oib_korisnika = $_SESSION['oib_korisnika'];
            $this->registry->template->ime_korisnika = $_SESSION['ime_korisnika'];
            $this->registry->template->prezime_korisnika = $_SESSION['prezime_korisnika'];

            $this->registry->template->poruka = "Niste unijeli potrebne podatke ili ste ih unijeli neispravno.";
            $this->registry->template->naslov = "Otvaranje kredita";
            $this->registry->template->show( 'admin_openCreditForm' );
        }
        else
        {
            $ime = $_SESSION['ime_korisnika'];
            $oib = $_SESSION['oib_korisnika'];
            $prezime = $_SESSION['prezime_korisnika'];
            $iznos = floatval($_POST['iznos']);
            $kamatna_stopa = floatval($_POST['kamatna_stopa']);
            $rata = floatval($_POST['rata']);
            $valuta = $_POST['valuta'];
            $racun = $_POST['vrsta'];

            $as = new AdminService();
            $poruka = $as -> addCredit($oib, $iznos, $kamatna_stopa, $valuta, $racun, $rata);

            unset($_SESSION['oib_korisnika']);
            unset($_SESSION['ime_korisnika']);
            unset($_SESSION['prezime_korisnika']);

            $this->registry->template->poruka = $poruka;
            $this->registry->template->naslov = "Otvaranje kredita";
            $this->registry->template->show( 'admin_openCreditUser' );
        }
    }

    public function approveTransaction()
    {
        $as = new AdminService();

		$id = $_GET['id'];

        $poruka = $as->acceptTransaction($id);

        $this->registry->template->poruka = $poruka;

		$this->registry->template->transakcije = $as->getAllUnapprovedTransactions();
    $this->registry->template->periodic = $as->getAllUnapprovedPeriodic();
		$this->registry->template->naslov = "Odobravanje transakcija";
		$this->registry->template->show( 'admin_transakcije' );
    }

    public function rejectTransaction()
    {
        $as = new AdminService();

		$id = $_GET['id'];

        $poruka = $as->rejectTransakciju($id);

        $this->registry->template->poruka = $poruka;

		$this->registry->template->transakcije = $as->getAllUnapprovedTransactions();
    $this->registry->template->periodic = $as->getAllUnapprovedPeriodic();
		$this->registry->template->naslov = "Odobravanje transakcija";
		$this->registry->template->show( 'admin_transakcije' );
    }

    public function unapprovedOpunomocenje()
    {
        $as = new AdminService();
        $this->registry->template->zahtjevi = $as->getUnapprovedPunomoc();
        $this->registry->template->naslov = "Odobrenje punomoći";
        $this->registry->template->show( 'admin_punomoc' );
    }

    public function approvePunomoc()
    {
        $as = new AdminService();

		$id = $_GET['id'];

        $poruka = $as->acceptPunomoc($id);

        $this->registry->template->poruka = $poruka;

		$this->registry->template->zahtjevi = $as->getUnapprovedPunomoc();
        $this->registry->template->naslov = "Odobrenje punomoći";
        $this->registry->template->show( 'admin_punomoc' );
    }

    public function rejectPunomoc()
    {
        $as = new AdminService();

		$id = $_GET['id'];

        $poruka = $as->rejectpunomoc($id);

        $this->registry->template->poruka = $poruka;

		$this->registry->template->zahtjevi = $as->getUnapprovedPunomoc();
        $this->registry->template->naslov = "Odobrenje punomoći";
        $this->registry->template->show( 'admin_punomoc' );
    }


    public function periodic() {

      $ps = new PeriodicService();
      $ps->resolvePeriodicTransactions();
      $ps->resolveCredits();
      $ps->resolveSavings();

      $as = new AdminService();
      $korisnici = $as-> getUnapprovedUsers();
      $racuni = $as -> getAllUnapprovedAccounts();
      $transakcije = $as -> getAllUnapprovedTransactions();
      $punomoci = $as -> getUnapprovedPunomoc();
      $periodicne = $as -> getAllUnapprovedPeriodic();
      $br_punomoci = count($punomoci);
      $br_korisnika = count($korisnici);
      $br_racuna = count($racuni);
      $br_transakcija = count($transakcije) + count($periodicne);
      $this->registry->template->br_korisnika = $br_korisnika;
      $this->registry->template->br_racuna = $br_racuna;
      $this->registry->template->br_punomoci = $br_punomoci;
      $this->registry->template->br_transakcija = $br_transakcija;
      $this->registry->template->poruka = "Akcije su provedene!";
      $this->registry->template->show( 'admin_index');
    }

    public function acceptPeriodic() {
      $as = new AdminService();

  $id = $_GET['id'];

      $poruka = $as->acceptPeriodic($id);

      $this->registry->template->poruka = $poruka;

  $this->registry->template->transakcije = $as->getAllUnapprovedTransactions();
  $this->registry->template->periodic = $as->getAllUnapprovedPeriodic();
  $this->registry->template->naslov = "Odobravanje transakcija";
  $this->registry->template->show( 'admin_transakcije' );
    }

    public function rejectPeriodic() {
      $as = new AdminService();

  $id = $_GET['id'];

      $poruka = $as->rejectPeriodic($id);

      $this->registry->template->poruka = $poruka;

  $this->registry->template->transakcije = $as->getAllUnapprovedTransactions();
  $this->registry->template->periodic = $as->getAllUnapprovedPeriodic();
  $this->registry->template->naslov = "Odobravanje transakcija";
  $this->registry->template->show( 'admin_transakcije' );
    }
};

?>
