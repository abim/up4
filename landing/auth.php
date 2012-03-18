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

if(OP){
	require_once(AdminHeader);
}else{
	if($_POST['authsubmit']){
		$objek = new auth;

		$row = $authresult = $objek -> authproses($_POST['authnama'], $_POST['authsandi']);
		if($row[0] == "fop"){
			echo "<script type='text/javascript'>document.location.href='?slhpasswd'</script>\n";
		}else if($row[0] == "fon"){
			echo "<script type='text/javascript'>document.location.href='?slhop'</script>\n";
		}else{

			$sandiOP = md5(md5($_POST['authsandi']));
			$autolog = $_POST['autologin'];
			$cookieval = $row['op_id'].".".md5($sandiOP);

			$sql -> db_Select("www_operator", "op_id, op_nama, op_password, op_folder", "op_nama='".$_POST['authnama']."'");			
			list($op_id, $op_nama, $sandiOP, $op_folder) = $sql-> db_Fetch();
			
			if($pref['tracking'] == "session"){
				$_SESSION[$pref['cookie']] = $cookieval;
				
			}else{
				//isicookie($pref['cookie'], $cookieval, ( time()+3600*24*30));
				if($autolog != 1){ //if($autolog == 1){
						isicookie($pref['cookie'], $cookieval, ( time()+3600*24*30));
						
					}else{
						isicookie($pref['cookie'], $cookieval, ( time()+3600*3));
						
					}
			}
			
			if($op_folder == "admin"){
				echo "<script type='text/javascript'>document.location.href='".c_ADMINDIR."'</script>\n";
			}else {
				echo "<script type='text/javascript'>document.location.href='".c_MODULEURL.$op_folder."'</script>\n";
			}
		}
	}
	
	$objek = new auth;

	if(c_QUERY == "slhpasswd"){
		$isiteks = "<div id=\"login_error\"><strong>ERROR</strong>: Password yg anda masukkan SALAH.</div>";
		$objek -> tampilanlogin($isiteks);
		exit;
	}
	if(c_QUERY == "slhop"){
		$isiteks = "<div id=\"login_error\"><strong>ERROR</strong>: Nama yg anda masukkan SALAH.</div>";
		$objek -> tampilanlogin($isiteks);
		exit;
	}
	if(c_QUERY == "gantipaswordberhasil"){
		$isiteks = "<p class=\"message\">Pergantian Password berhasil di lakukan.</p>";
		$objek -> tampilanlogin($isiteks);
		exit;
	}

	if(OP == FALSE){
		$isiteks ="<p class=\"message\">Silahkan Melakukan Login Untuk Masuk ke Server
		Dengan menggunakan Akses masing-masing</p>
		<p class=\"message\">Selamat Berkerja..</p>";
		$objek -> tampilanlogin();
		exit;
	}
}

//-------------------------------------------------------------------------------//
class auth{

	function tampilanlogin($isiteks=""){
	global $pref;
		
$teks .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"ltr\" lang=\"en-US\">
<head>
	<title>Log In &rsaquo; ".NAMA_APP."</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	<link rel='stylesheet' id='login-css'  href='".c_Container_URL."login/css/screen.css' type='text/css' media='screen' />";
if(file_exists(c_Container_DIR."global/fav.ico")){$teks .= "
\n<link rel='Shortcut Icon' type='image/ico' href='".c_Container_URL."global/fav.ico'>";}


$teks .= "</head>
<body class=\"login\">

<div id=\"logo\"></div>

<div id=\"login\">

".$isiteks."

<form name=\"loginform\" id=\"loginform\" action=\"".c_SELF."\" method=\"post\">
	<p>
		<label>Nama Pegawai<br />
		<input type=\"text\" name=\"authnama\" id=\"user_login\" class=\"input\" value=\"\" size=\"20\" tabindex=\"10\" /></label>
	</p>
	<p>
		<label>Password<br />
		<input type=\"password\" name=\"authsandi\" id=\"user_pass\" class=\"input\" value=\"\" size=\"20\" tabindex=\"20\" /></label>

	</p>
	
	<p class=\"submit\">
		<input type=\"submit\" name=\"authsubmit\" id=\"wp-submit\" value=\"Log In\" tabindex=\"100\" />
		<input type=\"hidden\" name=\"redirect_to\" value=\"".c_SELF."\" />
		<input type=\"hidden\" name=\"testcookie\" value=\"1\" />
	</p>
</form>

</div>

<div id=\"footer\">
<p id=\"footer-left\" class=\"alignleft\"><span id=\"footer-indobit\">&copy;{$pref['copyrights']} ".NAMA_APP."</span> <a href=\"{$pref['WEBSITE_LEMBAGA']}\">{$pref['APP_LEMBAGA']}</a>.</p>
<p id=\"footer-upgrade\" class=\"alignright\">Powered by <a href=\"http://www.indobit.com/\">BIT Hospital System</a> v".APPVersion."</p>

<div class=\"clear\"></div>
</div>


<script type=\"text/javascript\">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
</body>
</html>
";
		
echo $teks;
	}

	function authproses($authnama, $authsandi){
		$sql_auth = new db;
		$authsandi = md5(trim($authsandi));
		$authnama = ereg_replace("\sOR\s|\=|\#", "", $authnama);
		if($sql_auth -> db_Select("www_operator", "*", "op_nama='$authnama' AND op_level!='0' ")){
			if($sql_auth -> db_Select("www_operator", "*", "op_nama='$authnama' AND op_password='".md5($authsandi)."' AND op_level!='0' ")){
				$row = $sql_auth -> db_Fetch();
				return $row;
			}else{
				$row = array("fop");
				return $row;
			}
		}else{
			$row = array("fon");
			return $row;
		}
	}
}

//-------------------------------------------------------------------------------//


?>