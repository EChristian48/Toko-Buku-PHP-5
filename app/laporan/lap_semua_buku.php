<?php
@session_start();
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>LAPORAN SEMUA BUKU</h4>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group form-inline text-left">
      <div class="clearfix"></div>
      <div class="controls"> <a target="_blank" href="laporan/lap_semua_buku_cetak.php" class="btn btn-primary">Cetak</a> <a target="_blank" href="laporan/lap_semua_buku_cetak_excel.php" class="btn btn-success">Export Excel</a> </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>Kode Buku</th>
          <th>Judul</th>
          <th>NO ISBN</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Stok</th>
          <th>Harga Pokok</th>
          <th>Harga Jual</th>
          <th>PPN</th>
          <th>Diskon</th>
        </tr>
        <?php
				$no=0;
                $sql = mysql_query("SELECT * FROM tbl_buku ORDER BY id_buku ASC");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
				?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['id_buku']; ?></td>
          <td><?php echo $r['judul'] ?></td>
          <td><?php echo $r['noisbn'] ?></td>
          <td><?php echo $r['penulis'] ?></td>
          <td><?php echo $r['penerbit'] ?></td>
          <td><?php echo $r['stok'] ?></td>
          <td><?php echo format_angka($r['harga_pokok']) ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td><?php echo $r['ppn'] ?>%</td>
          <td><?php echo $r['diskon'] ?>%</td>
        </tr>
          <?php } ?>
        <tr>
          <th class="text-right">Jumlah</th>
          <?php 
						$jumlah = mysql_num_rows(mysql_query("SELECT * FROM tbl_buku"));
					?>
          <td colspan="10"><strong><?php echo $jumlah; ?> Buku</strong></td>
        </tr>
      </table>
    </div>
  </div>
  <!--/panel content--> 
</div>
<!--/panel--> 
