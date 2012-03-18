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

@include("../statistics.class.php");
$statistics = new STATISTICS;

	echo $teks;
	$statistics -> POPULASI_KELAMIN_UMUR();	
	$statistics -> STAT_LINE_BASIC();
}
$Tengah->Tutup();

//K A N A N
if($kanan==TRUE){
	
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
?>