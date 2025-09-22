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
            <header style="margin-top:20px;">
                    <table border="0" width="100%">
                        <tr>
                           
                            <td  width="74%"  align="center">
							<p align="center">
								<img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80" width="60" style="padding-right:5px;">
							</p><br>
                               
                            <p><h3>RSUD SIJUNJUNG</h3></p><br>
                                
                            </td>
                           
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
			KARTU TINDAKAN
            </p>
					<table border="0" width="100%">
					
						<tr>
							<td width="15%"><b>No. Registrasi</b></td>
							<td width="3%">:</td>
							<td width="32%"><?= isset($data_pasien[0]['no_ipd'])?$data_pasien[0]['no_ipd']:'' ?></td>
							<td width="10%"><b>Nama Pasien</b></td>
							<td width="3%">:</td>
							<td width="37%"><?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:'' ?></td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:'' ?></td>
							<td><b>Tanggal Lahir</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['tgl_lahir'])? date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])):''; ?></td>
						</tr>
                        <tr>
							<td><b>Kelas</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['klsiri'])?$data_pasien[0]['klsiri']:'' ?></td>
							<td><b>Kelamin</b></td>
							<td> : </td>
							<td><?php if($data_pasien[0]['sex'] == 'L') {
                                echo 'Laki Laki';
                            } else {
                                echo 'Perempuan';
                            } ?></td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td>: </td>
							<td><?= isset($data_pasien[0]['carabayar'])?$data_pasien[0]['carabayar']:'' ?></td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td><?= isset($tahun)?$tahun.' '.'Tahun':'' ?></td>
							
						</tr>
						<tr>
						    <td><b>Asal Pasien</b></td>
							<td> : </td>
							<td><?= $data_pasien[0]['nmruang'] ?></td>
                            <td><b>Dokter Pengirim</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['dokter'])?$data_pasien[0]['dokter']:'' ?></td>
						</tr>
					</table>
					<br>

					<table border="1" id="data">
						<tr>
                            <th>Tindakan</th>
							<th>Pelaksana</th>
							<th>Nama Ruang</th>
							<th>Tgl Tindakan</th>
						    <th>Jam Tindakan</th>
						    <th>Biaya Tindakan</th>
							<th>Qty</th>
							<th>Total</th>
							<th>TTD</th>
						</tr>
					<?php
					$i=1;
                    $total_bayar = 0;
					foreach($list_tindakan_pasien as $r){
                        ?>
						<tr>
							<td><?php echo $r['nmtindakan'] ; //if($r['nama_kel']!=''){ echo ' | <b>'.$r['nama_kel'].'</b>'; }?></td>
							<td><?php echo $r['pelaksana'] ; ?></td>
							<td><?php echo $r['nmruang'] ; ?></td>
							<td><?php
								echo date('d-m-Y',strtotime($r['tgl_layanan']));
							?></td>
							<td><?php if($r['jam_tindakan'] != NULL) {
								echo date('H:i',strtotime($r['jam_tindakan']));
							} else { 
								echo "";
							}
							?></td>
							<td>Rp. <?php echo number_format($r['tumuminap'],0) ; ?></td>
							
							<td><?php echo $r['qtyyanri'] ; ?></td>
							<td>Rp. <?php echo number_format(($r['tumuminap'])*$r['qtyyanri'],0) ; ?></td>
							<?php $total_bayar = $total_bayar + ($r['tumuminap'])*$r['qtyyanri'];?>
							<td id="ttd"><img id="imageid" name="imageid" src="<?php echo $r['ttd_pelaksana']; ?>" alt="Red dot" width="75px" height="75px"></td>
							<?php
								//$ttd = '<img src="'.$r['ttd_pelaksana'].'" alt="" width="50px" height="50px"/> ';
								?>
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
			 					<p>Dokter DPJP</p><br><br>
                                 <img src="<?php
                                    //$userid = isset($data_pemeriksaan[0]->xinput)?$data_pemeriksaan[0]->xinput:'';
                                    // if($userid == ''){
                                    //     $ttd = '';
                                    // }else{
                                    //     $ttd = $this->labmdaftar->get_ttd_by_userid($userid)->row();
                                    // }
                                    
                                    echo $ttd;
                                 ?>" alt="" style="width:100px;height; 100px;">
                                 <p><?= $dokter; ?></p>
			 					</p>
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>