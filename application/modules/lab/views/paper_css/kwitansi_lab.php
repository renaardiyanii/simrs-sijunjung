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
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>RSUD SIJUNJUNG</label></b>
                                </font>
                               
                            </td>
                            
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p align="center" style="font-size:14px"><b>
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA LABORATORIUM<br/>
					No. LAB_<?= $no_lab ?>
			</b></p>

            <table width="100%" border="0">	
							
							<tr>
								<td width="23%"><b>Telah Terima Dari</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?= isset($penyetor)?str_replace('%20', ' ', $penyetor):''?></td>
								<td width="23%"><b>Nama Pasien</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?= isset($data_pasien->nama)?$data_pasien->nama:''?></td>

							</tr>
							<tr>
								<td ><b>No Register</b></td>
								<td > : </td>
								<td><?= isset($no_register)?$no_register:''?></td>
								<td ><b>Alamat</b></td>
								<td > : </td>
								<td><?= isset($data_pasien->alamat)?$data_pasien->alamat:''?></td>
							</tr>
							<tr>
								<td ><b>No RM</b></td>
								<td > : </td>
								<td><?= isset($data_pasien->no_cm)?strtoupper($data_pasien->no_cm):''?></td>
								<td><b>Kota</b></td>
								<td> : </td>
								<td><?= (isset($data_pasien->kotakabupaten)?$data_pasien->kotakabupaten:'') ?></td>
							</tr>
							<tr>
								<td ><b>Tgl Reg</b></td>
								<td > : </td>
								<td><?=isset($data_pasien->tgl)?$data_pasien->tgl:''?></td>	
								<td><b>Umur</b></td>
								<td > : </td>
								<td><?=strtoupper($umur).' '.'Tahun'?></td>
							</tr>
							<tr>
								<td ><b>Pembayaran</b></td>
								<td > : </td>
								<td><?=isset($data_pasien->cara_bayar)?strtoupper($data_pasien->cara_bayar):''?></td>	
								<td><b>Jenis Kelamin</b></td>
								<td > : </td>
								<td><?= (isset($data_pasien->sex)?$data_pasien->sex:'') ?></td>
							</tr>
							<tr>
								<td ><b>Dijamin Oleh</b></td>
								<td > : </td>
								<td><?= isset($detail_daful->kontraktor)?strtoupper($detail_daful->kontraktor):''?></td>	
								<td><b>No Kwitansi</b></td>
								<td > : </td>
								<td><?=isset($kwitansi)?$kwitansi:''  ?></td>
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan="3"><?= isset($detail_daful->nm_poli)?strtoupper($detail_daful->nm_poli):''?></td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td><?=isset($detail_daful->nm_dokter)?strtoupper($detail_daful->nm_dokter):''?></td>
							</tr>											
			</table>
                
                <br>

                <table border="1" style="padding:2px;font-size:11px" width="100%">
						<tr>
							<th width="5%"><p align="center"><b>No</b></p></th>
							<th width="65%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
							<th width="10%"><p align="center"><b>Banyak</b></p></th>
							<th width="20%"><p align="center"><b>Total</b></p></th>
						</tr>

                       <?php 
                        $i=1;
                        $no=1;
                        $jumlah_vtot=0;
                        foreach($data_pemeriksaan as $row){
                            $jumlah_vtot=$jumlah_vtot+$row->vtot;
                            $vtot = number_format( $row->vtot, 2 , ',' , '.' );
                        ?>
						<tr>
						  	<td><p align="center" style="font-size:11px"><?= $i ?></p></td>
						  	<td><p style="font-size:11px"><?= $row->jenis_tindakan ?></p></td>
						  	<td><p align="center" style="font-size:11px"><?= $row->qty?></p></td>
						  	<td><p align="right" style="font-size:11px"><?= $vtot?></P></td>
						</tr>
						<?php $i++; ?>
					<?php } ?>

                    <?php if(substr($data_pasien->no_register,0,2) == 'PL'){ ?>
						<tr>
						  	<td><p align="center" style="font-size:11px"></p></td>
						  	<td style="font-size:11px"><p><?= $data_adm->nmtindakan ?></p></td>
						  	<td style="font-size:11px"><p align="center"></p></td>
						  	<td style="font-size:11px"><p align="right"><?= $data_adm->total_tarif ?></P></td>
						</tr>
						<?php $jumlah_vtot += $data_adm->total_tarif; ?>
				    <?php } ?>

                         <tr>
							<th colspan="2"><p align="left"><b> Laboratorium </b></p></th>
							<th><p align="center"><b><?= $i-1 ?></b></p></th>
							<th><p align="right"><?= number_format( $jumlah_vtot, 2 , ',' , '.' ) ?></p></th>
						</tr>
                        <?php if($diskon!=0){ ?>
                                <tr>
                                    <th colspan="3"><p align="left"><b>Diskon </b></p></th>
                                    <th><p align="right"><?= number_format( $diskon, 2 , ',' , '.' )?></p></th>
                                </tr>
                            <?php $jumlah_vtot=$jumlah_vtot-$diskon; ?>
                                <tr>
                                    <th colspan="3"><p align="right"><b>Total Bayar</b></p></th>
                                    <th><p align="right"><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
                                </tr>
                     <?php  } ?>
					 
					 
                    <?php $vtot_terbilang=$cterbilang->terbilang($jumlah_vtot); ?>

                </table>
					
						<p style="font-size:12px">
                        Terbilang : 
							<i><b><?= strtoupper($vtot_terbilang)?></b></i>
                        </p><br><br>
					
					
					<table style="width:100%;">
						<tr>
							<td width="65%" >
							<p>
								<?= $kota_header.','.' '.$tgl ?>
								<br>Pasien
								<br>
								<br><br><br>
								
								</p>
							</td>
							<td width="35%">
								<p>
								<?= $kota_header.','.' '.$tgl ?>
								<br>an.Kepala Rumah Sakit
								<br>K a s i r
								<br><br><br>ADMIN
								</p>
							</td>
						</tr>	
					</table>
               
        </div>
    </body>
</html>