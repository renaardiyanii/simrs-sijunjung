<script>
    function inputResep() {
        swal({
            title: "Resep",
            text: "Input Data Resep Pasien?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url('irj/rjcpelayanan/update_rujukan_resep_ruangan')?>",
                    data: {
                        id_poli: "<?=$id_poli?>",
                        no_register: "<?=$no_register?>",
                        obat: "1"
                    },
                    dataType: 'text',
                    success: function (data) {
                        //if(data === 'success'){
                            window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/'.$id_poli)?>", "_self");
                        /*}else{
                            swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                        }*/
                    }
                });
            } else {
                swal("Close", "Batal Input Resep", "error");
            }
        });
    }
</script>
<!--href="<?=base_url('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$no_register.'/'.$id_poli)?>"-->
<!-- table -->
<div class="table-responsive m-t-0">
<table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No Resep</th>
      <th>Nama Obat</th>
      
      <th>Signa</th>
      <th>Biaya Obat</th>
      <th>Qty</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_bayar = 0;
    if(!empty($list_resep_pasien)){
        foreach($list_resep_pasien as $r){ ?>
        <tr>
            <td><?php echo $r->no_resep ; ?></td>
            <td><?php echo $r->nama_obat ; ?></td>
            <td><?php echo $r->signa ; ?></td>
            <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
            <td><?php echo $r->qty ; ?></td>
            <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
            <?php $total_bayar = $total_bayar + $r->vtot;?>
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
	              <td colspan="6">Total Resep</td>
	              <td>Rp. <?php echo number_format($total_bayar,0);?></td>
	            </tr>
	        </table>
    	</div>
    </div>
</div>