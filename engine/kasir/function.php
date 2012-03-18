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


class AdminTblKanan{
	
	function Halo(){
		$teks = "
		<div class='wp100 pad2em bg-abu2-1 li_uppercase'>
		<ul>
			<li>Contact Support</li>
			<li>Support Programs</li>
		</ul>
		</div>";
		echo $teks;
	}
	
	function Buka(){
		$teks = "<div id='kanan' class='w337 alignleft'>";
		echo $teks;
	}
	function Tutup(){
		$teks = "<div class=\"clear\"></div></div><div class=\"clear\"></div>
		<div class=\"tutup_kanan\"></div>\n";
		echo $teks;
	}
}

?>