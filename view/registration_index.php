<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>MoržBank</title>
	<link rel="icon" href="https://d29fhpw069ctt2.cloudfront.net/icon/image/49289/preview.svg">
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="./js/registracija.js"></script>
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
			<div style=" height:240px; width:240px; border:1px solid #ccc;
			font:16px/26px Georgia, Garamond, Serif; overflow:auto;">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			Curabitur fermentum turpis tortor, eu rutrum odio commodo sit amet. Maecenas hendrerit id magna et consequat.
			Proin iaculis massa id sagittis elementum. Aliquam tincidunt mauris nisi, a elementum massa convallis et.
			Duis vulputate, metus eget feugiat maximus, orci diam placerat libero, non fringilla neque elit id libero.
			Mauris quis tristique lacus. Proin accumsan laoreet arcu, eu vulputate tortor sollicitudin a.
			Curabitur ultricies sit amet urna eget mollis.
			Morbi semper pulvinar turpis, et dapibus ante viverra aliquet.
			Nulla porttitor, justo et venenatis malesuada, risus urna maximus orci, ac maximus lectus elit ut erat.
			enean tempor nulla orci, et rhoncus leo fringilla sit amet.
			Aliquam tellus massa, facilisis ut venenatis ac, dictum vel nunc.
			Integer nec nisl dictum, feugiat velit ac, accumsan diam.

			Etiam vitae neque ac dui sagittis ultricies. Morbi laoreet lacus sit amet purus lobortis congue.
			Fusce laoreet varius metus eget euismod. Nunc quis ipsum felis. Duis quis mattis nunc.
			Nullam in ex at urna ultrices faucibus at id leo. Donec venenatis pulvinar lacus, eu rutrum velit pharetra sed.
			Quisque quis augue semper, efficitur sapien nec, pulvinar odio.
			Curabitur non augue consectetur, venenatis justo quis, dignissim dui.
			Sed non metus lobortis velit condimentum vehicula at ac nisl.
			Sed ac leo in nunc suscipit scelerisque nec aliquet urna.

			Fusce facilisis aliquam arcu, sit amet tincidunt mauris accumsan non.
			Pellentesque aliquam nulla ex, at tincidunt mi auctor et. Suspendisse potenti.
			Etiam ac scelerisque urna, sagittis hendrerit mi.
			Donec molestie sagittis metus, ut feugiat felis viverra sit amet.
			Suspendisse quis justo ut magna ullamcorper semper.
			Etiam accumsan lobortis dolor, vitae efficitur velit semper eu.
			Fusce dapibus augue quis dolor commodo, sed viverra lectus lacinia.
			Ut aliquam lectus at orci hendrerit consectetur.
			Duis venenatis dignissim ex, nec volutpat dolor aliquam vitae.
			In volutpat hendrerit nulla eget bibendum. Curabitur cursus nulla sed vehicula gravida.

			Quisque sagittis pellentesque ligula, a auctor lacus maximus et. Vestibulum porta ut velit eu ultrices.
			Cras ac ultricies ante. Ut quis purus diam.
			Donec tempor justo eu erat sollicitudin viverra.
			Praesent porta tincidunt facilisis.
			Ut congue ex dui, non elementum ipsum rutrum sit amet.
			Suspendisse vulputate dolor et metus fermentum scelerisque.
			Maecenas vel porttitor lorem, et imperdiet metus.
			Proin accumsan tortor quis justo ultrices, et feugiat tortor aliquet.
			Phasellus pharetra vehicula ligula ut mollis.
			Vestibulum vel placerat tortor, eget viverra ligula.
			Vestibulum efficitur metus ac dui consectetur, vitae molestie massa luctus.

			In ante felis, vehicula in cursus quis, tempus eget nibh.
			Nunc auctor arcu ut semper gravida.
			Nullam pretium faucibus scelerisque.
			Nam quis mi et neque egestas aliquet.
			Curabitur consectetur enim erat, sit amet tincidunt nunc semper vel.
			Etiam nec eros a enim bibendum pellentesque ornare a diam.
			Donec finibus sagittis odio sed congue.
			</div>
			<input type="checkbox" id="TiC" value="">Prihvaćam prava i uvjete <br>
			<button class="button" type="submit" id="klik" disabled="true" style = "opacity:0.5;">Pošalji zahtjev!</button>
  	</form>
    <?php }
    echo '<br>' . $message . '<br>'; ?>

  <?php require_once __SITE_PATH . '/view/_footer.php'; ?>
