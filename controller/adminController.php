<?php

class AdminController extends BaseController
{
    public function index()
    {
		$this->registry->template->show( 'admin_index' );
    }

	public function unapprovedUsers()
	{   
        $as = new AdminService();
        $this->registry->template->zahtjevi = $as->getUnapprovedUsers();
        $this->registry->template->title = "Administracija korisnika";
        $this->registry->template->show( 'admin_requests' );       
    }

    public function approve(){
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

    public function unapprovedAcc(){

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

            $as = new AdminService();
            $poruka = $as -> checkUser($ime, $prezime, $oib);
            
            if($poruka === 'OK')
            {
                if(!isset($_POST['iznos']) || !is_numeric($_POST['iznos']) || !isset($_POST['kamatna_stopa']) || !is_numeric($_POST['kamatna_stopa']))
                {
                    $this->registry->template->oib_korisnika = $_POST['oib'];	
                    $this->registry->template->ime_korisnika = $_POST['ime'];	
                    $this->registry->template->prezime_korisnika = $_POST['prezime'];

                    $this->registry->template->poruka = "Niste unijeli potrebne podatke ili ste ih unijeli neispravno.";		
                    $this->registry->template->naslov = "Otvaranje štednje";
                    $this->registry->template->show( 'admin_openSavingUser' ); 
                }
                else
                {
                    echo $_POST['ime'];   
                    $ime = $_POST['ime'];
                    $oib = $_POST['oib'];
                    $prezime = $_POST['prezime'];
                    $iznos = floatval($_POST['iznos']);
                    $kamatna_stopa = floatval($_POST['kamatna_stopa']);
                    $valuta = $_POST['valuta'];

                    $as = new AdminService();
                    $poruka = $as -> addSaving($oib, $iznos, $kamatna_stopa, $valuta);

                    $this->registry->template->poruka = $poruka;		
                    $this->registry->template->naslov = "Otvaranje štednje";
                    $this->registry->template->show( 'admin_openSavingUser' ); 
                }   
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
            $this->registry->template->oib_korisnika = $_POST['oib'];	
            $this->registry->template->ime_korisnika = $_POST['ime'];	
            $this->registry->template->prezime_korisnika = $_POST['prezime'];

            $this->registry->template->poruka = "Niste unijeli potrebne podatke ili ste ih unijeli neispravno.";		
            $this->registry->template->naslov = "Otvaranje štednje";
            $this->registry->template->show( 'admin_openSavingForm' ); 
        }
        else
        {
            echo $_POST['ime'];   
            $ime = $_POST['ime'];
            $oib = $_POST['oib'];
            $prezime = $_POST['prezime'];
            $iznos = floatval($_POST['iznos']);
            $kamatna_stopa = floatval($_POST['kamatna_stopa']);
            $valuta = $_POST['valuta'];

            $as = new AdminService();
            $poruka = $as -> addSaving($oib, $iznos, $kamatna_stopa, $valuta);

            $this->registry->template->poruka = $poruka;		
            $this->registry->template->naslov = "Otvaranje štednje";
            $this->registry->template->show( 'admin_openSavingUser' ); 
        }
    }
};

?>