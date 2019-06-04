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
            include("include/bootstrap.inc");
         ?>
        <!-- CSS -->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link rel="stylesheet" href="css/css_tableau.css"/>
        <link rel="stylesheet" href="css/navbar.css">
    </head>

    <body>
        <?php
            include('include/connect.php');
            $idc = connect();

            $selectid = "";
            $sql='SELECT id_p FROM parcours ORDER BY id_p desc';
            $rs=pg_exec($idc,$sql);
            $ligne=pg_fetch_assoc($rs);
            if (isset($_POST['inputId'])) {
                $selectid = $_POST['inputId'];
            } else {
                $selectid = $ligne['id_p'];
            }

            $sql="SELECT id_p, lieu, date_p, longueur_p FROM parcours WHERE id_p = $selectid";
            $rs=pg_exec($idc,$sql);
            $ligne=pg_fetch_assoc($rs);
            $lieup = $ligne['lieu'];
            $distancep = $ligne['longueur_p'];
            $datep = $ligne['date_p'];
        ?>

        <h3 class="display-5" style="color: #303030;text-align:center;">Selectionner une course</h3>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="align-items: center;">
                <form name="frm" action="affichage_resultats.php" method="post">
                    <div class="form-group row"  id="choixParcours">
                        <label for="inputId">Identifiant de la course</label>
                        <select class="form-control" id="inputId" name='inputId' >
                            <?php
                                $sql='SELECT id_p, lieu, longueur_p, date_p FROM parcours ORDER BY id_p';
                                $rs=pg_exec($idc,$sql);

                                while($ligne=pg_fetch_assoc($rs)){
                                    if($ligne['id_p'] != $selectid){
                                        print('<option value="'.$ligne['id_p'].'">'.$ligne['id_p'].' - '.$ligne['lieu'].' - '.$ligne['longueur_p'].'km - '.$ligne['date_p'].'</option>');
                                    }else{
                                        print('<option value="'.$ligne['id_p'].'" selected>'.$ligne['id_p'].' - '.$ligne['lieu'].' - '.$ligne['longueur_p'].'km - '.$ligne['date_p'].'</option>');
                                    };
                                }
                            ?>
                        </select>
                        <input type="submit" value="Voir les résultats" class="btn btn-info btn-sm" style="margin-top: 1%;">
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>

        <hr>

        <h3 class="display-5" style="color: #303030;text-align:center;">Résultat de la course:</h3>

        <br/>
        <?php
            echo ("<h5><b>Parcours n°".$selectid."</b> : ". $lieup." - ".$distancep."km - ".$datep."</h5>");
        ?>
        <div id="users">
            <input class="search" placeholder="Rechercher par nom ou dossard" />
            <table align="center">
                <tr>
                    <td class="classement"><b>Classement</b></td>
                    <td class="dossard"><b>N° Dossard</b></td>
                    <td class="name"><b>Nom Prénom</b></td>
                    <td class="chrono"><b>Chrono</b></td>
                </tr>
                <tbody class="list">
                    <?php
                        $sql="SELECT num_dossard, nom_p, prenom_p, chrono
                        FROM individu ind
                        INNER JOIN inscrits ins
                        ON ind.id_individu = ins.id_individu
                        INNER JOIN performe p
                        ON ins.id_inscrit = p.id_inscrit
                        WHERE id_p = $selectid.
                        ORDER BY chrono";
                        $rs=pg_exec($idc,$sql);
                        $classement = 1;
                        while($ligne=pg_fetch_assoc($rs)){
                                print('<tr>
                                <td class="classement">'.$classement.'</td>
                                <td class="dossard">'.$ligne['num_dossard'].'</td>
                                <td class="name">'.$ligne['nom_p'].' '.$ligne['prenom_p'].'</td>
                                <td class="Chrono">'.$ligne['chrono'].'</td>
                                </tr>'
                            );
                            $classement = $classement + 1;
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- List.js -->
        <?php include("include/list.js") ?>


        <!-- JavaScript -->
        <script type="text/javascript">
            var options = {
                valueNames: ['dossard', 'name']
            };
            var userList = new List('users', options);
        </script>

    </body>
</html>
