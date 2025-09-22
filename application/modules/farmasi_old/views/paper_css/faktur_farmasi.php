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
            
            <font size="1" align="right" style="float:right;"><?= $tgl_jam ?></font><br>
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
            <?php if($cara_bayar != 'BPJS') { ?>
                <table class="table-font-size1" width="100%">
                    <tr>
                        <td  >Nama Pasien</td>
                        <td > :</td>
                        <td  ><?= $nama ?></td>
                        <td >No Resep</td>
                        <td> :</td>
                        <td ><?= 'FRM_'.$no_resep ?></td>
                        
                    </tr>	
                    <tr>
                        <td>Alamat</td>
                        <td> :</td>
                        <td><?= $alamat ?></td>
                        <td >No. Medrec</td>
                        <td> :</td>
                        <td ><?= $no_cm ?></td>						
                    </tr>  
                    <tr>
                        <td>Unit Asal</td>
                        <td> :</td>
                        <td><?= $bed ?></td>
                        <td width="13%">Cara Bayar</td>
                        <td width="2%">:</td>
                        <td width="25%"><?= $cara_bayar ?></td>
                    </tr>			
                    <tr>
                        <td  >Resep Dokter</td>
                        <td  >:</td>
                        <td  ><?= $nmdokter ?></td>
                        <td width="13%">No. Reg</td>
                        <td width="2%">:</td>
                        <td width="25%"><?=  $no_register ?></td>
                        
                    </tr>
                
                    
                    
                </table>
                <br><br>
                <table class="table-font-size1" border="1" width="100%">
                            <tr>
                                <th width="5%" ><p align="center">No</p></th>
                                <th width="25%" ><p align="center">Nama Item</p></th>
                                <th width="25%" ><p align="center">Banyak</p></th>
                                <th  width="20%" ><p align="center">Subtotal</p></th>
                            </tr>
                                <?php $i=1;
                                $jumlah_vtot=0;

                                foreach($data_permintaan as $row){
                                    $jumlah_vtot += $row->vtot;
                                    $vtot = number_format( $row->vtot, 2 , ',' , '.' ); ?>
                                    <tr>
                                        <td><p  align="center"><?= $i ?></p></td>
                                        <td><p align="center"> <?= $row->nama_obat ?>
                                    
                                          <?php  foreach ($data_tindakan_racik as $row1) {
                                                if ($row->id_resep_pasien == $row1->id_resep_pasien) {
                                                    echo '<br>-' . $row1->nm_obat . ' (' . $row1->qty . ')';
                                                
                                                '<br>-'.$row1->nm_obat.$row1->qty; 
                                                }
                                        } ?>
                                                        
                                                
                                        </p></td>
                                        <td><p align="center"> <?= $row->qty ?></p></td>
                                        <td><p align="right"> <?= $vtot ?></p></td>
                                    </tr>
                                   <?php  $i++; ?>
                                   <?php } ?>

                                   <?php $jumlah_vtot += 0; // $tuslah;

                                        $vtot_terbilang=$cterbilang->terbilang($jumlah_vtot); ?>
                            
                                    <tr>
                                        <th colspan="3"><p class="table-font-size1" align="center">Total   </p></th>
                                        <th><p class="table-font-size1" align="right"><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4"><p class="table-font-size1" align="left"><b>Terbilang:</b><?= $vtot_terbilang?></p></th>
                                    </tr>
                                    </table>



           <?php } else { ?>
           <br>
            <table class="table-font-size1" width="100%">				
                <tr>
                    <td width="13%">No. Reg</td>
                    <td width="2%">:</td>
                    <td width="25%"><?=  $no_register ?></td>
                    <td width="13%">Cara Bayar</td>
                    <td width="2%">:</td>
                    <td width="25%"><?= $cara_bayar ?></td>
                </tr>
                <tr>
                    <td >No. Medrec</td>
                    <td> :</td>
                    <td ><?= $no_cm ?></td>
                    <td >No Resep</td>
                    <td> :</td>
                    <td ><?= 'FRM_'.$no_resep ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td> :</td>
                    <td><?= $nama ?></td>
                    <td>Resep Dokter</td>
                    <td>:</td>
                    <td><?= $nmdokter ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td> Unit Asal:</td>
                    <td><?= $bed ?></td>
                    <td>Alamat</td>
                    <td> :</td>
                    <td><?= $alamat ?></td>						
                </tr>    
            </table>
            <br>
            <table class="table-font-size1" border="1" width="100%">
                            <tr>
                                <th width="5%" ><p align="center">No</p></th>
                                <th width="25%" ><p align="center">Nama Item</p></th>
                                <th  width="20%" ><p align="center">Subtotal</p></th>
                            </tr>
                                <?php $i=1;
                                $jumlah_vtot=0;

                                foreach($data_permintaan as $row){
                                    $jumlah_vtot += $row->vtot;
                                    $vtot = number_format( $row->vtot, 2 , ',' , '.' ); ?>
                                    <tr>
                                        <td><p  align="center"><?= $i ?></p></td>
                                        <td><p align="center"> <?= $row->nama_obat ?>
                                    
                                          <?php  foreach ($data_tindakan_racik as $row1) {
                                                if ($row->id_resep_pasien == $row1->id_resep_pasien) {
                                                    echo '<br>-' . $row1->nm_obat . ' (' . $row1->qty . ')';
                                                
                                                '<br>-'.$row1->nm_obat.$row1->qty; 
                                                }
                                        } ?>
                                                        
                                                
                                        </p></td>
                                        <td><p align="center"> <?= $row->qty ?></p></td>
                                        <td><p align="right"> <?= $vtot ?></p></td>
                                    </tr>
                                   <?php  $i++; ?>

                           <?php      }
                                $total_akhir = (int) (1000 * ceil($jumlah_vtot / 1000));
                                $vtot_terbilang=$cterbilang->terbilang($total_akhir);?>

                        <tr>
							<th colspan="2"><p class="table-font-size1" align="center">Total   </p></th>
							<th colspan="2"><p class="table-font-size1" align="right"><?= number_format( $total_akhir, 2 , ',' , '.' )?></p></th>
						</tr>
						<tr>
							<th colspan="4"><p class="table-font-size1" align="right"><b>Terbilang:</b><?= $vtot_terbilang?></p></th>
						</tr>

                            </table>						
                                <p class="table-font-size" align="left">Biaya yang dibayar oleh pasien sebesar 0 rupiah<br>(Ditanggung BPJS)</p>
                                <p></p>
                            </table>
            
           <?php } ?>
                    
                    
        </div>
    </body>
</html>