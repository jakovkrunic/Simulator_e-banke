<?php

class Predlozak
{
	protected $id, $ime, $racun_posiljatelj, $racun_primatelj, $valuta;
	function __construct($id, $ime, $racun_posiljatelj, $racun_primatelj, $valuta)
	{
		$this->id = $id;
		$this->ime = $ime;
		$this->racun_posiljatelj = $racun_posiljatelj;
		$this->racun_primatelj = $racun_primatelj;
		$this->valuta = $valuta;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
