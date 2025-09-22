<?php 
$data = (isset($ews_dewasa->ews_json))?json_decode($ews_dewasa->ews_json):'';
// var_dump($data);
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            text-align:center;
            
        }
        @media print {
            body {-webkit-print-color-adjust: exact;
                color-adjust: exact;}
        }    
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
        <body class="A4 landscape" >

            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/header_print') ?>
                </header>
                <hr color="black">

                <p align="center" style="font-weight:bold;font-size:16px">
                    <span>LEMBAR OBSERVASI</span><br>
                    <span>(EARLY WARNING SCORE)</span><br>
                    <span>DEWASA</span>
                </p>

                <div style="font-size:12px">
                    <p style="font-weight:bold">Parameter :</p>
               

                    <table width="100%" border="1" id="data" cellpadding="5px">
                        <tr>
                            <td width="15%" rowspan="2">Physiological Parameter</td>
                            <td width="5%" rowspan="2" style="background-color:red">3</td>
                            <td width="5%" rowspan="2" style="background-color:yellow">2</td>
                            <td width="5%" rowspan="2" style="background-color:green">1</td>
                            <td width="5%" rowspan="2">0</td>
                            <td width="5%" rowspan="2" style="background-color:green">1</td>
                            <td width="5%" rowspan="2" style="background-color:yellow">2</td>
                            <td width="5%" rowspan="2" style="background-color:red">3</td>
                            <td width="3.5%" colspan="14">Nilai</td>
                        </tr>
                        <tr>
                        
                            <td width="3.5%"><br></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                            <td width="3.5%"></td>
                        </tr>
                        <tr>
                            <td>Pernafasan</td>
                            <td style="background-color:red">3>≤8</td>
                            <td style="background-color:yellow">3></td>
                            <td style="background-color:green">3>9-11</td>
                            <td >3>12-20</td>
                            <td style="background-color:green"></td>
                            <td style="background-color:yellow">21-24</td>
                            <td style="background-color:red">>25</td>
                            <td><?= isset($data->physiological->result->{'1'})?$data->physiological->result->{'1'}:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Temperatur</td>
                            <td style="background-color:red">≤35</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:green">35,1-36,0</td>
                            <td>36,2-38,0</td>
                            <td style="background-color:green">≥39,1</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:red"></td>
                            <td><?= isset($data->physiological->result->{'2'})?$data->physiological->result->{'2'}:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Sistolik</td>
                            <td style="background-color:red">≤90</td>
                            <td style="background-color:yellow">90-100</td>
                            <td style="background-color:green">101-110</td>
                            <td>111-219</td>
                            <td style="background-color:green"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:red">≥220</td>
                            <td><?= isset($data->physiological->result->{'3'})?$data->physiological->result->{'3'}:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Denyut Nadi</td>
                            <td style="background-color:red">≤40</td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:green">41-50</td>
                            <td>51-90</td>
                            <td style="background-color:green">91-110</td>
                            <td style="background-color:yellow">111-130</td>
                            <td style="background-color:red">≥131</td>
                            <td><?= isset($data->physiological->result->{'4'})?$data->physiological->result->{'4'}:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Kesadaran</td>
                            <td style="background-color:red"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:green"></td>
                            <td>Sadar Penuh</td>
                            <td style="background-color:green"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:red">V.P Or U</td>
                            <td><?= isset($data->physiological->result->{'5'})?$data->physiological->result->{'5'}:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="8">Total</td>
                            <td><?= isset($data->physiological->result->total_skor)?$data->physiological->result->total_skor:'' ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <p style="font-weight:bold">Nilai Score</p>

                    <table width="60%" cellpadding="5px" border=1>
                        <tr>
                            <td width="20%" style="text-align:center">0</td>
                            <td width="20%" style="text-align:center">1 - 4</td>
                            <td width="20%" style="text-align:center">5 - 6</td>
                            <td width="20%" style="text-align:center">7</td>
                        </tr>
                    </table>
                </div><br><br><br><br><br><br><br><br><br>
                <p style="text-align:right;font-size:12px">1</p>
            </div>


            <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/header_print_ganjil') ?>
                </header>
                <hr color="black">

                <p style="font-weight:bold;font-size:14px">
                    <span>Tindakan Penilaian Early Warning System</span><br>
                </p>

                <div style="font-size:12px">
                    <table width="100%" border=1 cellpadding="5px">
                        <tr>
                            <td width="5%" style="text-align:center">NO</td>
                            <td width="20%" style="text-align:center">NILAI EWS</td>
                            <td width="20%" style="text-align:center">FREKUENSI MONITORING</td>
                            <td width="55%" style="text-align:center">ASUHAN YANG DIBERIKAN</td>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>0</td>
                            <td>Minimal setiap 12 jam sekali</td>
                            <td>Lanjutkan observasi/ monitoring secara rutin</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>TOTAL SCORE1 – 4</td>
                            <td>Minimal Setiap 4 – 6 Jam Sekali</td>
                            <td>
                                <ol>
                                    <li>Perawat pelaksana menginformasikan kepada ketua tim / penanggung jawab jaga ruangan tentang siapa yang melaksanakan assesmen selanjutnya.</li>
                                    <li>Ketua tim / penanggung jawab membuat keputusan:<br>
                                        a.	Meningkatkan frekuensi observasi / monitoring<br>
                                        b.	Perbaikan asuhan yang dibutuhkan oleh pasien
                                        </li>
                                </ol>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>TOTAL SCORE 5 DAN 6 ATAU 3 DALAM 1 (SATU) PARAMETER</td>
                            <td>Peningkatan Frekuensi Observasi / Monitoring.Setidaknya Setiap 1 Jam Sekali</td>
                            <td>
                                <ol>
                                    <li>Ketua Tim (Perawat) segera memberikan informasi tentang kondisi pasien kepada dokter jaga atau DPJP,</li>
                                    <li>Dokter jaga atau DPJP melakukan assesmen sesuai kompetensinya dan menentukan kondisi pasien apakah dalam penyakit akut,</li>
                                    <li>Siapkan fasilitas monitoring yang lebih canggih.</li>
                                </ol>
                            </td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>TOTAL SCORE 7 ATAU LEBIH</td>
                            <td>Lanjutkan Observasi / Monitoring Tanda-Tanda Vital</td>
                            <td>
                                <ol>
                                    <li>Ketua Tim (Perawat) melaporkan kepada Tim kode biru</li>
                                    <li>Tim kode biru melakukan assesmen segera</li>
                                    <li>Stabilisasi oleh Tim kode biru dan pasien dirujuk sesuai kondisi pasien</li>
                                    <li>Untuk pasien di IGD (Prioritas 3, 4 dan 5), Perawat penanggungjawab segera kirim pasien ke ruang Resusitasi untuk penangan Bantuan Hidup Lanjut (BHL)</li>
                                </ol>
                            </td>
                        </tr>

                    </table>
                </div>
                <br><br><br><br>
                <p style="text-align:right;font-size:12px">2</p>
            </div>
        </body>
</html>