<?php
@session_start();
include "../config/database.php";

$perintah = new oop();
$table = "tbl_distributor";
$where = "id_distributor = '$_GET[id]'";
$redirect = "?menu=distributor";

$field = array(
  'nama_distributor' => $_POST['nama'], 
  'alamat' => $_POST['alamat'],
  'telpon' => $_POST['telpon']
);

if (isset($_POST['simpan'])) { 
    $perintah->simpan($table, $field, $redirect);
}
if (isset($_GET['hapus'])) {
    $perintah->hapus($table, $where, $redirect);
}
if (isset($_GET['edit'])) {
    $edit = $perintah->edit($table, $where);
}
if (isset($_POST['ubah'])) {
    $perintah->ubah($table, $field, $where, $redirect);
}
if(isset($_POST['cari'])){
  $cari = "WHERE nama_distributor LIKE '%$_POST[txtcari]%'";
}
?>
<body OnLoad="document.myform.nama.focus();">
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Distributor</h4>
    </div>
  </div>
  <div class="panel-body">
    <form class="form form-vertical" method="post" name="myform">
      <div class="control-group">
        <label>Nama Distributor</label>
        <div class="controls">
          <input type="text" name="nama" setFocus class="form-control" value="<?php echo $edit['nama_distributor'] ?>" required placeholder="Masukan nama distributor">
        </div>
      </div>
      <div class="control-group">
        <label>Alamat</label>
        <div class="controls">
          <textarea class="form-control" name="alamat"><?php echo $edit['alamat'] ?></textarea>
        </div>
      </div>
      <div class="control-group">
        <label>Telpon</label>
        <div class="controls">
          <input type="number" name="telpon" class="form-control" value="<?php echo $edit['telpon'] ?>" placeholder="Masukan Telpon">
        </div>
      </div>
       <div class="control-group">
        <label></label>
        <div class="controls">
          <?php if ($_GET['id'] == "") { ?>
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <?php } else { ?>
          <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
          <?php } ?>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="form-group form-inline text-right">
  <div class="clearfix"></div>
  <div class="controls">
    <form method="post" class="form-group form-inline">
      <label>Pencarian :</label>
      <input type="text" name="txtcari" class="form-group form-control" placeholder="nama distributor">
      <button type="submit" name="cari" class="form-group btn btn-info">Cari</button>
      <a class="form-group btn btn-success" href="?menu=distributor">Refresh</a>
    </form>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-hover table-bordered table-responsive">
    <tr>
      <th>Nama Distributor</th>
      <th>Alamat</th>
      <th>Telpon</th>
      <th>Edit</th>
      <th>Hapus</th>
    </tr>
    <?php 
    $halaman=$_GET['halaman'];
    if(empty($halaman)){
    $halaman=1;
    }
    $batas=30;
    $posisi=($halaman-1) * $batas;
    $sql = mysql_query("SELECT * FROM tbl_distributor $cari order by id_distributor DESC limit $posisi,$batas");
    $cek = mysql_num_rows($sql);
    if ($cek == "") {
      echo "<tr><td align='center' colspan='5'>Tidak ada data distributor</td></tr>";
    } else {
      while($r=mysql_fetch_assoc($sql)){
    ?>
    <tr>
      <td><?php echo $r['nama_distributor'] ?></td>
      <td><?php echo $r['alamat'] ?></td>
      <td><?php echo $r['telpon'] ?></td>
      
      <td align="center">
      <a href="?menu=distributor&edit&id=<?php echo $r['id_distributor'] ?>" title="EDIT">
      <img class="img-responsive" src="../img/b_edit.png">
      </a>
      </td>
      <?php 
        //distributor yg sudah masok buku ga bisa di hapus 
        $cek = mysql_fetch_assoc(mysql_query("SELECT id_distributor FROM tbl_pasok"));
        if($cek['id_distributor'] == $r['id_distributor']){
          echo "";
        }else{ 
      ?>
      <td align="center">
      <a href="?menu=distributor&hapus&id=<?php echo $r['id_distributor'] ?>" title="HAPUS" onClick="return confirm('Hapus distributor <?php echo $r['nama_distributor'] ?> ? ')">
      <img class="img-responsive" src="../img/b_drop.png">
      </a>
      </td>
      <?php } ?>
    </tr>
    <?php } } ?>
    <tr>
      <td><?php
        $sum = mysql_fetch_assoc(mysql_query("select count(id_distributor) as jumlah from tbl_distributor"));
        ?>
        Jumlah : <strong><?php echo $sum['jumlah']; ?></strong> distributor </td>
      <td colspan="4"> Hal :
        <?php
    $jumlah_data=mysql_num_rows(mysql_query("SELECT * FROM tbl_distributor"));
    $jumlah_halaman=ceil($jumlah_data/$batas);
    $no_halaman=1;  
    while($no_halaman<=$jumlah_halaman){
      if($no_halaman==$halaman){
      echo $no_halaman;
    }else{
    ?>
        <a href="?menu=distributor&halaman=<?php echo $no_halaman?>"><?php echo $no_halaman?></a>
        <?php
    }
    $no_halaman++;
    }
    ?></td>
    </tr>
  </table>
</div>
</body>