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
                <?php echo form_open('iri/riclaporan/lap_realisasi_pendapatan_pasien_pulang');?>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_months2" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="jaminan" id="jaminan" class="form-control">
                                    <option value="">-- piih jaminan --</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="KERJASAMA">Kerjasama </option>
                                    <option value="UMUM">UMUM </option>
                                    <option value="selisih_tarif">Selisih Tarif</option>
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
					<h4 align="center">Laporan Realisasi Pendapatan Pasien Pulang</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Penjamin</th>
                                            <th>No Register</th>
                                            <th>Tanggal Pulang</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <?php if($jaminan == 'BPJS' || $jaminan == 'selisih_tarif') { ?>
                                                <th>Inacbg</th>
                                                <th>No SEP</th>
                                            <?php } ?>
                                            <th>Ruang</th>
                                            <th>Kelas</th>
                                            <th>Ins Rawat Intensive</th>
                                            <th>IGD</th>
                                            <th>Ins Bedah Sentral</th>
                                            <th>Ins Farmasi</th>
                                            <th>Ins Gizi</th>
                                            <th>Ins Laboratorium</th>
                                            <th>Ins MR</th>
                                            <th>Ins Radiologi</th>
                                            <th>Elektromedik</th>
                                            <th>Ins Rawat Inap</th>
                                            <th>Ins Rawat Jalan</th>
                                            <th>Ins Rehab</th>
                                            <th>Total</th>
                                            <th>Tarif RIll RS</th>
                                        </tr>                                       
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        $grand_total_intensif = 0;
                                        $grand_total_igd = 0;
                                        $grand_total_ok = 0;
                                        $grand_total_obat = 0;
                                        $grand_total_gizi = 0;
                                        $grand_total_lab = 0;
                                        $grand_total_mr = 0;
                                        $grand_total_rad = 0;
                                        $grand_total_em = 0;
                                        $grand_total_ri = 0;
                                        $grand_total_rj = 0;
                                        $grand_total_rehab = 0;
                                        $grand_total_all = 0;
                                        
                                        if($jaminan == 'BPJS' || $jaminan == 'selisih_tarif') {
                                            foreach($data_pendapatan as $row) { 
                                                $intensif = $this->rimlaporan->get_ruang_intensif($row->no_ipd);
                                                $ruang = $this->rimlaporan->get_ruang_non_intensif($row->no_ipd);
                                                $lab_rill = isset($this->rimlaporan->get_tarif_rill_lab($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_lab($row->no_ipd)->row()->tarif:null;
                                                $rad_rill = isset($this->rimlaporan->get_tarif_rill_rad($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_rad($row->no_ipd)->row()->tarif:null;
                                                $em_rill = isset($this->rimlaporan->get_tarif_rill_em($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_em($row->no_ipd)->row()->tarif:null;
                                                $ok_rill = isset($this->rimlaporan->get_tarif_rill_ok($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_ok($row->no_ipd)->row()->tarif:null;

                                                if(substr($row->no_ipd,0,2) == 'RJ') {
                                                    $alltind_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_rj($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_all_tindakan_rj($row->no_ipd)->row()->tarif:null;
                                                } else {
                                                    $alltind_rj_rill = isset($this->rimlaporan->get_vtot_noregasal_blm_claim($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_vtot_noregasal_blm_claim($row->no_ipd)->row()->tarif:null;
                                                    $alltind_ri_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_ri($row->no_ipd)->row()->tarif)?$this->rimlaporan->get_tarif_rill_all_tindakan_ri($row->no_ipd)->row()->tarif:null;
                                                }?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row->carabayar;?></td>
                                                    <td><?php echo $row->no_ipd;?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row->tgl)); ?></td>
                                                    <td><?php echo $row->no_cm; ?></td>
                                                    <td><?php echo $row->nama; ?></td>
                                                    <td><?php echo $row->kd_inacbg; ?></td>
                                                    <td><?php echo $row->no_sep; ?></td>
                                                    <td><?php echo $row->ruang; ?></td>
                                                    <td><?php echo $row->klsiri; ?></td>
                                                    <td><?php 
                                                        $total_intensif = 0;
                                                        $int_rill = 0;
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
                                                            
                                                            //if($row->carabayar == 'UMUM') {
                                                                // $total_intensif += $ins['total_tarif'] * $diff;
                                                                // if($ins['titip'] == '1') {
                                                                //     $ruang_rill += $ins['tarif_jatah'] * $diff;
                                                                // } else {
                                                                //     $ruang_rill += $ins['total_tarif'] * $diff;
                                                                // }
                                                            //} else if($row->carabayar == 'BPJS') {
                                                                $total_intensif += $ins['tarif_bpjs'] * $diff;
                                                                if($ins['titip'] == '1') {
                                                                    $ruang_rill += $ins['tarif_jatah_bpjs'] * $diff;
                                                                } else {
                                                                    $ruang_rill += $ins['tarif_bpjs'] * $diff;
                                                                }
                                                           // } else {
                                                                // $total_intensif += $ins['tarif_iks'] * $diff;
                                                                // if($ins['titip'] == '1') {
                                                                //     $ruang_rill += $ins['tarif_jatah_iks'] * $diff;
                                                                // } else {
                                                                //     $ruang_rill += $ins['tarif_iks'] * $diff;
                                                                // }
                                                           // }
                                                           
                                                            $grand_total_intensif += $total_intensif;
                                                        }
                                                        echo number_format($total_intensif);?></td>
                                                    <td><?php echo number_format($row->igd); 
                                                    $grand_total_igd += $row->igd;?></td>
                                                    <td><?php echo number_format($row->ok_iri + $row->ok_igd); 
                                                    $grand_total_ok += $row->ok_iri + $row->ok_igd;?></td>
                                                    <td><?php echo number_format($row->farmasi_iri + $row->farmasi_irj); 
                                                    $grand_total_obat += $row->farmasi_iri + $row->farmasi_irj;?></td>
                                                    <td><?php echo number_format($row->gizi_iri + $row->gizi_igd); 
                                                    $grand_total_gizi += $row->gizi_iri + $row->gizi_igd;?></td>
                                                    <td><?php echo number_format($row->lab_iri + $row->lab_igd); 
                                                    $grand_total_lab += $row->lab_iri + $row->lab_igd;?></td>
                                                    <td><?php echo number_format($row->mr); 
                                                    $grand_total_mr += $row->mr;?></td>
                                                    <td><?php echo number_format($row->rad_iri + $row->rad_igd); 
                                                    $grand_total_rad += $row->rad_iri + $row->rad_igd;?></td>
                                                    <td><?php echo number_format($row->em_iri + $row->em_igd); 
                                                    $grand_total_em += $row->em_iri + $row->em_igd;?></td>
                                                    <td><?php $total_ruang = 0; $ruang_rill = 0;
                                                        foreach($ruang as $v) {
                                                            //echo $v['idrg'].'<br>';
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
                                                            
                                                            //if($row->carabayar == 'UMUM') {
                                                                // $total_ruang += ($v['total_tarif'] * $diff);
                                                                // if($v['titip'] == '1') {
                                                                //     $ruang_rill += $v['tarif_jatah'] * $diff;
                                                                // } else {
                                                                //     $ruang_rill += $v['total_tarif'] * $diff;
                                                                // }
                                                                // echo number_format($v['total_tarif']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
                                                            //} else if($row->carabayar == 'BPJS') {
                                                                $total_ruang += ($v['tarif_bpjs'] * $diff);
                                                                if($v['titip'] == '1') {
                                                                    $ruang_rill += $v['tarif_jatah_bpjs'] * $diff;
                                                                } else {
                                                                    $ruang_rill += $v['tarif_bpjs'] * $diff;
                                                                }
                                                                echo number_format($v['tarif_bpjs']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
                                                            //} else {
                                                                // $total_ruang += ($v['tarif_iks'] * $diff);
                                                                // if($v['titip'] == '1') {
                                                                //     $ruang_rill += $v['tarif_jatah_iks'] * $diff;
                                                                // } else {
                                                                //     $ruang_rill += $v['tarif_iks'] * $diff;
                                                                // }
                                                                // echo number_format($v['tarif_iks']*$diff).'('.$v['kelas'].')('.$diff.' Hari)<br>';
                                                            //}

                                                            $grand_total_ri += $total_ruang + $row->iri;
                                                        }
                                                        // echo number_format($row->ruang).'<br>';
                                                        echo number_format($row->iri);
                                                        // $grand_total_ri += $row->ruang + $row->iri; ?></td>
                                                    <td><?php echo number_format($row->irj); 
                                                    $grand_total_rj += $row->irj;?></td>
                                                    <td><?php echo number_format($row->rehab_iri + $row->rehab_igd); 
                                                    $grand_total_rehab += $row->rehab_iri + $row->rehab_igd;?></td>
                                                    <td><?php echo number_format($row->farmasi_iri + $row->farmasi_irj + $row->igd + $row->ok_iri + $row->ok_igd + $row->gizi_iri + $row->gizi_igd + $row->lab_iri + $row->lab_igd + $row->mr + $row->rad_iri + $row->rad_igd + $row->irj + $row->rehab_iri + $row->rehab_igd + $total_intensif + $row->iri + $total_ruang); 
                                                    //$grand_total_all += $row['igd'] + $row['ok_iri'] + $row['ok_igd'] + $row['resep_iri'] + $row['resep_igd'] + $row['gizi_iri'] + $row['gizi_igd'] + $row['lab_iri'] + $row['lab_igd'] + $row['mr'] + $row['rad_iri'] + $row['rad_igd'] + $row['irj'] + $row['rehab_iri'] + $row['rehab_igd'] + $total_intensif + $row['iri'] + $total_ruang;?></td>
                                                    <td><?php
                                                        if(substr($row->no_ipd,0,2) == 'RJ') {
                                                            echo number_format($lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rill + $row->farmasi_iri + $row->farmasi_irj);
                                                        } else {
                                                            echo number_format($lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rj_rill + $alltind_ri_rill + $int_rill + $ruang_rill + $row->farmasi_iri + $row->farmasi_irj);
                                                        }
                                                    ?></td>
                                                </tr>
                                        <?php } 
                                        } else {
                                            foreach($data_pendapatan as $r) { 
                                                $intensif = $this->rimlaporan->get_ruang_intensif($r->no_register);
                                                $ruang = $this->rimlaporan->get_ruang_non_intensif($r->no_register);
                                                $lab_rill = isset($this->rimlaporan->get_tarif_rill_lab($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_lab($r->no_register)->row()->tarif:null;
                                                $rad_rill = isset($this->rimlaporan->get_tarif_rill_rad($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_rad($r->no_register)->row()->tarif:null;
                                                $em_rill = isset($this->rimlaporan->get_tarif_rill_em($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_em($r->no_register)->row()->tarif:null;
                                                $ok_rill = isset($this->rimlaporan->get_tarif_rill_ok($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_ok($r->no_register)->row()->tarif:null;

                                                if(substr($r->no_register,0,2) == 'RJ') {
                                                    $alltind_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_rj($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_all_tindakan_rj($r->no_register)->row()->tarif:null;
                                                } else {
                                                    $alltind_rj_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_noregasal($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_all_tindakan_noregasal($r->no_register)->row()->tarif:null;
                                                    $alltind_ri_rill = isset($this->rimlaporan->get_tarif_rill_all_tindakan_ri($r->no_register)->row()->tarif)?$this->rimlaporan->get_tarif_rill_all_tindakan_ri($r->no_register)->row()->tarif:null;
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $r->cara_bayar;?></td>
                                                    <td><?php echo $r->no_register;?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($r->tgl_kunjungan)); ?></td>
                                                    <td><?php echo $r->no_medrec; ?></td>
                                                    <td><?php echo $r->nama; ?></td>
                                                    <td><?php echo $r->nm_poli; ?></td>
                                                    <td><?php echo $r->kelas_pasien; ?></td>
                                                    <td><?php
                                                        $total_intensif = 0;
                                                        $int_rill = 0;
                                                        foreach($intensif as $int) {
                                                            $diff = 1;
                                                            if($int['tglkeluarrg'] != null){
                                                                $start = new DateTime($int['tglmasukrg']);//start
                                                                $end = new DateTime($int['tglkeluarrg']);//end
                
                                                                $diff = $end->diff($start)->format("%a");
                                                                if($diff == 0){
                                                                    $diff = 1;
                                                                }
                                                            // echo $diff." Hari"; 
                                                            }else{
                                                                if($int['tgl_keluar_resume'] != NULL){
                                                                $start = new DateTime($int['tglmasukrg']);//start
                                                                    $end = new DateTime($int['tgl_keluar_resume']);//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    // echo $diff." Hari"; 
                                                                }else{
                                                                    $start = new DateTime($int['tglmasukrg']);//start
                                                                    $end = new DateTime(date("Y-m-d"));//end
                
                                                                    $diff = $end->diff($start)->format("%a");
                                                                    if($diff == 0){
                                                                        $diff = 1;
                                                                    }
                                                                    
                                                                    // echo $diff." Hari"; 
                                                                }
                                                            }
                                                            
                                                            if($r->cara_bayar == 'UMUM') {
                                                                if($int['titip'] == '1') {
                                                                    $int_rill += $int['tarif_jatah'] * $diff;
                                                                } else {
                                                                    $int_rill += $int['total_tarif'] * $diff;
                                                                }
                                                                $total_intensif += $int['total_tarif'] * $diff;
                                                            } else if($r->cara_bayar == 'BPJS') {
                                                                if($int['titip'] == '1') {
                                                                    $int_rill += $int['tarif_jatah_bpjs'] * $diff;
                                                                } else {
                                                                    $int_rill += $int['tarif_bpjs'] * $diff;
                                                                }
                                                                $total_intensif += $int['tarif_bpjs'] * $diff;
                                                            } else {
                                                                if($int['titip'] == '1') {
                                                                    $int_rill += $int['tarif_jatah_iks'] * $diff;
                                                                } else {
                                                                    $int_rill += $int['tarif_iks'] * $diff;
                                                                }
                                                                $total_intensif += $int['tarif_iks'] * $diff;
                                                            }
                                                           
                                                            //grand_total_intensif += $total_intensif;
                                                        }
                                                        $grand_total_intensif += $r->intensif;
                                                        echo number_format($r->intensif);?></td>
                                                    <td><?php 
                                                        if(substr($r->no_register,0,2) == 'RJ') {
                                                            $igd_gizi_rehab = $r->gizi_igd + $r->rehab_igd;
                                                            if($igd_gizi_rehab > $r->igd) {
                                                                $igdReal = 0;
                                                            } else {
                                                                $igdReal = $r->igd - $igd_gizi_rehab;
                                                            }
                                                            echo number_format($igdReal);
                                                            $grand_total_igd += $igdReal;
                                                        } else {
                                                            $igdReal = $r->igd;
                                                            echo number_format($r->igd); 
                                                            $grand_total_igd += $r->igd;
                                                        }
                                                    ?></td>
                                                    <td><?php echo number_format($r->ok); 
                                                    $grand_total_ok += $r->ok;?></td>
                                                    <td><?php echo number_format($r->farmasi); 
                                                    $grand_total_obat += $r->farmasi;?></td>
                                                    <td><?php echo number_format($r->gizi_igd + $r->gizi_irj); 
                                                    $grand_total_gizi += $r->gizi_igd + $r->gizi_irj;?></td>
                                                    <td><?php echo number_format($r->lab); 
                                                    $grand_total_lab += $r->lab;?></td>
                                                    <td><?php echo number_format($r->mr); 
                                                    $grand_total_mr += $r->mr;?></td>
                                                    <td><?php echo number_format($r->rad); 
                                                    $grand_total_rad += $r->rad;?></td>
                                                    <td><?php echo number_format($r->em); 
                                                    $grand_total_em += $r->em;?></td>
                                                    <td><?php $total_ruang = 0; $ruang_rill = 0;
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
                                                            
                                                            if($r->cara_bayar == 'UMUM') {
                                                                $total_ruang += ($val['total_tarif'] * $diff);
                                                                if($val['titip'] == '1') {
                                                                    $ruang_rill += $val['tarif_jatah'] * $diff;
                                                                } else {
                                                                    $ruang_rill += $val['total_tarif'] * $diff;
                                                                }
                                                               // echo number_format($val['total_tarif']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
                                                            } else if($r->cara_bayar == 'BPJS') {
                                                                $total_ruang += ($val['tarif_bpjs'] * $diff);
                                                                if($val['titip'] == '1') {
                                                                    $ruang_rill += $val['tarif_jatah_bpjs'] * $diff;
                                                                } else {
                                                                    $ruang_rill += $val['tarif_bpjs'] * $diff;
                                                                }
                                                                //echo number_format($val['tarif_bpjs']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
                                                            } else {
                                                                if($val['titip'] == '1') {
                                                                    $ruang_rill += $val['tarif_jatah_iks'] * $diff;
                                                                } else {
                                                                    $ruang_rill += $val['tarif_iks'] * $diff;
                                                                }
                                                                $total_ruang += ($val['tarif_iks'] * $diff);
                                                               // echo number_format($val['tarif_iks']*$diff).'('.$val['kelas'].')('.$diff.' Hari)<br>';
                                                            }

                                                            //$grand_total_ri += $total_ruang + $r->iri;
                                                            
                                                        }
                                                        $grand_total_ri += $r->ruang + $r->iri;
                                                        echo number_format($r->ruang).'</br>';
                                                        echo number_format($r->iri); ?></td>
                                                    <td><?php 
                                                        if(substr($r->no_register,0,2) == 'RJ') {
                                                            $irj_gizi_rehab = $r->gizi_irj + $r->rehab_irj;
                                                            if($irj_gizi_rehab > $r->irj) {
                                                                $irjReal = 0;
                                                            } else {
                                                                $irjReal = $r->irj - $irj_gizi_rehab;
                                                            }
                                                            echo number_format($irjReal);
                                                            $grand_total_rj += $irjReal;
                                                        } else {
                                                            $irjReal = $r->irj;
                                                            echo number_format($r->irj); 
                                                            $grand_total_rj += $r->irj;
                                                        } 
                                                    ?></td>
                                                    <td><?php echo number_format($r->rehab_igd + $r->rehab_irj); 
                                                    $grand_total_rehab += $r->rehab_igd + $r->rehab_irj;?></td>
                                                    <td><?php echo number_format($r->farmasi + $igdReal + $r->ok + $r->gizi_igd + $r->gizi_irj + $r->lab + $r->mr + $r->rad + $irjReal + $r->rehab_igd + $r->rehab_irj + $r->intensif + $r->iri + $r->ruang); 
                                                    //$grand_total_all += $r['igd'] + $r['ok_iri'] + $r['ok_igd'] + $r['resep_iri'] + $row['resep_igd'] + $row['gizi_iri'] + $row['gizi_igd'] + $row['lab_iri'] + $row['lab_igd'] + $row['mr'] + $row['rad_iri'] + $row['rad_igd'] + $row['irj'] + $row['rehab_iri'] + $row['rehab_igd'] + $total_intensif + $row['iri'] + $total_ruang;?></td>
                                                    <td><?php
                                                        if(substr($r->no_register,0,2) == 'RJ') {
                                                            // echo number_format($lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rill);
                                                            echo number_format($r->farmasi + $igdReal + $r->em + $r->ok + $r->gizi_igd + $r->gizi_irj + $r->lab + $r->mr + $r->rad + $irjReal + $r->rehab_igd + $r->rehab_irj + $r->intensif + $r->iri + $r->ruang); 
                                                        } else {
                                                            // echo number_format($lab_rill + $rad_rill + $ok_rill + $em_rill + $alltind_rj_rill + $alltind_ri_rill + $int_rill + $ruang_rill);
                                                            echo number_format($r->farmasi + $igdReal + $r->em + $r->ok + $r->gizi_igd + $r->gizi_irj + $r->lab + $r->mr + $r->rad + $irjReal + $r->rehab_igd + $r->rehab_irj + $r->intensif + $r->iri + $r->ruang); 
                                                        }
                                                    ?></td>
                                                </tr>
                                        <?php } 
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </div><br>
                        <h5><b>Total Ins Rawat Intensive : </b><?php echo number_format($grand_total_intensif); ?></h5><br>
                        <h5><b>Total IGD : </b><?php echo number_format($grand_total_igd); ?></h5><br>
                        <h5><b>Total Ins Bedah Sentral : </b><?php echo number_format($grand_total_ok); ?></h5><br>
                        <h5><b>Total Ins Farmasi : </b><?php echo number_format($grand_total_obat); ?></h5><br>
                        <h5><b>Total Ins Gizi : </b><?php echo number_format($grand_total_gizi); ?></h5><br>
                        <h5><b>Total Ins Laboratorium : </b><?php echo number_format($grand_total_lab); ?></h5><br>
                        <h5><b>Total Ins MR : </b><?php echo number_format($grand_total_mr); ?></h5><br>
                        <h5><b>Total Ins Radiologi : </b><?php echo number_format($grand_total_rad); ?></h5><br>
                        <h5><b>Total Elektromedik : </b><?php echo number_format($grand_total_em); ?></h5><br>
                        <h5><b>Total Ins Rawat Inap : </b><?php echo number_format($grand_total_ri); ?></h5><br>
                        <h5><b>Total Ins Rawat Jalan : </b><?php echo number_format($grand_total_rj); ?></h5><br>
                        <h5><b>Total Ins Rehab : </b><?php echo number_format($grand_total_rehab); ?></h5>
                        <h5><b>Total : </b><?php echo number_format($grand_total_obat + $grand_total_intensif + $grand_total_igd + $grand_total_ok + $grand_total_lab + $grand_total_mr + $grand_total_rad + $grand_total_em + $grand_total_ri + $grand_total_rj + $grand_total_gizi + $grand_total_rehab); ?></h5>
                    </div>	
                    <a href="<?= base_url('iri/riclaporan/excel_lap_pendapatan_pasien_pulang'.'/'.$date1.'/'.$date2.'/'.$jaminan); ?>" class="btn btn-danger" target="_blank">Excel</a>			
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