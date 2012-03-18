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
		
		@require("../tagihan.class.php");
		$tagihan = HARGA_GET($unit);
		
		$jumlahdata = count($_POST['DynName']);
		
		for($x=0; $x<$jumlahdata; $x++){
			$hasil_analisa .= "{".$_POST['DynName'][$x]."::".$_POST['DynValue'][$x]."}";
		}
		
		$tindakan = ($_POST['tindakan'] ? 1 : 0);
		
		$now_datetime = date("Y-m-d H:i:s");
		
		$sql -> db_Insert("info_dokter", "'0', 
			'".$_POST['code_checkin']."',
			'".$_POST['hasil_diagnosa']."',
			'".$hasil_analisa."', 
			'".$tindakan."', 
			'".$_POST['unit_rujukan']."',
			'".$_POST['note_pasien']."',
			'".$now_datetime."' 
			");
		
		$sql -> db_Insert("info_dokter_note", "'0', 
			'".OPID."', 
			'".$_POST['id_pasien']."',
			'".$_POST['code_checkin']."',
			'".base64_encode($_POST['note_dokter'])."',
			'".$now_datetime."' 
			");
			
		$sql -> db_Insert("info_resep", "'0', 
			'".$_POST['code_checkin']."',
			'".$_POST['resep']."',
			'',
			'".$now_datetime."' 
			");
			
		@require("../checkin.class.php");
		$CheckIn = new CheckIN;
		
		$CheckIn -> INSTALL ($_POST['code_checkin'], $_POST['id_pasien']);
		
		$CheckIn -> UPDATE ("done", $unit);		
		$CheckIn -> ADD ("history", "done", $unit, $tagihan);
		
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip'</script>\n";
	}
}

//=========================================================================//

	if($_POST['rujukan_submit']){
		
		//Tulis Catatan Dokter
		$sql -> db_Update("info_checkin", "`catatan_dokter`='".$_POST['catatan_dokter']."' WHERE code_checkin='".$_POST['code_checkin']."' AND id_pasien='".$_POST['id_pasien']."'");		
		
		@require("../checkin.class.php");
		$CheckIn = new CheckIN;
		
		$CheckIn -> INSTALL ($_POST['code_checkin'], $_POST['id_pasien']);
		
		$CheckIn -> ADD ("today", "wait", $_POST['to_rujukan']);
		$CheckIn -> UPDATE ("pending", "dokter");
		
		$CheckIn -> ADD ("history", "pending", "dokter");
		$CheckIn -> ADD ("history", "wait", $_POST['to_rujukan']);
			
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?transfer'</script>\n";
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

	if(c_QUERY == "sip"){
		$inputclass -> judul(success, "DATA BERHASIL DITAMBAHKAN");
	}
	
	if(c_QUERY == "transfer"){
		$inputclass -> judul(success, "PASIEN BERHASIL DI TRANSFER");
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
		$kanan -> ANTRIAN_DOKTER(active);
	}else{
		$kanan -> ANTRIAN_DOKTER(pending);
		$kanan -> ANTRIAN_DOKTER(active);
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
	<h2>FORM DOKTER</h2>
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
function printsetup($code_checkin) {
		
		$teks =  "<div class='center'>
		<p><a class=\"btnPrint tombolInput center\" href='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'>Print Kartu Pasien</a></p>
		
		<p><img src='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'/></p>
		</div>";
echo $teks;
}

//=========================================================================//
function formulir($code_checkin="") {

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

		$teks =  "
<!-- Pengarahan Pasien //-->
<div class='alignright ui-corner-all tooltip bg-hijau-1 bor-hijau-1 pad10px' title='PENTING - Abaikan form hijau ini jika tidak ingin melalui proses tindakan pemeriksaan Laboratorium, Radiologi dll'>
	
	<form method='post' action='". c_SELF ."'>
	".$form->hidden("code_checkin", $code_checkin) ."
	".$form->hidden("id_pasien", $id_pasien) ."
	
		<label for=\"to_rujukan\">Arahkan Pasien ke : </label>
		". $form->buka_select(to_rujukan) . 
			$form -> option("Laboratorium", "", "lab") .
			$form -> option("Radiologi", "", "radiologi") .
			$form -> tutup_select() ."
		<br class=\"clear\"/>
	
		<label for=\"catatan_dokter\">Analisa / Catatan Dokter :</label>
		<br class=\"clear\"/>
		
		". $form -> textarea("catatan_dokter",40,2,$catatan_dokter) ."

		<p><span class='submit'>".$form -> button("submit", "rujukan_submit", " Submit ") ."</span></p>

	</form>
</div>
<!-- END pengarahan Pasien //-->
<h2>{$nama_pasien}</h2>


<div id=\"Tabs\">

<div class=\"other ui-corner-all\">
	<ul id=\"dashboard-buttons\">
		<li><a href=\"#form\" class=\"Clipboard_3 tooltip\" title=\"Form Pengisian Dokter\">Form Dokter</a></li>
		<li><a href=\"#info\" class=\"Chart_5 tooltip\" title=\"Informasi Pasien\">Informasi</a></li>
		<li><a href=\"#history\" class=\"Chart_4 tooltip\" title=\"Rekam Medik\">Rekam Medik</a></li>
	</ul>
</div><br class=\"clear\"/>

<div id=\"history\">
	<div class=\"form-wrap\">
		
		<h2>Keluhan Awal Pasien</h2>

		<label for=\"keluhan_pasien\">".($keluhan_pasien ? "{$keluhan_pasien}" : "<span> -no data- </span>")."</label>
		<div class=\"clear\"></div>
		
		".($catatan_dokter ? "
		
		<h2>Catatan Dokter</h2>
		
		<label for=\"catatan_dokter\">{$catatan_dokter}</label>
		<div class=\"clear\"></div>		
		
		" : "")."
		
		".($rujukan ? "<h2>STATUS : Rujukan Dari {$rujukan}</h2>" : "")."
		
	</div>
</div>

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
		<div class=\"form_col_2\">Jl. {$alamat_jl}<br/>
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
	
	<div class=\"form-wrap\">";
	
	$sql2 = new db;
		$sql2 -> db_Select("info_pemeriksaan", "*", "code_checkin='{$code_checkin}' ORDER BY create_date ASC");
		
		$total_hasil_pemeriksaan = $sql2->db_Rows();
		
		if (!empty($total_hasil_pemeriksaan)) {
		
			while($row2 = $sql2-> db_Fetch()){
				
				$teks .= "
<!-- HASIL PEMERIKSAAN //-->
<div class='ui-corner-all white bor-hijau-1 pad10px'>
<h2>HASIL PEMERIKSAAN {$row2['unit']}</h2>
";
				$tmp1_open = "<div class='form_col_1 bold'><label>";
				$tmp_pemisah = "</label></div><div class='form_col_2'>";
				$tmp_close = "</div>
				<div class='clear'></div>
				";
				
				$search = array('/::/', '/{/','/}/','/\n/');
				$replace = array($tmp_pemisah, $tmp1_open, $tmp_close, "<br/>");
				
				$Hasil_Pemeriksaan = preg_replace($search, $replace, $row2['hasil_analisa']);
				
				$teks .= "{$Hasil_Pemeriksaan}
				<div class=\"form_col_1 bold\"><label>Catatan</label></div>
				<div class='form_col_2'>{$row2['dll']}</div><div class=\"clear\"></div>
				</div><br/><!-- END hasil pemeriksaan Pasien //-->				
				";
			}
		}
	
$teks .= "

	<h2>Pemeriksaan Fisik - ".$form -> button("dynamicInput", "myInputs[]", " + Form Pemeriksaan ", " onClick=\"addInput('dynamicInput');\"", "","", "tombolInput") ."</h2>

	<script src=\"".c_Container_URL."admin/js/addInput.js\" language=\"Javascript\" type=\"text/javascript\"></script>

	<div id=\"dynamicInput\"></div>
	
	<h2><label for=\"hasil_diagnosa\">Hasil Diagnosa</label></h2>
	<p>". $form -> textarea("hasil_diagnosa",50,3) ."</p>	
	<br class=\"clear\"/>
	
	<h2><label for=\"hasil_diagnosa\">Tindakan</label></h2>
	<em>**</em>". $form->buka_select(tindakan) . 
			$form -> option("Tidak Perlu", "", 0) .
			$form -> option("Perlu", "", 1) .
			$form -> tutup_select() ."<label for=\"tindakan\"> Dilakukan Tindakan Medis Lanjut</label>
	<br/><br class=\"clear\"/>	
		
	<label for=\"unit_rujukan\"><em>**</em> Bila Iya, Rujukan Ke</label>
	". $form->buka_select(unit_rujukan) . 
			$form -> option("SELECT", "", "0") .
			$form -> option("Unit Tindakan", "", "unit_tindakan") .
			$form -> option("Rumah Sakit", "", "rumahsakit") .
			$form -> tutup_select() ."
	<br class=\"clear\"/>

	
	<h2><label for=\"note_dokter\">CATATAN KHUSUS DOKTER</label></h2>
	<p>". $form -> textarea("note_dokter",50,2) ."<br/>
	<span>Catatan Khusus Dokter</span> <em>*) tidak untuk pasien</em></p>
	<br class=\"clear\"/>
		
	<h2><label for=\"note_pasien\">CATATAN UNTUK PASIEN</label></h2>
	<p>". $form -> textarea("note_pasien",50,2) ."</p>	
	<br class=\"clear\"/>
			
	<h2><label for=\"resep\">RESEP OBAT</label></h2>
	<p>". $form -> textarea("resep",50,4) ."</p>	
	<br class=\"clear\"/>
		
	<p class='submit'>".$form -> button("submit", "tambahsubmit", " INPUT KE DATABASE & Checkout ") ."</p>
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
	
//=========================================================================//

//end class
}

?>
