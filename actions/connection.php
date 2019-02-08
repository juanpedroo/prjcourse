<?php
    echo " HELLO WORLD ";
    echo " <br>";
    //session_start();
    include('../includes/connect.inc');
    $idc = connect();
    echo $idc;
    if (isset($_REQUEST['submit'])) //here give the name of your button on which you would like    //to perform action.
    {
        echo "helpi";
        // here check the submitted text box for null value by giving there name.
        if($_REQUEST['email']=="" || $_REQUEST['password']=="")
        {
            echo "help";
            echo " Veuillez remplir les champs";
        }
        else
        {
            echo "test";
            $sql1= "select prenom_p, organisateur from individu where mail_p= '".$_REQUEST['email']."' AND mdp_p = crypt('".$_REQUEST['password']."',mdp_p)";
            $result=pg_query($idc,$sql1);
            while($ligne = pg_fetch_assoc($result)) {
                $prenom = $ligne['prenom_p'];
                $organisateur = $ligne['organisateur'];

            }
            $num_rows=pg_num_rows($result);
            if($num_rows>0)
            {
                // Connecté
                header('Location: ../accueil.php');

                session_start();
                $_SESSION['email'] = $_POST['email'];
		        $_SESSION['password'] = $_POST['password'];
                $_SESSION['prenom'] = $prenom;
                $_SESSION['organisateur'] = $organisateur;


            }
            // Pb connection
            else
            {
                echo "test";
                $sql2= "select * from individu where mail_p = '".$_REQUEST['email']."'";
                $result=pg_query($idc,$sql2);
                $num_rows=pg_num_rows($result);
                if($num_rows>0)
                {
                    echo "allo";
                    // Bon mail donc mauvais mdp
                    // echo "<label for='inputPassword' class='sr-only'>Mot de passe</label>";
                    // echo "<input type='password' name='password' id='inputPassword' class='form-control is-invalid' placeholder='Mot de passe' required>";
                    header('Location: connection_mauvaismdp.php');
                }
                else
                {
                    echo "test";
                    // Mauvais mail
                    echo "<label for='inputEmail' class='sr-only'>Adresse mail</label>";
                    echo "<input type='email' name='email' id='inputEmail' class='form-control is-invalid' placeholder='Adresse mail' required autofocus>";
                }
                // Erreur identifiants
            }
        }
        echo "oui";
    }
    else {
        echo "end";
    }

?>
