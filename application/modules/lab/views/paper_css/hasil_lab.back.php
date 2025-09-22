<?php 
//var_dump($hasil_lab);die();
?>
<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            /* position: relative; */
            text-align: center;
        }
       
        .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:11px;
            }
        .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            }
						
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
            <p align="center"><b>
			HASIL PEMERIKSAAN LABORATORIUM
		</b></p><br/>
        <?php if(substr($no_register, 0,2)=="PL"){ ?>
            		<table border="0">
						<tr>
							<td width="10%">No. Lab</td>
							<td width="2%"> : </td>
							<td width="40%"><?= $no_lab?></td>
							<td width="10%">No Reg</td>
							<td width="2%"> : </td>
							<td width="16%"><?= $data_pasien->no_register ?></td>
							<td width="5%">No MR</td>
							<td width="2%"> : </td>
							<td width="13%">PL-<?= $data_pasien->no_cm ?></td>
						</tr>
						<tr> 
							<td>Dokter</td>
							<td> : </td>
							<td><?= $data_pasien->dokter ?></td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan="4"><b><?= $data_pasien->nama ?></b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Lab</td>
							<td> : </td>
							<td><?=  $data_pasien->nm_dokter ?></td>
							<td width="10%">Kelamin</td>
							<td width="2%"> : </td>
							<td width="16%"><?php if($data_pasien->jk == 'P'){
								echo 'Perempuan';
							}else{
								echo 'Laki - laki';
							} ?></td>
							<td width="5%">Usia</td>
							<td width="2%"> : </td>
							<td width="13%"><?php 
								$tgl_lahir = date('Y',strtotime($data_pasien->tgl_lahir));
								$sekarang = date('Y');
								$tahun = (int)$sekarang - (int)$tgl_lahir;
								echo $tahun;
							?></td>
						</tr>
						<tr>
							<td width="10%">Tanggal</td>
							<td width="2%"> : </td>
							<td width="40%"><?= date("d F Y",strtotime($data_pasien->tgl_kunjungan)); ?></td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td><?= $data_pasien->alamat?></td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan="4" rowspan="2 ">-</td>
						</tr>
					</table>
        <?php } else { ?>
            <table  border="0" cellpadding="0" cellspacing="1" width="100%">
                        <tr>
							<td width="18%">No. Lab</td>
							<td width="2%">:</td>
							<td width="30%"><?= $no_lab ?></td>
							<td width="18%">No Reg</td>
							<td width="2%"> : </td>
							<td width="30%"><?= $data_pasien->no_register?></td>
						</tr>
						<tr>
							<td>No MR</td>
							<td> : </td>
							<td><?= $data_pasien->no_cm ?></td>
                            <td>Dokter</td>
							<td> : </td>
							<td><?= $nama_dokter ?></td>
						</tr>
						<tr>
							<td>Nama Pasien</td>
							<td> : </td>
							<td><b><?= $data_pasien->nama ?></b></td>
                            <td>Dr. PJ. Lab</td>
							<td> : </td>
							<td><?= $data_pasien->nm_dokter?></td>
						</tr>
						<tr>
							
							<td>Kelamin</td>
							<td> : </td>
							<td><?= $kelamin ?></td>
							<td>Usia</td>
							<td> : </td>
							<?php
								// $age = date_diff(date_create($usia), date_create('now'))->y;
								// $age1 = date_diff(date_create($usia), date_create('now'))->m;
									?>
							<td><?= $usia->y.' '.'Tahun'.' '.$usia->m.' '.'Bulan'?></td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td> : </td>
							<td><?= date("d F Y",strtotime($data_pasien->tgl_kunjungan))?></td>
							<td>Status</td>
							<td> : </td>
							<td><?= $cara_bayar ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>
								<?= $almt ?>
							</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td><?php if(substr($data_pasien->no_register,0,2) == 'RI') {
								echo $data_pasien->idrg;
							} else {
								echo $data_pasien->bed;
							} ?></td>
						</tr>
			</table>
        <?php } ?>
				<br>
					<table width="100%" border="1">
						<tr>
							<th style="font-size:11px;text-align:center"  width="30%"><p align="center"><b>Jenis Pemeriksaan</b></p></th>
							<th  style="font-size:11px;text-align:center"  width="30%"><p align="center"><b>Hasil</b></p></th>
							<th style="font-size:11px;text-align:center"  width="15%"><p align="center"><b>Satuan</b></p></th>
							<th style="font-size:11px;text-align:center"  width="25%"><p align="center"><b>Nilai Rujukan</b></p></th>
						</tr>
						<?php
						$ket = [];
						foreach ($data_kategori_lab as $rw) {
						
						$tindakan=strtoupper($rw->nama_jenis); ?>
						
							<tr>
								<th colspan="5"><p align="left" style="font-size:11px">
									<br/><b>Jenis Pemeriksaan : <i><?= $tindakan ?></i></b></p>
								</th>
							</tr>

						<?php 
						
						foreach($data_jenis_lab as $index=>$row){

							// masukin keterangan
							
							
							if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) {
								 ?>
							
									<tr>
										<th colspan="5"><p align="left" style="font-size:11px"><b>&nbsp;&nbsp;<?= $row->nmtindakan ?></b></p></th>
									</tr>

								<?php //$data_hasil_lab=$this->labmdaftar->get_data_hasil_lab($row->id_tindakan,$row->no_lab)->result();
								foreach($hasil_labor as $row1){
									// echo '<pre>';
									// var_dump($row1);
									// echo '</pre>';
									// die();
									foreach($row1 as $val):
									// 	echo '<pre>';
									// var_dump($val);
									// echo '</pre>';
									//die();
										if(!in_array($val->ket,$ket)){
											array_push($ket,$val->ket);
										}
										
										if($rw->kode_jenis == substr($val->id_tindakan,0,2)):
											// var_dump($row1[0]->kadar_normal);die();
											$kadar_normal = str_replace('<','&lt;',$val->kadar_normal);
											$kadar_normal = str_replace('>','&gt;',$kadar_normal); ?>
										<tr>
											<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $val->jenis_hasil ?></td>
											<td width="30%"><center><?= $val->hasil_lab ?></center></td>
											<td width="15%"><?= $val->satuan ?></td>
											<td width="25%"><?= $val->kadar_normal ?></td>
										</tr>


									<?php 	
									endif;
								endforeach;
							} 
							?>
							<tr>
                                <th colspan="5"><p align="left" style="font-size:11px"><b>&nbsp;&nbsp;Catatan : </b><?= isset($ket[$index])?$ket[$index]:'' ?></p></th>
                            </tr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					</table>

					
					<br/>
					<table style="width:100%;" style="padding-bottom:5px;">
						<tr>
							<td width="65%" ><img src="<?php echo $qr; ?>" alt=""></td>
							<td width="35%"  style="text-align: center;">
								<p  >
						<br/>
								<?= $kota_header.','.' '.date("d-m-Y",strtotime($data_pasien->tgl_kunjungan));	?>							
								<?php 
									//var_dump($kota_header); die();
									//$cekeestttd = $this->labmdaftar->ttd_haisl($data_pasien->id_dokter)->row();
									if ($ttd != null) {
								?>
									<img src="<?php echo $ttd ?>" alt="">
								<?php }else{} ?>
								<br><br><br><?= $data_pasien->nm_dokter ?>
								</p>
							</td>
						</tr>	
					</table>
					<br><p style="font-size:11px">*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter</p>
		
        </div>
       
        
       
    </body>
</html>