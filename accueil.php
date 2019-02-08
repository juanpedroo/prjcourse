<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Navbar Dropdown Login and Signup Form with Social Buttons</title>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="styles/navbar.css">
<script src="lib/jquery/jquery-3.3.1.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>

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
        include 'includes/header.inc';

    ?>


</body>
</html>
