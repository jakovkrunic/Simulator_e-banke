<?php require_once 'view/_header.php';
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

 <form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=transaction/novi'?>">
 			<button class="button" type="submit">Nova transakcija</button>
 		</form>	<br>
<h2> Povijest transakcija</h2>
<p align="center">
Vrsta: <select id="vrsta_transakcije">
<option value="poslane" selected="selected"> Poslane transakcije </option>
<option value="primljene"> Primljene transakcije </option>
</select>
<br> <br>
Od: <select id="od_dan">
	<option value="1" selected="selected"> 1 </option>
<?php
for ($i = 2; $i <= 31; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
}
?>
</select>
<select id="od_mjesec">
	<option value="1" selected="selected"> 1 </option>
	<?php
	for ($i = 2; $i <= 12; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
</select>
<select id="od_godina">
	<option value="1991" selected="selected"> 1991 </option>
	<?php
	for ($i = 1992; $i <= 2019; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
</select>
<br> <br>

Do: <select id="do_dan">
<?php
for ($i = 1; $i <= 30; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
}
?>
<option value="31" selected="selected"> 31 </option>
</select>
<select id="do_mjesec">
	<?php
	for ($i = 1; $i <= 11; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
	<option value="12" selected="selected"> 12 </option>
</select>
<select id="do_godina">
	<?php
	for ($i = 1991; $i <= 2018; $i++) {
	echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
	<option value="2019" selected="selected"> 2019 </option>
</select>

<br> <br>
</p>

<table id="tablica_povijesti" align="center">
<tr id="header_povijesti">
	<th>Opis</th>
	<th>Pošiljatelj</th>
	<th>Primatelj</th>
	<th>Iznos</th>
	<th>Valuta</th>
	<th>Status</th>
	<th>Datum</th>
</tr>
</table>

<script src="<?php echo __SITE_URL;?>/js/povijest.js"></script>


<br>

<?php
require_once 'view/_footer.php'; ?>
