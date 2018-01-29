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
?>