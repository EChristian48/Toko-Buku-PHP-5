<?php
@session_start();
include "../config/database.php";
$perintah = new oop();
$perintah->tampil("tbl_user WHERE username = '$_SESSION[username]'");
if (empty($_SESSION['username'])) {
    echo "<script>alert('Silahkan login terlebih dahulu');document.location.href='../'</script>";
}
$edit= mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_setting_lap"));	
$table = "tbl_setting_lap";
$where = "id_setting = '$edit[id_setting]'";
$redirect = "?menu=setting";
$tempat = "../img";
if (isset($_POST['ubahhh'])) {
	$foto = $_FILES['logo'];
    $upload = $perintah->upload($foto, $tempat);
    if (empty($_FILES['logo']['name'])) {
		$field = array('nama_perusahaan' => $_POST['nama'], 'alamat' => $_POST['alamat'], 'no_tlpn' => $_POST['no_tlpn'], 'web' => $_POST['web'], 'no_hp' => $_POST['no_hp'], 'email' => $_POST['email']);
	    $perintah->ubah($table, $field, $where, $redirect);
    } else {
        $field = array('nama_perusahaan' => $_POST['nama'], 'alamat' => $_POST['alamat'], 'no_tlpn' => $_POST['no_tlpn'], 'web' => $_POST['web'], 'logo' => $upload, 'no_hp' => $_POST['no_hp'], 'email' => $_POST['email']);
        $perintah->ubah($table, $field, $where, $redirect);
    }	
}

?>

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Setting Laporan</h4>
    </div>
  </div>
  <div class="panel-body">
    <form class="form form-vertical" method="post" enctype="multipart/form-data">
      <div class="control-group">
        <label>Nama Perusahaan</label>
        <div class="controls">
          <input type="text" name="nama" value="<?php echo $edit['nama_perusahaan'];?>" class="form-control" required>
        </div>
      </div>
      <div class="control-group">
        <label>Alamat</label>
        <div class="controls">
          <textarea name="alamat" class="form-control" required><?php echo $edit['alamat'] ?></textarea>
        </div>
      </div>
      <div class="control-group">
        <label>No Telpon</label>
        <div class="controls">
          <input type="text" name="no_tlpn" class="form-control" value="<?php echo $edit['no_tlpn'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label>No Handphone</label>
        <div class="controls">
          <input type="text" name="no_hp" class="form-control" value="<?php echo $edit['no_hp'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label>Web</label>
        <div class="controls">
          <input type="text" name="web" class="form-control" value="<?php echo $edit['web'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label>Email</label>
        <div class="controls">
          <input type="email" name="email" class="form-control" value="<?php echo $edit['email'] ?>">
        </div>
      </div>
      <div class="form-group form-inline">
        <label>Logo Laporan</label>
        <div class="clearfix"></div>
        <div class="controls">
          <input type="file" name="logo" class="form-control">
          <img width="45" height="45" src="../img/<?php echo $edit['logo'] ?>"> </div>
      </div>
      <div class="control-group">
        <label></label>
        <div class="controls">
          <button type="submit" name="ubah" class="btn btn-primary">Perbaharui</button>
        </div>
      </div>
    </form>
  </div>
  <!--/panel content--> 
</div>
<!--/panel-->