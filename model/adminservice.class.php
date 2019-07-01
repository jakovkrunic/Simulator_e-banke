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
}
?>
