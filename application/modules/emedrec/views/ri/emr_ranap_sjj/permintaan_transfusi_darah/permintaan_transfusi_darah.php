<?php 
$data = isset($permintaan->formjson)?json_decode($permintaan->formjson):'';
//  var_dump($data);die;
?>


<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><center>PERMINTAAN TRANSFUSI DARAH</center></h3>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Rumah sakit : <?= isset($data->question1->text1)?nl2br($data->question1->text1):'' ?></td>
                        <td>Bag : <?= isset($data->question1->text2)?nl2br($data->question1->text2):'' ?></td>
                        <td>Kelas : <?= isset($data->question1->text3)?nl2br($data->question1->text3):'' ?></td>
                    </tr>
                    <tr>
                        <td>Dr. yang meminta </td>
                        <td colspan="2">: <?= isset($data->question2->text1)?nl2br($data->question2->text1):'' ?></td>
                    </tr>
                    <tr>
                        <td>No Rekam Medis </td>
                        <td colspan="2">: <?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                    </tr>
                    <tr>
                        <td>Nama OS </td>
                        <td colspan="2">: <?= isset($data->question2->text3)?nl2br($data->question2->text3):'' ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td colspan="2">: <?php
                        if (isset($data_pasien[0]->tgl_lahir)) {
                            $tahun_lahir = date('Y', strtotime($data_pasien[0]->tgl_lahir));
                            $tahun_sekarang = date('Y');
                            $umur = $tahun_sekarang - $tahun_lahir;
                            echo $umur . " tahun";
                        } else {
                            echo "Tanggal lahir tidak tersedia";
                        }
                        ?>

                            </td>
                    </tr>
                    <tr>
                        <td>Jenis kelamin </td>
                        <td colspan="2"> : <?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat </td>
                        <td colspan="2">: <?= isset($data->question2->text6)?nl2br($data->question2->text6):'' ?></td>
                    </tr>
                    <tr>
                        <td>Diagnosa (sementara) </td>
                        <td colspan="2">: <?= isset($data->question2->text7)?$data->question2->text7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Indikasi Tegas </td>
                        <td colspan="2">: <?= isset($data->question2->text8)?$data->question2->text8:'' ?></td>
                    </tr>
                    <tr>
                        <td>Diperlukan tanggal </td>
                          <td colspan="2">: <?= isset($data->question2->text9)?$data->question2->text9:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Trasf. sebelumnya</td>
                           <td colspan="2">: <?= isset($data->question2->text10)?$data->question2->text10:'' ?> Kapan : <?= isset($data->question2->text11)?$data->question2->text11:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Untuk OS Wanita</td>
                    </tr>
                    <tr>
                        <td>Pernah hamil </td>
                        <td colspan="2">: <?= isset($data->question3->text1)?$data->question3->text1:'' ?> Abortus  : <?= isset($data->question3->text2)?$data->question3->text2:'' ?> Partus  : <?= isset($data->question3->text3)?$data->question3->text3:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Jenis Darah yang diperlukan</td>
                       
                    </tr>
                    <tr>
                        <td>1. Whole Blood </td>
                        <td colspan="2">: <?= isset($data->question4->text1)?$data->question4->text1:'' ?> cc</td>
                    </tr>
                    <tr>
                        <td>2. Packed Red Cells </td>
                        <td colspan="2">: <?= isset($data->question4->text2)?$data->question4->text2:'' ?> Unit</td>
                    </tr>
                    <tr>
                        <td>3. Liquid Plasma </td>
                        <td colspan="2">: <?= isset($data->question4->text3)?$data->question4->text3:'' ?> Unit</td>
                    </tr>
                    <tr>
                        <td>4. Trombosit</td>
                        <td colspan="2">: <?= isset($data->question4->text4)?$data->question4->text4:'' ?> Unit</td>
                    </tr>
                    <tr>
                        <td>5. FFP </td>
                        <td colspan="2">: <?= isset($data->question4->text5)?$data->question4->text5:'' ?> Unit</td>
                    </tr>
                    <tr>
                        <td>Hal lainnya</td>
                        <td colspan="2">: <?= isset($data->question5)?$data->question5:'' ?> </td>
                    </tr>
                </table><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang ,  <?= isset($permintaan->tgl_input)?date('d/m/Y h:i',strtotime($permintaan->tgl_input)):'' ?></p>
                                <p><br></p>
                                <p>Tanda tangan Dokter</p>
                                <?php
                                $id_dokter = isset($data->question20) ? $data->question20 : null;
                                // var_dump($data->question17);die();
                                $id_dokter1 = null;
                                $dokter = null;

                                // Pastikan $id_dokter adalah string dulu
                                if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                    $parts = explode('-', $id_dokter);
                                    if (isset($parts[1])) {
                                        $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                        if (!empty($id_dokter1)) {
                                            $query = $this->db->query("SELECT a.name, a.ttd 
                                                FROM hmis_users a
                                                JOIN dyn_user_dokter b ON a.userid = b.userid
                                                WHERE b.id_dokter = '$id_dokter1'");
                                            $dokter = $query->row();
                                        }
                                    }
                                }
                                ?>

                                <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                                <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                            </div>
                        </div><br>
                <p>Catatan :</p>
                <p>-Harap diisi dengan lengkap</p>
                <p>-Yang tidak diisi dengan lengkap akan dikembalikan</p>
            </td>
       </tr>
    </table>
    </div>
</body>