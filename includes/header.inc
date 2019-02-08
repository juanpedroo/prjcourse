<?php
if (isset($_SESSION['email']) AND isset($_SESSION['password']) AND $_SESSION['organisateur'] == 't')
{
    echo '<nav class="navbar navbar-default navbar-expand-lg navbar-light">
    	<div class="navbar-header d-flex col">
    		<a class="navbar-brand" href="#">Solidaria<b>Bram</b></a>
    		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
    			<span class="navbar-toggler-icon"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    		</button>
    	</div>
    	<!-- Collection of nav links, forms, and other content for toggling -->
    	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    		<ul class="nav navbar-nav">
    			<li class="nav-item"><a href="accueil.php" class="nav-link">Accueil</a></li>
    			<li class="nav-item"><a href="association.php" class="nav-link">Association</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les parcours</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les résultats</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Informations utiles</a></li>
                <li class="nav-item dropdown">
    				<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Administration <b class="caret"></b></a>
    				<ul class="dropdown-menu">
    					<li><a href="#" class="dropdown-item">Option A</a></li>
    					<li><a href="#" class="dropdown-item">Option B</a></li>
    					<li><a href="#" class="dropdown-item">Option C</a></li>
    					<li><a href="#" class="dropdown-item">Choisir l\'association</a></li>
    				</ul>
    			</li>
    		</ul>
    		<ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Bienvenue '. $_SESSION["prenom"] .' </a>
                </li>
    			<li class="nav-item">
    				<a href="actions/deconnection.php" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">Déconnexion</a>
    			</li>
    		</ul>
    	</div>
    </nav>';
}
else if(isset($_SESSION['email']) AND isset($_SESSION['password']) AND $_SESSION['organisateur'] == 'f')
{
    echo '<nav class="navbar navbar-default navbar-expand-lg navbar-light">
    	<div class="navbar-header d-flex col">
    		<a class="navbar-brand" href="#">Solidaria<b>Bram</b></a>
    		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
    			<span class="navbar-toggler-icon"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    		</button>
    	</div>
    	<!-- Collection of nav links, forms, and other content for toggling -->
    	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    		<ul class="nav navbar-nav">
    			<li class="nav-item"><a href="accueil.php" class="nav-link">Accueil</a></li>
    			<li class="nav-item"><a href="association.php" class="nav-link">Association</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les parcours</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les résultats</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Informations utiles</a></li>
    		</ul>
    		<ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Bienvenue '. $_SESSION["prenom"] .' </a>
                </li>
    			<li class="nav-item">
    				<a href="actions/deconnection.php" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">Déconnexion</a>
    			</li>
    		</ul>
    	</div>
    </nav>';
}
else
{
    echo '<nav class="navbar navbar-default navbar-expand-lg navbar-light">
    	<div class="navbar-header d-flex col">
    		<a class="navbar-brand" href="#">Solidaria<b>Bram</b></a>
    		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
    			<span class="navbar-toggler-icon"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    		</button>
    	</div>
    	<!-- Collection of nav links, forms, and other content for toggling -->
    	<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
    		<ul class="nav navbar-nav">
    			<li class="nav-item"><a href="accueil.php" class="nav-link">Accueil</a></li>
    			<li class="nav-item"><a href="association.php" class="nav-link">Association</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les parcours</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Les résultats</a></li>
    			<li class="nav-item"><a href="#" class="nav-link">Informations utiles</a></li>
    		</ul>
    		<ul class="nav navbar-nav navbar-right ml-auto">
    			<li class="nav-item">
    				<a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Connexion</a>
    				<ul class="dropdown-menu form-wrapper">
    					<li>
    						<form action="actions/connection.php" method="post">
    							<div class="form-group">
    								<input type="email" name="email" class="form-control" placeholder="Adresse Mail" required="required">
    							</div>
    							<div class="form-group">
    								<input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required">
    							</div>
    							<input type="submit" name="submit" class="btn btn-primary btn-block" value="Connexion">
    							<div class="form-footer">
    								<a href="#">Mot de passe oublié ?</a>
    							</div>
    						</form>
    					</li>
    				</ul>
    			</li>
    			<li class="nav-item">
    				<a href="inscription.php" data-toggle="dropdown" class="btn btn-primary dropdown-toggle get-started-btn mt-1 mb-1">Inscription</a>
    			</li>
    		</ul>
    	</div>
    </nav>';
}
?>
