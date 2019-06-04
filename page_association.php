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
		<title>Association</title>
		<?php
			include("include/bootstrap.inc")
		?>
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="css/navbar.css">
		<style>
			hr{
				border:         none;
				border-left:    1px solid hsla(200, 10%, 50%,50);
				height:         100vh;
				width:          1px;
			}
		</style>
		<script type="text/javascript">
			$(document).on("click", ".navbar-right .dropdown-menu", function(e){
				e.stopPropagation();
			});
		</script>
	</head>

	<body>
		<?php
			$nomassoc = "";
			$adrassoc = "";
			$cpassoc = "";
			$villeassoc = "";
			$descrassoc = "";
			$telassoc = "";
			$dirassoc = "";
			include('./include/connect.php');
			$idc = connect();

			$sql = 'select nom_asso, adresse_asso, cp_asso, ville_asso, description_asso, tel_asso, nom_directeur_asso from association';
			$resultat = pg_exec($idc, $sql);
			while($ligne = pg_fetch_assoc($resultat)) {
				$nomassoc = $ligne['nom_asso'];
				$adrassoc = $ligne['adresse_asso'];
				$cpassoc = $ligne['cp_asso'];
				$villeassoc = $ligne['ville_asso'];
				$descrassoc = $ligne['description_asso'];
				$telassoc = $ligne['tel_asso'];
				$dirassoc = $ligne['nom_directeur_asso'];
			}
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8">
					<div class="carousel slide" id="carousel-147768">
						<div class="carousel-inner"  style="margin-left: 12%; margin-top: 3%; margin-right:10%">
							<div class="carousel-item active">
								<img src="https://www.villedebram.fr/images/actualite/centrebourg.jpg" />
							</div>
							<a class="carousel-control-prev" href="#carousel-147768" data-slide="prev"><span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span></a> <a class="carousel-control-next" href="#carousel-147768" data-slide="next"><span class="carousel-control-next-icon"></span> <span class="sr-only">Next</span></a>
						</div>
						<div style="margin-left: 12%; margin-top: 4%; margin-right:10%">
							<h1 class="display-5" style="color: #303030">
								<?php echo $nomassoc;?>
							</h1>
							<div>
								<p style="color: #585858; font-size:110%;"> Cette année, c'est l'association <b><?php echo $nomassoc;?> </b> présidé par <b><?php echo $dirassoc ?></b> qui est la bénéficiaire de notre course.</br>
								Voici quelques mots laissés par l'association :</p>
								<blockquote class="blockquote">
									<p class="mb-0">
								<?php
									echo $descrassoc;
								?>
								</p>
								<footer class="blockquote-footer"> <?php echo $dirassoc ?>, <cite> Assemblée Générale de <?php echo $nomassoc;?> </cite></footer>
							</blockquote>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<hr>
				</div>
				<div class="col-md-3">
					<div class="card" style="width: 75%; margin-top: 6%;">
					<div class="card-header">
						<h3>Coordonnées</h3>
					</div>
					<ul class="list-group list-group-flush"  style="text-align: center; margin-top: 2%;">
						<li class="list-group-item"><b><?php echo $nomassoc; ?></b></li>
						<li class="list-group-item"><b>Adresse:</b> </br><?php echo $adrassoc; ?> </br> <?php echo $cpassoc. " - ". $villeassoc."<br>";?> </li>
						<li class="list-group-item"><b>Téléphone:</b> </br><?php echo $telassoc; ?></li>
						<li class="list-group-item"><b>Président:</b> </br><?php echo $dirassoc; ?></li>
					</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
