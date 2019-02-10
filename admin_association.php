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

table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
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
        session_start();
        include 'includes/header.inc';
    ?>
    <br>
    <div class="container-fluid">
        <div class="row blabla">
            <div class="col-md-7">
                <p>Infos association selectionnée : </p>
                <div id="txtHint">
                    <?php
                    include('./includes/connect.inc');
                    $idc = connect();
                    $sql= "select nom_asso, adresse_asso, cp_asso, ville_asso, description_asso,
                    tel_asso, nom_directeur_asso
                    from association
                    where asso_check = 't'";

                    $result=pg_query($idc,$sql);
                    echo '<table class="table">
                    <thead class="thead-light">
                    <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">CP</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Description</th>
                    <th scope="col">Telephone</th>
                    <th scope="col">Directeur</th>
                    </tr>
                    </thead>
                    <tbody>';
                    while($row = pg_fetch_array($result)) {
                        echo "<tr>";
                        echo '<th scope="row">' . $row['nom_asso'] . "</th>";
                        echo "<td>" . $row['adresse_asso'] . "</td>";
                        echo "<td>" . $row['cp_asso'] . "</td>";
                        echo "<td>" . $row['ville_asso'] . "</td>";
                        $desc = $row['description_asso'];
                        echo "<td>" . substr($row['description_asso'],0,25) . " ...</td>";
                        echo "<td>" . $row['tel_asso'] . "</td>";
                        echo "<td>" . $row['nom_directeur_asso'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>
                    </table>";
                    echo $desc;
                    ?>
                </div>
            </div>
            <div class="col-md-2">
                <form name="frm_choixass" method="post" action="actions/update_association.php">
                Choix : <select id="assos" name="assos" onchange="showAssos(this.value)" class="form-control">
    <?php


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
