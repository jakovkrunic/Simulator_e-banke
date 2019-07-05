<?php require_once 'view/_header.php';
?>
<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
<h1> Karta </h1>
<div id="map" class="map"></div>
<script src="<?php echo __SITE_URL;?>/js/mapa.js"></script>

<h1> Tečajna lista </h1>
<table id="table_exchange" style="border: 1px solid black">
  <tr>
  <th style="border: 1px solid black">*</th>
  <th style="border: 1px solid black"> HRK / * </th>
  <th style="border: 1px solid black"> * / HRK </th>

</tr>
</table>
<br>
<h1>Kontakt informacije</h1>
Za sve informacije ili nedoumice, navratite u jednu od naših poslovnica ili nas kontaktirajte putem telefona ili e-maila.<br>
Broj telefona: +385 (0)1 4605 777<br>
E-mail: morz(at)math.hr
<script src="<?php echo __SITE_URL;?>/js/tecaj.js"></script>
<?php
require_once 'view/_footer.php'; ?>
