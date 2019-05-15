<?php
session_start();
include('../includes/connect.inc');
$idc = connect();

$online = $_POST['online'];
$id_user = $_SESSION['individu'];



$sql= "UPDATE public.individu
       SET online = '$online'
       WHERE id_individu = $id_user";


// Exécution de la requête
if(pg_exec($idc, $sql)) {
    echo ("Done");
}
?>
