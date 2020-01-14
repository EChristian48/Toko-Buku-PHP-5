<?php
@session_start();
include "../config/database.php";
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">
      <h4>Form Filter Pasok Berdasarkan Distributor</h4>
    </div>
  </div>
  
  <div class="panel-body">
    <form class="form form-vertical" method="post">
        <div class="control-group">
        <label>Nama Distributor</label>
        <div class="controls">
          <select name="distributor" class="form-control" onchange="submit()" required>
            <option value="<?php echo $_POST['distributor'] ?>"><?php echo $_POST['distributor'] ?></option>
            <?php 
				$sql = mysql_query("SELECT tbl_pasok .*, nama_distributor FROM tbl_pasok INNER JOIN tbl_distributor ON tbl_distributor.id_distributor = tbl_pasok.id_distributor GROUP BY nama_distributor");
				while($distributor = mysql_fetch_assoc($sql)){
			?>
            <option value="<?php echo $distributor['nama_distributor'] ?>"><?php echo $distributor['nama_distributor'] ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <div class="control-group">
        <label></label>
        <div class="controls">
          <a href="laporan/lap_filter_distributor_pasok.php?distributor=<?php echo $_POST[distributor]?>" target="_blank" class="btn btn-primary btn-lg btn-block">LIHAT</a>  
        </div>
      </div>
    </form>
  </div>
  
  <!--/panel content--> 
</div>
