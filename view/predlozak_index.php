<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<br>
<table>
	<tr>
    <th>Platni nalozi</th>
    <th>Interni prijenosi</th>
  </tr>
  <tr>
    <td><a href="index.php?rt=predlozak/pregledplatni">Pregled predložaka</a></td>
    <td><a href="index.php?rt=predlozak/pregledinterni">Pregled predložaka</a></td>
  </tr>
</table>
<br>
<a href="index.php?rt=predlozak/stvori">Stvori novi predložak!</a>
<?php
require_once 'view/_footer.php'; ?>
