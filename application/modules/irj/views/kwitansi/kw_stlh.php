<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            
            width: 100%;
            font-size: 9px;
            /* position: relative; */
            
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
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;" ></div>
                <table width="100%" border="0">	
							<tr>
								<td colspan="6" ><p size="12px" align="center"><u><b>KWITANSI <?php if ($data_pasien->id_poli == 'BA00') {
									echo 'RAWAT DARURAT';
								}else{
									echo 'RAWAT JALAN';
								} ?> </b></u></p></td>
							</tr>	
	
							<tr>
								<td ><b>No Register</b></td>
								<td > : </td>
								<td><?= $no_register?></td>
								<!-- <td width="23%"><b>Telah Terima Dari</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?php //echo str_replace('%20', ' ', $penyetor)?></td> -->
								<td width="23%"><b>Nama Pasien</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?=strtoupper($data_pasien->nama)?></td>

							</tr>
							<tr>
								<td ><b>No RM</b></td>
								<td > : </td>
								<td><?= strtoupper($data_pasien->no_cm)?></td>
								<td ><b>Alamat</b></td>
								<td > : </td>
								<td><?= strtoupper($data_pasien->alamat)?></td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td > : </td>
								<td><?=(int)date('Y') - (int)substr($data_pasien->tgl_lahir,0,4);?> Tahun</td>
								<td><b>Kota</b></td>
								<td> : </td>
								<td><?=$data_pasien->kotakabupaten?></td>
							</tr>
							<tr>
								<td ><b>Tgl Reg</b></td>
								<td > : </td>
								<td><?=date("d-m-Y", strtotime($data_pasien->tgl_kunjungan))?></td>	
								<td><b>Jenis Kelamin</b></td>
								<td > : </td>
								<td><?php
                                if($data_pasien->sex == 'L') {
                                    echo 'Laki - Laki';
                                } else {
                                    echo 'Perempuan';
                                }
                                ?></td>
							</tr>
							<tr>
								<td ><b>Jaminan</b></td>
								<td > : </td>
								<td><?=strtoupper($data_pasien->cara_bayar)//.' ('.$data_kwitansi->jenis_bayar.')'?></td>	
								<td><b>No Kwitansi</b></td>
								<td > : </td>
								<td><?= isset($data_kwitansi->no_kwitansi)?strtoupper($data_kwitansi->no_kwitansi):''?></td>
							</tr>
							<tr>
								<!-- <td ><b>Dijamin Oleh</b></td>
								<td > : </td>
								<td><?php //echo strtoupper($detail_daful->kontraktor)?></td>	 -->
								<td><b>Dokter</b></td>
								<td> : </td>
								<td><?=strtoupper($nm_dokter)?></td>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan="3"><?=strtoupper($data_pasien->nm_poli)?></td>
							</tr>
							
							<!-- <tr>
								
								
							</tr>											 -->
				</table><br>

                <?php $no=1; ?>
			
			    <table border="1" style="padding:2px" width="100%" >
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Diskon</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>

                       <?php  
					   $jumlah_vtot = 0;  
					   //$jml = 0;
					   foreach($data_tindakan as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $no++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->nmtindakan))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format( $row1->diskon, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot - $row1->diskon), 2 , ',' , '.' )?></p></td>
                        </tr>
					<?php 
					
					$jumlah_vtot += $row1->vtot - $row1->diskon;
				        

				} ?>

                    <?php 
                   // $jumlah_vtot =  $vtottind;
			        //$jumlah_vtot_1 =  $jumlah_vtot - $diskon;
                    $jumlah_vtot_1 =  $jumlah_vtot; ?>
						
						<tr>
							<th colspan="4"><p align="right" style="font-size:11px"><b>Sub Total   </b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
						</tr>
						<!-- <tr>
							<th colspan="4"><p align="right" style="font-size:11px"><b>Diskon   </b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $diskon, 2 , ',' , '.' )?></p></th>
						</tr> -->
						<tr>
							<th colspan="4"><p align="right" style="font-size:11px"><b>Total   </b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_1, 2 , ',' , '.' )?></p></th>
						</tr>
					</table>
					<br/><br/>
					<!-- <table  >										
					        <tr>
								<td width="17%" style="font-size:11px"><b>Terbilang</b></td>
								<td width="2%" style="font-size:11px"> : </td>
								<td  width="78%" style="font-size:11px"><i><?= strtoupper($vtot_terbilang)?></i></td>
							</tr>
					</table><br> -->

                    <table style="width:100%;">
						<tr>
							<td width="65%" >
							<p>
								<?= $kota_header.','.' '.date("d-m-Y", strtotime($data_pasien->tgl_kunjungan)); ?>
								<br>Pasien
								<br>
								<br><br><br>
								
								</p>
							</td>
							<td width="35%">
								<p>
								<?= $kota_header.','.' '.date("d-m-Y", strtotime($data_pasien->tgl_kunjungan)); ?>
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br><?= $login_data->username ?>
								</p>
							</td>
						</tr>	
					</table>
        </div>
    </body>

</html>
            