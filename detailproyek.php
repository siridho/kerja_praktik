<?php
session_start();
include('conn.php');

if(isset($_GET['idproy'])){
    $_SESSION['idproy']=$_GET['idproy'];
    $sql='select * from proyek WHERE id = '.$_GET['idproy'];
    $hasil=$a->query($sql);
    while ($baris=$hasil->fetch_assoc()) {
        $nama = $baris['nama'];
        $alamat = $baris['alamat'];
        $status_rab = $baris['status_rab'];
        $tgl_mulai = $baris['tgl_mulai'];
        $lamaproyek = $baris['lamaproyek'];
        $klien = $baris['klien'];
        $status = $baris['status'];
    }
}

if(isset($_POST['btnSelesai'])){
     $stat = 1;
        $sql=$a->prepare("update proyek set status=? WHERE id=".$_SESSION['idproy']);
        $sql->bind_param("i", $stat);
        $sql->execute();

        setcookie("suksesSelesaiProyek", "", time() + 1, "/");

        unset($_SESSION['idproy']);

        header('location: daftarproyek.php');
}

    $_SESSION['user']='homepusat';
    $_SESSION['halaman']='detailproyek';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Proyek</title>
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
                            Detail Proyek
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

                        <div class="row">
                                <div class="col-md-2">
                                    <label >Nama Proyek : </label>
                                </div>
                                <div class="col-md-10">
                                    <p class="form-control"><?php echo $nama; ?></p>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label >Alamat Proyek : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php echo $alamat; ?></p>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-2">
                                <label >Status RAB : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php
                                if($baris['status_rab']==0)
                                    echo "Belum Jadi";
                                    else
                                        echo "Sudah Jadi";
                                ?></p>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-2">
                                <label >Tanggal Mulai : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php echo $tgl_mulai; ?></p>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-2">
                                <label >Lama Proyek : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php echo $lamaproyek; ?></p>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-2">
                                <label >Klien : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php echo $klien; ?></p>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-md-2">
                                <label >Status Proyek : </label>
                            </div>
                            <div class="col-md-10">
                                <p class="form-control"><?php
                                    if($status==0)
                                        echo "Belum Selesai";
                                        else
                                            echo "Selesai";
                                ?></p>
                            </div>
                        </div><br>

                        <?php if($status==0){?>
                        <div class="row">
                                <div class="col-md-offset-5 col-md-2">
                                    <form action="detailproyek.php" method="post">
                                        <input type="submit" name="btnSelesai" class="btn btn-primary" value="Proyek Selesai">

                                    </form>
                                </div>
                            </div>
                        <?php } ?>

                            <br><hr><br>
                        <div class="row">
                            <div class="col-md-offset-3 col-md-2">
                                <a class="btn btn-default" href='mpdf/laporan/daftaralat.php?idproy=<?php echo $_GET['idproy']; ?>'>Daftar Alat</a>
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-default" href='mpdf/laporan/daftarupah.php?idproy=<?php echo $_GET['idproy']; ?>'>Daftar Upah</a>
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-default" href='mpdf/laporan/daftarmaterial.php?idproy=<?php echo $_GET['idproy']; ?>'>Daftar Material</a>
                            </div>
                        </div><br>
                    
                        <!-- table responsive -->
                        <div class="table-responsive">
                            <form method='post' action='daftarhargaalat.php'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Minggu</th>
                                            <th>Biaya</th>
                                            <th>Alat</th>
                                            <th>Material</th>
                                            <th>Upah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql='select distinct minggu from pengukuranprogresslapangan';
                                        $hasil=$a->query($sql);
                                        $itung=0;
                                        $idproy = $_GET['idproy'];

                                        while ($baris=$hasil->fetch_assoc()) {
                                            $minggu = $baris['minggu'];
                                            $string1='idproyek='.$idproy.'&minggu='.$minggu.'&det=biaya';
                                            $string2='idproyek='.$idproy.'&minggu='.$minggu.'&det=alat';
                                             $string3='idproyek='.$idproy.'&minggu='.$minggu.'&det=material';
                                            $string4='idproyek='.$idproy.'&minggu='.$minggu.'&det=upah';
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $baris['minggu']; ?></td>
                                                <td><a class='btn btn-default' href='mpdf/laporan/biayaperminggu.php?<?php echo $string1;?>'>Tampil</a></td>
                                                <td><a class='btn btn-default' href='mpdf/laporan/alatperminggu.php?<?php echo $string2;?>'>Tampil</a></td>
                                                <td><a class='btn btn-default' href='mpdf/laporan/materialperminggu.php?<?php echo $string3;?>'>Tampil</a></td>
                                                <td><a class='btn btn-default' href='mpdf/laporan/upahperminggu.php?<?php echo $string4;?>'>Tampil</a></td>
                                               
                                            </tr>
                                        <?php
                                        $itung++;
                                        $no++;
                                        $_SESSION['itung']=$itung;
                                    } ?>
                                       
                                    </tbody>
                                </table>
                               
                            </div>
                            <!-- end of table responsive -->

                            
                            
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
