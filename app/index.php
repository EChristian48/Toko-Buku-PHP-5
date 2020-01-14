<?php
@session_start();
include "../config/database.php";
include "../library/controllers.php";
$perintah = new oop();
$perintah->tampil("tbl_user WHERE username = '$_SESSION[username]'");
if (empty($_SESSION['akses'])) {
    echo "<script>alert('Silahkan login terlebih dahulu');document.location.href='../'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Toko Buku Qu</title>
<meta name="generator" content="Bootply" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css" />
<link href="../css/styles.css" rel="stylesheet">
<link rel="shortcut icon" href="../img/icon.png">
</head>
<body>
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="?menu=home">Administrator</a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"> <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['username'] ?><span class="caret"></span></a>
          <ul id="g-account-menu" class="dropdown-menu" role="menu">
            <li><a href="?menu=ubahpass">Ubah Password</a></li>
            <?php if($_SESSION['akses']=="manager"){ ?>
            <li><a href="?menu=addakun">Tambah Akun</a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="logout.php" onClick="return confirm('Anda yakin ingin keluar?')"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
      </ul>
    </div>
  </div>
  <!-- /container --> 
</div>
<!-- /Header --> 
<!-- Main -->
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <ul class="list-unstyled">
        <li class="active"> <a href="?menu=home"><i class="glyphicon glyphicon-home"></i> Beranda</a></li>
        <?php if($_SESSION['akses']=="admin"){ ?>
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu">
          <h5>Inputan <i class="glyphicon glyphicon-chevron-down"></i></h5>
          </a>
          <ul class="list-unstyled collapse in" id="userMenu">
            <li><a href="?menu=distributor"><i class="glyphicon glyphicon-file"></i> Input Distributor</a></li>
            <li><a href="?menu=buku"><i class="glyphicon glyphicon-file"></i> Input Buku</a></li>
          </ul>
        </li>
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu1">
          <h5>Tambah <i class="glyphicon glyphicon-chevron-down"></i></h5>
          </a>
          <ul class="list-unstyled collapse in" id="userMenu1">
            <li><a href="?menu=pasok"><i class="glyphicon glyphicon-file"></i> Input Pasok Buku</a></li>
          </ul>
        </li>
        <?php } if($_SESSION['akses']=="kasir"){ ?>
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#userMenu1">
          <h5>Transaksi <i class="glyphicon glyphicon-chevron-down"></i></h5>
          </a>
          <ul class="list-unstyled collapse in" id="userMenu1">
            <li><a href="?menu=penjualan"><i class="glyphicon glyphicon-briefcase"></i> Penjualan</a></li>
          </ul>
        </li>
        <?php } ?>
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#menu2">
          <h5>Laporan <i class="glyphicon glyphicon-chevron-right"></i></h5>
          </a>
          <ul class="list-unstyled collapse" id="menu2">
          	<?php if($_SESSION['akses']=="kasir" or $_SESSION['akses']=="manager"){ ?>
            <li><a href="?menu=form_cetak_faktur">Cetak Faktur</a> </li>
            <li><a href="?menu=lap_semua_penjualan">Semua Penjualan</a> </li>
            <li><a href="?menu=form_filter_tgl_penjualan">Penjualan Pertanggal</a> </li>
            <?php } ?>
            <?php if($_SESSION['akses']=="admin" or $_SESSION['akses']=="manager"){ ?>
            <li><a href="?menu=lap_semua_buku">Semua Data Buku</a> </li>
            <li><a href="?menu=form_filter_penulis_buku">Filter Penulis Buku</a> </li>
            <li><a href="?menu=lap_data_buku_terjual">Buku yang Sering Terjual</a> </li>
            <li><a href="?menu=lap_data_buku_tidak_terjual">Buku yang Tidak Pernah Terjual</a> </li>
            <li><a href="?menu=lap_pasok_buku">Pasok Buku</a> </li>
            <li><a href="?menu=form_filter_pasok_buku">Filter Pasok Buku</a> </li>
            <?php } ?>
          </ul>
        </li>
        <?php if($_SESSION['akses']=="manager"){ ?>
        <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#menu3">
          <h5>Pengaturan <i class="glyphicon glyphicon-chevron-right"></i></h5>
          </a>
          <ul class="list-unstyled collapse" id="menu3">
            <li><a href="?menu=setting">Profil</a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
      <hr>
    </div>
    <!-- /col-3 -->
    <div class="col-md-9">
      <div class="row">
        <?php
          switch ($_GET['menu']) {
          case "home";
                        include "home.php";
                        break;
					case "buku";
                        include "buku.php";
                        break;
          case "distributor";
                        include "distributor.php";
                        break;				
					case "pasok";
                        include "pasok.php";
                        break;					
					case "penjualan";
                        include "penjualan.php";
                        break;
          case "penjualan_formstruk";
                        include "penjualan_formstruk.php";
                        break;
					case "form_cetak_faktur";
                        include "form_cetak_faktur.php";
                        break;
					case "lap_semua_penjualan";
                        include "laporan/lap_semua_penjualan.php";
                        break;
          case "form_filter_tgl_penjualan";
                        include "form_filter_tgl_penjualan.php";
                        break;
  				case "lap_semua_buku";
                        include "laporan/lap_semua_buku.php";
                        break;
					case "lap_data_buku_terjual";
                        include "laporan/lap_data_buku_terjual.php";
                        break;
					case "lap_data_buku_tidak_terjual";
                        include "laporan/lap_data_buku_tidak_terjual.php";
                        break;
          case "form_filter_penulis_buku";
                        include "form_filter_penulis_buku.php";
                        break;
          case "lap_pasok_buku";
                        include "laporan/lap_pasok_buku.php";
                        break;
          case "form_filter_pasok_buku";
                        include "form_filter_pasok_buku.php";
                        break;
					case "setting";
                        include "setting_lap.php";
                        break;
					case "ubahpass";
						            include "akun/ubah_pass.php";
						            break;
					case "addakun";
          						  include "akun/add_akun.php";
          						  break;
          }
          ?>
      </div>
      <!--/row--> 
    </div>
    <!--/col-span-9--> 
  </div>
</div>
<!-- /Main --> 
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/scripts.js"></script>
</body>
</html>