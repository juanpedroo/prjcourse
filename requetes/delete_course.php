<?php
	$idcourse= $_POST['deleteId'];

	include('../include/connect.inc');
	$idc = connect();

	$sql="DELETE FROM course where id_course = $idcourse;";
	$rs=pg_exec($idc,$sql);
	$sql="DELETE FROM profite where id_course = $idcourse;";
	$rs=pg_exec($idc,$sql);
	$sql="UPDATE parcours SET id_course = null where id_course = $idcourse;";
	$rs=pg_exec($idc,$sql);
?>

<script type="text/javascript">
	document.location.href='../gestion_course.php'
</script>
