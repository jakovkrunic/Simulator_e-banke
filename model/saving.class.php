<?php

class Saving{
  protected $id, $oib, $iznos_stednje, $kamatna_stopa, $valuta, $datum_sljedece;
	function __construct($id, $oib, $iznos_stednje, $kamatna_stopa, $valuta, $datum_sljedece)
	{
		$this->oib = $oib;
		$this->id = $id;
		$this->iznos_stednje = $iznos_stednje;
		$this->kamatna_stopa = $kamatna_stopa;
		$this->valuta = $valuta;
    $this->datum_sljedece = $datum_sljedece;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
 ?>
