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

		$date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];

		if ($day >= 15) $month++;
		if ($month > 12) {
			$month -= 12;
			$year++;
		}
		$day = 15;

		$str_date = strval($year);

    $str_date = $str_date . '-';

    if ($month >= 10) $str_date = $str_date . strval($month);
    else $str_date = $str_date . '0' . strval($month);

    $str_date = $str_date . '-';

    if ($day >= 10) $str_date = $str_date . strval($day);
    else $str_date = $str_date . '0' . strval($day);

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_stednja(oib, iznos_stednje, kamatna_stopa, valuta, datum_sljedece) VALUES ' .
				                '(:oib, :iznos, :kam, :val, :datum)' );

			$st->execute( array( 'oib' => $oib,
								 'iznos' => $iznos,
								 'kam' => $kamatna_stopa,
								 'val' => $valuta,
								 'datum' => $str_date
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

		$date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];

		if ($day >= 15) $month++;
		if ($month > 12) {
			$month -= 12;
			$year++;
		}
		$day = 15;

		$str_date = strval($year);

    $str_date = $str_date . '-';

    if ($month >= 10) $str_date = $str_date . strval($month);
    else $str_date = $str_date . '0' . strval($month);

    $str_date = $str_date . '-';

    if ($day >= 10) $str_date = $str_date . strval($day);
    else $str_date = $str_date . '0' . strval($day);

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
			$st = $db->prepare( 'INSERT INTO projekt_kredit(oib, id_racuna, iznos_kredita, kamatna_stopa, rata_placanja, valuta, datum_sljedece) VALUES ' .
				                '(:oib, :id, :iznos, :kam, :rata, :val, :datum)' );

			$st->execute( array( 'oib' => $oib,
								 'id' => $racun_id['id'],
								 'iznos' => $iznos,
								 'kam' => $kamatna_stopa,
								 'rata' =>$rata,
								 'val' => $valuta,
								 'datum' => $str_date
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

	function getAllUnapprovedPeriodic()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_periodicna_transakcija WHERE odobrena=0' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new PeriodicTransaction($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
					$row['racun_primatelj'], $row['valuta'], $row['iznos'], $row['period'], $row['odobrena'], $row['datum_sljedece']);

		}

		return $arr;
	}

	function getUnapprovedPunomoc()
	{
		$db = DB::getConnection();
		try
		{
			$st = $db->prepare( 'SELECT * FROM projekt_punomoc WHERE odobren=0' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			try
			{
			$q = $db->prepare( 'SELECT ime, prezime FROM projekt_korisnik WHERE oib=:oib' );
			$q->execute(array( 'oib' => $row['oib_opunomocenika']));
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$opunomocenik = $q->fetch();

			try
			{
			$qq = $db->prepare( 'SELECT oib FROM projekt_racun WHERE id=:id' );
			$qq->execute(array( 'id' => $row['id_racuna']));
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$oib_vlasnika_racuna = $qq->fetch();

			try
			{
			$qqq = $db->prepare( 'SELECT ime, prezime FROM projekt_korisnik WHERE oib=:oib' );
			$qqq->execute(array( 'oib' => $oib_vlasnika_racuna['oib']));
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$vlasnik_racuna = $qqq->fetch();

			//, $oib_opunomocenika, $ime_opunomocenika, $prezime_opunomocenika, $odobren
			$arr[] = new Punomoc($row['id'], $row['id_racuna'], $oib_vlasnika_racuna['oib'], $vlasnik_racuna['ime'],
					$vlasnik_racuna['prezime'], $row['oib_opunomocenika'], $opunomocenik['ime'], $opunomocenik['prezime'], 0);

		}

		return $arr;
	}

	function acceptPunomoc($id){

        try
			{
				$db = DB::getConnection();
				$st = $db->prepare( 'UPDATE projekt_punomoc SET odobren=1 WHERE id=:id' );
				$st->execute( array( 'id' => $id ) );
			}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
	}

	function rejectpunomoc($id)
	{
		$db = DB::getConnection();
		try
		{
			$st = $db->prepare( 'SELECT oib_opunomocenika FROM projekt_punomoc WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		$oib_opunomocenika = $st->fetch();

		try
		{
			$st = $db->prepare( 'DELETE FROM projekt_punomoc WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		try
		{
			$st = $db->prepare( 'SELECT oib, ime, email, prezime FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib_opunomocenika['oib_opunomocenika']) );
		}
        catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		// $row = $st->fetch();
		// $to       = $row['email'];
		// $subject  = 'Povratni mail';
		// $message  = 'Poštovani ' . $row['ime'] . ', ' . $row['prezime'] . ' (OIB: ' . $row['oib'] . ')' . "!\n";
		// 	$message .= 'Administrator Vam nije dozvolio da postanete opunomoćenik za traženi račun.' . "\n";

		// $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		// 'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		// 'X-Mailer: PHP/' . phpversion();

		// $isOK = mail($to, $subject, $message, $headers);

		// if( !$isOK )
		// 	return 'Mail se ne može poslati.';

		// //Zahvali mu na prijavi.
		// return 'ok';
	}

	function rejectTransakciju($id)
	{
		// 1. uzmi sve podatke o toj transakciji
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_transakcija WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$transakcija = $st->fetch();

		// 2. na transakciju stavi odobrena = -1
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_transakcija SET odobrena=-1 WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		// 3. pronadi racun posiljatelja i dodaj mu ponovo iznos
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT stanje_racuna FROM projekt_racun WHERE id=:id' );
			$st->execute( array( 'id' => $transakcija['racun_posiljatelj'] ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$iznos_racuna = $st->fetch();
		$iznos = $iznos_racuna['stanje_racuna'] + $transakcija['iznos'];

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_racun SET stanje_racuna=:stanje WHERE id=:id' );
			$st->execute( array( 'stanje' => $iznos, 'id' => $transakcija['racun_posiljatelj']  ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		return "OK";
	}

	function acceptTransaction($id) {
		// Nadji transakciju
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_transakcija WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$transakcija = $st->fetch();

		// Nadji racun primatelja i valutu

		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE id=:id' );
			$st->execute( array( 'id' => $transakcija["racun_primatelj"] ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$racun_primatelj = $st->fetch();

		// Nadji tecaj preko skripte

		$valuta1 = $transakcija['valuta'];
		$valuta2 = $racun_primatelj['valuta_racuna'];

		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
		echo '<script src="' . __SITE_URL .'/js/approve_tecaj.js"></script>';
		echo '<script> getTecaj("'. $valuta1 . '", "' . $valuta2. '") </script>';

		$tecaj = $_COOKIE["tecaj"];

		// Nadji iznos

		$iznos = round(floatval($transakcija['iznos']) * floatval($tecaj), 2);
		// Update baze

		// Na transakciju stavi odobrena = 1
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_transakcija SET odobrena=1 WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		// Pronadi racun primatelja i dodaj mu iznos
		$novo_stanje = $iznos + $racun_primatelj['stanje_racuna'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_racun SET stanje_racuna=:stanje WHERE id=:id' );
			$st->execute( array( 'stanje' => $novo_stanje, 'id' => $transakcija['racun_primatelj']  ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		return "OK";
	}

	function acceptPeriodic($id) {
		// Na transakciju stavi odobrena = 1
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_periodicna_transakcija SET odobrena=1 WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		return "OK";
	}

	function rejectPeriodic($id) {
		// Na transakciju stavi odobrena = -1
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_periodicna_transakcija SET odobrena=-1 WHERE id=:id' );
			$st->execute( array( 'id' => $id ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		return "OK";
	}
}
?>
