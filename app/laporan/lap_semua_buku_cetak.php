<?php
@session_start();
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
              <div class="col-md-2 col-xs-2"> <img class="img-responsive" src="../../img/<?php echo $edit['logo'] ?>"> </div>
              <div class="col-md-10 surat-title">
                <h1><?php echo $edit['nama_perusahaan'];?></h1>
                <p><?php echo $edit['alamat'] ?></p>
                <p>No. Telp <?php echo $edit['no_tlpn'] ?> | Web : <?php echo $edit['web'] ?> | Email : <?php echo $edit['email'] ?></p>
                <h2 class="text-center">LAPORAN SEMUA BUKU</h2>
                <p class="text-right">Tanggal Cetak	: <?php echo date('d-m-Y');?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
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
          <td></td>
          <th class="text-right">Jumlah</th>
          <?php 
            $jumlah = mysql_num_rows(mysql_query("SELECT * FROM tbl_buku"));
          ?>
          <td colspan="10"><strong><?php echo $jumlah; ?> Buku</strong></td>
        </tr>
      </table>
          </div>
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