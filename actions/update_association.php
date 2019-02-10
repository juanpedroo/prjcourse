<?php
include('../includes/connect.inc');
$idc = connect();
$sqlF = "update association set asso_check = 'false' where id_asso  <>'".$_POST['assos']."'";
$sqlT = "update association set asso_check = 'true' where id_asso  ='".$_POST['assos']."'";

pg_query($idc,$sqlF);
pg_query($idc,$sqlT);

header('Location: ../admin_association.php');
?>
