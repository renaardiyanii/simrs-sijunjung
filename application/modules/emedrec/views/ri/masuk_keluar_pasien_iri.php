<?php
//  var_dump($data_pasien);
$data_pasien = isset($data_pasien[0])?$data_pasien[0]:null;
$data = (isset($general_consent[0]->formjson)?json_decode($general_consent[0]->formjson):'');
//var_dump($tindakan);
?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            /* border-collapse: collapse; */
            /* border: 1px solid black;     */
            width: 100%;
            /* position: relative; */
            /* text-align: justify;  */
        }

        #data tr td{            
            font-size: 11px;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                RINGKASAN MASUK DAN KELUAR PASIEN RAWAT INAP
            </p>
            <div style="font-size:11px">
                <table style="width: 100%;" id="data"  cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="18%">Alamat </td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
                        <td width="18%"><span style="margin-left:17px">Tanggal Masuk</span></td>
                        <td width="2%">:</td>
                        <td width="30%"><?= isset($data_pasien->tgl_masuk)?date('d-m-Y',strtotime($data_pasien->tgl_masuk)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Jam</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->jam_masuk)?$data_pasien->jam_masuk:'' ?></p></td>
                        <td width="25%"><p style="margin-left:17px">Telepon Rumah</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><?= isset($data_pasien->no_telp)?$data_pasien->no_telp:'' ?></td>
                    </tr>
                    <tr>
                        <td width="25%">Suku Bangsa</td>
                        <td width="2%">:</td>
                        <td width="25%"><?= isset($data_pasien->suku_bangsa)?$data_pasien->suku_bangsa:'' ?></td>
                        <td width="25%"><span  style="margin-left:17px">Telepon Seluler(Hp)</span></td>
                        <td width="2%">:</td>
                        <td width="25%"><?= isset($data_pasien->no_hp)?$data_pasien->no_hp:'' ?></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Kewarganegaraan</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->wnegara)?$data_pasien->wnegara:'' ?></p></td>
                        <td width="25%"><p  style="margin-left:17px">Telepon Kantor</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->no_telp_kantor)?$data_pasien->no_telp_kantor:'' ?></p></td>
                    </tr>
                    <tr>
                        <td width="25%">Cara Bayar</td>
                        <td width="2%">:</td>
                        <td width="25%"><?= isset($data_pasien->carabayar)?$data_pasien->carabayar:'' ?></td>
                        <td width="25%"></td>
                        <td width="2%"></td>
                        <td width="25%"></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Status Pasien</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien_kedua->jns_kunj)?$data_pasien_kedua->jns_kunj:'BARU' ?></p></td>
                        <td width="25%"><p><span  style="margin-left:17px">No. KTP/SIM/Pasport</span></p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->no_identitas)?$data_pasien->no_identitas:'' ?></p></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Pekerjaan</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->pekerjaan)?$data_pasien->pekerjaan:'' ?></p></td>
                        <td width="25%"><p  style="margin-left:17px">Agama</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien->agama)?$data_pasien->agama:'' ?></p></td>
                    </tr>
                    <tr>
                        <td width="25%">Kelas Perawatan</td>
                        <td width="2%">:</td>
                        <td width="25%"><?= isset($data_pasien->klsiri)?$data_pasien->klsiri:'' ?></td>
                        <td width="25%" ><span style="margin-left:17px">Status Perkawinan</span></td>
                        <td width="2%">:</td>
                        <td width="25%"><?php
                        switch($data_pasien->status){
                            case 'B':
                                echo 'Belum Kawin';
                                break;
                            case 'K':
                                echo 'Kawin';
                                break;
                            case 'C':
                                echo 'Janda/Duda';
                                break;
                            default:
                                echo '-';
                                break;
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Nama Keluarga Terdekat</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien_kedua->nmpjawabri)?$data_pasien_kedua->nmpjawabri:'' ?></p></td>
                        <td width="25%"><p style="margin-left:17px">Hubungan Keluarga</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien_kedua->hubpjawabri)?$data_pasien_kedua->hubpjawabri:'' ?></p></td>
                    </tr>
                    <tr>
                        <td width="25%">Alamat </td>
                        <td width="2%">:</td>
                        <td width="25%"><?= isset($data_pasien_kedua->alamatpjawabri)?$data_pasien_kedua->alamatpjawabri:'' ?></td>
                        <td width="25%"><span  style="margin-left:17px">Telepon Seluler </span></td>
                        <td width="2%">:</td>
                        <td width="25%"></td>
                    </tr>
                    <tr>
                        <td width="25%"><p>Perhatian Khusus</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"><p><?= isset($data_pasien_kedua->kekhususan)?$data_pasien_kedua->kekhususan:'' ?></p></td>
                        <td width="25%"><p style="margin-left:17px">Alergi Obat </p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="25%"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="6"><p><b>Diagnosa Masuk&Kode ICD-10</b></p></td>
                        
                    </tr>
                    <?php   
                                    $jml_diag = isset($diagnosa_masuk)?count($diagnosa_masuk):'';
                                    for ($x = 0; $x < $jml_diag; $x++) {
                                ?>
                                     <tr>
                                        <td colspan ="4" ><li><?= isset($diagnosa_masuk[$x]->diagnosa)?$diagnosa_masuk[$x]->diagnosa:''; ?></li></td>
                                        <td colspan="2"><?= isset($diagnosa_masuk[$x]->id_diagnosa)?'('.$diagnosa_masuk[$x]->id_diagnosa.')':''; ?></td>
                                    </tr>
                                <?php } ?>
                    
                    <tr>
                        <td><p>Dokter yang merawat</p></td>
                        <td width="2%"><p>:</p></td>
                        <td colspan="4"><p><?= isset($data_pasien_kedua->nm_dokter_dpjp)?$data_pasien_kedua->nm_dokter_dpjp:'' ?></p></td>
                    </tr>
                    <tr>
                        <td>Lama dirawat</td>
                        <td>:</td>
                        <td colspan="4"><?= isset($lama)?$lama:'-' ?> Hari</td>
                    </tr>
                    <tr>
                        <td colspan="6"><p><b>Diagnosa Keluar&Kode ICD-10</b></p></td>
                        
                    </tr>
                    <tr>
                        <td colspan = "4"><li><?= isset($diagnosa_utama[0]->diagnosa)?$diagnosa_utama[0]->diagnosa:''; ?></li></td>
                        <td colspan="2"><?= isset($diagnosa_utama[0]->id_diagnosa)?'('.$diagnosa_utama[0]->id_diagnosa.')':''; ?></td>
                    </tr>
                    <?php   
                            $jml = isset($diagnosa)?count($diagnosa):'';
                            for ($x = 0; $x < $jml; $x++) {
                        ?>
                            <tr>
                                <td colspan = "4"><li><?= isset($diagnosa[$x]->diagnosa)?$diagnosa[$x]->diagnosa:''; ?></li></td>
                                <td colspan="2"><?= isset($diagnosa[$x]->id_diagnosa)?'('.$diagnosa[$x]->id_diagnosa.')':''; ?></td>
                            </tr> 
                        <?php } ?>
                    <!-- <tr>
                        <td colspan="6"><p>Tindakan</p></td>
                    </tr> -->
                    <tr>
                        <td colspan="6" ><p><b>Nama Tindakan & kode ICD-9</p></b></td>
                        
                    </tr>
                    <?php   
                                    $jml_tind = isset($tindakan)?count($tindakan):'';
                                    for ($x = 0; $x < $jml_tind; $x++) {
                                ?>
                                     <tr>
                                       
                                        <td colspan = "4"><li><?= isset($tindakan[$x]->nm_procedure)?$tindakan[$x]->nm_procedure:''?></li></td>
                                        <td colspan="2">ICD 9 : <?= isset($tindakan[$x]->id_procedure)?$tindakan[$x]->id_procedure:'' ?></td>
                                    </tr>
                                <?php } ?>
                    <tr><br><br>
                        <td><br><br><p>Golongan Operasi</p></td>
                        <td><br><br><p>:</p></td>
                        <td colspan="4"><br><br>
                            <p>
                                <input type="checkbox" name="" id=""><span>Kecil</span>
                                <input type="checkbox" name="" id=""><span>Sedang</span>
                                <input type="checkbox" name="" id=""><span>Besar</span>
                                <input type="checkbox" name="" id=""><span>Khusus</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td><p>Jenis Anestesi</p></td>
                        <td><p>:</p></td>
                        <td colspan="4">
                            <p>
                            <input type="checkbox" name="" id=""><span>Lokal</span>
                            <input type="checkbox" name="" id=""><span>Umum</span>
                            <input type="checkbox" name="" id=""><span>Regional</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td><p>Infeksi Nosokomial</p></td>
                        <td><p>:</p></td>
                        <td colspan="4">
                            <p>
                                <input type="checkbox" name="" id=""><span>Ya</span>
                                <input type="checkbox" name="" id=""><span>Tidak</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td><p>Penyebab Infeksi</p></td>
                        <td><p>:</p></td>
                        <td colspan="4"><p></p></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>Keadaan Keluar</p>
                            <p>
                            <p><input type="checkbox" class="text-body" value="perbaikan" <?php echo ($pasien->status_pulang=='PERBAIKAN' ? 'checked' : 'disabled') ?>><span class="text-body" for="perbaikan">Perbaikan</span></p>
                            <input type="checkbox" class="text-body" value="sembuh" <?php echo ($pasien->status_pulang=='PULANG' ? 'checked' : 'disabled') ?>><span class="text-body" for="sembuh">Sembuh</span>
                            <p><input type="checkbox" class="text-body" value="blm_sembuh" <?php echo ($pasien->status_pulang=='BELUM_SEMBUH' ? 'checked' : 'disabled') ?>><span class="text-body" for="blm_sembuh">Belum Sembuh</span><p>
                            <input type="checkbox" class="text-body" value="meninggal_krg_48" <?php echo ($pasien->status_pulang=='MENINGGALKRG48' ? 'checked' : 'disabled') ?>><span class="text-body" for="meniggal_krg_48">Meninggal<48Jam</span>
                            <p><input type="checkbox" class="text-body" value="meninggal_lbh_48" <?php echo ($pasien->status_pulang=='MENINGGALLBH48' ? 'checked' : 'disabled') ?>><span class="text-body" for="meniggal_lbh_48">Meninggal>=48Jam</span></p>
                            </p>
                        </td>
                        <td>
                            <p>Cara Keluar</p>
                            <p>
                            <p><input type="checkbox" class="text-body" value="izin_dktr" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "izin_dokter" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="izin_dktr">Izin Dokter</label></p>
                            <p><input type="checkbox" class="text-body" value="rujuk" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "rujuk" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="rujuk">Rujuk</label></p>
                            <p><input type="checkbox" class="text-body" value="aps" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "aps" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="aps">APS</label></p>
                            <p><input type="checkbox" class="text-body" value="pindah" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "pindah_rs" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="pindah">Pindah RS</label></p>
                            </p>
                        </td>
                        <td colspan="3">
                                <p style="text-align:center">Bukittinggi, <?= isset($data_pasien->tgl_keluar)?date('d-m-Y',strtotime($data_pasien->tgl_keluar)):'' ?></p>
                                <p style="text-align:center">Tanda Tangan</p>
                                <center><img src="<?= isset($data_pasien_kedua->ttd_dokter_dpjp)?$data_pasien_kedua->ttd_dokter_dpjp:'' ?>" alt="" width="50px" height="50px"></center>
                                <p style="text-align:center"> <?= isset($data_pasien_kedua->nm_dokter_dpjp)?$data_pasien_kedua->nm_dokter_dpjp:'Dokter Yang Merawat' ?></p>
                                <p style="text-align:center"> <?= isset($data_pasien_kedua->nipeg_dpjp)?$data_pasien_kedua->nipeg_dpjp:'' ?> </p>
                        </td>
                    </tr>
                </table>
            </div><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 2</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
        </div>



        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                RINGKASAN MASUK DAN KELUAR PASIEN RAWAT INAP
            </p>
            <div style="font-size:11px">
                <div style="min-height:70vh">
                    <table style="width: 100%;"  id="data" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="18%">Nama Perusahaan/ Penanggung Jawab Biaya</td>
                                <td width="2%" style="text-align:center">:</td>
                                <td colspan="4"><?= isset($data->question23->nama)?$data->question23->nama:'' ?></td>
                            </tr>
                            <tr>
                                <td width="18%"><p>Alamat Penanggung Jawab Biaya</p></td>
                                <td width="2%" style="text-align:center"><p>:</p></td>
                                <td colspan="4"><?= isset($data->question23->alamat)?$data->question23->alamat:'' ?></td>
                            </tr>
                            <tr>
                                <td width="18%">Telepon / HP</td>
                                <td width="2%" style="text-align:center">:</td>
                                <td width="30%"><?= isset($data->question23->no_hp)?$data->question23->no_hp:'' ?></td>
                                <td width="18%">Yang dihubungi</td>
                                <td width="2%">:</td>
                                <td width="30%"><?= isset($data->question23->hub)?$data->question23->hub:'' ?></td>
                            </tr>
                            <tr>
                                <td width="18%"><p>Nomor Asuransi</p></td>
                                <td width="2%" style="text-align:center"><p>:</p></td>
                                <td width="30%"></td>
                                <td width="18%"><p>Keterangan</p></td>
                                <td width="2%"><p>:</p></td>
                                <td width="30%"></td>
                            </tr>
                            <tr>
                                <td width="18%">Surat Jaminan</td>
                                <td width="2%" style="text-align:center">:</td>
                                <td colspan="4">
                                        <input type="checkbox" name="" id=""><span>Ya</span>
                                        <input type="checkbox" name="" id=""><span>Tidak</span> 
                                </td>
                                <td width="18%"></td>
                                <td width="2%"></td>
                                <td width="30%"></td>
                            </tr>
                            
                    </table>
                </div>
               
                <table>
                <tr>
                    <td width="30%">
                        <p style="text-align:center">Bukittinggi, <?= isset($general_consent[0]->tgl_input)?date('d-m-Y',strtotime($general_consent[0]->tgl_input)):'' ?></p>
                        <p style="text-align:center">Tanda Tangan</p>
                      
                        <?php
                        if(isset($data->ttd_pasien)){
                        ?>
                        <img width="120px" src="<?= $data->ttd_pasien ?>" alt="">
                        <?php }else{ ?>
                            <br><br><br>
                            <?php } ?>
                       
                        <p style="text-align:center"><?= isset($data_pasien_kedua->nmpjawabri)?$data_pasien_kedua->nmpjawabri:'' ?></p>
                    </td>
                    <td width="50%">

                    </td>
                   
                    <td width="20%">
                        <p style="text-align:center">Bukittinggi, <?= isset($general_consent[0]->tgl_input)?date('d-m-Y',strtotime($general_consent[0]->tgl_input)):'' ?></p>
                        <p style="text-align:center">Tanda Tangan</p>
                        <?php
                        if(isset($general_consent[0]->ttd_pemeriksa)){
                        ?>
                        <img width="120px" src="<?= $general_consent[0]->ttd_pemeriksa ?>" alt="">
                        <?php }else{ ?>
                            <br><br><br>
                            <?php } ?>
                        <span></span><br>
                        <p style="text-align:center"><?= isset($general_consent[0]->nm_pemeriksa)?$general_consent[0]->nm_pemeriksa:'' ?></p>
                    </td>
                </tr>
                </table>
            </div><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 2 dari 2</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div>
        </div>

    </body>
</html>