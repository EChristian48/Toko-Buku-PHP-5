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
      <h4>DATA BUKU BANYAK TERJUAL</h4>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group form-inline text-left">
      <div class="clearfix"></div>
      <div class="controls"><a target="_blank" href="laporan/lap_data_buku_terjual_cetak_excel.php" class="btn btn-success">Export Excel</a> </div>
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
                $sql = mysql_query("SELECT judul, noisbn, penulis, penerbit, harga_jual, COUNT( jumlah_beli ) AS tot_transaksi, SUM(jumlah_beli) AS jmlh_beli FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku GROUP BY judul ORDER BY tot_transaksi DESC");
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
          <td><?php echo $r['jmlh_beli'] ?></td>
          <td><?php echo $r['tot_transaksi'] ?></td>
          <?php } ?>
           <tr>
    	<td colspan="2" align="right"><strong>Jumlah</strong></td>
        <?php $jumlah = mysql_num_rows($sql); ?>
        <td colspan="8"><strong><?php echo $jumlah; ?> Buku</strong></td>
    </tr>
      </table>
    </div>
  </div>
  <!--/panel content--> 
</div>
<!--/panel--> 
