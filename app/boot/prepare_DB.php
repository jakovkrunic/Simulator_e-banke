<?php

// Manualno inicijaliziramo bazu ako vec nije.
require_once '../../model/db.class.php';

$db = DB::getConnection();

$has_tables = false;

try
{
	$st = $db->prepare(
		'SHOW TABLES LIKE :tblname'
	);

	$st->execute( array( 'tblname' => 'projekt_korisnik' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_racun' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_transakcija' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_predlozak' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_punomoc' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_periodicna_transakcija' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_stednja' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'projekt_kredit' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_tables )
{
	exit( 'Tablice vec postoje. Obrisite ih pa probajte ponovno.' );
}

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_korisnik (' .
		'oib varchar(11) NOT NULL PRIMARY KEY,' .
		'ime varchar(50) NOT NULL,' .
		'prezime varchar(50) NOT NULL,' .
		'email varchar(50) NOT NULL,' .
		'password_hash varchar(255) NOT NULL,'.
		'registriran int)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create projekt_korisnik]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_korisnik.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_racun (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'oib varchar(11) NOT NULL,' .
		'tip_racuna varchar(100) NOT NULL,' .
		'valuta_racuna varchar(3) NOT NULL,' .
		'stanje_racuna decimal(10,2) NOT NULL,' .
		'datum_izrade date NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_racun]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_racun.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_transakcija (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'opis varchar(100) NOT NULL,' .
		'racun_posiljatelj int NOT NULL,' .
		'racun_primatelj int NOT NULL,' .
		'valuta varchar(3) NOT NULL,' .
		'iznos decimal(10,2) NOT NULL,' .
		'datum date NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_transakcija]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_transakcija.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_predlozak (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'ime varchar(50) NOT NULL,' .
		'racun_posiljatelj int NOT NULL,' .
		'racun_primatelj int NOT NULL,' .
		'valuta varchar(3) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_predlozak]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_predlozak.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_punomoc (' .
		'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'id_racuna int NOT NULL,' .
		'oib_opunomocenika varchar(11) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_punomoc]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_punomoc.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_periodicna_transakcija (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'opis varchar(100) NOT NULL,' .
			'racun_posiljatelj int NOT NULL,' .
			'racun_primatelj int NOT NULL,' .
			'valuta varchar(3) NOT NULL,' .
			'iznos decimal(10,2) NOT NULL,' .
			'period int NOT NULL,' .
			'datum_sljedece date NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_periodicna_transakcija]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_periodicna_transakcija.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_stednja (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'oib varchar(11) NOT NULL,' .
			'iznos_stednje decimal(10,2) NOT NULL,' .
			'kamatna_stopa decimal(10,2) NOT NULL,' .
			'valuta varchar(3) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_stednja]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_stednja.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS projekt_kredit (' .
			'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
			'oib varchar(11) NOT NULL,' .
			'iznos_kredita decimal(10,2) NOT NULL,' .
			'kamatna_stopa decimal(10,2) NOT NULL,' .
			'rata_placanja decimal(10,2) NOT NULL,' .
			'valuta varchar(3) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [projekt_kredit]: " . $e->getMessage() ); }

echo "Napravio tablicu projekt_kredit.<br />";


// Ubaci neke korisnike unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_korisnik(oib, ime, prezime, email, password_hash , registriran) VALUES (:oib, :ime, :prezime, :email, :password, \'1\')' );

	$st->execute( array( 'oib' => '00000000000', 'ime' => 'admin', 'prezime' => 'admin', 'email' => 'admin@admin.com', 'password' => password_hash( 'admin', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => '11111111111', 'ime' => 'mirko', 'prezime' => 'miric', 'email' => 'mirko@miric.com', 'password' => password_hash( 'mirkovasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => '22222222222', 'ime' => 'ana', 'prezime' => 'anic', 'email' => 'ana@anic.com', 'password' => password_hash( 'aninasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => '33333333333', 'ime' => 'maja', 'prezime' => 'majic', 'email' => 'maja@majic.com', 'password' => password_hash( 'majinasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => '44444444444', 'ime' => 'slavko', 'prezime' => 'slavic', 'email' => 'slavko@slavic.com', 'password' => password_hash( 'slavkovasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => '55555555555', 'ime' => 'pero', 'prezime' => 'peric', 'email' => 'pero@peric.com', 'password' => password_hash( 'perinasifra', PASSWORD_DEFAULT ) ) );
}
catch( PDOException $e ) { exit( "PDO error [insert projekt_korisnik]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_korisnik.<br />";


// Ubaci neke racune unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_racun(oib, tip_racuna, valuta_racuna, stanje_racuna, datum_izrade) VALUES (:oib, :t, :v, :s, :d)' );

	$st->execute( array( 'oib' => '11111111111', 't' => 'tekuci', 'v' => 'HRK', 's' => 1000, 'd' => '2019-05-01'  ) ); // mirko
	$st->execute( array( 'oib' => '22222222222', 't' => 'tekuci', 'v' => 'HRK', 's' => 100000, 'd' => '2019-04-04'  ) ); // ana
	$st->execute( array( 'oib' => '33333333333', 't' => 'devizni', 'v' => 'HRK', 's' => 5000, 'd' => '2019-05-05'  ) ); // maja
	$st->execute( array( 'oib' => '44444444444', 't' => 'tekuci', 'v' => 'HRK', 's' => 400, 'd' => '2019-04-10'  ) ); // slavko
	$st->execute( array( 'oib' => '55555555555', 't' => 'ziro', 'v' => 'HRK', 's' => 30000, 'd' => '2019-05-14'  ) ); // pero
}
catch( PDOException $e ) { exit( "PDO error [projekt_racun]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_racun.<br />";

// Ubaci neke transakcije unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_transakcija(opis, racun_posiljatelj, racun_primatelj, valuta, iznos, datum) VALUES (:opis, :pos, :pri, :v, :i, :d)' );

	$st->execute( array( 'opis' => 'Poklon za rodendan.', 'pos' => 1, 'pri' => 2, 'v' => 'HRK', 'i' => 500, 'd' => '2019-05-20'  ) ); // mirko poslao ani
	$st->execute( array( 'opis' => 'Za proslavu.', 'pos' => 2, 'pri' => 4, 'v' => 'HRK', 'i' => 200, 'd' => '2019-05-19'  ) ); // ana poslala slavku
}
catch( PDOException $e ) { exit( "PDO error [projekt_transakcija]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_transakcija.<br />";

// Ubaci neke predloske unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_predlozak(ime, racun_posiljatelj, racun_primatelj, valuta) VALUES (:ime, :pos, :pri, :v)' );

	$st->execute( array( 'ime' => 'Komunalije', 'pos' => 1, 'pri' => 5, 'v' => 'HRK' ) ); // mirkov predlozak
}
catch( PDOException $e ) { exit( "PDO error [projekt_predlozak]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_predlozak.<br />";

// Ubaci neke punomoci unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_punomoc(id_racuna, oib_opunomocenika) VALUES (:id, :oib)' );

	$st->execute( array( 'id' => '1', 'oib' => '33333333333' ) ); // mirko dao punomoc maji za svoj tekuci
}
catch( PDOException $e ) { exit( "PDO error [projekt_punomoc]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_punomoc.<br />";

// Ubaci neke periodicne transakcije unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_periodicna_transakcija(opis, racun_posiljatelj, racun_primatelj, valuta, iznos, period, datum_sljedece) VALUES (:opis, :pos, :pri, :v, :i, :p, :d)' );

	$st->execute( array( 'opis' => 'Stanarina.', 'pos' => 2, 'pri' => 5, 'v' => 'HRK', 'i' => 2000, 'p' => 1, 'd' => '2019-06-01'  ) ); // ana placa stanarinu
}
catch( PDOException $e ) { exit( "PDO error [projekt_periodicna_transakcija]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_periodicna_transakcija.<br />";

// Ubaci neke stednje unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_stednja(oib, iznos_stednje, kamatna_stopa, valuta) VALUES (:oib, :i, :k, :v)' );

	$st->execute( array( 'oib' => '33333333333', 'i' => 50000, 'k' => 0.1, 'v' => 'HRK' ) ); // majina stednja
}
catch( PDOException $e ) { exit( "PDO error [projekt_stednja]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_stednja.<br />";

// Ubaci neke kredite unutra
try
{
	$st = $db->prepare( 'INSERT INTO projekt_kredit(oib, iznos_kredita, kamatna_stopa, rata_placanja, valuta) VALUES (:oib, :i, :k, :r, :v)' );

	$st->execute( array( 'oib' => '55555555555', 'i' => 1000000, 'k' => 0.5, 'r' => 2000, 'v' => 'HRK' ) ); // perin kredit
}
catch( PDOException $e ) { exit( "PDO error [projekt_kredit]: " . $e->getMessage() ); }

echo "Ubacio u tablicu projekt_kredit.<br />";

?>
