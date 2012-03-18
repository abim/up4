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

$kanan = 0;
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
		
		$row = $authresult = $inputclass -> inputproses($_POST['nama_lengkap']);
		if($row[0] == "kosong1"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg1'</script>\n";
		}else{
			
			$ultah = "{$_POST['tahun_lahir']}-{$_POST['bulan_lahir']}-{$_POST['tanggal_lahir']}";
			$now = time() - 1;
			
			$sql -> db_Insert("info_pasien", "'0', 
			'".$_POST['id_card']."', 
			'".$_POST['jenis_card']."', 
			'".$_POST['nama_lengkap']."', 
			'".$_POST['tempat_lahir']."',
			'".$ultah."', 
			'".$_POST['gender']."',
			'".$_POST['orang_tua']."',
			'".$_POST['alamat_pasien_jl']."',
			'".$_POST['alamat_pasien_rt']."',
			'".$_POST['alamat_pasien_rw']."',
			'".$_POST['alamat_pasien_kel']."',
			'".$_POST['alamat_pasien_kec']."',
			'".$_POST['alamat_pasien_kota']."',
			'".$_POST['no_telp']."',
			'1',
			'".$now."' 
			");
			
			$ambil = new strf;
			$comot_id_pasien = $ambil -> COMOT(info_pasien, "id_pasien", "`create_date`='".$now."' ORDER BY id_pasien DESC LIMIT 1");
			
			$pengaturan = new strf;
			require_once (c_INCDIR."class.img.php");
			
$teks_kartu = "UP4-{$comot_id_pasien}
{$_POST['id_card']}
{$_POST['nama_lengkap']}
{$_POST['tempat_lahir']}/ {$_POST['tanggal_lahir']}-{$_POST['bulan_lahir']}-{$_POST['tahun_lahir']}
".$pengaturan->gender($_POST['gender'])."
".$pengaturan->BATASI_KARAKTER("Jl.{$_POST['alamat_pasien_jl']}",28)."
".($_POST['alamat_pasien_rt'] ? "RT. {$_POST['alamat_pasien_rt']}" : "").($_POST['alamat_pasien_rw'] ? "/RW. {$_POST['alamat_pasien_rw']}" : "").($_POST['alamat_pasien_kel'] ? ", {$_POST['alamat_pasien_kel']}" : "")." 
".($_POST['alamat_pasien_kec'] ? "{$_POST['alamat_pasien_kec']}" : "")."
{$_POST['alamat_pasien_kota']}";
			
			CREATE_KARTU_PASIEN_IMAGES($teks_kartu, $comot_id_pasien);
			
			$code = '';
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
			$JumlahKarakter = strlen($chars)-1; 
			
			for($i = 0 ; $i < 10 ; $i++){
				$code .= $chars[rand(0,$JumlahKarakter)];
			}
			$code_checkin = $code;
			
			$sql -> db_Insert("info_checkin", "'0', 
			'".$code_checkin."', 
			'".$comot_id_pasien."', 
			'".$_POST['rujukan']."', 
			'".$_POST['klasifikasi']."',
			'".$_POST['keperluan']."', 
			'".$_POST['keluhan_pasien']."', 
			'', 
			'".$_POST['desc']."', 
			'".$now."'
			");
			
			@require("../tagihan.class.php");
			$tagihan = HARGA_GET($module_conf['level']); 
			if(empty($tagihan)){$tagihan=0;}
			
			//CHECK-IN
			@require("../checkin.class.php");
			$CheckIn = new CheckIN;
			
			$CheckIn -> INSTALL ($code_checkin, $comot_id_pasien);
			
			$CheckIn -> ADD ("history", "register", "loket", $tagihan);
			$CheckIn -> ADD ("history", "wait", $_POST['tujuan_pelayanan']);
			
			$CheckIn -> ADD ("today", "wait", $_POST['tujuan_pelayanan']);
		}
			
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip.{$comot_id_pasien}'</script>\n";
	}
}

//=========================================================================//

	if(c_QUERY == "ksg1"){
		$inputclass -> judul("Nama tidak Terisi dengan Benar, Ulangi Pengisian", 1);
		$inputclass -> formulir();
	}

	if($tmp1 == "sip"){
		$inputclass -> judul("DATA BERHASIL DITAMBAHKAN", 1);
		$inputclass -> printsetup($tmp2);
	}
	if(c_QUERY == ""){
        $inputclass -> judul();
		$inputclass -> formulir();
	}
	

$Tengah->Tutup();

include(AdminFooter);

//=========================================================================//


class inputclass{

//=========================================================================//
function judul($text="", $tampilmenu="") {
		global $MENU_ATAS, $width;
		$teks1 = "
<div id=\"index\" class='{$width['section']}'>
	<div id=\"icon-users\" class=\"icon99\"></div>
	<h2>FORM PENDAFTARAN</h2>
</div>

<div id='content' class='{$width['white']} base'>
<div id='main' class='{$width['section']} alignleft pad1em'>";

$teks1 .= $MENU_ATAS;

		$teks2 = "
	<div class='center'>
	<h2>RESPON SERVER : ";

		$teks2 .= "
		".$text."</h2>
	</div>";

		if (!empty($tampilmenu)) {echo $teks1.$teks2;}
		else {
			if (empty($text)) {echo $teks1;}
			if ($text) {echo $teks2;}
		}
}

//=========================================================================//
function printsetup($id_pasien) {
		
		$teks =  "<div class='center'>
		<p><a class=\"btnPrint tombolInput center\" href='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'>Print Kartu Pasien</a></p>
		
		<p><img src='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'/></p>
		</div>";
echo $teks;
}
		
		
//=========================================================================//
function formulir() {
		global $sql;

		include (c_INCDIR."class.form.php");
		$form = new form_class;
		
		$teks =  "

<form method='post' action='". c_SELF ."'>

<div class=\"form-wrap\">
<h2>Informasi Pasien</h2>
	 
	<div class=\"form_col_1\">
		<label for=\"nama_lengkap\">Nama Lengkap</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("nama_lengkap") ."	
	</div>	
	<div class=\"clear\"></div><br/>

	<div class=\"form_col_1\">
		<label for=\"nama_lengkap\">Nama Orang Tua</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("orang_tua") ."	
	</div>	
	<div class=\"clear\"></div><br/>
	
	
	<div class=\"form_col_1\">
		<label for=\"id_card\">Nomer Identitas</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("id_card") .
			$form->buka_select(jenis_card) . 
			$form -> option("SELECT") .
			$form -> option("KTP", "", "ktp") .
			$form -> option("e-KTP", "", "ektp") .
			$form -> option("SIM", "", "sim") .
			$form -> option("PASSPORT", "", "passport") .
			$form -> option("AKTE", "", "akte") .
			$form -> tutup_select() ."
	</div>	
	<div class=\"clear\"></div><br/>
	
	
	<div class=\"form_col_1\">
		<label for=\"tempat_lahir\">Tempat / Tanggal Lahir</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("tempat_lahir") ."<br/>
		". $form->buka_select(tanggal_lahir);
		
		for($i = 1; $i <= 31; $i++){
			$teks .= $form -> option($i,"", $i);
		}
		
		$teks .= $form -> tutup_select() ."
		
		". $form->buka_select(bulan_lahir) . 
			$form -> option("Jan", "", "01") .
			$form -> option("Feb", "", "02") .
			$form -> option("Mar", "", "03") .
			$form -> option("Apr", "", "04") .
			$form -> option("May", "", "05") .
			$form -> option("Jun", "", "06") .
			$form -> option("Jul", "", "07") .
			$form -> option("Agt", "", "08") .
			$form -> option("Sep", "", "09") .
			$form -> option("Okt", "", "10") .
			$form -> option("Nov", "", "11") .
			$form -> option("Des", "", "12") .
		$form -> tutup_select() ."
		". $form->buka_select(tahun_lahir);
		
		for($i = date("Y"); $i >= 1900; $i--){
			$teks .= $form -> option($i,"", $i);
		}
		
		$teks .= $form -> tutup_select() ."
	<p>Tempat lahir - Tanggal / Bulan / Tahun</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	
	<div class=\"form_col_1\">
		<label for=\"gender\">Jenis Kelamin</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> radio("gender","L", 1, "Laki-laki") ."
		". $form -> radio("gender","P", 0, "Perempuan") ."
	</div>	
	<div class=\"clear\"></div><br/>
	
	
	<div class=\"form_col_1\">
		<label for=\"alamat_pasien_jl\">Alamat Pasien</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> textarea("alamat_pasien_jl",30,2) ."<br/>
		<span>RT.</span>". $form -> text("alamat_pasien_rt",3) ."
		<span>/ RW.</span>". $form -> text("alamat_pasien_rw",3) ."
		<em>Dalam Angka (bukan romawi)</em><br/>
	</div>	
	<div class=\"clear\"></div>
	
	
	<div class=\"form_col_1\">
		<label for=\"alamat_pasien_kel\">Kelurahan</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("alamat_pasien_kel") ."
	</div>	
	<div class=\"clear\"></div>
	
	
	<div class=\"form_col_1\">
		<label for=\"alamat_pasien_kec\">Kecamatan</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("alamat_pasien_kec",20) ."
	</div>	
	<div class=\"clear\"></div>
	
	
	<div class=\"form_col_1\">
		<label for=\"alamat_pasien_kota\">Kota</label>
	</div>
	<div class=\"form_col_2\">
	". $form -> text("alamat_pasien_kota","","Pontianak") ."
	</div>	
	<div class=\"clear\"></div><br/>
	
	
	<div class=\"form_col_1\">
		<label for=\"no_telp\">No. Telp</label>
	</div>
	<div class=\"form_col_2\">
	". $form -> text("no_telp") ."
	</div>	
	<div class=\"clear\"></div>

<br class='clear'/>
<h2>Unit Pelayanan</h2>

	<label for=\"tujuan_pelayanan\">Tujuan Unit Pelayanan</label><p>
	". $form->buka_select(tujuan_pelayanan,"w350");		

		$sql -> db_Select("info_modul", "*", "code_modul LIKE 'dokter%'");
		while($row = $sql-> db_Fetch()){
			$teks .= $form -> option($row['nama_modul'], "", $row['code_modul']);
		}

		$teks .= $form -> tutup_select() ."</p>	
	<div class=\"clear\"></div>
	<br/>
	
	<label for=\"keluhan_pasien\">Keluhan Pasien</label>
	<p>". $form -> textarea("keluhan_pasien",50,2) ."</p>	
	<div class=\"clear\"></div>
	<br/>
	
	<label for=\"rujukan\">Rujukan Dari</label>
	<p>". $form->buka_select(rujukan,"w350") . 
		$form -> option("UMUM", "", "umum") .
		$form -> option("Puskesmas", "", "puskesmas") .
		$form -> option("Rumah Sakit", "", "rumahsakit") .
		$form -> option("Klinik Dokter", "", "swasta") .
		$form -> tutup_select() ."</p>	
	<div class=\"clear\"></div>
	<br/>
	
	<label for=\"klasifikasi\">Klasifikasi Pasien</label>
	<p>". $form->buka_select(klasifikasi,"w350") . 
		$form -> option("UMUM", "", "umum") .
		$form -> option("ASKES", "", "askes") .
		$form -> option("JAMKESMAS", "", "jamkesmas") .
		$form -> tutup_select() ."</p>
	<span>(Klasifikasi Jenis Payment Issue)</span>
	<div class=\"clear\"></div>
	<br/>
	
<br class='clear'/>
<h2>Keperluan Pasien</h2>

	
	<label for=\"keperluan\">Keperluan ke UP4</label>
	<p>". $form->buka_select(keperluan,"w350") . 
		$form -> option("Keperluan Berobat", "", "berobat") .
		$form -> option("Persyaratan Bekerja", "", "syarat_kerja") .
		$form -> option("Persyaratan Sekolah", "", "syarat_sekolah") .
		$form -> option("Persyaratan Naik Haji", "", "syarat_naikhaji") .
		$form -> option("Lain-lain", "", "dll") .
		$form -> tutup_select() ."</p>
	<div class=\"clear\"></div>
	<br/>
	
	<label for=\"desc\">Informasi Lainnya</label>
	<p>". $form -> textarea("desc",50,2) ."</p>
	<span>Kosongkan jika tidak ada</span>
	<div class=\"clear\"></div>
	
	<p class='submit'>".$form -> button("submit", "tambahsubmit", " INPUT KE DATABASE ") ."</p>

</div>
</form>
";
echo $teks;
}

//=========================================================================//

function inputproses($nama_lengkap){
	
	if(empty($_POST['nama_lengkap'])){
		$row = array("kosong1");
		return $row;
	}
	  
  $nama_lengkap = ereg_replace("\sOR\s|\=|\#", "", $nama_lengkap);
	}

//end class
}
//=========================================================================//

?>
