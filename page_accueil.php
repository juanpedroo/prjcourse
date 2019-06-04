<!DOCTYPE html>
<?php
	session_start();
	include 'include/header.inc';
?>
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
			$(document).on("click", ".navbar-right .dropdown-menu", function(e){
				e.stopPropagation();
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row marketing" style="margin-top: 5%;">
				<div class="col-lg-6">
					<img alt="affiche de la course" src="images/affiche_course.jpg" align="center" width="600px" height="780px" class="img-fluid">
				</div>
				<div class="col-lg-6">
					<h1 class="display-5" style="color: #303030">	Bienvenue dans cette nouvelle édition de Solidària Bram!</h1>
					<p class="lead" style="color: #585858;"> Nous sommes heureux de vous compter parmis nous.</br> Votre participation permet de financer différentes aides apportées aux enfants démunis.</br> L'association bram solidaire s'occupe de redistribuer l'argent à bon escient.</br> Toutes les actions de l'association sont consultables sur sa page visible en suivant ce lien:</p></p></p>
					<h3>Merci à tous!!<p class="lead" style="color: #585858;">Nous avons récolté 5000 euros depuis la 1ère édition!!</p></h3>
				</div>
			</div>
		</div>
	</body>
</html>
