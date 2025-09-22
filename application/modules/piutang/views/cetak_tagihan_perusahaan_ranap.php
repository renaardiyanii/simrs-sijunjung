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
               
			<table width="100%" border="0" cellpadding="5px">	
							<tr>
								<td colspan="3" ><p size="14px" align="center"><u><b><center>TAGIHAN IKATAN KERJASAMA <?= $date1 ?> s/d <?= $date2 ?></center></b></u></p></td>
							</tr>	
	
							<tr>
								<td width="20%" ><b>Nama Perusahaan</b></td>
								<td width="2%"> : </td>
								<td><?= strtoupper($nm_perusahaan)?></td>
							</tr>	
							<tr>		
								<td><b>Tgl Cetak Tagihan</b></td>
								<td> : </td>
								<td><?= date('d-m-Y') ?></td>

							</tr>										
				</table><br>

                <?php $no=1; ?>
			
			        <table border="1" style="padding:2px" width="100%" >
                        
						<tr>
                            <th width="20%" style="font-size:11px"><p align="center"><b>Tgl Kunjungan</b></p></th>
                            <th width="15%" style="font-size:11px"><p align="center"><b>No.RM</b></p></th>
                            <th width="40%" style="font-size:11px"><p align="center"><b>Nama Pasien</b></p></th>
							<th width="25%" style="font-size:11px"><p align="center"><b>Tagihan</b></p></th>
                            <th width="25%" style="font-size:11px"><p align="center"><b>Tagihan Ruangan</b></p></th>
						</tr>

						<?php 
						$total_tagihan=0;
                        $total_bayar=0;
                        $no=1;
                        foreach ($list_pasien as $val){ 
                            $tagihan_ruang_ranap = $this->mperusahaan->get_tagihan_ruangan_ranap($val->no_ipd);
                        ?>
                        <tr>
                            <td  style="font-size:11px"><p align="center"><?= date('d-m-Y',strtotime($val->tgl_kunjungan)) ?></p></td>
                            <td  style="font-size:11px"><p align="center"><?= $val->no_medrec ?></p></td>
                            <td  style="font-size:11px"><p align="center"><?= $val->nama ?></p></td>
							<?php 
							 	$tagihan_pasien =  $val->biaya_poli + $val->biaya_lab + $val->biaya_rad + $val->biaya_em + $val->biaya_ok + $val->biaya_resep;
							?>
							<td  style="font-size:11px"><p align="center">Rp. <?= number_format($tagihan_pasien, 2 , ',' , '.' );?></p></td>

                            <?php
                                    foreach($tagihan_ruang_ranap as $r){
                                        if($r['no_ipd'] == $val->no_ipd){
                                            $diff = 1;
                                            if($r['tglkeluarrg'] != null){
                                                $start = new DateTime($r['tglmasukrg']);//start
                                                $end = new DateTime($r['tglkeluarrg']);//end

                                                $diff = $end->diff($start)->format("%a");
                                                if($diff == 0){
                                                    $diff = 1;
                                                }
                                            }else{
                                                if($val->tgl_keluar != NULL){
                                                $start = new DateTime($r['tglmasukrg']);//start
                                                    $end = new DateTime($val->tgl_keluar);//end

                                                    $diff = $end->diff($start)->format("%a");
                                                    if($diff == 0){
                                                        $diff = 1;
                                                    }

                                                }else{
                                                    $start = new DateTime($r['tglmasukrg']);//start
                                                    $end = new DateTime(date("Y-m-d"));//end

                                                    $diff = $end->diff($start)->format("%a");
                                                    if($diff == 0){
                                                        $diff = 1;
                                                    }
                                                }
                                            }
                                            $total_bayar = $total_bayar + ($diff * $r['tarif_iks'] );
                                     }
                                    
                                    }
								
							?>
						    <td><?php echo number_format($total_bayar, 2 , ',' , '.' );?></td>
						</tr>
                       <?php 
					   $total_tagihan += $tagihan_pasien + $total_bayar ;
						}
                        
                        ?>

						<tr>
                            <th style="font-size:11px" colspan="4"><p align="center"><b>Total Tagihan</b></p></th>
							<th style="font-size:11px"><p align="center"><b>Rp. <?php echo number_format($total_tagihan, 2 , ',' , '.' )  ?></b></p></th>
						</tr>

					</table>
					<br/><br/>
					

                    <table style="width:100%;">
						<tr>
							<td width="65%" >
							
							</td>
							<td width="35%">
								<p>
								<?= $kota_header.','.' '.strtoupper(date('d-m-Y')) ?>
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br>
								</p>
							</td>
						</tr>	
					</table>
        </div>
    </body>

</html>
            