<?php require_once 'view/admin_header.php';
?>

<br>
<script src='./js/kreiranje_racuna.js'></script>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=admin/openCreditUser'?>">
    <label>Upišite tražene podatke </label> <br><br>
    <label>Ime: </label> <input type="text" name="ime"/>
    <label>Prezime: </label> <input type="text" name="prezime"/> 
    <label>OIB: </label> <input type="text" name="oib"> <br><br>

    <button class="button" type="submit">Otvori kredit korisniku!</button>
</form>	

<?php

if(isset($poruka)) echo '<br>' . $poruka . '<br>';
require_once 'view/_footer.php';

?>
