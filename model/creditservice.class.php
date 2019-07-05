<?php
class CreditService{
  function getAllCredits( $user_oib )		 //pronadi sve odobrene racune korisnika ciji je oib $user_oib
  {
    try
    {
      $db = DB::getConnection();
      $st = $db->prepare( 'SELECT * FROM projekt_kredit WHERE oib=:oib' );
      $st->execute( array( 'oib' => $user_oib) );
    }
    catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    $arr = array();
    while( $row = $st->fetch() )
    {
      $arr[] = new Credit($row['id'], $row['oib'], $row['iznos_kredita'] ,
                      $row['kamatna_stopa'], $row['rata_placanja'],	$row['valuta']);
    }

    return $arr;
  }

}
 ?>
