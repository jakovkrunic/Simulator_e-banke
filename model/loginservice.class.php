<?php

class LoginService
{

	function checkUserLogin($oib, $email, $password){ 

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib, ime, email, prezime, password_hash, registriran, odobren FROM projekt_korisnik WHERE oib=:oib AND email=:email' );
			$st->execute( array( 'oib' => $oib, 'email' => $email ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$row = $st->fetch();
		if( $row === false )
		{
			return 'no_user';
		}
		else if( $row['registriran'] === '0')
			return 'check_email';
		else if ( $row['odobren'] === '0')
			return 'contact_admin';
		else if( !password_verify($password, $row['password_hash']) ) 
			return 'not_correct';
		else
		{
		// Sad je valjda sve OK. Ulogiraj ga.
		$_SESSION['oib'] = $_POST['oib'];
		$_SESSION['ime'] = $row['ime'];
		$_SESSION['prezime'] = $row['prezime'];
		$_SESSION['email'] = $row['email'];
		return 'OK';
		}
	}

	function checkUserOIB($oib)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$row = $st->fetch();
		if($row !== false)
			return false;
		else return true;
	}	

	function tryRegistration($oib, $name, $surname, $password, $email)
	{

		// Dodaj novog korisnika u bazu. Prvo mu generiraj random string od 10 znakova za registracijski link.
		$reg_seq = '';
		for( $i = 0; $i < 20; ++$i )
			$reg_seq .= chr( rand(0, 25) + ord( 'a' ) ); // Zalijepi slučajno odabrano slovo

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_korisnik(oib, ime, prezime, email, password_hash, registriran, odobren, reg_seq) VALUES ' .
				                '(:oib, :name, :surname, :email, :password, 0, 0, :reg_seq)' );

			$st->execute( array( 'oib' => $oib,
								 'name' => $name,	
								 'surname' => $surname,
								 'email' => $email,
								 'password' => password_hash( $password, PASSWORD_DEFAULT ),	
								 'reg_seq' => $reg_seq			                 
				                  ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		//Sad mu još pošalji mail
		$to       = $email;
		$subject  = 'Registracijski mail';
		$message  = 'Poštovani ' . $name . ', ' . $surname . ' (OIB: ' . $oib . ')' . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		$message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?rt=login/register&niz=' . $reg_seq . "\n";
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			return 'Can not send e-mail';

		//Zahvali mu na prijavi.
		return 'OK';

	}

	function finishRegistration($niz)
	{
		$db = DB::getConnection();

		try
		{
			$st = $db->prepare( 'SELECT * FROM projekt_korisnik WHERE reg_seq=:reg_seq' );
			$st->execute( array( 'reg_seq' => $niz ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$row = $st->fetch();

		if( $st->rowCount() !== 1 )
			return 'Not OK';
		else
		{
			// Sad znamo da je točno jedan takav. Postavi mu registriran na 1.
			try
			{
				$st = $db->prepare( 'UPDATE projekt_korisnik SET registriran=1 WHERE reg_seq=:reg_seq' );
				$st->execute( array( 'reg_seq' => $niz ) );
			}
			catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

			// Sve je uspjelo, zahvali mu na registraciji.
			return 'OK';
		}
	}

	

};

?>
