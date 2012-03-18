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

function HARGA_GET ($unit) {
	global $sql;
	
	$sql -> db_Select("info_harga", "unit, harga", "unit = '{$unit}' LIMIT 1");
	$result = $sql -> db_Fetch();
	return $result['harga'];
}

function DISKON_GET ($jenis) {
	global $sql;
	
	$sql -> db_Select("info_diskon", "jenis, potongan", "jenis = '{$jenis}' LIMIT 1");
	$result = $sql -> db_Fetch();
	return $result['potongan'];
}

function CEK_DISKON ($jenis) {
	global $sql;
	
	$sql -> db_Select("info_diskon", "jenis, potongan", "jenis = '{$jenis}' LIMIT 1");
	if($sql->db_Rows()) { return TRUE;}else{return FALSE;}
}

?>