<?php
@session_start();
include "../config/database.php";

$table = "tbl_user";
$username = $_POST['username'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$redirect = "?menu=admin_addakun";
if (isset($_POST['tambah'])){
	if($pass1==$pass2){	
		$pass = base64_encode($pass1);
		$field = array('nama'=>$_POST['nama'], 'alamat'=>$_POST['alamat'], 'telpon'=>$_POST['telpon'], 'status'=>$_POST['status'], 'username'=>$username,'password' => $pass, 'akses'=>$_POST['akses']);	
		$perintah->simpan($table, $field, $redirect);
	}else{
		echo "<script>alert('Penambahan akun gagal !! Cek password yang anda masukan');document.location.href='?menu=addakun'</script>";
	}
}	
?>
<div class="panel panel-default">
                	<div class="panel-heading">
                      	<div class="panel-title">
                      	<h4 class="text-uppercase">Form Tambah Akun</h4>
                      	</div>
                	</div>
                	<div class="panel-body">
                      <form class="form form-vertical" method="post">
                        <div class="control-group">
                          <label>Nama Lengkap</label>
                          <div class="controls">
                           <input type="text" name="nama" class="form-control" placeholder="Masukan Nama Lengkap" required>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Alamat</label>
                          <div class="controls">
                           <textarea name="alamat" class="form-control" required></textarea>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Telpon</label>
                          <div class="controls">
                           <input type="number" name="telpon" class="form-control" placeholder="Masukan telpon" required>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Status</label>
                          <div class="controls">
                           <select name="Status" class="form-control" required>
                             <option></option>
                              <option value="Sudah Menikah">Sudah Menikah</option>
                              <option value="Belum Menikah">Belum Menikah</option>
                           </select>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Masukan Username</label>
                          <div class="controls">
                           <input type="text" name="username" class="form-control" placeholder="Masukan username" required>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Masukan Password</label>
                          <div class="controls">
                           <input type="password" name="pass1" class="form-control" placeholder="Masukan password" required>
                          </div>
                        </div>  
                        <div class="control-group">
                          <label>Ulangi Masukan Password</label>
                          <div class="controls">
                           <input type="password" name="pass2" class="form-control" placeholder="Ulangi masukan password" required>
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Hak Akses</label>
                          <div class="controls">
                           <select name="akses" class="form-control" required>
                              <option></option>
                              <option value="manager">Manager</option>
                              <option value="admin">Admin</option>
                              <option value="kasir">Kasir</option>
                           </select>
                          </div>
                        </div>
                        <div class="control-group">
                          	<label></label>
                        	<div class="controls">
                            <button type="submit" name="tambah" class="btn btn-primary">Tambah Akun</button>
                            </div>
                        </div>   
                      </form>                
                  </div><!--/panel content-->
</div><!--/panel-->