<?php require_once 'view/admin_header.php';
?>	
	<h2><?php echo $title; ?></h2>
<?php
echo '<table align="center"><th>OIB</th><th>Ime</th><th>Prezime</th><th>Email</th><th></th>';
	foreach($zahtjevi as $user){
		echo "<tr><td>".$user['oib']."</td><td>".$user['ime']."</td><td>".$user['prezime']."</td><td>".$user['email']."</td>";
	
?>

<td>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/approve&oib=' . $user['oib']. '&registriran='. $user['registriran']?>">
			<button class="button" type="submit">Odobri!</button>
		</form>	<br>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/reject&oib=' . $user['oib']. '&registriran='. $user['registriran']?>">
			<button class="button" type="submit">Odbij!</button>
		</form>
		</td></tr>
                <?php
			}
			
		?></table>

<?php if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';  ?>