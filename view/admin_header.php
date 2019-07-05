<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank - admin</title>
	<link rel="icon" href="https://d29fhpw069ctt2.cloudfront.net/icon/image/49289/preview.svg">
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


	<nav>
		<ul>
			<li class="adminovo"><a href="index.php?rt=admin">Naslovnica</a></li>
            <li class="adminovo"><a href="index.php?rt=admin/unapprovedUsers">Odobri zahtjeve za nove korisnike</a></li>
			<li class="adminovo"><a href="index.php?rt=admin/unapprovedAcc">Odobri zahtjeve za nove račune</a></li>
			<li class="adminovo"><a href="index.php?rt=admin/unapprovedOpunomocenje">Odobri zahtjeve opunomoćenje</a></li>
			<li class="adminovo"><a href="index.php?rt=admin/transactions">Odobri transakcije</a></li>
			<li class="adminovo"><a href="index.php?rt=admin/openSavingForm">Otvori novu štednju korisniku</a></li>
			<li class="adminovo"><a href="index.php?rt=admin/openCreditForm">Otvori novi kredit korisniku</a></li>
		</ul>
	</nav>
	
	<div class = "user">
	Korisnik:  <?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']; ?>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/logout'?>">
	<button class="button" type="submit">Odjavi se</button>
	</form>
	</div>
	 
	 <br>
