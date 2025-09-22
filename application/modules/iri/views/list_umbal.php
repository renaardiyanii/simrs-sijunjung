<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    // $('#example').DataTable();
    $('#example').DataTable( {
        fixedColumns: {
            left: 7,
            right: 0
        }
    });
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

function submitRupiah(no_register, btn, vol) {
    // let data = $("#formedit").serialize();
    console.log(btn);
    document.getElementById('btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/riclaporan/insert_total_tindakan_pasien",                         
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
      url:"<?php echo base_url(); ?>iri/riclaporan/update_total_tindakan_pasien",                         
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
/* hr {
	border-color:#7DBE64 !important;
} */

td {
    background-color: #FFF;
} .bebas {
    background-color: #50CB93 !important;
  }

/* thead {
    background-color: #ffffff; 
} */
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/input_realisasi_tindakan');?>
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
					<h4 align="center">Input Realisasi Tindakan Rawat Inap</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Penjamin</th>
                                            <th>Kontraktor</th>
                                            <th>No SEP</th>
                                            <th>Inacbg</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>No Register</th>
                                            <th>Tanggal Pulang</th>
                                            <th>Ruang</th>
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
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->carabayar;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nmkontraktor;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_sep;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->kd_inacbg;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_cm;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nama;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->klsiri;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->no_ipd;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo date("d-m-Y", strtotime($row->tgl_keluar_resume));?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>"><?php echo $row->nmruang;?></td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>">
                                                <?php 
                                                    $total_ruang = 0;
                                                    $ruang = $this->rimlaporan->get_ruang_intensif_non_intensif($row->no_ipd)->result();
                                                    foreach($ruang as $r) {
                                                        $diff = 1;
                                                        if($r->tglkeluarrg != null){
                                                            $start = new DateTime($r->tglmasukrg);//start
                                                            $end = new DateTime($r->tglkeluarrg);//end
            
                                                            $diff = $end->diff($start)->format("%a");
                                                            if($diff == 0){
                                                                $diff = 1;
                                                            }
                                                        // echo $diff." Hari"; 
                                                        }else{
                                                            if($r->tgl_keluar_resume != NULL){
                                                                $start = new DateTime($r->tglmasukrg);//start
                                                                $end = new DateTime($r->tgl_keluar_resume);//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                                // echo $diff." Hari"; 
                                                            }else{
                                                                $start = new DateTime($r->tglmasukrg);//start
                                                                $end = new DateTime(date("Y-m-d"));//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                            }
                                                        }
                                                        $total_ruang += ($r->total_tarif * $diff);
                                                    }
                                                    $bukan_ruang = $row->tindakan_igd + $row->tindakan_iri + $row->lab_iri + $row->lab_igd + $row->rad_iri + $row->rad_igd + $row->em_iri + $row->em_igd + $row->ok_iri + $row->ok_igd + $row->resep_igd + $row->resep_iri;
                                                    echo number_format($total_ruang + $bukan_ruang);
                                                    $vol = $bukan_ruang + $total_ruang;
                                                ?>
                                                </td>
                                                <td class="<?= $row->vtot_realisasi ? 'bebas' : ''; ?>">
                                                    <input type="text" class="form form-control" name="tarif_umum" id="tarif-umum-<?= $row->no_ipd ?>" style="width: 60%;" value="<?php echo $row->vtot_realisasi; ?>">
                                                    <?php if($row->vtot_realisasi != NULL) { ?>
                                                        <button type="button" id="edit-btn-tarif-umum-<?= $row->no_ipd ?>" class="btn btn-info " onclick="submitEditRupiah('<?= $row->no_ipd ?>','tarif-umum-<?= $row->no_ipd ?>','<?= $vol; ?>')">Edit</button>  
                                                    <?php } else { ?>
                                                        <button type="button" id="btn-tarif-umum-<?= $row->no_ipd ?>" class="btn btn-primary" onclick="submitRupiah('<?= $row->no_ipd ?>','tarif-umum-<?= $row->no_ipd ?>','<?= $vol; ?>')">Insert</button>  
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
                        </div>
                        <br>
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