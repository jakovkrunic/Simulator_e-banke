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

	function getAllTransactions($user_oib){
		// ne moze oib, ili ce se morat joinat ili ce se morat spremit u sešn idevi racuna
		// ili pozvat daj mi sve ideve i onda vrtit po tome
		try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT projekt_transakcija.id, opis, racun_posiljatelj, racun_primatelj, valuta, iznos, odobrena, datum
				 				FROM projekt_transakcija JOIN  projekt_racun
								ON projekt_transakcija.racun_posiljatelj=projekt_racun.id WHERE oib=:oib' );
      $st->execute( array( 'oib' => $user_oib) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Transaction($row['id'], $row['opis'], $row['racun_posiljatelj'] ,
                      $row['racun_primatelj'],	$row['valuta'], $row['iznos'],
											$row['odobrena'], $row['datum']);
    }

    return $arr;
	}

	function removependingTransaction($id_trans){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM projekt_transakcija WHERE id=:id' );
			$st->execute( array( 'id' => $id_trans) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

};

?>
