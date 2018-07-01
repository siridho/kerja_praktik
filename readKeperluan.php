<?php
    session_start();
    include('conn.php');
 	if(empty($_SESSION['idproy'])){
        header('location: tambahpekerjaan.php');
    }
 	if(!empty($_POST["keywordalat"])) {
 	$sql = "SELECT a.nama as namaalat, a.kode as kodealat FROM daftaralat da INNER JOIN alat_daftaralat ada ON da.id=ada.iddaftaralat
 			INNER JOIN alat a ON ada.kodealat=a.kode WHERE da.idproyek=".$_SESSION['idproy']." AND (a.nama LIKE '%".$_POST["keywordalat"] . "%'  OR a.kode LIKE '%".$_POST["keywordalat"] . "%')  ORDER BY a.nama LIMIT 0,6";
    $hasil = $a->query($sql);
//echo $sql;

    
    	if($hasil->num_rows > 0){
?>
    		<ul id="country-list">
<?php
        	while ($row = $hasil->fetch_assoc()) {
?>			
				<li onClick="selectCountry('<?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?>');"><?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?></li>
<?php
        }
?>
        	</ul>
<?php
    	}  
    }

    if(!empty($_POST["keywordmaterial"])) {
    $sql = "SELECT m.nama as namaalat , m.kode as kodealat FROM daftarmaterial dm INNER JOIN material_daftarmaterial mdm ON dm.id=mdm.iddaftarmaterial INNER JOIN material m ON mdm.kode=m.kode WHERE dm.idproyek=".$_SESSION['idproy']." AND (m.nama LIKE '%".$_POST['keywordmaterial']."%' OR m.kode LIKE '%".$_POST['keywordmaterial']."%') ORDER BY m.nama LIMIT 0,6";
            //echo $sql;
    $hasil = $a->query($sql);
//echo $sql;

    
        if($hasil->num_rows > 0){
?>
            <ul id="country-list">
<?php
            while ($row = $hasil->fetch_assoc()) {
?>          
                <li onClick="selectCountry('<?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?>');"><?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?></li>
<?php
        }
?>
            </ul>
<?php
        }  
    }

    if(!empty($_POST["keywordupah"])) {
    $sql = "SELECT a.nama as namaalat, a.kode as kodealat FROM daftarupah da INNER JOIN upah_daftarupah ada ON da.id=ada.iddaftarupah
            INNER JOIN upah a ON ada.kodeupah=a.kode WHERE da.idproyek=".$_SESSION['idproy']." AND (a.nama LIKE '%".$_POST["keywordupah"] . "%'  OR a.kode LIKE '%".$_POST["keywordupah"] . "%')  ORDER BY a.nama LIMIT 0,6";
    $hasil = $a->query($sql);

//echo $sql;

    
        if($hasil->num_rows > 0){
?>
            <ul id="country-list">
<?php
            while ($row = $hasil->fetch_assoc()) {
?>          
                <li onClick="selectCountry('<?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?>');"><?php echo $row["namaalat"]." (".$row["kodealat"].")"; ?></li>
<?php
        }
?>
            </ul>
<?php
        }  
    }
 ?>