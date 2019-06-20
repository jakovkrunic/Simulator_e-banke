<?php require_once 'view/_header.php';
?>
<table>
	<tr>
    <th>Tip</th>
    <th>Valuta</th>
    <th>Trenutno stanje</th>
    <th>Datum izrade</th>
  </tr>
	<?php
		foreach( $racuni as $racun )
		{
			echo '<tr>' .
			     '<td>' . $racun->tip_racuna . '</td>' .
			     '<td>' . $racun->valuta_racuna . '</td>' .
           '<td>' . $racun->stanje_racuna . '</td>' .
			     '<td>' . $racun->datum_izrade . '</td>' .
			     '</tr>';
		}
	?>
</table>
<?php
require_once 'view/_footer.php'; ?>
