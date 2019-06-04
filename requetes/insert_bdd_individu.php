<?php

 $civ=$_POST['zl_civ'];
 $nom=$_POST['zs_nom'];
 $prenom=$_POST['zs_prenom'];
 $datnais=$_POST['zs_ddn'];
 $adresse=$_POST['zs_adresse'];
 $cp=$_POST['zs_cp'];
 $ville=$_POST['zs_ville'];
 $mail=$_POST['zs_mail'];
 $pass=$_POST['zs_pass'];
 $tel=$_POST['zs_tel'];
 $type_doc=$_POST['doc'];
 $file=$_POST['zs_doc'];
 $parcours=$_POST['zl_parcours'];
 $password = password_hash($pass, PASSWORD_DEFAULT);

if ($type_doc == "licence"){
  $licence = "true";
  $certificat = "false";
}
else {
  $licence = "false";
  $certificat = "true";
}


 include('../include/connect.inc');
 $idc=connect();

 $sql='SELECT id_individu FROM individu ORDER BY id_individu DESC';
 $rs=pg_exec($idc,$sql);
 $ligne=pg_fetch_assoc($rs);
 $idindividu = $ligne['id_individu'] + 1;

 $sql='SELECT id_inscrit FROM inscrits ORDER BY id_inscrit DESC';
 $rs=pg_exec($idc,$sql);
 $ligne=pg_fetch_assoc($rs);
 $idinscrit = $ligne['id_inscrit'] + 1;


$sql="insert into individu (id_individu, nom_p, prenom_p, adresse_p, ville_p, cp_p, civilite_p, date_naissance_p, mail_p, tel_p, mdp_p) values ($idindividu, '$nom', '$prenom', '$adresse', '$ville', '$cp', '$civ', '$datnais', '$mail', '$tel', '$password')";
$rs=pg_exec($idc, $sql);



$sql="insert into inscrits (id_inscrit, certificat_medical_p, licence_p, document_med, id_individu) values ($idinscrit, $certificat, $licence, '$file', $idindividu)";
$rs=pg_exec($idc, $sql);

?>

<script type="text/javascript">
	document.location.href='../page_accueil.php'
</script>
