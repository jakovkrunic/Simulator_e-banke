<?php require_once 'view/admin_header.php';
?>	
	<h1><?php echo $title; ?></h1>
<?php
echo "<table><th>OIB</th><th>Ime</th><th>Prezime</th><th>Email</th><th></th>";
	foreach($zahtjevi as $user){
		echo "<tr><td>".$user['oib']."</td><td>".$user['ime']."</td><td>".$user['prezime']."</td><td>".$user['email']."</td>";
	
?>

<td>
		<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/approve&oib=' . $user['oib']. '&registriran='. $user['registriran']?>">
			<button class="button" type="submit">Accept!</button>
		</form>	
		</td>
                <?php
			}
			
		?>

<?php echo '<br>' . $poruka . '<br>'; ?>
</body>
