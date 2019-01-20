<?php
	function connect(){
		$idc=pg_connect('host=localhost user=postgres password=postgres dbname=bd_projet_course');
		return($idc);
	}
?>
