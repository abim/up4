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
	<div id=\"icon-index\" class=\"icon99\"></div>
	<h2>".$module_conf['name']."</h2>
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

$teks .= $SHOW -> record();

	echo $teks;
	
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
		//$kanan -> ANTRIAN(pending);
		$kanan -> ANTRIAN(active);
		$kanan -> LAST_ACTIVE();
	}
	$kanan -> Tutup();	
}



include(AdminFooter);

class SHOW_CLASS{

//=========================================================================//
function record($halaman="0") {
global $module_conf;

$sql = new db;
$sql2 = new db;
$pengaturan = new strf;

$teks = "
<h2>Daftar Antrian {$module_conf['name']}</h2>";

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("info_current_status JOIN info_pasien AS pasien ON info_current_status.id_pasien = pasien.id_pasien", "pasien.nama_pasien AS nama, pasien.alamat_jl, pasien.tanggal_lahir, info_current_status.status, code_checkin, now_date, info_current_status.id_pasien AS id", "posisi = '{$module_conf['level']}' AND info_current_status.status != 'done' ORDER BY info_current_status.status AND `now_date` ASC");

	$teks .= "
	<table id='DataTable' class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col' class='no'>No</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class='num tgl'>Umur</th>
		<th scope='col' class='num tgl'>Lama Antrian</th>
		<th scope='col' class='num tgl'>Status</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>No</th>
		<th scope='col'>Nama Panjang</th>
		<th scope='col' class='num'>Umur</th>
		<th scope='col' class='num'>Lama Antrian</th>
		<th scope='col' class='num'>Status</th>
		</tr>
	</tfoot>

	<tbody>";
	$i=1;

	while($row = $sql-> db_Fetch()){

		$teks .= "
		<tr $jav>
			<td>". $i ."</td>
			<td>
				<a class='row-title tooltip' href=\"form.php?checkin.{$row['code_checkin']}\" title=\"U P 4 &mdash; {$row['id']} - Terdaftar ".$pengaturan->_ago($row['create_date'])." yang lalu\">{$row['nama']}</a>
				<br />
				<div class=\"row-actions\">
					".$row['alamat_jl']."
				</div>
			</td>
			<td class=\"num\">".$pengaturan->umur($row['tanggal_lahir'])." thn</td>
			<td class=\"num\">".$pengaturan->_ago($row['now_date'])."</td>
			<td class=\"num\">".$row['status']."</td>
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