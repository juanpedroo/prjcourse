<?php
session_start();
include('../include/connect.inc');
$idc = connect();

$online = $_POST['online'];
$id_user = $_SESSION['individu'];



$sql= "UPDATE public.individu
       SET online = '$online'
       WHERE id_individu = $id_user";

 $sql1= "UPDATE public.individu
        SET last_activity = now()
        WHERE id_individu = $id_user";
// Exécution de la requête
if(pg_exec($idc, $sql)) {
    pg_exec($idc, $sql1);
    echo ("Done");
}
?>
