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



 $sql = "SELECT barangproduksi.nama as namabarang , detailspk.quantity as kuantitas FROM barangproduksi inner join detailspk ON barangproduksi.id= detailspk.id_barang WHERE detailspk.id_spk='".$_SESSION['spk']."'";
  $result=$a->query($sql);
  $html = $html."<table border=1 ><tr ><th style='width:80%; '> Nama Barang </th><th style='width:50%; '> Kuantitas </th></tr>";
  while($row=$result->fetch_assoc())
  { $html = $html." <tr><td style='width:auto;'>".$row["namabarang"]."</td> <td style='text-align: center'>".$row["kuantitas"]."</td></tr>";
  }
  $html = $html."  </table>";

  $sql = "SELECT karyawan.nama as nama , sum(realisasiprogress.realisasimanhour) as manhour FROM spk INNER JOIN jadwalproduksi ON spk.id_jadwal_produksi=jadwalproduksi.id 
                          LEFT JOIN formprogress ON jadwalproduksi.id = formprogress.id_jadwalproduksi
                          INNER JOIN realisasiprogress ON formprogress.id = realisasiprogress.id_formprogress
                          INNER JOIN karyawan on realisasiprogress.id_karyawan = karyawan.id
                          WHERE spk.id='".$_SESSION['spk']."' GROUP BY karyawan.nama";
  $result=$a->query($sql);

  $html = $html."  <br><br><table border=1 ><tr><th style='width:50%; '>Nama Karyawan</th><th>Manhour</th></tr>";
  while($row=$result->fetch_assoc())
  { $html = $html."<tr><td > ".$row["nama"]."</td>";
    $html = $html."<td style='text-align: center'> ".$row["manhour"]."</td></tr>";
  }
  $html = $html." </table>";


  $sql = "SELECT mesin.nama as nama  FROM spk INNER JOIN jadwalproduksi ON spk.id_jadwal_produksi=jadwalproduksi.id 
                          LEFT JOIN formprogress ON jadwalproduksi.id = formprogress.id_jadwalproduksi
                          INNER JOIN realisasimesin ON formprogress.id = realisasimesin.id_formprogress
                          INNER JOIN mesin on realisasimesin.id_mesin = mesin.id
                          WHERE spk.id='".$_SESSION['spk']."'";
  $result=$a->query($sql);

  $html = $html."  <br><br><table border=1><tr><th style='width:50%; '>Nama Mesin</th></tr>";
  while($row=$result->fetch_assoc())
  { $html = $html."<tr><td > ".$row["nama"]."</td>";
    $html = $html."</tr>";
  }
  $html = $html." </table>";




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