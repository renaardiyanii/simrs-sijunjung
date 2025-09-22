<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        fixedColumns: {
            left: 6,
            right: 0
        }
    });
    // $('#example').DataTable();
    $('#date_picker_days').show();
});

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			$('#date_picker_days').show();
		//	$('#date_picker_months').hide();
			$('#date_picker_months').hide();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			$('#date_picker_months').show();
			$('#date_picker_days').hide();
		}
	}

function insert_rumus(no_register) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjclaporan/get_total_tindakan_pasien')?>",
      data: {
        no_register: no_register
      },
      success: function(data){
        var total = +data.resep_iri + + data.mr + + data.igd + + data.rad_iri + + data.rad_igd + + data.lab_igd + + data.lab_iri + + data.ok_igd + + data.ok_iri + + data.igd + + data.iri + + data.irj + + data.resep_igd + + data.gizi_iri + + data.gizi_igd + + data.rehab_iri + + data.rehab_igd;
        // $('#edit_nmtindakan').val(data.jenis_tindakan);
        $('#noreg_hide').val(data.no_ipd);
        $('#vol_umum').val(total);
        $('#tarif_umum').val(data.vtot);
        // $('#nmtindakan_hide').val(data.jenis_tindakan);
      },
      error: function(){
        alert("error");
      }
    });
}

function submitRupiah(no_register, btn, vol) {
    // let data = $("#formedit").serialize();
    console.log(btn);
    document.getElementById('btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>irj/rjclaporan/insert_total_tindakan_pasien",                         
      method:"POST",  
      data:{
        noreg_hide: no_register,
		vol_umum: vol,
		tarif_umum: $('#'+btn).val()
      },  
      success: function(data)  
      { 
        document.getElementById('btn-tarif-umum-'+no_register).innerHTML = 'Insert';
        swal({
          title: "Selesai",
          text: "Data berhasil disimpan",
          type: "success",
          showCancelButton: false,
          closeOnConfirm: true,
          showLoaderOnConfirm: true
        },
        function () {
          window.location.reload();
        }); 
      },
      error:function(event, textStatus, errorThrown) {
        document.getElementById('btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function submitEditRupiah(no_register, btn, vol) {
    document.getElementById('edit-btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>irj/rjclaporan/update_total_tindakan_pasien",                         
      method:"POST",  
      data:{
        noreg_hide: no_register,
		vol_umum: vol,
		tarif_umum: $('#'+btn).val()
      },  
      success: function(data)  
      { 
        document.getElementById('edit-btn-tarif-umum-'+no_register).innerHTML = 'Edit';
        swal({
          title: "Selesai",
          text: "Data berhasil disimpan",
          type: "success",
          showCancelButton: false,
          closeOnConfirm: true,
          showLoaderOnConfirm: true
        },
        function () {
        //   window.location.reload();
        }); 
      },
      error:function(event, textStatus, errorThrown) {
        document.getElementById('edit-btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  }); 
}
</script>
<style>
hr {
	border-color:#7DBE64 !important;
} .bebas {
    background-color: #50CB93 !important;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('irj/rjclaporan/input_realisasi_tindakan');?>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_months1" class="form-control" placeholder="Bulan" name="date_picker_months1">	
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_months2" class="form-control" placeholder="Bulan" name="date_picker_months2">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Input Realisasi Tindakan Rawat Jalan/IGD</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Penjamin</th>
                                            <th>Kontraktor</th>
                                            <th>No SEP</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <th>Tanggal Kunjungan</th>
                                            <th>No Register</th>
                                            <th>Poli</th>
                                            <th>Kelas</th>
                                            <th>Total Tarif RS</th>
                                            <th>Rupiah Realisasi</th>
                                        </tr>                                       
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        $total = 0;
                                        foreach($list_umbal as $row) { ?>
                                            <tr>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $i++; ?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->cara_bayar;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nmkontraktor;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_sep;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_cm;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nama;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan));?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_register;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nm_poli;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->kelas_pasien;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo number_format($row->tindakan + $row->lab + $row->rad + $row->em + $row->ok + $row->resep); 
                                                    $vol = $row->tindakan + $row->lab + $row->rad + $row->em + $row->ok + $row->resep;?>
                                                </td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>">
                                                    <input type="text" class="form form-control" name="tarif_umum" id="tarif-umum-<?= $row->no_register ?>" style="width: 60%; height: 15px;" value="<?php echo $row->vtot_realisasi; ?>">
                                                    <?php if($row->vtot_realisasi != NULL) { ?>
                                                        <button type="button" id="edit-btn-tarif-umum-<?= $row->no_register ?>" class="btn btn-info" onclick="submitEditRupiah('<?= $row->no_register ?>','tarif-umum-<?= $row->no_register ?>','<?= $vol; ?>')">Edit</button>
                                                    <?php } else { ?>
                                                        <button type="button" id="btn-tarif-umum-<?= $row->no_register ?>" class="btn btn-primary" onclick="submitRupiah('<?= $row->no_register ?>','tarif-umum-<?= $row->no_register ?>','<?= $vol; ?>')">Insert</button>
                                                    <?php } ?>     
                                                </td>
                                            </tr>
                                        <?php $total += $vol; } ?>
                                        <!-- <tr>
                                            <td colspan="10"><b>Total</b></td>
                                            <td colspan="2"><?php echo number_format($total); ?></td>
                                        </tr> -->
                                    </tbody>
                                </table>
                        </div><br>
                        <h5><b>Total : </b><?php echo number_format($total); ?></h5>
                    </div>	
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>