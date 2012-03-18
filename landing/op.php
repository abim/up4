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

//=========================================================================//

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
	
	if($_POST['tambahopsubmit']){
		
		$row = $authresult = $tambahop -> proses($_POST['opnama'], $_POST['oppass1'], $_POST['oppass2'], $_POST['opemail']);
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

			$sandiOP = md5(md5($_POST['oppass1']));
			$oplevel = $_POST['oplevel'];
					
			$sql -> db_Insert("www_operator", "'0', 
			'".$_POST['opnama']."', 
			'".$_POST['opnick']."', 
			'".$sandiOP."', 
			'', 
			'".$_POST['opemail']."', 
			'', 
			'".time()."', 
			'".time()."', 
			'0', 
			'', 
			'0', 
			'0', 
			'".$oplevel."', 
			'".$oplevel."/', 
			'".time()."'
			");
			
			}
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip'</script>\n";
		}
	}

//=========================================================================//

	if($_POST['update']){
		
		/*$row = $authresult = $tambahop -> proses($_POST['opnama']);
		if($row[0] == "kosong1"){
			echo "<script type='text/javascript'>document.location.href='./op".c_EXT."?ksg1'</script>\n";
		}else{*/
		
		if(!empty($_POST['pass1'])) {
			$sandiOP = md5(md5($_POST['pass1']));
				
			$sql -> db_Update("www_operator", "
				`op_nick`='".$_POST['opnick']."', 
				`op_password`='".$sandiOP."', 
				`op_email`='".$_POST['opemail']."', 
				`op_level`='".$_POST['oplevel']."', 
				`op_folder`='".$_POST['oplevel']."/', 
				`op_pwchange`='".time()."' 
				WHERE `op_id`='".$_POST['opid']."' ");
		}else {
				$sql -> db_Update("www_operator", "
				`op_nick`='".$_POST['opnick']."', 
				`op_level`='".$_POST['oplevel']."', 
				`op_folder`='".$_POST['oplevel']."/', 
				`op_email`='".$_POST['opemail']."' 
				WHERE `op_id`='".$_POST['opid']."' ");
		}

		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?goup'</script>\n";
	}
	if($tmp1 == "edit"){
		if (!empty($tmp2)) {
			$tambahop -> judul();
			$tambahop -> edit($tmp2);
			$tambahop -> record();

		}else{
			$tambahop -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1,1);
		}
	}

//=========================================================================//
	if($_POST['hapus']){
		
		$sql -> db_Delete("www_operator", "`op_id`='".$_POST['id']."' ");
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?gohap'</script>\n";
	}
	if($tmp1 == "hapus"){
		if (!empty($tmp2)) {
			
			$tambahop -> hapus($tmp2);
		}else{
			$tambahop -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1);
		}
	}
	
//=========================================================================//

	if(c_QUERY == "ksg1"){
		$tambahop -> judul("NAMA TIDAK TERISI DENGAN BENAR, ULANGI PENGISIAN", 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "ksg2"){
		$tambahop -> judul("NAMA PANJANG TIDAK TERISI, ULANGI PENGISIAN", 1, 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "ksg3"){
		$tambahop -> judul("MASUKKAN PASSWORD 1, ULANGI PENGISIAN", 1, 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "ksg4"){
		$tambahop -> judul("MASUKKAN PASSWORD 2, ULANGI PENGISIAN", 1, 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "ksg5"){
		$tambahop -> judul("MASUKKAN LEVEL, ULANGI PENGISIAN", 1, 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "ksg6"){
		$tambahop -> judul("EMAIL TIDAK TERISI, ULANGI PENGISIAN", 1, 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "slh1"){
		$tambahop -> judul("PASSWORD 1 DAN PASSWORD 2 TIDAK SAMA, ULANGI PENGISIAN", 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "slh2"){
		$tambahop -> judul("PASSWORD TIDAK BOLEH KURANG DARI 4 KARAKTER, ULANGI PENGISIAN", 1);
		$tambahop -> formulir();
	}
	if(c_QUERY == "slh3"){
		$tambahop -> judul("FORMAT EMAIL YANG DIMASUKKAN SALAH, ULANGI PENGISIAN");
		$tambahop -> formulir();
	}
	if(c_QUERY == "goup"){
		$tambahop -> judul("DATA OPERATOR BERHASIL DI UBAH");
		$tambahop -> record();
		$tambahop -> formulir();
	}
	if(c_QUERY == "gohap"){
		$tambahop -> judul("DATA OPERATOR BERHASIL DI HAPUS");
		$tambahop -> record();
		$tambahop -> formulir();
		
	}
	if(c_QUERY == "sip"){
		$tambahop -> judul("DATA OPERATOR BERHASIL DITAMBAHKAN");
		$tambahop -> record();
		$tambahop -> formulir();
	}
	if(is_numeric(c_QUERY)){
		$tambahop -> judul();
		if(!empty($tmp1)){$tambahop -> record($tmp1);$tambahop -> formulir();}else{$tambahop -> record();$tambahop -> formulir();}
	}
	if(c_QUERY == ""){
        $tambahop -> judul();
        $tambahop -> record();
		$tambahop -> formulir();
	}


$Tengah->Tutup();
include(AdminFooter);

//=========================================================================//


class tambahop{

//=========================================================================//
function edit($id) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("www_operator", "*", "op_id='$id'");
		$result = $sql -> db_Fetch(); extract($result);
$teks =  "

<h2>Pengubahan Operator ".$op_nick."</h2>

<form method='post' action='". c_SELF ."'>
". $form->buka("post", c_SELF) . $form->hidden("opid", $op_id) ."
<div class=\"form-wrap\">

	<div class=\"form_col_1\">
		<label for=\"opnama\">User ID</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnama", "", $op_nama,"","","","","",'readonly') ."
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"opnick\">Nama Lengkap</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnick", "", $op_nick) ."
		<p>Nama Lengkap Operator</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"oppass1\">Passwords</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("oppass1") ."
		<p>Minimal 4 Karakter</p>
	</div>	
	<div class=\"clear\"></div>
	
	<div class=\"form_col_1\">
		<label for=\"oppass2\">Ulangi Passwords</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("oppass2") ."
		<p>Ulangi Pengisian Password Diatas</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"oplevel\">Rangking Level User</label><em>*</em>
	</div>
	<div class=\"form_col_2\">";
	
	$level['admin'] = "Administrator";
	$level['loket'] = "Loket";
	
	$sql2 = new db;
	$sql2 -> db_Select("info_modul", "*", "code_modul LIKE 'dokter%'");
	while($row2 = $sql2-> db_Fetch()){
		$level[$row2['code_modul']] = $row2['nama_modul'];
	}

	$level['lab'] = "Laboratorium";
	$level['radiologi'] = "Radiologi";
	$level['dot'] = "D O T";
	$level['apotek'] = "Apotek";
	$level['kasir'] = "Kasir";
	$level['tindakan'] = "Tindakan";
	
	$teks .= $form->buka_select(oplevel);
	foreach($level as $lev => $val) {
		if($op_level == $lev) {$selected_level = 1;}else{$selected_level = 0;}
		
		$teks .= $form -> option($val, $selected_level, $lev);
	}
	$teks .= $form -> tutup_select();
	
	$teks .= "<p>Operator Module</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"opemail\">Email User</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opemail", "", $op_email,"","","","",'code') ."
	<p>Masukkan Email, Jika ada</p>
	</div>
	<div class=\"clear\"></div><br/>
	
	<div class='center'><p class='submit'>".$form -> button("submit", "update", " Update Database ") ."</p></div>

</div>
</form>
";
echo $teks;
}

//=========================================================================//
function hapus($id) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("www_operator", "*", "op_id='$id'");
		$result = $sql -> db_Fetch(); extract($result);
		
		$teks =  "APAKAH ANDA YAKIN AKAN MENGHAPUS <span style='color:red;'><em>".$op_nick."</em></span> DARI DAFTAR OPERATOR?
";
		$button = "
".$form->buka("post", c_SELF)."\n
".$form->hidden("id", $op_id)."\n
".$form->button("submit", "cancel", " B A T A L ")."
".$form->button("submit", "hapus", " H A P U S  ")."
".$form->tutup()."
";

$this -> judul($teks, $button);
}

//=========================================================================//
function judul($text="", $button="") {
		
		$teks1 = "
<div id=\"index\" class='w600'>
	<div id=\"icon-users\" class=\"icon99\"></div>
	<h2>MANAGEMENT OPERATOR</h2>
</div>

<div id='content' class='w627 white'>
<div id='main' class='w600 alignleft pad1em'>";

		$teks2 = "
	<div class='center'>
	<h2>RESPON SERVER :</h2>
	
	<div class='response-msg notice'>
	".$text."
	</div>
	</div>
	";
	if (!empty($button)){ 
		$teks2 .= "<div class='center'>".$button."</div>";
	}
		
	if (empty($text)) {echo $teks1;}
	else{echo $teks1.$teks2;}	
}

//=========================================================================//
function formulir() {
		
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		
		$teks =  "

<h2>Penambahan Operator</h2>

<form method='post' action='". c_SELF ."'>
<div class=\"form-wrap\">

	<div class=\"form_col_1\">
		<label for=\"opnama\">User ID</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnama") ."	
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"opnick\">Nama Lengkap</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opnick") ."
		<p>Nama Lengkap Operator</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"oppass1\">Passwords</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("oppass1") ."
		<p>Minimal 4 Karakter</p>
	</div>	
	<div class=\"clear\"></div>
	
	<div class=\"form_col_1\">
		<label for=\"oppass2\">Ulangi Passwords</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> password("oppass2") ."
		<p>Ulangi Pengisian Password Diatas</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"oplevel\">Rangking Level User</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form->buka_select(oplevel) . 
		$form -> option("Administrator", "", "admin") .
		$form -> option("Loket", "", "loket");


		$sql2 = new db;
		$sql2 -> db_Select("info_modul", "*", "code_modul LIKE 'dokter%'");
		while($row2 = $sql2-> db_Fetch()){
			$teks .= $form -> option($row2['nama_modul'], "", $row2['code_modul']);
		}

		$teks .= $form -> option("Laboratorium", "", "lab") .
		$form -> option("Radiologi", "", "radiologi") .
		$form -> option("Tindakan", "", "tindakan") .
		$form -> option("D O T", "", "dot") .
		$form -> option("Apotek", "", "apotek") .
		$form -> option("Kasir", "", "kasir") .
		$form -> tutup_select() ."
		<p>Operator Module</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"opemail\">Email User</label>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("opemail", "", "","","","","",'code') ."
	<p>Masukkan Email, Jika ada</p>
	</div>
	<div class=\"clear\"></div><br/>
	
	<div class='center'><p class='submit'>".$form -> button("submit", "tambahopsubmit", " Input Database ") ."</p></div>

</div>
</form>
";
echo $teks;
}

//=========================================================================//
function record($halaman="0") {
$sql = new db;
$sql2 = new db;
$pengaturan = new strf;
define("ITEMVIEW", 20);
$from = (!is_numeric($halaman) || !c_QUERY ? 0 : ($halaman ? $halaman : c_QUERY));

$teks = "
<h2>Record Operator</h2>";

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("www_operator", "*", "op_id!='0' ORDER BY op_id ASC LIMIT ".$halaman.",".ITEMVIEW."");
	$sql2 -> db_Select("www_operator");
	define("ITEMTOTAL", $sql2->db_Rows());
	require_once(c_INCDIR."np.class.php");
	$satu = $halaman;
	$page = new nextprev;

	$teks .= "
	<h4>Total Operator yang terdaftar sebanyak ".ITEMTOTAL." record</h4>
	<br class='clear'>
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col' class=\"num tgl\">Username</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class=\"num tgl\">Level</th>
		<th scope='col' class=\"num tgl\">Terakhir Login</th>
		<th scope='col' class=\"num tgl\">Total Login</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>Username</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class=\"num\">Level</th>
		<th scope='col'>Terakhir Login</th>
		<th scope='col' class=\"num\">Total Login</th>
		</tr>
	</tfoot>

	<tbody>";

	while($row = $sql-> db_Fetch()){

		$teks .= "
		<tr {$jav}>
			<td class='uppercase'>". $row['op_nama'] ."
			<div class=\"row-actions\">
					<span class='edit'><a href=\"". c_SELF ."?edit.".$row['op_id']."\">Edit</a> | </span>
					<span class='delete'><a class='delete' href='". c_SELF ."?hapus.".$row['op_id']."'>Delete</a></span>
				</div>
			</td>
			<td>
				<a class='row-title' href='#' title='#'> ". $row['op_nick'] ."</a>
			</td>
			<td class=\"num\">". $row['op_level'] ."</td>
			<td>". $pengaturan -> waktu($row['op_terakhir_login'], "panjang") ."</td>
			<td class=\"num\">". $row['op_kunjungan'] ."</td>
		</tr>";

	}$teks .= "
	</tbody>
</table>
<br class=\"clear\">

";	
	$teks .= $page->tampilkan(c_SELF."?", $from, ITEMVIEW, ITEMTOTAL, "LANJUT", ($satu == "list" ? $satu.".".$dua : ""));


echo $teks;

}//end record()
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
