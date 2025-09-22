<?php 
$data = isset($ringkasan_keluar->formjson)?json_decode($ringkasan_keluar->formjson):'';
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
<div class="A4 sheet  padding-fix-10mm">
    <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="28%">1. Tanggal Kunjungan</td>
                            <td width="2%">:</td>
                            <td width="20%"><?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></td>
                            <td width="18%">Poliklinik</td>
                            <td width="2%">:</td>
                            <td width="30%"><?= isset($data_daftar_ulang->namapoli)?$data_daftar_ulang->namapoli:'' ?></td>
                        </tr>
                        <tr>
                            <td>Cara Bayar</td>
                            <td>:</td>
                            <td><?= isset($data_daftar_ulang->cara_bayar)?$data_daftar_ulang->cara_bayar:'' ?></td>
                        </tr>
                    </table> 
                </td>
                
            </tr>
            <?php 
            ?>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">2. ANAMNESA :
                                <div style="min-height:30px">
                                    <?= isset($data->question2)?$data->question2:'' ?>
                                </div>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">3. DIAGNOSA UTAMA :
                                <div style="min-height:30px">
                                    <?= isset($data->diagnosa)?$data->diagnosa:'' ?>
                                </div>
                            </td>

                            <td width="70%">ICD-10 :
                                <div style="min-height:30px">
                                </div>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">4. DIAGNOSA SEKUNDER :
                                <div style="min-height:50px">
                                    <?= isset($data->diagnosa_sekunder)?$data->diagnosa_sekunder:'' ?>
                                </div>
                            </td>

                            <td width="70%">ICD-10 :
                                <div style="min-height:30px">
                                </div>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
       
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">5. TINDAKAN YANG DILAKUKAN :
                                <div style="min-height:50px">
                                    <?= isset($data->tindakan)? str_replace("-","<br>",$data->tindakan):'' ?>
                                </div>
                            </td>
                            <td>KODE ICD-9 
                                <div style="min-height:30px">
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">6. TERAPI YANG DIBERIKAN :
                                <div style="min-height:50px">
                                    <?= isset($data->question3)?str_replace("-","<br>",$data->question3):'' ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="70%">7. ANJURAN / RENCANA / KONTROL SELANJUTNYA :
                                <div style="min-height:30px">
                                <p><?= isset($data->anjuran)?$data->anjuran:'' ?></p>
                                </div>
                            </td>
                            <td> </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td>

                <div style="display: inline; position: relative;">
                    
                    
                    <div style="float: right;margin-top: 15px;font-size:12px; margin-right: 20px">
                            <p>Tanggal, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?> Jam <?= isset($data_daftar_ulang->tgl_kunjungan)?date('h:i',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Dokter Penanggung Jawab </p>
                            <br><br><br>
                            <?php 
                                $id1 = isset($ringkasan_keluar->id_pemeriksa) ? $ringkasan_keluar->id_pemeriksa : null;                                    
                                $query1 = $id1 ? $this->db->query("SELECT ttd, name FROM hmis_users WHERE hmis_users.userid = $id1")->row() : null;

                                // ID poli yang ingin diperiksa
                                $id_poli = isset($data_daftar_ulang->id_poli) ? $data_daftar_ulang->id_poli : null;
                                // var_dump($id_poli);die();
                                // Nama dokter
                                $nama_dokter_meyko = "dr Meyko ravelino Tulalo, Sp.KFR";
                                $current_user_name = isset($query1->name) ? $query1->name : '';

                                // Kondisi untuk menampilkan nama dokter
                                if ($id_poli === "CE00") {
                                    // Jika ID poli adalah CE00
                                    echo "<span>($nama_dokter_meyko)</span><br>";
                                } else {
                                    // Jika tidak, tampilkan nama user yang login
                                    echo "<span>($current_user_name)</span><br>";
                                }
                                ?>

                           
                    </div> 
            </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


            
        
    </div>
   


</body>

</html>