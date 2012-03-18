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

if(OPFOLDER !="admin"){
	echo "<script type='text/javascript'>document.location.href='".c_MODULEURL.OPFOLDER."'</script>\n";
}

$Tengah = new AdminTblTengah;
$Tengah->Buka();

$pengaturan = new strf;
$homeadmin = new homeadmin;
if(ADMIN){
	
$teks = "

<div id=\"index\" class='w600'>
	<div id=\"icon-index\" class=\"icon99\"></div>
	<h2>ADMINISTRATOR</h2>
</div>
<div id='content' class='w627 white'>
<div id='main' class='w600 alignleft pad1em'>";

$teks .= "
<div class=\"other ui-corner-all bg-hijau-1 bor-hijau-1\">
	<ul id=\"dashboard-buttons\">
		
		<li><a href=\"".c_MODULEDIR."loket/baru.php\" class=\"Clipboard_3 tooltip\" title=\"Input data Pasien Baru\">Pendaftaran</a></li>
		<li><a href=\"".c_MODULEDIR."loket/search.php\" class=\"Glass tooltip\" title=\"Pencarian Pasien\">Cari</a></li>
		<li><a href=\"".c_MODULEDIR."loket/checkin.php\" class=\"Box_recycle tooltip\" title=\"Checkin Pasien Lama\">Checkin</a></li>
		
		
		<li><a href=\"#\" class=\"Book_phones tooltip\" title=\"Daftar Antrian Seluruh Unit\">Antrian</a></li>
		<li><a href=\"#\" class=\"Chart_4 tooltip\" title=\"Statistik\">Statistik</a></li>
		<li><a href=\"#\" class=\"Books tooltip\" title=\"x\">x</a></li>
		<li><a href=\"".c_ADMINDIR."setting/diskon.php\" class=\"Box_content tooltip\" title=\"unit Pembayaran - Contoh: ASKES, JAMKESMAS\">Pembayaran</a></li>
		<li><a href=\"".c_ADMINDIR."setting/harga.php\" class=\"Briefcase_files tooltip\" title=\"x\">Harga</a></li>
		<li><a href=\"#\" class=\"Chart_5 tooltip\" title=\"x\">x</a></li>
		<li><a href=\"#\" class=\"Globe tooltip\" title=\"x\">x</a></li>
		<li><a href=\"#\" class=\"Mail_compose tooltip\" title=\"Tulis Pesan ke Operator Lain\">Kirim Surat</a></li>
		<li><a href=\"#\" class=\"Mail_open tooltip\" title=\"Kotak Surat anda\">Inbox</a></li>
		<li><a href=\"#\" class=\"Monitor tooltip\" title=\"System Monitoring\">System</a></li>
		<li><a href=\"". c_ADMINDIR ."op.php\" class=\"Star tooltip\" title=\"Operator\">Operator</a><div class=\"clear\"></div></li>
	</ul>
	<div class=\"clear\"></div>
</div>


";

if((OPPWCHANGE+2592000) < time()) {
	$teks .= "
<div class='response-msg notice'>
	<span>Untuk keamanan, Silakan ganti password anda secara berkala.</span>
	Password anda telah 30 hari Tidak diGanti. <a href='". c_MODULEDIR ."op.php'>Ubah Password disini</a>.<br/>
	Terakhir di Ubah Pada tanggal ".$pengaturan->waktu(OPPWCHANGE, "tampil")."
</div>";
}

$teks .= "

<div class='response-msg inf'>
	<span>".OPNICK."</span>
	Total Login berjumlah ".OPKUNJUNGAN." kali, Sejak Anda Terdaftar Pada ".$pengaturan->waktu(OPJOIN, "pendek")." sebagai ".OPLEVEL.".<br/>
	Anda Login Terakhir menggunakan alamat IP ".OPIP.", pada ".$pengaturan->waktu(OPTERAKHIRLOGIN, "tampil")." 
</div>";

	echo $teks;
	
}
$Tengah->Tutup();
include(AdminFooter);

class homeadmin{
//==================================================================================================================//
function judul($type="", $judul="", $text="", $icon="", $align="left") {
		$teks1 = "
	<div id=\"icon-index\" class=\"icon99\"><br /></div>
	<h2>Control Panel</h2>";

		$teks2 = "
		<div id=\"kotak\" class=\"kotak-all kotak_kuning ui-pojok-bundar\">
		<div class=\"cont ui-pojok-bundar\">
		<h3>".$judul."</h3>
		".$text."
		</div>
		</div>
		";
		
		$teks_info = "
		<div class=\"response-msg inf ui-pojok-bundar\"><span>".$judul."</span>
		".$text."
		</div>
		";
		
		$teks_eror = "
		<div class=\"response-msg error ui-pojok-bundar\">
		<span>".$judul."</span>
		".$text."
		</div>
		";
		
		$teks_notice = "
		<div class=\"response-msg notice ui-pojok-bundar\">
		<span>".$judul."</span>
		".$text."
		</div>
		";
		
		$teks_sukses = "
		<div class=\"response-msg success ui-pojok-bundar\">
		<span>".$judul."</span>
		".$text."
		</div>
		";
		
		
		
		if($type == "msg"){
			return $teks2;
		}elseif($type == "msg_info"){
			return $teks_info;
		}elseif($type == "msg_eror"){
			return $teks_eror;
		}elseif($type == "msg_notice"){
			return $teks_notice;
		}elseif($type == "msg_sukses"){
			return $teks_sukses;
		}else{return $teks1;}
		
}//judul()
}//class

?>