<?php
session_start();
include('conn.php');

if(isset($_SESSION['iduserlogin'])){
    $sql='select * from user where id='.$_SESSION['iduserlogin'];
    $hasil=$a->query($sql);
    while ($baris=$hasil->fetch_assoc()) {
        $namauserlogin = $baris['nama'];
        $level = $baris['level'];
    }
}
else{
    header('location: index.php');
}

$_SESSION['user']='';
$_SESSION['halaman']='';

?>

<html>
<head>
    <title>Dashboard</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
</head>

<body>
    <div id="wrapper">
        <?php require_once('master.php');?>
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Dashboard 
                            <small>
                                ( <?php echo $level; ?> )
                            </small>
                        </h1>
                        <h3>Selamat datang, <?php echo $namauserlogin; ?></h3>
                    </div>
                </div>

				<footer>
                    <p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p>
				</footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
	 
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
	
	
	<script src="assets/js/easypiechart.js"></script>
	<script src="assets/js/easypiechart-data.js"></script>
	
	 <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>
	
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
 

</body>

</html>