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

//MENUATAS
if(ADMIN){
	if(file_exists(AdminGlobalDIR."menu.php")){ @include(AdminGlobalDIR."menu.php"); }
}else{
	@include(c_MODULEDIR.OPFOLDER."conf.php");
	if(file_exists(c_MODULEDIR.OPFOLDER."menu.php")){ @include(c_MODULEDIR.OPFOLDER."menu.php"); }
}
//END MENU ATAS

$AdministratorHeader = "
<header>
<nav>
	<div id=\"logo\"><img src=\"".c_Container_URL."global/images/logo/logo.jpg\"/></div>
	
	<ul id='nav_atas' role='navigation'>
		{$AdministratorMenu}
	</ul>
	<div id='navsearch'>
		<form action='/search/' method=\"post\" class=\"search\" id=\"g-search\">
		<div class=\"sp-label\">
			<label for=\"sp-searchtext\">Search</label>
			<input type=\"text\" name=\"q\" id=\"sp-searchtext\" />
		</div></form>
	</div>
	<div id='judul'>
		<h1><span id=\"site-title\">".NAMA_APP."</span> <em>v".APPVersion."</em></h1>
	</div>
	<div id='navuserinfo'>
		<span>Halo, <a class='tooltip' href=\"" .c_MODULEURL. "op.php\" title=\"Profil anda\">".OPNICK."</a> | <a class='tooltip' href=\"" .c_ADMINDIR. "?keluar\" title=\"Log Out\">Log Out</a></span>
</div>
</nav>
</header>
<div class='clear'></div>

";

echo $AdministratorHeader;
}
?>