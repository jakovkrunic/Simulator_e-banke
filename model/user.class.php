<?php

class User
{
	protected $oib, $ime, $prezime, $email, $password_hash, $reg_seq, $odobren, $registriran;
	function __construct($oib, $ime, $prezime, $email, $password_hash, $reg_seq, $odobren, $registriran)
	{
		$this->oib = $oib;
		$this->ime = $ime;
		$this->prezime = $prezime;
		$this->password_hash = $password_hash;
		$this->email = $email;
		$this->reg_seq = $reg_seq;
		$this->odobren = $odobren;
		$this->registriran = $registriran;
	}

  function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
