<?php
@session_start();
$tanggal = date('d-m-Y');
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$tanggal-laporan_semua_penjualan.xls");
include "../../config/database.php";
include "../../library/controllers.php";

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
<h2 style="text-align:center;">LAPORAN SEMUA PENJUALAN Buku</h2>
<p style="text-align:right;">Tanggal Cetak	: <?php echo date('d-m-Y');?></p>
<table border="1">
        <tr>
          <th>No</th>
          <th>No Faktur</th>
          <th>Judul Buku</th>
          <th>Jumlah Beli</th>
          <th>Harga Satuan</th>
          <th>PPN</th>
          <th>Diskon</th>
          <th>Total Harga</th>
          <th>Tanggal Transaksi</th>
        </tr>
        <?php
                function IndonesiaTgl($tanggal) {
                    $tgl = substr($tanggal, 8, 2);
                    $bln = substr($tanggal, 5, 2);
                    $thn = substr($tanggal, 0, 4);
                    $tanggal = "$tgl-$bln-$thn";
                    return $tanggal;
                }
        $no=0;
                $sql = mysql_query("SELECT tbl_penjualan .*, judul, ppn, diskon, harga_jual FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku ORDER BY id_penjualan DESC");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
        ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['id_penjualan']; ?></td>
          <td><?php echo $r['judul'] ?></td>
          <td><?php echo $r['jumlah_beli'] ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td><?php echo $r['ppn'] ?>%</td>
          <td><?php echo $r['diskon'] ?>%</td>
          <td class="text-right"><?php echo format_angka($r['total_harga']) ?></td>
          <td><?php echo IndonesiaTgl($r['tanggal']); ?></td>
          <?php } ?>
        <tr>
          <th class="text-right">Total</th>
                <?php 
            $jumlah = mysql_num_rows(mysql_query("SELECT * FROM tbl_penjualan GROUP BY id_penjualan"));
          ?>
                <td> <strong> <?php echo $jumlah; ?> Transaksi</strong></td>
                <th class="text-right">Jumlah</th>
                <?php 
            $jumlah = mysql_fetch_assoc(mysql_query("SELECT jumlah_beli, sum(jumlah_beli) AS jumlah FROM tbl_penjualan"));
          ?>
                <td> <strong><?php echo $jumlah['jumlah'] ?></strong></td>
                <td colspan="2"></td>
                <th class="text-right"> <strong>Grand Total</strong></th>
                <?php 
            $harga = mysql_fetch_assoc(mysql_query("SELECT total_harga, sum(total_harga) AS harga FROM tbl_penjualan"));
          ?>
                <td class="text-right"> <strong><?php echo format_angka($harga['harga']) ?></strong></td>
        </tr>
      </table>
</body>
</html>