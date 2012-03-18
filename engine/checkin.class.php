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

class CheckIN {
	
	var $Code;
	var $ID;
	
//-------------------------------------------------------------------------//
	function INSTALL ($code_checkin, $id_pasien) {		
		$this->Code = $code_checkin;
		$this->ID = $id_pasien;
	}

//-------------------------------------------------------------------------//
	function ADD ($table="today", $status="wait", $posisi, $kasir=0, $lunas=0) {
		$Sql_Query = new db;
		$now = time() -1;
		$now_datetime = date("Y-m-d H:i:s");
		if($table == "today") {
			$Sql_Query -> db_Insert("info_current_status", "'0', 
				'".$this->ID."', '".$this->Code."', 
				'".$now."', '".$posisi."', '".$status."'
				");
		}
		else {
			$Sql_Query -> db_Insert("info_history", "'0', 
				'".$this->Code."', '".$now_datetime."', '".$posisi."', '".$status."','".$kasir."', '".$lunas."'
			");
		}
		
	}

//-------------------------------------------------------------------------//
	function UPDATE ($status="wait", $posisi, $kasir=0) {
		// UPDATE GA ADA HISTORY (semuanya info_current_status)
		$Sql_Query = new db;
				
			$Sql_Query -> db_Update("info_current_status", "`status`='".$status."', 	`now_date`='".time()."' WHERE code_checkin='".$this->Code."' AND id_pasien='".$this->ID."' AND posisi='{$posisi}'
			");

	}

//-------------------------------------------------------------------------//
} //END CLASS

?>