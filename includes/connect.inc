<?php
	function connect(){
		$idc=pg_connect('host=localhost user=postgres password=postgres dbname=bd_projet_course');
		return($idc);
	}

	// function connect(){
	// 	$idc=pg_connect('host=postgresql-coursebram.alwaysdata.net user=coursebram_admin password=solidariabram dbname=coursebram_test');
	// 	return($idc);
	// }
?>
