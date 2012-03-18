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


define("c_Container_DIR", c_BASE.$TampilanDir);
define("c_Container_URL", $url.GUE_BANGET_GITU_LOH.$TampilanDir);

define("APPVersion", $APPVersion);
define("NAMA_APP", $pref['NAMA_APP']);

define("c_UPLOADDIR", c_BASE.$UploadDir);
define("c_TAMPILANDIR", c_BASE.$TampilanDir);
define("c_ADMINDIR", c_BASE.$AdminDir);

define("c_MODULEDIR", c_BASE.$ModuleDir);
define("c_MODULEURL", $url.GUE_BANGET_GITU_LOH.$ModuleDir);

define("atasF", c_BASE.$TampilanDir."header_default.php");
define("bawahF", c_BASE.$TampilanDir."footer_default.php");

define("c_TAMPILAN", c_BASE.$TampilanDir.$Tampilan);
define("c_TAMPILANURL", $url.GUE_BANGET_GITU_LOH.$TampilanDir.$Tampilan);

define ("TemplateHeader", c_TAMPILAN."header.php");
define ("TemplateFooter", c_TAMPILAN."footer.php");
?>
