<?php
    session_start();
?>
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

<script src="lib/popper/popper.js"></script>

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
        include('includes/header.inc');
        include('./includes/connect.inc');
        $idc = connect();
    ?>
    <br>
    <div class="container-fluid">
        <div class="row blabla">
            <div class="col-md-10">
                <p>Infos association selectionnée : </p>
                <div id="txtHint">
                    <table class="table">
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

                        <tbody>
                            <tr>
                                <th id="nom_asso" scope="row"></th>

                                <td id="adresse_asso"></td>
                                <td id="cp_asso"></td>
                                <td id="ville_asso"></td>
                                <td id="description_asso">
                                    <a href='#' tabindex='0' id='desc' data-container='body' data-trigger='focus' data-toggle='popover' data-placement='bottom' data-content=''>
                                        ...
                                    </a>
                                </td>
                                <td id="tel_asso"></td>
                                <td id="nom_directeur_asso"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2">
                <form name="frm_choixass" method="post" action="actions/update_association.php">
                    <?php
                        // Rqt affiche l'assoc checked = true
                        $sqlDef = 'SELECT id_asso, nom_asso FROM association WHERE asso_check = true';

                        //Rqt affiche le reste
                        $sqlChoix = 'SELECT id_asso, nom_asso FROM association WHERE asso_check = false';

                        // Traitement
                        $resultat = pg_exec($idc, $sqlDef);
                        $resultat1 = pg_exec($idc, $sqlChoix);
                    ?>

                    Choix :
                    <select id="assos" name="assos" onchange="showAssos(this.value)" class="form-control">
                        <optgroup label="Actuelle">
                            <?php
                            while($ligne = pg_fetch_assoc($resultat)) {
                                print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
                            }
                            ?>
                        </optgroup>

                        <optgroup label="Autres">
                            <?php
                                while($ligne = pg_fetch_assoc($resultat1)) {
                                    print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
                                }
                            ?>
                        </optgroup>
                    </select><br>
                    <input type="submit" name="submit" class=" btn btn-vert btn-block" value="Valider">
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function showAssos(str) {

            $.post('./actions/get_association.php',
                { q: str },

                // Fonction quand success
                function(data) {

                    // Décode du JSON le résultat
                    var res = JSON.parse(data);

                    // Affectation des nouvelles valeurs
                    $('#nom_asso')[0].innerHTML = res['nom_asso'];
                    $('#adresse_asso')[0].innerHTML = res['adresse_asso'];
                    $('#cp_asso')[0].innerHTML = res['cp_asso'];
                    $('#ville_asso')[0].innerHTML = res['ville_asso'];
                    $('#description_asso')[0].innerHTML = res['description_asso'].substring(0, 25) + ' ';
                    $('#tel_asso')[0].innerHTML = res['tel_asso'];
                    $('#nom_directeur_asso')[0].innerHTML = res['nom_directeur_asso'];

                    // Création du lien de la popover
                    var popover = $('<a>',{
                        text: '...',
                        href: '#',
                        'tabindex': '0',
                        'id': 'desc',
                        'data-container': 'body',
                        'data-trigger': 'focus',
                        'data-toggle': 'popover',
                        'data-placement': 'bottom',
                        'data-content': res['description_asso'],
                        click:function(e){ e.preventDefault(); }
                    }).appendTo('#description_asso')[0];

                    // Création de l'événement popover sur le lien de la description
                    $('[data-toggle="popover"]').popover();


                }
            )
        }

        // On récupère la value de l'option sélectionnée
        var id_option = $('#assos option:eq(0)').prop('selected', true)[0].value;

        // On affiche les informations de l'association quand la page est chargée
        $(document).ready( showAssos(id_option) );
    </script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
