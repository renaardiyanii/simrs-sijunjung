<?php
$data = (isset($ceklis->formjson)?json_decode($ceklis->formjson):null);
// var_dump($data);
function listIsian($isian,$checked="")
{
    return '<tr>
    <td><li>'.$isian.'</li></td>
    <td><input type="checkbox" name="" id="" '.($checked==1?"checked":'').'></td>
    <td><input type="checkbox" name="" id="" '.($checked==0?"checked":'').'></td>
</tr>';
}

function linespacing($judul)
{
    return '<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td class="judul-textnya">'.$judul.'</td>
    <td></td>
    <td></td>
</tr>
    ';
}
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       .data {
            margin-left:8em;
            font-size: 11px;
        }
        .data td{
            border:1px solid black;
            padding:2px;
            text-align:center;
        }

        .block-space{
            padding-left:2em;
        }
        .judul-textnya{
            font-size:11pt;
            font-weight:bold;
            text-align:'left';
        }
        td{
            padding:2px;
        }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>

            <hr color="black">

            <p align="center" style="font-weight:bold;font-size:16px">CEKLIS PASIEN DENGAN PERENCANAAN PEMULANGAN PASIEN</p>
            <div>
                <table border='1' width="100%">
                    <tr>
                        <td class="judul-textnya">Kondisi Pasien</td>
                        <td>YA</td>
                        <td>TIDAK</td>
                    </tr>
                    <?= listIsian('Pasien lansia dengan kelemahan fisik',(isset($data->kondisi_pasien[0]->pasien_lansia_dengan_kelemahan)?$data->kondisi_pasien[0]->pasien_lansia_dengan_kelemahan == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien stunting',(isset($data->kondisi_pasien[0]->pasien_stunting)?$data->kondisi_pasien[0]->pasien_stunting == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien yang memerlukan perawatan khusus<br>(makanan melalui sonde, perawatan keter,drain)',(isset($data->kondisi_pasien[0]->pasien_yang_memerlukan)?$data->kondisi_pasien[0]->pasien_yang_memerlukan == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien vegetatif',(isset($data->kondisi_pasien[0]->pasien_vegetatif)?$data->kondisi_pasien[0]->pasien_vegetatif == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien perawatan paliatif (hospis)',(isset($data->kondisi_pasien[0]->pasien_perawatan_paliatif)?$data->kondisi_pasien[0]->pasien_perawatan_paliatif == 'ya'?1:0:null))?>
                    <?= linespacing('GANGGUAN AKTIVITAS SEHARI-HARI') ?>
                    <?= listIsian('Pasca Stroke', (isset($data->gangguan_aktivitas[0]->pasca_stroke)?$data->gangguan_aktivitas[0]->pasca_stroke == 'ya'?1:0:null))?>
                    <?= listIsian('Pasca operasi tulang belakang',(isset($data->gangguan_aktivitas[0]->pasca_operasi_tulang_belakang)?$data->gangguan_aktivitas[0]->pasca_operasi_tulang_belakang == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasca operasi daerah panggul',(isset($data->gangguan_aktivitas[0]->{'Pasca Operasi daerah Panggul'})?$data->gangguan_aktivitas[0]->{'Pasca Operasi daerah Panggul'} == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasca operasi colum femoris',(isset($data->gangguan_aktivitas[0]->pasca_operasi_colum_femoris)?$data->gangguan_aktivitas[0]->pasca_operasi_colum_femoris == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasca luka bakar > 30 %',(isset($data->gangguan_aktivitas[0]->pasca_luka_bakar)?$data->gangguan_aktivitas[0]->pasca_luka_bakar == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasca operasi besar dengan gangguan aktivitas',(isset($data->gangguan_aktivitas[0]->pasca_operasi_besar_dengan_gangguan_aktivitas)?$data->gangguan_aktivitas[0]->pasca_operasi_besar_dengan_gangguan_aktivitas == 'ya'?1:0:null)) ?>
                    <?= linespacing('BANTUAN ASUHAN/PENGOBATAN') ?>
                    <?= listIsian('Perawatan luka yang luas atau posisi sulit',(isset($data->bantuan_asuhan_pengobatan[0]->perawatan_luka_yang_luas)?$data->bantuan_asuhan_pengobatan[0]->perawatan_luka_yang_luas == 'ya'?1:0:null)) ?>
                    <?= listIsian('Perawatan luka operasi',(isset($data->bantuan_asuhan_pengobatan[0]->perawatan_luka_operasi)?$data->bantuan_asuhan_pengobatan[0]->perawatan_luka_operasi == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pemberian terapi (misalnya insulin)',(isset($data->bantuan_asuhan_pengobatan[0]->pemberian_terapi)?$data->bantuan_asuhan_pengobatan[0]->pemberian_terapi == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien lansia dengan dementia',(isset($data->bantuan_asuhan_pengobatan[0]->pasien_lansia)?$data->bantuan_asuhan_pengobatan[0]->pasien_lansia == 'ya'?1:0:null)) ?>
                    <?= listIsian('Pasien anak',(isset($data->bantuan_asuhan_pengobatan[0]->pasien_anak)?$data->bantuan_asuhan_pengobatan[0]->pasien_anak == 'ya'?1:0:null)) ?>
                    <?= listIsian('Variasi rute pemberian',(isset($data->bantuan_asuhan_pengobatan[0]->variasi_rute)?$data->bantuan_asuhan_pengobatan[0]->variasi_rute == 'ya'?1:0:null)) ?>
                    <?= listIsian('Variasi aturan pakai',(isset($data->bantuan_asuhan_pengobatan[0]->variasi_aturan_pakai)?$data->bantuan_asuhan_pengobatan[0]->variasi_aturan_pakai == 'ya'?1:0:null)) ?>
                    <?= listIsian('Cara pemberian khusus (contoh : inhalasi rektal)' ,(isset($data->bantuan_asuhan_pengobatan[0]->cara_pemberian_khusus)?$data->bantuan_asuhan_pengobatan[0]->cara_pemberian_khusus == 'ya'?1:0:null))?>
                </table>
            </div>
            <br><br><br>
            <span style="font-size:8pt">Bukittinggi , <?= isset($ceklis->tgl_input)? date('d-m-Y',strtotime($ceklis->tgl_input)):''; ?></span><br>
            <span style="font-size:8pt;margin-left:20px;">MPP</span><br>
            <img width="80px" src="<?= $ceklis->ttd ?>" alt=""><br>
            <span style="font-size:8pt">(<?= $ceklis->nama_pemeriksa ?>)</span>
            
            <br><br><br><br><br><br><br><br><br><br>    
            <p style="text-align:right;font-size:12px">1</p>
        </div>

    </body>
</html>