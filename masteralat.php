<?php
session_start();
include('conn.php');
 //$_SESSION['txt']=$_POST['txt'];

if(isset($_POST['btnmasuk'])){
    $kode=$_POST['kode'];
    $nama=$_POST['nama'];
    $satuan=$_POST['satuan'];

    $sql=$a->prepare('insert into alat(kode,nama,satuan) values(?,?,?)');
        $sql->bind_param('sss',$kode,$nama,$satuan);
        $sql->execute();

    echo "<script>alert('data telah disimpan')</script>";
}

$_SESSION['halaman']='masteralat';
$_SESSION['user']='homepusat';

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Master Alat</title>
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
                            Daftar Alat
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                              Tambah Alat
                            </button>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Satuan</th>
                                            <th>edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql='select * from alat';
                                        $hasil=$a->query($sql);
                                        $itung=1;

                                        while ($baris=$hasil->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $baris['kode'];?></td>
                                                <td id='namaalat<?php echo $baris['kode']; ?>'><?php echo $baris['nama'];?></td>
                                                <td id='satuanalat<?php echo $baris['kode']; ?>'><?php echo $baris['satuan'];?></td>
                                                <td>  <button class="btn btn-primary btn-lg openedit" data-toggle="modal" data-target="#myModaledit" id='btedit<?php echo $baris['kode']; ?>' value='<?php echo $baris['kode'];?>'>
                             Edit
                             <input type='hidden' name='edit' id='tan-<?php echo $itung; ?>' value='<?php echo $baris['kode'];?>'>
                            </button>
                        </td>
                                            </tr>
                                        <?php
                                    } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            
                <!-- /. ISI MODAL -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Tambah Alat</h4>
                                        </div>
                                        <div class="modal-body">
                                          <form method='post' action='masteralat.php'>
        <table>

            <tr class="form-group">
             
                <td>Kode:</td>
                <td><?php
               
              //  echo $_GET['tanda'];
               // echo $_REQUEST['tanda'];
                 
                 //echo $_SESSION['sessionStorage'];
                // $aaa=$_REQUEST['kko'];
             
                //          $sql='select * from alat where kode="'.$_REQUEST['tanda'].'"';
                //     $hasil=$a->query($sql);
                //     while ($baris=$hasil->fetch_assoc()) {
                //         $kod=$_POST['tanda'];
                //         echo $kod;
                //         $nama=$baris['nama'];
                //         $satuan=$baris['satuan'];
                //         echo "<input type='hidden' name='kode' value='".$kod."'>";
                //     }
                // }
                // else{
                    $sql='select max(kode) as kode from alat';
                    $hasil=$a->query($sql);
                    while ($baris=$hasil->fetch_assoc()) {
                        $kod=$baris['kode']+1;
                        echo $kod;
                        echo "<input type='hidden' name='kode' value='".$kod."'>";
                    //}
                }
                ?></td>
            </tr class="form-group">
                <tr>
                <td>Nama:</td>
                <td><input type='text' name='nama'  required class="form-control" ></td>
            </tr class="form-group">
                <tr>
                <td>Satuan:</td>
                <td><input type='text' name='satuan'  required class="form-control" ></td>
            </tr>
          
        </table>
    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type='submit' name='btnmasuk' class="btn btn-primary">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

    </div> <!-- AKHIR ISI MODAL -->

     <!-- /. ISI MODAL -->
                <div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Tambah Alat</h4>
                                        </div>
                                        <div class="modal-body">
                                          <form method='post' action='masteralat.php'>
        <table>

            <tr class="form-group">
             
                <td>Kode:</td>
                <td id='coba' ><?php
               
              //  echo $_GET['tanda'];
               // echo $_REQUEST['tanda'];
                 $nama='';$satuan='';
                 //echo $_SESSION['sessionStorage'];
                // $aaa=$_REQUEST['kko'];
             
                //          $sql='select * from alat where kode="'.$_REQUEST['tanda'].'"';
                //     $hasil=$a->query($sql);
                //     while ($baris=$hasil->fetch_assoc()) {
                //         $kod=$_POST['tanda'];
                //         echo $kod;
                //         $nama=$baris['nama'];
                //         $satuan=$baris['satuan'];
                //         echo "<input type='hidden' name='kode' value='".$kod."'>";
                //     }
                // }
                // else{
                    
                ?></td>
                <input type="hidden" name="kode" id="kode">
            </tr class="form-group">
                <tr>
                <td>Nama:</td>
                <td><input type='text' name='nama' id='nama' required class="form-control" value='<?php echo $nama;?>'></td>
            </tr class="form-group">
                <tr>
                <td>Satuan:</td>
                <td><input type='text' name='satuan' id='satuan' required class="form-control" value='<?php echo $satuan;?>'></td>
            </tr>
          
        </table>
    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <input type='submit' name='btnedit' class="btn btn-primary">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

    </div> <!-- AKHIR ISI MODAL -->
        
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
    //(document).ready(function(){
    //      function submitinfo(){
    //          //document.getElementById('kko').value = document.getElementById('tan').value;
    //          //var mboh=$("button[name='btedit']").val();

    //          $.ajax({
    //                         type: 'POST',
    //                         url: "masteralat.php",
                            
    //                         data: 'id=' +$('#btedit201').val();
                           
    //          //});
    //     });
    // }

    $(document).on("click", ".openedit", function () {
     var myBookId = $(this).val();
     $(".modal-body #coba").text( myBookId );
     var aaa='namaalat'+myBookId;
     $('.modal-body #nama').val($('#namaalat'+myBookId).text());
     $('modal-body #kode').val(myBookId);
    $('.modal-body #satuan').val($('#satuanalat'+myBookId).text());
    //      jQuery.ajax({
    //     url: 'masteralat.php',
    //     type: 'POST',
    //     data: {
    //         txt: myBookId,
    //     },
    //     dataType : 'json',
    //     success: function(data, textStatus, xhr) {
    //         console.log(data); // do with data e.g success message
    //     },
    //     error: function(xhr, textStatus, errorThrown) {
    //         console.log(textStatus.reponseText);
    //     }
    // });

    // alert(myBookId);
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});

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
                $('#dataTables-example').dataTable();
            });


//     </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
