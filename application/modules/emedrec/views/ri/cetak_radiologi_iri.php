<?php
// var_dump($hasil_pemeriksaan_radiologi);
// $result = array_chunk($data_pasien_irj, 1);
// var_dump($hasil_pemeriksaan_radiologi[0]);die();

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
		.sheet{
			background-repeat:no-repeat!important;
			background-size:700px!important;
			background-position: center center!important;
			background-image:url('<?= base_url("assets/img/logo_transparency_reduce.png"); ?>')!important;
		}
	</style>
</head>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>

// By using querySelector
        JsBarcode("#barcode", "Hi world!");
   </script>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    
    <div class="sheet  padding-fix-10mm"><br>
        <div>
            <center>
                <h3>RUMAH SAKIT OTAK DR. Drs. M . HATTA BUKITTINGGI </h3>
                <h3>INSTALASI RADIOLOGI </h3>
                <p><b><?= isset($hasil_pemeriksaan_radiologi[0]->jenis_tindakan)?$hasil_pemeriksaan_radiologi[0]->jenis_tindakan:'' ?></b></p>

            </center>
        </div>

        <header style="margin-top:20px; font-size:1pt!important;">
            <table border="0" width="100%">
           
                <tr>
                    <td width="15%"><span>No. Reg</span></td>
                    <td width="5%"><span>:</span></td>
                    <td width="30%"><span><?php echo isset($pasien->no_ipd)?$pasien->no_ipd:'' ?></span></td>
                    <td width="15%"><span>Ruang/Poli</span></td>
                    <td width="5%"><span>:</span></td>
                    <td width="30%"><span><?php echo isset($pasien->idrg)?$pasien->idrg:'' ?></span></td>
                </tr>
                <tr>
                    <td><span>No. RM</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($pasien->no_cm)?$pasien->no_cm:'' ?></span></td>
                    <td><span>Tgl. Daftar</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($hasil_pemeriksaan_radiologi[0]->tgl_kunjungan)?date('d-m-Y H:i:s',strtotime($hasil_pemeriksaan_radiologi[0]->tgl_kunjungan)):'' ?></span></td>
                </tr>
                <tr>
                    <td><span>Nama</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($pasien->nama)?$pasien->nama:'' ?></span></td>
                    <td><span>Tgl. Hasil</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($hasil_pemeriksaan_radiologi[0]->tanggal_isi)?date('d-m-Y H:i:s',strtotime($hasil_pemeriksaan_radiologi[0]->tanggal_isi)):'' ?></span></td>
                </tr>
                <tr>
                    <td><span>J-kel/Tgl-Lahir</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($pasien->sex)?$pasien->sex.' '.'/'.' '.date('d-m-Y',strtotime($pasien->tgl_lahir)):'' ?></span></td>
                    <td><span>Dokter Pengirim</span></td>
                    <td><span>:</span></td>
                    <td><span><?php echo isset($pasien->dokter)?$pasien->dokter:''?></span></td>
                </tr>
                <tr>
                    <td><span>Rujukan</span></td>
                    <td><span>:</span></td>
                    <td><span></span></td>
                    <td><span>Kelas Rawat</span></td>
                    <td><span>:</span></td>
                    <td><span><?= isset($pasien->jatahklsiri)?$pasien->jatahklsiri:'' ?></span></td>
                </tr>
    
                <tr>
								<td >Diagnosa</td>
								<td> : </td>
								<td colspan="3">
								<?php echo $nama_diagnosa;?>
								</td>
								
							</tr>  
                    </table> 
                </td>
                </tr>
            </table>
        </header>

        <hr color="black">
        
        <div style="min-height:40%">

            <pre style="font-size:12px"><?= isset($hasil_pemeriksaan_radiologi[0]->hasil_pengirim)?$hasil_pemeriksaan_radiologi[0]->hasil_pengirim:'' ?></pre><br>

            <!-- <p style="font-size:12px"><?php //echo isset($hasil_pemeriksaan_radiologi[0]->rekam_radiologi)?$hasil_pemeriksaan_radiologi[0]->rekam_radiologi:'' ?></p> -->

        </div>

        <table style="width:100%;" style="padding-bottom:5px;font-weight:bold;background-color:red;">
                            <tr>
                                <td width="65%" ></td>
                                <td width="35%">
                                    <p align="center" style="font-weight:bold">
                                        Terimakasih atas kerjasamanya
                                    </p>
                                    <div align="center" style="min-height:60px" >
                                        <p style="font-weight:bold">Wassalaam</p>
                                    </div>
                                  
                                </td>
                            </tr>	
        </table> 
        <div style="width:100%;text-align:right;">
            <div style="margin-bottom:2em;">
                <img src="<?= isset($hasil_pemeriksaan_radiologi[0]->ttd_dokter)?$hasil_pemeriksaan_radiologi[0]->ttd_dokter:'' ?>" width="80px"></img>
            </div>
            <span><?= isset($hasil_pemeriksaan_radiologi[0]->nm_dokter)?$hasil_pemeriksaan_radiologi[0]->nm_dokter:''; ?></span>
        </div>

        <!-- BORDER LUAR-->
    </div>
    
</body>

</html>