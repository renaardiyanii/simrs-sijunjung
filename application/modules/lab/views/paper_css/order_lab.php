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
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
                ORDER PEMERIKSAAN LABORATORIUM
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
							<td><b>Umur</b></td>
							<td> : </td>
							<td><?= $tahun .'tahun'?></td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td>: </td>
							<td><?= $data_pasien->cara_bayar ?></td>
							<td><b>Alamat</b></td>
							<td> :</td>
							<td><?= $data_pasien->alamat ?></td>
						</tr>
						<tr>
							<td><b>Asal Pasien</b></td>
							<td> : </td>
							<td colspan ="4"><?= $data_pasien->ruang ?></td>
						</tr>
					</table>
					<br><br/>

					<table border="1" id="data">
						<tr>
							<th width="5%"><p align="center"><b>No</b></p></th>
							<th width="25%"><p align="center"><b>Id Tindakan</b></p></th>
							<th width="30%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
							<th width="30%"><p align="center"><b>Tanggal Periksa</b></p></th>
						</tr>
						<?php
						$i=1;
						foreach($data_pemeriksaan as $row){
                        ?>
						<tr>
						  	<td><p><?= $i++?></p></td>
						  	<td><p><?= $row->id_tindakan ?></p></td>
						  	<td><p><?= $row->jenis_tindakan?></p></td>
						  	<td><p><?= $row->tgl_kunjungan?></p></td>
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
			 					<p>Laboratorium</p><br><br>
                                 <img src="<?php
                                    $userid = isset($data_pemeriksaan[0]->xinput)?$data_pemeriksaan[0]->xinput:'';
                                    if($userid == ''){
                                        $ttd = '';
                                    }else{
                                        $ttd = $this->labmdaftar->get_ttd_by_userid($userid)->row();
                                    }
                                    
                                    echo isset($ttd->ttd)?$ttd->ttd:'';
                                 ?>" alt="" style="width:100px;height; 100px;">
                                 <p><?= $user?></p>
			 					</p>
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>