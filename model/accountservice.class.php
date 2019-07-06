<?php

class AccountService
{

	function getAccountById( $id )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new Account($row['id'], $row['oib'], $row['tip_racuna'] ,
											$row['valuta_racuna'], $row['stanje_racuna'],	$row['datum_izrade'], $row['odobren'], $row['dozvoljeni_minus']);
	}

	function getAllUserAccounts( $user_oib )		 //pronadi sve odobrene racune korisnika ciji je oib $user_oib
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE oib=:oib AND odobren=:odobren' );
			$st->execute( array( 'oib' => $user_oib , 'odobren' => 1) );
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

	function openAccount( $user_oib, $vrsta_racuna, $valuta_racuna, $pocetni_iznos, $zeljeni_minus ){

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare(
			'INSERT INTO projekt_racun (oib,tip_racuna,valuta_racuna,stanje_racuna,dozvoljeni_minus, datum_izrade, odobren)
			VALUES (:user_oib, :vrsta_racuna, :valuta_racuna, :pocetni, :zeljeni_minus, :datum, 0);');
			$st->execute( array( 'user_oib' => $user_oib, 'vrsta_racuna' => $vrsta_racuna, 'valuta_racuna' => $valuta_racuna, 'pocetni' => $pocetni_iznos, 'zeljeni_minus' => $zeljeni_minus , 'datum' => date('Y-m-d')) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}

	function getAllAccountAssigneesOIB($id_racuna) 			//vrati niz OIB-a ljudi koji imaju punomoc nad racunom ciji je id $id_racuna
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_punomoc WHERE id_racuna=:id_racuna AND odobren=:odobren' );
			$st->execute( array( 'id_racuna' => $id_racuna , 'odobren' => 1) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = $row['oib_opunomocenika'];
		}

		return $arr;

	}

	function getAllAssigneeAccountsFromOIB($oib_opunomocenika) 	//vrati sve racune nad kojim ima punomoc osoba sa zadanim oibom
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_punomoc WHERE oib_opunomocenika=:oib_opunomocenika AND odobren=:odobren' );
			$st->execute( array( 'oib_opunomocenika' => $oib_opunomocenika , 'odobren' => 1) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = $row['id_racuna'];
		}

		return $arr;

	}

	function insertNewAssignee($id_racuna, $oib_opunomocenika) 			//unesi novu punomoc
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_punomoc(id_racuna, oib_opunomocenika, odobren) VALUES (:id_racuna,
													:oib_opunomocenika, :odobren)' );
			$st->execute( array( 'id_racuna' => $id_racuna, 'oib_opunomocenika' => $oib_opunomocenika, 'odobren' => 0 ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}

	function updateAmount($id_racuna,$iznos){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'UPDATE projekt_racun SET  stanje_racuna=stanje_racuna-:iznos WHERE id=:id_racuna' );
			$st->execute( array( 'id_racuna' => $id_racuna, ':iznos' => $iznos ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

};

?>
