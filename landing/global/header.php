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
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		
<html xmlns=\"http://www.w3.org/1999/xhtml\"  dir=\"ltr\" lang=\"en-US\">

<head>
<title>".NAMA_APP."</title>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />

<link rel='stylesheet' id='reset' href='".c_Container_URL."global/css/reset.css?v=0.1' type='text/css' media='reset'/>

<link rel='stylesheet' id='all' href='".c_Container_URL."admin/css/all.css?v=0.1' type='text/css' media='all'/>
		
<link rel='stylesheet' id='screen' href='".c_Container_URL."admin/css/screen.css?v=0.1' type='text/css' media='screen'/>

<link rel='stylesheet' id='style-icons' href='".c_Container_URL."admin/css/icons.css?v=0.1' type='text/css' media='screen'/>

<link rel='stylesheet' id='style-form' href='".c_Container_URL."admin/css/style-form.css?v=0.1' type='text/css' media='screen'/>

<link rel='stylesheet' id='style-form' href='".c_Container_URL."admin/css/style-tabel.css?v=0.1' type='text/css' media='screen'/>
		
<script src='".c_Container_URL."global/js/jquery-1.7.1.min.js'></script>

<script src='".c_Container_URL."global/js/jquery.idTabs.min.js'></script>

<script src='".c_Container_URL."global/js/jquery.tooltip-1.3.js'></script>

<script src='".c_Container_URL."global/js/jquery.printPage.js'></script>

<script src='".c_Container_URL."global/js/jquery.dataTables.min.js'></script>

<script src='".c_Container_URL."global/js/statistics/highcharts.js'></script>
<script src='".c_Container_URL."global/js/statistics/exporting.js'></script>

<script src='".c_Container_URL."global/js/custom.js'></script>";

		
if(file_exists(c_Container_DIR."global/fav.ico")){echo "
\n<link rel='Shortcut Icon' type='image/ico' href='".c_Container_URL."global/fav.ico'>";}
echo "
</head>
<body>
<div id=\"wrap\">";
if(file_exists(AdminGlobalDIR."atas.php")){ @include(AdminGlobalDIR."atas.php"); }
?>