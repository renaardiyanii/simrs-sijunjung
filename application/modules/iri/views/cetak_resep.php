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

			.sheet {
			page-break-after: auto !important;
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
							<td width="37%"><?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:'' ?></td>
						</tr>
						<tr>
							<td><b>No. RM</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:'' ?></td>
						</tr>
						<tr>
							<td><b>Jenis Pasien</b></td>
							<td>: </td>
							<td><?= isset($data_pasien[0]['carabayar'])?$data_pasien[0]['carabayar']:'' ?></td>
						</tr>
						<tr>
                            <td><b>Pemberi Resep</b></td>
							<td> : </td>
							<td><?= isset($ttd_dokter->name)?$ttd_dokter->name:'' ?></td>
						</tr>
						<tr>
                            <td><b>Tgl Pelayanan</b></td>
							<td> : </td>
							<td><?= isset($data_pasien[0]['tgl_masuk'])?$data_pasien[0]['tgl_masuk']:'' ?></td>
						</tr>
					</table>
					<br>

					<table border="1" id="data">
						<tr>
                            <th>No</th>
							<th>Nama Obat</th>
							<th>Qty</th>
							<th>Signa</th>
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
									<?= isset($ttd_dokter->name)?$ttd_dokter->name:'' ?>
			 					
			 				</td>
			 			</tr>	
			 		</table>	
        </div>
    </body>
</html>