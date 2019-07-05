<?php

class AdminService
{
	function getUnapprovedUsers(){

        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT oib, ime, email, prezime, odobren, registriran FROM projekt_korisnik WHERE odobren = 0' );
        $st->execute();
        $zahtjevi = array();
        while($row = $st->fetch()){
            $zahtjevi[] = $row;
        }

        return $zahtjevi;
	}
	
	function rejectUser($oib)
	{
		$db = DB::getConnection();

		try
		{
			$st = $db->prepare( 'SELECT oib, ime, email, prezime FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib ));
		}
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$row = $st->fetch();

		try
		{
			$st = $db->prepare( 'DELETE FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		
		$to       = $row['email'];
		$subject  = 'Povratni mail';
		$message  = 'Poštovani ' . $row['ime'] . ', ' . $row['prezime'] . ' (OIB: ' . $row['oib'] . ')' . "!\n";
			$message .= 'Administrator Vam nije prihvatio zahtjev za izradu korisničkog računa.' . "\n";
			
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			return 'Mail se ne može poslati.';

		//Zahvali mu na prijavi.
		return 'ok';
	}

    function getAllUnapprovedAccounts()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE odobren=0' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Account($row['id'], $row['oib'], $row['tip_racuna'] ,
					$row['valuta_racuna'], $row['stanje_racuna'],	$row['datum_izrade'], $row['odobren'], $row['dozvoljeni_minus']);
		}

		return $arr;
	}


	function approveAccount($id){

        try
			{
				$db = DB::getConnection();
				$st = $db->prepare( 'UPDATE projekt_racun SET odobren=1 WHERE id=:id' );
				$st->execute( array( 'id' => $id ) );
			}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
	}
	
	function rejectAccount($id)
	{
		$db = DB::getConnection();
		try
		{
			$st = $db->prepare( 'SELECT oib FROM projekt_racun WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$oib_korisnika = $st->fetch();

		try
		{
			$st = $db->prepare( 'DELETE FROM projekt_racun WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		try
		{
			$st = $db->prepare( 'SELECT oib, ime, email, prezime FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib_korisnika['oib']) );
		}
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$row = $st->fetch();
		$to       = $row['email'];
		$subject  = 'Povratni mail';
		$message  = 'Poštovani ' . $row['ime'] . ', ' . $row['prezime'] . ' (OIB: ' . $row['oib'] . ')' . "!\n";
			$message .= 'Administrator Vam nije prihvatio zahtjev za izradu računa.' . "\n";
			
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			return 'Mail se ne može poslati.';

		//Zahvali mu na prijavi.
		return 'ok';
	}

    function sendEmail($oib, $poruka)
    {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib, ime, email, prezime FROM projekt_korisnik WHERE oib=:oib' );

			$st->execute( array( 'oib' => $oib) );
		}
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
        $row = $st->fetch();
        if($row === false)
            return 'Nema korisnika s tim oib-om';

        $to       = $row['email'];
        $subject  = 'Potvrdni mail';
        if ($poruka === 'nije_aktiviran')
        {
            $message  = 'Poštovani ' . $row['ime'] . ', ' . $row['prezime'] . ' (OIB: ' . $oib . ')' . "!\n";
            $message .= 'Administrator Vas je odobrio, još samo Vi morate potvrditi registraciju.' . "\n";
            $message .= 'Mail Vam je već bio poslan prilikom slanja zahtjeva.' . "\n";
        }
        else if ($poruka === 'aktiviran')
        {
            $message  = 'Poštovani ' . $row['ime'] . ', ' . $row['prezime'] . ' (OIB: ' . $oib . ')' . "!\n";
            $message .= 'Administrator Vas je odobrio i Vaša je registracija kompletna.' . "\n";
            $message .= 'Posjetite stranice banke i ulogirajte se.' . "\n";
        }
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			return 'Mail se ne može poslati.';

		//Zahvali mu na prijavi.
		return 'ok';
	}

	
	function checkUser($ime, $prezime, $oib)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT oib, ime, email, prezime FROM projekt_korisnik WHERE oib=:oib AND ime=:ime AND prezime=:prezime' );

			$st->execute( array( 'oib' => $oib, 'ime' => $ime, 'prezime' => $prezime) );
		}
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
        $row = $st->fetch();
        if($row === false)
			return 'Nema korisnika s tim oib-om';
		else return 'OK';
	}

	function addSaving($oib, $iznos, $kamatna_stopa, $valuta)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_stednja(oib, iznos_stednje, kamatna_stopa, valuta) VALUES ' .
				                '(:oib, :iznos, :kam, :val)' );

			$st->execute( array( 'oib' => $oib,
								 'iznos' => $iznos,	
								 'kam' => $kamatna_stopa,
								 'val' => $valuta		                 
				                  ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		return "Uspješno ste otvorili štednju.";
	}

	function getUserAccounts($oib)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE oib=:oib AND odobren=:odobren' );
			$st->execute( array( 'oib' => $oib , 'odobren' => 1) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Account($row['id'], $row['oib'], $row['tip_racuna'] ,
											$row['valuta_racuna'], $row['stanje_racuna'],	$row['datum_izrade'], $row['odobren'], $row['dozvoljeni_minus']);
		}

		return $arr;
	}

	function addCredit($oib, $iznos, $kamatna_stopa, $valuta, $racun, $rata)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id FROM projekt_racun WHERE oib=:oib AND tip_racuna=:tip' );
			$st->execute( array( 'oib' => $oib , 'tip' => $racun) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$racun_id = $st->fetch();
		
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_kredit(oib, id_racuna, iznos_kredita, kamatna_stopa, rata_placanja, valuta) VALUES ' .
				                '(:oib, :id, :iznos, :kam, :rata, :val)' );

			$st->execute( array( 'oib' => $oib,
								 'id' => $racun_id['id'],
								 'iznos' => $iznos,	
								 'kam' => $kamatna_stopa,
								 'rata' =>$rata,
								 'val' => $valuta		                 
				                  ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		return "Uspješno ste otvorili kredit.";
		
	}

	function getAllUnapprovedTransactions()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_transakcija WHERE odobrena=0' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Transaction($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
					$row['racun_primatelj'], $row['valuta'], $row['iznos'], $row['odobrena'], $row['datum']);
			
		}

		return $arr;
	}
}
?>
