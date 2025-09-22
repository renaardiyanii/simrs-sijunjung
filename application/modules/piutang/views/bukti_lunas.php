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
								<td colspan="6" ><p size="12px" align="center"><u><b>BUKTI PELUNASAN ANGSURAN PIUTANG <?php if (substr($detail_daful->nm_poli,0,3) == 'IGD') {
									echo 'RAWAT DARURAT';
								}else{
									echo 'RAWAT JALAN';
								} ?> </b></u></p></td>
							</tr>	
	
							<tr>
								<td ><b>No Register</b></td>
								<td > : </td>
								<td><?= strtoupper($data_header_piutang->no_register)?></td>
								<!-- <td width="23%"><b>Telah Terima Dari</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?= str_replace('%20', ' ', $penyetor)?></td> -->
								<td width="23%"><b>Nama Pasien</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?=strtoupper($nama_pasien)?></td>

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
								<td><?=strtoupper($umur)?>Tahun</td>
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
								<td><?=strtoupper($jenkel)?></td>
							</tr>
							<tr>
								<td ><b>Pembayaran</b></td>
								<td > : </td>
								<td>Bukti Lunas Angusran</td>	
								<td><b>Tgl Lunas</b></td>
								<td > : </td>
								<td><?=strtoupper($data_header_piutang->tgl_lunas)?></td>
							</tr>
							<tr>
								<!-- <td ><b>Dijamin Oleh</b></td>
								<td > : </td>
								<td><?=strtoupper($detail_daful->kontraktor)?></td>	 -->
								<td><b>Dokter</b></td>
								<td> : </td>
								<td><?=strtoupper($detail_daful->nm_dokter)?></td>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan="3"><?=strtoupper($detail_daful->nm_poli)?></td>
							</tr>
							
							<!-- <tr>
								
								
							</tr>											 -->
				</table><br>

                <?php $no=1; ?>
			
			        <table border="1" style="padding:2px" width="100%" >
                        <tr>
							<th width="40%" style="font-size:11px" colspan="5"><p align="center"><b>RINCIAN ANGSURAN</b></p></th>
						</tr>
                        <tr>
							<th width="40%" style="font-size:11px" colspan="5"><p align="left"><b>TOTAL TAGIHAN :<?= $data_header_piutang->total_tagihan ?></b></p></th>
						</tr>
						<tr>
                            <th width="20%" style="font-size:11px"><p align="center"><b>Tgl Angsuran</b></p></th>
                            <th width="20%" style="font-size:11px"><p align="center"><b>No Kwitansi</b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b>Sisa Angsuran</b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b>Biaya Angsuran</b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b>Sisa Akhir</b></p></th>
						
						</tr>

						<?php 
                        $no=1;
                        foreach ($data_item_piutang as $val){ ?>
                        <tr>
                            <th width="20%" style="font-size:11px"><p align="center"><b><?= date('d-m-Y',strtotime($val->created_date)) ?></b></p></th>
                            <th width="20%" style="font-size:11px"><p align="center"><b><?= $val->no_kwitansi ?></b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b><?= $val->sisa_angsuran ?></b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b><?= $val->biaya_angsuran ?></b></p></th>
							<th width="20%" style="font-size:11px"><p align="center"><b><?= $val->sisa_akhir ?></b></p></th>
						
						</tr>
                       <?php }
                        
                        ?>

					</table>
					<br/><br/>
					

                    <table style="width:100%;">
						<tr>
							<td width="65%" >
							<p>
								<?= $kota_header.','.' '.strtoupper($data_header_piutang->tgl_lunas) ?>
								<br>Pasien
								<br>
								<br><br><br>
								
								</p>
							</td>
							<td width="35%">
								<p>
								<?= $kota_header.','.' '.strtoupper($data_header_piutang->tgl_lunas) ?>
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br><?= $user ?>
								</p>
							</td>
						</tr>	
					</table>
        </div>
    </body>

</html>
            