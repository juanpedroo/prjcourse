<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Connection</title>

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
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>
<body class="text-center">
    <!-- Connection à la bd -->

    <!-- Formulaire de connection -->
    <form name = "form_login" class="form-signin" method="post" action="connection.php">
        <img class="mb-4" src="bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Veuillez vous connecter</h1>
        <label for="inputEmail" class="sr-only">Adresse mail</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Adresse mail" required autofocus>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required>
        <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Se souvenir de moi
        </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name = "submit">Se connecter</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
    </form>
    <?php
        //session_start();
        include('./includes/connect.inc');
        $idc = connect();
        if (isset($_REQUEST['submit'])) //here give the name of your button on which you would like    //to perform action.
        {
            // here check the submitted text box for null value by giving there name.
            if($_REQUEST['email']=="" || $_REQUEST['password']=="")
            {
                echo " Veuillez remplir les champs";
            }
            else
            {
                $sql1= "select * from individu where mail_p= '".$_REQUEST['email']."' AND mdp_p = crypt('".$_REQUEST['password']."',mdp_p)";
                $result=pg_query($idc,$sql1);
                $num_rows=pg_num_rows($result);
                if($num_rows>0)
                {
                    // Connecté
                    header('Location: accueil.php');
                    exit();
                }
                // Pb connection
                else
                {
                    $sql2= "select * from individu where mail_p = '".$_REQUEST['email']."'";
                    $result=pg_query($idc,$sql2);
                    $num_rows=pg_num_rows($result);
                    if($num_rows>0)
                    {
                        // Bon mail donc mauvais mdp
                        // echo "<label for='inputPassword' class='sr-only'>Mot de passe</label>";
                        // echo "<input type='password' name='password' id='inputPassword' class='form-control is-invalid' placeholder='Mot de passe' required>";
                        header('Location: connection_mauvaismdp.php');
                    }
                    else
                    {
                        // Mauvais mail
                        echo "<label for='inputEmail' class='sr-only'>Adresse mail</label>";
                        echo "<input type='email' name='email' id='inputEmail' class='form-control is-invalid' placeholder='Adresse mail' required autofocus>";
                    }
                    // Erreur identifiants
                }
            }
        }
    ?>
</body>
</html>
