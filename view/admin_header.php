<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


	<nav>
		<ul>
			<li><a href="index.php?rt=admin">Naslovnica</a></li>
            <li><a href="index.php?rt=admin/unapprovedUsers">Odobri zahtjeve za nove korisnike</a></li>
			<li><a href="index.php?rt=admin/unapprovedAcc">Odobri račune</a></li>
			<li><a href="index.php?rt=predlozak">Odobri štednje - nema još</a></li>
			<li><a href="index.php?rt=saving">Odobri kredite - nema još</a></li>
			<li><a href="index.php?rt=credit">Ako će trebati još nešto - nema još</a></li>
		</ul>
	</nav>
	<hr>
	<div class = "user">
	Korisnik:  <?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']; ?>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=login/logout'?>">
	<button class="button" type="submit">Odjavi se</button>
	</form>
	</div>
	 <hr>
	 <br>
