<?php
	session_start();
	include('conn.php');

	$arrayminggu = array();
	$arrayminggu = $_SESSION["minggu"];
	for($i=0 ; $i<sizeof($arrayminggu) ; $i++){
		for($j=0 ; $j<sizeof($arrayminggu[$i]) ; $j++){
			$mingguke = $i+1;
			$rencanavolumeprogress = $arrayminggu[$i][$j]['volume'];
			$iduser = 2;
			$idpekerjaan = $arrayminggu[$i][$j]['kode'];
			$idproyek = 13;

			$ins=$a->prepare('INSERT INTO `rencanapekerjaanprogres`(`mingguke`, `rencanavolumeprogress`, `iduser`, `idpekerjaan`, `idproyek`) VALUES (?,?,?,?,?)');
            $ins->bind_param('iiisi',$mingguke , $rencanavolumeprogress ,$iduser , $idpekerjaan , $idproyek);
            $ins->execute();
		}
	}

	header('Location: buatrab.php');

?>