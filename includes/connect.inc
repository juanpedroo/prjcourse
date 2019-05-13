<?php
	/* Maison * /
	// function connect(){
	// 	$idc=pg_connect('host=localhost user=postgres password=postgres dbname=coursebram');
	// 	return($idc);
	// }
	/* Web */
	// function connect(){
	// 	$idc=pg_connect('host=postgresql-coursebram.alwaysdata.net user=coursebram_admin password=solidariabram dbname=coursebram_test');
	// 	return($idc);
	// }
	/* IUT */
	function connect(){
		$idc=pg_connect('host=10.11.159.20 user=postgres password=postgres dbname=bd_projet_course');
		return($idc);
	}
?>
