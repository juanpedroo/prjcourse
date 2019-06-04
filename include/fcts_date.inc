<?php
	
	function jour_ang_fr($testj){
		if($testj == 0){
			$jour='Dimanche';
		}
		elseif($testj == 1){
			$jour='Lundi';
		}
		elseif($testj == 2){
			$jour='Mardi';
		}
		elseif($testj == 3){
			$jour='Mercredi';
		}
		elseif($testj == 4){
			$jour='Jeudi';
		}
		elseif($testj == 5){
			$jour='Vendredi';
		}
		elseif($testj== 6){
			$jour='Samedi';
		}
		return($jour);
	}


	function jour_fr_v2($numj){
		switch($numj){
			case 0:
				$nomj='Grosmanche'; break;
			case 1:
				$nomj='Landi'; break;
			case 2:
				$nomj='Maaardi'; break;
			case 3:
				$nomj='Credi'; break;
			case 4:
				$nomj='Jodi'; break;
			case 5:
				$nomj='Dredi'; break;
			case 6:
				$nomj='Samedi'; break;
		}
			
		return($nomj);
	}
	
	function jour_fr_v3($numj){
		$tab=array('Dimanch','Lund','Mard','Mercred','Jeud','Vendred','Samd');
		$nomj = $tab[$numj];
		return($nomj);
	}

	function mois_fr($numm){
		$tabm=array(1=>'Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
		$nomm = $tabm[$numm];
		return($nomm);
	}
	
	function date_ch2fr($date_ch){
		$t=explode('-',$date_ch);
		$dt_fr = $t[2].'/'.$t[1].'/'.$t[0];
		return($dt_fr);	
	}
	




?>


