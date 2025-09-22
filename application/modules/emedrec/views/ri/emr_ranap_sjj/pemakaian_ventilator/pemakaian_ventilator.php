<?php 
$data = isset($ventilator->formjson)?json_decode($ventilator->formjson):'';

// var_dump($data);die();
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
                <h3><center>PEMAKAIAN VENTILATOR</center></h3>
             
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">DIAGNOSIS  PRIMER : 
                            <br> <?= isset($data->question1)?nl2br($data->question1):'' ?><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">DIAGNOSIS  SEKUNDER
                            <br><?= isset($data->question2)?nl2br($data->question2):'' ?><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">TINDAKAN  :
                            <br><?= isset($data->question3)?nl2br($data->question3):'' ?><br><br>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2">PEMAKAIAN  VENTILATOR
                             <br><br><br>
                        </td>
                        
                    </tr>
                    <tr>
                        <td width="30%">INTUBASI</td>
                        <td width="70%">:Tanggal :<?= isset($data->question4->{'Row 1'}->{'Column 1'})?$data->question4->{'Row 1'}->{'Column 1'}:'' ?> Jam :<?= isset($data->question4->{'Row 1'}->{'Column 2'})?$data->question4->{'Row 1'}->{'Column 2'}:'' ?></td>
                    </tr>
                      <tr>
                        <td width="30%">EKSTUBASI</td>
                        <td width="70%">:Tanggal : <?= isset($data->question4->{'Row 2'}->{'Column 1'})?$data->question4->{'Row 2'}->{'Column 1'}:'' ?> Jam : <?= isset($data->question4->{'Row 2'}->{'Column 2'})?$data->question4->{'Row 2'}->{'Column 2'}:'' ?></td>
                    </tr>
                </table>
               
                <!-- Container untuk posisi horizontal -->
                    <div style="display: flex; justify-content: space-between; text-align: center;">

                    <!-- Dokter 2 (Kiri) -->
                    <div style="width: 45%;">
                        <p><br></p>
                        <p>DPJP 1</p>
                        <?php
                    $id_dokter = isset($data->question9) ? $data->question9 : null;
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

                    <!-- Dokter 3 (Kanan) -->
                    <div style="width: 45%;">
                        <p><br></p>
                        <p>DPJP 2</p>
                        
                        <?php
                        $id_dokter = isset($data->question10) ? $data->question10 : null;
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
                    <div style="width: 45%;">
                        <p><br></p>
                        <p>DPJP 3</p>
                        
                        <?php
                        $id_dokter = isset($data->question5) ? $data->question5 : null;
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
                    <div style="width: 45%;">
                        <p><br></p>
                        <p>DPJP 4</p>
                        
                        <?php
                        $id_dokter = isset($data->question6) ? $data->question6 : null;
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

                    </div>

            </td>
       </tr>
    </table>
    </div>
</body>