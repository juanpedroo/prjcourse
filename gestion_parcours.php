<!DOCTYPE html>
<?php
	session_start();
	include 'include/header.inc';
?>
<html lang="fr" dir="ltr">
    <head>
        <title>La Solidaria Bram</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            include("include/bootstrap.inc")
        ?>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
        <link rel="stylesheet" href="css/navbar.css"/>
        <link rel="stylesheet" href="css/css_tableau.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="css/css_gestion_parcours.css">
    </head>

    <body>
        <?php
            include('./include/connect.php');
            $idc = connect();
        ?>

        <!-- Tableau listant les parcours -->
        <div class="container">
            <div class="row">
                <h3> Listes des parcours:</h3>
                <br/>
                <div class="col-md">
                    <table id="table" align="center" class="table table-bordered table-hover" style="width: 80%;">
                        <tr>

                            <th class="text-center">Identifiant du parcours</th>
                            <th class="text-center">Nom du parcours</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Heure</th>
                            <th class="text-center">Longueur</th>
                            <th class="text-center">Denivele</th>
                            <th class="text-center">Terrain</th>
                            <th class="text-center">Niveau</th>
                            <th class="text-center">Tarif</th>
                            <th class="text-center">Tracé</th>
                            <th class="text-center">Course</th>

                        </tr>
                        <?php
                            $sql='SELECT id_p, lieu, heure_p, longueur_p, denivelee_p, type_p, niveau, tarif, date_p, id_parcours_carte, id_course FROM parcours ORDER BY id_p';
                            $rs=pg_exec($idc,$sql);
                            while($ligne=pg_fetch_assoc($rs)){
                                // vérification si un parcours à été tracé
                                if (isset($ligne['id_parcours_carte'])) {
                                    $draw = ' ✔️ ';
                                }else{
                                    $draw = '❌';
                                };

                                //affichage du tableau qui liste les parcours
                                print('<tr>

                                    <td class="idP">'.$ligne['id_p'].'</td>
                                    <td class="name">'.$ligne['lieu'].'</td>
                                    <td class="date">'.$ligne['date_p'].'</td>
                                    <td class="heure">'.$ligne['heure_p'].'</td>
                                    <td class="long">'.$ligne['longueur_p'].'</td>
                                    <td class="deniv">'.$ligne['denivelee_p'].'</td>
                                    <td class="type">'.$ligne['type_p'].'</td>
                                    <td class="niv">'.$ligne['niveau'].'</td>
                                    <td class="tarif">'.$ligne['tarif'].'</td>
                                    <td class="drawed"><input type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalTrace" id="inputTrace" value ='.$draw.'></input></td>
                                    <td class="idCourse">'.$ligne['id_course'].'</td>
                                    <td class="drawed"><input type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#ModalDelete" id="inputDelete" value="❌"></input></td>
                                    </tr>'
                                );
                            }
                        ?>
                    </table>
                    <p style="font-style: italic;color:#33cabb;"> * cliquer sur une ligne du tableau pour modifier les informations</p>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalInsert">
                        Ajouter un parcours
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal du Update -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md">
                            <form name="frm" action="requetes/update_bdd_parcours.php" method="POST">
                                <div class="col-md">
                                    <label for="inputId">Identifiant du Parcours</label>
                                    <input type="text" class="form-control" id="inputId" name='inputId' style="text-align:center" readonly>
                                </div>
                                <hr>
                                <div class="col-md">
                                    <label for="selectCourse">Course correspondante</label>
                                    <select class="form-control" name='updateCourse' id="updateCourse">
                                        <?php
                                            $sql='SELECT id_course, nom_course FROM course ORDER BY id_course';
                                            $rs=pg_exec($idc,$sql);
                                            while($ligne=pg_fetch_assoc($rs)){
                                                print('<option value="'.$ligne['id_course'].'"> Course n°'.$ligne['id_course'].' - '.$ligne['nom_course'].'</option>');
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label for="inputName">Nom du Parcours</label>
                                    <input type="text" class="form-control" id="inputName" name='inputName' placeholder="La Solidaria Bram">
                                </div>
                                <div class="col-md">
                                    <label for="inputDate">Date de la course</label>
                                    <input type="date" class="form-control" id="inputDate" name='inputDate' placeholder="2019-08-02">
                                </div>
                                <div class="col-md">
                                    <label for="inputHeure">Heure du départ</label>
                                    <input type="time" class="form-control" id="inputHeure" name='inputHeure' placeholder="09:15">
                                </div>
                                <div class="col-md">
                                    <label for="inputLg">Longueur</label>
                                    <input type="number" class="form-control" id="inputLg" name='inputLg' placeholder="5">
                                </div>
                                <div class="col-md">
                                    <label for="inputDeniv">Denivele</label>
                                    <input type="number" class="form-control" id="inputDeniv" name='inputDeniv'></input>
                                </div>
                                <div class="col-md">
                                    <label for="inputType">Type de parcours</label>
                                    <select id="inputType" name='inputType' class="form-control">
                                        <option selected>Route</option>
                                        <option>Route et Chemins</option>
                                        <option>Chemins</option>
                                        <option>Trail</option>
                                        <option>Cross Country</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label for="inputNiv">Niveau</label>
                                    <input type="number" class="form-control" id="inputNiv" name='inputNiv' min="1" max="5"></input>
                                </div>
                                <div class="col-md">
                                    <label for="inputTarif">Tarif</label>
                                    <input type="number" class="form-control" id="inputTarif" name='inputTarif'></input>
                                </div>
                                <div class="col-md">
                                    <label for="textTracé">Tracé</label>
                                    <br/>
                                    <input type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalTrace" id="inputTrace" name='inputTrace' value ='Changer de Parcours'></input>
                                </div>
                                <hr>
                                <div class="row">
                                    <input type="submit" class="btn btn-success" style="margin-top: 5px;"></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Choix Trace -->
        <div class="modal fade centered-modal" id="ModalTrace" tabindex="-1" role="dialog" aria-labelledby="ModalTrace" aria-hidden="true">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Changer de parcours</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="accordion">
                            <form  action="draw_parcours.php" method="post">
                                <input type="text" id="AjouterId" name='AjouterId' style="display:none;">
                                <input type="submit" class="btn btn-link" value="Dessiner un parcours"></input>
                            </form>
                            <hr>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Choisir le tracé d'un parcours existant
                                    </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <form name="frm" action="requetes/update_bdd_trace_parcours.php" method="POST">
                                            <input type="text" id="changerId" name='changerId' style="display:none;">
                                            <select class="form-control" name='selectTrace' id="selectTrace">
                                                <?php
                                                    $sql='SELECT id_p, lieu, heure_p, longueur_p, denivelee_p, type_p, niveau, tarif, date_p, id_parcours_carte FROM parcours ORDER BY id_p';
                                                    $rs=pg_exec($idc,$sql);
                                                    while($ligne=pg_fetch_assoc($rs)){
                                                        print('<option value="'.$ligne['id_p'].'"> Parcours n°'.$ligne['id_p'].' - '.$ligne['lieu'].' - Longueur:  '.$ligne['longueur_p'].'km - Utilisé le: '.$ligne['date_p'].'</option>');
                                                    }
                                                ?>
                                            </select>
                                            <div class="row">
                                                <input type="submit" class="btn btn-primary" style="margin-top: 5px;"></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal suppression du parcours -->
        <div class="modal fade centered-modal" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDelete" aria-hidden="true">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="icon-box">
                            <i class="material-icons">&#xE5CD;</i>
                        </div>
                        <h4 class="modal-title">Attention !</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Vous êtes sur le point de supprimer le parcours !</p>
                        <form name="frm" action="requetes/delete_parcours.php" method="POST">
                            <input type="text" id="deleteId" name='deleteId' style="display: none;">
                            <div class="row">
                                <input type="submit" class="btn btn-danger" style="margin-top: 5px;" value="Supprimer"></button>
                            </div>
                        </form>
                        <button type="button" class="btn btn-info" data-dismiss="modal" style="margin-top: 2%;">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Insert -->
        <div class="modal fade" id="ModalInsert" tabindex="-1" role="dialog" aria-labelledby="ModalInsert" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un parcours</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        $sql='SELECT id_p FROM parcours ORDER BY id_p DESC';
                        $rs=pg_exec($idc,$sql);
                        $ligne=pg_fetch_assoc($rs);
                        $idp = $ligne['id_p'] + 1;
                    ?>
                    <div class="modal-body">
                        <div class="col-md">
                            <form name="frm" action="requetes/insert_bdd_parcours.php" method="POST">
                                <div class="col-md">
                                    <label for="inputId">Identifiant du Parcours</label>
                                    <input type="text" class="form-control" id="inputId" name='inputId' value="<?php echo $idp ?>" style="text-align:center" readonly>
                                </div>
                                <hr>
                                <div class="col-md">
                                    <label for="inputName">Nom du Parcours</label>
                                    <input type="text" class="form-control" id="inputName" name='inputName' placeholder="La Solidaria Bram">
                                </div>
                                <div class="col-md">
                                    <label for="inputDate">Date de la course</label>
                                    <input type="date" class="form-control" id="inputDate" name='inputDate' placeholder="2019-08-02">
                                </div>
                                <div class="col-md">
                                    <label for="inputHeure">Heure du départ</label>
                                    <input type="time" class="form-control" id="inputHeure" name='inputHeure' placeholder="09:15">
                                </div>
                                <div class="col-md">
                                    <label for="inputLg">Longueur</label>
                                    <input type="number" class="form-control" id="inputLg" name='inputLg' placeholder="5">
                                </div>
                                <div class="col-md">
                                    <label for="inputDeniv">Denivele</label>
                                    <input type="number" class="form-control" id="inputDeniv" name='inputDeniv'></input>
                                </div>
                                <div class="col-md">
                                    <label for="inputType">Type de parcours</label>
                                    <select id="inputType" name='inputType' class="form-control">
                                        <option selected>Route</option>
                                        <option>Route et Chemins</option>
                                        <option>Chemins</option>
                                        <option>Trail</option>
                                        <option>Cross Country</option>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label for="inputNiv">Niveau</label>
                                    <input type="number" class="form-control" id="inputNiv" name='inputNiv' min="1" max="5"></input>
                                </div>
                                <div class="col-md">
                                    <label for="inputTarif">Tarif</label>
                                    <input type="number" class="form-control" id="inputTarif" name='inputTarif'></input>
                                </div>
                                <div class="col-md">
                                    <label for="selectCourse">Course correspondante</label>
                                    <select class="form-control" name='selectCourse' id="selectCourse">
                                        <?php
                                            $sql='SELECT id_course, nom_course FROM course ORDER BY id_course';
                                            $rs=pg_exec($idc,$sql);
                                            while($ligne=pg_fetch_assoc($rs)){
                                                print('<option value="'.$ligne['id_course'].'"> Course n°'.$ligne['id_course'].' - '.$ligne['nom_course'].'</option>');
                                            }
                                        ?>
                                    </select>
                                </div>
                                <hr>
                                <div class="row">
                                    <div>
                                        <input type="submit" class="btn btn-success" style="margin-top: 5px;"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.onload = function () {
                addr = document.getElementById("flop");
            }

            var rIndex,
            table = document.getElementById("table");

            // Vérifie si un input est vide
            function checkEmptyInput()
            {
                var isEmpty = false,
                idp = document.getElementById("inputId").value,
                name = document.getElementById("inputName").value,
                date = document.getElementById("inputDate").value;
                heure = document.getElementById("inputHeure").value;
                long = document.getElementById("inputLg").value;
                deniv = document.getElementById("inputDeniv").value;
                type = document.getElementById("inputType").value;
                niv = document.getElementById("inputNiv").value;
                tarif = document.getElementById("inputTarif").value;
                course = document.getElementById("selectCourse").value;

                if(fname === ""){
                    alert("First Name Connot Be Empty");
                    isEmpty = true;
                }
                else if(lname === ""){
                    alert("Last Name Connot Be Empty");
                    isEmpty = true;
                }
                else if(age === ""){
                    alert("Age Connot Be Empty");
                    isEmpty = true;
                }
                else if(asso === ""){
                    alert("Age Connot Be Empty");
                    isEmpty = true;
                }
                else if(date === ""){
                    alert("Age Connot Be Empty");
                    isEmpty = true;
                }
                return isEmpty;
            }

            // Quand on clique sur la ligne correspondante
            function selectedRowToInput()
            {
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                        // récupère la ligne selectionnée
                        rIndex = this.rowIndex;
                        document.getElementById("inputId").value = this.cells[0].innerHTML;
                        document.getElementById("changerId").value = this.cells[0].innerHTML;
                        document.getElementById("deleteId").value = this.cells[0].innerHTML;
                        document.getElementById("AjouterId").value = this.cells[0].innerHTML;
                        document.getElementById("inputName").value = this.cells[1].innerHTML;
                        document.getElementById("inputDate").value = this.cells[2].innerHTML;
                        document.getElementById("inputHeure").value = this.cells[3].innerHTML;
                        document.getElementById("inputLg").value = this.cells[4].innerHTML;
                        document.getElementById("inputDeniv").value = this.cells[5].innerHTML;
                        document.getElementById("inputType").value = this.cells[6].innerHTML;
                        document.getElementById("inputNiv").value = this.cells[7].innerHTML;
                        document.getElementById("inputTarif").value = this.cells[8].innerHTML;
                        //ouvre le menu modal
                        $('#exampleModalCenter').modal('show');
                    };
                }
            }
            selectedRowToInput();
        </script>
    </body>
</html>
