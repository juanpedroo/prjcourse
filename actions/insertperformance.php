<?php
session_start();
include('../includes/connect.inc');
$idc = connect();


$dDeb = $_POST['dateDeb'];
// $dFin = $_POST['dateFin'];
// $chrono = $_POST['chrono'];
$etat = $_POST['etat'];
$id_user = $_SESSION['individu'];


$sqlPointDeb = "SELECT id_point
                FROM public.point where id_individu = $id_user
                and dateheure = '$dDeb'";
$result = pg_query($idc, $sqlPointDeb);
$pointDebut = pg_fetch_row($result);


if($etat == "start") {
    $sql= "INSERT INTO public.performe (id_inscrit, point_start)
    VALUES ($id_user,$pointDebut[0])";

    if(pg_exec($idc, $sql)) {
        echo ("Done");
    }
}

if ($etat == "stop")  {
    $dFin = $_POST['dateFin'];
    $chrono = $_POST['chrono'];

    $sqlPointFin = "SELECT id_point
                    FROM public.point where id_individu = $id_user
                    and dateheure = '$dFin'";
    $result1 = pg_query($idc, $sqlPointFin);
    $pointFin = pg_fetch_row($result1);

    $sql3= "UPDATE public.performe
           SET chrono = '$chrono',
           point_stop = $pointFin[0]
           WHERE id_inscrit = $id_user
           AND point_start = $pointDebut[0]";


    $sql1 = "UPDATE public.point
             SET type_point ='stop'
             WHERE id_point = $pointFin[0]";
    if(pg_exec($idc, $sql3)) {
        pg_exec($idc,$sql1);
        echo ($dDeb. " ".$dFin);
    }
}

?>
