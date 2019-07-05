<?php require_once 'view/_header.php';
?>
<table align="center">
	<tr>
		<th>ID</th>
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
					 '<td>' . $racun->id . '</td>' .
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
		echo "<h3>Lista Vaših opunomoćenika</h3>" . "<br>";
		for($i=0;$i<count($op_racuni);$i++)
		{
			echo "ID računa: " . $op_racuni[$i]->id;
			echo ". Popis opunomoćenika: ";
			foreach ($korisnici[$i] as $osoba)
			{
				echo $osoba->ime . " " . $osoba->prezime . " ";
			}
			echo ".";
			echo "<br><br>";

		}
	}
	?>
</div>
<div align="center">
	<?php
	if(empty($punomocni))
		echo "Nemate punomoć ni nad jednim tuđim računom.";
	else
	{	echo "<h3>Lista računa nad kojima imate punomoć</h3>" . "<br>";?>
		<table align="center">
			<tr>
				<th>ID</th>
		    <th>Tip</th>
		    <th>Valuta</th>
		    <th>Trenutno stanje</th>
		    <th>Datum izrade</th>
				<th>Vlasnik</th>
		  </tr>
			<?php
				for($i=0;$i<count($punomocni);$i++)
				{
					if($punomocni[$i]->odobren == 1){
					echo '<tr>' .
							 '<td>' . $punomocni[$i]->id . '</td>' .
					     '<td>' . $punomocni[$i]->tip_racuna . '</td>' .
					     '<td>' . $punomocni[$i]->valuta_racuna . '</td>' .
		           '<td>' . $punomocni[$i]->stanje_racuna . '</td>' .
					     '<td>' . $punomocni[$i]->datum_izrade . '</td>' .
							 '<td>' . $vlasnici[$i]->ime . " " . $vlasnici[$i]->prezime . '</td>' .
					     '</tr>';
					}
				}
			?>
		</table><?php


	}
	?>
</div>

<?php
require_once 'view/_footer.php'; ?>
