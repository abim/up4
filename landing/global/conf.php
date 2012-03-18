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

define ("AdminGlobalDIR", c_ADMINDIR."global/");
define ("AdminHeader", AdminGlobalDIR."header.php");
define ("AdminFooter", AdminGlobalDIR."footer.php");

//-------------------------------------------//
class AdminTblTengah{
	
	function Buka(){
		$teks = "<div id='tengah'>";
		echo $teks;
	}

	function Tutup(){
		$teks = "<div class=\"clear\"></div></div>\n";
		//$teks .= "</div>\n";//end white
		echo $teks;
	}
}
?>