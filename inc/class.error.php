<?php
/*
+----------------------------------------------------------------------+
|        INDOBIT-TECHNOLOGIES
|	 	 based 		: 02-04-2005
|		 continue 	: December 2011
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
|		 Rosi Abimanyu Yusuf	(bima@abimanyu.net) | Pontianak, INDONESIA
|        ©2005 INDOBIT.COM | http://www.indobit.com
+----------------------------------------------------------------------+
*/

function seting_error($tipe, $pesan, $file, $baris, $isiteks){
	$tipe_bug = "ERROR";

	switch($tipe){
		case E_NOTICE:
			if(eregi("NOTICE", $tipe_bug)){ echo "<b>Programing Notice: </b>".$pesan.", Baris <b>".$baris."</b> Pada File <b>".$file."</b><br />"; }
		break;
		case E_WARNING:
			if(eregi("WARNING", $tipe_bug)){ echo "<b>Programing Warning: Terjadi kesalahan Yang mungkin tidak tergolong FATAL yakni </b>".$pesan.", Baris <b>".$baris."</b> Pada File <b>".$file."</b><br />"; }
		break;
		case E_ERROR:
			if(eregi("ERROR", $tipe_bug)){ echo "<b>Programing ERROR: Terjadi kesalahan FATAL yakni </b>".$pesan.", Baris <b>".$baris."</b> Pada File <b>".$file."</b><br />"; }
		break;
	}
	if(eregi("ECHOSTATE", $tipe_bug)){
		echo "<br />Ketika Sebuah Akurasi Variable Data, Terjadi Kesalahan: <br>";
		print_r($isiteks);
	}
}
?>