<?php
$data = isset($lap_pembedahan->formjson)?json_decode($lap_pembedahan->formjson):'';
//  var_dump($data);die();
?>
<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>LAPORAN PEMBEDAHAN</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 1</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%"><p>Tanggal Pemindahan : <?= isset($data->question1)?date('d-m-Y',strtotime($data->question1)):'' ?></p></td>
                                <td><p>Jam : <?= isset($data->question1) ? date('H:i', strtotime($data->question1)) : '' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="40%"><p>Ahli bedah : <?= isset($data->question2->ahli)?$data->question2->ahli:'' ?></p></td>
                                <td><p>Asisten : <?= isset($data->question2->asisten)?$data->question2->asisten:'' ?></p></td>
                                <td><p>Instrumentator : <?= isset($data->question2->instrumenator)?$data->question2->instrumenator:'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td>
                    <span>Macam Pembedahan :</span>
                    <input type="checkbox"  value=""<?php echo isset($data->question3)?(in_array("kecil", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Kecil</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("sedang", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Sedang</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("besar", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Besar</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("khusus1", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Khusus 1</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("khusus2", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Khusus 2</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("gawat_darurat", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Gawat darurat</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("berencana", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Berencana</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("bersih", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Bersih</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("bersih_tercemar", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Bersih tercemar</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("tercemar", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Tercemar</label>
                    <input type="checkbox"  value="" <?php echo isset($data->question3)?(in_array("kotor", $data->question3) ? "checked" : "disabled"):""; ?>>
                    <label for="sendiri">Kotor</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnosa Pra Bedah : <?= isset($data->question4->diagnosa_pra_bedah)?$data->question4->diagnosa_pra_bedah:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Tindakan Pembedahan : <?= isset($data->question4->tindakan)?$data->question4->tindakan:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnosa Pasca bedah : <?= isset($data->question4->diagnosa_pasca)?$data->question4->diagnosa_pasca:'' ?></span>
                    </td>
                </tr>
            </table>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">Nama Implant</td>
                    <td style="border: 1px solid black; padding: 8px; ">Lokasi pemasangan</td>
                    <td style="border: 1px solid black; padding: 8px; ">Kode Produk / Barcode</td>
                    <td style="border: 1px solid black; padding: 8px; ">Keterangan</td>
                </tr>
                <?php 
                if(isset($data->question5)){
                foreach($data->question5 as $val){ ?>
                    <tr>
                        <td style="border: 1px solid black; padding: 8px; "><?= isset($val->nm_implant)?$val->nm_implant:'' ?></td>
                        <td style="border: 1px solid black; padding: 8px; "><?= isset($val->lokais)?$val->lokais:'' ?></td>
                        <td style="border: 1px solid black; padding: 8px; "><?= isset($val->kode)?$val->kode:'' ?></td>
                        <td style="border: 1px solid black; padding: 8px; "><?= isset($val->keterangan)?$val->keterangan:'' ?></td>
                    </tr>
                <?php  }}
                ?>
                
            </table>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">Ahli Bius</td>
                    <td style="border: 1px solid black; padding: 8px; ">Cara pembiusan</td>
                    <td style="border: 1px solid black; padding: 8px; ">Posisi pasien</td>
                    <td style="border: 1px solid black; padding: 8px; ">Mulai</td>
                    <td style="border: 1px solid black; padding: 8px; ">Selesai</td>
                    <td style="border: 1px solid black; padding: 8px; ">Lama pembedahan <br> Jam & Menit</td>
                    <td style="border: 1px solid black; padding: 8px; ">OK</td>
                </tr>

                <?php 
                if(isset($data->question6)){
                foreach($data->question6 as $value){ ?>

                <tr>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->ahli_bius)?$value->ahli_bius:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->cara_pembiusan)?$value->cara_pembiusan:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->posisi_pasien)?$value->posisi_pasien:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->mulai)?$value->mulai:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->selesai)?$value->selesai:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($value->lama_pembedahan)?$value->lama_pembedahan:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px; "><?php echo isset($value->ok)?(in_array("ok", $value->ok) ? "✓" : "disabled"):""; ?></td>
                </tr>

                <?php  }}
                ?>
            </table>
            <br>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                <tr>
                    <td>
                        <span>URAIAN PEMBEDAHAN :</span>
                    </td>
                </tr>
            </table>
            <div style="min-height:60px">
                <p style="font-size:11px"><?= isset($data->uraian)?$data->uraian:'' ?></p>
            </div>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                <tr>
                    <td>
                        <span>KOMPLIKASI : <?= isset($data->question7->komplikasi)?$data->question7->komplikasi:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>PERDARAHAAN : <?= isset($data->question7->perdarahaan)?$data->question7->perdarahaan:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                    <span>Jaringan di kirim ke patologi :</span>
                    <input type="checkbox"  value="" <?php echo isset($data->jaringan)?($data->jaringan == "tidak" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Tidak</label>
                    <input type="checkbox"  value="" <?php echo isset($data->jaringan)?($data->jaringan == "ya" ? "checked" : "disabled"):'';?>>
                    <label for="sendiri">Ya</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Asal jaringan : <?= isset($data->asjal)?$data->asjal:'' ?></span>
                    </td>
                </tr>
            </table>
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Ahli Bedah</p>
                           
                            <?php 
                            $id1 =isset($lap_pembedahan->id_pemeriksa)?$lap_pembedahan->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                             <img src="<?= $query1->ttd ?>" alt="img" height="50px" width="50px"><br>
                            <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br> 
                           
                    </div>  
                </div>
    </tr>
</table>




</div>
</body>
</html>
