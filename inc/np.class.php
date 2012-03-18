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

class nextprev{
	function tampilkan($url, $from, $view, $total, $td, $qs=""){


		if($total > $view){
			$a = $total/$view;
			$r = explode(".", $a);
			if($r[1] != 0 ? $pages = ($r[0]+1) : $pages = $r[0]);
		}else{
			$pages = FALSE;
		}

		if($pages){
			
			$nppage= "Halaman ";
			if($pages > 10){
				$current = ($from/$view)+1;

				for($c=0; $c<=2; $c++){
					$nppage .= ($view*$c == $from ? "[<span style='text-decoration:underline'>".($c+1)."</span>] " : "<a href='$url".($view*$c).($qs ? ".".$qs : "")."'>".($c+1)."</a> ");
				}

				if($current >=3 && $current <= 5){
					for($c=3; $c<=$current; $c++){
						$nppage .= ($view*$c == $from ? "[<span style='text-decoration:underline'>".($c+1)."</span>] " : "<a href='$url".($view*$c).($qs ? ".".$qs : "")."'>".($c+1)."</a> ");
					}
				}else if($current >= 6 && $current <= ($pages-5)){
					$nppage .= " ... ";
					for($c=($current-2); $c<=$current; $c++){
						$nppage .= ($view*$c == $from ? "[<span style='text-decoration:underline'>".($c+1)."</span>] " : "<a href='$url".($view*$c).($qs ? ".".$qs : "")."'>".($c+1)."</a> ");
					}
				}
				$nppage .= " ... ";
				

				if(($current+5) > $pages && $current != $pages){
					$tmp = ($current-2);
				}else{
					$tmp = $pages-3;
				}

				for($c=$tmp; $c<=($pages-1); $c++){
					$nppage .= ($view*$c == $from ? "[<span style='text-decoration:underline'>".($c+1)."</span>] " : "<a href='$url".($view*$c).($qs ? ".".$qs : "")."'>".($c+1)."</a> ");
				}

			}else{
				for($c=0; $c < $pages; $c++){
					if($view*$c == $from ? $nppage .= "[<span style='text-decoration:underline'>".($c+1)."</span>] " : $nppage .= "<a href='$url".($view*$c).($qs ? ".".$qs : "")."'>".($c+1)."</a> ");
				}
			}
			$nomorhalaman = "<div style='text-align:center'><div class='nextprev'><span class='smalltext'>".$nppage."</span></div></div><br /><br />";
			
			return $nomorhalaman;
		}
		
	}
		
}
?>