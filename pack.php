<?php
include("src/Packer.php");

//declaration des boites a empaqueter
$boxes = null;
$brut_boxes = null;
$container = null;
$others = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	foreach($_POST['l'] as $k => $v){
		if(is_numeric($v)){
			$w=0; if(is_numeric($_POST['w'][$k])) $w=$_POST['w'][$k];
			$h=0; if(is_numeric($_POST['h'][$k])) $h=$_POST['h'][$k];
			if($v*$w*$h>0){
				$brut_boxes[] = [$v,$w,$h];
			}
		}
	}
	foreach($brut_boxes as $i => $v){
		$boxes[] = ['length' => $v[0], 'width' => $v[1],'height' => $v[2]];
	}
	
}else if ($_SERVER["REQUEST_METHOD"] == "GET") {
	
	if(isset($_GET['c'])){
		//demo
		if($_GET['c']=="random"){
			$nbb=rand(3,10);
			for($i=0; $i<$nbb; $i++){
				$l=rand(1,25)-rand(0,1)*0.5; 
				$w=max(0.5,rand(1,$l)-rand(0,1)*0.5); 
				$h=max(0.5,rand(1,$w)-rand(0,1)*0.5);
				$brut_boxes[] = [$l, $w, $h];
			}
		}else{
			$boxes=unserialize(urldecode($_GET['c']));
			foreach($boxes as $box) 
				$brut_boxes[] = [$box['length'], $box['width'], $box['height']];
		}
	}
}

//declaration des boites a empaqueter
if($_POST['cl'] && $_POST['cw']){
	$container = ['length' => $_POST['cl'], 'width' => $_POST['cw'],'height' => 1];
}

if(!is_null($boxes)){
	// Initialize LAFFPack
	$lp = new Cloudstek\PhpLaff\Packer();

	// Start packing our nice boxes
	if(is_null($container)){
		$lp->pack($boxes);
	}else{
		$lp->pack($boxes, $container);
	}

	// Collect our stack and container details
	$c_size = $lp->get_container_dimensions();
	$c_volume = $lp->get_container_volume();
	$c_levels = $lp->get_levels();

	$ctnr = $c_size; 
	rsort($ctnr);
	$ctnr_volume = ceil($ctnr[0])*ceil($ctnr[1])*ceil($ctnr[2]);
	$ctnr_average = ceil(pow($ctnr_volume, 1/3));

	// Collect remaining boxes details
	$r_boxes = $lp->get_remaining_boxes();
	$r_volume = $lp->get_remaining_volume();
	$r_num_boxes = 0;
	if(is_array($r_boxes)) {
		foreach($r_boxes as $level)
			$r_num_boxes += count($level);
	}

	// Collect packed boxes details
	$p_boxes = $lp->get_packed_boxes();
	$p_volume = $lp->get_packed_volume();
	$p_num_boxes = 0;
	if(is_array($p_boxes)) {
		foreach($p_boxes as $level)
			$p_num_boxes += count($level);
	};
		
	// Calculate our waste
	$w_volume = $ctnr_volume - $p_volume;
	$w_percent = intval($ctnr_volume > 0 && $p_volume > 0 ? (($ctnr_volume - $p_volume) / $ctnr_volume) * 100 : 0);

	// calcul alternatives
	function mySort($a, $b) { return $a[4] - $b[4]; }

	if(is_null($container)){
		$min0=ceil($ctnr[0]); $min1=ceil($ctnr[1]); $min2=ceil($ctnr[2]); 
		
		for($i=$ctnr_average; $i<=$ctnr_average*2; $i++){
			for($j=1; $j<=$i; $j++){
				
				$other_lp = new Cloudstek\PhpLaff\Packer();
				$other_lp->pack($boxes, ['length' => $i, 'width' => $j,'height' => 0]);
				$other_lp_size = $other_lp->get_container_dimensions();
				rsort($other_lp_size);
				
				//si alternative interessante on garde
				$other0=ceil($other_lp_size[0]);
				$other1=ceil($other_lp_size[1]);
				$other2=ceil($other_lp_size[2]);
				if($other0<$min0 || $other1<$min1 || $other2<$min2){
					$tmp_lp_volume = $other0*$other1*$other2;
					$tmp_w_percent = intval($tmp_lp_volume > 0 && $p_volume > 0 ? (($tmp_lp_volume - $p_volume) / $tmp_lp_volume) * 100 : 0);
					$others[]=[$other0,$other1,$other2,$tmp_lp_volume,$tmp_w_percent];
					$min0=min($other0,$min0); $min1=min($other1,$min1); $min2=min($other2,$min2);
				}
			}
		}
		if(!is_null($others)){
			//$others=array_unique($others);
			uasort($others, 'mySort');
		}
	}
}

//view
require 'view/pack.tpl.php';