<?php require_once 'view/admin_header.php';
?>

<h2><?php echo $naslov; ?></h2>

<?php
echo '<table align="center"><th>OIB</th><th>Vrsta računa</th><th>Željeno prekoračenje</th><th>Valuta</th><th>Datum kreiranja</th><th></th>';
	foreach($racuni as $racun){
        //echo $racun->id;
		echo "<tr><td>".$racun->oib."</td><td>".$racun->tip_racuna."</td><td>".$racun->dozvoljeni_minus."</td><td>".$racun->valuta_racuna."</td><td>".$racun->datum_izrade."</td>";
	
?>
<td>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/approveAcc&id='.$racun->id?>">
			<button class="button" type="submit">Odobri!</button>
		</form>	<br>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/rejectAcc&id='.$racun->id?>">
			<button class="button" type="submit">Odbij!</button>
		</form>	
		</td></tr>
                <?php
			}
			
		?>
		</table>
<?php

require_once 'view/_footer.php'; ?>
