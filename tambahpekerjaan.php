<?php
    session_start();
    include('conn.php');
    //session_unset();

    if(isset($_POST['btnPilihProyek'])){
        $idproy = $_POST['cboproyek'];
        $_SESSION['idproy'] = $idproy;

        $sql = "SELECT * FROM proyek WHERE id = ".$_SESSION['idproy'];
        $hasil = $a->query($sql);
        if($hasil->num_rows > 0){
            while ($row = $hasil->fetch_assoc()) {
                $_SESSION['namaproyek'] = $row['nama'];
            }
        }
    }
    if(isset($_GET['delete'])){
        $sql='DELETE FROM proyek_pekerjaan where idproyek='.$_SESSION['idproy'].' and kodepekerjaan="'.$_GET['delete'].'"';
        //echo $sql;
         if( $a->query($sql)){
            header("Location: tambahpekerjaan.php");
         }
    }

    if(isset($_POST['btnTambahPekerjaan'])){
        $sql = "SELECT max(kode) as kodeakhir FROM pekerjaan";
        $hasil = $a->query($sql);
        if($hasil->num_rows>0){
            while ($row = $hasil->fetch_assoc()) {

                $kodebaru = $row['kodeakhir'] + 1;
                $nama = $_POST['txtPekerjaan'];
                $satuan = $_POST['txtSatuan'];

                //tambah pekerjaan
                $ins = $a->prepare('INSERT INTO `pekerjaan`(`kode`, `nama`, `satuan`) VALUES (?,?,?)');
                $ins->bind_param('sss', $kodebaru, $nama, $satuan);
                $ins->execute();

                $idproyek = $_SESSION['idproy'];
                $hasil = $_POST['txtHasil'];

                //tambah proyek_pekerjaan
                $ins = $a->prepare('INSERT INTO `proyek_pekerjaan`(`idproyek`, `kodepekerjaan`, `hasil`) VALUES (?,?,?)');
                $ins->bind_param('isi', $idproyek, $kodebaru, $hasil);
                $ins->execute();

                header("Location: tambahpekerjaan.php");
            }
        }
    }

    $_SESSION['halaman']='tambahpekerjaan';
    $_SESSION['user']='';
?>                                                                                                                                                                                                                                                                                                                                                                                          

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Jadwal</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <style type="text/css">
   .md-scroll-mask { position: initial;}
   .frmSearch {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}

   /*searchajax*/
    #country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
    #country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
    #country-list li:hover{background:#F0F0F0;}
    #search-box{padding: 10px;border: #F0F0F0 1px solid;}
    /*end of searchajax*/
   </style>
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
                            Tambah Pekerjaan
                        </h1>

                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <form method="post" action="tambahpekerjaan.php">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Pilih Proyek : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name='cboproyek'>
                                            <?php
                                                $sql = "SELECT * FROM proyek WHERE status_rab = 0";
                                                $hasil = $a->query($sql);
                                                if($hasil->num_rows > 0){
                                                    while ($row = $hasil->fetch_assoc()) {
                                                        if(isset($_SESSION['idproy'])){
                                                            if($row['id'] == $_SESSION['idproy']){
                                                                echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                                                            }
                                                            else{
                                                                echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                                                            }
                                                        }
                                                        else{
                                                            echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="btnPilihProyek" class="btn btn-primary form-control" value="Tampilkan">
                                    </div>
                                </div>
                            </form>


                            <!-- tampilkan pekerjaan -->
                            <form action="tambahpekerjaan.php" method="post">
                                <h2 style="text-align: center; margin-top: 2em; margin-bottom: 1em;">
                                    <?php 
                                        if(isset($_SESSION['idproy'])){
                                            echo "Proyek ".$_SESSION['namaproyek'];
                                        }  
                                    ?>
                                </h2>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Pekerjaan : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="txtPekerjaan" class="form form-control" style="" placeholder="Masukkan nama pekerjaan">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Hasil : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" name="txtHasil" class="form form-control" style="" placeholder="Masukkan hasil pekerjaan">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Satuan : </label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="txtSatuan" class="form form-control" style="" placeholder="Masukkan satuan pekerjaan">
                                    </div>
                                </div>
                                <input type="submit" value="Tambah" name="btnTambahPekerjaan" class="btn btn-primary form-control" style="margin-left: 40%; margin-top: 1em; margin-bottom: 3em; width:20%;">
                            </form>

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Pekerjaan</th>
                                                <th>Hasil</th>
                                                <th>Hapus</th>
                                                <th>Tambah Keperluan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                if(isset($_SESSION['idproy'])){
                                                    $sql = "SELECT hasil, kodepekerjaan from proyek_pekerjaan where idproyek = ".$_SESSION['idproy'];
                                                    $hasil = $a->query($sql);
                                                    if($hasil->num_rows>0){
                                                        while ($row = $hasil->fetch_assoc()) {
                                                            $sql2 = "SELECT p.nama as namapekerjaan, p.satuan as satuanpekerjaan from proyek_pekerjaan pp INNER JOIN pekerjaan p where p.kode = ".$row['kodepekerjaan'];
                                                            $hasil2 = $a->query($sql2);
                                                            if($hasil2->num_rows>0){
                                                                while ($row2 = $hasil2->fetch_assoc()) {
                                                                    $namapekerjaan = $row2['namapekerjaan'];
                                                                    $satuanpekerjaan = $row2['satuanpekerjaan'];
                                                                   
                                                                }
                                                            }
                                                            echo "<tr>";
                                                            echo "<td>".$no."</td>";
                                                            echo "<td>".$namapekerjaan."</td>";
                                                            echo "<td>".$row['hasil']." ".$satuanpekerjaan."</td>";
                                                            echo "<td><a onclick=\"return confirm('Apakah anda yakin ingin menghapus kelas ini?')\" href='tambahpekerjaan.php?delete=".$row['kodepekerjaan']."'><button>hapus</button></a></td>";
                                                            echo "<td><a href='buatkeperluan.php?perlu=".$row['kodepekerjaan']."&nama=".$namapekerjaan."'><button>Tambah Keperluan</button></a></td>";
                                                            echo "</tr>";
                                                            $no++;
                                                        }
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <!-- end of tampilkan pekerjaan -->

                        </div>
                    </div>
                    <!--End Advanced Tables -->

               <!--      <div class="frmSearch">
                        <input type="text" id="search-box" placeholder="Country Name" />
                        <div id="suggesstion-box"></div>
                    </div> -->


                </div>
            </div>
            


               <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer>
    </div>
             <!-- /. PAGE INNER  -->
            </div>

         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js">
            
    </script>
    <script type="text/javascript">
      
    </script>

     <script type="text/javascript">
       /*searchajax*/
        $(document).ready(function(){
            $("#search-box").keyup(function(){
                $.ajax({
                type: "POST",
                url: "readKeperluan.php",
                data:'keyword='+$(this).val(),
                beforeSend: function(){
                    $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background","#FFF");
                }
                });
            });
        });

        function selectCountry(val) {
            $("#search-box").val(val);
            $("#suggesstion-box").hide();
        }   
        // end of searchajax
    </script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"/>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
               
            });


    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
