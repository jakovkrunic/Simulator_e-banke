<?php require_once 'view/_header.php';
?>
<h2><?php echo $naslov; ?></h2>
<br>
<script src='./js/kreiranje_racuna.js'></script>
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=account/save'?>">
    <label>Odaberite vrstu računa:</label>
    <select name='vrsta' id="vrstaRacuna" required>
    <?php
        $brojac = 0;
        foreach ($vrste as $key) {
            if($brojac==0)
                echo "<option selected value=".$key.">".$key."</option>";
            else echo "<option value=".$key.">".$key."</option>";
            $brojac++;
        }
    ?>
    </select><br>
    <label>Odaberite valutu računa:</label>
    <select name='valuta' id='valutaRacuna'>
    </select><br>

    <label>Početno stanje računa:</label>
    <input type="number" disabled value="0"><br>

    <label>Željeno dozvoljeno prekoračenje računa:</label>
    <input type="range" min="0" max="10000" id="raspon" value="1000" step="100" name="minus">&nbsp;<label id="minus"></label><br>

    <button class="button" type="submit">Otvori novi račun!</button>
</form>
<?php
require_once 'view/_footer.php'; ?>
