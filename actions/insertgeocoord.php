<?php
// Récupération de l'id de l'option
$q = intval($_POST['q']);

include('../includes/connect.inc');
$idc = connect();


$posX =
$posY =
$precision =
$altitude =
$vitesse =
$id_user =
$dateheure = date("Y-m-d ")
// Requête
$sql= "SELECT nom_asso, adresse_asso, cp_asso, ville_asso, description_asso,
tel_asso, nom_directeur_asso
FROM association
WHERE id_asso = $q";

// Exécution de la requête
$result = pg_query($idc, $sql);

// Retourne le tableau des résultats encodé en JSON
echo json_encode( pg_fetch_all($result)[0] );
?>
