<?php
    session_start();
    include('conn.php');
    //session_unset();
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

if(isset($_SESSION['idproy'])){
    $sql = "SELECT * FROM proyek WHERE id = ".$_SESSION['idproy'];
        $hasil = $a->query($sql);
        if($hasil->num_rows > 0){
            while ($row = $hasil->fetch_assoc()) {
                $_SESSION['namaproyek'] = $row['nama'];
                $_SESSION['lamaproyek'] = $row['lamaproyek'];
            }
        }
    }

    if(isset($_POST['btnPilihProyek'])){
        $idproy = $_POST['cboproyek'];
        $_SESSION['idproy'] = $idproy;

        $sql = "SELECT * FROM proyek WHERE id = ".$_SESSION['idproy'];
        $hasil = $a->query($sql);
        if($hasil->num_rows > 0){
            while ($row = $hasil->fetch_assoc()) {
                $_SESSION['namaproyek'] = $row['nama'];
                $_SESSION['lamaproyek'] = $row['lamaproyek'];
            }
        }
    }

    if(isset($_POST['btnSimpanJadwal'])){
        $mulaihari = $_POST['txtMulai'];
        $lamahari = $_POST['txtLama'];
        $kodepekerjaan=$_POST['txtkodepekerjaan'];
    
        for($i=0;$i<sizeof($lamahari);$i++){
            $lam=$lamahari[$i];
            $mul=$mulaihari[$i];
            $kod=$kodepekerjaan[$i];
            
            $sql=$a->prepare("update proyek_pekerjaan set lamahari=?,mulaihari=? WHERE idproyek=".$_SESSION['idproy']." AND kodepekerjaan=?");
            $sql->bind_param("iis", $lam,$mul,$kod);
            $sql->execute();


        }

        
        if($_SESSION['lamaproyek']%7!=0)
        $jumminggu=($_SESSION['lamaproyek']/7)+1;
        else
        $jumminggu=$_SESSION['lamaproyek']/7;

        $jumminggu=floor($jumminggu);
           // echo $jumminggu.'<br>';
        for($i=0;$i<$jumminggu;$i++){
            $mingguawal=($i*7)+1;
            $mingguakhir=($i+1)*7;
            $sqlpekerjaan='SELECT * from proyek_pekerjaan where idproyek='.$_SESSION['idproy'].' and mulaihari between '.$mingguawal.' and '.$mingguakhir;
            $hasilpekerjaan=$a->query($sqlpekerjaan);
            //echo $sqlpekerjaan;

            while ($barispekerjaan=$hasilpekerjaan->fetch_assoc()) {
                $jumhari=$barispekerjaan['mulaihari']+$barispekerjaan['lamahari']-1;
                $mulaiminggu=$i+1;
                if($jumhari%7==0)
                    $minggupekerjaan=floor($jumhari/7);
                else
                    $minggupekerjaan=floor($jumhari/7)+1;

                //$itungminggu=
                   $mulai=$barispekerjaan['mulaihari']-1;
                $mingguke=$mulaiminggu;
                while($mingguke<=$minggupekerjaan){
                   // if($mingguke=$mulaiminggu)
                     
                    if($jumhari<=$mingguke*7)
                     $jumlahharidiminggu=$jumhari-$mulai;
                    else
                     $jumlahharidiminggu=($mingguke*7)-$mulai;
                    $mulai=$mingguke*7;

                   // echo $barispekerjaan['kodepekerjaan'].' perlu '.$jumlahharidiminggu.' hari di minggu '.$mingguke."<br>" ;

                    $sqlkeperluan='SELECT * from rencanaanggaranpelaksanaan where idpekerjaan="'.$barispekerjaan['kodepekerjaan'].'" and idproyek='.$_SESSION['idproy'];
                    $hasilkeperluan=$a->query($sqlkeperluan);
                     while ($bariskeperluan=$hasilkeperluan->fetch_assoc()) {
                         $ins = $a->prepare('INSERT INTO `pengukuranprogresslapangan`(`minggu`, `volumepengukuran`, `idpekerjaan`, `iduser`, `idproyek`, `idkeperluan`, `total`) VALUES (?,?,?,?,?,?,?)');
                            $volumepengukuran = round($bariskeperluan['rencanavolume']/$jumhari*$jumlahharidiminggu);
                            
                            $idpekerjaan = $bariskeperluan['idpekerjaan'];
                            $iduser = $_SESSION['iduserlogin'];
                            $idproyek = $_SESSION['idproy'];
                            $idkeperluan = $bariskeperluan['idkeperluan'];
                            $total = round( $bariskeperluan['rencanavolume'] / $jumhari * $jumlahharidiminggu * $bariskeperluan['rencanahargasatuan']);
                            $ins->bind_param('issiiss', $mingguke, $volumepengukuran, $idpekerjaan, $iduser, $idproyek, $idkeperluan, $total);
                            $ins->execute();
                    }

                    $mingguke++;
                }
              // echo $barispekerjaan['kodepekerjaan'].' perlu '.$minggupekerjaan.' minggu dari minggu ke'.$mulaiminggu.'<br>';
            }
///================================================================================================
             //while ($barispekerjaan=$hasilpekerjaan->fetch_assoc()) {
            //    // echo $jumhari.'<br>';
               //  $jumhari=$barispekerjaan['mulaihari']+$barispekerjaan['lamahari']-1;

            //     if($barispekerjaan['mulaihari']%7!=0)
            //     $mingguawal=floor($barispekerjaan['mulaihari']/7+1);
            //     else
            //     $mingguawal=floor($barispekerjaan['mulaihari']/7);
            //    // echo $mingguawal.' '.$mingguakhir.'<br>lalu';
            //     if($jumhari%7!=0)
            //     $mingguakhir=$jumhari/7+1;
            //     else
            //     $mingguakhir=$jumhari/7;

            //    // echo $mingguawal.' '.$mingguakhir.'<br>';




            //     // for($i=0;$i<$jumminggu;$i++){
            //         // if(($barispekerjaan['mulaihari'])>=(($i*7)+1) && ($barispekerjaan['lamahari']+$barispekerjaan['mulaihari']-1)<=($i+1)*7)
            //         // {
            //         $mulai=$barispekerjaan['mulaihari'];
            //         for($i=$mingguawal;$i<=$mingguakhir;$i++){
            //             if($jumhari<=$i*7){
            //                 $jumlahharidiminggu=$jumhari-$mulai+1;
            //             }
            //             else{
            //                 $jumlahharidiminggu=$i*7-$mulai;
            //             }
            //             $mulai=$i*7;
            //             echo 'jumlahharidiminggu='. $jumlahharidiminggu;
            //             $sqlkeperluan='SELECT * from rencanaanggaranpelaksanaan where idpekerjaan="'.$barispekerjaan['idpekerjaan'].'" and idproyek='.$_SESSION['idproy'];
            //             $hasilkeperluan=$a->query($sqlkeperluan);
            //             while ($bariskeperluan=$hasilkeperluan->fetch_assoc()) {
            //                 $ins = $a->prepare('INSERT INTO `pengukuranprogresslapangan`(`minggu`, `volumepengukuran`, `idpekerjaan`, `iduser`, `idproyek`, `idkeperluan`, `total`) VALUES (?,?,?,?,?,?,?)');
            //                 $volumepengukuran = $bariskeperluan['rencanavolume']/$jumhari*$jumlahharidiminggu;
            //                 $idpekerjaan = $bariskeperluan['idpekerjaan'];
            //                 $iduser = $_SESSION['iduserlogin'];
            //                 $idproyek = $_SESSION['idproy'];
            //                 $idkeperluan = $bariskeperluan['idkeperluan'];
            //                 $total = $bariskeperluan['rencanavolume'] / $jumhari * $jumlahharidiminggu * $bariskeperluan['rencanahargasatuan'];
            //                 $ins->bind_param('iisiisi', $i, $volumepengukuran, $idpekerjaan, $iduser, $idproyek, $idkeperluan, $total);
            //                 $ins->execute();
            //             }
            //          }
            //     // }
           //  }
            
        }



        $stat = 1;
        $sql=$a->prepare("update proyek set status_rab=? WHERE id=".$_SESSION['idproy']);
        $sql->bind_param("i", $stat);
        $sql->execute();

        setcookie("suksesaturjadwal", "", time() + 1, "/");

        unset($_SESSION['idproy']);

        header('location: aturjadwal.php');
    }

    $_SESSION['halaman']='aturjadwal';
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
                            Buat Jadwal Pekerjaan
                        </h1>

                    </div>
                </div> 
                 <!-- /. ROW  -->

                  <?php
            if(isset($_COOKIE['suksesaturjadwal'])) {
                echo '<div class="row">
                    <div class="alert alert-success">
                        <strong>Jadwal telah disimpan!</strong>
                    </div> 
                </div>';
            }
        ?>
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <form method="post" action="aturjadwal.php">
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
                                <h2 style="text-align: center; margin-top: 2em; margin-bottom: 1em;">
                                    <?php 
                                        if(isset($_SESSION['idproy'])){
                                            echo "Proyek ".$_SESSION['namaproyek'];
                                        }  
                                    ?>
                                </h2>
                                
                   
                           

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <form action="aturjadwal.php" method="post">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Pekerjaan</th>
                                                <th>Hasil</th>
                                                <th>Mulai Hari</th>
                                                <th>Lama Hari</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                if(isset($_SESSION['idproy'])){
                                                    $sql = "SELECT nama, kodepekerjaan, mulaihari, lamahari, satuan, hasil FROM `proyek_pekerjaan` pp INNER join pekerjaan p on pp.kodepekerjaan=p.kode  WHERE idproyek=".$_SESSION['idproy'];
                                                   // echo $sql;
                                                    $hasil = $a->query($sql);
                                                    $itung=0;
                                                    if($hasil->num_rows>0){
                                                        while ($row = $hasil->fetch_assoc()) {

                                                            echo "<tr><input type='hidden' name='txtkodepekerjaan[]' value='".$row['kodepekerjaan']."'>";
                                                            echo "<td>".$no."</td>";
                                                            echo "<td>".$row['nama']."</td>";
                                                            echo "<td>".$row['hasil']." ".$row['satuan']."</td>";
                                                            echo "<td><input value='".$row['mulaihari']."' type='number' name='txtMulai[]' class='form-control mulaihari'  id='mulaihari".$itung."'  min='1' max='".$_SESSION['lamaproyek']."'></td>";
                                                            echo "<td><input value='".$row['lamahari']."' type='number' name='txtLama[]' class='form-control lamahari' min='1'></td>";
                                                            echo "</tr>";
                                                            $no++;
                                                            $itung++;
                                                            $_SESSION['itung']=$itung;
                                                        }
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                    <br>
                                    <div class="col-md-offset-5 col-md-2">
                                        <input type="submit" name="btnSimpanJadwal" class="btn btn-primary form-control" value="Simpan" onclick="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
                                    </div>
                                    </form>
                            </div>

                        
                        <!-- end of tampilkan pekerjaan -->

                        </div>
                    </div>
                    <!--End Advanced Tables -->


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

        $(document).on('keyup', '.lamahari', function() {
            var isi = $(this).val();

            var lamaproy = <?php echo $_SESSION['lamaproyek']; ?>;
            // alert('lamaproyek = ' + lamaproy);

            var index = $( ".lamahari" ).index(this);
            var mulaihari = document.getElementById('mulaihari'+index);
            var max = lamaproy - mulaihari.value;
            
            
            // alert('max = ' + max);
            // alert('index = ' + index);
            // alert('lamahari = ' + lamahari);
            
            $(this).attr("max", max+1);
            //$(this).val(mulaihari.value);
            // alert('lamahari[index] = ' + lamahari);
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
