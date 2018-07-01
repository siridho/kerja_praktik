<?php
session_start();
include('conn.php');
 // setcookie("suksesbuatproyek", "" , time() -1000, "/");

if(isset($_POST['btnSubmit'])){
    $nama = $_POST['txtNama'];
    $alamat = $_POST['txtAlamat'];
    $lamaproyek = $_POST['txtLama'];
    $klien = $_POST['txtKlien'];
    $tgl_mulai = $_POST['txtTanggal'];


    // cek nama proyek sudah ada atau belum
    $sql='select count(id) as jum from proyek where nama="'.$nama.'"';
    $hasil=$a->query($sql);
    while ($baris=$hasil->fetch_assoc()) {
        $ju=$baris['jum'];
    }
    if($ju == 0){
        $ins = $a->prepare('INSERT INTO `proyek`(`nama`, `alamat`, `lamaproyek`, `klien`, `tgl_mulai`) VALUES (?,?,?,?,?)');
        $ins->bind_param('ssiss', $nama, $alamat, $lamaproyek, $klien, $tgl_mulai);
        $ins->execute();
        
        $cookie_name = "suksesbuatproyek";
        $cookie_value = "yes";
        setcookie($cookie_name, $cookie_value, time() + 1, "/");

        header('location: buatproyek.php');
    }
    else{
        echo "<script>Nama proyek sudah ada</script>";
    } 
}


    $_SESSION['user']='homepusat';
    $_SESSION['halaman']='buatproyek';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap Admin html Template : Master</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <?php require_once('master.php');?>
        <div id="page-wrapper" >
            <div id="page-inner">
             <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Buat Proyek
                        </h1>
                    </div>
            </div>

        <?php
            if(isset($_COOKIE['suksesbuatproyek'])) {
                echo '<div class="row">
                    <div class="alert alert-success">
                        <strong>Proyek berhasil ditambahkan!</strong>
                    </div> 
                </div>';
            }
        ?>
                 <!-- /. ROW  -->
               

            <div class="row">
                <div class="col-md-12">
                  
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">

                            <!-- tampilkan pekerjaan -->
                            <form action="buatproyek.php" method="post">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Nama Proyek : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="txtNama" class="form form-control" style="" placeholder="Masukkan nama proyek" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Alamat : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="txtAlamat" class="form form-control" style="" placeholder="Masukkan alamat proyek" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Klien : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="txtKlien" class="form form-control" style="" placeholder="Masukkan nama klien" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Lama Proyek : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" name="txtLama" class="form form-control" style="" placeholder="Masukkan lama proyek" required>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Tanggal Mulai : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="date" name="txtTanggal" class="form form-control" style="" placeholder="Masukkan tanggal mulai proyek" required>
                                    </div>
                                </div><br>
                                <input type="submit" value="Tambah" name="btnSubmit" class="btn btn-primary form-control" style="margin-left: 40%; margin-top: 1em; margin-bottom: 3em; width:20%;">
                            </form>
           
                            
                        </div>
                    </div>
                     
                    <!--End Advanced Tables -->
                </div>
       
      
            </div>

          <!-- /. ROW  -->

       
    
             <!-- /. PAGE INNER  -->
            </div>



       <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer>
    </div>


         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js">
            
    </script>
    <script type="text/javascript">

    </script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                // $('#dataTables-example').dataTable();
                $('#dataTables-example').dataTable( {
                  "lengthMenu": [ [ -1], [ "All"] ]
                });
            });
        </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
