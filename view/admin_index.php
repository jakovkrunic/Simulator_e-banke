<?php require_once 'view/admin_header.php';
?>

<?php if (isset($poruka)){
	?>
	<div style = "text-align: center">
		<?php echo $poruka;  ?>
	</div>
	<br>
	<?php
}

 ?>

<p class="obavijesti"> Obavijesti! </p>

<div align="center">

<p class="korisnici">
<span class="unutra">
Trenutno imate <?php echo $br_korisnika; ?> korisnika za odobriti ili odbiti.
</span>
</p>

<p class="korisnici">
<span class="unutra">Trenutno imate <?php echo $br_racuna; if ($br_racuna % 10 === 1 && $br_racuna!== 11) echo " račun"; else echo " računa"; ?> za odobriti ili odbiti.
</span>
</p>

<p class="korisnici">
<span class="unutra">
Trenutno imate <?php echo $br_transakcija;
if ($br_transakcija % 10 === 1 && $br_transakcija!== 11) echo " transakciju";
else if ($br_transakcija % 10 >= 2 && $br_transakcija % 10 <=4 ) echo " transakcije";
else echo " transakcija" ?> za odobriti ili odbiti.
</span>

</p>
<p class="korisnici">
<span class="unutra">Trenutno imate <?php echo $br_punomoci; if ($br_punomoci % 10 === 1 && $br_punomoci!== 11) echo " punomoć"; else echo " punomoći"; ?> za odobriti ili odbiti.
</span>
</p>

<br>

<form style="align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/periodic'?>">
<button class="button" type="submit"> Provedi sve automatizirane akcije! </button>
</form>

</div>

<?php
require_once 'view/_footer.php'; ?>
