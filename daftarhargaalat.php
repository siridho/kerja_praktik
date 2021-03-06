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

$sql='select nama from user where id='.$_SESSION['iduserlogin'];
$hasil=$a->query($sql);
while ($baris=$hasil->fetch_assoc()) {
    $namauserlogin = $baris['nama'];
}

if(isset($_POST['btnPilihProyek'])){
    $idproy = $_POST['cboproyek'];
    $_SESSION['idproy'] = $idproy;

    $sql='select nama from proyek where id='.$_SESSION['idproy'];
    $hasil=$a->query($sql);
    while ($baris=$hasil->fetch_assoc()) {
        $_SESSION['namaproyek'] = $baris['nama'];
    }    
}



if(isset($_POST['simpan'])){

    $sql='select count(id) as jum from daftaralat where nama like"%'.$_SESSION['namaproyek'].'%"';
    $hasil=$a->query($sql);
    while ($baris=$hasil->fetch_assoc()) {
        $jum = $baris['jum'];
    }
    
    if($jum==0){
        $sql='select id from proyek where nama="'.$_SESSION['namaproyek'].'"';
        $hasil=$a->query($sql);
        $namaproyek = $_SESSION['namaproyek'];
        while ($baris=$hasil->fetch_assoc()) {
            $tam=$baris['id'];
            $ins=$a->prepare('INSERT into daftaralat(`nama`,`idproyek`) values(?,?)');
            $ins->bind_param('si',$namaproyek,$tam);
            $ins->execute();
        }
    }
    else{
        $jum++;
        $namaproyek = $_SESSION['namaproyek'].'-'.$jum;

        $sql='select id from proyek where nama = "'.$_SESSION['namaproyek'].'"';
        $hasil=$a->query($sql);
        while ($baris=$hasil->fetch_assoc()) {
            $tam=$baris['id'];
            $ins=$a->prepare('INSERT into daftaralat(`nama`,`idproyek`) values(?,?)');
            $ins->bind_param('si',$namaproyek,$tam);
            $ins->execute();
        }
    }


    $sql = 'select id from daftaralat where nama="'.$_SESSION['namaproyek'].'"';
    $hasil = $a->query($sql);
    while ($baris = $hasil->fetch_assoc()) {
        $iddaftaralat = $baris['id'];
    }
    
    $itung = $_SESSION['itung'];

    for($i=0 ; $i<$itung ; $i++){
        $nam = 'hargaalat'.$i;
        
        if(isset($_POST[$nam])){
            $ko='kode'.$i;
            $harga=$_POST[$nam];
            $kode=$_POST[$ko];
            
            $ins=$a->prepare('INSERT INTO `alat_daftaralat`(`harga`, `kodealat`, `iddaftaralat`) VALUES (?,?,?)');
            $ins->bind_param('isi',$harga,$kode,$iddaftaralat);
            $ins->execute();
        }

    }

    header('Location:daftarhargaupah.php');
}
    $_SESSION['halaman']='daftarhargaalat';
    $_SESSION['user']='';
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
         <!-- <form method='post' action='daftarhargaalat.php'> -->
            <div id="page-inner">
             <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Buat Daftar Harga - Alat
                        </h1>
                        <ol class="breadcrumb">
                          <li class="active" style="color:red;">Daftar Harga Alat</li>
                          <li>Daftar Harga Upah</li>
                          <li>Daftar Harga Material</li>
                        </ol>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               

            <div class="row">
                <div class="col-md-12">
                  
                    
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="margin-bottom: 2em;">
                            <!-- <label>Nama proyek:</label> <input type='text' name='namaproyek' class='form-control' required> -->
                            <form method="post" action="daftarhargaalat.php">
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
                                        <input type="submit" name="btnPilihProyek" class="btn btn-primary form-control" value="Pilih">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <form method='post' action='daftarhargaalat.php'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Cek</th>
                                            <th>Kode</th>
                                            <th>Nama Alat</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql='select * from alat';
                                        $hasil=$a->query($sql);
                                        $itung=0;

                                        while ($baris=$hasil->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type='checkbox' class='form-control checkalat' name='cek<?php echo $baris['kode']; ?>' checked value='<?php echo $baris['kode'];?>'>
                                                 </td>
                                                <td><?php echo $baris['kode'];?></td>
                                                <td id='namapekerjaan<?php echo $baris['kode']; ?>'><?php echo $baris['nama'];?></td>
                                                <td id='satuanpekerjaan<?php echo $baris['kode']; ?>'><?php echo $baris['satuan'];?></td>
                                                <td>  <!-- <button class="btn btn-primary btn-lg openedit" data-toggle="modal" data-target="#myModaledit" id='btedit<?php echo $baris['kode']; ?>' value='<?php echo $baris['kode'];?>'>


                             Edit
                             <input type='hidden' name='edit' id='tan-<?php echo $itung; ?>' value='<?php echo $baris['kode'];?>'>
                            </button> -->

                            <input type='hidden' name='kode<?php echo $itung; ?>' value='<?php echo $baris['kode']; ?>'>
                           
                                <input type='text' required class='form-control hargaalat' name='hargaalat<?php echo $itung; ?>' id='<?php echo $baris['kode']; ?>' value='50000'>

                        </td>
                                            </tr>
                                        <?php
                                        $itung++;
                                        $_SESSION['itung']=$itung;
                                    } ?>
                                       
                                    </tbody>
                                </table>
                               
                            </div>
                            <!-- <BUAT DAFTAR>  -->

                            <br>
                            <div class="col-md-offset-5 col-md-2">
                                 <input type='submit' name='simpan' class="btn btn-primary form-control" value="Simpan" onclick="return confirm('Apakah anda yakin ingin menyimpan data ini?')">
                            </div>
                             

                                <!-- <AKHIR BUAT DAFTAR> -->
                            
                        </div>
                    </div>
                     
                    <!--End Advanced Tables -->
                </div>
       
      
            </div>

          <!-- /. ROW  -->

       
    
             <!-- /. PAGE INNER  -->
            </div>
     <!--  <input type='submit' name='simpan'> -->
                                </form>


       <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer>
    </div>


         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js">
            
    </script>
    <script type="text/javascript">

$(document).on('change', '.checkalat', function() {
    if(!this.checked){
        //  alert($(this).val());
        var k=$(this).val();
       // var idd='hargaalat'+k;
        document.getElementById(k).disabled=true;
      
    }
    else{
         var k=$(this).val();
         //var idd='hargaalat'+k;
        document.getElementById(k).disabled=false;
    }
   // alert($(this).val());

});



// $(document)on('change','hargaalat',function(){
//     document.getElementById();
// } );

//     $(document).on("click", ".openedit", function () {
//      var myBookId = $(this).val();
//      //$(".modal-body #coba").text( myBookId );
//      var aaa='namapekerjaan'+myBookId;
//      $('.modal-body #nama').val($('#namapekerjaan'+myBookId).text());
//      $('#kod').val(myBookId);
//      //document.getElementById('kod').value=='myBookId';
//     $('.modal-body #satuan').val($('#satuanpekerjaan'+myBookId).text());
//     //alert($('#kod').val());
//     return false;

// });

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
