<?php
@session_start();
include "../config/database.php";
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
?>
<div class="table-responsive">                       
	<table class="table table-hover table-bordered">
             <tr>
                <th>Judul Buku (klik judul buku)</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        <?php
     
        $cari = $_GET['cari'];
		$data = "AND judul LIKE '%$cari%' OR penulis LIKE '%$cari%'"; 
		if ( !empty ( $cari ) ) {
			
		$query = mysql_query("SELECT * FROM tbl_buku WHERE stok != '0' $data order by id_buku asc");
		$row = mysql_num_rows($query);
		if ( $row != 0 ) {
		while($r=mysql_fetch_assoc($query)){
		?>
            <tr>
            	<td class="text-center"><a title="PILIH" href="?menu=penjualan&id_buku=<?php echo $r['id_buku'] ?>&judul=<?php echo $r['judul'] ?>&harga=<?php echo $r['harga_jual'] ?>"><?php echo $r['judul'] ?></a></td>
                <td><?php echo $r['penulis'] ?></td>
                <td><?php echo $r['penerbit'] ?></td>
                <td><?php echo format_angka($r['harga_jual']) ?></td>
                <td><?php echo $r['stok'] ?></td>           
        <?php }  } else { echo "<tr><td colspan='6' align='center'>Buku tidak ditemukan</td></tr>"; } } ?>      
    </table>
</div>