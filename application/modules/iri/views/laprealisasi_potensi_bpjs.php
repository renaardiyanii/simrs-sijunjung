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
<style>
hr {
	border-color:#7DBE64 !important;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/lap_realisasi_potensi_bpjs');?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="month" id="date_months" class="form-control" placeholder="Bulan" name="date_months">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="object_claim" id="object_claim" class="form-control">
                                    <option value="">-- piih Objek Klaim --</option>
                                    <option value="RI-Rawat Inap">Rawat Inap</option>
                                    <option value="RJ-Rawat Jalan/IGD">Rawat Jalan/IGD</option>
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
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center"><?php echo $date_title ?></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Realisasi dan Potensi Pendapatan</th>
                                            <th>Rill RS</th>
                                            <th>Rill RS versi umbal</th>
                                            <th>Klaim Diajukan</th>
                                            <th>Umbal Disetujui</th>
                                        </tr>                                       
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $countClaim = 0;
                                        $rillRSUmbal = 0;
                                        $vtotDiajukan = 0;
                                        $vtotDisetujui = 0;
                                        $vtotRill = 0;
                                        $vtotRillBlmClaim = 0;
                                        $vtotRuang = 0;
                                        foreach($potensi_bpjs as $row) { 
                                            $countClaim += $row->vol_kasus_umbal;
                                            $rillRSUmbal += $row->rupiah_rilrs;
                                            $vtotDiajukan += $row->rupiah_diajukan;
                                            $vtotDisetujui += $row->rupiah_disetujui;

                                            $sep = $this->rimlaporan->get_nosep_umbal($row->periode_umbal, $object)->result();?>
                                            <tr>
                                                <td colspan="5" style="font-weight:bold; font-size: 18px;"><?php echo $row->periode_umbal;?></td>
                                                <tr>
                                                    <td>Vol Kasus/Kunjungan</td>
                                                    <td><?php echo $row->vol_kasus_umbal; ?></td> <!-- rill rs -->
                                                    <td><?php echo $row->vol_kasus_umbal; ?></td>
                                                    <td><?php echo $row->vol_kasus_umbal; ?></td>
                                                    <td><?php echo $row->vol_kasus_umbal; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Rupiah</td>
                                                    <td><?php
                                                        $rill = 0;
                                                        $vtotAkomodasiClaim = 0;
                                                        // foreach($sep as $row_nosep) {
                                                        //     $no_register = isset($this->rimlaporan->get_nosep_from_bpjsep($row_nosep->no_sep)->row()->no_register)?$this->rimlaporan->get_nosep_from_bpjsep($row_nosep->no_sep)->row()->no_register:null;
                                                    
                                                        //     if(substr($no_register,0,2) == 'RI') {
                                                        //         $iriRill = isset($this->rimlaporan->get_vtot_iri_blm_claim($no_register)->row()->tarif)?$this->rimlaporan->get_vtot_iri_blm_claim($no_register)->row()->tarif:null;
                                                        //         $irjNoregasalRill = isset($this->rimlaporan->get_vtot_noregasal_blm_claim($no_register)->row()->tarif)?$this->rimlaporan->get_vtot_noregasal_blm_claim($no_register)->row()->tarif:null;
                                                        //         $ruang = $this->rimlaporan->get_ruang_realisasi_potensi($no_register)->result();

                                                        //         $vtotRuangClaim = 0;
                                                        //         foreach($ruang as $val) {
                                                        //             $diff = 1;
                                                        //             if($val->tglkeluarrg != null){
                                                        //                 $start = new DateTime($val->tglmasukrg);//start
                                                        //                 $end = new DateTime($val->tglkeluarrg);//end
                        
                                                        //                 $diff = $end->diff($start)->format("%a");
                                                        //                 if($diff == 0){
                                                        //                     $diff = 1;
                                                        //                 }
                                                        //             }else{
                                                        //                 if($val->tgl_keluar_resume != NULL){
                                                        //                     $start = new DateTime($val->tglmasukrg);//start
                                                        //                     $end = new DateTime($val->tgl_keluar_resume);//end
                        
                                                        //                     $diff = $end->diff($start)->format("%a");
                                                        //                     if($diff == 0){
                                                        //                         $diff = 1;
                                                        //                     }
                                                        //                 }else{
                                                        //                     $start = new DateTime($val->tglmasukrg);//start
                                                        //                     $end = new DateTime(date("Y-m-d"));//end
                        
                                                        //                     $diff = $end->diff($start)->format("%a");
                                                        //                     if($diff == 0){
                                                        //                         $diff = 1;
                                                        //                     } 
                                                        //                 }
                                                        //             }
                                                                    
                                                        //             if($val->titip == '1') {
                                                        //                 $vtotRuangClaim += $val->tarif_jatah_bpjs * $diff;
                                                        //             } else {
                                                        //                 $vtotRuangClaim += $val->tarif_bpjs * $diff;
                                                        //             }
                                                        //         }
                                                        //         $vtotAkomodasiClaim += $vtotRuangClaim;
                                                        //         $rill += $iriRill + $irjNoregasalRill;
                                                        //     } else {
                                                        //         $irjRill = isset($this->rimlaporan->get_vtot_irj_blm_claim($no_register)->row()->tarif)?$this->rimlaporan->get_vtot_irj_blm_claim($no_register)->row()->tarif:null;
                                                        //         $rill += $irjRill;
                                                        //     }
                                                        // } 
                                                       
                                                        // $vtotRill += $rill;
                                                        // $vtotRuang += $vtotAkomodasiClaim;
                                                        //echo number_format($vtotAkomodasiClaim + $rill);
                                                        echo number_format($row->rupiah_rilrs);
                                                    ?></td> <!-- rill rs -->
                                                    <td><?php echo number_format($row->rupiah_rilrs);?></td>
                                                    <td><?php echo number_format($row->rupiah_diajukan);?></td>
                                                    <td><?php echo number_format($row->rupiah_disetujui);?></td>
                                                </tr>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="5" style="font-weight:bold; font-size: 18px;">Belum Klaim</td>
                                            <tr>
                                                <td>Vol Kasus/Kunjungan</td>
                                                <td><?php echo $countSep;?></td> <!-- rill rs -->
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Rupiah</td>
                                                <td><?php
                                                    if($object == 'RI') {
                                                        $rilliri = isset($this->rimlaporan->get_rill_rs_blm_claim_ri($date, $object)->row()->tarif)?$this->rimlaporan->get_rill_rs_blm_claim_ri($date, $object)->row()->tarif:null;
                                                        $rillNoregasal = isset($this->rimlaporan->get_rill_rs_blm_claim_noregasal($date, $object)->row()->tarif)?$this->rimlaporan->get_rill_rs_blm_claim_noregasal($date, $object)->row()->tarif:null;
                                                        
                                                        $vtotAkomodasiBlmClaim = 0;
                                                        foreach($noregBelumClaim as $row_blm) {
                                                            $ruangBlmClaim = $this->rimlaporan->get_ruang_realisasi_potensi($row_blm->no_register)->result();

                                                            $vtotRuangBlmClaim = 0;
                                                            foreach($ruangBlmClaim as $r) {
                                                                $diff = 1;
                                                                if($r->tglkeluarrg != null){
                                                                    $start = new DateTime($r->tglmasukrg);//start
                                                                    $end = new DateTime($r->tglkeluarrg);//end
                    
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                }else{
                                                                    if($r->tgl_keluar_resume != NULL){
                                                                        $start = new DateTime($r->tglmasukrg);//start
                                                                        $end = new DateTime($r->tgl_keluar_resume);//end
                    
                                                                        $diff = $end->diff($start)->format("%a");
                                                                        if($diff == 0){
                                                                            $diff = 1;
                                                                        }
                                                                    }else{
                                                                        $start = new DateTime($r->tglmasukrg);//start
                                                                        $end = new DateTime(date("Y-m-d"));//end
                    
                                                                        $diff = $end->diff($start)->format("%a");
                                                                        if($diff == 0){
                                                                            $diff = 1;
                                                                        } 
                                                                    }
                                                                }
                                                                
                                                                if($r->titip == '1') {
                                                                    $vtotRuangBlmClaim += $r->tarif_jatah_bpjs * $diff;
                                                                } else {
                                                                    $vtotRuangBlmClaim += $r->tarif_bpjs * $diff;
                                                                }
                                                            }
                                                            $vtotAkomodasiBlmClaim += $vtotRuangBlmClaim;
                                                        }
                                                        
                                                        echo number_format($rilliri + $rillNoregasal + $vtotAkomodasiBlmClaim);
                                                        $vtotRillBlmClaim += $rilliri + $rillNoregasal + $vtotAkomodasiBlmClaim;
                                                    } else {
                                                        $rillirj = isset($this->rimlaporan->get_rill_rs_blm_claim_rj($date, $object)->row()->tarif)?$this->rimlaporan->get_rill_rs_blm_claim_rj($date, $object)->row()->tarif:null;
                                                        echo number_format($rillirj);
                                                        $vtotRillBlmClaim += $rillirj;
                                                    }
                                                ?></td> <!-- rill rs -->
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="font-weight:bold; font-size: 18px;">Total</td>
                                            <tr>
                                                <td style="font-weight:bold; font-size: 18px;">Vol Kasus/Kunjungan</td>
                                                <td><?php echo $countSep + $countClaim;?></td> <!-- rill rs -->
                                                <td><?php echo $countClaim;?></td>
                                                <td><?php echo $countClaim;?></td>
                                                <td><?php echo $countClaim;?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight:bold; font-size: 18px;">Rupiah</td>
                                                <td><?php echo number_format($rillRSUmbal + $vtotRillBlmClaim + $vtotRuang);?></td> <!-- rill rs -->
                                                <td><?php echo number_format($rillRSUmbal);?></td>
                                                <td><?php echo number_format($vtotDiajukan);?></td>
                                                <td><?php echo number_format($vtotDisetujui);?></td>
                                            </tr>
                                        </tr>
                                    </tbody>
                                </table>
                        </div><br>
                    </div>	
                    <a href="<?= base_url('iri/riclaporan/excel_lap_realisasi_potensi_bpjs/'.$object.'/'.$date); ?>" class="btn btn-success" target="_blank">Excel</a>			
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
    }?>