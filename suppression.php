<?php 
include("connection.php");

$temps = time() - 900;

$reponse = $bdd->query('SELECT * FROM accidents');

foreach($reponse as $donnees){
    $datecheck = $donnees['time1'];

    if($temps > $datecheck) {
        $bdd->query("DELETE FROM `accidents` WHERE `time1` = $datecheck");
        }
}
