<?php
@session_start();
include "../config/database.php";
if(isset($_POST['cetak'])){
	echo "<script>document.location.href='?menu=penjualan_formstruk&no_faktur=$_POST[faktur]'</script>";
}
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Cetak Faktur Penjualan</h4>
    </div>
  </div>
  
  <div class="panel-body">
    <form class="form form-vertical" method="post">
        <div class="control-group">
        <label>No Faktur</label>
        <div class="controls">
          <select name="faktur" class="form-control" required>
            <option value=""></option>
            <?php 
				$sql = mysql_query("SELECT id_penjualan FROM tbl_penjualan GROUP BY id_penjualan");
				while($faktur = mysql_fetch_assoc($sql)){
			?>
            <option value="<?php echo $faktur['id_penjualan'] ?>"><?php echo $faktur['id_penjualan'] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label></label>
        <div class="controls">
          <button type="submit" name="cetak" class="btn btn-primary btn-lg btn-block">LIHAT</button>
        </div>
      </div>
      
    </form>
  </div>
  
  <!--/panel content--> 
</div>
