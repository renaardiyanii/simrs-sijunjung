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
                               
                            <p><h3>RSUD AHMAD SYAFII MAARIF</h3></p><br>
                                
                            </td>
                           
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
					RESEP
            </p>
					<table border="0" width="100%">
					
						<tr>
							<td width="10%"><b>Nama Pasien</b></td>
							<td width="3%">:</td>
							<td width="37%"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
						</tr>
						<tr>
							<td><b>No. RM</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
						</tr>
						<tr>
							<td><b>Jenis Pasien</b></td>
							<td>: </td>
							<td><?= isset($data_pasien->cara_bayar)?$data_pasien->cara_bayar:'' ?></td>
						</tr>
						<tr>
                            <td><b>Pemberi Resep</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?></td>
						</tr>

						<tr>
                            <td><b>Tgl Pelayanan</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->tgl_kunjungan)?date('d-m-Y',strtotime($data_pasien->tgl_kunjungan)):'' ?></td>
						</tr>
					</table>
					<br>

					<table border="1" id="data">
						<tr>
                            <th>No</th>
							<th>Nama Obat</th>
							<th>Qty</th>
							<th>Signa</th>
							<?php 
							if($stat == '1'){ ?>
							<th>Harga Obat</th>
							<?php }
							?>
						</tr>
					<?php
					$i=1;
                    $total_bayar = 0;
					foreach($list_tindakan_pasien as $r){
                        ?>
						<tr>
							<td>R/</td>
							<td><?php echo $r->nama_obat ; ?></td>
							<td><?php echo $r->qty ; ?></td>
							<td><?php echo $r->signa ; ?></td>
							<?php 
							if($stat == '1'){ ?>
							<th><?= $r->biaya_obat ?></th>
							<?php }
							?>
							
						</tr>
                        <?php } ?>
                         </table>
			 		<br>
			 		<br>
			 		<table style="width:100%;">
			 			<tr>
			 				<td width="65%" ></td>
			 				<td width="35%">
			 					<p><?= 'Tanah Badantuang'.','.$tgl ?></p>
								<p><img src="<?= $ttd_dokter->ttd ?>" width="50px" height="50px"></img></p>
								<?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?>
			 	
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>