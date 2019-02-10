<!DOCTYPE html>
<html>
<head>
<style>
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
</head>
<body>

    <?php
    $q = intval($_GET['q']);
    include('../includes/connect.inc');
    $idc = connect();
    $sql= "select nom_asso, adresse_asso, cp_asso, ville_asso, description_asso,
    tel_asso, nom_directeur_asso
    from association
    where id_asso = '".$q."'";

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
    pg_close($idc);
    ?>
</body>
</html>
