<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=predlozak/provjeri&akcija=stvori'?>">
	Naziv predloška:
	<input type="text" autocomplete="off" name="ime" ><br>
	Broj mog računa:
	<input type="text" autocomplete="off" name="moj"><br>
	Broj računa primatelja:
	<input type="text" autocomplete="off" name="primatelj"><br>
	Valuta:
	<input type="text" autocomplete="off" name="valuta"><br>
	<button class="button" type="submit" name="stvori">Stvori!</button>
</form><br>
<a href="index.php?rt=predlozak">Povratak na izbornik predložaka.</a>
<?php echo '<br>' . $message . '<br>';
require_once 'view/_footer.php'; ?>
