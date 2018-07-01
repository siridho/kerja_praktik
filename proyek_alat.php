<?php
session_start();
include('conn.php');



    $_SESSION['user'] = 'homepusat';
    $_SESSION['halaman'] = 'proyek_alat';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Proyek - Daftar Alat</title>
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
                            Daftar Alat Proyek xxx
                        </h1>
                    </div>
            </div>
            <!-- /. ROW  -->
               

            <div class="row">
                <div class="col-md-12">
                  
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">

                        
                    
                        <!-- table responsive -->
                        <div class="table-responsive">
                            <form method='post' action='daftarhargaalat.php'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Minggu</th>
                                            <th>Biaya</th>
                                            <th>Jumlah n biaya Alat</th>
                                            <th>Bahan</th>
                                            <th>Upah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql='select ada.kodealat from alat_daftaralat ada INNER JOIN ';
                                        $hasil=$a->query($sql);
                                        $itung=0;

                                        while ($baris=$hasil->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $baris['id'];?></td>
                                                <td><?php echo $baris['nama'];?></td>
                                                <td><?php echo $baris['tgl_mulai'];?></td>
                                                <td><?php echo $baris['lamaproyek'];?></td>
                                                <td><?php echo $baris['klien'];?></td>
                                                <td><?php  if($baris['status']==0)
                                                echo "Belum Selesai";
                                                else
                                                    echo "Selesai";
                                                 ?></td>
                                                <td>
                                                    <a href='detailproyek.php?idproy=<?php echo $baris['id']; ?>'>Detail</a>
                                                </td>
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
