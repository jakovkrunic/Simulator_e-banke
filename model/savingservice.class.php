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
                      $row['kamatna_stopa'],	$row['valuta']);
    }

    return $arr;
  }

}
 ?>
