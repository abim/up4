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

$isipesan[1] = "<b>[1]: Eror berhubungan dengan Database MySQL !!</b>";
$isipesan[2] = "<b>[2]: Eror berhubungan dengan Database MySQL !! (ga ada isi table nya)</b>";
$isipesan[3] = "<b>[3]: Database tersimpan!!</b>";
$isipesan[4] = "<b>[4]: apa yah?</b>";
$isipesan[5] = "<b>[5]: Ada kotak pengisian yang terlewatkan. Ulangi pengisian, dan isi bagian-bagian yang penting untuk informasinya.</b>";
$isipesan[6] = "<b>[6]: Ada yang salah dengan Database MYSQL. Sehingga tidak bisa melakukan Koneksi ke mySQL. Silahkan lihat kembali file _konfigurasi.php di dalam folder system.</b>";
$isipesan[7] = "<b>[7]: mySQL dapat terkoneksi, namun database ($mySQLDb) Tidak dapat terhubung.<br />Silahkan lihat kembali file _konfigurasi.php di dalam folder system.</b>";


function keluar_pesan($mode, $pesan, $baris=0, $file=""){
        global $isipesan;
        switch($mode){
                case "CRITICAL_ERROR":
                        $pesan = is_numeric($pesan) ? $isipesan[$pesan] : $pesan;
                        echo "<div style='text-align:center; font: 11px verdana, tahoma, arial, helvetica, sans-serif;'><b>CRITICAL_ERROR: </b><br />Baris $baris $file<br /><br />Kesalahan: ".$pesan."</div>";
                break;
                
                case "MESSAGE":
                        echo "<div style='text-align:center'><b>".$pesan."</b></div>";
                break;

                case "ADMIN_MESSAGE":
                        echo "<div style='text-align:center'><b>".$pesan."</b></div>";
                break;

                case "ALERT":
                        @require_once(c_INCDIR."text.parse.php");
                        $kotakpesan = new kalbar_basicparse;
                        echo "<script type='text/javascript'>alert(\"".$kotakpesan->unentity($isipesan[$pesan])."\"); window.history.go(-1); </script>\n";
                break;

                case "P_ALERT":
                        @require_once(c_INCDIR."text.parse.php");
                        $kotakpesan = new kalbar_basicparse;
                        echo "<script type='text/javascript'>alert(\"".$kotakpesan->unentity($pesan)."\"); </script>\n";
                break;
        }
}
?>