<?php
@session_start();
include "../config/database.php";
include "../library/controllers.php";
$perintah = new oop();
$perintah->tampil("tbl_user WHERE username = '$_SESSION[username]'");
if (empty($_SESSION['username'])) {
    echo "<script>alert('Silahkan login terlebih dahulu');document.location.href='../'</script>";
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
if(isset($_GET['no_faktur'])){
	$no_faktur = $_GET['no_faktur'];
	
	$myQry = mysql_query("SELECT tbl_penjualan .*, nama FROM tbl_penjualan 
        INNER JOIN tbl_user ON tbl_user.id_user = tbl_penjualan.id_kasir
        WHERE id_penjualan ='$no_faktur'");
	$kolomData = mysql_fetch_array($myQry);
}
else {
	echo "Data Penjualan dengan Nomor Faktur tersebut tidak ditemukan";
	exit;
}	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>STRUCK PENJUALAN</title>
<link href="../css/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
<style type="text/css">
<!--
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style4 {color: #FF0000}
.style6 {color: #000000}
-->
</style>
</head>
<body onLoad="window.print()">
<table class="table-list" border="0" cellspacing="0" cellpadding="2">
 <tr>
    <td height="87" colspan="7" align="center">
		<span class="style2"><span class="style6">STRUCK PENJUALAN</span><br />
      <strong>Toko Buku Qu</strong></span><br />
        <span class="style6"><strong>Alamat : </strong>Alamat : Jl. Nyi Raja Permas, Blok C1 Psr. Anyar-Bogor</span></td>
  </tr>
  <tr>
    <td colspan="4"><strong>No Faktur :</strong> <?php echo $no_faktur; ?></td>
    <td colspan="3" align="right"> <?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
  </tr>
  <tr>
      <td colspan="7"><strong>Kasir :</strong> <?php echo $kolomData['nama']; ?></td>
  </tr>
            <tr>
            	<th bgcolor="#F5F5F5">No</th>
                <th bgcolor="#F5F5F5">Judul Buku</th>
                <th bgcolor="#F5F5F5">Jumlah Beli</th>
                <th bgcolor="#F5F5F5">Harga Satuan</th>
                <th bgcolor="#F5F5F5">PPN</th>
                <th bgcolor="#F5F5F5">Diskon</th>
                <th bgcolor="#F5F5F5" align="right">Total</th>
            </tr>
 		<?php 
		$no =0;
		$query = mysql_query("SELECT tbl_penjualan .*, judul, ppn, diskon, harga_jual FROM tbl_penjualan INNER JOIN tbl_buku ON tbl_penjualan.id_buku = tbl_buku.id_buku WHERE id_penjualan='$_GET[no_faktur]'");
		while($r=mysql_fetch_array($query)){
		$no++
		?>
            <tr>
                <td><strong><?php echo $no ?></strong></td>
                <td><strong><?php echo $r['judul'] ?></strong></td>
                <td><strong><?php echo $r['jumlah_beli'] ?></strong></td>
                <td><strong><?php echo format_angka($r['harga_jual']) ?></strong></td>
                <td><?php echo $r['ppn'] ?>%</td>
                <td><?php echo $r['diskon'] ?>%</td>
                <?php 
                $harga_asli = $r['harga_jual'] * $r['jumlah_beli']; 
                $ppn = $r['ppn'] / 100 * $harga_asli;
                $diskon = $r['diskon'] / 100 * $harga_asli;
                $total = $harga_asli + $ppn - $diskon;
                ?>
                <td align="right"><strong><?php echo format_angka($total); ?></strong></td>
            </tr>
        <?php } ?>
        	<tr>
            	<td colspan="2" align="right"><strong>Jumlah</strong></td>
                <?php 
					$jumlah = mysql_fetch_array(mysql_query("SELECT jumlah_beli, sum(jumlah_beli) as jumlah_beli from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
                <td><strong><?php echo $jumlah['jumlah_beli'] ?> buku</strong></td>
                <td colspan="3" align="right"><strong>Grand Total</strong></td>
                <?php 
					$grand = mysql_fetch_array(mysql_query("SELECT total_harga, sum(total_harga) as grand_total from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
                <td align="right"><strong><?php echo format_angka($grand['grand_total']) ?></strong></td>
            </tr>
            <tr>
            	<td colspan="6" align="right"><strong>Bayar</strong></td>
                <?php 
					$bayar = mysql_fetch_array(mysql_query("SELECT bayar as data_bayar from tbl_penjualan WHERE id_penjualan = '$_GET[no_faktur]'"));
				?>
                <td align="right"><strong><?php echo format_angka($bayar['data_bayar']) ?></strong></td>
            </tr>
              <tr>
            <?php 
				$kembalian = $bayar['data_bayar'] - $grand['grand_total']; 
			?>
             <?php if($kembalian < 0){ ?>
            <td colspan="6" align="right"><strong>Hutang</strong></td>
			<?php }else{ ?>    
            <td colspan="6" align="right"><strong>Kembalian</strong></td>
            <?php } ?>
            	<td align="right"><strong><?php echo format_angka($kembalian) ?></strong></td>
            </tr>   
</table>                     
</body>
</html>