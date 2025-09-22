
<div class="table-responsive m-t-0">
<table id="tabel_lab_view" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No Lab</th>
      <th>Pemeriksaan</th>
      <th>Biaya</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_bayar = 0;
    if(!empty($list_lab_pasien)){
        foreach($list_lab_pasien as $r){ ?>
        <tr>
            <td><?php echo $r->no_lab ; ?></td>
            <td><?php echo $r->jenis_tindakan ; ?></td>
            <td>Rp. <?php echo number_format($r->biaya_lab,0) ; ?></td>
            <?php $total_bayar = $total_bayar + $r->biaya_lab;?>
        </tr>
        <?php
        }
    }else{ ?>
    <tr>
            <td colspan="7">Data Kosong</td>
        </tr>
    <?php
    }
    ?>
  </tbody>
</table>
</div>
<div class="form-inline" align="right">
    <div class="input-group">
    	<div class="table-responsive m-t-0">
	        <table width="100%" class="table table-hover table-striped table-bordered">
	            <tr>
	              <td colspan="6">Total Lab</td>
	              <td>Rp. <?php echo number_format($total_bayar,0);?></td>
	            </tr>
	        </table>
    	</div>
    </div>
</div>