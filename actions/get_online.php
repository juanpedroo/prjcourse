<?php
session_start();
include('../includes/connect.inc');
$idc = connect();

$id_individu = $_POST['id_individu'];


$sql= "SELECT latitude, longitude, altitude, vitesse, dateheure
       FROM public.point
       WHERE id_individu = $id_individu and id_point > ";

if(pg_exec($idc, $sql)) {
    echo ("Done");
}
?>
