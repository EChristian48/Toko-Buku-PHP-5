<?php 
	include "../../config/database.php";
?>
<table border="1">
	<tr>
		<th>No</th>
		<th>Kode Buku</th>
		<th>Judul</th>
		<th>NO ISBN</th>
		<th>Penerbit</th>
		<th>Stok</th>
		<th>Harga Pokok</th>
		<th>Harga Jual</th>
		<th>PPN</th>
		<th>Diskon</th>
	</tr>
	<?php 
		$sql = mysql_query("SELECT * FROM tbl_buku WHERE penulis = '$_GET[penulis]'");
		$no =0;
		while($r = mysql_fetch_array($sql)){
		$no++  
	?> 
	<tr>
		<td><?php echo $no ?></td>
		<td><?php echo $r['id_buku'] ?></td>
		<td><?php echo $r['judul'] ?></td>
		<td><?php echo $r['noisbn'] ?></td>
		<td><?php echo $r['penerbit'] ?></td>
		<td><?php echo $r['stok'] ?></td>
		<td><?php echo $r['harga_pokok'] ?></td>
		<td><?php echo $r['harga_jual'] ?></td>
		<td><?php echo $r['ppn'] ?></td>
		<td><?php echo $r['diskon'] ?></td>
	</tr>
	<?php } ?>	 		
</table>