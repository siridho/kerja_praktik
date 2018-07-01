<?php
    session_start();
    include('conn.php');
    session_unset();

    if(isset($_POST["txtemail"]) && isset($_POST["txtpassword"])){
        $txtemail = $_POST["txtemail"];
        $txtpassword = $_POST["txtpassword"];

        $sql = "SELECT email, password, id, level FROM user WHERE email='".$txtemail."'";
        $hasil = $a->query($sql);
        if($hasil->num_rows>0) {
            while($row = $hasil->fetch_assoc()) {
                $email = $row["email"];
                $password = $row["password"];
                $level = $row["level"];

                if($txtpassword == $password){ 

                    //cek role user !!!!!!!!!!!!!!!!
                    if($level == "Pusat"){
                        $_SESSION["iduserlogin"] = $row["id"];
                        header('location: homepusat.php');
                    }
                    else if($level == "Lapangan"){
                        $_SESSION["iduserlogin"] = $row["id"];
                        header('location: homelapangan.php');  
                    }
                    else if($level == "Admin"){
                        $_SESSION["iduserlogin"] = $row["id"];
                        header('location: homeadmin.php');  
                    }

                }
                else{
                    echo "<script>alert('passsword salah')</script>";
                }
            }
        }
        else{
            echo "<script>alert('email tidak terdaftar')</script>";
        }
    }
?>

<html>
<head>
    <title>Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
</head>
<body>

    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><i class="fa fa-gear"></i> <strong>LOGO</strong></a>
            </div>

        </nav>
        <!--/. NAV TOP  -->
    </div>
    <!-- end of wrapper -->


     <div class="col-md-offset-4 col-md-4" style="margin-top: 11em; border: solid white 3px; padding: 2em 4em 2em 4em;">
        <form role="form" action="index.php" method="post">
            <div class="form-header">
                <h3 style="text-align: center;">LOGIN</h3>
            </div><hr>
            <div class="form-group">
                <p><label>Email</label> <input class="form-control" type="email" name="txtemail" required></p>
                <p><label>Password</label> <input class="form-control" type="password" name="txtpassword" required></p>
                <p style="text-align: center;"><button class="btn btn-default" type="submit" >LOGIN</button></p>
            </div>
        </form>
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