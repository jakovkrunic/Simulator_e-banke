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
};

?>