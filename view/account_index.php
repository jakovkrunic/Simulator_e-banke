<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
    <th>Tip</th>
    <th>Valuta</th>
    <th>Trenutno stanje</th>
    <th>Datum izrade</th>
		<th>Želite li dati punomoć nekome?</th>
  </tr>
	<?php
		foreach( $racuni as $racun )
		{
			if($racun->odobren == 1){
			echo '<tr>' .
			     '<td>' . $racun->tip_racuna . '</td>' .
			     '<td>' . $racun->valuta_racuna . '</td>' .
           '<td>' . $racun->stanje_racuna . '</td>' .
			     '<td>' . $racun->datum_izrade . '</td>' .
					 '<td><a href="index.php?rt=account/punomoc&id_racun='.$racun->id.'">Unos za punomoć</a></td>' .
			     '</tr>';
			}
		}
	?>
</table>
<br>
<form style = "text-align: center" method="post" action="<?php echo __SITE_URL . '/index.php?rt=account/open'?>">
			<button class="button" type="submit">Otvori novi račun!</button>
		</form>	<br>
<div align="center">
	<?php
	if(empty($op_racuni))
		echo "Nitko nema punomoć ni na jednom Vašem računu.";
	else
	{
		echo "<h3>Lista Vaših opunomoćenika<h3>" . "<br>";
		for($i=0;$i<count($op_racuni);$i++)
		{
			echo "Tip računa: " . $op_racuni[$i]->tip_racuna;
			echo ". Popis opunomoćenika: ";
			foreach ($korisnici[$i] as $osoba)
			{
				echo $osoba->ime . " " . $osoba->prezime . " ";
			}
			echo "<br>";

		}
	}
	?>
</div>

<?php
require_once 'view/_footer.php'; ?>
