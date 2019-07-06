<?php

class Credit{
  protected $id, $oib, $iznos_kredita, $kamatna_stopa, $rata_placanja, $valuta, $datum_sljedece;
	function __construct($id, $oib, $iznos_kredita, $kamatna_stopa, $rata_placanja, $valuta, $datum_sljedece)
	{
		$this->oib = $oib;
		$this->id = $id;
		$this->iznos_kredita = $iznos_kredita;
		$this->valuta = $valuta;
		$this->kamatna_stopa = $kamatna_stopa;
		$this->rata_placanja = $rata_placanja;
		$this->valuta = $valuta;
    $this->datum_sljedece = $datum_sljedece;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
 ?>
