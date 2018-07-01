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

    if(empty($_SESSION['idproy'])){
        header('location: tambahpekerjaan.php');
    }

    if(isset($_GET['perlu'])){
        $_SESSION['perlu']=$_GET['perlu'];
        $_SESSION['namapekerjaan']=$_GET['nama'];
    }
    if(isset($_SESSION['perlu'])){
        $_GET['perlu']=$_SESSION['perlu'];
        $_GET['nama']=$_SESSION['namapekerjaan'];
    }
    else{
        header('Location: tambahpekerjaan.php');
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

    if(isset($_GET['delete'])){
        $sql='DELETE FROM  `rencanaanggaranpelaksanaan` where id='.$_GET['delete'];
        if($a->query($sql)){
            header('Location: buatkeperluan.php');
        }
        else{
            echo "<script>alert('tidak berhasil menghapus data');</script>";
        }
    }

    if(isset($_POST['btnTambahKeperluan'])){
        if(!empty($_POST['txtnamaalat'])){
        $temp=explode('(',rtrim( $_POST['txtnamaalat'],')'));
        $kodekeperluan=$temp[1];
        
            $sql = "SELECT harga FROM alat_daftaralat a inner join daftaralat d on a.iddaftaralat=d.id where idproyek=".$_SESSION['idproy']." and kodealat='".$kodekeperluan."'";

            $hasil = $a->query($sql);
            if($hasil->num_rows>0){
                while ($row = $hasil->fetch_assoc()) {
                 $harga=$row['harga'];
                }
            }
        }
          if(!empty($_POST['txtnamaupah'])){
        $temp=explode('(',rtrim( $_POST['txtnamaupah'],')'));
        $kodekeperluan=$temp[1];
        
             $sql = "SELECT harga FROM upah_daftarupah a inner join daftarupah d on a.iddaftarupah=d.id where idproyek=".$_SESSION['idproy']." and kodeupah='".$kodekeperluan."'";

        $hasil = $a->query($sql);
        if($hasil->num_rows>0){
            while ($row = $hasil->fetch_assoc()) {
                $harga=$row['harga'];
            }
        }

        }
        if(!empty($_POST['txtnamamaterial'])){
        $temp=explode('(',rtrim( $_POST['txtnamamaterial'],')'));
        $kodekeperluan=$temp[1];
        
        $sql = "SELECT harga FROM material_daftarmaterial a inner join daftarmaterial d on a.iddaftarmaterial=d.id where idproyek=".$_SESSION['idproy']." and kode='".$kodekeperluan."'";

        $hasil = $a->query($sql);
      
        if($hasil->num_rows>0){
            while ($row = $hasil->fetch_assoc()) {
                $harga=$row['harga'];
            }
        }
        }

        //cek jumlah
        if(!empty($_POST['txtjumlahalat']))
            $jumlah = $_POST['txtjumlahalat'];
        else if(!empty($_POST['txtjumlahupah']))
            $jumlah = $_POST['txtjumlahupah'];
        else
            $jumlah = $_POST['txtjumlahmaterial'];
       // $temp2=explode(")", string)

   
       // echo $sql."<br>";

                //$kodebaru = $row['kodeakhir'] + 1;
                //$nama = $_POST['txtPekerjaan'];
                
                $idproyek = $_SESSION['idproy'];
                $jenis=$_POST['cbojenis'];
                $idbiaya=1;
                $idpekerjaan=$_SESSION['perlu'];
                $proy=$_SESSION['idproy'];
                
                //tambah pekerjaan
                $ins = $a->prepare('INSERT INTO `rencanaanggaranpelaksanaan`(`rencanavolume`, `rencanahargasatuan`, `idbiaya`, `idpekerjaan`, `iduser`, `idproyek`, `idkeperluan`, `mingguke`) VALUES (?,?,?,?,?,?,?,?)');

                $ins2 = 'INSERT INTO `rencanaanggaranpelaksanaan`(`rencanavolume`, `rencanahargasatuan`, `idpekerjaan`, `iduser`, `idproyek`, `idkeperluan`, `mingguke`) VALUES ('.$jumlah.','.$harga.',"'.$idpekerjaan.'",1,'.$proy.',"'.$kodekeperluan.'",1)';
                if($a->query($ins2)){

                 //echo $jumlah."\N ".$harga." ".$idbiaya." ".$idpekerjaan." ".$idbiaya." ".$proy." ".$kodekeperluan;
                }else{
                    echo $ins2;
                }
                // exit();
               // $ins->bind_param('iissiisi', $jumlah, $harga, $idbiaya, $idpekerjaan, $idbiaya, $proy, $kodekeperluan, $idbiaya);
               // $ins->execute();

               
                // header('Location:buatkeperluan.php');
    }

    $_SESSION['halaman']='buatkeperluan';
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
   /*.frmSearch {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}*/

   /*searchajax*/
    #country-list{float:left;list-style:none;margin:0;padding:0;width:190px;}
    #country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
    #country-list li:hover{background:#F0F0F0;}
    /*#search-box{padding: 10px;border: #F0F0F0 1px solid;}*/
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
                            Tambah Keperluan
                        </h1>

                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
<!-- 
                            <form method="post" action="tambahpekerjaan.php">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label >Pilih Proyek : </label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name='cboproyek'> -->
                                           
                                            <?php
                                                // $sql = "SELECT * FROM proyek WHERE status_rab = 0";
                                                // $hasil = $a->query($sql);
                                                // if($hasil->num_rows > 0){
                                                //     while ($row = $hasil->fetch_assoc()) {
                                                //         if(isset($_SESSION['idproy'])){
                                                //             if($row['id'] == $_SESSION['idproy']){
                                                //                 echo "<option value='".$row['id']."' selected>".$row['nama']."</option>";
                                                //             }
                                                //             else{
                                                //                 echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                                                //             }
                                                //         }
                                                //         else{
                                                //             echo "<option value='".$row['id']."'>".$row['nama']."</option>";
                                                //         }
                                                //     }
                                                // }
                                            ?>
                                       <!--  </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="btnPilihProyek" class="btn btn-primary form-control" value="Tampilkan">
                                    </div>
                                </div>
                            </form> -->


                            <!-- tampilkan pekerjaan -->
                            <form action="buatkeperluan.php" method="post">
                                <h2 style="text-align: center; margin-top: 2em; margin-bottom: 1em;">
                                    <?php 
                                        if(isset($_SESSION['idproy'])){
                                            echo "Proyek ".$_SESSION['namaproyek'];
                                        }  
                                    ?>
                                </h2>
                                
                                <h4 style="text-align: center; margin-top: 2em; margin-bottom: 1em;">
                                     <?php 
                                        if(isset($_GET['nama'])){
                                            echo $_GET['nama'];
                                        }
                                        ?>
                                </h4>
                                <br>
                                <div class='row'>
                                    <div class='col-md-8'>
                                <select name="cbojenis" id="cbojenis" onchange="bukaKeperluan()" class="form-control">
                                    <option value="">Pilih Jenis</option>
                                    <option value="alat">Alat</option>
                                    <option value="material">Material</option>
                                    <option value="upah">Upah</option>
                                </select>
                                </div>
                                </div>
                                <div id='divAlat'>
                                <div class="row">
                                    <div class="col-md-4">
                                         
                                        
                                        <label>nama:</label>
                                        <div class="frmSearch">
                                        <input type="text" id="search-boxalat" placeholder="Nama alat" name="txtnamaalat" class='form-control form' />
                                        <div id="suggesstion-boxalat"></div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <!-- <input type="text" name="txtPekerjaan" class="form form-control" style="" placeholder="Masukkan nama pekerjaan"> -->
                                        <label>jumlah</label>
                                         <input type="number" name="txtjumlahalat" class="form form-control" min="1">
                                    </div>
                                </div>
                                </div>


                                <div id='divUpah'>
                                <div class="row">
                                    <div class="col-md-4">
                                         
                                        
                                        <label>nama:</label>
                                        <div class="frmSearch">
                                        <input type="text" id="search-boxupah" placeholder="Nama upah" name="txtnamaupah" class='form-control form' />
                                        <div id="suggesstion-boxupah"></div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <!-- <input type="text" name="txtPekerjaan" class="form form-control" style="" placeholder="Masukkan nama pekerjaan"> -->
                                        <label>jumlah</label>
                                         <input type="number" name="txtjumlahupah" class="form form-control" min="1">
                                    </div>
                                </div>
                                </div>


                                <div id='divMaterial'>
                                <div class="row">
                                    <div class="col-md-4">
                                         
                                        
                                        <label>nama:</label>
                                        <div class="frmSearch">
                                        <input type="text" id="search-boxmaterial" placeholder="Nama material" name="txtnamamaterial" class='form-control form' />
                                        <div id="suggesstion-boxmaterial"></div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <!-- <input type="text" name="txtPekerjaan" class="form form-control" style="" placeholder="Masukkan nama pekerjaan"> -->
                                        <label>jumlah</label>
                                         <input type="number" name="txtjumlahmaterial" class="form form-control" min="1">
                                    </div>
                                </div>
                                </div>
                                <!-- <div class="row"> -->
                         <!--            <div class="col-md-2">
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
                                </div> -->
                                <input type="submit" value="Tambah" name="btnTambahKeperluan" class="btn btn-primary form-control" style="margin-left: 40%; margin-top: 1em; margin-bottom: 3em; width:20%;">
                            </form>

                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>Jenis</th>
                                                <th>Nama Keperluan</th>
                                                <th>jumlah</th>
                                                <th>hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                if(isset($_SESSION['idproy'])){
                                                   $sql = "SELECT id, nama, rencanavolume from rencanaanggaranpelaksanaan r, alat a where idproyek=".$_SESSION['idproy']." and idpekerjaan='".$_GET['perlu']."' and r.idkeperluan=a.kode";
                                                   
                                                    $hasil = $a->query($sql);
                                                    if($hasil->num_rows>0){
                                                        while ($row = $hasil->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>".$no."</td>";
                                                            echo "<td>Alat</td>";
                                                            echo "<td>".$row['nama']."</td>";
                                                            echo "<td>".$row['rencanavolume']."</td>";
                                                            echo "<td><a onclick=\"return confirm('Apakah anda yakin ingin menghapus pekerjaan ini?')\" href='buatkeperluan.php?delete=".$row['id']."'><button>hapus</button></a></td>";
                                                            echo "</tr>";
                                                            $no++;
                                                        }
                                                    }

                                                    $sql = "SELECT id, nama, rencanavolume from rencanaanggaranpelaksanaan r, material m where idproyek=".$_SESSION['idproy']." and idpekerjaan='".$_GET['perlu']."' and r.idkeperluan=m.kode";
                                                    $hasil = $a->query($sql);
                                                    if($hasil->num_rows>0){
                                                        while ($row = $hasil->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>".$no."</td>";
                                                            echo "<td>Material</td>";
                                                            echo "<td>".$row['nama']."</td>";
                                                            echo "<td>".$row['rencanavolume']."</td>";
                                                            echo "<td><a onclick=\"return confirm('Apakah anda yakin ingin menghapus pekerjaan ini?')\" href='buatkeperluan.php?delete=".$row['id']."'><button>hapus</button></a></td>";
                                                            echo "</tr>";
                                                            $no++;
                                                        }
                                                    }

                                                    $sql = "SELECT id, nama, rencanavolume from rencanaanggaranpelaksanaan r, upah u where idproyek=".$_SESSION['idproy']." and idpekerjaan='".$_GET['perlu']."' and r.idkeperluan=u.kode";
                                                    $hasil = $a->query($sql);
                                                    if($hasil->num_rows>0){
                                                        while ($row = $hasil->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>".$no."</td>";
                                                            echo "<td>Upah</td>";
                                                            echo "<td>".$row['nama']."</td>";
                                                            echo "<td>".$row['rencanavolume']."</td>";
                                                            echo "<td><a href='buatkeperluan.php?delete=".$row['id']."'><button>hapus</button></a></td>";
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

                        <form action='tambahpekerjaan.php' method='post'>
                            <input type="submit" value="Simpan" name="btnTambahKeperluan" class="btn btn-primary form-control" style="margin-left: 40%; margin-top: 1em; margin-bottom: 3em; width:20%;">
                        </form>

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
       function bukaKeperluan(){
        var apa = document.getElementById('cbojenis');
       // $('#tabelkeperluan tbody tr').remove();

        if(apa.value == "alat"){
            $('#divAlat').show();
            $('#divMaterial').hide();
            $('#divUpah').hide();
            $('#btnSimpanKeperluan').show();
        }
        else if(apa.value == "material"){
           $('#divMaterial').show();
           $('#divAlat').hide();
           $('#divUpah').hide();
           $('#btnSimpanKeperluan').show();
        }
        else if(apa.value == "upah"){
            $('#divUpah').show();
            $('#divAlat').hide();
            $('#divMaterial').hide();
            $('#btnSimpanKeperluan').show();
        }
        else{
            $('#divAlat').hide();
            $('#divMaterial').hide();
            $('#divUpah').hide();
            $('#btnSimpanKeperluan').hide();
        }
    }

        $(document).ready(function(){
            $('#divAlat').hide();
        $('#divMaterial').hide();
        $('#divUpah').hide();

            $("#search-boxalat").keyup(function(){
                $.ajax({
                type: "POST",
                url: "readKeperluan.php",
                data:'keywordalat='+$(this).val(),
                beforeSend: function(){
                    $("#search-boxalat").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-boxalat").show();
                    $("#suggesstion-boxalat").html(data);
                    $("#search-boxalat").css("background","#FFF");
                }
                });
            });


            $("#search-boxmaterial").keyup(function(){
                //alert($(this).val());
                $.ajax({
                type: "POST",
                url: "readKeperluan.php",
                data:'keywordmaterial='+$(this).val(),
                beforeSend: function(){
                    $("#search-boxmaterial").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-boxmaterial").show();
                    $("#suggesstion-boxmaterial").html(data);
                    $("#search-boxmaterial").css("background","#FFF");
                }
                });
            });

            $("#search-boxupah").keyup(function(){
               // alert($(this).val());
                $.ajax({
                type: "POST",
                url: "readKeperluan.php",
                data:'keywordupah='+$(this).val(),
                beforeSend: function(){
                    $("#search-boxupah").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggesstion-boxupah").show();
                    $("#suggesstion-boxupah").html(data);
                    $("#search-boxupah").css("background","#FFF");
                }
                });
            });


        });

        function selectCountry(val) {

            $("#search-boxalat").val(val);
            $("#suggesstion-boxalat").hide();

            $("#search-boxupah").val(val);
            $("#suggesstion-boxupah").hide();

            $("#search-boxmaterial").val(val);
            $("#suggesstion-boxmaterial").hide();
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
