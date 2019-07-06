<?php

function sendJSONandExit( $message )
{
    // Kao izlaz skripte poĹˇalji $message u JSON formatu i prekini izvoÄ‘enje.
    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );
}

session_start();

class DB
{
	private static $db = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection()
	{
		if( DB::$db === null )
	    {
	    	try
	    	{
		    	DB::$db = new PDO( "mysql:host=rp2.studenti.math.hr; dbname=gunja; charset=utf8", 'student', 'pass.mysql' );
		    	DB::$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
		    catch( PDOException $e ) { exit( 'PDO Error: ' . $e->getMessage() ); }
	    }
		return DB::$db;
	}
}


$od = $_GET[ 'od' ];
$do = $_GET[ 'do' ];
$vrsta = $_GET[ 'vrsta' ];

$user_oib = $_SESSION['oib'];
$arr = array();
if ($vrsta === "poslane") {
  // Transakcije poslane sa racuna korisnika
  try
  {
    $db = DB::getConnection();
    $st = $db->prepare( 'SELECT projekt_transakcija.id, opis, racun_posiljatelj, racun_primatelj, valuta, iznos, odobrena, datum
              FROM projekt_transakcija JOIN  projekt_racun
              ON projekt_transakcija.racun_posiljatelj=projekt_racun.id WHERE oib=:oib AND :od <= datum AND :do >= datum' );
    $st->execute( array( 'oib' => $user_oib, 'od' => $od, 'do' => $do) );
  }
  catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

  while( $row = $st->fetch() )
  {
    $arr[] = array($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
                    $row['racun_primatelj'],	$row['valuta'], $row['iznos'],
                    $row['odobrena'], $row['datum']);
  }

  // Transakcije poslane s racuna kojima je korisnik opunomocenik

  $arr2 = array();

  try
  {
    $db = DB::getConnection();
    $st = $db->prepare( 'SELECT * FROM projekt_punomoc WHERE oib_opunomocenika=:oib_opunomocenika AND odobren=:odobren' );
    $st->execute( array( 'oib_opunomocenika' => $user_oib , 'odobren' => 1) );
  }
  catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

  $arr2 = array();
  while( $row = $st->fetch() )
  {
    $arr2[] = $row['id_racuna'];
  }

  foreach ($arr2 as $id_posiljatelja) {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT * FROM projekt_transakcija  WHERE racun_posiljatelj=:id_posiljatelja AND :od <= datum AND :do >= datum' );
      $st->execute( array( 'id_posiljatelja' => $id_posiljatelja, 'od'=> $od, 'do' => $do) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    while( $row = $st->fetch() )
    {
      $arr[] = array($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
                      $row['racun_primatelj'],	$row['valuta'], $row['iznos'],
                      $row['odobrena'], $row['datum']);
    }

  }
}

else {

  try
  {
    $db = DB::getConnection();
    $st = $db->prepare( 'SELECT projekt_transakcija.id, opis, racun_posiljatelj, racun_primatelj, valuta, iznos, odobrena, datum
              FROM projekt_transakcija JOIN  projekt_racun
              ON projekt_transakcija.racun_primatelj=projekt_racun.id WHERE oib=:oib AND :od <= datum AND :do >= datum' );
    $st->execute( array( 'oib' => $user_oib, 'od'=> $od, 'do' => $do) );
  }
  catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

  while( $row = $st->fetch() )
  {
    $arr[] = array($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
                    $row['racun_primatelj'],	$row['valuta'], $row['iznos'],
                    $row['odobrena'], $row['datum']);
  }

  $arr2 = array();

  try
  {
    $db = DB::getConnection();
    $st = $db->prepare( 'SELECT * FROM projekt_punomoc WHERE oib_opunomocenika=:oib_opunomocenika AND odobren=:odobren' );
    $st->execute( array( 'oib_opunomocenika' => $user_oib , 'odobren' => 1) );
  }
  catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

  $arr2 = array();
  while( $row = $st->fetch() )
  {
    $arr2[] = $row['id_racuna'];
  }

  foreach ($arr2 as $id_posiljatelja) {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT * FROM projekt_transakcija  WHERE racun_primatelj=:id_posiljatelja AND :od <= datum AND :do >= datum' );
      $st->execute( array( 'id_posiljatelja' => $id_posiljatelja, 'od'=> $od, 'do' => $do) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    while( $row = $st->fetch() )
    {
      $arr[] = array($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
                      $row['racun_primatelj'],	$row['valuta'], $row['iznos'],
											$row['odobrena'], $row['datum']);
    }
  }
}
sendJSONandExit($arr);
?>
