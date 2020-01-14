<?php
@session_start();
include "../../config/database.php";
function IndonesiaTgl($tanggal){
  $tgl=substr($tanggal,8,2);
  $bln=substr($tanggal,5,2);
  $thn=substr($tanggal,0,4);
  $tanggal="$tgl-$bln-$thn";
  return $tanggal;
}
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
                <h2 class="text-center">LAPORAN PASOK BERDASARKAN DISTRIBUTOR</h2>
                <h2 class="text-center">Nama Distributor : <?php echo $_GET['distributor'] ?></h2>
                <p class="text-right">Tanggal Cetak : <?php echo date('d-m-Y');?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>Judul Buku</th>
          <th>NO ISBN</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Harga Jual</th>
          <th>Stok</th>
          <th>Jumlah Pasok</th>
          <th>Tanggal</th>
        </tr>
        <?php
        $no=0;
                $sql = mysql_query("SELECT tbl_pasok .*, judul, noisbn, penulis, penerbit, harga_jual, stok, nama_distributor FROM tbl_pasok INNER JOIN tbl_buku ON tbl_pasok.id_buku = tbl_buku.id_buku INNER JOIN tbl_distributor ON tbl_pasok.id_distributor = tbl_distributor.id_distributor WHERE nama_distributor ='$_GET[distributor]' ORDER BY id_pasok DESC");
                while ($myData = mysql_fetch_assoc($sql)) {
                $no++
        ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $myData['judul'] ?></td>
          <td><?php echo $myData['noisbn'] ?></td>
          <td><?php echo $myData['penulis'] ?></td>
          <td><?php echo $myData['penerbit'] ?></td>
          <td><?php echo format_angka($myData['harga_jual']) ?></td>
          <td><?php echo $myData['stok'] ?></td>
          <td><?php echo $myData['jumlah'] ?></td>
          <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
          <?php } ?>
        <tr>
          <th class="text-right">Jumlah</th>
          <?php 
            $jumlah = mysql_num_rows(mysql_query("SELECT tbl_pasok .*, judul, noisbn, penulis, penerbit, harga_jual, stok, nama_distributor FROM tbl_pasok INNER JOIN tbl_buku ON tbl_pasok.id_buku = tbl_buku.id_buku INNER JOIN tbl_distributor ON tbl_pasok.id_distributor = tbl_distributor.id_distributor"));
          ?>
          <td colspan="9"><strong><?php echo $jumlah; ?> Buku</strong></td>
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