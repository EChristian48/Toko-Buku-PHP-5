<?php
@session_start();
include "../config/database.php";
function InggrisTgl($tanggal){
  $tgl=substr($tanggal,0,2);
  $bln=substr($tanggal,3,2);
  $thn=substr($tanggal,6,4);
  $tanggal="$thn-$bln-$tgl";
  return $tanggal;
}
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
$redirect = "?menu=lap_pasok_buku";
# Deklarasi variabel
$filterSQL = ""; 
$tglAwal  = ""; 
$tglAkhir = "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal  = isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir   = isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  // Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterSQL = "WHERE ( tanggal BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$pageQry  = mysql_query("SELECT * FROM tbl_pasok $filterSQL"); 
$jumData  = mysql_num_rows($pageQry);

if(isset($_POST['refresh'])){
  echo "<script>document.location.href='$redirect'</script>";
}
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>LAPORAN PASOK BUKU</h4>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group form-inline text-right">
      <div class="clearfix"></div>
      <div class="controls">
        <form method="post" class=" myform form-group form-inline">
          <label>Periode :</label>
          <input type="text" name="cmbTglAwal" class="tcal form-control" value="<?php echo $tglAwal; ?>">
          s/d
          <input type="text" name="cmbTglAkhir" class="tcal form-group form-control" value="<?php echo $tglAkhir; ?>">
          <button type="submit" name="btnTampil" class="form-group btn btn-info">Tampilkan</button>
          <button type="submit" name="refresh" class="form-group btn btn-primary">Refresh</button>
          <a  target="_blank" class="btn btn-success" href="laporan/lap_filter_tgl_penjualan.php?tglin=<?php echo InggrisTgl($tglAwal); ?>&tglout=<?php echo InggrisTgl($tglAkhir);?>" role="button">Cetak</a>
        </form>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>Nama Distributor</th>
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
  # Perintah untuk menampilkan Penjualan dengan Filter Periode
  $myQry = mysql_query("SELECT tbl_pasok .*, judul, noisbn, penulis, penerbit, harga_jual, stok, nama_distributor FROM tbl_pasok INNER JOIN tbl_buku ON tbl_pasok.id_buku = tbl_buku.id_buku INNER JOIN tbl_distributor ON tbl_pasok.id_distributor = tbl_distributor.id_distributor $filterSQL ORDER BY id_pasok DESC");
  $nomor = 0;
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
  ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $myData['nama_distributor']; ?></td>
          <td><?php echo $myData['judul'] ?></td>
          <td><?php echo $myData['noisbn'] ?></td>
          <td><?php echo $myData['penulis'] ?></td>
          <td><?php echo $myData['penerbit'] ?></td>
          <td><?php echo format_angka($myData['harga_jual']) ?></td>
          <td><?php echo $myData['stok'] ?></td>
          <td><?php echo $myData['jumlah'] ?></td>
          <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="2"><strong>Jumlah : <?php echo $jumData; ?> Data</strong></td>
        </tr>
      </table>
    </div>
  </div>
  <!--/panel content--> 
</div>
<!--/panel-->