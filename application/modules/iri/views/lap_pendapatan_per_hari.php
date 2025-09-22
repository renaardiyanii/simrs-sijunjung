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
	

    $('#detailModal').on('shown.bs.modal', function(e) {
         //get data-id attribute of the clicked element

        var no_register = $(e.relatedTarget).data('id');
        //tableDetail.clear().draw();
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {no_register:no_register},
            url: "<?php echo site_url(); ?>rad/radclaporan/get_detail_bhp_rad",
            success: function( response ) {
                tableDetail.clear().draw();
                tableDetail.rows.add(response.data);
                tableDetail.columns.adjust().draw();

                $("#total_rekap").html(response.total);
            }
        });
    });

    tableDetail = $('#tableDetail').DataTable({
            columns: [
                { data: "no_register" },
                { data: "jenis_tindakan" },
                { data: "nama_bhp" },
                { data: "satuan" },
                { data: "kategori" },
                { data: "qty" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false },
                { targets: [ 4 ], orderable: false },
                { targets: [ 5 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
        });
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
<style>
hr {
	border-color:#7DBE64 !important;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/pendapatan_perhari');?>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days1" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days2" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div>	
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >
                                    <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		
                                </div>
                                <div id="month_input">
                                    <input type="date" id="date_picker_months2" class="form-control" placeholder="Bulan" name="date_picker_months2">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="jaminan" id="jaminan" class="form-control">
                                    <option value="">-- piih jaminan --</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="KERJASAMA">Kerjasama </option>
                                    <option value="UMUM">UMUM </option>
                                    <option value="selisih_tarif">Selisih Tarif</option>
                                    <option value="gabungan">Gabungan</option>
                                </select>
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


</section>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan Pendapatan Perhari</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Ins Rawat Intensive</th>
                                            <th>IGD</th>
                                            <th>Ins Bedah Sentral</th>
                                            <th>Ins Gizi</th> 
                                            <th>Ins Laboratorium</th>
                                            <th>Ins MR</th>
                                            <th>Ins Radiologi</th>
                                            <th>Elektromedik</th>
                                            <?php if($jaminan == 'UMUM') { ?>
                                                <th>Ins Farmasi</th>
                                                <th>Non Pasien</th>
                                            <?php } ?>
                                            <th>Ins Rawat Inap</th>
                                            <th>Ins Rawat Jalan</th>
                                            <th>Ins Rehab</th>
                                            <th>Total</th>
                                        </tr>                                       
                                    </thead>
                                    <tbody id="tbodyexample">
                                       <?php
                                        if($jaminan == 'BPJS') {
                                            foreach($data_pendapatan as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row->tgl_keluar_resume;?></td>
                                                    <td><?php 
                                                    $intensive = 0;
                                                    foreach($noreg as $n) {
                                                        $intensif = $this->rimlaporan->get_ruang_intensif($n->no_register);

                                                        $total_intensif = 0;
                                                        foreach($intensif as $ins) {
                                                            $diff = 1;
                                                            if($ins['tglkeluarrg'] != null){
                                                                $start = new DateTime($ins['tglmasukrg']);//start
                                                                $end = new DateTime($ins['tglkeluarrg']);//end
                
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                            // echo $diff." Hari"; 
                                                            }else{
                                                                if($ins['tgl_keluar_resume'] != NULL){
                                                                $start = new DateTime($ins['tglmasukrg']);//start
                                                                    $end = new DateTime($ins['tgl_keluar_resume']);//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    // echo $diff." Hari"; 
                                                                }else{
                                                                    $start = new DateTime($ins['tglmasukrg']);//start
                                                                    $end = new DateTime(date("Y-m-d"));//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    
                                                                    // echo $diff." Hari"; 
                                                                }
                                                            }
                                                            
                                                            $total_intensif += $ins['tarif_bpjs'] * $diff;
                                                        }
                                                        $intensive += $total_intensif;
                                                    }
                                                    echo number_format($intensive);?></td>
                                                    <td><?php echo number_format($row->igd);?></td>
                                                    <td><?php echo number_format($row->ok);?></td>
                                                    <!-- <td><?php echo number_format($row->resep);?></td> -->
                                                    <td><?php echo number_format($row->gizi);?></td>
                                                    <td><?php echo number_format($row->lab);?></td>
                                                    <td><?php echo number_format($row->mr);?></td>
                                                    <td><?php echo number_format($row->rad);?></td>
                                                    <td><?php echo number_format($row->em);?></td>
                                                    <td><?php 
                                                    $ruang = 0;
                                                    foreach($noreg as $no) {
                                                        $akom = $this->rimlaporan->get_ruang_non_intensif($no->no_register);

                                                        $total_ruang = 0;
                                                        foreach($akom as $v) {
                                                            $diff = 1;
                                                            if($v['tglkeluarrg'] != null){
                                                                $start = new DateTime($v['tglmasukrg']);//start
                                                                $end = new DateTime($v['tglkeluarrg']);//end
                
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                            // echo $diff." Hari"; 
                                                            }else{
                                                                if($v['tgl_keluar_resume'] != NULL){
                                                                $start = new DateTime($v['tglmasukrg']);//start
                                                                    $end = new DateTime($v['tgl_keluar_resume']);//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    // echo $diff." Hari"; 
                                                                }else{
                                                                    $start = new DateTime($v['tglmasukrg']);//start
                                                                    $end = new DateTime(date("Y-m-d"));//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    
                                                                    // echo $diff." Hari"; 
                                                                }
                                                            }
                                                            
                                                            $total_ruang += $v['tarif_bpjs'] * $diff;
                                                        }
                                                        $ruang += $total_ruang;
                                                    }
                                                    echo number_format($ruang + $row->iri);?></td>
                                                    <td><?php echo number_format($row->irj);?></td>
                                                    <td><?php echo number_format($row->rehab);?></td>
                                                    <td><?php echo number_format($intensive + $ruang + $row->igd + $row->ok + $row->gizi + $row->lab + $row->mr + $row->rad + $row->em + $row->iri + $row->irj + $row->rehab);?></td>
                                                </tr>
                                        <?php }
                                        } else if($jaminan == 'UMUM' || $jaminan == 'KERJASAMA' || $jaminan == 'selisih_tarif') {
                                            foreach($data_pendapatan as $row) {
                                                $intensif = $this->rimlaporan->get_ruang_intensif_pendapatan_perhari_umum($row->tgl);
                                                $ruang = $this->rimlaporan->get_ruang_non_intensif_pendapatan_perhari_umum($row->tgl); ?>
                                                <tr>
                                                    <td><?php echo date("d-m-Y", strtotime($row->tgl));?></td>
                                                    <td><?php
                                                    $total_intensif = 0;
                                                    // foreach($intensif as $ui) {
                                                    //     $diff = 1;
                                                    //     if($ui['tglkeluarrg'] != null){
                                                    //         $start = new DateTime($ui['tglmasukrg']);//start
                                                    //         $end = new DateTime($ui['tglkeluarrg']);//end
            
                                                    //         $diff = $end->diff($start)->format("%a");
                                                    //         if($diff == 0){
                                                    //             $diff = 1;
                                                    //         }
                                                    //     // echo $diff." Hari"; 
                                                    //     }else{
                                                    //         if($ui['tgl_keluar_resume'] != NULL){
                                                    //         $start = new DateTime($ui['tglmasukrg']);//start
                                                    //             $end = new DateTime($ui['tgl_keluar_resume']);//end
            
                                                    //             $diff = $end->diff($start)->format("%a");
                                                    //             if($diff == 0){
                                                    //                 $diff = 1;
                                                    //             }
                                                    //             // echo $diff." Hari"; 
                                                    //         }else{
                                                    //             $start = new DateTime($ui['tglmasukrg']);//start
                                                    //             $end = new DateTime(date("Y-m-d"));//end
            
                                                    //             $diff = $end->diff($start)->format("%a");
                                                    //             if($diff == 0){
                                                    //                 $diff = 1;
                                                    //             }
                                                                
                                                    //             // echo $diff." Hari"; 
                                                    //         }
                                                    //     }
                                                    //     //echo $diff.'<br>';
                                                    //     if($jaminan == 'UMUM') {
                                                    //         $total_intensif += $ui['total_tarif'] * $diff;
                                                    //     } else if($jaminan == 'KERJASAMA') {
                                                    //         $total_intensif += $ui['tarif_iks'] * $diff;
                                                    //     } else if($jaminan == 'BPJS') {
                                                    //         $total_intensif += $ui['tarif_bpjs'] * $diff;
                                                    //     }
                                                            
                                                    // }
                                                    echo number_format($row->intensif);
                                                    ?></td>
                                                    <td><?php 
                                                        $igd_gizi_rehab = $row->gizi_igd + $row->rehab_igd;
                                                        if($igd_gizi_rehab > $row->igd) {
                                                            $igdReal = 0;
                                                        } else {
                                                            $igdReal = $row->igd - $igd_gizi_rehab;
                                                        }
                                                        echo number_format($igdReal);
                                                        //$grand_total_igd += $igdReal;
                                                    //echo number_format($row->igd);?></td>
                                                    <td><?php echo number_format($row->ok);?></td>
                                                    <!-- <td><?php echo number_format($row->resep);?></td> -->
                                                    <td><?php echo number_format($row->gizi_igd + $row->gizi_irj);?></td>
                                                    <td><?php echo number_format($row->lab);?></td>
                                                    <td><?php echo number_format($row->mr);?></td>
                                                    <td><?php echo number_format($row->rad);?></td>
                                                    <td><?php echo number_format($row->em);?></td>
                                                    <?php if($jaminan == 'UMUM') { ?>
                                                        <td><?php echo number_format($row->farmasi);?></td>
                                                        <td><?php echo number_format($row->non_pasien);?></td>
                                                    <?php } ?>
                                                    <td><?php 
                                                    $total_ruang = 0;
                                                    // foreach($ruang as $ur) {
                                                    //     //echo $val['idrg'].'<br>';
                                                    //     $diff = 1;
                                                    //     if($ur['tglkeluarrg'] != null){
                                                    //         $start = new DateTime($ur['tglmasukrg']);//start
                                                    //         $end = new DateTime($ur['tglkeluarrg']);//end
            
                                                    //         $diff = $end->diff($start)->format("%a");
                                                    //         if($diff == 0){
                                                    //             $diff = 1;
                                                    //         }
                                                    //     // echo $diff." Hari"; 
                                                    //     }else{
                                                    //         if($ur['tgl_keluar_resume'] != NULL){
                                                    //         $start = new DateTime($ur['tglmasukrg']);//start
                                                    //             $end = new DateTime($ur['tgl_keluar_resume']);//end
            
                                                    //             $diff = $end->diff($start)->format("%a");
                                                    //             if($diff == 0){
                                                    //                 $diff = 1;
                                                    //             }
                                                    //             // echo $diff." Hari"; 
                                                    //         }else{
                                                    //             $start = new DateTime($ur['tglmasukrg']);//start
                                                    //             $end = new DateTime(date("Y-m-d"));//end
            
                                                    //             $diff = $end->diff($start)->format("%a");
                                                    //             if($diff == 0){
                                                    //                 $diff = 1;
                                                    //             }
                                                                
                                                    //             // echo $diff." Hari"; 
                                                    //         }
                                                    //     }
                                                    //     $total_ruang += ($ur['total_tarif'] * $diff);
                                                    // }
                                                    echo number_format($row->iri + $row->ruang);
                                                    ?></td>
                                                    <td><?php 
                                                        $irj_gizi_rehab = $row->gizi_irj + $row->rehab_irj;
                                                        if($irj_gizi_rehab > $row->irj) {
                                                            $irjReal = 0;
                                                        } else {
                                                            $irjReal = $row->irj - $irj_gizi_rehab;
                                                        }
                                                        echo number_format($irjReal);
                                                    //echo number_format($row->irj);?></td>
                                                    <td><?php echo number_format($row->rehab_igd + $row->rehab_irj);?></td>
                                                    <td><?php echo number_format($row->intensif + $igdReal + $row->ok + $row->em + $row->gizi_igd + $row->gizi_irj + $row->lab + $row->mr + $row->rad + $row->ruang + $row->iri + $irjReal + $row->rehab_igd + $row->rehab_irj + $row->farmasi + $row->non_pasien);?></td>
                                                </tr>
                                        <?php }
                                        } else {
                                            foreach($data_pendapatan as $row) {
                                                $intensif = $this->rimlaporan->get_ruang_intensif_pendapatan_perhari($row->tgl_keluar_resume);
                                                $ruang = $this->rimlaporan->get_ruang_non_intensif_pendapatan_perhari($row->tgl_keluar_resume); ?>
                                                <tr>
                                                    <td><?php echo $row->tgl_keluar_resume;?></td>
                                                    <td><?php
                                                    $total_intensif = 0;
                                                    foreach($intensif as $r) {
                                                        $diff = 1;
                                                        if($r['tglkeluarrg'] != null){
                                                            $start = new DateTime($r['tglmasukrg']);//start
                                                            $end = new DateTime($r['tglkeluarrg']);//end
            
                                                            $diff = $end->diff($start)->format("%a");
                                                            if($diff == 0){
                                                                $diff = 1;
                                                            }
                                                        // echo $diff." Hari"; 
                                                        }else{
                                                            if($r['tgl_keluar_resume'] != NULL){
                                                            $start = new DateTime($r['tglmasukrg']);//start
                                                                $end = new DateTime($r['tgl_keluar_resume']);//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                                // echo $diff." Hari"; 
                                                            }else{
                                                                $start = new DateTime($r['tglmasukrg']);//start
                                                                $end = new DateTime(date("Y-m-d"));//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                                
                                                                // echo $diff." Hari"; 
                                                            }
                                                        }
                                                        //echo $diff.'<br>';
                                                        $total_intensif += $r['total_tarif'] * $diff;
                                                    }
                                                    echo number_format($total_intensif + $row->ruang_intensif);?></td>
                                                    <td><?php echo number_format($row->igd);?></td>
                                                    <td><?php echo number_format($row->ok);?></td>
                                                    <!-- <td><?php echo number_format($row->resep);?></td> -->
                                                    <td><?php echo number_format($row->gizi);?></td>
                                                    <td><?php echo number_format($row->lab);?></td>
                                                    <td><?php echo number_format($row->mr);?></td>
                                                    <td><?php echo number_format($row->rad);?></td>
                                                    <td><?php 
                                                    $total_ruang = 0;
                                                    foreach($ruang as $val) {
                                                        //echo $val['idrg'].'<br>';
                                                        $diff = 1;
                                                        if($val['tglkeluarrg'] != null){
                                                            $start = new DateTime($val['tglmasukrg']);//start
                                                            $end = new DateTime($val['tglkeluarrg']);//end
            
                                                            $diff = $end->diff($start)->format("%a");
                                                            if($diff == 0){
                                                                $diff = 1;
                                                            }
                                                        // echo $diff." Hari"; 
                                                        }else{
                                                            if($val['tgl_keluar_resume'] != NULL){
                                                            $start = new DateTime($val['tglmasukrg']);//start
                                                                $end = new DateTime($val['tgl_keluar_resume']);//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                                // echo $diff." Hari"; 
                                                            }else{
                                                                $start = new DateTime($val['tglmasukrg']);//start
                                                                $end = new DateTime(date("Y-m-d"));//end
            
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                                
                                                                // echo $diff." Hari"; 
                                                            }
                                                        }
                                                        $total_ruang += ($val['total_tarif'] * $diff);
                                                    }
                                                    echo number_format($row->iri + $total_ruang + $row->ruang);
                                                    ?></td>
                                                    <td><?php echo number_format($row->irj);?></td>
                                                    <td><?php echo number_format($row->rehab);?></td>
                                                    <td><?php echo number_format($total_intensif + $row->ruang_intensif + $row->igd + $row->ok + $row->gizi + $row->lab + $row->mr + $row->rad + $total_ruang + $row->ruang + $row->iri + $row->irj + $row->rehab);?></td>
                                                </tr>
                                        <?php }
                                        }
                                       ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>	
                    <?php 
                    ?>		
                    <a href="<?= base_url('iri/riclaporan/excel_lap_pendapatan_perhari'.'/'.$date1.'/'.$date2.'/'.$jaminan); ?>" class="btn btn-danger" target="_blank">Excel</a>			
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
<script>
    
function down_excel(){
    var date = document.getElementById('date_picker_days').value;
    var bln = document.getElementById('date_picker_months').value;
    var ppa = document.getElementById('ppa').value;
    var tampil = document.getElementById('tampil').value;

    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>iri/riclaporan/excel_lap_dpjp_utama_tgl/"+date+"/"+ppa;
    } else if(tampil === 'BLN') {
        var url = "<?php echo base_url();?>iri/riclaporan/excel_lap_dpjp_utama/"+bln+"/"+ppa;
    }
    
    window.open(url, '_blank');      
}

function get_bln(){
    var date = document.getElementById('date_picker_days').value;
    var bln = document.getElementById('date_picker_months').value;
    var ppa = document.getElementById('ppa').value;
    var tampil = document.getElementById('tampil').value;
   
    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>iri/riclaporan/lap_dpjp_exe_tgl/"+date+"/"+ppa;
    } else if(tampil === 'BLN') {
        var url = "<?php echo base_url();?>iri/riclaporan/lap_dpjp_exe/"+bln+"/"+ppa;
    }
    
    $.ajax({
        url: url,
        beforeSend: function() {
            $('#btncari').attr('disabled',true);
            $('#btncari').html('Loading....');
        },
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            $('#example').DataTable();
            $('#tbodyexample').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.dokter}</td>
                        <td>${e.jml_icu}</td>
                        <td>${e.jml_hcu}</td>
                        <td>${e.jml_neuro_1}</td>
                        <td>${e.jml_neuro_2}</td>
                        <td>${e.jml_anak_bedah_1}</td>
                        <td>${e.jml_anak_bedah_2}</td>
                        <td>${e.jml_anak_bedah_3}</td>
                        <td>${e.jml_interne_1}</td>
                        <td>${e.jml_interne_2}</td>
                        <td>${e.jml_interne_3}</td>
                        <td>${e.jml_irnab_lt12_2}</td>
                        <td>${e.jml_irnab_lt12_vip}</td>
                        <td>${e.jml_irnab_lt3}</td>
                        <td>${e.jml_irnac_lt1}</td>
                        <td>${e.jml_irnac_lt2}</td>
                        <td>${e.jml_irnac_lt3}</td>
                    </tr>
                    `;
                });
            $('#tbodyexample').append(html);
            $('#example').DataTable();
            return;
            }
            $('#tbodyexample').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');

        },
        error: function(xhr) { // if error occured
            $('#tbodyexample').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');
            
        },
        complete: function() {
            $('#btncari').attr('disabled',false);
            $('#btncari').html('Cari');
        },
    });
}
</script>
    
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>