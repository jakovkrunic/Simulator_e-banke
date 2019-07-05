<?php require_once 'view/admin_header.php';
?>

<h2><?php echo $naslov; ?></h2>

<?php
echo '<table align="center"><th>Opis</th><th>Racun pošiljatelja</th><th>Račun primatelja</th><th>Iznos</th><th>Valuta</th><th>Datum</th><th></th>';
	foreach($transakcije as $transakcija){
        //echo $racun->id;
		echo "<tr><td>".$transakcija->opis."</td><td>".$transakcija->racun_posiljatelj."</td><td>".$transakcija->racun_primatelj."</td><td>".$transakcija->iznos."</td><td>".$transakcija->valuta."</td><td>".$transakcija->datum."</td>";
	
?>
<td>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/approveTransaction&id='.$transakcija->id?>">
			<button class="button" type="submit">Odobri!</button>
		</form>	<br>
        <form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/rejectTransaction&id='.$transakcija->id?>">
			<button class="button" type="submit">Odbij!</button>
		</form>	
		</td></tr>
                <?php
			}
			
		?>
		</table>
<?php

require_once 'view/_footer.php'; ?>
