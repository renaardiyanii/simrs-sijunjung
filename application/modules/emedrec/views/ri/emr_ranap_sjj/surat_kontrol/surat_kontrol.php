<?php
$data = isset($surat_kontrol->formjson)?json_decode($surat_kontrol->formjson):'';
// var_dump($data_iri->tgl_masuk);die();
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
               
                <tr>
                     <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="70px" style="padding-bottom: 4px;">
                    </td>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RUMAH SAKIT UMUM DAERAH AHMAD SYAFI'I MA'ARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Website :rsud.sijunjung.go.id E-mail : rsudsijunjung1@gmail.com</label>
                    </td>
                     
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black; margin-top: 2px;"></div>
        <H2><center><u>SURAT KONTROL PASIEN</u></center></H2>

        <table border="0" width="100%" cellpadding="2px" style="margin-top:0px; font-size:10px;">
           <tr>  
                <td style="border: 0px solid black; width: 20%;">Nama</td> 
                <td style="border: 0px solid black; width: 30%;">: <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>  
                <td style="border: 0px solid black; width: 20%;">Umur</td> 
                <?php
                    $umur = '';
                    if (isset($data_pasien[0]->tgl_lahir) && !empty($data_pasien[0]->tgl_lahir)) {
                        // Ambil hanya tanggal (tanpa jam)
                        $tgl_lahir_str = substr($data_pasien[0]->tgl_lahir, 0, 10); // potong jadi "YYYY-MM-DD"
                        
                        $tgl_lahir = new DateTime($tgl_lahir_str);
                        $today = new DateTime(date('Y-m-d')); // hari ini, hanya tanggal
                        $diff = $today->diff($tgl_lahir);
                        
                        $umur = $diff->y . ' tahun ' ;
                    }
                    ?>
                <td style="border: 0px solid black; width: 30%;">: <?= $umur ?></p>
                </td>
            </tr> 
             <tr>  
                <td style="border: 0px solid black; width: 20%;">Tgl Masuk</td> 
                <td style="border: 0px solid black; width: 30%;">: <?= isset($data_iri[0]['tgl_masuk']) ? $data_iri[0]['tgl_masuk'] : '' ?></td>  
                <td style="border: 0px solid black; width: 20%;">Status Bayar</td> 
                <td style="border: 0px solid black; width: 30%;">:  <?= isset($data_iri[0]['carabayar']) ? $data_iri[0]['carabayar'] : '' ?></td>
            </tr> 
             <tr>  
                <td style="border: 0px solid black; width: 20%;">Tgl Keluar</td> 
                <td style="border: 0px solid black; width: 30%;">:  <?= isset($data_iri[0]['tgl_keluar']) ? $data_iri[0]['tgl_keluar'] : '' ?></td>  
            </tr> 
             <tr>  
                <td style="border: 0px solid black; width: 20%;">Alamat</td> 
                <td style="border: 0px solid black; width: 30%;">: <?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'' ?></td>  
            </tr> 
             
    </table>
    <br>
    <span style="font-size: 13px;"> Ringkasan Riwayat Penyakit  :</span><br>
    <span style="font-size: 13px;"> <?= isset($data->question1) ? nl2br($data->question1) : '' ?></span><br>
    <span style="font-size: 13px;"> Anjuran / Rencana kontrol :<br>
    <span style="font-size: 13px;"></span> <?= isset($data->question2)? nl2br($data->question2) :'' ?> </span><br>
     <span style="font-size: 13px;"> Hasil Pemeriksaan :</span><br>
    <span style="font-size: 13px;">- Penujang : <?= isset($data->question3)?$data->question3:'' ?></span><br><br>
    <span style="font-size: 13px;">- Diagnosa Medis : <?= isset($data->question4)?$data->question4:'' ?></span><br><br>
    <span style="font-size: 13px;">- Terapi : <?= isset($data->question4)?$data->question4:'' ?></span><br><br><br>

            <div style="display: inline; position: relative;">
                    
                   <div style="float: right; margin-top: 15px;">
                        <p style="font-size: 13px;">DPJP</p>
                        <?php 
                            $id1 = isset($surat_kontrol->id_pemeriksa) ? $surat_kontrol->id_pemeriksa : null; 

                            $query1 = null;
                            if (!empty($id1)) {
                                $query1 = $this->db->query("SELECT ttd, name FROM hmis_users WHERE userid = '$id1'")->row();
                            }
                        ?>
                        <?php if ($query1): ?>
                            <img src="<?= $query1->ttd ?>" alt="ttd" height="100px" width="100px"><br>
                            (<?= $query1->name ?>)<br>
                        <?php else: ?>
                            <p style="font-size: 12px; color: red;">TTD atau nama tidak ditemukan</p>
                        <?php endif; ?>
                    </div>
                    
                </div>
    </div>
</body>

</html>
