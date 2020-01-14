<?php
@session_start();
include "../config/database.php";

$perintah = new oop();
$cari_kode = mysql_query("select max(id_buku) as kode from tbl_buku");
$tm_cari=mysql_fetch_assoc($cari_kode);
$kode = substr($tm_cari['kode'],-3,4);
$tambah = $kode + 1;
if($tambah<10){
	$kode = "BQU000000000000000".$tambah;
}else if($tambah<100){
	$kode = "BQU00000000000000".$tambah;
}else if ($tambah<1000){
	$kode = "BQU0000000000000".$tambah;
}else if ($tambah<10000){
	$kode = "BQU000000000000".$tambah;
}else if ($tambah<100000){
	$kode = "BQU00000000000".$tambah;
}else if ($tambah<1000000){
	$kode = "BQU0000000000".$tambah;
}else if ($tambah<10000000){
	$kode = "BQU000000000".$tambah;
}else if ($tambah<100000000){
	$kode = "BQU00000000".$tambah;
}else if ($tambah<1000000000){
	$kode = "BQU0000000".$tambah;
}else if ($tambah<10000000000){
	$kode = "BQU000000".$tambah;
}else if ($tambah<100000000000){
	$kode = "BQU00000".$tambah;
}else if ($tambah<1000000000000){
	$kode = "BQU0000".$tambah;
}else if ($tambah<10000000000000){
	$kode = "BQU000".$tambah;
}else if ($tambah<100000000000000){
	$kode = "BQU00".$tambah;
}else if ($tambah<1000000000000000){
	$kode = "BQU0".$tambah;
}else if ($tambah<10000000000000000){
	$kode = "BQU".$tambah;
}
$table = "tbl_buku";
$where = "id_buku = '$_GET[id]'";
$redirect = "?menu=buku";

$field = array(
  'id_buku' => $_POST['id_buku'], 
  'judul' => $_POST['judul'], 
  'noisbn' => $_POST['noisbn'],
  'penulis' => $_POST['penulis'],
  'penerbit' => $_POST['penerbit'],
  'tahun' => $_POST['tahun'],
  'stok' => "0",
  'harga_pokok' => $_POST['harga_pokok'],
  'harga_jual' => $_POST['harga_jual'],
  'ppn' => "10",
  'diskon' => $_POST['diskon']);

if (isset($_POST['simpan'])) { 
    $perintah->simpan($table, $field, $redirect);
}
if (isset($_GET['hapus'])) {
    $perintah->hapus($table, $where, $redirect);
}
if (isset($_GET['edit'])) {
    $edit = $perintah->edit($table, $where);
}
if (isset($_POST['ubah'])) {
    $perintah->ubah($table, $field, $where, $redirect);
}
if(isset($_POST['cari'])){
	$cari = "WHERE judul LIKE '%$_POST[txtcari]%' OR penulis LIKE '%$_POST[txtcari]%'";
}
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
?>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/autoNumeric-min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
   
    $('.demo').autoNumeric('init');
	
  $('#harga_jual').bind('blur focusout keypress keyup', function () {
        var harga_jualGet = $('#harga_jual').autoNumeric('get');
        $('#harga_jualGet').val(harga_jualGet);
    });

	$('#harga_pokok').bind('blur focusout keypress keyup', function () {
        var harga_pokokGet = $('#harga_pokok').autoNumeric('get');
        $('#harga_pokokGet').val(harga_pokokGet);
    });
	});
 </script>
<body OnLoad="document.myform.judul.focus();">
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form buku</h4>
    </div>
  </div>
  <div class="panel-body">
    <form class="form form-vertical" method="post" name="myform">
      <div class="control-group">
        <label>Kode buku</label>
        <div class="controls">
          <input type="text" name="id_buku" readonly value="<?php if(isset($_GET['edit'])){ echo $edit['id_buku']; }else{ echo $kode; } ?>" class="form-control">
        </div>
      </div>
      <div class="control-group">
        <label>Judul buku</label>
        <div class="controls">
          <input type="text" name="judul" setFocus class="form-control" value="<?php echo $edit['judul'] ?>" required placeholder="Masukan judul buku">
        </div>
      </div>
      <div class="control-group">
        <label>NO ISBN</label>
        <div class="controls">
          <input type="text" name="noisbn" class="form-control" value="<?php echo $edit['noisbn'] ?>" required placeholder="Masukan ISBN">
        </div>
      </div>
      <div class="control-group">
        <label>Penulis</label>
        <div class="controls">
          <input type="text" name="penulis" class="form-control" value="<?php echo $edit['penulis'] ?>" placeholder="Masukan penulis">
        </div>
      </div>
      <div class="control-group">
        <label>Penerbit</label>
        <div class="controls">
          <input type="text" name="penerbit" class="form-control" value="<?php echo $edit['penerbit'] ?>" placeholder="Masukan Penerbit">
        </div>
      </div>
      <div class="control-group">
        <label>Tahun Terbit</label>
        <div class="controls">
          <input type="number" oninput="if(value.length>4)value=value.slice(0,4)" pattern="\d*" name="tahun" class="form-control" value="<?php echo $edit['tahun'] ?>" placeholder="Masukan Tahun">
        </div>
      </div>
      <div class="control-group">
        <label>Harga Pokok</label>
        <div class="controls">
          <input type="text" id="harga_pokok" class="demo form-control" value="<?php echo $edit['harga_pokok'] ?>" placeholder="Masukan harga pokok" required>
          <input name="harga_pokok" id="harga_pokokGet" readonly type="hidden" value="<?php echo $edit['harga_pokok'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label>Harga Jual</label>
        <div class="controls">
          <input type="text" id="harga_jual" class="demo form-control" value="<?php echo $edit['harga_jual'] ?>" placeholder="Masukan harga jual" required>
          <input name="harga_jual" id="harga_jualGet" readonly="" type="hidden" value="<?php echo $edit['harga_jual'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label>Diskon</label>
        <div class="controls">
          <input type="number" name="diskon" class="control" value="<?php echo $edit['diskon'] ?>" placeholder="Masukan diskon"> %
        </div>
      </div>
      <div class="control-group">
        <label></label>
        <div class="controls">
          <?php if ($_GET['id'] == "") { ?>
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <?php } else { ?>
          <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
          <?php } ?>
        </div>
      </div>
    </form>
  </div>
  <!--/panel content--> 
</div>
<!--/panel-->
<div class="form-group form-inline text-right">
  <div class="clearfix"></div>
  <div class="controls">
    <form method="post" class="form-group form-inline">
      <label>Pencarian :</label>
      <input type="text" name="txtcari" class="form-group form-control" placeholder="judul buku / penulis">
      <button type="submit" name="cari" class="form-group btn btn-info">Cari</button>
      <a class="form-group btn btn-success" href="?menu=buku">Refresh</a>
    </form>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-hover table-bordered table-responsive">
    <tr>
      <th>Kode buku</th>
      <th>Judul</th>
      <th>NO ISBN</th>
      <th>Penulis</th>
      <th>Penerbit</th>
      <th>Tahun</th>
      <th>Harga Pokok</th>
      <th>Harga Jual</th>
      <th>Diskon</th>
      <th>Edit</th>
      <th>Hapus</th>
    </tr>
    <?php 
		$halaman=$_GET['halaman'];
		if(empty($halaman)){
		$halaman=1;
		}
		$batas=30;
		$posisi=($halaman-1) * $batas;
		$sql = mysql_query("SELECT * FROM tbl_buku $cari order by id_buku DESC limit $posisi,$batas");
		$cek = mysql_num_rows($sql);
		if ($cek == "") {
			echo "<tr><td align='center' colspan='10'>Tidak ada data buku</td></tr>";
		} else {
			while($r=mysql_fetch_assoc($sql)){
		?>
    <tr>
      <td><?php echo $r['id_buku'] ?></td>
      <td><?php echo $r['judul'] ?></td>
      <td><?php echo $r['noisbn'] ?></td>
      <td><?php echo $r['penulis'] ?></td>
      <td><?php echo $r['penerbit'] ?></td>
      <td><?php echo $r['tahun'] ?></td>
      <td><?php echo format_angka($r['harga_pokok']) ?></td>
      <td><?php echo format_angka($r['harga_jual']) ?></td>
      <td><?php echo $r['diskon'] ?>%</td>
      <td align="center"><a href="?menu=buku&edit&id=<?php echo $r['id_buku'] ?>" title="EDIT"><img class="img-responsive" src="../img/b_edit.png"></a></td>
      <?php 
        //buku yg sudah dijual ga bisa di hapus 
        $cek = mysql_fetch_assoc(mysql_query("SELECT id_buku FROM tbl_penjualan"));
        if($cek['id_buku'] == $r['id_buku']){
          echo "";
        }else{ 
      ?>
      <td align="center"><a href="?menu=buku&hapus&id=<?php echo $r['id_buku'] ?>" title="HAPUS" onClick="return confirm('Hapus buku dengan judul <?php echo $r['judul'] ?> ? ')"><img class="img-responsive" src="../img/b_drop.png"></a></td>
      <?php } ?>
    </tr>
    <?php } } ?>
    <tr>
      <td><?php
        $sum = mysql_fetch_assoc(mysql_query("select count(id_buku) as jumlah from tbl_buku"));
        ?>
        Jumlah : <strong><?php echo $sum['jumlah']; ?></strong> buku </td>
      <td colspan="11"> Hal :
        <?php
		$jumlah_data=mysql_num_rows(mysql_query("SELECT * FROM tbl_buku"));
		$jumlah_halaman=ceil($jumlah_data/$batas);
		$no_halaman=1;	
		while($no_halaman<=$jumlah_halaman){
			if($no_halaman==$halaman){
			echo $no_halaman;
		}else{
		?>
        <a href="?menu=buku&halaman=<?php echo $no_halaman?>"><?php echo $no_halaman?></a>
        <?php
		}
		$no_halaman++;
		}
		?></td>
    </tr>
  </table>
</div>
</body>
