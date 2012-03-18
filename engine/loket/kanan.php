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

require_once(c_MODULEDIR."function.php");

class AdminTblKanan{

	function LAST_PASIEN_REGISTER(){
		$teks = "
		<div class='wp100 pad10px white bor_bottom1 bor_left1'>
		<h3>Pasien Pendaftar Terbaru</h3>
		<ul>
			".LI_LAST_PASIEN_REGISTER()."
		</ul>
		</div>";
		
		echo $teks;
	}

	function ANTRIAN_DOKTER(){
		global $sql, $pengaturan;
		
		$teks = "";
		$sql3 = new db;

		// (3E): delete untuk expired date 1 hari sebelumnya 86400 sec.
		$sql3 -> db_Delete("info_current_status", "now_date<".(time() - 86400));

		$sql3 -> db_Select("info_modul", "*", "code_modul LIKE 'dokter%'");
		while($row3 = $sql3-> db_Fetch()){
		

			$teks .= "
				<div class='wp100 pad10px white bor_bottom1 bor_left1'>
				<h3>".$row3['nama_modul']."</h3>
				<ul>";
				
			// (3E): hasil query belum di sortir perhari. jgn lupa di delete untuk expired date 1 hari sebelumnya 86400 sec.
			$sql -> db_Select("info_current_status JOIN info_pasien AS pasien ON info_current_status.id_pasien = pasien.id_pasien", "pasien.nama_pasien AS nama, code_checkin, now_date, info_current_status.id_pasien AS id", "posisi = '".$row3['code_modul']."' AND info_current_status.status = 'wait' ORDER BY `now_date` ASC LIMIT 5");
			
			
			$sql2 = new db;
			$sql2 -> db_Select("info_current_status", "status", "posisi='".$row3['code_modul']."' AND status='wait'");
			$total_antrian = $sql2->db_Rows();		
			
			while($row = $sql-> db_Fetch()){
				$teks .= "<li><a class='tooltip' href=\"#{$row['code_checkin']}\" title=\"U P 4 &mdash; {$row['id']} - Lama antrian ".$pengaturan->_ago($row['now_date'])."\">{$row['nama']}</a></li>
			";
			}
			$teks .= "</ul>
			
			".($total_antrian ? "Total Antrian: {$total_antrian}" : "Antrian Kosong")."
			
			</div>";
		
		}
		
		echo $teks;
	}
	
	function Buka(){
		global $width;
		$teks = "<div id='kanan' class='{$width['kanan']} alignleft'>";
		echo $teks;
	}
	
	function Tutup(){
		$teks = "<div class=\"clear\"></div></div><div class=\"clear\"></div>
		<div class=\"tutup_kanan\"></div>\n";
		echo $teks;
	}
	
	//ACTIVITY
	
	function LAST_ACTIVE(){
		global $pengaturan;
		$teks = "
		<div class='wp100 pad10px bg-abu2-1 bor_bottom1 bor_left1'>
		<h3 class='uppercase'>".OPNICK."</h3>
		<ul>";
		$teks .= "<li>Level Operator anda adalah ".OPLEVEL."</li>
		<li>Total Login berjumlah ".OPKUNJUNGAN." kali</li>
		<li>Terdaftar ".$pengaturan->_ago(OPJOIN)." yg lalu</li>
		<li>Login ".$pengaturan->_ago(OPTERAKHIRLOGIN)." yg lalu (".OPIP.")</li>
		";
		$teks .= "
		</ul>
		</div>";
		
		echo $teks;
	}
	
	// ADMINISTRATOR
	
	function ADMIN_MENU_KANAN(){
		$teks = "
		<div class='wp100 pad10px bg-abu2-1 bor_bottom1'>
		<h3>Administrator Menu</h3>
		<ul>
			<li><a href='baru.php'>Edit Form Pendaftaran</a></li>
			<li>sss</li>
			<li>sss</li>
			<li>sss</li>
		</ul>
		</div>";
		
		echo $teks;
	}	
	
	function ADMIN_MENU_KANAN_EDIT_FORM(){
		$teks = "
		<div class='wp100 pad10px bg-abu2-1 bor_bottom1'>
		<h3>Edit Form Pendaftaran</h3>
		<ul>
			<li><a href='#'>Jenis Identitas</a></li>
			<li><a href='#'>Tujuan Unit Pelayanan</a></li>
			<li><a href='#'>Jenis Rujukan</a></li>
			<li><a href='#'>Klasifikasi Payment</a></li>
			<li><a href='#'>Keperluan Pasien</a></li>
		</ul>
		</div>";
		
		echo $teks;
	}
}