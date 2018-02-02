<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=quicksave;charset=utf8', 'root', '');
}
catch (Exception $e){
	die('Erreur :'. $e->getMessage());
}

$geopoint = $bdd->query('SELECT GeoPoint, id FROM table1');

$donnees = $geopoint->fetchAll();

$geopoint->closeCursor();

$geopoint2 = $bdd->query('SELECT geo_point FROM pharmacies');

$donnees2 = $geopoint2->fetchAll();

$geopoint2->closeCursor(); 

$geopoint3 = $bdd->query('SELECT coordonnees FROM accidents');

$donnees3 = $geopoint3->fetchAll();

$geopoint3->closeCursor(); 

$membres = $bdd->query("SELECT pseudo, connectiontime FROM membres WHERE intervenant = 1");

$membresco = $membres->fetchAll();

$membres->closeCursor();
?>