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

@include ("../inc/qapuas.php");
require_once(c_ADMINDIR."auth.php");

$Tengah = new AdminTblTengah;
$Tengah->Buka();

//================================================================================//

if(!OP) {
	echo "Anda Tidak Memiliki Cukup Akses Untuk Melihat Halaman Ini";
}

//=========================================================================//

else {
	$tambahop = new tambahop;
	
	$tmp = explode(".", c_QUERY);
	$tmp1 = $tmp[0];
	$tmp2 = $tmp[1];
	$tmp3 = $tmp[2];

}

//=========================================================================//

	if($_POST['update']){
		
		$row = $authresult = $tambahop -> proses($_POST['opnama'], $_POST['opnick'], $_POST['pass1'], $_POST['pass2'], $_POST['opemail']);
		if($row[0] == "passgasama"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?slh1'</script>\n";
		}else if($row[0] == "passpendek"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?slh2'</script>\n";
		}else if($row[0] == "salahemail"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?slh3'</script>\n";
		}else if($row[0] == "kosong1"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg1'</script>\n";
		}else if($row[0] == "kosong2"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg2'</script>\n";
		}else if($row[0] == "kosong3"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg3'</script>\n";
		}else if($row[0] == "kosong4"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg4'</script>\n";
		}else if($row[0] == "kosong5"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg5'</script>\n";
		}else if($row[0] == "kosong6"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg6'</script>\n";
		}else{

			if(!empty($_POST['pass1'])) {
				$sandiOP = md5(md5($_POST['pass1']));
				
				$sql -> db_Update("www_operator", "
				`op_nick`='".$_POST['opnick']."', 
				`op_password`='".$sandiOP."', 
				`op_email`='".$_POST['opemail']."', 
				`op_pwchange`='".time()."' 
				WHERE `op_id`='".OPID."' ");
			}else {
				$sql -> db_Update("www_operator", "
				`op_nick`='".$_POST['opnick']."', 
				`op_email`='".$_POST['opemail']."' 
				WHERE `op_id`='".OPID."' ");
			}

		}
		echo "<script type='text/javascript'>document.location.href='". c_ADMINDIR ."?gantipaswordberhasil'</script>\n";
	}

//=========================================================================//

	if(c_QUERY == "ksg1"){
		$tambahop -> judul("NAMA TIDAK TERISI DENGAN BENAR, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "ksg2"){
		$tambahop -> judul("NAMA PANJANG TIDAK TERISI, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "ksg3"){
		$tambahop -> judul("MASUKKAN PASSWORD 1, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "ksg4"){
		$tambahop -> judul("MASUKKAN PASSWORD 2, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "slh1"){
		$tambahop -> judul("PASSWORD 1 DAN PASSWORD 2 TIDAK SAMA, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "slh2"){
		$tambahop -> judul("PASSWORD TIDAK BOLEH KURANG DARI 3 KARAKTER, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "slh3"){
		$tambahop -> judul("FORMAT EMAIL YANG DIMASUKKAN SALAH, ULANGI PENGISIAN", 1, 1);
		$tambahop -> edit();
	}
	if(c_QUERY == "goup"){
		$tambahop -> judul("DATA OPERATOR BERHASIL DI UBAH", 1);
		$tambahop -> edit();
	}
	if(c_QUERY == ""){
        $tambahop -> judul();
        $tambahop -> edit();
	}


$Tengah->Tutup();
include(AdminFooter);

//=========================================================================//


class tambahop{

//=========================================================================//
function edit() {
		global $pengaturan;
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("www_operator", "*", "op_id='".OPID."'");
		$result = $sql -> db_Fetch(); extract($result);
		
		$teks =  "
<h2>
	<ul>
		<li>Level Operator anda adalah ".OPLEVEL."</li>
		<li>Total Login berjumlah ".OPKUNJUNGAN." kali</li>
		<li>Terdaftar ".$pengaturan->_ago(OPJOIN)." yg lalu</li>
		<li>Login ".$pengaturan->_ago(OPTERAKHIRLOGIN)." yg lalu (".OPIP.")</li>
	</ul>
</h2>

". $form->buka("post", c_SELF) . $form->hidden("id", $op_id) ."
<div class=\"form-wrap\">

	<div class=\"form_col_1\">
		<label for=\"opnama\">User ID</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnama", "", $op_nama, "","","","","readonly", "readonly") ."
	<em>User ID tidak dapat di-ubah.</em>
	</div>
	
	<div class=\"form_col_1\">
		<label for=\"opnick\">Nama Lengkap</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnick", "", $op_nick) ."
	<p>Masukkan Nama Lengkap Anda</p>
	</div>
	
	<div class=\"form_col_1\">
		<label for=\"pass1\">Ganti Password</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("pass1") ." <em>Minimal 3 karakter</em>
	<p>Kosongkan jika tidak ingin mengubah.</p>
	</div>
	
	<div class=\"form_col_1\">
		<label for=\"pass2\">Ulangi Password</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("pass2") ." <em>Password harus sama</em>
	<p>Kosongkan jika tidak ingin mengubah.</p>
	</div>
	
	<div class=\"form_col_1\">
		<label for=\"opemail\">Email User</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opemail", "", $op_email,"","","","",'code') ."
	<p>Masukkan Email Anda, Jika ada</p>
	</div>
	
	<div class='center'><p class='submit'>".$form -> button("submit", "update", " Update Data ") ."</p></div>

</div>
</form>
";
echo $teks;
}

//=========================================================================//
function judul($text="", $tampilmenu="", $icon="") {
		
		$teks1 = "
<div id=\"index\" class='w720'>
	<div id=\"icon-users\" class=\"icon99\"></div>
	<h2>Profil ".OPNICK."</h2>
</div>

<div id='content' class='maxw747 base'>
<div id='main' class='w720 alignleft pad1em'>";

		$teks2 = "
	<div class='center'>
	<h2>RESPON SERVER : ";

		if (!empty($icon)){ 
			$teks2 .= "
			<img src='".c_IMAGESDIR."original/!.gif'>";}

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

function proses($opnnick, $pass1="", $pass2="", $opemail=""){
	
	if(empty($_POST['opnick'])){
		$row = array("kosong2");
		return $row;
	}


	if(!empty($_POST['pass1'])) {
		if(strlen($_POST['pass1']) < 2 && $_POST['pass1'] !=""){
			$row = array("passpendek");
			$pass1 = "";
			$pass2 = "";
			return $row;
		}
		
		if(empty($_POST['pass2'])){
			$row = array("kosong4");
			return $row;
		}
		
		if($_POST['pass1'] != $_POST['pass2']){
			$row = array("passgasama");
		return $row;
		}
	}
	
	if(!empty($_POST['opemail'])) {
		if(!preg_match('/^[-!#$%&\'*+\\.\/0-9=?A-Z^_`{|}~]+@([-0-9A-Z]+\.)+([0-9A-Z]){2,4}$/i', $_POST['opemail'])){
		 $row = array("salahemail");
		 return $row;
		}
	}
  
  $opnama = ereg_replace("\sOR\s|\=|\#", "", $opnama);
	}

//end class
}
//=========================================================================//

?>
