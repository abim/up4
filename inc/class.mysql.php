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


class db{

	var $MySQLHost;
	var $MySQLUser;
	var $MySQLPasswd;
	var $MySQLDb;
	var $mySQLaccess;
	var $mySQLresult;
	var $mySQLrows;
	var $mySQLerror;
//-------------------------------------------------------------------------//
	function db_Connect($MySQLHost, $MySQLUser, $MySQLPasswd, $MySQLDb){
		
		$this->MySQLHost = $MySQLHost;
		$this->MySQLUser = $MySQLUser;
		$this->MySQLPasswd = $MySQLPasswd;
		$this->MySQLDb = $MySQLDb;
		$temp = $this->mySQLerror;
		$this->mySQLerror = FALSE;
		if(!$this->mySQL_access = @mysql_connect($this->MySQLHost, $this->MySQLUser, $this->MySQLPasswd)){
			return "wadoh_ga_bisa_konek";
		}else{
			if(!@mysql_select_db($this->MySQLDb)){
				return "wadoh_db_nya_mana_yah";
			}else{
				$this->dbError("dbConnect/SelectDB");
			}
		}
	}

//-------------------------------------------------------------------------//
	function db_Select($table, $fields="*", $arg="", $mode="default", $debug=FALSE){
		global $dbq;
		$dbq++;

		//mode statis (default)
		if($arg != "" && $mode=="default"){
			if($debug){ echo "SELECT ".$fields." FROM ".$table." WHERE ".$arg."<br />"; }
			if($this->mySQLresult = @mysql_query("SELECT ".$fields." FROM ".$table." WHERE ".$arg)){
				$this->dbError("dbQuery");
				return $this->db_Rows();
			}else{
				$this->dbError("db_Select (SELECT $fields FROM "."$table WHERE $arg)");
				return FALSE;
			}
		}
		
		//mode iseng (Transparanent)
		else if($arg != "" && $mode != "default"){
			if($debug){ echo "@@SELECT ".$fields." FROM ".$table." ".$arg."<br />"; }
			if($this->mySQLresult = @mysql_query("SELECT ".$fields." FROM ".$table." ".$arg)){
				$this->dbError("dbQuery");
				return $this->db_Rows();
			}else{
				$this->dbError("db_Select (SELECT $fields FROM "."$table $arg)");
				return FALSE;
			}
		}else{
			if($debug){ echo "SELECT ".$fields." FROM ".$table."<br />"; }
			if($this->mySQLresult = @mysql_query("SELECT ".$fields." FROM ".$table)){
				$this->dbError("dbQuery");
				return $this->db_Rows();
			}else{
				$this->dbError("db_Select (SELECT $fields FROM "."$table)");
				return FALSE;
			}		
		}
	}
//-------------------------------------------------------------------------//
	function db_Insert($table, $arg, $debug=FALSE){
		
		if($debug){
			echo "INSERT INTO ".$table." VALUES (".htmlentities($arg).")";
		}

//		if(!ANON && !USER && $table != "user"){ return FALSE; }

		if($result = $this->mySQLresult = @mysql_query("INSERT INTO ".$table." VALUES (".$arg.")" )){
			$tmp = mysql_insert_id();

		// kalo mau pake temporary aktipin aza!
			if(OP && $table != "www_online"){
				mysql_query("INSERT INTO www_tmp VALUES ('adminlog', '".time()."', '<br /><b>Insert</b> - <b>$table</b> table (field id <b>$tmp</b>)<br />by <b>".OPNAMA."</b>') ");
			}
			return $tmp;
		}else{
			$this->dbError("db_Insert ($query)");
			return FALSE;
		}
	}
//-------------------------------------------------------------------------//
	function db_Update($table, $arg, $debug=FALSE){
		global $dbq;
		$dbq++;
		if($debug){ echo "UPDATE ".$table." SET ".$arg."<br />"; }	
		if($result = $this->mySQLresult = @mysql_query("UPDATE ".$table." SET ".$arg)){
			$result = mysql_affected_rows();
		
		// kalo mau pake temporary aktipin aza!
			if(OP && $table != "www_online"){
				if(!strstr($arg, "link_order")){
					$str = addslashes(str_replace("WHERE", "", substr($arg, strpos($arg, "WHERE"))));
					mysql_query("INSERT INTO www_tmp VALUES ('adminlog', '".time()."', '<br /><b>Update</b> - <b>$table</b> table (string: <b>".$str."</b>)<br />by <b>".OPNAMA."</b>') ");
				}
			}
			
			return $result;
		}else{
			$this->dbError("db_Update ($query)");
			return FALSE;
		}
	}
//-------------------------------------------------------------------------//
	function db_Fetch($mode = "strip"){
		if($row = @mysql_fetch_array($this->mySQLresult)){
			if($mode == strip){
				while (list($key,$val) = each($row)){
					$row[$key] = stripslashes($val);
				}
			}
			$this->dbError("db_Fetch");
			return $row;
		}else{
			$this->dbError("db_Fetch");
			return FALSE;
		}
	}
//-------------------------------------------------------------------------//
	function db_Count($table, $fields="(*)", $arg=""){
//		echo "SELECT COUNT".$fields." FROM ".$table." ".$arg;

		global $dbq;
		$dbq++;
		if($fields == "generic"){
			if($this->mySQLresult = @mysql_query($table)){
				$rows = $this->mySQLrows = @mysql_fetch_array($this->mySQLresult);
				return $rows[0];
			}else{
				$this->dbError("dbCount ($query)");
			}
		}
		
		
		if($fields == "bima"){
			if($this->mySQLresult = @mysql_query($table)){
				$rows = $this->mySQLrows = @mysql_fetch_rows($this->mySQLresult);
			echo $rows;
			//	return $rows[0];
			}else{
				$this->dbError("dbCount ($query)");
			}
		}

		if($this->mySQLresult = @mysql_query("SELECT COUNT ".$fields." FROM ".$table." ".$arg)){
			$rows = $this->mySQLrows = @mysql_fetch_array($this->mySQLresult);
			return $rows[0];
		}else{
			$this->dbError("dbCount ($query)");
		}
	}
//-------------------------------------------------------------------------//
	function db_Close(){
		mysql_close();
		$this->dbError("dbClose");
	}

//-------------------------------------------------------------------------//
	function db_Delete($table, $arg=""){
		if($table == "user"){
	//		echo "DELETE FROM ".$table." WHERE ".$arg."<br />";			// debug
		}
		if(!$arg){
			if($result = $this->mySQLresult = @mysql_query("DELETE FROM ".$table)){
			
			// kalo mau pake temporary aktipin aza!
				if(OP && $table != "www_online" && $table != "www_tmp"){
					$str = addslashes(str_replace("WHERE", "", substr($arg, strpos($arg, "WHERE"))));

					if($table == "www_tmp"){
						$string = "<br /><b>Delete</b> - <b>$table</b> table (routine tidy-up)<br />by <b>BIMA SYSTEM</b>";
					}else{
						$string = "<br /><b>Delete</b> - <b>$table</b> table (all entries deleted)<br />by <b>".OPNAMA."</b>";
					}

					mysql_query("INSERT INTO www_tmp VALUES ('adminlog', '".time()."', '$string') ");
				}
				
				return $result;
			}else{
				$this->dbError("db_Delete ($arg)");
				return FALSE;
			}
		}else{
			if($result = $this->mySQLresult = @mysql_query("DELETE FROM ".$table." WHERE ".$arg)){
				$tmp = mysql_affected_rows();
				
			// kalo mau pake temporary aktipin aza!
				if(OP && $table != "www_online" && $table != "www_tmp"){
					$str = addslashes(str_replace("WHERE", "", substr($arg, strpos($arg, "WHERE"))));
					mysql_query("INSERT INTO www_tmp VALUES ('adminlog', '".time()."', '<b>Delete</b> - <b>$table</b> table (string: <b>$str</b>) by <b>".OPNAMA."</b>') ");
				}
				
				return $tmp;
			}else{
				$this->dbError("db_Delete ($arg)");
				return FALSE;
			}
		}
	}
//-------------------------------------------------------------------------//
	function db_Rows(){
		$rows = $this->mySQLrows = @mysql_num_rows($this->mySQLresult);
		return $rows;
		$this->dbError("db_Rows");
	}
//-------------------------------------------------------------------------//
	function dbError($from){
		if($error_message = @mysql_error()){
			if($this->mySQLerror == TRUE){
				keluar_pesan("ADMIN_MESSAGE", "<b>mySQL Error!</b> Function: $from. [".@mysql_errno()." - $error_message]",  __LINE__, __FILE__);
				return $error_message;
			}
		}
	}
//-------------------------------------------------------------------------//
	function db_SetErrorReporting($mode){
		$this->mySQLerror = $mode;
	}
//-------------------------------------------------------------------------//
//-------------------------------------------------------------------------//

	function db_Select_gen($arg){
		global $dbq;
		$dbq++;
		//echo "\mysql_query($arg)";
		if($this->mySQLresult = @mysql_query($arg)){
			$this->dbError("db_Select_gen");
			return $this->db_Rows();
		}else{
			$this->dbError("dbQuery ($query)");
			return FALSE;
		}
	}
//-------------------------------------------------------------------------//

	function db_Fieldname($offset){

		$result = @mysql_field_name($this->mySQLresult, $offset);
		return $result;
	}

	function db_Num_fields(){
		$result = @mysql_num_fields($this->mySQLresult);
		return $result;
	}

}
?>