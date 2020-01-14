<?php
@session_start();
$tanggal = date('d-m-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$tanggal-laporan_semua_buku.xls");
include "../../config/database.php";
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
$edit= mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_setting_lap"));	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo $edit['nama_perusahaan'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<link rel="shortcut icon" href="../../img/<?php echo $edit['logo'];?>">
</head>
<body>
<h1 style="text-align:center;">Toko Buku Qu</h1>
<p style="text-align:center;"><?php echo $edit['alamat'] ?> <br>
  No. Telp <?php echo $edit['no_tlpn'] ?> | Web : <?php echo $edit['web'] ?> | Email : <?php echo $edit['email'] ?></p>
<h2 style="text-align:center;">LAPORAN SEMUA BUKU</h2>
<p style="text-align:right;">Tanggal Cetak	: <?php echo date('d-m-Y');?></p>
 <table border="1">
        <tr>
          <th>No</th>
          <th>Kode Buku</th>
          <th>Judul</th>
          <th>NO ISBN</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Stok</th>
          <th>Harga Pokok</th>
          <th>Harga Jual</th>
          <th>PPN</th>
          <th>Diskon</th>
        </tr>
        <?php
        $no=0;
                $sql = mysql_query("SELECT * FROM tbl_buku ORDER BY id_buku ASC");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
        ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['id_buku']; ?></td>
          <td><?php echo $r['judul'] ?></td>
          <td><?php echo $r['noisbn'] ?></td>
          <td><?php echo $r['penulis'] ?></td>
          <td><?php echo $r['penerbit'] ?></td>
          <td><?php echo $r['stok'] ?></td>
          <td><?php echo format_angka($r['harga_pokok']) ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td><?php echo $r['ppn'] ?>%</td>
          <td><?php echo $r['diskon'] ?>%</td>
          <?php } ?>
        <tr>
          <th class="text-right">Jumlah</th>
          <?php 
            $jumlah = mysql_num_rows(mysql_query("SELECT * FROM tbl_buku"));
          ?>
          <td colspan="10"><strong><?php echo $jumlah; ?> Buku</strong></td>
        </tr>
      </table>
</body>
</html>