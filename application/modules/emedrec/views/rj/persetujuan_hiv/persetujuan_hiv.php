<?php 
$data = isset($persetujuan_hiv->formjson)?json_decode($persetujuan_hiv->formjson):'';
// var_dump($query1->ttd);die()                                  
?>

<!DOCTYPE html>
<html>

<head>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }
        .highlight {
            font-weight: bold;
        }
    </style>

</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
            
                <tr>
                    <td style="text-align: left;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <u><span style="font-size:17px;font-weight:bold;">FORMULIR PERSETUJUAN UNTUK TES HIV</span></u><br>
        </center>
    <div class="container">
        <h4>Sebelum menandatangani formulir persetujuan ini, harap mengetahui bahwa:</h4>
        <ul>
            <li>Anda mempunyai hak untuk berpartisipasi di dalam pemeriksaan dengan dasar kerahasiaan</li>
            <li>Anda mempunyai hak untuk menarik persetujuan dari tes HIV sebelum pemeriksaan tersebut dilangsungkan</li>
            <li>Keberadaan dan kegunaan testing HIV</li>
        </ul>
        <div class="box">
            <p>Saya Telah menerima informasi dan konseling menyangkut hal-hal berikut:</p>
            <ol>
                <li>Keberadaan dan kegunaan testing HIV</li>
                <li>Tujuan dan kegunaan dari tes HIV</li>
                <li>Apa yang dapat dan tidak dapat diberitahukan dari tes HIV</li>
                <li>Keuntungan serta resiko dari tes HIV dan dari mengetahui hasil tes HIV saya</li>
                <li>Pemahaman dari positif, negatif, false negatif, false positif dan hasil intermediate serta nampak dari masa jendela</li>
                <li>Pengukuran untuk pencegahan dari pemaparan dan penularan akan HIV</li>
            </ol>
        </div>
        <div class="box">
            <p>Saya dengan sukarela menyetujui untuk menjalani tes HIV, pemeriksaan HIV dengan ketentuan bahwa hasil tes tersebut akan tetap rahasia dan terbuka hanya kepada saya seorang.</p>
            <p>Saya menyetujui untuk menerima pelayanan konseling setelah menjalani tes HIV pemeriksaan untuk mendiskusikan hasil tes HIV saya dan cara untuk mengurangi resiko untuk terkena HIV atau menyebarluaskan HIV kepada orang lain untuk waktu kedepannya.</p>
            <p>Saya mengetahui bahwa pelayanan kesehatan pada klinik ini tidak akan mempengaruhi keputusan saya secara negatif terhadap tes HIV atau tidak menjalani tes HIV atau hasil dari tes HIV saya.</p>
            <p>Saya telah memberikan kesempatan untuk bertanya dan pertanyaan saya ini telah diberikan jawaban yang memuaskan saya.</p>
        </div>
        <div class="box">
            <p>Saya dengan ini mengizinkan tes HIV / Pemeriksaan HIV</p>
            <p>Untuk dilaksanakan pada tanggal : <?= isset($data->question2)?$data->question2:'' ?></p><br>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <!-- Pasien 1 -->
                <div>
                    <p>Pasien</p>
                    <img src="<?= isset($data->question3)?$data->question3:'' ?>" alt="img" height="50px" width="50px">
                    <p>( <?=  isset($data->question5)?$data->question5:'' ?> )</p>
                </div>
                <div>
                    <?php 
                        $id =isset($persetujuan_medik->id_pemeriksa)?$persetujuan_medik->id_pemeriksa:null;
                        $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                    ?>
                    <p>Konselor</p>
                    <img src="<?= isset($query1->ttd)?$query1->ttd:'' ?>" alt="img" height="50px" width="50px">
                    <p>( <?=  isset($query1->name)?$query1->name:'' ?> )</p>
                </div>
            </div>
        </div>

    </div>
    </div>
    </body>
</html>