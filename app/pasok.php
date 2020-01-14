<?php
include "../config/database.php";
function InggrisTgl($tanggal) {
        $tgl = substr($tanggal, 0, 2);
        $bln = substr($tanggal, 3, 2);
        $thn = substr($tanggal, 6, 4);
        $tanggal = "$thn-$bln-$tgl";
        return $tanggal;
}
$table = "tbl_pasok";
$where = "id_pasok = '$_GET[id]'";
$redirect = "?menu=pasok";
$tanggal = InggrisTgl($_POST['tanggal']);
$field = array(
  'id_pasok' => null, 
  'id_distributor' => $_POST['distributor'], 
  'id_buku' => $_POST['buku'],
  'jumlah' => $_POST['jumlah'],
  'tanggal' => $tanggal);

if (isset($_POST['simpan'])) { 
    $perintah->simpan($table, $field, $redirect);
}

if (isset($_GET['hapus'])) {
    $perintah->hapus($table, $where, $redirect);
} 
if(isset($_POST['cari'])){
  $cari = "WHERE judul LIKE '%$_POST[txtcari]%' OR nama_distributor LIKE '%$_POST[txtcari]%'";
}
?>
<body>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Pasok Buku</h4>
    </div>
  </div>
  <div class="panel-body">
    <form class="form form-vertical" method="post">
      <div class="control-group">
        <label>Nama Distributor</label>
        <div class="controls">
          <select class="form-control input-lg" name="distributor" required>
          <option></option>
            <?php 
              $data = $perintah->tampil("tbl_distributor");
              foreach ($data as $r) {
            ?>
          <option value="<?php echo $r['id_distributor'] ?>"><?php echo $r['nama_distributor'] ?></option>
          <?php } ?>
          </select>  
        </div>
      </div>
      <div class="control-group">
        <label>Judul Buku</label>
        <div class="controls">
          <select class="form-control input-lg" name="buku" required>
          <option></option>
            <?php 
              $data = $perintah->tampil("tbl_buku");
              foreach ($data as $r) {
            ?>
          <option value="<?php echo $r['id_buku'] ?>"><?php echo $r['judul'] ?></option>
          <?php } ?>
          </select>  
        </div>
      </div>
      <div class="control-group">
        <label>Jumlah</label>
        <div class="controls">
          <input type="number" name="jumlah" class="form-control" placeholder="Masukan Jumlah Pasok">
        </div>
      </div>
      <div class="control-group">
        <label>Tanggal</label>
        <div class="controls">
          <input type="text" name="tanggal" value="<?php echo date('d-m-Y'); ?>" class="tcal control">
        </div>
      </div>
     
       <div class="control-group">
        <label></label>
        <div class="controls">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
  <!--/panel content--> 
</div>
<!--/panel-->
<div class="form-group form-inline text-right">
  <div class="clearfix"></div>
  <div class="controls">
    <form method="post" class="form-group form-inline">
      <label>Pencarian :</label>
      <input type="text" name="txtcari" class="form-group form-control" placeholder="Judul buku / Distributor">
      <button type="submit" name="cari" class="form-group btn btn-info">Cari</button>
      <a class="form-group btn btn-success" href="?menu=pasok">Refresh</a>
    </form>
  </div>
</div>
<div class="table-responsive">
  <table class="table table-hover table-bordered table-responsive">
    <tr>
      <th>Judul Buku</th>
      <th>Nama Distributor</th>
      <th>Jumlah</th>
      <th>Tanggal</th>
      <th>Hapus</th>
    </tr>
    <?php 
    $halaman=$_GET['halaman'];
    if(empty($halaman)){
    $halaman=1;
    }
    $batas=30;
    $posisi=($halaman-1) * $batas;
    $sql = mysql_query("SELECT tbl_pasok .*, nama_distributor, judul FROM tbl_pasok
    INNER JOIN tbl_distributor ON tbl_distributor.id_distributor = tbl_pasok.id_distributor
    INNER JOIN tbl_buku ON tbl_buku.id_buku = tbl_pasok.id_buku
    $cari order by id_pasok DESC limit $posisi,$batas");
    $cek = mysql_num_rows($sql);
    if ($cek == "") {
      echo "<tr><td align='center' colspan='5'>Tidak ada data pasok</td></tr>";
    } else {
      while($r=mysql_fetch_assoc($sql)){
    ?>
    <tr>
      <td><?php echo $r['judul'] ?></td>
      <td><?php echo $r['nama_distributor'] ?></td>
      <td><?php echo $r['jumlah'] ?></td>
      <td><?php echo $r['tanggal'] ?></td>
      <td align="center"><a href="?menu=pasok&hapus&id=<?php echo $r['id_pasok'] ?>" title="HAPUS" onClick="return confirm('Hapus data pasok dgn judul buku <?php echo $r['judul'] ?> ? ')"><img class="img-responsive" src="../img/b_drop.png"></a></td>
    </tr>
    <?php } } ?>
    <tr>
      <td><?php
        $sum = mysql_fetch_assoc(mysql_query("select count(id_pasok) as jumlah from tbl_pasok"));
        ?>
        Jumlah : <strong><?php echo $sum['jumlah']; ?></strong> pasok </td>
      <td colspan="4"> Hal :
        <?php
    $jumlah_data=mysql_num_rows(mysql_query("SELECT * FROM tbl_pasok"));
    $jumlah_halaman=ceil($jumlah_data/$batas);
    $no_halaman=1;  
    while($no_halaman<=$jumlah_halaman){
      if($no_halaman==$halaman){
      echo $no_halaman;
    }else{
    ?>
        <a href="?menu=pasok&halaman=<?php echo $no_halaman?>"><?php echo $no_halaman?></a>
        <?php
    }
    $no_halaman++;
    }
    ?></td>
    </tr>
  </table>
</div>
</body>
