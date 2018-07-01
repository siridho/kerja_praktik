<?php
  session_start();
  include('conn.php');

$html = "
<h3 style='text-align:center;'>INI KOP JANGAN LUPA DIGNATI YACHHHH</h3>
<h3 style='text-align:center;'>TEKNIK INDUSTRI- UNIVERSITAS SURABAYA</h3>
<h5 style='text-align:center;'>Jl.Raya Kalirungkut, Surabaya-60293</h5>
<h5 style='text-align:center; margin-top:-10%;'>Ph. (031) 2981392 Fax. (031)2981376 teaching.industry@ubaya.ac.id</h5>
<hr>
";


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
    $id=$_GET['idproy'];
}

$html.="<h4 style='text-align:center;'>Daftar Alat</h4>
<h4 style='text-align:center;'>Proyek ".$nama."</h4>";

$html.='<table border=1 style="margin:auto;">
		<tr>
			<th>No.</th>
			<th>Kode Alat</th>
			<th>Nama Alat</th>
			<th>Harga Satuan</th>
			<th>Satuan</th>
		</tr>';

$sqldaftaralat = "SELECT ada.kodealat as kode, ada.harga as harga, a.nama as namaalat, a.satuan as satuan FROM daftaralat da inner join alat_daftaralat ada on da.id=ada.iddaftaralat INNER JOIN alat a ON a.kode=ada.kodealat WHERE da.idproyek=".$id." and ada.iddaftaralat=(select max(dd.id) from daftaralat dd where dd.idproyek=".$id.")";
$no=1;
$hasil=$a->query($sqldaftaralat);
while ($baris1=$hasil->fetch_assoc()) {
$html.=		"<tr>
		<td style='text-align:center;'>".$no."</td>
		<td style='text-align:center;'>".$baris1['kode']."</td>
		<td>".$baris1['namaalat']."</td>
		<td style='text-align:center;'>".$baris1['harga']."</td>
		<td style='text-align:center;'>".$baris1['satuan']."</td>
		</tr>";
	$no++;
	}
	$html.='</table>';


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