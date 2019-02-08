<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Choix Association</title>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="styles/navbar.css">
<script src="lib/jquery/jquery-3.3.1.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<style>
.btn-vert {
  color: #FFFFFF;
  background-color: #33CABB;
  border-color: #33CABB;
}

.btn-vert:hover,
.btn-vert:focus,
.btn-vert:active,
.btn-vert.active,
.open .dropdown-toggle.btn-vert {
  color: #FFFFFF;
  background-color: #31BFB1;
  border-color: #33CABB;
}

.btn-vert:active,
.btn-vert.active,
.open .dropdown-toggle.btn-vert {
  background-image: none;
}
</style>
<script type="text/javascript">
	// Prevent dropdown menu from closing when click inside the form
	$(document).on("click", ".navbar-right .dropdown-menu", function(e){
		e.stopPropagation();
	});
</script>
</head>
<body>
    <?php
        include 'includes/header.inc';
    ?>
    <br>
    <div class="container-fluid">
        <div class="row blabla">
            <div class="col-md-7">
                <p>Veuillez selectionner l'association qui doit être affichée : </p>
                <div id="txtHint"><b>Person info will be listed here...</b></div>
            </div>
            <div class="col-md-2">
                <form name="frm_choixass" method="post" action="actions/update_association.php">
                Choix : <select id="assos" name="assos" onchange="showAssos(this.value)" class="form-control">
    <?php

        include('./includes/connect.inc');
        $idc = connect();

        // Rqt affiche l'assoc checked = true
        $sqlDef = 'select id_asso, nom_asso from association where asso_check = true';

        //Rqt affiche le reste
        $sqlChoix = 'select id_asso, nom_asso from association where asso_check = false';

        // Traitement
        $resultat = pg_exec($idc, $sqlDef);
        $resultat1 = pg_exec($idc, $sqlChoix);
        while($ligne = pg_fetch_assoc($resultat)) {
            print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
        }

        while($ligne = pg_fetch_assoc($resultat1)) {
            print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
        }
    ?>
                </select><br>
                <input type="submit" name="submit" class=" btn btn-vert btn-block" value="Valider">
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
function showAssos(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","./actions/getassociation.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</body>
</html>
