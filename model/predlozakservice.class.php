<?php

class PredlozakService
{

	function getTemplatesByOwnerAccountId( $racun_posiljatelj )      // dohvati predloske ako znas id racuna posiljatelja
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_predlozak WHERE racun_posiljatelj=:racun_posiljatelj' );
			$st->execute( array( 'racun_posiljatelj' => $racun_posiljatelj) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Predlozak($row['id'], $row['ime'], $row['racun_posiljatelj'] ,$row['racun_primatelj'], $row['valuta']);
		}
		return $arr;
	}

	function insertNewTemplate($ime, $racun_posiljatelj, $racun_primatelj, $valuta) 		//stvori novi predlozak
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_predlozak(ime, racun_posiljatelj, racun_primatelj, valuta) VALUES (:ime,
													:racun_posiljatelj, :racun_primatelj, :valuta)' );
			$st->execute( array( 'ime' => $ime, 'racun_posiljatelj' => $racun_posiljatelj,
		 												'racun_primatelj' => $racun_primatelj, 'valuta' => $valuta) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}

	function changeTemplate($id, $ime, $racun_posiljatelj, $racun_primatelj, $valuta) 		//izmijeni predlozak s zadanim id-em i novim vrijednostima
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( "UPDATE projekt_predlozak SET ime=:ime, racun_posiljatelj=:racun_posiljatelj,
														racun_primatelj=:racun_primatelj, valuta=:valuta	WHERE id=:id");
			$st->execute( array( 'id' => $id, 'ime' => $ime, 'racun_posiljatelj' => $racun_posiljatelj,
										 		 		'racun_primatelj' => $racun_primatelj, 'valuta' => $valuta) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}

	function deleteTemplate( $id )      // izbrisi predlozak s zadanim id-em
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM projekt_predlozak WHERE id=:id' );
			$st->execute( array( 'id' => $id) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

	}



};

?>
