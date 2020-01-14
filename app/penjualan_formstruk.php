<?php
@session_start();
include "../config/database.php";
$perintah = new oop();
$perintah->tampil("tbl_user WHERE username = '$_SESSION[username]'");
if (empty($_SESSION['username'])) {
    echo "<script>alert('Silahkan login terlebih dahulu');document.location.href='../'</script>";
}	
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
$table = "tbl_penjualan";
$where = "id_penjualan = '$_GET[no_faktur]'";
$redirect = "?menu=form_cetak_faktur";

?>

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Struck</h4>
    </div>
  </div>
  <div class="panel-body">
    <form class="form" method="post">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Jumlah Beli</th>
            <th>Harga Satuan</th>
            <th>PPN</th>
            <th>Diskon</th>
            <th>Total</th>
          </tr>
          <?php 
		$no =0;
		$query = mysql_query("SELECT tbl_penjualan .*, judul, ppn, diskon, harga_jual FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku WHERE id_penjualan='$_GET[no_faktur]'");
		while($r=mysql_fetch_array($query)){
		$no++
		?>
          <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $r['judul'] ?></td>
            <td><?php echo $r['jumlah_beli'] ?></td>
            <td><?php echo format_angka($r['harga_jual']) ?></td>
            <td><?php echo $r['ppn'] ?>%</td>
            <td><?php echo $r['diskon'] ?>%</td>
            <?php 
            $harga_asli = $r['harga_jual'] * $r['jumlah_beli']; 
            $ppn = $r['ppn'] / 100 * $harga_asli;
            $diskon = $r['diskon'] / 100 * $harga_asli;
            $total = $harga_asli + $ppn - $diskon;
            ?>  
          <td align="right"><?php echo format_angka($total); ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="2" class="text-right">Jumlah</td>
            <?php 
					$jumlah = mysql_fetch_array(mysql_query("SELECT jumlah_beli, sum(jumlah_beli) as jumlah_beli from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
            <td colspan="3"><strong><?php echo $jumlah['jumlah_beli'] ?> buku</strong></td>
            <td class="text-right">Grand Total</td>
            <?php 
					$grand = mysql_fetch_array(mysql_query("SELECT total_harga, sum(total_harga) as grand_total from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
            <td class="text-right"><strong><?php echo format_angka($grand['grand_total']) ?></strong></td>
          </tr>
          <tr>
            <td colspan="6" class="text-right">Bayar</td>
            <?php 
					$bayar = mysql_fetch_array(mysql_query("SELECT bayar as data_bayar from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
            <td class="text-right"><strong><?php echo format_angka($bayar['data_bayar']) ?></strong></td>
          </tr>
          <tr>
            <?php 
			$kembalian = $bayar['data_bayar'] - $grand['grand_total']; 
			?>
             <?php if($kembalian < 0){ ?>
            <td colspan="6" class="text-right">Hutang</td>
			<?php }else{ ?>    
            <td colspan="6" class="text-right">Kembalian</td>
            <?php } ?>
            <td class="text-right"><strong><?php echo format_angka($kembalian) ?></strong></td>
          </tr>
        </table>
      </div>
      <a target="_blank" href="penjualan_cetakstruck.php?no_faktur=<?php echo $_GET['no_faktur'] ?>" class="btn btn-success btn-lg btn-block">Cetak Struk</a> <a href="?menu=penjualan" class="btn btn-primary btn-lg btn-block">Kembali</a>
    </form>
  </div>
  <!--/panel content--> 
</div>
<!--/panel-->
</div>