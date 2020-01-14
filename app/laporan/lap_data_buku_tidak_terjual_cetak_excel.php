<?php
@session_start();
$tanggal = date('d-m-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$tanggal-laporan_data_buku_tidak_terjual.xls");
include "../../config/database.php";
include "../../library/controllers.php";

$edit= mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_setting_lap"));	
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
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
<h1 style="text-align:center;"><?php echo $edit['nama_perusahaan'];?></h1>
<p style="text-align:center;"><?php echo $edit['alamat'] ?> <br>
  No. Telp <?php echo $edit['no_tlpn'] ?> | Web : <?php echo $edit['web'] ?> | Email : <?php echo $edit['email'] ?></p>
<h2 style="text-align:center;">LAPORAN DATA BUKU TIDAK TERJUAL</h2>
<p style="text-align:right;">Tanggal Cetak	: <?php echo date('d-m-Y');?></p>
<table border="1">
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>NO ISBN</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Harga Jual</th>
          <th>Total Jumlah Beli</th>
          <th>Total Transaksi</th>
        </tr>
        <?php
        $no=0;
                $sql = mysql_query("SELECT * FROM tbl_buku WHERE id_buku NOT IN (SELECT id_buku FROM tbl_penjualan)");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
        ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['judul']; ?></td>
          <td><?php echo $r['noisbn'] ?></td>
          <td><?php echo $r['penulis'] ?></td>
          <td><?php echo $r['penerbit'] ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td>0</td>
          <td>0</td>
          <?php } ?>
           <tr>
      <td colspan="2" align="right"><strong>Jumlah</strong></td>
        <?php $jumlah = mysql_num_rows($sql); ?>
        <td colspan="6"><strong><?php echo $jumlah; ?> Buku</strong></td>
    </tr>
      </table>
</body>
</html>