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
        <link rel="stylesheet" href="css/css_gestion_course.css">
        <style>
            .container{overflow: hidden}
            .tab{float: left;}
            .tab-2{margin-left: 50px}
            .tab-2 input{display: block;margin-bottom: 10px}
            tr{transition:all .25s ease-in-out}
            tr:hover{background-color:#EEE;cursor: pointer}
            #editDiv {	visibility : visible; border-width:1px;	}
            #flop {	visibility : hidden;	}
        </style>
    </head>

    <body>
        <?php
            include('./include/connect.php');
            $idc = connect();
        ?>

        <div class="container">
            <div class="row">
				<br/>
				<div class="col-md-12">
					<h3> Listes des courses:</h3>
				</div>
                <br/>
                <div class="col-md-12">
                    <table id="table" align="center" class="table table-bordered table-hover" style="width: 80%;">
                        <tr>
                            <th class="text-center">Identifiant de la course</th>
                            <th class="text-center">Nom de la course</th>
                            <th class="text-center">Infos course</th>
                            <th class="text-center">Association</th>
                            <th class="text-center">Date</th>
                        </tr>
                        <?php
                            $sql='SELECT course.id_course, nom_course, infos_course, date_jour, id_asso
                            FROM course
                            INNER JOIN profite
                            ON profite.id_course = course.id_course
                            ORDER BY id_course';
                            $rs=pg_exec($idc,$sql);
                            while($ligne=pg_fetch_assoc($rs)){
                                print('<tr>
                                <td class="idC">'.$ligne['id_course'].'</td>
                                <td class="name">'.$ligne['nom_course'].'</td>
                                <td class="infos">'.$ligne['infos_course'].'</td>
                                <td class="infos">'.$ligne['id_asso'].'</td>
                                <td class="infos">'.$ligne['date_jour'].'</td>
                                <td class="drawed"><input type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#ModalDelete" id="inputDelete" value="❌"></input></td>
                                </tr>'
                                );
                            }
                        ?>
                    </table>
                    <p style="font-style: italic;color:#33cabb;"> * cliquer sur une ligne du tableau pour modifier une course</p>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalInsert">
                        Ajouter une course
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
                            <form name="frm" action="requetes/update_bdd_course.php" method="POST">
                                <div class="col-md">
                                    <label for="fname">Identifiant de la Course</label>
                                    <input type="text" class="form-control" id="fname" name='fname' style="text-align:center" readonly>
                                </div>
                                <hr>
                                <div class="col-md">
                                    <label for="lname">Nom de la course</label>
                                    <input type="text" class="form-control" id="lname" name='lname' placeholder="La Solidaria Bram">
                                </div>
                                <div class="col-md">
                                    <label for="date">Date de la course</label>
                                    <input type="date" class="form-control" id="date" name='date' placeholder="2019-08-02">
                                </div>
                                <div class="col-md">
                                    <label for="asso">Association concernée</label>
                                    <select class="form-control" id="asso" name='asso' >
                                        <?php
                                            $sql='SELECT id_asso, nom_asso FROM association ORDER BY nom_asso';
                                            $rs=pg_exec($idc,$sql);

                                            while($ligne=pg_fetch_assoc($rs)){
                                                print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label for="age">Informations complémentaires:</label>
                                    <textarea class="form-control" rows="5" id="age" name='age'></textarea>
                                </div>
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


        <!-- Modal Insert -->
        <div class="modal fade" id="ModalInsert" tabindex="-1" role="dialog" aria-labelledby="ModalInsert" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter une course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        $sql='SELECT id_course FROM course ORDER BY id_course DESC';
                        $rs=pg_exec($idc,$sql);
                        $ligne=pg_fetch_assoc($rs);
                        $idcourse = $ligne['id_course'] + 1;
                    ?>
                    <div class="modal-body">
                        <div class="col-md">
                            <form name="frm" action="requetes/insert_bdd_course.php" method="POST">
                                <div class="col-md" style="margin-top: 5px;">
                                    <label for="inputId">Identifiant de la Course</label>
                                    <input type="text" class="form-control" id="inputId" name='inputId' value='<?php echo $idcourse ?>' style="text-align:center" readonly>
                                </div>
                                <hr>
                                <div class="col-md" style="margin-top: 5px;">
                                    <label for="inputLieu">Nom de la course</label>
                                    <input type="text" class="form-control" id="inputNomC" name='inputNomC' placeholder="La Solidaria Bram" style="text-align:center">
                                </div>
                                <div class="col-md" style="margin-top: 5px;">
                                    <label for="inputLieu">Date de la course</label>
                                    <input type="date" class="form-control" id="inputDate" name='inputDate' placeholder="2019-08-02" style="text-align:center">
                                </div>
                                <div class="col-md" style="margin-top: 5px;">
                                    <label for="inputId">Association concernée</label>
                                    <select class="form-control" id="inputIdAsso" name='inputIdAsso' >
                                        <?php
                                            $sql='SELECT id_asso, nom_asso FROM association ORDER BY nom_asso';
                                            $rs=pg_exec($idc,$sql);
                                            while($ligne=pg_fetch_assoc($rs)){
                                                print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md" style="margin-top: 5px;">
                                    <label for="comment">Informations complémentaires:</label>
                                    <textarea class="form-control" rows="5" id="inputInfos" name='inputInfos'></textarea>
                                </div>
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

        <!-- Modal suppression d'une course -->
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
                        <p>Vous êtes sur le point de supprimer la course !</p>
                        <form name="frm" action="requetes/delete_course.php" method="POST">
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
                fname = document.getElementById("fname").value,
                lname = document.getElementById("lname").value,
                age = document.getElementById("age").value;
                asso = document.getElementById("asso").value;
                date = document.getElementById("date").value;

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
                        document.getElementById("deleteId").value = this.cells[0].innerHTML;
                        document.getElementById("fname").value = this.cells[0].innerHTML;
                        document.getElementById("lname").value = this.cells[1].innerHTML;
                        document.getElementById("age").value = this.cells[2].innerHTML;
                        document.getElementById("asso").value = this.cells[3].innerHTML;
                        document.getElementById("date").value = this.cells[4].innerHTML;

                        //ouvre le menu modal
                        $('#exampleModalCenter').modal('show');
                    };
                }
            }
            selectedRowToInput();
        </script>
    </body>
</html>
