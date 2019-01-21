<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
</head>
<body>
    <form name = "form_select_asso" method="post" action="admin_asso_selected.php">
        <label for="inputEmail">Choix association</label>
        <SELECT NAME="zl_association">
        <?php
        include('./includes/connect.inc');
        $idc = connect();
        $sql = 'select id_asso, nom_asso from association';
        $rs = pg_exec($idc,$sql);
        while($ligne = pg_fetch_assoc($rs)) {
          print('<option value="'.$ligne['id_asso'].'">'.$ligne['nom_asso'].'</option>');
        }
        ?>
        </SELECT><BR>

        <button type="submit" name = "submit">Choisir</button>
    </form>

</body>
</html>
