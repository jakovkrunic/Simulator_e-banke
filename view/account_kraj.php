<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<?php echo '<br>' . $message . '<br>'; ?>
<a href="index.php?rt=account">Kliknite ovdje za povratak na račune.</a>
<?php
require_once 'view/_footer.php'; ?>
