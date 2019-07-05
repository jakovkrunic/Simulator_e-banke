<?php

class Punomoc
{
	protected $id, $id_racuna, $oib_vlasnika, $ime_vlasnika,$prezime_vlasnika, $oib_opunomocenika, $ime_opunomocenika, $prezime_opunomocenika, $odobren;
	function __construct($id, $id_racuna, $oib_vlasnika, $ime_vlasnika, $prezime_vlasnika, $oib_opunomocenika, $ime_opunomocenika, $prezime_opunomocenika, $odobren )
	{
        $this->id = $id;
        $this->id_racuna = $id_racuna;
		$this->oib_vlasnika = $oib_vlasnika;
		$this->ime_vlasnika = $ime_vlasnika;
		$this->prezime_vlasnika = $prezime_vlasnika;
        $this->oib_opunomocenika = $oib_opunomocenika;
        $this->ime_opunomocenika = $ime_opunomocenika;
        $this->prezime_opunomocenika = $prezime_opunomocenika;
        $this->odobren = $odobren;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
