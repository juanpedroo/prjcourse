<?php
include('./includes/connect.inc');
$idc = connect();
$association = $_POST['zl_association'];
// Mettre toutes les assos en false
$sql2 = 'update association set asso_check = false where 1 = 1'; // pas ouf le 1 = 1
$rs = pg_exec($idc,$sql2);
// Mettre l'asso select en true
$sql3 = 'update association set asso_check = true where id_asso ='.$association.'';
$rs = pg_exec($idc,$sql3);
header('Location: admin_select_asso.php');
 ?>
