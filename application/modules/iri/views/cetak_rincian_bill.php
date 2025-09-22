<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 12px;
            /* position: relative; */
            /* text-align: center; */
        }
       
        /* .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:12px;
            } */
        /* .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            } */
						
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                                </font>
                                <font style="font-size:8pt">
                                    <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                    <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                                </font>    
                                <br>
                                <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsomh.co.id</label>
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
			RINCIAN BILL PASIEN
            </p>
					<table border="0" width="100%">
					
						<tr>
							<td width="15%"><b>No. Registrasi</b></td>
							<td width="3%">:</td>
							<td width="32%"><?= isset($data_pasien->no_ipd)?$data_pasien->no_ipd:'' ?></td>
							<td width="10%"><b>Nama Pasien</b></td>
							<td width="3%">:</td>
							<td width="37%"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
							<td><b>Tanggal Lahir</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->tgl_lahir)? date('d-m-Y',strtotime($data_pasien->tgl_lahir)):''; ?></td>
						</tr>
                        <tr>
							<td><b>Kelas</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->klsiri)?$data_pasien->klsiri:'' ?></td>
							<td><b>Kelamin</b></td>
							<td> : </td>
							<td><?php if($data_pasien->sex == 'L') {
                                echo 'Laki Laki';
                            } else {
                                echo 'Perempuan';
                            } ?></td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td>: </td>
							<td><?= isset($data_pasien->carabayar)?$data_pasien->carabayar:'' ?></td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td><?= isset($tahun)?$tahun:'' ?></td>
							
						</tr>
						<tr>
						    <td><b>Asal Pasien</b></td>
							<td> : </td>
							<td><?= $data_pasien->ruang ?></td>
                            <td><b>Dokter Pengirim</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?></td>
						</tr>
					</table>
					<br>

					<table border="1" id="data">
                        <thead>
                            <tr>
                                <th>History</th>
                                <th>Nama Tindakan</th>
                                <th>Volume</th>
                                <th>Tarif</th>
                                <th>Pelaksana</th>
                                <th>Disc</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            $total_lab = 0;
                            $total_em = 0;
                            $total_ok = 0;
                            $total_rad = 0;
                            $total_gizi = 0;
                            $total_igd = 0;
                            $total_mr = 0;
                            $total_irj = 0;
                            $total_rehab = 0;
                            $total_resep = 0;
                            $total_ruang_intensif = 0;
                            $total_akom = 0;
                            $total_iri = 0;
                            // $total_intensif = 0;
                            // $total_ruang = 0;
                            // $tarif_intensif = 0;
                            // $tarif_ruang = 0;
                            if($lab) {
                                foreach($lab as $rlab) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Laboratorium';?></td>
                                        <td><?php echo $rlab->jenis_tindakan;?></td>
                                        <td><?php echo $rlab->qtx;?></td>
                                        <td><?php echo number_format($rlab->biaya_lab); ?></td>
                                        <td><?php echo $rlab->nm_dokter;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rlab->total_rekap);?></td>
                                    </tr>
                            <?php $total_lab += $rlab->total_rekap; }
                            } ?>
                            <?php 
                            if($ok) {
                                foreach($ok as $rok) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Bedah Sentral';?></td>
                                        <td><?php echo $rok->jenis_tindakan;?></td>
                                        <td><?php echo $rok->qtx;?></td>
                                        <td><?php echo number_format($rok->biaya_ok); ?></td>
                                        <td><?php echo $rok->nm_dokter;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rok->total_rekap);?></td>
                                    </tr>
                            <?php $total_ok += $rok->total_rekap; }
                            } ?>
                            <?php
                            if($rad) {
                                foreach($rad as $rrad) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Radiologi';?></td>
                                        <td><?php echo $rrad->jenis_tindakan;?></td>
                                        <td><?php echo $rrad->qtx;?></td>
                                        <td><?php echo number_format($rrad->biaya_rad); ?></td>
                                        <td><?php echo $rrad->nm_dokter;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rrad->total_rekap);?></td>
                                    </tr>
                            <?php $total_rad += $rrad->total_rekap; }
                            } ?>
                            <?php
                            if($em) {
                                foreach($em as $rem) { ?>
                                    <tr>
                                        <td><?php echo 'Ins UDT';?></td>
                                        <td><?php echo $rem->jenis_tindakan;?></td>
                                        <td><?php echo $rem->qtx;?></td>
                                        <td><?php echo number_format($rem->biaya_em); ?></td>
                                        <td><?php echo $rem->nm_dokter;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rem->total_rekap);?></td>
                                    </tr>
                            <?php $total_em += $rem->total_rekap; }
                            } ?>
                            <?php 
                            if($gizi) {
                                foreach($gizi as $rgizi) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Gizi';?></td>
                                        <td><?php echo $rgizi->nmtindakan;?></td>
                                        <td><?php echo $rgizi->qtx;?></td>
                                        <td><?php echo number_format($rgizi->biaya); ?></td>
                                        <td><?php echo $rgizi->pelaksana;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rgizi->total_rekap);?></td>
                                    </tr>
                            <?php $total_gizi += $rgizi->total_rekap; }
                            } ?>
                            <?php
                            if($tind_igd) {
                                foreach($tind_igd as $rigd) { ?>
                                    <tr>
                                        <td><?php echo 'IGD';?></td>
                                        <td><?php echo $rigd->nmtindakan;?></td>
                                        <td><?php echo $rigd->qtx;?></td>
                                        <td><?php echo number_format($rigd->biaya_tindakan); ?></td>
                                        <td><?php echo $rigd->pelaksana;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rigd->total_rekap);?></td>
                                    </tr>
                            <?php $total_igd += $rigd->total_rekap; }
                            } ?>
                            <?php
                            if($ins_mr) {
                                foreach($ins_mr as $rmr) { ?>
                                    <tr>
                                        <td><?php echo 'Ins MR';?></td>
                                        <td><?php echo $rmr->nmtindakan;?></td>
                                        <td><?php echo $rmr->qtx;?></td>
                                        <td><?php echo number_format($rmr->biaya_tindakan); ?></td>
                                        <td><?php echo $rmr->pelaksana;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rmr->total_rekap);?></td>
                                    </tr>
                            <?php $total_mr += $rmr->total_rekap; }
                            } ?>
                            <?php 
                            if($irj) {
                                foreach($irj as $rj) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Rawat Jalan';?></td>
                                        <td><?php echo $rj->nmtindakan;?></td>
                                        <td><?php echo $rj->qtx;?></td>
                                        <td><?php echo number_format($rj->biaya_tindakan); ?></td>
                                        <td><?php echo $rj->pelaksana;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rj->total_rekap);?></td>
                                    </tr>
                            <?php $total_irj += $rj->total_rekap; }
                            } ?>
                            <?php 
                            if($rehab_medik) {
                                foreach($rehab_medik as $rehab) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Rehab';?></td>
                                        <td><?php echo $rehab->nmtindakan;?></td>
                                        <td><?php echo $rehab->qtx;?></td>
                                        <td><?php echo number_format($rehab->biaya); ?></td>
                                        <td><?php echo $rehab->pelaksana;?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($rehab->total_rekap);?></td>
                                    </tr>
                            <?php $total_rehab += $rehab->total_rekap; }
                            } ?>
                            <?php
                            if($resep_pasien) {
                                foreach($resep_pasien as $obat) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Farmasi';?></td>
                                        <td><?php echo $obat->nama_obat;?></td>
                                        <td><?php echo $obat->qtx;?></td>
                                        <td><?php echo number_format($obat->biaya_obat); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><?php echo number_format($obat->total_rekap);?></td>
                                    </tr>
                            <?php $total_resep += $obat->total_rekap; }
                             } ?>
                            <?php
                            if($ruang_intensif) {
                                foreach($ruang_intensif as $r) {
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
										if($data_pasien->tgl_keluar_resume != NULL){
											$start = new DateTime($r['tglmasukrg']);//start
											$end = new DateTime($data_pasien->tgl_keluar_resume);//end

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
                                    if($data_pasien->carabayar == 'UMUM') {
                                        if($data_pasien->titip == NULL) {
                                            $total_intensif = $r['total_tarif'] * $diff;
                                            $tarif_intensif = $r['total_tarif'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_intensif = $r['tarif_jatah'] * $diff;
                                            $tarif_intensif = $r['tarif_jatah'];
                                        }
                                    } else if($data_pasien->carabayar == 'BPJS') {
                                        if($data_pasien->titip == NULL) {
                                            $total_intensif = $r['tarif_bpjs'] * $diff;
                                            $tarif_intensif = $r['tarif_bpjs'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_intensif = $r['tarif_jatah_bpjs'] * $diff;
                                            $tarif_intensif = $r['tarif_jatah_bpjs'];
                                        }
                                    } else {
                                        if($data_pasien->titip == NULL) {
                                            $total_intensif = $r['tarif_iks'] * $diff;
                                            $tarif_intensif = $r['tarif_iks'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_intensif = $r['tarif_jatah_iks'] * $diff;
                                            $tarif_intensif = $r['tarif_jatah_iks'];
                                        }
                                    }
                                        
                                    $total_ruang_intensif += $total_intensif; ?>

                                    <tr>
                                        <td><?php echo 'Ins Rawat Intensive';?></td>
                                        <td><?php echo 'Akomodasi';?></td>
                                        <td><?php echo $diff;?></td>
                                        <td><?php echo number_format($tarif_intensif); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><?php echo number_format($total_intensif);?></td>
                                    </tr>
                            <?php }
                            }
                            ?>
                            <?php 
                            if($ruang) {
                                foreach($ruang as $row) {
                                    $diff = 1;
									if($row['tglkeluarrg'] != null){
										$start = new DateTime($row['tglmasukrg']);//start
										$end = new DateTime($row['tglkeluarrg']);//end

										$diff = $end->diff($start)->format("%a");
										if($diff == 0){
											$diff = 1;
										}
										// echo $diff." Hari"; 
									}else{
										if($data_pasien->tgl_keluar_resume != NULL){
											$start = new DateTime($row['tglmasukrg']);//start
											$end = new DateTime($data_pasien->tgl_keluar_resume);//end

											$diff = $end->diff($start)->format("%a");
											if($diff == 0){
												$diff = 1;
											}
										    // echo $diff." Hari"; 
										}else{
										    $start = new DateTime($row['tglmasukrg']);//start
											$end = new DateTime(date("Y-m-d"));//end

											$diff = $end->diff($start)->format("%a");
											if($diff == 0){
												$diff = 1;
											}
											// echo $diff." Hari"; 
										}
									}
                                    if($data_pasien->carabayar == 'UMUM') {
                                        if($data_pasien->titip == NULL) {
                                            $total_ruang = $row['total_tarif'] * $diff;
                                            $tarif_ruang = $row['total_tarif'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_ruang = $row['tarif_jatah'] * $diff;
                                            $tarif_ruang = $row['tarif_jatah'];
                                        }
                                    } else if($data_pasien->carabayar == 'BPJS') {
                                        if($data_pasien->titip == NULL) {
                                            $total_ruang = $row['tarif_bpjs'] * $diff;
                                            $tarif_ruang = $row['tarif_bpjs'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_ruang = $row['tarif_jatah_bpjs'] * $diff;
                                            $tarif_ruang = $row['tarif_jatah_bpjs'];
                                        }
                                    } else {
                                        if($data_pasien->titip == NULL) {
                                            $total_ruang = $row['tarif_iks'] * $diff;
                                            $tarif_ruang = $row['tarif_iks'];
                                        } else if($data_pasien->titip == '1'){
                                            $total_ruang = $row['tarif_jatah_iks'] * $diff;
                                            $tarif_ruang = $row['tarif_jatah_iks'];
                                        }
                                    }
                                    $total_akom += $total_ruang; ?>
                                    
                                    <tr>
                                        <td><?php echo 'Ins Rawat Inap';?></td>
                                        <td><?php echo 'Akomodasi';?></td>
                                        <td><?php echo $diff;?></td>
                                        <td><?php echo number_format($tarif_ruang); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><?php echo number_format($total_ruang);?></td>
                                    </tr>
                                <?php } 
                            }
                            ?>
                            <?php
                            if($tind_iri) {
                                foreach($tind_iri as $ri) { ?>
                                    <tr>
                                        <td><?php echo 'Ins Rawat Inap';?></td>
                                        <td><?php echo $ri->nmtindakan;?></td>
                                        <td><?php echo $ri->qtx;?></td>
                                        <td><?php echo number_format($ri->tumuminap); ?></td>
                                        <td><?php echo $ri->pelaksana; ?></td>
                                        <td>-</td>
                                        <td><?php echo number_format($ri->total_rekap);?></td>
                                    </tr>
                            <?php $total_iri += $ri->total_rekap; }
                            }
                            ?>
                            <tr>
                                <td colspan = "6"><b>Total</b></td>
                                <td><?php echo number_format($total_lab + $total_ok + $total_rad + $total_gizi + $total_igd + $total_mr + $total_irj + $total_rehab + $total_resep + $total_ruang_intensif + $total_akom + $total_iri + $total_em);?></td>
                            </tr>
                        </tbody>
                    </table>
			 		<br>
			 		<br>
			 		<table style="width:100%;">
			 			<tr>
			 				<td width="75%" ></td>
			 				<td width="25%">
			 					<p><?= $kota_header.','.' '.$tgl?></p>
			 					<p>Dokter DPJP</p><br><br>
                                 <img src="<?php echo $ttd;?>" alt="" style="width:100px;height; 100px;">
                                 <p><?= $data_pasien->dokter; ?></p>
			 					</p>
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>