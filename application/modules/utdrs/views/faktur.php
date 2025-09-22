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
            font-size:12px;
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
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>RSUD AHMAD SYAFII MAARIF</label></b><br>
                                </font>
                                <!-- <font style="font-size:8pt">
                                    <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                    <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                                </font>    
                                <br>
                                <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label> -->
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <!-- <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;"> -->
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
                FAKTUR TRANSFUSI DARAH No.<?= $no_utdrs ?>
            </p>
					<table border="0" width="100%">
					
						<tr>
							<td width="15%"><b>No. Registrasi</b></td>
							<td width="3%">:</td>
							<td width="32%"><?= $data_pasien->no_register ?></td>
							<td width="10%"><b>Nama Pasien</b></td>
							<td width="3%">:</td>
							<td width="37%"><?= $data_pasien->nama ?></td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td><?= $data_pasien->no_cm ?></td>
							<td><b>Tanggal Lahir</b></td>
							<td> : </td>
							<td><?php echo date("d-m-Y", strtotime($data_pasien->tgl_lahir)); ?></td>
							<!-- <td><b>Umur</b></td>
							<td> : </td>
							<td><?php //echo $tahun .'tahun'?></td> -->
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td>: </td>
							<td><?php 
								if($data_pasien->ruang == 'BI00' && $data_pasien->kelas == 'NK') {
									echo 'MCU';
								} else if($data_pasien->ruang == 'BI03' && $data_pasien->kelas == 'EKSEKUTIF') {
									echo 'MCU EKSEKUTIF';
								} else if($data_pasien->ruang != 'BI00' && $data_pasien->ruang != 'BI03' && $data_pasien->kelas == 'EKSEKUTIF') {
									echo 'EKSEKUTIF';
								} else {
									echo $data_pasien->cara_bayar;
								}
							?></td>
							<td><b>Alamat</b></td>
							<td> :</td>
							<td><?= $data_pasien->alamat ?></td>
						</tr>
						<tr>
							<td><b>Asal Pasien</b></td>
							<td> : </td>
							<td colspan ="4"><?= $data_pasien->ruang ?></td>
						</tr>
						<tr>
							<td><b>Terbilang</b></td>
							<td> : </td>
							<td colspan ="4"><b><i><?= strtoupper($vtot_terbilang)?></i></b></td>							
						</tr>
					</table>
					<br><br/>

					<table border="1" id="data">
						<tr>
							<th width="5%"><p align="center"><b>No</b></p></th>
							<th width="55%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
							<th width="15%"><p align="center"><b>Biaya</b></p></th>
							<th width="10%"><p align="center"><b>Banyak</b></p></th>
							<th width="15%"><p align="center"><b>Total</b></p></th>
						</tr>
						<?php
						$i=1;
						$jumlah_vtot=0;
						foreach($data_pemeriksaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
                        ?>
						<tr>
						  	<td><p><?= $i++?></p></td>
						  	<td style="text-align:justify"><p><?= $row->jenis_tindakan?></p></td>
						  	<td><p><?= number_format( $row->biaya_utd, 2 , ',' , '.' )?></p></td>
						  	<td><p><?= $row->qty ?></p></td>
						  	<td><p><?= $vtot ?></P></td>
						</tr>
                        <?php } ?>
                        <tr>
						<th colspan="4" style="text-align:justify"><p><b>Total</b></p></th>
			 				<th><p><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
			 			</tr>
                    </table>
			 		<br>
			 		<br>
			 		<table style="width:100%;">
			 			<tr>
			 				<td width="55%" ></td>
			 				<td>
			 					<p>Tanah Badantuang <?=','.' '.$tgl?></p>
			 					<p>Unit Transfusi Darah</p><br><br>
                                 <p><?= $user?></p>
			 					</p>
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>