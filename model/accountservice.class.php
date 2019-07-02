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

	function openAccount( $user_oib, $vrsta_racuna, $valuta_racuna, $zeljeni_minus ){

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare(
			'INSERT INTO projekt_racun (oib,tip_racuna,valuta_racuna,stanje_racuna,dozvoljeni_minus, datum_izrade, odobren)
			VALUES (:user_oib, :vrsta_racuna, :valuta_racuna, 0, :zeljeni_minus, :datum, 0);');
			$st->execute( array( 'user_oib' => $user_oib, 'vrsta_racuna' => $vrsta_racuna, 'valuta_racuna' => $valuta_racuna, 'zeljeni_minus' => $zeljeni_minus , 'datum' => date('Y-m-d')) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}



};

?>
