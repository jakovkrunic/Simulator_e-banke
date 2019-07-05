<?php

class Saving{
  protected $id, $oib, $iznos_stednje, $kamatna_stopa, $valuta;
	function __construct($id, $oib, $iznos_stednje, $kamatna_stopa, $valuta)
	{
		$this->oib = $oib;
		$this->id = $id;
		$this->iznos_stednje = $iznos_stednje;
		$this->kamatna_stopa = $kamatna_stopa;
		$this->valuta = $valuta;

	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
 ?>
