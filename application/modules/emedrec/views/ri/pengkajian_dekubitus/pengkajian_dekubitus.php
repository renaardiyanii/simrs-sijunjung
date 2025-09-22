<?php 
$result = array_chunk($pengkajian_dekubitus, 2);
//  $dekubitus = isset($pengkajian_dekubitus[1]->formjson)?json_decode($pengkajian_dekubitus[1]->formjson):null;

    // var_dump($dekubitus);
?>

<!DOCTYPE html>
<html>
    <head><title>Pengkajian Dekubitus</title></head>
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
        .bg-checked{
        background-color:#64C9CF;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
    <?php
    if(count($result)>0){
        // foreach($result as $val){
            for($i=0;$i<count($result);$i++){
            
            ?>
              <?php
            foreach($result[$i] as $val){
                $data = json_decode($val->formjson);
                // var_dump($data);
            ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                PENGKAJIAN DEKUBITUS
            </p>
            <div style="font-size: 12px">

                <div style="display: flex;">
                    <div>
                        <span>Tgl Masuk</span><br>
                        <span>Tgl Pengisian</span><br>
                        <span>Diagnosa Medis</span><br>
                        <span>Ruangan</span>
                    </div>
        
                    <div style="margin-left: 30px;">
                        <span>: <?= isset($data_pasien[0]->tgldaftarri)?date('d-m-Y',strtotime($data_pasien[0]->tgldaftarri)):''; ?></span><br>
                        <span>: <?= isset($val->tgl_input)?date('d-m-Y',strtotime($val->tgl_input)):''; ?></span><br>
                        <span>: <?= isset($diagnosa->diagnosa)?$diagnosa->diagnosa:''; ?></span><br>
                        <span>: <?= isset($data_pasien[0]->nm_ruang)?$data_pasien[0]->nm_ruang:''; ?></span>
                    </div>
                </div><br>

                <span>Berikan tanda (√) pada setiap kondisi pasien dibawah ini :</span><br>
                <table id="data" border="1" style="text-align: center;">
                    <tr class="h-2">
                        <td style="width: 5%;">SKOR</td>
                        <td style="width: 8%;">KONDISI UMUM</td>
                        <td style="width: 3%;">(√)</td>
                        <td style="width: 8%;">KONDISI MENTAL</td>
                        <td style="width: 3%;">(√)</td>
                        <td style="width: 8%;">AKTIVITAS</td>
                        <td style="width: 3%;">(√)</td>
                        <td style="width: 8%;">MOBILITAS</td>
                        <td style="width: 3%;">(√)</td>
                        <td style="width: 8%;">INKONTINENSIA</td>
                        <td style="width: 3%;">(√)</td>
                        <td style="width: 5%;">TOTAL SKOR</td>
                    </tr>
                    <tr class="h-2">
                        <td style="width: 5%;">4</td>
                        <td style="width: 8%;">Baik</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{1})?$data->assesment_dekubitis->result->{1} == "4"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Sadar</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{2})?$data->assesment_dekubitis->result->{2} == "4"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Ambulasi baik</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{3})?$data->assesment_dekubitis->result->{3} == "4"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Penuh</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{4})?$data->assesment_dekubitis->result->{4} == "4"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Kontinen/Kateter</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{5})?$data->assesment_dekubitis->result->{5} == "4"?"✓":'':''; ?></td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr class="h-2">
                        <td style="width: 5%;">3</td>
                        <td style="width: 8%;">Cukup</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{1})?$data->assesment_dekubitis->result->{1} == "3"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Apatis</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{2})?$data->assesment_dekubitis->result->{2} == "3"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Jalan Perlu bantuan</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{3})?$data->assesment_dekubitis->result->{3} == "3"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Terbatas</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{4})?$data->assesment_dekubitis->result->{4} == "3"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Kadang inkontinen</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{5})?$data->assesment_dekubitis->result->{5} == "3"?"✓":'':''; ?></td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr class="h-2">
                        <td style="width: 5%;">2</td>
                        <td style="width: 8%;">Lemah</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{1})?$data->assesment_dekubitis->result->{1} == "2"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Bingung</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{2})?$data->assesment_dekubitis->result->{2} == "2"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Tak bisa pindah bed</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{3})?$data->assesment_dekubitis->result->{3} == "2"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Sangan terbatas</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{4})?$data->assesment_dekubitis->result->{4} == "2"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Inkontinen bak</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{5})?$data->assesment_dekubitis->result->{5} == "2"?"✓":'':''; ?></td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr class="h-2">
                        <td style="width: 5%;">1</td>
                        <td style="width: 8%;">Sangat lemah</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{1})?$data->assesment_dekubitis->result->{1} == "1"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Tak sadar</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{2})?$data->assesment_dekubitis->result->{2} == "1"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Tak bergerak</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{3})?$data->assesment_dekubitis->result->{3} == "1"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Imobilisasi</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{4})?$data->assesment_dekubitis->result->{4} == "1"?"✓":'':''; ?></td>
                        <td style="width: 8%;">Inkonkontinen BAB & BAK</td>
                        <td style="width: 3%;"><?= isset($data->assesment_dekubitis->result->{5})?$data->assesment_dekubitis->result->{5} == "1"?"✓":'':''; ?></td>
                        <td style="width: 5%;"><?= isset($data->assesment_dekubitis->result->total_skor)?$data->assesment_dekubitis->result->total_skor:''; ?></td>
                    </tr>
                </table><br>

                <span>Keterangan skor :</span>
                <span style="margin-left: 80px;">Ttd Pengkaji :</span><br>
                <div class="row">
                    <span>
                        <span class="<?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)<=5?"penanda":"":''; ?>"> < 10	= Resiko sangat tinggi</span><br>
                        <span class="<?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=10 && intval($data->assesment_dekubitis->result->total_skor)<=14?"penanda":"":''; ?>">10 – 14	= Risiko Tinggi</span><br>
                        <span class="<?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=15 && intval($data->assesment_dekubitis->result->total_skor)<=18?"penanda":"":''; ?>">15 - 18 = Risiko Sedang</span><br>
                        <span class="<?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=19 && intval($data->assesment_dekubitis->result->total_skor)<=28?"penanda":"":''; ?>"> > 18	= Risiko Rendah</span>
                    </span>
                   
                            <img width="120" src="<?= $val->ttd; ?>" alt="">

                       
                        <br>
                </div>

                <span>
                    <span><i>Pentalaksanaan Sesuai Derajat Risiko Decubitus</i></span>
                    <span style="margin-left: 60px;">Nama pengkaji : <?= $val->nama_pemeriksa ?></span>
                </span>
                <br><br>


                <table id="data" border="1">
                    <tr class="h-2">
                        <td style="width: 10%;text-align: center;">DERAJAT RESIKO</td>
                        <td style="width: 90%;text-align: center;">PENATALAKSANAAN</td>
                    </tr>
                    <tr class="h-3 <?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)<=5?"penanda":"":''; ?>">
                        <td style="width: 20%;text-align: center;">Risiko sangat Tinggi</td>
                        <td style="width: 40%;">
                            <span>1. Kaji kembali setiap minggu</span><br>
                            <span>2. Kaji kembali jika ada perubahan kondisi signifikan</span>
                        </td>
                    </tr>
                    <tr class="h-3 <?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=10 && intval($data->assesment_dekubitis->result->total_skor)<=14?"penanda":"":''; ?>">
                        <td style="width: 20%;text-align: center;">Risiko Tinggi</td>
                        <td style="width: 40%;">
                        <span style="display: inline-block;line-height:1.8;">1.     Laksanakan perubahan posisi secara berkala</span><br>
                        <span>2.     KIE pasien dan keluarga untuk melaksanakan perubahan posisi 4 jam</span><br>
                        <span>3.    Berikan mobilisasi maksimal</span><br>
                        <span>4.    Amankan tumit</span><br>
                        <span>5.    Manajemen kelembaban kulit, nutrisi adekuat serta resiko gesekan kulit</span><br>
                        <span>6.    Jika memungkinkan kurangi tekanan pada bagian tubuh yang berisiko tertekan dengan alas yang lembut</span>
                        </td>
                </tr>
                <tr class="h-3 <?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=15 && intval($data->assesment_dekubitis->result->total_skor)<=18?"penanda":"":''; ?>">
                    <td style="width: 20%;text-align: center;">Risiko Sedang</td>
                    <td style="width: 40%;">
                    <span>1.    Buat jadwal tertulis miring kanan dan miring kiri (perubahan posisi)</span><br>
                    <span>2.    Gunakan alas yang lembut atau bantal pada area tertekan</span><br>
                    <span>3.    KIE pasien dan keluarga untuk melaksanakan perubahan posisi 2 jam</span><br>
                    <span>4.    Berikan mobilisasi maksimal</span><br>
                    <span>5.    Amankan tumit</span><br>
                    <span>6.    Manejem kelembaban kulit, nutrisi adekuat serta resiko gesekan kulit</span>
                    </td>
                </tr>
                <tr class="h-3 <?= isset($data->assesment_dekubitis->result->total_skor)?intval($data->assesment_dekubitis->result->total_skor)>=18 && intval($data->assesment_dekubitis->result->total_skor)<=28?"penanda":"":''; ?>">
                    <td style="width: 20%;text-align: center;">Sangat Rendah</td>
                    <td style="width: 40%;">
                        Semua yang tertulis pada resiko tinggi + gunakan alas untuk mengurangi tekanan (kasur angin) + protein yang adekuat 
                    </td>
            </tr>
                </table>
            </div>
            <div class="footer">
                <span></span>
            </div>
        </div>

       

        
    <?php }}}?>
       

       
    </body>
</html>