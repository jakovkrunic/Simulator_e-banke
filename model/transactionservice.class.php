<?php

class TransactionService
{

	function insertNewTransaction($opis, $racun_posiljatelj, $racun_primatelj, $valuta, $iznos) 		//stvori novu transakciju, odobrena=0, datum je danasnji
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_transakcija(opis, racun_posiljatelj, racun_primatelj, valuta, iznos, odobrena, datum) VALUES (:opis,
													:racun_posiljatelj, :racun_primatelj, :valuta, :iznos, :odobrena, :datum)' );
			$st->execute( array( 'opis' => $opis, 'racun_posiljatelj' => $racun_posiljatelj, 'racun_primatelj' => $racun_primatelj,
		 												'valuta' => $valuta, 'iznos' => $iznos, 'odobrena' => 0, 'datum' => date('Y-m-d') ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}




};

?>
