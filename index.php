<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Solidaria Bram</title>
		<?php
			include("include/bootstrap.inc")
		?>
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="css/navbar.css">
		<script type="text/javascript">
			// Prevent dropdown menu from closing when click inside the form
			$(document).on("click", ".navbar-right .dropdown-menu", function(e){
				e.stopPropagation();
			});
		</script>
	</head>
	<body>
	    <!-- Appel Navbar -->
	    <?php
	        session_start();
			header("Location: page_accueil.php");
			exit();
			//include('nav.php');

	    ?>


	</body>
</html>
