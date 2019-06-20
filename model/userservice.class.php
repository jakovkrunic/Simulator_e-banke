<?php

class UserService
{

	function getUserByOIB( $oib )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_korisnik WHERE oib=:oib' );
			$st->execute( array( 'oib' => $oib) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['oib'], $row['ime'], $row['prezime'] , $row['email'],
											$row['password_hash'], $row['reg_seq'],	$row['odobren'], $row['registriran'] );
	}

	function getUserByEmail( $email )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM projekt_korisnik WHERE email=:email' );
			$st->execute( array( 'email' => $email) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return new User( $row['oib'], $row['ime'], $row['prezime'] , $row['email'],
											$row['password_hash'], $row['reg_seq'],	$row['odobren'], $row['registriran'] );
	}


};

?>
