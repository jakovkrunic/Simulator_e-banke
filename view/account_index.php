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
			if($racun->odobren == 1){
			echo '<tr>' .
			     '<td>' . $racun->tip_racuna . '</td>' .
			     '<td>' . $racun->valuta_racuna . '</td>' .
           '<td>' . $racun->stanje_racuna . '</td>' .
			     '<td>' . $racun->datum_izrade . '</td>' .
			     '</tr>';
			}
		}
	?>
</table>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=account/open'?>">
			<button class="button" type="submit">Otvori novi račun!</button>
		</form>	

		<!--  PRIVREMENO DOK SE NE SLOŽI ADMIN HEADER -->
		<nav>
			<ul>
				<li><a href="index.php?rt=account/unapproved">Odobri račun</a></li>
			</ul>
		</nav>
		<!--  -->
<?php
require_once 'view/_footer.php'; ?>
