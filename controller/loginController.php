<?php

class LoginController extends BaseController
{
	public function index()
	{
    // Popuni template potrebnim podacima
    $this->registry->template->title = 'Dobrodošli na stranice Morž Banke.';
    $this->registry->template->message = '';
    $this->registry->template->show( 'login_index' );
	}

  public function provjeri()
	{
		$ls = new LoginService();

		// Ako nam forma nije u $_POST poslala autora u ispravnom obliku, preusmjeri ponovno na formu.
		if( !isset( $_POST['oib'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
		{
      //header( 'Location: ' . __SITE_URL . '/index.php?rt=login');
      $this->registry->template->title = 'Prijavite se.';
      $this->registry->template->message = 'Molimo, unesite sve tražene podatke.';
      $this->registry->template->show( 'login_index' );

			exit();
		}
    else{
      $poruka = $ls->checkUserLogin($_POST['oib'],  $_POST['email'], $_POST['password']);

      if($poruka === 'check_email')
      {
      //  header( 'Location: ' . __SITE_URL . '/index.php?rt=login');
        $this->registry->template->title = 'Prijavite se';
        $this->registry->template->message = 'Niste registrirani. Ako ste se već pokušali registrirati, provjerite email. Ako niste, registrirajte se.';
        $this->registry->template->show( 'login_index' );
  			exit();
      }
      else if( $poruka === 'not_correct')
      {
        //  header( 'Location: ' . __SITE_URL . '/index.php?rt=login');
          $this->registry->template->title = 'Prijavite se';
          $this->registry->template->message = 'Lozinka nije točna.';
          $this->registry->template->show( 'login_index' );
          exit();
      }
      else if( $poruka === 'no_user')
      {
        //  header( 'Location: ' . __SITE_URL . '/index.php?rt=login');
          $this->registry->template->title = 'Prijavite se';
          $this->registry->template->message = 'Nema korisnika s ovim OIB-om i emailom u bazi korisnika.';
          $this->registry->template->show( 'login_index' );
          exit();
      }
      else if( $poruka === 'contact_admin')
      {
        //  header( 'Location: ' . __SITE_URL . '/index.php?rt=login');
          $this->registry->template->title = 'Prijavite se';
          $this->registry->template->message = 'Vaš račun nije odobren od strane administratora. Kontaktirajte administratora.';
          $this->registry->template->show( 'login_index' );
          exit();
      }
      else if($poruka === 'OK' ){
        $oib = $_SESSION['oib'];
		    $ime = $_SESSION['ime'];
		    $prezime = $_SESSION['prezime'];
        $email = $_SESSION['email'];
        if ($oib === '00000000000' && $ime === 'admin' && $prezime === 'admin' && $email === 'admin@admin.com')
          header( 'Location: ' . __SITE_URL . '/index.php?rt=admin'); 
        else 
          header( 'Location: ' . __SITE_URL . '/index.php?rt=user');
        }
    }
  }

  public function registracija_stranica()
  {
    $this->registry->template->title = 'Registracija';
    $this->registry->template->message = '';
    $this->registry->template->show( 'registration_index' );
  }

  public function provjeri_registracija()
  {
    $ls = new LoginService();
    if( !isset( $_POST['oib'] ) || !isset($_POST['name'] ) || !isset($_POST['surname'] ) || !isset( $_POST['password'] ) || !isset( $_POST['email'] ) )
	  {
		  $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'Molimo, unesite sve podatke.';
      $this->registry->template->show( 'registration_index' );
			exit();
    }
    else if( !preg_match( '/^[0-9]{11}$/', $_POST['oib'] ) )
	  {
		  $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'OIB sadrži 11 znamenki između 0 i 9.';
      $this->registry->template->show( 'registration_index' );
			exit();
    }
    else if( !preg_match( '/^[A-Za-zčćžšđČŠŽĆĐ\',.-]*$/', $_POST['name'] ) )
	  {
		  $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'Ime nije u pravilnom obliku.';
      $this->registry->template->show( 'registration_index' );
			exit();
    }
    else if ( !preg_match( '/^[A-Za-zčćžšđČŠŽĆĐ\',.-]*$/', $_POST['surname'] ))
    {
      $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'Prezime nije u pravilnom obliku.';
      $this->registry->template->show( 'registration_index' );
			exit();
    }
    else if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) )
	  {
      $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'Nije unesen ispravan email.';
      $this->registry->template->show( 'registration_index' );
			exit();

    }
    else if($ls->checkUserOIB($_POST['oib']) === false )
    {
      $this->registry->template->title = 'Registracija';
      $this->registry->template->message = 'Korisnik s ovim OIB-om već postoji.';
      $this->registry->template->show( 'registration_index' );
			exit();
    }
    else
    {
      $poruka = $ls->tryRegistration($_POST['oib'], $_POST['name'], $_POST['surname'], $_POST['password'], $_POST['email']); //ovo implementirati
      if($poruka === 'OK')
        $this->registry->template->message = 'Zahtjev je zaprimljen.';
      else if($poruka === 'Ne mogu poslati email')
        $this->registry->template->message = 'Ne mogu poslati email.';
      $this->registry->template->title = 'Registracija';
      $this->registry->template->show( 'registration_index' );
			exit();
    }

  }

    public function register()
  {
    if( !isset( $_GET['niz'] ) || !preg_match( '/^[a-z]{20}$/', $_GET['niz'] ) )
    {
      $this->registry->template->message = 'Došlo je do greške.';
      $this->registry->template->title = 'Registration';
      $this->registry->template->show( 'registration_index' );
      exit();
    }
    else
    {
      $ls = new LoginService();
      $poruka = $ls -> finishRegistration($_GET['niz']);
      if($poruka === 'OK')
        $this->registry->template->message = 'Registration completed.';
      else if($poruka === 'Not OK')
        $this->registry->template->message = 'Došlo je do greške.';
      $this->registry->template->title = 'Registration';
      $this->registry->template->show( 'login_index' );
			exit();
    }
  }


  public function logout()
	{
    session_unset();
    session_destroy();
    header( 'Location: ' . __SITE_URL . '/index.php');
	}

};

?>
