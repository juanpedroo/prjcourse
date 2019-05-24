<?php
session_start();
include('../includes/connect.inc');
$idc = connect();

$id_individu = intval($_POST['id_individu']);
$id_point = $_POST['id_point'];


$sql= "SELECT latitude, longitude, altitude, vitesse, dateheure, type_point, id_point
       FROM public.point
       WHERE id_individu = 3 AND id_point >= (select max(id_point) from public.point where id_individu = 3 and type_point = 'start')
       AND id_point > $id_point";



// Exécution de la requête
$result = pg_query($idc, $sql);

// Retourne le tableau des résultats encodé en JSON

echo json_encode(pg_fetch_all($result));


?>
