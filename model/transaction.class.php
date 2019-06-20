<?php

class Transaction
{
	protected $id, $opis, $racun_posiljatelj, $racun_primatelj, $valuta, $iznos, $datum;
	function __construct($id, $opis, $racun_posiljatelj, $racun_primatelj, $valuta, $iznos, $datum)
	{
		$this->opis = $opis;
		$this->id = $id;
		$this->racun_posiljatelj = $racun_posiljatelj;
		$this->racun_primatelj = $racun_primatelj;
		$this->valuta = $valuta;
		$this->iznos = $iznos;
		$this->datum = $datum;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
