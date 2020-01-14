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
      <h4>DATA SEMUA PENJUALAN BUKU</h4>
    </div>
  </div>
  <div class="panel-body">
    <div class="form-group form-inline text-left">
      <div class="clearfix"></div>
      <div class="controls"> <a target="_blank" href="laporan/lap_semua_penjualan_cetak.php" class="btn btn-primary">Cetak</a> <a target="_blank" href="laporan/lap_semua_penjualan_cetak_excel.php" class="btn btn-success">Export Excel</a> </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <tr>
          <th>No</th>
          <th>No Faktur</th>
          <th>Judul Buku</th>
          <th>Jumlah Beli</th>
          <th>Harga Satuan</th>
          <th>PPN</th>
          <th>Diskon</th>
          <th>Total Harga</th>
          <th>Tanggal Transaksi</th>
        </tr>
        <?php
                function IndonesiaTgl($tanggal) {
                    $tgl = substr($tanggal, 8, 2);
                    $bln = substr($tanggal, 5, 2);
                    $thn = substr($tanggal, 0, 4);
                    $tanggal = "$tgl-$bln-$thn";
                    return $tanggal;
                }
				$no=0;
                $sql = mysql_query("SELECT tbl_penjualan .*, judul, ppn, diskon, harga_jual FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku ORDER BY id_penjualan DESC");
                while ($r = mysql_fetch_assoc($sql)) {
                $no++
				?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $r['id_penjualan']; ?></td>
          <td><?php echo $r['judul'] ?></td>
          <td><?php echo $r['jumlah_beli'] ?></td>
          <td><?php echo format_angka($r['harga_jual']) ?></td>
          <td><?php echo $r['ppn'] ?>%</td>
          <td><?php echo $r['diskon'] ?>%</td>
          <td class="text-right"><?php echo format_angka($r['total_harga']) ?></td>
          <td><?php echo IndonesiaTgl($r['tanggal']); ?></td>
          <?php } ?>
        <tr>
          <th class="text-right">Total</th>
                <?php 
						$jumlah = mysql_num_rows(mysql_query("SELECT * FROM tbl_penjualan GROUP BY id_penjualan"));
					?>
                <td> <strong> <?php echo $jumlah; ?> Transaksi</strong></td>
                <th class="text-right">Jumlah</th>
                <?php 
						$jumlah = mysql_fetch_assoc(mysql_query("SELECT jumlah_beli, sum(jumlah_beli) AS jumlah FROM tbl_penjualan"));
					?>
                <td> <strong><?php echo $jumlah['jumlah'] ?></strong></td>
                <td colspan="2"></td>
                <th class="text-right"> <strong>Grand Total</strong></th>
                <?php 
						$harga = mysql_fetch_assoc(mysql_query("SELECT total_harga, sum(total_harga) AS harga FROM tbl_penjualan"));
					?>
                <td class="text-right"> <strong><?php echo format_angka($harga['harga']) ?></strong></td>
        </tr>
      </table>
    </div>
  </div>
  <!--/panel content--> 
</div>
<!--/panel--> 
