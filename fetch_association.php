<?php
    $nomassoc = "";
    $adrassoc = "";
    $cpassoc = "";
    $villeassoc = "";
    $descrassoc = "";
    $telassoc = "";
    $dirassoc = "";
    $tabInfos = array();
    include('./includes/connect.inc');
    $idc = connect();
    $sql= "select nom_asso, adresse_asso, cp_asso, ville_asso, description_asso,
            tel_asso, nom_directeur_asso
            from association
            where asso_check = 'true'";


    $resultat=pg_exec($idc,$sql);
    while($ligne = pg_fetch_assoc($resultat)) {
        $nomassoc = $ligne['nom_asso'];
        $adrassoc = $ligne['adresse_asso'];
        $cpassoc = $ligne['cp_asso'];
        $villeassoc = $ligne['ville_asso'];
        $descrassoc = $ligne['description_asso'];
        $telassoc = $ligne['tel_asso'];
        $dirassoc = $ligne['nom_directeur_asso'];
    }

    $tabInfos[] = $nomassoc;
    $tabInfos[] = $adrassoc;
    $tabInfos[] = $cpassoc;
    $tabInfos[] = $villeassoc;
    $tabInfos[] = $descrassoc;
    $tabInfos[] = $telassoc;
    $tabInfos[] = $dirassoc;

    foreach($tabInfos as $value) {
        echo($value);
        echo("<br />");
    }

    // function setInfosAssoc() {
    //     $tabInfos[] = $nomassoc;
    //     $tabInfos[] = $adrassoc;
    //     $tabInfos[] = $cpassoc;
    //     $tabInfos[] = $villeassoc;
    //     $tabInfos[] = $descrassoc;
    //     $tabInfos[] = $telassoc;
    //     $tabInfos[] = $dirassoc;
    // }

    function getInfosAssoc() {
        return $tabInfos;
    }




 ?>
