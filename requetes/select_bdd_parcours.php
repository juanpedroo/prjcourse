<?php
	$selectid = $_POST['inputId'];


include('../include/connect.inc');
        $idc = connect();
        $sql='SELECT longueur_p  from parcours where id_p = '.$selectid.';';
        $rs=pg_exec($idc,$sql);


			while($ligne=pg_fetch_assoc($rs)){
	      print('<input type="text" class="form-control" id="inputLg" name="inputLg" value='.$ligne['longueur_p'].'>');
				$longueur = $ligne['longueur_p'];
			}

?>
