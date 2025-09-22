<?php 
 $data = (isset($tata[0]->formjson)?json_decode($tata[0]->formjson):'');
//  var_dump($data); 
?>

<!DOCTYPE html>
<html>
    <head><title>Tata Tertib Pasien</title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            /* position: relative; */
            text-align: justify;
           
        }
        .h-2{
            height:40px;
            text-align:center;
        }
        .h-2 td{
            vertical-align:middle;
        }

        .h-3{
            height:35px;
        }
        .h-3 td{
            vertical-align:middle;
        }
        .h-3 td span{
            display: inline-block;
            line-height:1.5;
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
        .row{
            display:flex;

        }
        .footer{
            float:right;
            margin-top:20px;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
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
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>
            <p style = "font-weight:bold; font-size: 18px; text-align: center;">
                TATA TERTIB PASIEN, PENUNGGU DAN PENGUNJUNG
            </p>
            <ol style="list-style-type: upper-alpha;font-size: 13px;">
                <li>Tata Tertib Pasien, Penunggu dan Pengunjung Rumah Sakit Otak DR. Drs. M. Hatta  Bukittinggi</li>
                    <ol>
                        <li>Jam Berkunjung (bezuk) Pasien  : <br> a. Ruang Rawat Inap A,B,C : <br>Pagi : Jam 11.00 s/d 13.00 WIB <br> Sore : Jam 17.00 s/d 19.00 WIB <br><br> b.Ruang Rawat ICU dan HCU : <br>Pagi : Jam 11.00 s/d 12.00 WIB <br>Sore : Jam 17.00 s/d 18.00 WIB </li><br>
                        <li>Untuk kepentingan kesehatan, anak usia di bawah 12 tahun tidak diizinkan/dilarang memasuki area perawatan.</li>
                        <li>Dilarang merokok,membawa minuman keras dan membawa senjata tajam selama  berada di lingkungan RSOMH Bukittinggi.</li>
                        <li>Tata Tertib Bagi Penunggu Pasien :</li>
                            <ol style="list-style-type: lower-alpha;">
                                <li>Setiap pasien hanya boleh ditunggui oleh maksimal 1 orang yang merupakan keluarga pasien dan tidak boleh diganti sampai pasien pulang.</li>
                                <li>Dilarang membawa barang berharga/alat tidur/barang elektronik (magic com,kipas angin,radio atau barang sejenis lainnya) ke dalam lingkungan RSOMH Bukittinggi dan kami tidak bertanggung jawab atas kehilangan,pencurian atau kerusakan terhadap barang tersebut.</li>
                                <li>Dilarang duduk,makan dan tidur dilantai koridor ruang perawatan.</li>
                                <li>Dilarang mencuci dan menjemur pakaian di lingkungan ROMH Bukittinggi.</li>
                            </ol>
                        <li>Untuk keselamatan dan kenyamanan pasien :</li>
                            <ol style="list-style-type: lower-alpha;">
                                <li>Jumlah pengunjung (saat jam bezuk) yang masuk ruang perawatan maksimal 2 orang untuk Rawat Inap A,B,C, kecuali ruang ICU dan HCU 1 orang secara bergantian.</li>
                                <li>Dilarang membawa makanan yang beraroma tajam dan menyengat (durian,terasi dan makanan sejenis lainnya).</li>
                            </ol>
                        <li>Jagalah kebersihan dan buanglah sampah pada tempat yang telah disediakan </li>
                        <li>Jagalah kesopanan dan kenyamanan di dalam ruang perawatan.</li>
                        <li>Petugas Satpam akan menutup/mengunci seluruh pintu ruang Rawat Inap dan petugas Satpam berwenang untuk melaksanakan penertiban sesuai ketentuan tersebut diatas.</li>
                    </ol>
                <li>Untuk penunggu pasien akan diberi tanda pengenal sesuai peraturan yang berlaku di RSOMH Bukittinggi.</li>
            </ol>

            <br><br>

            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Pasien/Keluarga/Penanggung Jawab</p>
                        <img style="margin-left:5em;" src="<?= isset($data->ttd_pasien)?$data->ttd_pasien:''; ?>" width="120px" height="120px" alt=""><br> 
                        <span> <center>(<span><?= (isset($data->question23->nama)?$data->question23->nama:'') ?>)</span></center> </span>
                        <span>Nama jelas & tanda tangan	</span>      
                    </div>
                    <div style="float: right;text-align: center;">
                        <p>Petugas Rumah Sakit</p>
                        <img  src="<?= (isset($tata[0]->ttd_pemeriksa)?$tata[0]->ttd_pemeriksa:'')?>" width="120px"  height="120px" alt=""><br>  
                            <center><span><?= (isset($tata[0]->nm_pemeriksa)?$tata[0]->nm_pemeriksa:'') ?></span></center>  
                        <span>Nama jelas & tanda tangan	</span>
                    </div>     
                </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
            
         
        </div>
    </body>
</html> 