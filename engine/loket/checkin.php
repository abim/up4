<?php
/*
+-------------------------------------------------------------------+
|	INDOBIT-TECHNOLOGIES
|	based 		: 02-04-2005
|	continue 	: December 2011
|
|	Released under the terms and conditions of the
|	GNU General Public License (http://gnu.org).
|
|	Rosi Abimanyu Yusuf	(bima@abimanyu.net) | Pontianak, INDONESIA
|	(c)2005 INDOBIT.COM | http://www.indobit.com
+-------------------------------------------------------------------+
*/

@include ("../../inc/qapuas.php");

require_once(c_ADMINDIR."auth.php");

$kanan = 1;
@include("conf.php");

$Tengah = new AdminTblTengah;
$Tengah->Buka();

$pengaturan = new strf;

if((OPLEVEL != $module_conf['level'] ) && (!ADMIN)){
	echo "<script type='text/javascript'>document.location.href='". c_MODULEDIR .OPFOLDER."#SECURITY_WARNING/".OPLEVEL."=nyasar?'</script>\n";
}else{
	
	$SHOW = new SHOW_CLASS;
	
	$tmp = explode(".", c_QUERY);
	$tmp1 = $tmp[0];
	$tmp2 = $tmp[1];
	$tmp3 = $tmp[2];
	
	$teks = "

<div id=\"index\" class='{$width['section']}'>
	<div id=\"icon-plugins\" class=\"icon99\"></div>
	<h2>".$module_conf['name']." Checkin</h2>
</div>
<div id='content' class='{$width['white']} base'>
<div id='main' class='{$width['section']} alignleft pad1em'>";

$teks .= $MENU_ATAS;

if(!ADMIN){
	if((OPPWCHANGE+2592000) < time()) {
		$teks .= "
	<div class='response-msg notice'>
		<span>Untuk keamanan, Silakan ganti password anda secara berkala.</span>
		Password anda telah ".$pengaturan->_ago(OPPWCHANGE)." Tidak di ganti. <a href='". c_MODULEDIR ."op.php'>Ubah Password disini</a>.<br/>
		Terakhir Pengubahan pada tanggal ".$pengaturan->waktu(OPPWCHANGE, "tampil")."
	</div>";
	}
}

if($_POST['searchtext']) {
	$teks .= $SHOW -> formsearch($_POST['searchtext']);
	$teks .= $SHOW -> record($_POST['searchtext']);
}

else{
	if($_POST['checkinsubmit']){
		$code = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
		$JumlahKarakter = strlen($chars)-1; 
			
		for($i = 0 ; $i < 10 ; $i++){
			$code .= $chars[rand(0,$JumlahKarakter)];
		}
		$code_checkin = $code;
		$now = time() -1;
			
			// CECKIN HISTORY
			$sql -> db_Insert("info_checkin", "'0', 
			'".$code_checkin."', 
			'".$_POST['id_pasien']."', 
			'".$_POST['rujukan']."', 
			'".$_POST['klasifikasi']."',
			'".$_POST['keperluan']."', 
			'', 
			'', 
			'".$now."'
			");
			
			@require("../checkin.class.php");
			$CheckIn = new CheckIN;
			
			$CheckIn -> INSTALL ($code_checkin, $_POST['id_pasien']);
			
			$CheckIn -> ADD ("history", "checkin", "loket");
			$CheckIn -> ADD ("history", "wait", $_POST['tujuan_pelayanan']);
			
			$CheckIn -> ADD ("today", "wait", $_POST['tujuan_pelayanan']);
		
		$teks .= "<h2>Status Server :</h2>
		<div class='response-msg success'>
			<span>Pasien Berhasil Melakukan Checkin</span>
			Anda dipersilahkan kembali ke <a href='".c_MODULEDIR.$module_conf['path']."'>halaman depan</a>.
		</div>
		";

	}
	else{$teks .= $SHOW -> formsearch();}
}


	echo $teks;
	
}
$Tengah->Tutup();

//K A N A N
if($kanan == TRUE){
	
	@include("kanan.php");

	$kanan = new AdminTblKanan;
	$kanan -> Buka();
	if(ADMIN){
		$kanan -> ADMIN_MENU_KANAN();
	}else{
		$kanan -> ANTRIAN_DOKTER();
		$kanan -> LAST_ACTIVE();
	}
	$kanan -> Tutup();	
}



include(AdminFooter);

class SHOW_CLASS{

//=========================================================================//
function formsearch($searchtext="") {
$sql = new db;
$pengaturan = new strf;
include (c_INCDIR."class.form.php");
$form = new form_class;

$teks = "
<h2>Nama Pasien yang akan checkin :</h2>


<div id=\"PasienSearch\">
<form method='post' action='". c_SELF ."' class=\"search-icons\" id=\"x-search\">
<label for=\"searchtext\">Search</label>
". $form -> text("searchtext","",$searchtext) ."

</form>
</div>
";


return $teks;

}//end record()

//=========================================================================//
function record($searchtext, $halaman="0") {
$sql = new db;
$sql2 = new db;
$pengaturan = new strf;

//include (c_INCDIR."class.form.php");
$form = new form_class;
		
		
define("ITEMVIEW", 10);
$from = (!is_numeric($halaman) || !c_QUERY ? 0 : ($halaman ? $halaman : c_QUERY));

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("info_pasien", "*", "`nama_pasien` LIKE '%".$searchtext."%' ORDER BY create_date DESC LIMIT ".$halaman.",".ITEMVIEW."");
	
	$sql2 -> db_Select("info_pasien", "nama_pasien", "`nama_pasien` LIKE '%".$searchtext."%'");
	define("ITEMTOTAL", $sql2->db_Rows());
	require_once(c_INCDIR."np.class.php");
	$satu = $halaman;
	$page = new nextprev;
	
$teks = "
<h2>Hasil Pencarian Database : {$searchtext} (".ITEMTOTAL." record)</h2>";

	$teks .= "
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class=\"num tgl\">Tanggal Lahir</th>
		<th scope='col'>Info Checkin</th>
		<th scope='col' class=\"num tgl\">Checkin</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class=\"num\">Tanggal Lahir</th>
		<th scope='col'>Info Checkin</th>
		<th scope='col' class=\"num\">Checkin</th>
		</tr>
	</tfoot>

	<tbody>";

	while($row = $sql-> db_Fetch()){

		$teks .= "
		<form method='post' action='". c_SELF ."'>
		<tr $jav>
			<td>
				<a class='row-title tooltip' href=\"info_pasien.php?umum.{$row['id_pasien']}\" title=\"U P 4 &mdash; {$row['id_pasien']} - Terdaftar ".$pengaturan->_ago($row['create_date'])." yang lalu\">{$row['nama_pasien']}</a>
				<br />
				<div class=\"row-actions\">
					Jl. ".$row['alamat_jl']."
				</div>
			</td>
			<td class=\"num\">".$pengaturan->tanggal_lahir($row['tanggal_lahir'])."</td>
			<td><label for=\"tujuan_pelayanan\">Tujuan Unit</label><p>
				". $form->buka_select(tujuan_pelayanan);
				

				$sql2 = new db;
				$sql2 -> db_Select("info_modul", "*", "code_modul LIKE 'dokter%'");
				while($row2 = $sql2-> db_Fetch()){
					$teks .= $form -> option($row2['nama_modul'], "", $row2['code_modul']);
				}


				$teks .= $form -> tutup_select() ."
				<br />
				<div class=\"row-actions\">
					<label for=\"rujukan\">Rujukan Dari</label><p>
					". $form->buka_select(rujukan) . 
						$form -> option("Umum", "", "umum") .
						$form -> option("Puskesmas", "", "puskesmas") .
						$form -> option("Rumah Sakit", "", "rumahsakit") .
						$form -> option("Klinik Dokter", "", "klinik") .
						$form -> tutup_select() ."</p>						
					<label for=\"klasifikasi\">Klasifikasi Pasien</label>
					<p>". $form->buka_select(klasifikasi) . 
						$form -> option("Umum", "", "umum") .
						$form -> option("ASKES", "", "askes") .
						$form -> option("JAMKESMAS", "", "jamkesmas") .
						$form -> tutup_select() ."</p>
					<label for=\"keperluan\">Keperluan ke UP4</label>
					<p>". $form->buka_select(keperluan) . 
						$form -> option("Keperluan Berobat", "", "berobat") .
						$form -> option("Persyaratan Bekerja", "", "syarat_kerja") .
						$form -> option("Persyaratan Sekolah", "", "syarat_sekolah") .
						$form -> option("Persyaratan Naik Haji", "", "syarat_naikhaji") .
						$form -> option("Lain-lain", "", "dll") .
						$form -> tutup_select() ."</p>	
					<div class=\"clear\"></div>
				</div>
			</td>
			<td class=\"num\">
				".$form->hidden("id_pasien", $row['id_pasien']) ."
				".$form -> button("submit", "checkinsubmit", " Checkin ") ."
			</td>
		</tr>
		</form>";

	}$teks .= "
	</tbody>
</table>
<br class=\"clear\">

";	
	$teks .= $page->tampilkan(c_SELF."?", $from, ITEMVIEW, ITEMTOTAL, "LANJUT", ($satu == "list" ? $satu.".".$dua : ""));

return $teks;

}//end record()
//=========================================================================//
}//end Class
?>