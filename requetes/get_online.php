<?php
session_start();
include('../includes/connect.inc');
$idc = connect();

$id_individu = $_POST['option'];
// $id_individu = intval($id_individu);
$id_point = $_POST['id_point'];

if ($id_individu != 0) {
    $sql_check_online = "SELECT online
                         FROM public.individu
                         where id_individu = $id_individu and online ='connecte'";
$rs = pg_query($idc,$sql_check_online);
$ligne = pg_fetch_assoc($rs);

    if($ligne['online'] == 'connecte') {
        $sql= "SELECT latitude, longitude, altitude, vitesse, dateheure, type_point, id_point,chrono
               FROM public.point
               WHERE id_individu = $id_individu AND id_point >= (select max(id_point) from public.point where id_individu = $id_individu and type_point = 'start')
               AND id_point > $id_point";



        // Exécution de la requête
        $result = pg_query($idc, $sql);

        // Retourne le tableau des résultats encodé en JSON
        echo json_encode(pg_fetch_all($result));
    }
    else {
        echo ("Offline");
    }
    
}

?>
