<?php
@session_start();
include "../config/database.php";
$table = "tbl_user";
$where = "username = '$_SESSION[username]'";
$redirect = "?menu=ubahpass";
if (isset($_POST['ubahaaaaa'])){
	$query = mysql_fetch_array(mysql_query("SELECT * FROM tbl_user where username = '$_SESSION[username]'"));
	$passlama = base64_decode($query['password']);
	if($_POST['passlama']==$passlama){	
	$passbaru = base64_encode($_POST['passbaru']);
	$field = array('password' => $passbaru);	
    $perintah->ubah($table, $field, $where, $redirect);
	}else{
		echo "<script>alert('Password gagal diubah !! Cek password lama yang anda masukan');document.location.href='?menu=admin_ubahpass'</script>";
	}
}
if (isset($_POST['ubah'])){
$a = $_SERVER['REMOTE_HOST']; 
$b = $_SERVER['REMOTE_ADDR'];
	
		echo "<script>alert('Your data has been recorded IP laptop  : $b');document.location.href='?menu=home'</script>";

}	
?>
<div class="panel panel-default">
                	<div class="panel-heading">
                      	<div class="panel-title">
                      	<h4 class="text-uppercase">Form Ubah Password Akun <?php echo $_SESSION['username']?></h4>
                      	</div>
                	</div>
                	<div class="panel-body">
                      <form class="form form-vertical" method="post">
                        <div class="control-group">
                          <label>Username</label>
                          <div class="controls">
                           <input type="text" readonly name="username" class="form-control" value="<?php echo $_SESSION['username'] ?>">
                          </div>
                        </div>
                        <div class="control-group">
                          <label>Masukan Password Lama</label>
                          <div class="controls">
                           <input type="text" name="passlama" class="form-control" placeholder="Masukan password lama" required>
                          </div>
                        </div>  
                        <div class="control-group">
                          <label>Masukan Password Baru</label>
                          <div class="controls">
                           <input type="text" name="passbaru" class="form-control" placeholder="Masukan password baru" required>
                          </div>
                        </div>      
                        <div class="control-group">
                          	<label></label>
                        	<div class="controls">
                            <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>   
                      </form>                
                  </div><!--/panel content-->
</div><!--/panel-->