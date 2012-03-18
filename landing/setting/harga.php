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

@include ("../../inc/qapuas.php");
require_once(c_ADMINDIR."auth.php");

$Tengah = new AdminTblTengah;
$Tengah->Buka();

//=========================================================================//

if(!OP) {
	echo "Anda Tidak Memiliki Cukup Akses Untuk Melihat Halaman Ini";
}

//=========================================================================//

else {
	$tambah = new tambah;
	
	$tmp = explode(".", c_QUERY);
	$tmp1 = $tmp[0];
	$tmp2 = $tmp[1];
	$tmp3 = $tmp[2];
	
	if($_POST['tambahsubmit']){
		
		$row = $authresult = $tambah -> proses($_POST['unit'], $_POST['harga']);
		if($row[0] == "kosong1"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?kosong1'</script>\n";
		}else if($row[0] == "kosong2"){
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?kosong2'</script>\n";
		}else{
					
			$tanggal = date("Y-m-d H:i:s");
			$sql -> db_Insert("info_harga", " 
			'".$_POST['unit']."', 
			'".$_POST['harga']."', 
			'".$tanggal."' 
			");
			
			}
			echo "<script type='text/javascript'>document.location.href='". c_SELF ."?sip'</script>\n";
		}
	}

//=========================================================================//

	if($_POST['update']){
		$tanggal = date("Y-m-d H:i:s");
		$sql -> db_Update("info_harga", "
				`harga`='".$_POST['harga']."', 
				`tanggal_update`='".$tanggal."' 
				WHERE `unit`='".$_POST['unit']."' ");

		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?goup'</script>\n";
	}
	if($tmp1 == "edit"){
		if (!empty($tmp2)) {
			$tambah -> judul();
			$tambah -> edit($tmp2);
			$tambah -> record();

		}else{
			$tambah -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1);
		}
	}

//=========================================================================//
	if($_POST['hapus']){
		
		$sql -> db_Delete("info_harga", "`unit`='".$_POST['unit']."' ");
		echo "<script type='text/javascript'>document.location.href='". c_SELF ."?gohap'</script>\n";
	}
	if($tmp1 == "hapus"){
		if (!empty($tmp2)) {
			
			$tambah -> hapus($tmp2);
		}else{
			$tambah -> judul("ILLEGAL OPERATION DETECTED ON YOUR ACTIVITY", 1);
		}
	}
	
//=========================================================================//

	if(c_QUERY == "ksg1"){
		$tambah -> judul("UNIT NAMA TIDAK TERISI DENGAN BENAR, ULANGI PENGISIAN", 1);
		$tambah -> formulir();
	}
	if(c_QUERY == "ksg2"){
		$tambah -> judul("HARGA TIDAK TERISI, ULANGI PENGISIAN", 1, 1);
		$tambah -> formulir();
	}
	if(c_QUERY == "goup"){
		$tambah -> judul("DATA BERHASIL DI UBAH");
		$tambah -> record();
		$tambah -> formulir();
	}
	if(c_QUERY == "gohap"){
		$tambah -> judul("DATA BERHASIL DI HAPUS");
		$tambah -> record();
		$tambah -> formulir();
		
	}
	if(c_QUERY == "sip"){
		$tambah -> judul("DATA BERHASIL DITAMBAHKAN");
		$tambah -> record();
		$tambah -> formulir();
	}
	if(is_numeric(c_QUERY)){
		$tambah -> judul();
		if(!empty($tmp1)){$tambah -> record($tmp1);$tambah -> formulir();}else{$tambah -> record();$tambah -> formulir();}
	}
	if(c_QUERY == ""){
        $tambah -> judul();
        $tambah -> record();
		$tambah -> formulir();
	}


$Tengah->Tutup();
include(AdminFooter);

//=========================================================================//


class tambah{

//=========================================================================//
function edit($unit) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("info_harga", "*", "unit='{$unit}'");
		$result = $sql -> db_Fetch(); extract($result);
$teks =  "

<h2>Pengubahan ".$unit."</h2>

<form method='post' action='". c_SELF ."'>
". $form->buka("post", c_SELF) . $form->hidden("unit", $unit) ."
<div class=\"form-wrap\">

	<div class=\"form_col_1\">
		<label for=\"unit\">Unit Pembayaran</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("unit", "", $unit,"","","","","",'readonly') ."
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"harga\">Harga</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("harga", 8, $harga) ."
		<p>contoh: 3000</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class='center'><p class='submit'>".$form -> button("submit", "update", " Update Database ") ."</p></div>

</div>
</form>
";
echo $teks;
}

//=========================================================================//
function hapus($unit) {
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		$sql = new db;
		
		$sql -> db_Select("info_harga", "*", "unit='{$unit}'");
		$result = $sql -> db_Fetch(); extract($result);
		
		$teks =  "APAKAH ANDA YAKIN AKAN MENGHAPUS DATA <span style='color:red;'><em>".$unit."</em></span>?
";
		$button = "
".$form->buka("post", c_SELF)."\n
".$form->hidden("unit", $unit)."\n
".$form->button("submit", "cancel", " B A T A L ")."
".$form->button("submit", "hapus", " H A P U S  ")."
".$form->tutup()."
";

$this -> judul($teks, $button);
}

//=========================================================================//
function judul($text="", $button="") {
		
		$teks1 = "
<div id=\"index\" class='w600'>
	<div id=\"icon-users\" class=\"icon99\"></div>
	<h2>MANAGEMENT HARGA</h2>
</div>

<div id='content' class='w627 white'>
<div id='main' class='w600 alignleft pad1em'>";

		$teks2 = "
	<div class='center'>
	<h2>RESPON SERVER :</h2>
	
	<div class='response-msg notice'>
	".$text."
	</div>
	</div>
	";
	if (!empty($button)){ 
		$teks2 .= "<div class='center'>".$button."</div>";
	}
		
	if (empty($text)) {echo $teks1;}
	else{echo $teks1.$teks2;}	
}

//=========================================================================//
function formulir() {
		
		include (c_INCDIR."class.form.php");
		$form = new form_class;
		
		$teks =  "

<h2>Penambahan Harga</h2>

<form method='post' action='". c_SELF ."'>
<div class=\"form-wrap\">

	<div class=\"form_col_1\">
		<label for=\"unit\">unit Harga</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("unit") ."
		<p>contoh: ASKES</p>		
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class=\"form_col_1\">
		<label for=\"harga\">Harga</label><em>*</em>
	</div>
	<div class=\"form_col_2\">
		". $form -> text("harga",8) ."
		<p>contoh: 20000</p>
	</div>	
	<div class=\"clear\"></div><br/>
	
	<div class='center'><p class='submit'>".$form -> button("submit", "tambahsubmit", " Input Database ") ."</p></div>

</div>
</form>
";
echo $teks;
}

//=========================================================================//
function record($halaman="0") {
$sql = new db;
$sql2 = new db;
$pengaturan = new strf;
define("ITEMVIEW", 20);
$from = (!is_numeric($halaman) || !c_QUERY ? 0 : ($halaman ? $halaman : c_QUERY));

$teks = "
<h2>Record Diskon</h2>";

	$jav = "onmouseover=\"this.style.backgroundColor='#FAE9C6';\" onmouseout=\"this.style.backgroundColor=''\"";

	$sql -> db_Select("info_harga", "*", "unit!='0' ORDER BY unit ASC LIMIT ".$halaman.",".ITEMVIEW."");
	$sql2 -> db_Select("info_harga");
	define("ITEMTOTAL", $sql2->db_Rows());
	require_once(c_INCDIR."np.class.php");
	$satu = $halaman;
	$page = new nextprev;

	$teks .= "
	<h4>Total Data yang terdaftar sebanyak ".ITEMTOTAL." record</h4>
	<br class='clear'>
	
	<table class=\"widefat fixed\" cellspacing=\"0\">
	<thead>
		<tr>
		<th scope='col'>Unit Pembayaran</th>
		<th scope='col' class=\"num tgl\">Harga</th>
		<th scope='col' class=\"num\">Terakhir Update</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
		<th scope='col'>Unit Pembayaran</th>
		<th scope='col'>Harga</th>
		<th scope='col'>Terakhir Update</th>
		</tr>
	</tfoot>

	<tbody>";

	while($row = $sql-> db_Fetch()){

		$teks .= "
		<tr {$jav}>
			<td class='uppercase'>". $row['unit'] ."
			<div class=\"row-actions\">
					<span class='edit'><a href=\"". c_SELF ."?edit.".$row['unit']."\">Edit</a> | </span>
					<span class='delete'><a class='delete' href='". c_SELF ."?hapus.".$row['unit']."'>Delete</a></span>
				</div>
			</td>
			<td class='num'>". $row['harga'] ."</td>
			<td>". $row['tanggal_update'] ."</td>
		</tr>";

	}$teks .= "
	</tbody>
</table>
<br class=\"clear\">

";	
	$teks .= $page->tampilkan(c_SELF."?", $from, ITEMVIEW, ITEMTOTAL, "LANJUT", ($satu == "list" ? $satu.".".$dua : ""));


echo $teks;

}//end record()
//=========================================================================//

function proses($item1, $item2){
	
	if(empty($item1)){
		$row = array("kosong1");
		return $row;
	}
	
	if(empty($item2)){
		$row = array("kosong2");
		return $row;
	}

}
	
//end class
}
//=========================================================================//

?>
