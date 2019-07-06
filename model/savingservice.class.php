<?php
class SavingService{
  function getAllSavings( $user_oib )		 //pronadi sve odobrene racune korisnika ciji je oib $user_oib
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT * FROM projekt_stednja WHERE oib=:oib' );
      $st->execute( array( 'oib' => $user_oib) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Saving($row['id'], $row['oib'], $row['iznos_stednje'] ,
                      $row['kamatna_stopa'],	$row['valuta'], $row['datum_sljedece']);
    }

    return $arr;
  }
  function updateAmount($racun,$iznos)
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'UPDATE projekt_stednja SET  iznos_stednje=iznos_stednje+:iznos WHERE id=:id_racuna' );
      $st->execute( array( 'id_racuna' => $racun, ':iznos' => $iznos ) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
  }

  function getAccountById($id) {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT * FROM projekt_stednja WHERE id=:id' );
      $st->execute( array( 'id' => $id) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $row = $st->fetch();
    return new Saving($row['id'], $row['oib'], $row['iznos_stednje'] ,
                    $row['kamatna_stopa'],	$row['valuta'], $row['datum_sljedece']);
  }

}
 ?>
