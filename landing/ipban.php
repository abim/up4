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
require_once("auth.php");

$Tengah = new AdminTblTengah;
$Tengah->Buka();

if(!ADMIN) {
	echo "<script type='text/javascript'>document.location.href='". c_SELF ."?noakses'</script>";
}

//==================================================================================================================//
	$flood = new flood;

	$tmp = explode(".", c_QUERY);
	$tmp1 = $tmp[0];
	$tmp2 = $tmp[1];
	$tmp3 = $tmp[2];
	
	if($_POST['ipsubmit']){
		
		$row = $authresult = $flood -> ipproses($_POST['ipban'], $_POST['alasan']);
		if($row[0] == "ipkosong"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg1'</script>\n";
		}else if($row[0] == "alasankosong"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg2'</script>\n";
		}else{

				$sql -> db_Insert("www_daftarhitam", "'0', \"".$_POST['ipban']."\", \"".OPID."\", \"".$_POST['alasan']."\", \"".time()."\" ");

		}
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip'</script>\n";
	}
	
//==================================================================================================================//
	if($_POST['update']){
		
		$row = $authresult = $flood -> ipproses($_POST['ipban'], $_POST['alasan']);
		if($row[0] == "ipkosong"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg1'</script>\n";
		}else if($row[0] == "alasankosong"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?ksg2'</script>\n";
		}else{

				$sql -> db_Update("www_daftarhitam", " `banlist_ip`='".$_POST['ipban']."', `banlist_op`='".OPID."', `banlist_alasan`='".$_POST['alasan']."', `update`='".time()."' WHERE `id`='".$_POST['id']."' ");

		}
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?goup'</script>\n";
	}
	if($tmp1 == "edit"){
		if (!empty($tmp2)) {
			$flood -> judul();
			$flood -> edit($tmp2);
			$flood -> record();
		}else{
			$flood -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1,1);
		}
	}

//==================================================================================================================//
	if($_POST['hapus']){
		
		$sql -> db_Delete("www_daftarhitam", "`id`='".$_POST['id']."' ");
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?gohap'</script>\n";
	}
	if($tmp1 == "hapus"){
		if (!empty($tmp2)) {
			//$flood -> judul();
			$flood -> hapus($tmp2);
		}else{
			$flood -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1,1);
		}
	}
	
//==================================================================================================================//

	if(c_QUERY == "ksg1"){
		$flood -> judul("ALAMAT IP TIDAK TERISI DENGAN BENAR, ULANGI PENGISIAN", 1, 1);
		$flood -> formulir();
		$flood -> record();
	}
	if(c_QUERY == "ksg2"){
		$flood -> judul("ALASAN BANNED TIDAK TERISI DENGAN BENAR, ULANGI PENGISIAN", 1, 1);
		$flood -> formulir();
		$flood -> record();
	}
	if(c_QUERY == "sip"){
		$flood -> judul("DATA IP BANNED BERHASIL DI TAMBAHKAN", 1);
		$flood -> formulir();
		$flood -> record();
	}
	if(c_QUERY == "goup"){
		$flood -> judul("DATA IP BANNED BERHASIL DI UBAH", 1);
		$flood -> formulir();
		$flood -> record();
	}
	if(c_QUERY == "gohap"){
		$flood -> judul("DATA IP BANNED BERHASIL DI HAPUS", 1);
		$flood -> formulir();
		$flood -> record();
	}
	if(c_QUERY == "noakses"){
		$flood -> judul("ANDA TIDAK MEMILIKI AKSES UNTUK MENGGUKANAN HALAMAN INI",1,1);
	}
	if(is_numeric(c_QUERY)){
		$flood -> judul();
		if(!empty($tmp1)){$flood -> formulir();$flood -> record($tmp1);}else{$flood -> formulir();$flood -> record();}
	}
	if(c_QUERY == ""){
		$flood -> judul();
		$flood -> formulir();
		$flood -> record();
	}

$Tengah->Tutup();
include(AdminFooter);

class flood{

//==================================================================================================================//
function judul($text="", $tampilmenu="", $icon="") {
		$teks1 = "
<div id=\"icon-tools\" class=\"icon99\"><br /></div>
	<h2>IP BANNED</h2>";

		$teks2 = "
	<div style=\"text-align:center\">
	<h3>RESPON SERVER</h3>";

		if (!empty($icon)){ $teks2 .= "
	<img src='".c_IMAGESDIR."original/!.gif'>";}

		$teks2 .= "
		<h3>".$text."</h3>
	</div>";

		if (!empty($tampilmenu)) {echo $teks1.$teks2;}
		else {
			if (empty($text)) {echo $teks1;}
			if ($text) {echo $teks2;}
		}
}

//==================================================================================================================//
function formulir() {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$teks =  "
<div class=\"form-wrap\">
<h3>Penambahan Baru</h3>
<br class='clear'>
<form method='post' action='". c_SELF ."'>
	<div class=\"form-field\">
		<label for=\"ipban\">Alamat IP</label>
		". $form -> text("ipban", 80) ."
	<p>". BHS_ADM_IP_Help_ip ."</p>
	</div>
	
	<div class=\"form-field\">
		<label for=\"alasan\">ALASAN BANNED</label>
		". $form -> textarea("alasan", 80, 5, "") ."
	<p>". BHS_ADM_IP_Help_alasan ."</p>
	</div>
	
	<p class='submit'>".$form -> button("submit", "ipsubmit", " Tolak IP ") ."</p>
</form>
</div>

";
echo $teks;
}

//==================================================================================================================//
function edit($id) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("www_daftarhitam", "*", "id='$id'");
		$result = $sql -> db_Fetch(); extract($result);
		
		$teks =  "

<div class=\"form-wrap\">
<h3>Pengubahan IP Banned: ". $banlist_ip ."</h3>
<br class='clear'>
". $form -> buka("post", c_SELF) . $form -> hidden("id", $id) ."

	<div class=\"form-field\">
		<label for=\"ipban\">Alamat IP</label>
		". $form -> text("ipban", 80, $banlist_ip) ."
	<p>". BHS_ADM_IP_Help_ip ."</p>
	</div>
	
	<div class=\"form-field\">
		<label for=\"alasan\">ALASAN BANNED</label>
		". $form -> textarea("alasan", 80, 5, $banlist_alasan) ."
	<p>". BHS_ADM_IP_Help_alasan ."</p>
	</div>
	
	<p class='submit'>".$form -> button("submit", "update", " Update ") ."</p>
</form>
</div>

";
echo $teks;
}

//==================================================================================================================//
function hapus($id) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("www_daftarhitam", "*", "id='$id'");
		$result = $sql -> db_Fetch(); extract($result);
		
		$teks =  "Apakah anda yakin untuk Menghapus Firewall dari IP ".$banlist_ip."
		
<div style='text-align:center'>
".$form->buka("post", c_SELF)."\n
".$form->hidden("id", $id)."\n
".$form->button("submit", "cancel", " B A T A L ")."
".$form->button("submit", "hapus", " H A P U S ")."
".$form->tutup()."
</div>
";

$this -> judul($teks, 1,1);
}

//==================================================================================================================//
function ipproses($ip, $alasan){
	
	if(empty($_POST['ipban'])){
		$row = array("ipkosong");
		return $row;
	}
	if(empty($_POST['alasan'])){
		$row = array("alasankosong");
		return $row;
	}

}//end ipproses()

//==================================================================================================================//
function record($halaman="0") {
$sql = new db;
$sql2 = new db;
$pengaturan = new strf;
define("ITEMVIEW", 10);
$from = (!is_numeric($halaman) || !c_QUERY ? 0 : ($halaman ? $halaman : c_QUERY));

$teks = "
<div class=\"form-wrap\">

<h3>Report Firewall</h3>
<br class='clear'>
";

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("www_daftarhitam", "*", "id!='0' ORDER BY id DESC LIMIT ".$halaman.",".ITEMVIEW."");
	$sql2 -> db_Select("www_daftarhitam");
	define("ITEMTOTAL", $sql2->db_Rows());
	require_once(c_INCDIR."np.class.php");
	$satu = $halaman;
	$page = new nextprev;

	$teks .= "	
	<h4>Total Firewall yang terpasang sebanyak ".ITEMTOTAL." IP</h4>
	<br class='clear'>
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col'>Alamat IP</th>
		<th scope='col'>Eksekutor</th>
		<th scope='col' class=\"num\">IP ID</th>
		<th scope='col'>Update</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>Alamat IP</th>
		<th scope='col'>Eksekutor</th>
		<th scope='col' class=\"num\">IP ID</th>
		<th scope='col'>Update</th>
		</tr>
	</tfoot>

	<tbody>";

	while($row = $sql-> db_Fetch()){

		$teks .= "
		<tr $jav>
			<td>
				<a class='row-title' href='#' title='#'> ". $row['banlist_ip'] ."</a>
				<br />
				<div class=\"row-actions\">
					<span class='edit'><a href=\"". c_SELF ."?edit.".$row['id']."\">Edit</a> | </span>
					<span class='delete'><a class='delete' href='". c_SELF ."?hapus.".$row['id']."'>Delete</a></span>
				</div>
			</td>
			<td>". $pengaturan -> nickop($row['banlist_op']) ."</td>
			<td class=\"num\">".$row['id']."</td>
			<td>". $pengaturan -> waktu($row['update'], "panjang") ."</td>
		</tr>
		";

	}$teks .= "
	</tbody>
</table>
<br class=\"clear\">";	
	$teks .= $page->tampilkan(c_SELF ."?", $from, ITEMVIEW, ITEMTOTAL, "LANJUT", ($satu == "list" ? $satu.".".$dua : ""));
	$teks .= "</div>";

echo $teks;

}//end record()

}//end class
?>