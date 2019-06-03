<?php
    //session_start();
    include('../include/connect.inc');
    $idc = connect();

    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['password']);

    if( isset($_POST['email']) && isset($_POST['password']) )
    {
		// Requête pour récupérer le mdp hashé de l'utilisateur
      	$res = pg_query_params($idc, "SELECT id_individu, mdp_p, prenom_p, organisateur FROM individu WHERE mail_p = $1", array($email));
      	$mdp_bdd = pg_fetch_all($res)[0]['mdp_p'];
		$prenom = pg_fetch_all($res)[0]['prenom_p'];
		$organisateur = pg_fetch_all($res)[0]['organisateur'];
		$individu = pg_fetch_all($res)[0]['id_individu'];

      	// Si un utilisateur a été trouvé avec ce login
      	if(!empty($mdp_bdd)){
      	  	// On vérifie si le mot de passe correspond
          	if (password_verify($mdp, $mdp_bdd)) {

			        session_start();
			        // Connecté
			        $_SESSION['email'] = $email;
			        $_SESSION['prenom'] = $prenom;
			        $_SESSION['organisateur'] = $organisateur;
			        $_SESSION['individu'] = $individu;
					$reponse = "ok";


			}
		}
     }
	// Pb connection
    else
    {
		$reponse = "ko";
	}

    echo json_encode(['reponse' => $reponse]);
?>
