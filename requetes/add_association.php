<?php
	include('../include/connect.inc');
	$nom = $_POST['nom'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$desc = $_POST['desc'];
	$tel = $_POST['tel'];
	$directeur = $_POST['directeur'];

	$idc = connect();
	$sql="INSERT INTO association(nom_asso,adresse_asso,cp_asso,ville_asso,description_asso,tel_asso,nom_directeur_asso)
	      VALUES ('$nom','$adresse','$cp','$ville','$desc','$tel','$directeur');";

	if(pg_exec($idc, $sql)) {
		echo ("ok");
    }
    else {
        echo ("ko");
    }

?>
