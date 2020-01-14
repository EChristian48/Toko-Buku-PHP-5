<?php
@session_start();
include "../config/database.php";
$data = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_setting_lap"));
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Toko Buku Qu</title>
</head>
<body>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <div class="logo-beranda"> <img class="img-responsive" src="../img/<?php echo $data['logo']?>"> </div>
      <h2 align="center"><?php echo $data['nama_perusahaan'];?></h2>
      <h3 align="center"><?php echo $data['alamat'];?></h3>
    </div>
  </div>
</div>
<div class="col-md-12 text-center">
  <p>Copyright 2017 <a href="#">Buku Qu</a>. Powered By <a href="#">NAMA KALIAN</a></p>
</div>
</body>
</html>