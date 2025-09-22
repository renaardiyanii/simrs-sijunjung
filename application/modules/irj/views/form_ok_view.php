
<div class="table-responsive m-t-0">
<table id="tabel_ok_view" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No OK</th>
      <th>Pemeriksaan</th>
      <th>Biaya</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_bayar = 0;
    if(!empty($list_ok_pasien)){
        foreach($list_ok_pasien as $r){ ?>
        <tr>
            <td><?php echo $r->id_pemeriksaan_ok ; ?></td>
            <td><?php echo $r->jenis_tindakan ; ?></td>
            <td>Rp. <?php echo number_format($r->biaya_ok,0) ; ?></td>
            <?php $total_bayar = $total_bayar + $r->biaya_ok;?>
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
	              <td colspan="6">Total OK</td>
	              <td>Rp. <?php echo number_format($total_bayar,0);?></td>
	            </tr>
	        </table>
    	</div>
    </div>
</div>