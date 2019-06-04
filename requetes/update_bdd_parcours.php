<?php

	$id = $_POST['inputId'];
	$name = $_POST['inputName'];
	$date = $_POST['inputDate'];
	$heure = $_POST['inputHeure'];
	$longueur = $_POST['inputLg'];
 	$denivele = $_POST['inputDeniv'];
	$type = $_POST['inputType'];
	$tarif = $_POST['inputTarif'];
	$niv = $_POST['inputNiv'];
	$numCourse = $_POST['updateCourse'];

include('../include/connect.inc');
        $idc = connect();
        $sql="UPDATE parcours set type_p = '$type', niveau= '$niv', lieu = '$name', longueur_p = $longueur, denivelee_p = $denivele, tarif = $tarif, date_p = '$date', heure_p = '$heure', id_course = '$numCourse' where id_p = $id;";
        $rs=pg_exec($idc,$sql);

?>
<script type="text/javascript">
	//alert("Parcours modifié");
	document.location.href='../gestion_parcours.php'
</script>
