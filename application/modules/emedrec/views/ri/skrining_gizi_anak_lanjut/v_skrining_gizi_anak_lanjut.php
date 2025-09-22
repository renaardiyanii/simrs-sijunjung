<?php
$data = (isset($skrining->formjson)?json_decode($skrining->formjson):'');
// var_dump($data->question1->{'1'}->{'1'});
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 5px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 11px;
            
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center>
                <span style="font-size:15px;font-weight:bold">ASESMEN GIZI ANAK</span>
            </center>
            <!-- <center>
                <span style="font-size:15px;font-weight:bold">(Berdasarkan Metode Strong Kids)</span>
            </center> -->

            <div style="font-size:12px">
            <br>
                <table width="100%">
                    <tr>
                        <td width="20%"><span style="font-size:11px">Diagnosa Medis</span></td>
                        <td width="2%" style="font-size:10px">:</td>
                        <td><?= isset($data->diagnosis_medis)?$data->diagnosis_medis:'' ?></td>
                    </tr>
                </table><br>

            <table width="100%" border="1" id="data">
                <tr>
                    <td width="6%"><h4>No.</h4></td>
                    <td width="47%"><h4>Parameter</h4></td>
                    <td width="47%"><h4>Skor</h4></td>
                </tr>
                <tr>
                    <td width="6%" rowspan="3"><h4>1</h4></td>
                    <td width="47%">Apakah pasien tampak kurus ?</td>
                    <td width="47%"></td>
                </tr>
                <tr  class="<?= isset($data->question1->{'1'}->{'1'})?intval($data->question1->{'1'}->{'1'})=="0"?"penanda":"":''; ?>">
                    <td width="47%">A. Tidak</td>
                    <td width="47%">0</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'1'})?intval($data->question1->{'1'}->{'1'})=="1"?"penanda":"":''; ?>">
                    <td width="47%">B. Ya</td>
                    <td width="47%">1</td>
                </tr>
                <tr>
                    <td width="6%" rowspan="11"><h4>2</h4></td>
                    <td width="94%" colspan="2">Apakah terdapat penyakit atau keadaan berikut yang mengakibatkan pasien berisiko mengalami malnutrisi ?</td>
                </tr>
                <tr >
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Diare kronik (lebih dari 2 minggu)", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">A. Diare Kronik (Lebih dari 2 minggu)</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Lain-lain (berdasarkan pertimbangan dokter)", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">I. Lain-lain (berdasarkan pertimbangan dokter)</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Penyakit Jantung Bawaan", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">B. Penyakit Jantung Bawaan</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Kelainan anatomi daerah mulut yang menyebabkan kesulitan makan (misal: bibir sumbing)", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">J. Kelainan Anatomi daerah mulut yang menyebabkan kesulitan makan (misal: bibir sumbing)</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Infeksi Human Immunodeficiency Virus (HIV)", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">C. Infeksi Human Immunodeficiency Virus (HIV)</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Trauma", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">K. Trauma</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Kanker", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">D. Kanker</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Kelainan metabolik bawaan", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">L. Kelainan metabolik bawaan</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Penyakit hati kronik", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">E. Penyakit Hati Kronik</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Retardasi mental", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">M. Retardasi Mental</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Penyakit Ginjal kronik", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">F. Penyakit Ginjal Kronik</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Keterlambatan perkembangan", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">N. Keterlambatan perkembangan</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("TB Paru", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">G. TB Paru</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Rencana/paskaoperasi mayor (misal: laparotomi, Torakotomi)", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">O. Rencana/paskaoperasi mayor (misal: laparotomi, Torakotomi)</td>
                </tr>
                <tr>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("Luka bakar luas", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">H. Luka Bakar Luas</td>
                    <td width="47%" class="<?= isset($data->question1->{'1'}->kondisi)?in_array("p.\tTerpasang stoma", $data->question1->{'1'}->kondisi)?"penanda":"":''; ?>">P. Terpasang stoma</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'2'})?intval($data->question1->{'1'}->{'2'})==0?"penanda":"":''; ?>">
                   
                    <td width="47%">1. Tidak</td>
                    <td width="47%">0</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'2'})?intval($data->question1->{'1'}->{'2'})==2?"penanda":"":''; ?>">
                  
                    <td width="47%">2. Ya</td>
                    <td width="47%">2</td>
                </tr>
                <tr>
                    <td width="6%" rowspan="5"><h4>3</h4></td>
                    <td width="94%" colspan="2">Apakah terdapat salah satu dari kondisi berikut?</td>
                </tr>
                <tr>
                    <td width="94%" colspan="2" class="<?= isset($data->question1->{'1'}->kondisi1)?in_array("Diare ≥ 5 kali/hari dan atau muntah> 3 kali/hari dalam seminggu terakhir", $data->question1->{'1'}->kondisi1)?"penanda":"":''; ?>">A. Diare ≥ 5 kali/hari dan atau muntah> 3 kali/hari dalam seminggu terakhir</td>
                </tr>
                <tr>
                    <td width="94%" colspan="2" class="<?= isset($data->question1->{'1'}->kondisi1)?in_array("Asupan makanan berkurang selama 1 minggu terakhir", $data->question1->{'1'}->kondisi1)?"penanda":"":''; ?>">B. Asupan makanan berkurang selama 1 minggu terakhir</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'3'})?intval($data->question1->{'1'}->{'3'})==0?"penanda":"":''; ?>">
                   
                    <td width="47%">1. Tidak</td>
                    <td width="47%">0</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'3'})?intval($data->question1->{'1'}->{'3'})==1?"penanda":"":''; ?>">
                    
                    <td width="47%">2. Ya</td>
                    <td width="47%">1</td>
                </tr>
                <tr>
                    <td width="6%" rowspan="4"><h4>4</h4></td>
                    <td width="94%" colspan="2">Apakah terdapat penurunan berat badan atau tidak ada penambahan berat badan (bayi< 1 tahun) selama beberapa minggu/bulan terakhir?</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'4'})?intval($data->question1->{'1'}->{'4'})==0?"penanda":"":''; ?>">
                    <td width="47%">A. Tidak</td>
                    <td width="47%">0</td>
                </tr>
                <tr class="<?= isset($data->question1->{'1'}->{'4'})?intval($data->question1->{'1'}->{'4'})==1?"penanda":"":''; ?>">
                    <td width="47%">B. Ya</td>
                    <td width="47%">1</td>
                </tr>
                <tr>
                    <td width="47%"></td>
                    <td width="47%"></td>
                </tr>
                <tr>
                    <td width="6%"></td>
                    <td width="47%" style="font-weight:bold">Total Skor</td>
                    <td width="47%" style="font-weight:bold"><?= isset($data->question1->{'1'}->total_skor)?$data->question1->{'1'}->total_skor:'' ?></td>
                </tr>
                <tr>
                    <td width="6%"></td>
                    <td width="47%" style="font-weight:bold">Hasil Skor</td>
                    <td width="47%" style="font-weight:bold"><?= isset($data->question1->{'1'}->hasil_skor)?$data->question1->{'1'}->hasil_skor:'' ?></td>
                </tr>
            </table><br>

            <p>Hasil Total Skor:</p>
            <p>0	: Berisiko rendah, ulangi skrining setiap 7 hari.</p>
            <p >1-3	: Berisiko menengah, dirujuk ke Tim Terapi Gizi (TTG),  monitoring  asupan makan setiap 3 hari. </p>
            <p>4-5	: Berisiko tinggi, dirujuk ke Tim Terapi Gizi (TTG),  monitoring  asupan  makan setiap hari. </p>

            </div>
            <br><br>
            <div style="font-size:12px">
                <table width="100%">
                <tr align="right">
                    <td width="50%"><span style="font-size:11px">Tanda Tangan</span></td>
                </tr>
                <tr align="right">
                    <td width="50%"><span style="font-size:11px">Nutrisionis</span></td>
                </tr>
                <?php
                $id = isset($skrining->id_pemeriksa)?$skrining->id_pemeriksa:'';
                //  var_dump($id);                                     
                $query = $id?$this->db->query("SELECT ttd FROM hmis_users  where hmis_users.userid = $id")->row():null;
                if(isset($query->ttd)){
                ?>
                 <tr align="right">
                    <td width="50%">  <img width="70px" src="<?= $query->ttd ?>" alt=""></td>
                </tr>  
                <?php
                    } else {?>
                        <br><br><br>
                    <?php } ?>

                <tr align="right">
                    <td width="50%"><span style="font-size:11px">(<?= isset($skrining->nm_pemeriksa)?$skrining->nm_pemeriksa:'' ?>)</span></td>
                </tr>
                </table>
            </div><br><br><br><br><br><br><br>

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