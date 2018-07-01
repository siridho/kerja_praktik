<?php
  session_start();
  include('conn.php');

$html = "
<h3 style='text-align:center;'>LABORATORIUM SYSTEM ENGINEERING</h3>
<h3 style='text-align:center;'>TEKNIK INDUSTRI- UNIVERSITAS SURABAYA</h3>
<h5 style='text-align:center;'>Jl.Raya Kalirungkut, Surabaya-60293</h5>
<h5 style='text-align:center; margin-top:-10%;'>Ph. (031) 2981392 Fax. (031)2981376 teaching.industry@ubaya.ac.id</h5>
<hr>
";

//      if ($row["id"]==$_SESSION['spk'])
 if(isset($_SESSION['spk']))
  {
    if($_SESSION['spk'])
    {
		$html = $html.'<p> No SPK : '.$_SESSION['spk']." </p>";
	}
  }

  $pihak1="";
  $pihak2="";
$html = $html."<p> Yang bertanda tangan dibawah ini : </p>";

 $sql = "SELECT pelanggan.nama as nama , pelanggan.alamat as alamat FROM spk INNER JOIN pelanggan ON spk.idpelanggan=pelanggan.id WHERE spk.id='".$_SESSION['spk']."'";
  $result=$a->query($sql);
  while($row=$result->fetch_assoc())
  {$html = $html."<table> <tr><td style='width:15%;'> Nama : </td><td >".$row["nama"]."</td></tr>";
	$pihak1 = $row["nama"];
	$html = $html."<tr><td style='width:15%;'> Alamat : </td><td>".$row["alamat"]." , selanjutnya disebut <strong> PIHAK PERTAMA </strong> </td></tr></table>";}

$html = $html."<p> Memberi perintah untuk melakukan pekerjaan kepada : </p> ";

 $sql = "SELECT karyawan.nama as nama , karyawan.jabatan as jabatan, karyawan.telp as telp FROM spk INNER JOIN karyawan ON spk.idkaryawan=karyawan.id WHERE spk.id='".$_SESSION['spk']."'";
  $result=$a->query($sql);
  while($row=$result->fetch_assoc())
  {$html = $html."<table><tr><td style='width:20%;'>  Nama  </td><td >: <strong>".$row["nama"]."</strong></td></tr>";
	$pihak2 = $row["nama"];
	$html = $html."<tr><td style='width:20%;'>  Jabatan  </td><td >: <strong>".$row["jabatan"]."</strong> , selanjutnya disebut <strong>PIHAK KEDUA</strong></td></tr>";
	$html = $html."<tr><td style='width:20%;'> Alamat  </td><td >: Lab. Sistem Engineering Jurusan Teknik Industri - Universitas Surabaya Jalan Raya Kalirungkut - Surabaya</td></tr>";
	$html = $html."<tr><td style='width:20%;'>  Telepon  </td><td >: ".$row["telp"]."</td></tr>";}

$sql = "SELECT barangproduksi.nama as pekerjaan FROM barangproduksi INNER JOIN detailspk ON barangproduksi.id=detailspk.id_barang WHERE detailspk.id_spk='".$_SESSION['spk']."'";
  $result=$a->query($sql);
  $html = $html."<tr><td style='width:20%;'>  Pekerjaan  </td><td >: <strong>PEMBUATAN ";
  $i=1;
  while($row=$result->fetch_assoc())
  { if($i==1)$html = $html.strtoupper($row['pekerjaan']); else $html= $html.' DAN '.strtoupper($row["pekerjaan"]); $i++;}
$html = $html."</strong></td></tr>";

$sql = "SELECT biaya, estimasilamakerja, dp, tgltandatangan FROM spk WHERE id='".$_SESSION['spk']."'";
  $result=$a->query($sql);
  while($row=$result->fetch_assoc())
  { $html = $html."<tr><td style='width:20%;'>  Biaya Pekerjaan  </td><td >: <strong>Rp. ".$row["biaya"]."</strong></td></tr>";
	$html = $html."<tr><td style='width:20%;'>  Lama Pekerjaan  </td><td >: Rp. ".$row["estimasilamakerja"]." hari kerja </td></tr>";
	$html = $html."<tr><td style='width:20%;'>  Syarat-syarat  </td><td >: Pembayaran Rp. ".$row["dp"]." saat penandatanganan perjanjian kerjasama</td></tr></table>";
	$html = $html."<p style='text-align:center; padding:10%, 2%;'> Surabaya , ".$row["tgltandatangan"]."</p>";}

$html = $html."<table style='width:100%;' ><tr><td style='text-align:center;' >Pihak pertama, <br><br><br><br><br><br> </td>
					      <td style='text-align:center;'>Pihak kedua, <br><br><br><br><br><br></td></tr>
					  <tr><td style='text-align:center; '>".$pihak1."</td>
					      <td style='text-align:center; '>".$pihak2."</td></tr>
			  </table>";

$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>