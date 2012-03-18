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

require_once(c_MODULEDIR."function.php");

class AdminTblKanan{
	
	function LAST_PASIEN_REGISTER(){
		$teks = "
		<div class='wp100 pad10px bg-abu2-1 bor_bottom1'>
		<h3 class='uppercase'>ADMIN Pasien Pendaftar Terbaru</h3>
		<ul>
			".LI_LAST_PASIEN_REGISTER()."
		</ul>
		total antrian: 29
		</div>";
		
		echo $teks;
	}
	
	function LAST_PASIEN_STATUS(){
		$teks = "
		<div class='wp100 pad10px bg-abu2-1 bor_bottom1'>
		<h3 class='uppercase'>Aktifitas Pasien Terkini</h3>
		<ul>
			".LI_LAST_PASIEN_REGISTER()."
		</ul>
		total antrian: 29
		</div>";
		
		echo $teks;
	}
	
	function Buka(){
		$teks = "<div id='kanan' class='w353 alignleft'>";
		echo $teks;
	}
	function Tutup(){
		$teks = "<div class=\"clear\"></div></div><div class=\"clear\"></div>
		<div class=\"tutup_kanan\"></div>\n";
		echo $teks;
	}
}