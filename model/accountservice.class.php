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
											$row['valuta_racuna'], $row['stanje_racuna'],	$row['datum_izrade']);
	}

	function getAllUserAccounts( $user_oib )		 //pronadi sve racune korisnika ciji je oib $user_oib
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE oib=:oib' );
			$st->execute( array( 'oib' => $user_oib) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Account($row['id'], $row['oib'], $row['tip_racuna'] ,
											$row['valuta_racuna'], $row['stanje_racuna'],	$row['datum_izrade']);
		}

		return $arr;
	}



};

?>
