<?php

class Account
{
	protected $id, $oib, $tip_racuna, $valuta_racuna, $stanje_racuna, $datum_izrade;
	function __construct($id, $oib, $tip_racuna, $valuta_racuna, $stanje_racuna, $datum_izrade)
	{
		$this->oib = $oib;
		$this->id = $id;
		$this->tip_racuna = $tip_racuna;
		$this->valuta_racuna = $valuta_racuna;
		$this->stanje_racuna = $stanje_racuna;
		$this->datum_izrade = $datum_izrade;

	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
