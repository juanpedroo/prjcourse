<?php
session_start();
include('../includes/connect.inc');
$idc = connect();


$dDeb = $_POST['dateDeb'];
$dFin = $_POST['dateFin'];
$chrono = $_POST['chrono'];
$id_user = $_SESSION['individu'];


$sqlPointDeb = "SELECT id_point
                FROM public.point where id_individu = $id_user
                and dateheure = '$dDeb'";
$result = pg_query($idc, $sqlPointDeb);
$pointDebut = pg_fetch_row($result);

$sqlPointFin = "SELECT id_point
                FROM public.point where id_individu = $id_user
                and dateheure = '$dFin'";
$result1 = pg_query($idc, $sqlPointFin);
$pointFin = pg_fetch_row($result1);


$sql= "INSERT INTO public.performe (id_individu, chrono, point_start, point_stop)
VALUES ($id_user,'$chrono',$pointDebut[0],$pointFin[0])";


// Exécution de la requête
if(pg_exec($idc, $sql)) {
    echo ($dDeb. " ".$dFin);
}




?>
