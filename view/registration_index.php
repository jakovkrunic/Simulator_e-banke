<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="icon" href="https://d29fhpw069ctt2.cloudfront.net/icon/image/49289/preview.svg">
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<h1><?php echo $title; ?></h1>

    <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login'?>">
	<button class="button" type="submit">Povratak na login.</button>
	</form>
	
	<br> <br>
    <?php if($message!== 'Zahtjev je zaprimljen.') { ?>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/provjeri_registracija'?>">
   	    OIB:
  		<input type="text" name="oib" />
		<br /> <br />
		Ime:
  		<input type="text" name="name" />
		<br /> <br />
		Prezime:
  		<input type="text" name="surname" />
		<br />   <br />
  	    Lozinka:
  		<input type="password" name="password" />
  		<br />  <br />
        E-mail:
  		<input type="text" name="email" />
  		<br /> <br>
  		<button class="button" type="submit">Pošalji zahtjev!</button>
  	</form>
    <?php }
    echo '<br>' . $message . '<br>'; ?>

  <?php require_once __SITE_PATH . '/view/_footer.php'; ?>
