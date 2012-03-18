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

@include("conf.php");

$Tengah = new AdminTblTengah;
$Tengah->Buka();

$pengaturan = new strf;

if(OP){

$view = new view;

$tmp = explode(".", c_QUERY);
$tmp1 = $tmp[0];
$tmp2 = $tmp[1];
$tmp3 = $tmp[2];
	
$teks = "

<div id=\"index\" class='{$width['section']}'>
	<div id=\"icon-themes\" class=\"icon99\"></div>
	<h2>Informasi Pasien</h2>
</div>
<div id='content' class='{$width['white']} white'>
<div id='main' class='{$width['section']} alignleft pad1em'>";

$teks .= "

<div class=\"other ui-corner-all\">
	<ul id=\"dashboard-buttons\">
		<li><a href=\"info_pasien.php?umum.{$tmp2}\" class=\"Clipboard_3 tooltip\" title=\"Informasi Umum\">Info Umum</a></li>
		<li><a href=\"info_pasien.php?history.{$tmp2}\" class=\"Chart_4 tooltip\" title=\"Catatan Kunjungan Pasien\">History</a></li>
	</ul>
	<div class=\"clear\"></div>
</div>";


if($tmp1 == "umum"){
	if (!empty($tmp2)) {
		$teks .= $view -> umum($tmp2);
	}else{
		$view -> page404("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1,1);
	}
}

if($tmp1 == "history"){
	if (!empty($tmp2)) {
		$teks .= $view -> history($tmp2);
	}else{
		$view -> page404("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1,1);
	}
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
		$kanan -> LAST_PASIEN_REGISTER();
		$kanan -> ANTRIAN_DOKTER();
		$kanan -> LAST_ACTIVE();
	}
	$kanan -> Tutup();	
}



include(AdminFooter);

//=========================================================================//
class view{
//=========================================================================//
function page404() {
		
	$teks = "<h2>404</h2>";
	return $teks;
}

//=========================================================================//
function umum($id) {
		global $pengaturan;
		$sql = new db;
		
		$sql -> db_Select("info_pasien", "*", "id_pasien='$id'");
		
		if($sql->db_Rows() > 0) {
		
		$result = $sql -> db_Fetch();
		extract($result);
		
		$teks = "
<h2>".$nama_pasien."</h2>

<div class='pad10px bg-abu2-1'>
	<div class=\"form_col_1\">Nama Lengkap</div>
	<div class=\"form_col_2\">{$nama_pasien}</div><br class='clear'/>
</div>

<div class='pad10px'>
	<div class=\"form_col_1 uppercase\">No {$jenis_card}</div>
	<div class=\"form_col_2\">{$id_card}</div><br class='clear'/>
</div>

<div class='pad10px bg-abu2-1'>
	<div class=\"form_col_1\">Umur</div>
	<div class=\"form_col_2\">".$pengaturan->umur($tanggal_lahir)." Tahun</div><br class='clear'/>
</div>

<div class='pad10px'>
	<div class=\"form_col_1\">Tempat Tanggal Lahir</div>
	<div class=\"form_col_2\">{$tempat_lahir}, ".$pengaturan->tanggal_lahir($tanggal_lahir)."</div><br class='clear'/>
</div>

<div class='pad10px bg-abu2-1'>
	<div class=\"form_col_1\">Jenis Kelamin</div>
	<div class=\"form_col_2\">".$pengaturan->gender($gender)."</div><br class='clear'/>
</div>

<div class='pad10px'>
	<div class=\"form_col_1\">Alamat</div>
	<div class=\"form_col_2\">{$alamat_jl}<br/>
	".($alamat_rt ? "RT. {$alamat_rt}" : "").($alamat_rw ? "/RW. {$alamat_rw}" : "")."<br/>".($alamat_kelurahan ? " Kel. {$alamat_kelurahan}" : "").($alamat_kecamatan ? " Kec. {$alamat_kecamatan}" : "")."<br/>{$alamat_kota}<br/>".($alamat_telp ? "Telp. {$alamat_telp}" : "")."</div><br class='clear'/>
</div>

<div><img src='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'></div>";

include (c_INCDIR."class.form.php");
$form = new form_class;
$teks .= "
<p class='center'><a class=\"btnPrint tombolInput center\" href='".c_UPLOADDIR."/kartupasien/UP4-{$id_pasien}.png'>Print Kartu Pasien</a></p>
";
}
else{
	$teks = $this->page404();
}
	return $teks;
}

function history($id) {
		global $pengaturan;
		$sql = new db;
		
		$sql -> db_Select("info_pasien", "id_pasien", "id_pasien='{$id}'");
		
		if($sql->db_Rows() > 0) {
		
		$sql2 = new db;		
		$sql2 -> db_Select("info_checkin", "code_checkin, create_date", "id_pasien='{$id}' ORDER BY create_date DESC");
		
		$total_checkin = $sql2->db_Rows();		
		$teks = "Total Checkin: {$total_checkin}";
		
		while($row2 = $sql2-> db_Fetch()){
			$tanggal = $pengaturan->_ago($row2['create_date']);
			
			$teks .= "<h2>{$tanggal} yang Lalu</h2>";
			
			$sql3 = new db;
			$sql3 -> db_Select("info_history", "posisi, current_date, status", "code_checkin='{$row2['code_checkin']}' ORDER BY current_date ASC");
			
			$teks .= "<ul>";
			while($row3 = $sql3-> db_Fetch()){
				$tanggal3 = $row3['current_date'];
				$status = $row3['status'];
				$posisi = $row3['posisi'];
				
				$teks .= "<li>{$status} - {$posisi} (".$row3['current_date'].")</li>";
			}
			$teks .= "</ul>";
			
		}
	}
		
else{
	$teks = $this->page404();
}
	return $teks;
}

}//end class view
?>