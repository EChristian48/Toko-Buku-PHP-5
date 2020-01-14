<?php
@session_start();
include "../config/database.php";
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>DATA BUKU TIDAK TERJUAL</h4>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group form-inline text-left">
      <div class="clearfix"></div>
      <div class="controls"><a target="_blank" href="laporan/lap_data_buku_tidak_terjual_cetak_excel.php" class="btn btn-success">Export Excel</a> </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>NO ISBN</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Harga Jual</th>
          <th>Total Jumlah Beli</th>
          <th>Total Transaksi</th>
        </tr>
        <?php
				$no=0;
                $sql = mysql_query("SELECT * FROM tbl_buku WHERE id_buku NOT IN (SELECT id_buku FROM tbl_penjualan)");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
				?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['judul']; ?></td>
          <td><?php echo $r['noisbn'] ?></td>
          <td><?php echo $r['penulis'] ?></td>
          <td><?php echo $r['penerbit'] ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td>0</td>
          <td>0</td>
          <?php } ?>
           <tr>
    	<td colspan="2" align="right"><strong>Jumlah</strong></td>
        <?php $jumlah = mysql_num_rows($sql); ?>
        <td colspan="6"><strong><?php echo $jumlah; ?> Buku</strong></td>
    </tr>
      </table>
    </div>
  </div>
  <!--/panel content--> 
</div>
<!--/panel--> 
