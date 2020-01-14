<?php
@session_start();
include "../config/database.php";
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Filter Buku Berdasarkan Penulis</h4>
    </div>
  </div>
  
  <div class="panel-body">
    <form class="form form-vertical" method="post">
        <div class="control-group">
        <label>Nama Penulis</label>
        <div class="controls">
          <select name="penulis" class="form-control" onchange="submit()" required>
            <option value="<?php echo $_POST['penulis'] ?>"><?php echo $_POST['penulis'] ?></option>
            <?php 
				$sql = mysql_query("SELECT penulis FROM tbl_buku GROUP BY penulis");
				while($penulis = mysql_fetch_assoc($sql)){
			?>
            <option value="<?php echo $penulis['penulis'] ?>"><?php echo $penulis['penulis'] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label></label>
        <div class="controls">
          <a href="laporan/lap_filter_penulis_buku.php?penulis=<?php echo $_POST[penulis]?>" target="_blank" class="btn btn-primary btn-lg btn-block">LIHAT</a>  
        </div>
      </div>
      
    </form>
  </div>
  
  <!--/panel content--> 
</div>
