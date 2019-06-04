<?php

	$idParcoursVoulu = $_POST['selectTrace'];
	$idParcoursModif = $_POST['changerId'];

	echo $idParcoursModif;
	echo "<br/>";
	echo $idParcoursVoulu;

	include('../include/connect.inc');
    $idc = connect();

	$sql="SELECT forme_p FROM c_parcours WHERE id_p=$idParcoursVoulu";
	$rs=pg_exec($idc,$sql);
	while($ligne=pg_fetch_assoc($rs)){
		$nouvTrace= $ligne['forme_p'];
	}

	$sql = "UPDATE c_parcours SET forme_p = '$nouvTrace' WHERE id_p = $idParcoursModif";
	$rs=pg_exec($idc,$sql);


?>
<script type="text/javascript">
	//alert("Parcours modifié");
	document.location.href='../gestion_parcours.php'
</script>
