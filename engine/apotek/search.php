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
	<div id=\"icon-page\" class=\"icon99\"></div>
	<h2>".$module_conf['name']." Search</h2>
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
}else{$teks .= $SHOW -> formsearch();}


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
<h2>Pencarian Data Pasien</h2>

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
function record($searchtext) {
$sql = new db;
$sql2 = new db;

$pengaturan = new strf;

$teks = "
<h2>Hasil Pencarian Database : {$searchtext}</h2>";

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("info_pasien", "*", "`nama_pasien` LIKE '%".$searchtext."%'  ORDER BY create_date DESC");

	$teks .= "
	<table id='DataTable' class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col' class='no'>No</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class='num tgl'>Tanggal lahir</th>
		<th scope='col' class='num tgl'>Terdaftar</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>No</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class='num'>Tanggal lahir</th>
		<th scope='col' class='num'>Terdaftar</th>
		</tr>
	</tfoot>

	<tbody>";
	
	$i=1;
	while($row = $sql-> db_Fetch()){

		
		$code_checkin = $pengaturan -> COMOT (info_checkin, "code_checkin","id_pasien='{$row['id_pasien']} ORDER BY tanggal_checkin DESC LIMIT 1'");
		
		$teks .= "
		<tr $jav>
			<td>". $i ."</td>
			<td>
				<a class='row-title tooltip' href=\"form.php?checkin.{$code_checkin}\" title=\"U P 4 &mdash; {$row['id_pasien']} - Terdaftar ".$pengaturan->_ago($row['create_date'])." yang lalu\">{$row['nama_pasien']}</a>
				<br />
				<div class=\"row-actions\">
					".$row['alamat_jl']."
				</div>
			</td>
			<td class=\"num\">".$row['tanggal_lahir']."</td>
			<td class=\"num\">". $pengaturan -> waktu($row['create_date'], "panjang") ."</td>
		</tr>";
		$i++;

	}$teks .= "
	</tbody>
</table>
<br class=\"clear\">

";

return $teks;

}//end record()
//=========================================================================//
}//end Class
?>