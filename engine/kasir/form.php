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

//=========================================================================//

if((OPLEVEL != $module_conf['level'] ) && (!ADMIN)){
	echo "<script type='text/javascript'>document.location.href='". c_MODULEDIR .OPFOLDER."#SECURITY_WARNING/".OPLEVEL."=nyasar?'</script>\n";
}

//=========================================================================//

else {
	
	$inputclass = new inputclass;
	
	$tmp = explode(".", c_QUERY);
	$tmp1 = $tmp[0];
	$tmp2 = $tmp[1];
	$tmp3 = $tmp[2];
	
	if($_POST['tambahsubmit']){

			$unit = $module_conf['level'];
			
			@require("../checkin.class.php");
			$CheckIn = new CheckIN;
		
			$CheckIn -> INSTALL ($_POST['code_checkin'], $_POST['id_pasien']);
		
			$CheckIn -> UPDATE ("done", $unit);
			$CheckIn -> ADD ("history", "done", $unit, $_POST['total_harga'], 1);
			
			$sql -> db_Update("info_history", "`lunas`='1' WHERE code_checkin='".$_POST['code_checkin']."' AND tagihan!='0'
			");
			
			$kembalian = $_POST['uang_yg_dibayarkan'] - $_POST['total_harga'];
			
			$trim = '
			$code_checkin='.$_POST['code_checkin'].';
			$id='.$_POST['id_pasien'].';
			$bayar = '.$_POST['uang_yg_dibayarkan'].';
			$kembalian = '.$kembalian.';
			$nama_pasien = "'.$_POST['nama_pasien'].'";
			$klasifikasi = '.$_POST['klasifikasi'].';
			';
			
			$xcode = base64_encode($trim);

			
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip.{$kembalian}.{$xcode}'</script>\n";
			
			
		}
	}

//=========================================================================//

	if($tmp1 == "checkin"){
		if (!empty($tmp2)) {
			$inputclass -> judul();
			$inputclass -> formulir($tmp2);
		}else{
			$inputclass -> judul(error, "ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY");
			$kanan=0;
		}
	}
	
//=========================================================================//

	if(c_QUERY == "sip.{$tmp2}.{$tmp3}"){
		$inputclass -> judul();
		$inputclass -> printsetup($tmp2, $tmp3);
	}
	
	if(c_QUERY == ""){
        $inputclass -> judul();
		$inputclass -> formulir();
	}
	

$Tengah->Tutup();

//K A N A N
if($kanan==TRUE){
	
	@include("kanan.php");

	$kanan = new AdminTblKanan;
	$kanan -> Buka();
	if(ADMIN){
		$kanan -> ADMIN_MENU_KANAN();
		$kanan -> ANTRIAN(active);
	}else{
		$kanan -> ANTRIAN(active);
		$kanan -> LAST_ACTIVE();
	}
	$kanan -> Tutup();	
}

include(AdminFooter);

//=========================================================================//


class inputclass{

//status = success, error, info
function judul($status="", $text="") {
		global $MENU_ATAS, $width, $module_conf;
		$head = "
<div id=\"index\" class='{$width['section']}'>
	<div id=\"icon-users\" class=\"icon99\"></div>
	<h2>FORM {$module_conf['name']}</h2>
</div>

<div id='content' class='{$width['white']} base'>
<div id='main' class='{$width['section']} alignleft pad1em'>";

		$RESPOND = "{$MENU_ATAS}
		<h2>RESPON SERVER :</h2>";
		
		if($status=="error") {
			$link_text = "Silahkan Kembali ke <a href=\"#\" onClick=\"history.go(-1)\">halaman Sebelumnya</a>.";}
		elseif($status=="success") {
			$link_text = "Anda dipersilahkan ke <a href='".c_MODULEDIR.$module_conf['path']."'>Halaman Depan</a>.";}
		else {
			$link_text = "";
		}

		$RESPOND .= "
		<div class='response-msg {$status}'>
			<span>".$text."</span>
			{$link_text}
		</div>
	";
		
	if (empty($status)) {echo $head;}
	else {echo $head.$RESPOND;}
		
}

//=========================================================================//
function printsetup($kembalian="", $xcode) {

		$teks =  "
<h2>Lebih Pembayaran</h2>
<div class=\"form-wrap\">
<table class=\"widefat fixed\" cellspacing=\"0\">
	<tfoot>
		<tr>
		<th scope='col' class='right'>KEMBALIAN</th>
		<th scope='col' class='num harga'><em>Rp. ".$this->duit($kembalian).",-</em></th>
		</tr>
	</tfoot>
	</table>
</div>
	<br/>

<h2>Printout Tagihan</h2>

<div class='center white w400 alignleft'>
<iframe src=\"bukti_pembayaran.php?code={$xcode}\" frameborder='0' width='400px' height='500px'></iframe>
</div>
<p class='center'><a class=\"btnPrint tombolInput center\" href='bukti_pembayaran.php?code={$xcode}'>Print Tagihan Pasien</a></p>";

echo $teks;
}
//=========================================================================//
function formulir($code_checkin="") {
global $module_conf;
include (c_INCDIR."class.form.php");
$form = new form_class;

global $pengaturan;
$sql = new db;

$sql -> db_Select("info_current_status 
JOIN info_pasien AS pasien ON info_current_status.id_pasien = pasien.id_pasien 
JOIN info_checkin AS info_checkin ON info_current_status.code_checkin = info_checkin.code_checkin 
", "

now_date, info_current_status.id_pasien AS id_pasien, pasien.nama_pasien AS nama_pasien, pasien.id_card, pasien.jenis_card, pasien.tempat_lahir, pasien.tanggal_lahir, pasien.gender, pasien.alamat_jl, pasien.alamat_rt, pasien.alamat_rw, pasien.alamat_kelurahan, pasien.alamat_kecamatan, pasien.alamat_kota, pasien.alamat_telp, pasien.create_date, 
info_checkin.rujukan, info_checkin.klasifikasi, info_checkin.keperluan, info_checkin.keluhan_pasien, info_checkin.catatan_dokter, info_checkin.dll
", "info_current_status.code_checkin = '{$code_checkin}' ORDER BY `now_date` DESC LIMIT 1");

$result = $sql -> db_Fetch();
extract($result);

$resep_dokter = preg_replace('/\n/', "<br/>", $resep_dokter);

		$teks =  "
<h2>{$nama_pasien}</h2>


<div id=\"Tabs\">

<div class=\"other ui-corner-all\">
	<ul id=\"dashboard-buttons\">
		<li><a href=\"#form\" class=\"Clipboard_3 tooltip\" title=\"Form Pengisian {$module_conf['name']}\">Form {$module_conf['level']}</a></li>
		<li><a href=\"#info\" class=\"Chart_5 tooltip\" title=\"Informasi Pasien\">Informasi</a></li>
	</ul>
</div><br class=\"clear\"/>

<div id=\"info\">
	<div class=\"form-wrap\">
	<h2>Informasi Pasien</h2>
		
		<div class=\"form_col_1\">
			<label for=\"nama_lengkap\">Nama Lengkap</label>
		</div>
		<div class=\"form_col_2\">{$nama_pasien}</div>	
		<div class=\"clear\"></div>
		
		
		<div class=\"form_col_1\">
			<label for=\"id_card\">Nomer Identitas</label>
		</div>
		<div class=\"form_col_2\">{$id_card} <span>({$jenis_card})</span></div>	
		<div class=\"clear\"></div>
		
		<div class=\"form_col_1\">
			<label for=\"id_card\">Umur</label>
		</div>
		<div class=\"form_col_2\">".$pengaturan->umur($tanggal_lahir)." Tahun</div>	
		<div class=\"clear\"></div>
		
		
		<div class=\"form_col_1\">
			<label for=\"tempat_lahir\">Tempat / Tanggal Lahir</label>
		</div>
		<div class=\"form_col_2\">{$tempat_lahir}, ".$pengaturan->tanggal_lahir($tanggal_lahir)."
		<p>Tempat lahir, Tanggal-Bulan-Tahun</p>
		</div>	
		<div class=\"clear\"></div>
		
		
		<div class=\"form_col_1\">
			<label for=\"gender\">Jenis Kelamin</label>
		</div>
		<div class=\"form_col_2\">".$pengaturan->gender($gender)."</div>	
		<div class=\"clear\"></div>
		
		
		<div class=\"form_col_1\">
			<label for=\"alamat_pasien_jl\">Alamat Pasien</label>
		</div>
		<div class=\"form_col_2\">{$alamat_jl}<br/>
		".($alamat_rt ? "RT. {$alamat_rt}" : "").($alamat_rw ? "/RW. {$alamat_rw}" : "")."<br/>".($alamat_kelurahan ? " Kel. {$alamat_kelurahan}" : "").($alamat_kecamatan ? " Kec. {$alamat_kecamatan}" : "")."<br/>{$alamat_kota}<br/>".($alamat_telp ? "Telp. {$alamat_telp}" : "")."</div>	
		<div class=\"clear\"></div>
		
	<h2>Keperluan Pasien</h2>
		<div class=\"form_col_1\">
			<label for=\"klasifikasi\">Klasifikasi Pasien</label>
		</div>
		<div class=\"form_col_2\">{$klasifikasi}</div>	
		<div class=\"clear\"></div>
		
		<div class=\"form_col_1\">
			<label for=\"keperluan\">Keperluan ke UP4</label>
		</div>
		<div class=\"form_col_2\">{$keperluan}</div>	
		<div class=\"clear\"></div>
		
		<div class=\"form_col_1\">
			<label for=\"dll\">Informasi Lainnya</label>
		</div>
		<div class=\"form_col_2\">{$dll}</div>	
		<div class=\"clear\"></div>

	</div>
</div>

<div id=\"form\">
		
	<form method='post' action='". c_SELF ."'>
	".$form->hidden("code_checkin", $code_checkin) ."
	".$form->hidden("id_pasien", $id_pasien) ."
	".$form->hidden("nama_pasien", $nama_pasien) ."
	".$form->hidden("klasifikasi", $klasifikasi) ."
	
<h2>Jumlah Tagihan atas nama {$nama_pasien}</h2>

	<div class=\"form-wrap\">
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col'>Jenis Pelayanan</th>
		<th scope='col' class='num harga'>Biaya Pelayanan</th>
		</tr>
	</thead>
	
	<tbody>";
	
	
$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql2 = new db;
	$sql2 -> db_Select("info_history", "posisi, tagihan", "code_checkin='{$code_checkin}' AND status = 'done' AND tagihan!='0' AND lunas!='1' ORDER BY id_history ASC");
		
	while($row2 = $sql2-> db_Fetch()){
		$biaya = $row2['tagihan'];
		$teks .= "
			<tbody>	
			<tr>
				<th scope='col' class='uppercase'>".$row2['posisi']."</th>
				<th scope='col' class='num harga'>Rp. ".$this->duit($biaya)." ,-</th>
			</tr>
		";
		$jumlah_tagih += $biaya;
		
	}
	
$teks .= "
	</tbody>
	
	</table>
	
	<div id=\"dynamicInput\"></div>	
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<tfoot>
		<tr>
		<th scope='col' class='right uppercase'>Jumlah Tagihan</th>
		<th scope='col' class='num harga'><em>Rp. ".$this->duit($jumlah_tagih).",-</em></th>
		</tr>
	</tfoot>
	</table>
	<br/>";
	
	@require("../tagihan.class.php");
	if (CEK_DISKON($klasifikasi) == TRUE) {
	
	$diskon = DISKON_GET($klasifikasi);
	
	$total_diskon = ($jumlah_tagih * $diskon) / 100;
	$total_tagih = $jumlah_tagih - $total_diskon;
	
	$teks .= "
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<tfoot>
		<tr>
		<th scope='col' class='right uppercase'>Potongan {$klasifikasi} <em>{$diskon}%</em></th>
		<th scope='col' class='num harga'>Rp. ".$this->duit($total_diskon).",-</th>
		</tr>
	</tfoot>
	</table>
	<br/>
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<tfoot>
		<tr>
		<th scope='col' class='right uppercase'>Total Tagihan</th>
		<th scope='col' class='num harga'><em>Rp. ".$this->duit($total_tagih).",-</em></th>
		</tr>
	</tfoot>
	</table>
	<br/>
	";
	}else{$total_tagih = $jumlah_tagih;}
	$teks .= "
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<tfoot>
		<tr>
		<th scope='col' class='right'>JUMLAH UANG YANG DITERIMA</th>
		<th scope='col' class='num'><em>Rp. ". $form -> text("uang_yg_dibayarkan",30) .",-</em></th>
		</tr>
	</tfoot>
	</table>

	".$form->hidden("total_harga", $total_tagih) ."
	<p class='submit center'>".$form -> button("submit", "tambahsubmit", " L U N A S ") ."</p>
	</div>
	</form>
</div>

<script type=\"text/javascript\"> 
  $(\"#Tabs ul\").idTabs(); 
</script>
</div>
";
echo $teks;
}

function duit($xx) {
	if (empty($xx)){ return $xx;}else {
	$x = trim($xx);
	$b = number_format($x, 0, ",", ".");
	//$text .= substr_replace($text, '.', 0, -6);
	return $b;
	}
}

//end class
}
//=========================================================================//

?>
