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

$_menuAtribut['Dashboard'] = c_ADMINDIR;
$_menuAtribut['Loket'] = c_MODULEURL."loket/";
$_menuAtribut['Dokter'] = c_MODULEURL."dokter/";
$_menuAtribut['Laboratorium'] = c_MODULEURL."lab/";
$_menuAtribut['Radiologi'] = c_MODULEURL."radiologi/";
$_menuAtribut['D O T'] = c_MODULEURL."dot/";
$_menuAtribut['Setting'] = c_ADMINDIR."op.php";


while(list($value,$link) = each($_menuAtribut)){
	$Lihat = preg_match("#(".$link.")(.*?)(.*?)(.*?)#", c_SELF);
	
	if($Lihat) {
		$AdministratorMenu .= "<li id='aktif'><a href=\"{$link}\">{$value}</a></li>";
	}else{
		$AdministratorMenu .= "<li><a href=\"{$link}\">{$value}</a></li>";
	}

}
?>