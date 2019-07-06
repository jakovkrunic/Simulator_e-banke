<?php

class PeriodicTransaction
{
	protected $id, $opis, $racun_posiljatelj, $racun_primatelj, $valuta, $iznos, $period, $odobrena, $datum_sljedece;
	function __construct($id, $opis, $racun_posiljatelj, $racun_primatelj, $valuta, $iznos, $period, $odobrena, $datum_sljedece)
	{
		$this->id = $id;
		$this->opis = $opis;
		$this->racun_posiljatelj = $racun_posiljatelj;
		$this->racun_primatelj = $racun_primatelj;
		$this->valuta = $valuta;
    $this->iznos = $iznos;
    $this->period = $period;
    $this->odobrena = $odobrena;
    $this->datum_sljedece = $datum_sljedece;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
