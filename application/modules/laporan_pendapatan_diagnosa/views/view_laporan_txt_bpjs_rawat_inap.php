<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script>
$(document).ready(function() {
    $('#example').DataTable();
    $('#startMonth').datepicker({
        format: "yyyy-mm",
        viewMode: "months", 
        minViewMode: "months"
    });
    // $('#date_picker_days').show();

    // $('#tgl').daterangepicker({
    //   	opens: 'left',
	// 	format: 'YYYY-MM-DD',
	// });
    // $('#penjamin').select2();
    // $('#penjamin').multiselect({
    //     // enableFiltering: true,
    //     includeSelectAllOption: true,
    //     // buttonClass: 'form-control',
    // });
});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <div class="container-fluid">
					<div class="inline">
						<div class="row">
							<div class="form-inline">
								<form action="<?php echo base_url();?>laporan_pendapatan_diagnosa/Claporantxtbpjs/txtBPJSRawatInap" method="post" accept-charset="utf-8">
								<div class="col-lg-12">
									<i>*pilih bulan untuk melihat laporan</i>
									<div class="form-inline">
										
										<input id="startMonth" class="form-control"  name="startMonth" placeholder="Bulan">&nbsp;&nbsp;&nbsp;
										<!-- <input type="date" id="date_days2" class="form-control" placeholder="Pilih Tanggal" name="date_days2"> -->
										&nbsp;&nbsp;&nbsp;
										<button class="btn btn-primary" type="submit">Tampilkan</button>
									</div>
								</div><!-- /inline -->
								</form>	
							</div>
						</div>						
					</div>
				</div>
			</div>			
		</div>						
	</div>
</div>


<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan BPJS Rawat Inap</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kelompok Penagihan</th>
                                            <th>Tanggal Pelayanan</th>
                                            <th>Kelas Rawatan</th>
                                            <th>ruang rawatan terakhir</th>
                                            <th>SEP</th>
                                            <th>Nama Pasien</th>
                                            <th>Diagnosa</th>
                                            <th>Kode INA-CBG</th>
                                            <th>Deskripsi INA-CBG</th>
                                            <th>Nama DPJP</th>
                                            <th>Spesialistik</th>
                                            <th>LOS RI</th>
                                            <th>Tarif INA-CBG</th>
                                            <th>Tarif RS</th>
                                            <th>Tarif RS total</th>
                                        </tr>                         
                                    </thead>
                                    <tbody>

                                    <?php 
                                    $i = 1;
                                    foreach($data_lap as $val){ ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $val->kelompok_penagihan ?></td>
                                            <td><?= date('d-m-Y',strtotime($val->tgl_keluar)) ?></td>
                                            <td><?= $val->kelas ?></td>
                                            <td><?= $val->nmruang ?></td>
                                            <td><?= $val->no_sep ?></td>
                                            <td><?= $val->nama ?></td>
                                            <td><?= $val->diagnosa ?></td>
                                            <td><?= $val->cbg_code ?></td>
                                            <td><?= $val->descripsi_inacg ?></td>
                                            <td><?= $val->dokterdpjp ?></td>
                                            <td><?= $val->nm_poli ?></td>
                                            <?php 
                                                $diff = 1;
                                               
                                                    if($val->tgl_keluar != NULL){
                                                    $start = new DateTime($val->tgl_masuk);//start
                                                        $end = new DateTime($val->tgl_keluar);//end

                                                        $diff = $end->diff($start)->format("%a");
                                                        if($diff == 0){
                                                            $diff = 1;
                                                        }

                                                    }else{
                                                        $start = new DateTime($val->tgl_masuk);//start
                                                        $end = new DateTime(date("Y-m-d"));//end

                                                        $diff = $end->diff($start)->format("%a");
                                                        if($diff == 0){
                                                            $diff = 1;
                                                        }
                                                    }
                                                
                                            ?>
                                            <td><?= $diff .' '.'Hari' ?></td>
                                            <td><?= $val->tarif_inacbg ?></td>
                                            <td><?= $val->tarif_rs ?></td>
                                            <td><?= $val->tarif_rs_total ?></td>
                                        </tr>    
                                    <?php }
                                    
                                    ?>
                                        
                             
                                    <tbody>
                                </table>
                                <a href="<?php echo site_url('laporan_pendapatan_diagnosa/Claporantxtbpjs/excel_txtBPJSRawatInap/'.$bln);?>"><input type="button" class="btn 
				"  style="background-color: lime;color:white;" value="Excel"></a>
                        </div>
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
        $this->load->view("layout/footer_horizontal");
    }
?>