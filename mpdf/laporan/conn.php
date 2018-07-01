<?php
	$a = new mysqli("localhost", "root", "", "kp2");
	if($a->connect_errno) {
    	echo "Gagal connect ";
    }

?>