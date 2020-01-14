<?php
@session_start();
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
<meta name="generator" content="Bootply" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<link href="../../css/styles.css" rel="stylesheet">
<link rel="shortcut icon" href="../../img/<?php echo $edit['logo'];?>">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-12"> <a href="#" onclick="document.getElementById('print').style.display='none';window.print();"><img src="../../img/print-icon.png" id="print" width="25" height="25" border="0" /></a>
      <div class="clearfix"></div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="panel-title">
            <div class="row">
              <div class="col-md-2 col-xs-2"><img class="img-responsive" src="../../img/<?php echo $edit['logo'] ?>"> </div>
              <div class="col-md-10 surat-title">
                <h1>Toko Buku Qu</h1>
                <p><?php echo $edit['alamat'] ?></p>
                <p>No. Telp <?php echo $edit['no_tlpn'] ?> | Web : <?php echo $edit['web'] ?> | Email : <?php echo $edit['email'] ?></p>
                <h2 class="text-center">LAPORAN SEMUA PENJUALAN BUKU</h2>
                <p class="text-right">Tanggal Cetak	: <?php echo date('d-m-Y');?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body">
        <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>No Faktur</th>
          <th>Judul Buku</th>
          <th>ISBN</th>
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
                $sql = mysql_query("SELECT tbl_penjualan .*, judul, noisbn, ppn, diskon, harga_jual FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku ORDER BY id_penjualan DESC");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
        ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['id_penjualan']; ?></td>
          <td><?php echo $r['judul'] ?></td>
          <td><?php echo $r['noisbn'] ?></td>
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
        </div>
        <!--/panel content--> 
      </div>
      <!--/panel--> 
      
    </div>
    <!--/col-span-12--> 
  </div>
</div>
<!-- /Main -->
</body>
</html>