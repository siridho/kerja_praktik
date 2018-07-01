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


$sql='select * from proyek WHERE id = '.$_GET['idproyek'];
$hasil=$a->query($sql);
while ($baris=$hasil->fetch_assoc()) {
    $nama = $baris['nama'];
    $alamat = $baris['alamat'];
    $status_rab = $baris['status_rab'];
    $tgl_mulai = $baris['tgl_mulai'];
    $lamaproyek = $baris['lamaproyek'];
    $klien = $baris['klien'];
    $status = $baris['status'];
    $id=$_GET['idproyek'];
}

$html.="<h4 style='text-align:center;'>Daftar Alat Proyek ".$nama." Minggu ".$_GET['minggu']."</h4>";


$html.="<h5 style='text-align:center;'>Biaya upah</h5>";

$html.='<table border=1 style="margin:auto;">
		<tr>
			<th>No.</th>
			<th>Kode upah</th>
			<th>Nama upah</th>
			<th>Rencana Volume</th>
			<th>Total Biaya</th>
		</tr>';

$sqldaftarupah = "SELECT ada.kodeupah as kode, a.nama as namaupah, SUM(ppl.volumepengukuran) as vol, SUM(ppl.total) as total FROM daftarupah da inner join upah_daftarupah ada on da.id=ada.iddaftarupah INNER JOIN upah a ON a.kode=ada.kodeupah 
INNER JOIN pengukuranprogresslapangan ppl ON ppl.idkeperluan=a.kode
WHERE da.idproyek=".$id." and ada.iddaftarupah=(select max(dd.id) from daftarupah dd where dd.idproyek=".$id.") AND ppl.minggu=".$_GET['minggu'] ." GROUP BY ada.kodeupah, a.nama";
$no=1;
$totalupah = 0;
$hasil=$a->query($sqldaftarupah);
while ($baris1=$hasil->fetch_assoc()) {
	if($baris1['vol']!=0){
	$html.=		"<tr>
			<td style='text-align:center;'>".$no."</td>
			<td style='text-align:center;'>".$baris1['kode']."</td>
			<td>".$baris1['namaupah']."</td>
			<td style='text-align:center;'>".$baris1['vol']."</td>
			<td>Rp ".$baris1['total']."</td>
			</tr>";
		$no++;
		$totalupah+=$baris1['total'];
	}
}

	$html.='
<tr>
	<td colspan="4" style="text-align:right;">Total </td>
	<td>Rp '.$totalupah.'</td>
</tr>
	</table><br>';


$totalminggu = $totalupah + $totalalat + $totalmaterial;




//============== AKUMULASI ===========================================================================================

if($_GET['minggu'] > 1){




$html.="<br><br><h5 style='text-align:center;'>Akumulasi Biaya Upah Hingga Minggu ke-".$_GET['minggu']."</h5>";

$html.='<table border=1 style="margin:auto;">
		<tr>
			<th>No.</th>
			<th>Kode upah</th>
			<th>Nama upah</th>
			<th>Rencana Volume</th>
			<th>Total Biaya</th>
		</tr>';

$sqldaftarupah = "SELECT ada.kodeupah as kode, a.nama as namaupah, SUM(ppl.volumepengukuran) as vol, SUM(ppl.total) as total FROM daftarupah da inner join upah_daftarupah ada on da.id=ada.iddaftarupah INNER JOIN upah a ON a.kode=ada.kodeupah 
INNER JOIN pengukuranprogresslapangan ppl ON ppl.idkeperluan=a.kode
WHERE da.idproyek=".$id." and ada.iddaftarupah=(select max(dd.id) from daftarupah dd where dd.idproyek=".$id.") AND ppl.minggu  BETWEEN 1 AND ".$_GET['minggu'] ." GROUP BY ada.kodeupah, a.nama";
$no=1;
$totalupah = 0;
$hasil=$a->query($sqldaftarupah);
while ($baris1=$hasil->fetch_assoc()) {
	if($baris1['vol']!=0){
	$html.=		"<tr>
			<td style='text-align:center;'>".$no."</td>
			<td style='text-align:center;'>".$baris1['kode']."</td>
			<td>".$baris1['namaupah']."</td>
			<td style='text-align:center;'>".$baris1['vol']."</td>
			<td>Rp ".$baris1['total']."</td>
			</tr>";
		$no++;
		$totalupah+=$baris1['total'];
	}
}

	$html.='
<tr>
	<td colspan="4" style="text-align:right;">Total </td>
	<td>Rp '.$totalupah.'</td>
</tr>
	</table><br>';



$totalmingguak = $totalupah + $totalalat + $totalmaterial;

}
//============== END OF AKUMULASI ======================================================================================


$html.="<h3>Total Biaya Minggu ke-".$_GET['minggu']." = Rp ".$totalminggu."</h3>";
$html.="<h3>Total Biaya dari Minggu-1 sampai Minggu ke-".$_GET['minggu']." = Rp ".$totalmingguak."</h3>";












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