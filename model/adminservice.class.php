<?php

class AdminService
{
	function getUnapprovedUsers(){ 
        
        $db = DB::getConnection();
        $st = $db->prepare( 'SELECT oib, ime, email, prezime, odobren, registriran FROM projekt_korisnik WHERE odobren = 0' );
        $st->execute();
        $zahtjevi = array();
        while($row = $st->fetch()){
            $zahtjevi[] = $row;
        }  
        
        return $zahtjevi;
    }
}
?>