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
	
	function ANTRIAN_DOKTER($TYPE = "active"){
		global $sql, $pengaturan, $module_conf;
		
		if ($TYPE == "active") {
			$judul = "Atrian ".$module_conf['name'];
			$kode = "Antrian";
			$cur_status = "wait";
		}else {
			$judul = "Pasien Pending";
			$kode = "Pending";
			$cur_status = "pending";
		}
		
		$sql2 = new db;
		$sql2 -> db_Select("info_current_status", "status", "posisi='".$module_conf['level']."' AND status='{$cur_status}'");
		$total_antrian = $sql2->db_Rows();
		
		if (!empty($total_antrian)) {
		
			$teks = "
				<div class='wp100 pad10px white bor_bottom1 bor_left1'>
				<h3>{$judul}</h3>
				<ul>";
				
			// (3E): hasil query belum di sortir perhari. jgn lupa di delete untuk expired date 1 hari sebelumnya 86400 sec.
			$sql -> db_Select("info_current_status JOIN info_pasien AS pasien ON info_current_status.id_pasien = pasien.id_pasien", "pasien.nama_pasien AS nama, code_checkin, now_date, info_current_status.id_pasien AS id", "posisi = '".$module_conf['level']."' AND info_current_status.status = '{$cur_status}' ORDER BY `now_date` ASC LIMIT 5");
			
			while($row = $sql-> db_Fetch()){
				
				$teks .= "<li><a class='tooltip' href=\"form.php?checkin.{$row['code_checkin']}\" title=\"U P 4 &mdash; {$row['id']} - Lama {$kode} ".$pengaturan->_ago($row['now_date'])."\">{$row['nama']}</a></li>
			";
			}
			$teks .= "</ul>
			
			".($total_antrian ? "Total {$kode}: {$total_antrian}" : "{$kode} Kosong")."
			
			</div>";
			
			echo $teks;
		}//end if
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
		$teks .= "<li>Anda login sebagai ".OPLEVEL."</li>
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
		<div class='wp100 pad10px white bor_bottom1 bor_left1'>
		<h3>Administrator Menu</h3>
		<ul>
			<li><a href='#'>Edit Form Analisa</a></li>
		</ul>
		</div>";
		
		echo $teks;
	}	
	
	function ADMIN_MENU_KANAN_EDIT_FORM(){
		$teks = "
		<div class='wp100 pad10px white bor_bottom1 bor_left1'>
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