<?php

class PeriodicService {
  function __construct() {
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
    echo '<script src="' . __SITE_URL .'/js/approve_tecaj.js"></script>';
  }

  function resolvePeriodicTransactions() {
    $date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];

    $str_date = strval($year);

    $str_date = $str_date . '-';

    if ($month >= 10) $str_date = $str_date . strval($month);
    else $str_date = $str_date . '0' . strval($month);

    $str_date = $str_date . '-';

    if ($day >= 10) $str_date = $str_date + strval($day);
    else $str_date = $str_date . '0' . strval($day);

    try
		{
			$db = DB::getConnection();
			$_st = $db->prepare( 'SELECT * FROM projekt_periodicna_transakcija WHERE odobrena = "1" AND datum_sljedece <= :datum' );
			$_st->execute( array( 'datum' => $str_date) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    while ($transakcija = $_st->fetch()) {

      // Nadji racun posiljatelja i provjeri stanje

      try {
  			$db = DB::getConnection();
  			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE id=:id' );
  			$st->execute( array( 'id' => $transakcija["racun_posiljatelj"] ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

  		$racun_posiljatelj = $st->fetch();

      if ($racun_posiljatelj['stanje_racuna'] - $racun_posiljatelj['dozvoljeni_minus'] < $transakcija['iznos'])
        continue;

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
  		echo '<script> getTecaj("'. $valuta1 . '", "' . $valuta2. '") </script>';

  		$tecaj = $_COOKIE["tecaj"];

  		// Nadji iznos

  		$iznos = round(floatval($transakcija['iznos']) * floatval($tecaj), 2);

      $novo_stanje = $iznos + $racun_primatelj['stanje_racuna'];
  		try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_racun SET stanje_racuna=:stanje WHERE id=:id' );
  			$st2->execute( array( 'stanje' => $novo_stanje, 'id' => $transakcija['racun_primatelj']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

      // Oduzmi od posiljatelja

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_racun SET stanje_racuna=:stanje WHERE id=:id' );
  			$st2->execute( array( 'stanje' => $racun_posiljatelj['stanje_racuna'] - $transakcija['iznos'], 'id' => $transakcija['racun_posiljatelj']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

      // Konacno, postavi datum iduce transakcije

      $day2 = $day;
      $month2 = $month + intval($transakcija['period']);
      echo $month2 . '<br>';
      echo $transakcija['period'] . '<br>';
      echo $month . '<br>';
      $year2 = $year;

      while ($month2 > 12) {
        $year2++;
        $month2 -= 12;
      }

      $str_date2 = strval($year2);

      $str_date2 = $str_date2 . '-';

      if ($month2 >= 10) $str_date2 = $str_date2 . strval($month2);
      else $str_date2 = $str_date2 . '0' . strval($month2);

      $str_date2 = $str_date2 . '-';

      if ($day2 >= 10) $str_date2 = $str_date2 . strval($day2);
      else $str_date2 = $str_date2 . '0' . strval($day2);

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_periodicna_transakcija SET datum_sljedece=:datum WHERE id=:id' );
  			$st2->execute( array( 'datum' => $str_date2, 'id' => $transakcija['id']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

    }
  }

  function resolveCredits() {
    $date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];

    $str_date = strval($year);

    $str_date = $str_date . '-';

    if ($month >= 10) $str_date = $str_date . strval($month);
    else $str_date = $str_date . '0' . strval($month);

    $str_date = $str_date . '-';

    if ($day >= 10) $str_date = $str_date + strval($day);
    else $str_date = $str_date . '0' . strval($day);

    try
		{
			$db = DB::getConnection();
			$_st = $db->prepare( 'SELECT * FROM projekt_kredit WHERE datum_sljedece <= :datum' );
			$_st->execute( array( 'datum' => $str_date) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    while ($credit = $_st->fetch()) {
      // Nadji racun posiljatelja i provjeri stanje

      try {
  			$db = DB::getConnection();
  			$st = $db->prepare( 'SELECT * FROM projekt_racun WHERE id=:id' );
  			$st->execute( array( 'id' => $credit["id_racuna"] ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

  		$racun_posiljatelj = $st->fetch();

      if ($racun_posiljatelj['stanje_racuna'] - $racun_posiljatelj['dozvoljeni_minus'] < $credit['rata_placanja']) {
        // Salji mail
        try {
    			$db = DB::getConnection();
    			$st = $db->prepare( 'SELECT * FROM projekt_korisnik WHERE oib=:oib' );
    			$st->execute( array( 'oib' => $racun_posiljatelj["oib"] ) );
    		}
    		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

        $user = $st->fetch();
        $msg = 'Nemate dovoljno sredstava na racunu da Vam se naplati kredit!' .
        "\n" . 'Molimo, osigurajte potrebna sredstva sto prije!';
        mail($user['email'], 'Neuspjelo naplacivanje kredita', $msg);
        continue;
      }

  		// Nadji tecaj preko skripte

  		$valuta2 = $racun_posiljatelj['valuta_racuna'];
  		$valuta1 = $credit['valuta'];
  		echo '<script> getTecaj("'. $valuta1 . '", "' . $valuta2. '") </script>';

  		$tecaj = $_COOKIE["tecaj"];

  		// Nadji iznos

  		$iznos = round(floatval($credit['rata_placanja']) * floatval($tecaj), 2);

      // Oduzmi od posiljatelja

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_racun SET stanje_racuna=:stanje WHERE id=:id' );
  			$st2->execute( array( 'stanje' => $racun_posiljatelj['stanje_racuna'] - $iznos, 'id' => $credit['id_racuna']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

      // Postavi datum iduce naplate

      $datum = $credit['datum_sljedece'];
      $arr_datum = explode('-', $datum);
      $day2 = $arr_datum[2];
      $month2 = $arr_datum[1] + 1;
      $year2 = $arr_datum[0];

      while ($month2 > 12) {
        $year2++;
        $month2 -= 12;
      }

      $str_date2 = strval($year2);

      $str_date2 = $str_date2 . '-';

      if ($month2 >= 10) $str_date2 = $str_date2 . strval($month2);
      else $str_date2 = $str_date2 . '0' . strval($month2);

      $str_date2 = $str_date2 . '-';

      if ($day2 >= 10) $str_date2 = $str_date2 . strval($day2);
      else $str_date2 = $str_date2 . '0' . strval($day2);

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_kredit SET datum_sljedece=:datum WHERE id=:id' );
  			$st2->execute( array( 'datum' => $str_date2, 'id' => $credit['id']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

      // Umanji iznos_kredita

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_kredit SET iznos_kredita=:iznos WHERE id=:id' );
  			$st2->execute( array( 'iznos' => $credit['iznos_kredita'] - $credit['rata_placanja'], 'id' => $credit['id']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

    }

    // Makni kredite koji su otplaceni
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'DELETE FROM projekt_kredit WHERE iznos_kredita <= 0' );
      $st->execute();
    }
    catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
  }

  function resolveSavings() {
    $date = getdate();
    $day = $date['mday'];
    $month = $date['mon'];
    $year = $date['year'];

    $str_date = strval($year);

    $str_date = $str_date . '-';

    if ($month >= 10) $str_date = $str_date . strval($month);
    else $str_date = $str_date . '0' . strval($month);

    $str_date = $str_date . '-';

    if ($day >= 10) $str_date = $str_date + strval($day);
    else $str_date = $str_date . '0' . strval($day);

    try
		{
			$db = DB::getConnection();
			$_st = $db->prepare( 'SELECT * FROM projekt_stednja WHERE datum_sljedece <= :datum' );
			$_st->execute( array( 'datum' => $str_date) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    while ($saving = $_st->fetch()) {
      // Postavi datum iduce kamate

      $datum = $saving['datum_sljedece'];
      $arr_datum = explode('-', $datum);
      $day2 = $arr_datum[2];
      $month2 = $arr_datum[1] + 1;
      $year2 = $arr_datum[0];

      while ($month2 > 12) {
        $year2++;
        $month2 -= 12;
      }

      $str_date2 = strval($year2);

      $str_date2 = $str_date2 . '-';

      if ($month2 >= 10) $str_date2 = $str_date2 . strval($month2);
      else $str_date2 = $str_date2 . '0' . strval($month2);

      $str_date2 = $str_date2 . '-';

      if ($day2 >= 10) $str_date2 = $str_date2 . strval($day2);
      else $str_date2 = $str_date2 . '0' . strval($day2);

      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_stednja SET datum_sljedece=:datum WHERE id=:id' );
  			$st2->execute( array( 'datum' => $str_date2, 'id' => $saving['id']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

      // Dodaj kamatu
      try
  		{
  			$db = DB::getConnection();
  			$st2 = $db->prepare( 'UPDATE projekt_stednja SET iznos_stednje=:iznos WHERE id=:id' );
  			$st2->execute( array( 'iznos' => (1 + $saving['kamatna_stopa']) * $saving['iznos_stednje'], 'id' => $saving['id']  ) );
  		}
  		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
    }
  }
};

?>
