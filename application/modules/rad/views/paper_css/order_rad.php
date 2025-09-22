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
			SURAT PERMINTAAN 
            </p>
					<table border="0" width="100%">
					
						<tr>
							<td width="15%"><b>No. Registrasi</b></td>
							<td width="3%">:</td>
							<td width="32%"><?= isset($data_pasien->no_register)?$data_pasien->no_register:'' ?></td>
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
							<td><?= isset($data_pasien->kelas)?$data_pasien->kelas:'' ?></td>
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
							<td><?= isset($data_pasien->cara_bayar)?$data_pasien->cara_bayar:'' ?></td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td><?= isset($tahun)?$tahun.' '.'Tahun':'' ?></td>
							
						</tr>
						<tr>
						    <td><b>Asal Pasien</b></td>
							<td> : </td>
							<td><?= $asal ?></td>
                            <td><b>Dokter Pengirim</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?></td>
						</tr>
					</table>
					<br>

                    <table border="0" width="100%">
                        <tr>
							<td><b>Diagnosis Medis</b></td>
							<td>:</td>
							<td><?php foreach($diagnosa as $r) {
                                echo '- '.$r->diagnosa.' ('.$r->klasifikasi_diagnos.')<br>';
                            } ?></td>
						</tr>
                    </table><br>

					<table border="1" id="data">
						<tr>
							<th width="5%"><p align="center"><b>No</b></p></th>
							<th width="25%"><p align="center"><b>Catatan</b></p></th>
							<th width="30%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
							<th width="30%"><p align="center"><b>Tanggal Order</b></p></th>
						</tr>
					<?php
					$i=1;
					foreach($data_pemeriksaan as $row){
                        ?>
						<tr>
							<td><p><?= $i++?></p></td>
						  	<td><p><?= $row->komen ?></p></td>
						  	<td><p><?= $row->jenis_tindakan?></p></td>
						  	<td><p><?= $row->jadwal?></p></td>
						</tr>
                        <?php } ?>
                         </table>
			 		<br>
			 		<br>
			 		<table style="width:100%;">
			 			<tr>
			 				<td width="75%" ></td>
			 				<td width="25%">
			 					<p><?= $kota_header.','.' '.$tgl?></p>
			 					<p>Dokter Pengirim</p><br><br>
                                 <img src="<?php
                                    //$userid = isset($data_pemeriksaan[0]->xinput)?$data_pemeriksaan[0]->xinput:'';
                                    // if($userid == ''){
                                    //     $ttd = '';
                                    // }else{
                                    //     $ttd = $this->labmdaftar->get_ttd_by_userid($userid)->row();
                                    // }
                                    
                                    echo $data_pasien->ttd;
                                 ?>" alt="" style="width:100px;height; 100px;">
                                 <p><?= isset($data_pasien->dokter)?$data_pasien->dokter:''; ?></p>
			 					</p>
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>