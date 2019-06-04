<?php

	$id = $_POST['inputId'];
	$lieu = $_POST['inputName'];
	$date = $_POST['inputDate'];
	$heure = $_POST['inputHeure'];
	$longueur = $_POST['inputLg'];
	$denivele = $_POST['inputDeniv'];
	$type = $_POST['inputType'];
	$tarif = $_POST['inputTarif'];
	$difficulte = $_POST['inputNiv'];

	include('../include/connect.inc');
	$idc = connect();
	$sql="INSERT INTO parcours(id_p, lieu, heure_p, longueur_p, denivelee_p, tarif, date_p, type_p, niveau) values ($id,'$lieu','$heure',$longueur,$denivele,$tarif,'$date', '$type', $difficulte);";
	$rs=pg_exec($idc,$sql);

?>
<script type="text/javascript">
	//alert("Parcours enregistré")
	document.location.href='../gestion_parcours.php'
</script>
