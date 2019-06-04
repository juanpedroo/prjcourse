<?php

    $geojson = $_GET['insertBD'];
    $idparcours = $_GET['AjouterId'];


	include('../include/connect.inc');
	$idc = connect();

    $sql='SELECT id_parcours_carte FROM c_parcours ORDER BY id_parcours_carte DESC';
    $rs=pg_exec($idc,$sql);
    $ligne=pg_fetch_assoc($rs);
    $idtrace = $ligne['id_parcours_carte'] + 1;

	$sql="INSERT INTO c_parcours(id_parcours_carte, forme_p, id_p) values ($idtrace,'$geojson',$idparcours);";
	$rs=pg_exec($idc,$sql);

    $sql="UPDATE parcours SET id_parcours_carte = $idtrace WHERE id_p = $idparcours;";
	$rs=pg_exec($idc,$sql);

?>
<script type="text/javascript">
	//alert("Parcours enregistré")
	document.location.href='../gestion_parcours.php'
</script>
