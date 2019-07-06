<?php require_once 'view/_header.php';
?>
<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>

<h2> Tečajna lista </h2>
<table id="table_exchange" align="center">
  <tr>
  <th>*</th>
  <th> HRK / * </th>
  <th> * / HRK </th>

</tr>
</table>
<br>
<script src="<?php echo __SITE_URL;?>/js/tecaj.js"></script>
<h2> Karta </h2>
<div id="map" class="map" align="center"></div>
<script src="<?php echo __SITE_URL;?>/js/mapa.js"></script>

<br>

<h1>Kontakt informacije</h1>
Za sve informacije ili nedoumice, navratite u jednu od naših poslovnica ili nas kontaktirajte putem telefona ili e-maila.<br>
Broj telefona: +385 (0)1 4605 777<br>
E-mail: morz(at)math.hr

<?php
require_once 'view/_footer.php'; ?>
