<?php
session_start();
include('../includes/connect.inc');
$idc = connect();


$posX = $_POST['lat'];
$posY = $_POST['long'];
$precision = $_POST['precision'];
$direction = $_POST['direction'];
$altitude = $_POST['altitude'];
$vitesse = $_POST['vitesse'];
$id_user = $_SESSION['individu'];
$dateheure = date("Y-m-d H:i:s");


$sql= "INSERT INTO public.point (latitude, longitude, precision, altitude, vitesse,
    dateheure, id_individu, direction)
VALUES ($posX,$posY,$precision,$altitude,$vitesse,'$dateheure',$id_user,$direction)";


// Exécution de la requête
if(pg_exec($idc, $sql)) {
    echo ($dateheure);
}


?>
