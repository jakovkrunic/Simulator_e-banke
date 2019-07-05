<?php require_once 'view/admin_header.php';
?>

<h2><?php echo $naslov; ?></h2>

<?php
echo '<table align="center"><th>ID računa</th><th>Oib vlasnika računa</th><th>Ime vlasnika računa</th><th>Prezime vlasnika računa</th><th>Oib opunomoćenika</th><th>Ime opunomoćenika</th><th>Prezime opunomoćenika</th><th></th>';
	foreach($zahtjevi as $zahtjev){
        //echo $racun->id;
		echo "<tr><td>".$zahtjev->id_racuna."</td><td>".$zahtjev->oib_vlasnika."</td><td>".$zahtjev->ime_vlasnika."</td><td>".$zahtjev->prezime_vlasnika."</td><td>".$zahtjev->oib_opunomocenika."</td><td>".$zahtjev->ime_opunomocenika."</td><td>".$zahtjev->prezime_opunomocenika."</td>";
	
?>
<td>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/approvePunomoc&id='.$zahtjev->id?>">
			<button class="button" type="submit">Odobri!</button>
		</form>	<br>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/rejectPunomoc&id='.$zahtjev->id?>">
			<button class="button" type="submit">Odbij!</button>
		</form>	
		</td></tr>
                <?php
			}
			
		?>
		</table>
<?php

require_once 'view/_footer.php'; ?>
