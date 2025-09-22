<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
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
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/lap_realisasi_tindakan');?>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days2">	
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
					<h4 align="center">Realisasi Tindakan</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Kelompok Tindakan</th>
                                            <th rowspan="2">Kategori</th>
                                            <th rowspan="2">Sub Kelompok</th>
                                            <th rowspan="2">Tindakan</th>
                                            <th rowspan="2">Satuan</th>
                                            <th colspan="4">Volume</th>
                                            <th colspan="4">Rupiah Realisasi</th>
                                        </tr> 
                                        <tr>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS PLN</th>
                                            <th>IKS DLL</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS PLN</th>
                                            <th>IKS DLL</th>
                                        </tr>                                      
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        $total_ruang_umum = 0;
                                        $total_ruang_bpjs = 0;
                                        $total_ruang_iks = 0;
                                        $total_ruang_ikspln = 0;
                                        $total_umum = 0;
                                        $total_bpjs = 0;
                                        $total_iks_pln = 0;
                                        $total_iks = 0;
                                        foreach($data_pendapatan as $row) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->kel_tindakan;?></td>
                                                <td><?php echo $row->kategori;?></td>
                                                <td><?php echo $row->sub_kelompok;?></td>
                                                <td><?php echo $row->nmtindakan;?></td>
                                                <td><?php echo $row->satuan;?></td>
                                                <td><?php echo $row->qty_bpjs;?></td>
                                                <td><?php echo $row->qty_umum;?></td>
                                                <td><?php echo $row->qty_iks_pln;?></td>
                                                <td><?php echo $row->qty_iks;?></td>
                                                <td><?php echo number_format($row->vtot_bpjs);?></td>
                                                <td><?php echo number_format($row->vtot_umum);?></td>
                                                <td><?php echo number_format($row->vtot_iks_pln);?></td>
                                                <td><?php echo number_format($row->vtot_iks);?></td>
                                            </tr>
                                        <?php $total_bpjs += $row->vtot_bpjs;
                                            $total_umum += $row->vtot_umum;
                                            $total_iks += $row->vtot_iks;
                                            $total_iks_pln += $row->vtot_iks_pln; 
                                        }
                                        if($ruang) {
                                            foreach($ruang as $r) {
                                                $total_ruang_umum += $r->vtot_umum;
                                                $total_ruang_bpjs += $r->vtot_bpjs;
                                                $total_ruang_iks += $r->vtot_iks;
                                                $total_ruang_ikspln += $r->vtot_iks_pln;
                                                // $diff = 1;
                                                // if($r->tglkeluarrg != null){
                                                //     $start = new DateTime($r->tglmasukrg);//start
                                                //     $end = new DateTime($r->tglkeluarrg);//end
            
                                                //     $diff = $end->diff($start)->format("%a");
                                                //     if($diff == 0){
                                                //         $diff = 1;
                                                //     }
                                                //     // echo $diff." Hari"; 
                                                // }else{
                                                //     if($r->tgl_keluar_resume != NULL){
                                                //         $start = new DateTime($r->tglmasukrg);//start
                                                //         $end = new DateTime($r->tgl_keluar_resume);//end
            
                                                //         $diff = $end->diff($start)->format("%a");
                                                //         if($diff == 0){
                                                //             $diff = 1;
                                                //         }
                                                //         // echo $diff." Hari"; 
                                                //     }else{
                                                //         $start = new DateTime($r->tglmasukrg);//start
                                                //         $end = new DateTime(date("Y-m-d"));//end
            
                                                //         $diff = $end->diff($start)->format("%a");
                                                //         if($diff == 0){
                                                //             $diff = 1;
                                                //         }       
                                                //         // echo $diff." Hari"; 
                                                //     }
                                                // }
                                                //echo $diff.'<br>';
                                                //$total_ruang_umum += $r->total_tarif * $diff; ?>
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $r->kel_tindakan;?></td>
                                                    <td><?php echo $r->kategori;?></td>
                                                    <td><?php echo $r->sub_kelompok;?></td>
                                                    <td><?php echo $r->nmruang.' ('.$r->kelas.')';?></td>
                                                    <td><?php echo $r->satuan;?></td>
                                                    <td><?php echo $r->qty_bpjs;?></td>
                                                    <td><?php echo $r->qty_umum;?></td>
                                                    <td><?php echo $r->qty_iks_pln;?></td>
                                                    <td><?php echo $r->qty_iks;?></td>
                                                    <td><?php echo number_format($r->vtot_bpjs);?></td>
                                                    <td><?php echo number_format($r->vtot_umum);?></td>
                                                    <td><?php echo number_format($r->vtot_iks_pln);?></td>
                                                    <td><?php echo number_format($r->vtot_iks);?></td>
                                                </tr>
                                        <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                        <h5><b>Total Rupiah BPJS : </b><?php echo number_format($total_ruang_bpjs + $total_bpjs); ?></h5><br>
                        <h5><b>Total Rupiah UMUM : </b><?php echo number_format($total_ruang_umum + $total_umum); ?></h5><br>
                        <h5><b>Total Rupiah IKS PLN : </b><?php echo number_format($total_ruang_ikspln); ?></h5><br>
                        <h5><b>Total Rupiah IKS DLL : </b><?php echo number_format($total_iks + $total_ruang_iks); ?></h5>
                    </div>
                    <a href="<?= base_url('iri/riclaporan/excel_lap_realisasi_tindakan'.'/'.$tgl1.'/'.$tgl2); ?>" class="btn btn-danger" target="_blank">Excel</a>
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