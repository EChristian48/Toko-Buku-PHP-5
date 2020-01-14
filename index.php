<?php
session_start();

include "config/database.php";
include "library/controllers.php";

$perintah = new oop();

$table = "tbl_user";
$username = $_POST['user'];
$password = base64_encode($_POST['pass']);
$akses = $_POST['akses'];
$nama_form = "app/?menu=home";

if(isset($_POST['login'])) {	
	 $perintah->login($table, $username, $password,$akses, $nama_form);
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
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/icon.png">
	</head>
	<body>
<form method="post">
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">Toko Buku Qu</h1>
      </div>
      <div class="modal-body">        
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="user" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="pass" placeholder="Password" required>
            </div>
            <div class="form-group">
              <select class="form-control input-lg" name="akses" required>
                <option></option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
              </select>
            </div>
            <div class="form-group">
              <button name="login" class="btn btn-primary btn-lg btn-block">Masuk</button>
            </div>  
      </div>
  </div>
  </div>
</div>
</form>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>