<?php
session_start();
include('../includes/connect.inc');
$idc = connect();

$id_individu = $_POST['id_individu'];


$sql= "SELECT latitude, longitude, altitude, vitesse, dateheure
       FROM public.point
       WHERE id_individu = $id_individu and id_point > ";
// TODO: 
//        SELECT latitude, longitude, altitude, vitesse, dateheure, type_point, id_point
// FROM public.point
// WHERE id_individu = 3 and id_point >= (select max(id_point) from public.point where id_individu = 3 and type_point = 'start')

if(pg_exec($idc, $sql)) {
    echo ("Done");
}
?>
