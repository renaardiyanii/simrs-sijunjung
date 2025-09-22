<?php 
$data = (isset($skrining->formjson))?json_decode($skrining->formjson):'';
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="60px" style="padding-bottom: 5px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 11px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 2px solid black;margin-top:1px"></div><br>
      
        <center>
            <u><span style="font-size:15px;font-weight:bold;">FORMULIR SKRINING</span></u><br>
           
        </center>

        <div style="font-size:12px;">
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style=" padding: 5px; font-size:12px;">Nama : </td>
                    <td><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                    <td style=" padding: 5px; font-size:12px;">Tanggal lahir :</td>
                    <td><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?></td>  
                </tr>
                <tr>
                    <td style=" padding: 5px; font-size:12px;">No. MR :</td>
                    <td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                    <td style=" padding: 5px; font-size:12px;">Tanggal Berobat :</td>
                    <td><?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></td>
                </tr>
            </table>
        
            <span>1. FORMULIR SKIRING TB</span>
            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">No</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Gejala TB</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">YA</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">TIDAK</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">1</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Batuk berdahak selama > 2 minggu</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->batuk_berdahak->option)?($data->tb->batuk_berdahak->option == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->batuk_berdahak->option)?($data->tb->batuk_berdahak->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">2</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Batuk berdarah</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->baruk_berdarah->option)?($data->tb->baruk_berdarah->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->baruk_berdarah->option)?($data->tb->baruk_berdarah->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">3</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Sesak nafas</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->sesak_nafas->option)?($data->tb->sesak_nafas->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->sesak_nafas->option)?($data->tb->sesak_nafas->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">4</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Nyeri Dada</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->nyeri_dada->option)?($data->tb->nyeri_dada->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->nyeri_dada->option)?($data->tb->nyeri_dada->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">5</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Demam hilang timbul</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->demam_hilang->option)?($data->tb->demam_hilang->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->demam_hilang->option)?($data->tb->demam_hilang->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">6</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Keringat malam tanpa aktifitas</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->keringat_malam->option)?($data->tb->keringat_malam->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->keringat_malam->option)?($data->tb->keringat_malam->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">7</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Penurunan berat badan tanpa penyebab yang jelas</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->pernurunan_berat->option)?($data->tb->pernurunan_berat->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->pernurunan_berat->option)?($data->tb->pernurunan_berat->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">8</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Penurunan nafsu makan</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->penurunan_nafsu->option)?($data->tb->penurunan_nafsu->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->penurunan_nafsu->option)?($data->tb->penurunan_nafsu->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">9</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Pembesaran kelenjer getah gening (benjolan di leher)</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->pembesaran->option)?($data->tb->pembesaran->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->pembesaran->option)?($data->tb->pembesaran->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">10</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Keluarga/tetangga pernah sakit paru paru (TB)</td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->keluarga->option)?($data->tb->keluarga->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->tb->keluarga->option)?($data->tb->keluarga->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
            </table>
            <span>2. SKRINING COVID -19</span>
            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">No</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Gejala </td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">YA</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">TIDAK</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">1</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Demam (Suhu > 38 C)</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->demam->option)?($data->covid->demam->option == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->demam->option)?($data->covid->demam->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">2</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Batuk lebih dari 2 minggu</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->batuk->option)?($data->covid->batuk->option == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->batuk->option)?($data->covid->batuk->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">3</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Sesak nafas</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->sesak_nafas->option)?($data->covid->sesak_nafas->option == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->covid->sesak_nafas->option)?($data->covid->sesak_nafas->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
            </table>
            <span>3. PENILAIAN /PENGKAJIAN PASIEN RESIKO JATUH</span><br>
            <span>1. Pengkajian</span>
            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">No</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Penilaian/pengkajian</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">YA</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">TIDAK</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">1</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Cara Berjalan (salah satu atau lebih) <br>
                    a. Tidak seimbang/sempoyongan/limbung<br>
                    b. Jalan dengan menggunakan alat bantu(kruk, tripot, kursi roda, oranglain)
                     </td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->pengkajian->cara_berjalan->option)?($data->pengkajian->cara_berjalan->option == "ya" ? "✓" : ""):'';?></td>
                   <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->pengkajian->cara_berjalan->option)?($data->pengkajian->cara_berjalan->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">2</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Menopang saat akan duduk : tampak memegang pinggiran<br>
                    kursi atau meja/benda lain sebagai penopang saat akan duduk.
                    </td>
                     <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->pengkajian->menopang->option)?($data->pengkajian->menopang->option == "ya" ? "✓" : ""):'';?></td>
                     <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->pengkajian->menopang->option)?($data->pengkajian->menopang->option == "tidak" ? "✓" : ""):'';?></td>
                </tr>
            </table>
            <span>2. Hasil</span>
            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">No</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Hasil</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Penilaian/pengkajian</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Keterangan</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">1</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Tidak beresiko</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Tidak ditemukan a & b</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;"><?= isset($data->hasil->demam->keterangan)?$data->hasil->demam->keterangan:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">2</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Risiko rendah</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Ditemukan salah satu dari a/b</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;"><?= isset($data->hasil->batuk->keterangan)?$data->hasil->batuk->keterangan:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">3</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Risiko tinggi</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Ditemukan a & b</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;"><?= isset($data->hasil->sesak_nafas->keterangan)?$data->hasil->sesak_nafas->keterangan:'' ?></td>
                </tr>
            </table>
            <span>3. Tindakan</span>
            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">No</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Hasil kajian</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Tindakan</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Ya</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Tidak</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">TTD dan <br> Nama petugas</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">1</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Tidak beresiko</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Tidak ada tindakan</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;text-align:center"><?php echo isset($data->question1->tidak_beresiko->keterangan)?($data->question1->tidak_beresiko->keterangan == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;text-align:center"><?php echo isset($data->question1->tidak_beresiko->keterangan)?($data->question1->tidak_beresiko->keterangan == "tidak" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;"><img src="<?= isset($data->question1->tidak_beresiko->ttd1)?$data->question1->tidak_beresiko->ttd1:'' ?>" alt="img" height="20px" width="40px"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">2</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Risiko rendah</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;">Edukasi</td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;text-align:center"><?php echo isset($data->question1->risiko_rendah->keterangan)?($data->question1->risiko_rendah->keterangan == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;text-align:center"><?php echo isset($data->question1->risiko_rendah->keterangan)?($data->question1->risiko_rendah->keterangan == "tidak" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;"><img src="<?= isset($data->question1->risiko_rendah->ttd1)?$data->question1->risiko_rendah->ttd1:'' ?>" alt="img" height="20px" width="40px"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">3</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Risiko tinggi</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;">Pasang pita kuning dan edukasi</td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->question1->risiko_tinggi->keterangan)?($data->question1->risiko_tinggi->keterangan == "ya" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px;text-align:center"><?php echo isset($data->question1->risiko_tinggi->keterangan)?($data->question1->risiko_tinggi->keterangan == "tidak" ? "✓" : ""):'';?></td>
                    <td style="border: 1px solid black; padding: 2px; font-size:12px;"><img src="<?= isset($data->question1->risiko_tinggi->ttd1)?$data->question1->risiko_tinggi->ttd1:'' ?>" alt="img" height="20px" width="40px"></td>
                </tr>
            </table>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p>Petugas</p>
                <br>
                <span>(_____)</span>
            </div>
            </div>
        </div>
    </div>

    </body>
</html>