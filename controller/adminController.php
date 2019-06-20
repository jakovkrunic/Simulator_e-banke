<?php

class AdminController extends BaseController
{
	public function index()
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

        $registriran = $_GET['registriran'];
        $oib = $_GET['oib'];

        if($registriran = 0){
            //posalji mail da je odobren ali jos nije aktivirao racun
        }else{
            //posalji mail da je odobren
        }

        $db = DB::getConnection();

        try
			{
				$st = $db->prepare( 'UPDATE projekt_korisnik SET odobren=1 WHERE oib=:oib' );
				$st->execute( array( 'oib' => $oib ) );
			}
            catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
            
        $as = new AdminService();
        $this->registry->template->zahtjevi = $as->getUnapprovedUsers();
        $this->registry->template->title = "Administracija korisnika";
        $this->registry->template->show( 'admin_requests' );   
    }
};

?>