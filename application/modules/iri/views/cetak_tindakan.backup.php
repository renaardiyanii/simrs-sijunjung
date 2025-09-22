<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<style>
    thead {
        background: #c4e8b6 !important;
        color:#4B5F43 !important;
        background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
        background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
        background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
    } #table {
        border: 1px solid;
    }
</style>
<body class="A4">

<div class="A4 sheet  padding-fix-10mm">
        <!-- <header style="margin-top:20px; font-size:1pt!important;">
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
        </header> -->
        <div style="height:0px;border: 2px solid black;"></div>
        <p align="center"><b>
        Data Tindakan
        </b></p><br/>
        
            <table border="1" cellpadding="0" cellspacing="1" width="100%">
            <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Nama Ruang</th>
									  <th>Tgl Tindakan</th>
									  <th>Jam Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Biaya Alkes</th>
									  <th>Qty</th>
									  <th>Total</th>
									  <th>TTD</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar = 0;
									if(!empty($list_tindakan_pasien)){
										foreach($list_tindakan_pasien as $r){ 
											// $path = $r['ttd_pelaksana']; //this is the image path
											// $type = pathinfo($path, PATHINFO_EXTENSION);
											// $dt = file_get_contents($path);
											// $tanda = 'data:image/' . $type . ';base64,' . base64_encode($dt);
									
											//$ttd = $r['ttd_pelaksana'];
											//var_dump($ttd); die();
											// $img = $_POST['img'];
											// $img = str_replace('data:image/png;base64,', '', $img);
											// $img = str_replace(' ', '+', $img);
											// $data = base64_decode($img);
											// $file = "images/" . uniqid() . '.png';
											// $success = file_put_contents($file, $data);
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
											<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
											<td><?php echo $r['qtyyanri'] ; ?></td>
											<td>Rp. <?php echo number_format(($r['tumuminap']+$r['tarifalkes'])*$r['qtyyanri'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + ($r['tumuminap']+$r['tarifalkes'])*$r['qtyyanri'];?>
											<td id="ttd"><img id="imageid" name="imageid" src="<?php echo $r['ttd_pelaksana']; ?>" alt="Red dot" width="75px" height="75px"></td>
											<?php
												//$ttd = '<img src="'.$r['ttd_pelaksana'].'" alt="" width="50px" height="50px"/> ';
											?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
                                    <tr>
                                        <td colspan="8"><h4>Total</h4></td>
                                        <td colspan="2">Rp. <?php echo number_format($total_bayar,0);?></td>
                                    </tr>
								  </tbody>
            </table>
    
    </div>
    
</body>

</html>