 <?php 

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

 ?>
    <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><i class="fa fa-gear"></i> <strong>PT CAI</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">   
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $namauserlogin; ?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun ini?')"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--/. NAV TOP  -->

        <nav class="navbar-default navbar-side" role="navigation">
        <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <?php if($_SESSION['user']=='homepusat'){?>
                        <a <?php if($_SESSION['halaman']=='') echo 'class="active-menu" ';  ?>
                         href="homepusat.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap"></i> Master<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a <?php if($_SESSION['halaman']=='masteralat') echo 'class="active-menu" ';  ?>href="masteralat.php">Master Alat</a>
                            </li>
                            <li>
                                <a <?php if($_SESSION['halaman']=='masterupah'){ echo 'class="active-menu"'; }?>  href="masterupah.php">Master Upah</a>
                            </li>
                            <li>
                                <a <?php if($_SESSION['halaman']=='mastermaterial'){ echo 'class="active-menu"'; }?> href="mastermaterial.php">Master Material</a>
                            </li>
                            <li>
                                <a <?php if($_SESSION['halaman']=='masterpekerjaan'){ echo 'class="active-menu"'; }?>  href="masterpekerjaan.php">Master Pekerjaan</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a <?php if($_SESSION['halaman']=='buatproyek'){ echo 'class="active-menu"'; }?>  href="buatproyek.php"><i class="fa fa-dashboard"></i> Buat Proyek</a>
                    </li>
                    <li>
                        <a <?php if($_SESSION['halaman']=='daftarproyek'){ echo 'class="active-menu"'; }?> href="daftarproyek.php"><i class="fa fa-dashboard"></i> Daftar Proyek</a>
                    </li>
                        <?php }else{ ?>
                    <li>
                        <a <?php if($_SESSION['halaman']=='') echo 'class="active-menu" ';  ?> href="homelapangan.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                            
                   
                    
                   
                    <li>
                        <a
                        <?php if($_SESSION['halaman']=='daftarhargaalat'){ echo 'class="active-menu"'; }?> 
                        href="daftarhargaalat.php"><i class="fa fa-dashboard"></i> Buat Daftar Harga</a>
                    </li>
                    <li>
                        <a 
                        <?php if($_SESSION['halaman']=='tambahpekerjaan'){ echo 'class="active-menu"'; }?> 
                        href="tambahpekerjaan.php"><i class="fa fa-dashboard"></i> Tambah Pekerjaan</a>
                    </li>
                     
                     <li>
                        <a
                        <?php if($_SESSION['halaman']=='aturjadwal') echo 'class="active-menu" ';  ?>
                         href="aturjadwal.php"><i class="fa fa-dashboard"></i> Atur Jadwal</a>
                    </li>
                    

                    <?php } ?>
                </ul>

            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        