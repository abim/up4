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

echo "
<div class=\"clear\"></div>
</div>";//end Content

echo "

<div id=\"footer\">
<p id=\"footer-left\" class=\"alignleft\"><span id=\"footer-indobit\">&copy;{$pref['copyrights']} ".NAMA_APP."</span> <a href=\"{$pref['WEBSITE_LEMBAGA']}\">{$pref['APP_LEMBAGA']}</a>.</p>
<p id=\"footer-upgrade\" class=\"alignright\">Powered by <a href=\"http://www.indobit.com/\">BIT Hospital System</a> v".APPVersion."</p>
<div class=\"clear\"></div>
</div>

</body>
</html>";

$sql -> db_Close();
?>