<?php

	$id = $_POST['inputId'];
	$nomC = $_POST['inputNomC'];
	$infosC = $_POST['inputInfos'];
	$idAsso = $_POST['inputIdAsso'];
	$dateC = $_POST['inputDate'];

	include('../include/connect.inc');
	$idc = connect();
	$sql="INSERT INTO course(id_course, nom_course, infos_course) values ($id,'$nomC','$infosC');";
	$rs=pg_exec($idc,$sql);
	$sql="INSERT INTO profite(id_course, id_asso, date_jour) values ($id,'$idAsso','$dateC');";
	$rs=pg_exec($idc,$sql);


?>
<script type="text/javascript">
	document.location.href='../gestion_course.php'
</script>
