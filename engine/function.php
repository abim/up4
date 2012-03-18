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

function LI_LAST_PASIEN_REGISTER(){
	global $sql, $pengaturan;
	$teks = '';
	
	$sql -> db_Select("info_pasien", "id_pasien, nama_pasien, create_date", "status='1' ORDER BY create_date DESC LIMIT 5");
	
	while($row = $sql-> db_Fetch()){
		$teks .= "<li><a class='tooltip' href=\"".c_MODULEDIR."loket/info_pasien.php?umum.{$row['id_pasien']}\" title=\"U P 4 &mdash; {$row['id_pasien']} - Terdaftar ".$pengaturan->_ago($row['create_date'])." yang lalu\">{$row['nama_pasien']}</a></li>
	";
	}
	return $teks;
}
?>