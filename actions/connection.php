<?php
    //session_start();
    include('../includes/connect.inc');
    $idc = connect();


    if( isset($_POST['email']) && isset($_POST['password']) )
    {
      
      $sql1= "select id_individu, prenom_p, organisateur from individu where mail_p= '".$_POST['email']."' AND mdp_p = crypt('".$_POST['password']."',mdp_p)";
      $result=pg_query($idc,$sql1);
      while($ligne = pg_fetch_assoc($result)) {
        $individu = $ligne['id_individu'];
        $prenom = $ligne['prenom_p'];
        $organisateur = $ligne['organisateur'];
      }
      $num_rows=pg_num_rows($result);
      if($num_rows>0)
      {
        session_start();
        // Connecté
        //header('Location: ../accueil.php');
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['prenom'] = $prenom;
        $_SESSION['organisateur'] = $organisateur;
        $_SESSION['individu'] = $individu;
        $reponse = "ok";
      }
      // Pb connection
      else
      {
        $reponse = "ko";
      }
    }
    echo json_encode(['reponse' => $reponse]);
?>
