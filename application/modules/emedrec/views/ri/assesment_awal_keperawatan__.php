<?php 

$data = (isset($keperawatan[0]->formjson)?json_decode($keperawatan[0]->formjson):'');
$skor = 0;
$skor2 = 0;
$hari = (isset($data_rawat_darurat[0]->tgl_kunjungan))?date('D',strtotime($data_rawat_darurat[0]->tgl_kunjungan)):'';
// var_dump($data);
switch($hari){
    case 'Fri':
        $hari = 'Jum\'at';
        break;
    case 'Sat':
        $hari = 'Sabtu';
        break;
    case 'Sun':
        $hari = 'Minggu';
        break;
    case 'Mon':
        $hari = 'Senin';
        break;
    case 'Tue':
        $hari = 'Selasa';
        break;
    case 'Wed':
        $hari = 'Rabu';
        break;
    default:
        $hari = 'Kamis';
        break;
}

$skor = isset($data->parameter)?$data->parameter == "tidak_yakin"?$skor +2:$skor+0:$skor+0; 
if(isset($data->check_parameter)){
    switch($data->check_parameter){
        case 'item1':
            $skor+=1;
            break;
        case 'item2':
            $skor+=2;
            break;
        case 'item3':
            $skor+=3;
            break;
        case 'item4':
            $skor+=4;
            break;
        case 'item5':
            $skor+=2;
            break;
        default:
            break;
    }
}

$skor = isset($data->parameter1)?$data->parameter1 == 'ya'?$skor+1:$skor+0 :$skor + 0;

$skor2 = isset($data->riwayat_jatuh)?$data->riwayat_jatuh == 'ya'?$skor2+25:$skor2+0:$skor2+0;
$skor2 = isset($data->penyakit_penyerta)?$data->penyakit_penyerta == 'ya'?$skor2+15:$skor2+0:$skor2+0;
if(isset($data->alat_bantu_jalan)){
    if($data->alat_bantu_jalan == "berpegangan"){
        $skor2 = $skor2 +30;
    }elseif($data->alat_bantu_jalan == "penopang_tongkat"){
        $skor2 = $skor2 + 15;
    }
}
$skor2 = isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == 'ya'?$skor2+15:$skor2+0:$skor2+0;
$skor2 = isset($data->pemakaian_terapi_heparin)?$data->pemakaian_terapi_heparin == 'ya'?$skor2+20:$skor2 + 0:$skor2 + 0;
if(isset($data->cara_berjalan)){
    if($data->cara_berjalan == 'tergangu'){
        $skor2 = $skor2 + 20;
    }elseif($data->cara_berjalan == 'lemah'){
        $skor2 = $skor2 + 10;
    }
}

$skor2 = isset($data->status_mental)?$data->status_mental == 'lupa_keterbatasan_diri' ?$skor2 + 15:$skor2 + 0:$skor2 +0;
// echo $skor2;
$total_skor = $skor+$skor2;
//    var_dump($pemeriksa);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesmen awal Keperawatan</title>
</head>
<style>
 .data{
     font-size:11px;
 }
 .bg-checked{
     background-color:#64C9CF;
     color:white;
 }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <!-- page 1 -->
    <section class="sheet padding-10mm">
    <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border: 2px solid black;"></div>
            <div id="body">
                <div class="margintb">
                    <center>
                        <p><b>ASSESMEN AWAL KEPERAWATAN IGD</b></p>
                        <span style="font-size:12px"><b><i>(Dilengkapi dalam waktu 1 jam pertama pasien masuk IGD)</i></b></span>
                    </center><br>
                </div>
                <div class="border-all" style="font-size:12px">
                    <table border=0 width="100%"  style="font-size:12px">
                            <tr>
                                <td width="18%" style="font-size:12px"> <span class="margin-text">Hari/Tanggal</span></td>
                                <td width="2%" style="font-size:12px">:</td>
                                <td width="30%" style="font-size:12px"><?= (isset($data_rawat_darurat[0]->tgl_kunjungan))?$hari.' , '.date('d-m-Y',strtotime($data_rawat_darurat[0]->tgl_kunjungan)):''; ?></td>
                                <td width="18%" style="font-size:12px">Jam Masuk</td>
                                <td width="2%" style="font-size:12px">:</td>
                                <td width="30%" style="font-size:12px"><?= isset($data->jam_masuk)?$data->jam_masuk:'-' ?> WIB</td>

                            </tr>
                            <tr>

                                <td width="18%" style="font-size:12px"><p>Jam Ditolong</p></td>
                                <td width="2%" style="font-size:12px"><p>:</p></td>
                                <td width="30%" style="font-size:12px"> <p><?= isset($data->jam_masuk)?$data->jam_masuk:'-' ?> WIB</p></td>
                                <td width="18%" style="font-size:12px"><p>Jam Keluar</p></td>
                                <td width="2%" style="font-size:12px"><p>:</p></td>
                                <td width="30%" style="font-size:12px"><p><?= isset($data->jam_keluar)?$data->jam_keluar:'-' ?> WIB</p></td>
                            </tr>
                            <tr>

                                <td colspan="2" style="font-size:12px">
                                    <input type="checkbox" id="neurologi" name="neurologi"  value="neurologi" <?= (isset($data->anamnesa))?$data->anamnesa == 'auto_anamnesa'?'checked':'':''; ?>>
                                    <span style="text-align:right;">Auto Anamnesa</span>
                                </td>
                                <td style="font-size:12px">
                                    <input type="checkbox" id="neurologi" name="neurologi"  value="neurologi" <?= (isset($data->anamnesa))?$data->anamnesa == 'allo_anamnesa'?'checked':'':''; ?>>
                                    <span>Allo Anamnesa</span>
                                </td>
                                <td width="18%" style="font-size:12px">Hubungan</td>
                                <td width="2%" style="font-size:12px">:</td>
                                <td width="30%" style="font-size:12px">
                                    <?php 
                                        if(isset($data_pasien[0]->hubungan)){
                                            switch ($data_pasien[0]->hubungan) {
                                                case 'Ybs.':
                                                    echo 'Yang Bersangkutan';
                                                    break;
                                                case 'Ortu':
                                                    echo 'Orang Tua';
                                                    break;
                                                case 'Istri':
                                                    echo 'Istri';
                                                    break;
                                                case 'Suami':
                                                    echo 'Suami';
                                                    break;
                                                case 'Anak':
                                                    echo 'Anak';
                                                    break;
                                                default:
                                                    echo 'Orang Lain';
                                                    break;
                                            }
                                        }else{
                                            echo '-';
                                        }
                                        ?></td>
                                
                            </tr>
                            <tr>

                                <td width="18%" style="font-size:12px"><p>Cara Bayar</p></td>
                                <td width="2%" style="font-size:12px"><p>:</p></td>
                                <td width="30%" style="font-size:12px"> <p><?= (isset($data_rawat_darurat[0]->cara_bayar))?$data_rawat_darurat[0]->cara_bayar:'-' ?></p></td>
                                <td width="18%" style="font-size:12px"><p>JK</p></td>
                                <td width="2%" style="font-size:12px"><p>:</p></td>
                                <td width="30%" style="font-size:12px"><p><?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'-' ?></p></td>
                            </tr>
                            <tr>

                                <td width="18%" style="font-size:12px">Nama</td>
                                <td width="2%" style="font-size:12px">:</td>
                                <td width="30%" style="font-size:12px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'-' ?></td>
                                <td width="18%" style="font-size:12px">Alamat</td>
                                <td width="2%" style="font-size:12px">:</td>
                                <td width="30%" style="font-size:12px"><?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'-' ?></td>
                            </tr>
                    </table>
                    <div>
                        
                        <p >Cara Masuk :</p>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->cara_masuk)?$data->cara_masuk == 'jalan_tanpa_bantuan'?"checked":'':"") ?>>
                        <span class="margin-text">Jalan Tanpa Bantuan</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->cara_masuk)?$data->cara_masuk == 'kursi_roda'?"checked":'':"") ?>>
                        <span class="margin-text">Kursi Roda</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->cara_masuk)?$data->cara_masuk == 'brankar'?"checked":'':"") ?>>
                        <span class="margin-text">Brankar</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->cara_masuk)?$data->cara_masuk == 'datang_sendiri'?"checked":'':"") ?>>
                        <span class="margin-text">Datang Sendiri</span>
                        <div class="margintoright">
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->cara_masuk)?$data->cara_masuk == 'rujukan_rs' || $data->cara_masuk == 'rujukan_puskesmas'?"checked":'':"") ?>>
                            <span class="margin-text">Rujukan, dari <?= (isset($data->cara_masuk)?$data->cara_masuk == 'rujukan_rs' || $data->cara_masuk == 'rujukan_puskesmas'?$data->cara_masuk == "rujukan_puskesmas"?'Puskesmas':'Rumah Sakit':'..........':"..........") ?></span>
                        </div>
                    
                </div>
                
                    <div id="part2">
                        <div class="two-row">
                            <div id="first">
                                <div>
                                    <p>Agama :
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'ISLAM'?'checked':'':'') ?>>
                                    <span class="margin-text">islam</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'KATHOLIK'?'checked':'':'') ?>>
                                    <span class="margin-text">Kristen Katolik</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'KRISTEN'?'checked':'':'') ?>>
                                    <span class="margin-text">Kristen Protestan</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'HINDU'?'checked':'':'') ?>>
                                    <span class="margin-text">Hindu</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'BUDHA'?'checked':'':'') ?>>
                                    <span class="margin-text">Budha</span>
                                    </p>
                                </div>
                                <div>
                                    <p>Status Pasien :
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_rawat_darurat)?$data_rawat_darurat == "LAMA"?'checked':'':"") ?>>
                                    <span class="margin-text">Baru</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data_rawat_darurat)?$data_rawat_darurat != "LAMA"?'checked':'':"") ?>>
                                    <span class="margin-text">Lama</span>
                                    </p>
                                </div>
                                <p>Bahasa : <?= (isset($data_pasien[0]->bahasa)?$data_pasien[0]->bahasa:'-') ?></p>
                            </div>
                            <div>
                                <p>DEATH ON ARRIVAL (DOA) :</p>
                                <div class="titlewithcheckbox">
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->death_of_arival)?$data->death_of_arival == 'tanda_kehidupan'?'checked':'':'') ?>>
                                    <span class="margin-text">Tanda Kehidupan</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->death_of_arival)?$data->death_of_arival == 'ekg_flat'?'checked':'':'') ?>>
                                    <span class="margin-text">EKG Flat</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->death_of_arival)?$data->death_of_arival == 'tidak_ada_denyut_nadi'?'checked':'':'') ?>>
                                    <span class="margin-text">Tidak ada denyut nadi</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->death_of_arival)?$data->death_of_arival == 'jam_doa'?'checked':'':'') ?>>
                                    <span class="margin-text">Jam DOA : <?= (isset($data->jam_doa)?$data->jam_doa:'') ?> WIB</span><br>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->death_of_arival)?$data->death_of_arival == 'reflek_cahaya'?'checked':'':'') ?>>
                                    <span class="margin-text">Reflek Cahaya ( - / - )</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p style="font-size:12px"><b><u>RIWAYAT KESEHATAN</u></b></p>
                    </div>
                    <p>
                        <p><b>Riwayat Kesehatan Sekarang (Keluhan Utama) :</b></p>
                        <p><?= (isset($data->riwayat_kesehatan)?$data->riwayat_kesehatan:''); ?></p>
                        <p><b>Riwayat Kesehatan Dahulu :</b></p>
                        <p><?= (isset($data->riwayat_kesehatan_dulu)?$data->riwayat_kesehatan_dulu:''); ?></p>
                    </p>
                    <p><b><u>PEMERIKSAAN FISIK</u></b></p>
                    <table border=0 width="100%">
                        <tr>
                            <td width="18%" style="font-size:12px">Keadaan Umum</td>
                            <td width="2%" style="font-size:12px">:</td>
                            <td width="20%" style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->ku)?$pemeriksaan_fisik[0]->ku:'') ?></td>
                            <td width="26%" style="font-size:12px">Kesadaran</td>
                            <td width="2%" style="font-size:12px">:</td>
                            <td width="30%" style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->kesadaran)?$pemeriksaan_fisik[0]->kesadaran:'') ?></td>

                        </tr>
                        <tr>

                            <td style="font-size:12px"><p>Berat Badan</p></td>
                            <td style="font-size:12px"><p>:</p></td>
                            <td style="font-size:12px"> <p><?= (isset($pemeriksaan_fisik[0]->bb)?$pemeriksaan_fisik[0]->bb:'') ?>Kg</p></td>
                            <td style="font-size:12px"><p>Tanda - Tanda Vital </p></td>
                            <td style="font-size:12px"><p></p></td>
                            <td style="font-size:12px"><p><?= (isset($pemeriksaan_fisik[0]->vitalsign)?$pemeriksaan_fisik[0]->vitalsign:'') ?></p></td>
                        </tr>   
                        <tr>

                            <td style="font-size:12px" >TD</td>
                            <td style="font-size:12px" >:</td>
                            <td style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->sitolic)?$pemeriksaan_fisik[0]->sitolic.'/'.$pemeriksaan_fisik[0]->diatolic.' ':'') ?>mmHg</td>
                            <td style="font-size:12px" >HR</td>
                            <td style="font-size:12px" >:</td>
                            <td style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->nadi)?$pemeriksaan_fisik[0]->nadi:'') ?>x/i</td> 

                        </tr>
                        <tr>

                            <td style="font-size:12px" ><p>RR</p></td>
                            <td style="font-size:12px" ><p>:</p></td>
                            <td style="font-size:12px"><p><?= (isset($pemeriksaan_fisik[0]->pernafasan)?$pemeriksaan_fisik[0]->pernafasan:'') ?>x/i</p></td>
                            <td style="font-size:12px" ><p>SpO2</p></td>
                            <td style="font-size:12px" ><p>:</p></td>
                            <td style="font-size:12px"><p><?= (isset($pemeriksaan_fisik[0]->spotwo)?$pemeriksaan_fisik[0]->spotwo:'') ?></p></td>
                        </tr> 
                        <tr>

                            <td style="font-size:12px" >GCS</td>
                            <td style="font-size:12px" >:</td>
                            <td style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->e_gcs)?'E :'.' '.$pemeriksaan_fisik[0]->e_gcs.' '.'M :'.' '.$pemeriksaan_fisik[0]->m_gcs.' '.'V :'.' '.$pemeriksaan_fisik[0]->v_gcs:'') ?></td>
                            <td style="font-size:12px" >Pupil</td>
                            <td style="font-size:12px" >:</td>
                            <td style="font-size:12px"><?= (isset($pemeriksaan_fisik[0]->pupil)?$pemeriksaan_fisik[0]->pupil:'') ?></td>
                        </tr> 
                        
                    </table>
                   
                </div>
            </div>
        </div>
    </section>



    <!-- The second sheet -->
    <section class="sheet padding-10mm">
    <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border: 2px solid black;"></div>
            <div id="body" >
                <div>
                        <center>
                            <h4>ASSESMEN AWAL KEPERAWATAN IGD</h4>
                        </center>
                </div>

                <div class="border-all" style="font-size:12px">

                    <!-- rapihin --aldi -->

                    <div>
                        <p><b><u>RIWAYAT ALERGI</u></b></p>
                    </div>
                    <div>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->riwayat_alergi)?$data->riwayat_alergi == 'tidak'?'checked':'':'') ?>>
                        <span>Tidak</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->riwayat_alergi)?$data->riwayat_alergi == 'ya'?'checked':'':'') ?>>
                        <span>Ya</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->riwayat_alergi)?$data->riwayat_alergi == 'pasang_gelang'?'checked':'':'') ?>>
                        <span>Pasang gelang warna merah</span><br>
                        <p>
                            <span class="margin-text">a. Alergi Obat :</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->alergi_obat)?$data->alergi_obat == 'tidak'?'checked':'':'') ?>>
                            <span class="margin-text">Tidak</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->alergi_obat)?$data->alergi_obat == 'ya '?'checked':'':'') ?>>
                            <span class="margin-text"> Ya,jenis/nama Obat <?= (isset($data->value_alergi_obat)?$data->value_alergi_obat:'') ?></span>
                        </p>
                        <p style="margin-left:26px">
                            <span>Reaksi Utama yang timbul : </span>
                            <span><?= (isset($data->reaksi_utama)?$data->reaksi_utama:'') ?></span>
                        </p>
                        <div>
                            <span class="margin-text">b. Lain lain :</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->penyakit_lain)?$data->penyakit_lain == 'astma'?'checked':'':'') ?>>
                            <span class="margin-text">Astma</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->penyakit_lain)?$data->penyakit_lain == 'eksim_kulit'?'checked':'':'') ?>>
                            <span class="margin-text"> Eksim Kulit</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->penyakit_lain)?$data->penyakit_lain == 'sabun'?'checked':'':'') ?>>
                            <span class="margin-text"> Sabun</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->penyakit_lain)?$data->penyakit_lain == 'debu'?'checked':'':'') ?>>
                            <span class="margin-text"> Debu</span>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->penyakit_lain)?$data->penyakit_lain == 'makanan'?'checked':'':'') ?>>
                            <span class="margin-text"> Makanan : <?= (isset($data->makanan)?$data->makanan:'') ?></span>
                        </div>
                        <p style="margin-left:26px">
                            <span>Reaksi Utama yang timbul : </span>
                            <span><?= (isset($data->reaksi_utama_lainnya)?$data->reaksi_utama_lainnya:'') ?></span>
                        </p>
                    </div>

                    <!-- end -->
                    <br>
                    <div>
                        <span ><b>Skrining Gizi : Malnutrition Screening Tool (MST)</b></span><br><br>
                        <span>Lingkari skor sesuai dengan jawaban, total skor adalah jumlah skor yang dilingkari)</span>
                        <table border=1 >
                            <tr style="font-size:12px">
                                <th>No.</th>
                                <th>Parameter</th>
                                <th>Skor</th>
                            </tr>
                            <tr >
                                <td style="font-size:12px">1.</td>
                                <td style="font-size:12px">Apakah Pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6 bulan terakhir</td>
                                <td style="font-size:12px"> </td>
                            </tr>
                            <tr class="<?= isset($data->parameter)?$data->parameter == "tidak_ada_penurunan"?"bg-checked":"":"" ?> ">
                                <td style="font-size:12px;text-align:center;"><?= isset($data->parameter)?$data->parameter == "tidak_ada_penurunan"?"✓":"":"" ?></td>
                                <td style="font-size:12px">a. Tidak ada penurunan berat badan</td>
                                <td style="font-size:12px;text-align:center">0</td>
                            </tr>
                            <tr class="<?= isset($data->parameter)?$data->parameter == "tidak_yakin"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px;text-align:center;"><?= isset($data->parameter)?$data->parameter == "tidak_yakin"?"✓":"":"" ?></td>
                                <td style="font-size:12px">b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                                <td style="font-size:12px;text-align:center">2</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px;text-align:center;"> </td>
                                <td style="font-size:12px">c. Jika ya , berapa penurunan berat badan tersebut</td>
                                <td style="font-size:12px"> </td>
                            </tr>
                            <tr class="<?= isset($data->check_parameter)?$data->check_parameter == "item1"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px;text-align:center;"><?= isset($data->check_parameter)?$data->check_parameter == "item1"?"✓":"":"" ?> </td>
                                <td style="font-size:12px">1-5 kg</td>
                                <td style="font-size:12px;text-align:center">1</td>
                            </tr>
                            <!-- <td style="font-size:12px"></td> -->
                            <tr class="<?= isset($data->check_parameter)?$data->check_parameter == "item2"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px"> <?= isset($data->check_parameter)?$data->check_parameter == "item2"?"✓":"":"" ?></td>
                                <td style="font-size:12px">6-10 kg</td>
                                <td style="font-size:12px;text-align:center">2</td>
                            </tr>
                            <tr class="<?= isset($data->check_parameter)?$data->check_parameter == "item3"?"bg-checked":"":"" ?> ">
                                <td style="font-size:12px"><?= isset($data->check_parameter)?$data->check_parameter == "item3"?"✓":"":"" ?></td>
                                <td style="font-size:12px">11-15 kg</td>
                                <td style="font-size:12px;text-align:center">3</td>
                            </tr>
                            <tr class="<?= isset($data->check_parameter)?$data->check_parameter == "item4"?"bg-checked":"":"" ?>">
                                <td ><?= isset($data->check_parameter)?$data->check_parameter == "item4"?"bg-checked":"✓":"" ?></td>
                                <td style="font-size:12px">>15 kg</td>
                                <td style="font-size:12px;text-align:center">4</td>
                            </tr>
                            <tr class="<?= isset($data->check_parameter)?$data->check_parameter == "item5"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px"> <?= isset($data->check_parameter)?$data->check_parameter == "item5"?"✓":"":"" ?></td>
                                <td style="font-size:12px">Tidak yakin penurunannya</td>
                                <td style="font-size:12px;text-align:center">2</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px"> 2 </td>
                                <td style="font-size:12px">Apakah asupan makan berkurang karena berkurangnya nafsu makan?</td>
                                <td style="font-size:12px"></td>
                            </tr>
                            <tr class="<?= isset($data->parameter1)?$data->parameter1 == "tidak"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px"><?= isset($data->parameter1)?$data->parameter1 == "tidak"?"✓":"":"" ?></td>
                                <td style="font-size:12px">1. Tidak</td>
                                <td style="font-size:12px;text-align:center">0</td>
                            </tr>
                            <tr class="<?= isset($data->parameter1)?$data->parameter1 == "ya"?"bg-checked":"":"" ?>">
                                <td style="font-size:12px"><?= isset($data->parameter1)?$data->parameter1 == "ya"?"✓":"":"" ?></td>
                                <td style="font-size:12px">2. Ya</td>
                                <td style="font-size:12px;text-align:center">1</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px"></td>
                                <td colspan="3" style="font-size:12px">
                                    <span>Pasien dengan Diagnosa Khusus :</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi"<?= (isset($data-> pasien_diagnosa)?$data-> pasien_diagnosa == 'tidak'?'checked':'':'') ?>>
                                    <span class="margin-text">Tidak</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> pasien_diagnosa)?$data-> pasien_diagnosa == 'ya'?'checked':'':'') ?>>
                                    <span class="margin-text">Ya</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('dm',$data->chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">DM</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('ginjal',$data-> chechk_iya) ?'checked':'':'') ?>>
                                    <span class="margin-text">Ginjal</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('hati',$data-> chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">Hati</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('jantung',$data-> chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">Jantung</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('paru',$data-> chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">Paru</span><br><br>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('stroke',$data-> chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">Stroke</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi"<?= (isset($data-> chechk_iya)?in_array('kanker',$data-> chechk_iya)?'checked':'':'') ?>>
                                    <span class="margin-text">Kanker</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> chechk_iya)?in_array('penurunan_imunitas',$data-> chechk_iya) ?'checked':'':'') ?>>
                                    <span class="margin-text">Penurunan Immunitas</span>
                                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data-> pasien_diagnosa)?$data-> pasien_diagnosa == 'lainnya'?'checked':'':'') ?>>
                                    <span class="margin-text">Lain - Lain : <?= (isset($data-> value_diagnosa)?$data-> value_diagnosa:'') ?></span>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size:12px">Total</td>
                                <td style="font-size:12px;text-align:center;"><?= $skor ?></td>
                            </tr>
                        </table>
                        
                        <p>Bila skor >= 2 pasien berisiko malnutrisi, konsul ke ahli gizi</p>
                        <table  border=1 width="100%">
                            <tr>
                                <th style="font-size:12px">No.</th>
                                <th style="font-size:12px">Parameter</th>
                                <th style="font-size:12px">Status</th>
                                <th style="font-size:12px">Skor</th>
                            </tr>
                            <tr>
                                <td rowspan="2" style="font-size:12px">1</td>
                                <td rowspan="2" style="font-size:12px">Riwayat Jatuh</td>
                                <td style="font-size:12px" class="<?= isset($data->riwayat_jatuh)?$data->riwayat_jatuh == "tidak"?"bg-checked":"":"" ?>">Tidak</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->riwayat_jatuh)?$data->riwayat_jatuh == "tidak"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->riwayat_jatuh)?$data->riwayat_jatuh == "ya"?"bg-checked":"":"" ?>">Ya</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->riwayat_jatuh)?$data->riwayat_jatuh == "ya"?"bg-checked":"":"" ?>">25</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="font-size:12px">2</td>
                                <td rowspan="2" style="font-size:12px">Penyakit Penyerta (diagnosis sekunder >= 2)</td>
                                <td style="font-size:12px" class="<?= isset($data->penyakit_penyerta)?$data->penyakit_penyerta == "tidak"?"bg-checked":"":"" ?>">Tidak</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->penyakit_penyerta)?$data->penyakit_penyerta == "tidak"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->penyakit_penyerta)?$data->penyakit_penyerta == "ya"?"bg-checked":"":"" ?>">Ya</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->penyakit_penyerta)?$data->penyakit_penyerta == "ya"?"bg-checked":"":"" ?>">15</td>
                            </tr>
                            <tr>
                                <td rowspan="4">3</td>
                                <td style="font-size:12px" colspan="2">Alat bantu Jalan</td>
                                
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "tidak_ada_bed"?"bg-checked":"":"" ?>">a. Tidak ada/Bed rest/ dibantu Perawat</td>
                                <td  style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "tidak_ada_bed"?"bg-checked":"":"" ?>">Tanpa alat Bantu</td>
                                <td  style="font-size:12px;text-align:center" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "tidak_ada_bed"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "penopang_tongkat"?"bg-checked":"":"" ?>">b. Penopang tongkat / walker</td>
                                <td style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "penopang_tongkat"?"bg-checked":"":"" ?>">Tidak dapat jalan</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "penopang_tongkat"?"bg-checked":"":"" ?>">15</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "berpegangan"?"bg-checked":"":"" ?>">c. Berpegang dengan perabot</td>
                                <td style="font-size:12px" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "berpegangan"?"bg-checked":"":"" ?>">Kursi</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->alat_bantu_jalan)?$data->alat_bantu_jalan == "berpegangan"?"bg-checked":"":"" ?>">30</td>
                            </tr>

                            <tr>
                                <td rowspan="2" style="font-size:12px">4</td>
                                <td rowspan="2" style="font-size:12px">Pemakaian terapi herapin/ intra vena/ infus</td>
                                <td style="font-size:12px" class="<?= isset($data->pemakaian_terapi_heparin)?$data->pemakaian_terapi_heparin == "tidak"?"bg-checked":"":"" ?>">Tidak</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->pemakaian_terapi_heparin)?$data->pemakaian_terapi_heparin == "tidak"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->pemakaian_terapi_heparin)?$data->pemakaian_terapi_heparin == "ya"?"bg-checked":"":"" ?>">Ya</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->pemakaian_terapi_heparin)?$data->pemakaian_terapi_heparin == "ya"?"bg-checked":"":"" ?>">20</td>
                            </tr>
                            <tr>
                                <td rowspan="3" style="font-size:12px">5</td>
                                <td rowspan="3" style="font-size:12px">Cara berjalan / berpindah</td>
                                <td style="font-size:12px" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "normal_beda"?"bg-checked":"":"" ?>">Normal / bed rest/ immobilitas</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "normal_beda"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "lemah"?"bg-checked":"":"" ?>">Lemah</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "lemah"?"bg-checked":"":"" ?>">10</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "tergangu"?"bg-checked":"":"" ?>">Terganggu</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "tergangu"?"bg-checked":"":"" ?>">20</td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="font-size:12px">6.</td>
                                <td rowspan="2" style="font-size:12px">Status Mental</td>
                                <td style="font-size:12px" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "orientasi"?"bg-checked":"":"" ?>">Orientasi sesuai kemampuan diri</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->cara_berjalan)?$data->cara_berjalan == "orientasi"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="font-size:12px" class="<?= isset($data->status_mental)?$data->status_mental == "lupa_keterbatasan_diri"?"bg-checked":"":"" ?>">Lupa keterbatasan diri</td>
                                <td style="font-size:12px;text-align:center" class="<?= isset($data->status_mental)?$data->status_mental == "lupa_keterbatasan_diri"?"bg-checked":"":"" ?>">15</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="font-size:12px">Total</td>
                                <td style="font-size:12px;text-align:center;"><?= $skor2; ?></td>

                            </tr>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

    </section>


    <!-- PAGE 3 -->
    <section class="sheet padding-10mm">
    <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border: 2px solid black;"></div>
           
                <div class="margintop">
                    <center>
                        <h4>ASSESMEN AWAL KEPERAWATAN IGD</h4>
                    </center>
                </div>
           

                <div id="part1" style="font-size:12px">

                    <!-- DIrapihin -->
                    <p>Keterangan :</p>
                    <table border=1 width="100%">
                        <tr>
                            <th style="font-size:12px">Skor</th>
                            <th style="font-size:12px">Tingkat Risiko</th>
                            <th style="font-size:12px">Hasil asesmen</th>
                        </tr>
                        <tr>
                            <td style="font-size:12px">0-24</td>
                            <td style="font-size:12px"> Tidak berisiko</td>
                            <td style="text-align:center;font-size:24px"><?= $total_skor>=0 && $total_skor <= 24?'✓':'' ?> </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px">25-50</td>
                            <td style="font-size:12px">Risiko rendah</td>
                            <td style="text-align:center;font-size:24px"><?= $total_skor>=25 && $total_skor <= 50?'✓':'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:12px">>= 51</td>
                            <td style="font-size:12px">Risiko Tinggi</td>
                            <td style="text-align:center;font-size:24px"><center><?= $total_skor>=51?'✓':'' ?></center></td>
                        </tr>
                    </table>

               
                    <p>Keamanan:</p>
                    <input type="checkbox" <?= (isset($data-> keamanan)?$data-> keamanan == 'tidak'?'checked':'':'') ?>>
                    <span>Tidak</span>
                    <input type="checkbox" name="" id="" <?= (isset($data-> keamanan)?$data-> keamanan == 'ya'?'checked':'':'') ?>>
                    <span>Ya</span>
                    <input type="checkbox"<?php echo isset($data->check_keamanan)?(in_array("pasang_tempat_tidur", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                    <span>Pasang pengaman tempat tidur/ bed railis</span>
                    <input type="checkbox" <?php echo isset($data->check_keamanan)?(in_array("penanda_segitiga", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                    <span>Penanda Segitiga Resiko Jatuh </span> <br>
                    <input type="checkbox" <?php echo isset($data->check_keamanan)?(in_array("kunci_roda", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                    <span>Kunci roda tempat tidur </span>
                    
                    
                    <br>
               
                    <p><b>ASSESMENT NYERI</b></p>
                        <span style="margin-left:20px">Nyeri : </span>
                        <input type="checkbox" <?= (isset($data-> nyeri)?$data-> nyeri == 'tidak'?'checked':'':'') ?>>
                        <span>Tidak</span>
                        <input type="checkbox" <?= (isset($data-> nyeri)?$data-> nyeri == 'ya, bersifat'?'checked':'':'') ?>>
                        <span>Ya,Bersifat</span>
                        <input type="checkbox" <?= (isset($data-> akut_kronis)?$data-> akut_kronis == 'akut'?'checked':'':'') ?>>
                        <span>Akut</span>
                        <input type="checkbox" <?= (isset($data-> akut_kronis)?$data-> akut_kronis == 'kronis'?'checked':'':'') ?>>
                        <span>Kronis</span>
                    <!-- dirapihin -->
                        <p>
                            <div>
                                <center><img src="<?= base_url("assets/img/de.jpg") ?>" height="200" width="300" alt=""></center>
                                <div style="position:absolute; left:31.2%;top:45.7%;">
                                <?php 
                                if(isset($data->image_skor_nyeri)){
                                ?>
                                    <center><img src=" <?= (isset($data->image_skor_nyeri))?$data->image_skor_nyeri:'' ?>"  alt="img" height="200" width="300"></center>
                                <?php } ?>
                                </div>
                            </div>
                        </p>
                
                        <div style="margin-left:20px">
                            <p>
                                <span>1. Kualitas nyeri :</span>
                                <input type="checkbox" name="" id=""  <?= (isset($data-> kualitas_nyeri)?$data-> kualitas_nyeri == 'nyeri_tumpul'?'checked':'':'') ?> >
                                <span>Nyeri Tumpul</span>
                                <input type="checkbox"  <?= (isset($data-> kualitas_nyeri)?$data-> kualitas_nyeri == 'nyeri_tajam'?'checked':'':'') ?>>
                                <span>Nyeri Tajam</span>
                                <input type="checkbox"  <?= (isset($data-> kualitas_nyeri)?$data-> kualitas_nyeri == 'panas_terbakar'?'checked':'':'') ?>>
                                <span>Panas/Terbakar</span>
                            </p>
                            <p>
                                <span>2. Menjalar :</span>
                                <input type="checkbox" <?= (isset($data-> menjalar)?$data-> menjalar == 'tidak'?'checked':'':'') ?>>
                                <span>Tidak</span>
                                <input type="checkbox" <?= (isset($data-> menjalar)?$data-> menjalar == 'iya'?'checked':'':'') ?>>
                                <span>Ya, ke <?= (isset($data-> value_menjalar)?$data-> value_menjalar:'') ?> </span>
                            </p>
                            <p>
                                <span>3. Skor nyeri :</span>
                                <span> <?php
                                if (isset($data->nyeri)){
                                    echo  (isset($data-> skala_nyeri)?$data-> skala_nyeri:'');
                                    
                                }else{
                                    echo '0';
                                }
                                    ?> 
                                </span>
                            </p>
                            <p>
                                <span>4. Frekuensi Nyeri :</span>
                                <input type="checkbox" name="" id="" <?= (isset($data-> frekuensi_nyeri)?$data-> frekuensi_nyeri == 'jarang'?'checked':'':'') ?> >
                                <span>Jarang</span>
                                <input type="checkbox" <?= (isset($data-> frekuensi_nyeri)?$data-> frekuensi_nyeri == 'hilang_timbul'?'checked':'':'') ?>>
                                <span>Hilang timbul</span>
                                <input type="checkbox" name="" id="" <?= (isset($data-> frekuensi_nyeri)?$data-> frekuensi_nyeri == 'terus_menerus'?'checked':'':'') ?>>
                                <span>terus menerus</span>
                            </p>
                            <p>
                                <span>5. Lama nyeri :</span>
                                <span>
                                    <?php
                                    if (isset($data-> nyeri)){
                                        echo  (isset($data-> lama_nyeri)?$data-> lama_nyeri :'');
                                        
                                    }else{
                                        echo '0';
                                    }
                                        ?> </span>

                            </p>
                            <p>
                                <span>6. Lokasi Nyeri :</span>
                                <span> <?php
                                    if (isset($data-> nyeri)){
                                        echo (isset($data-> lokasi_nyeri)?$data-> lokasi_nyeri :'');
                                       
                                    }else{
                                        echo '0';
                                    }
                                        ?>
                                    </span>
                            </p>
                            <p>
                                <p>7. Faktor - faktor yang mengurangi / menghilangkan nyeri :</p>
                                <input type="checkbox" name="" id="" style="margin-left:20px" <?= (isset($data-> fk_minum_obat)?$data-> fk_minum_obat == 'minum_obat'?'checked':'':'') ?>>
                                <span>Minum obat</span>
                                <input type="checkbox" <?= (isset($data-> fk_istirahat)?$data-> fk_istirahat == 'istirahat'?'checked':'':'') ?>>
                                <span>Istirahat</span>
                                <input type="checkbox" <?= (isset($data-> fk_musik)?$data-> fk_musik == 'music'?'checked':'':'') ?>>
                                <span>Mendengar musik</span>
                                <input type="checkbox" <?= (isset($data-> fk_posisi_tidur)?$data-> fk_posisi_tidur == 'posisi_tidur'?'checked':'':'') ?>>
                                <span>berubah posisi/tidur</span>
                            </p>
                        </div>


                        <p><b>ASESMEN PSIKOSOSIAL</b></p>
                        <p style="margin-left:20px">Hubungan dengan anggota keluarga :
                            <input type="checkbox" name="" id="" <?= (isset($data-> stat_sosial_keluarga)?$data-> stat_sosial_keluarga == 'baik'?'checked':'':'') ?> >
                            <span>baik</span>
                            <input type="checkbox" <?= (isset($data-> stat_sosial_keluarga)?$data-> stat_sosial_keluarga == 'tidak_baik'?'checked':'':'') ?>>
                            <span>Tidak Baik</span><br>
                        </p>

                        
                        <p><b>ASESMEN PSIKOLOGIS</b></p>
                        <p style="margin-left:20px">
                            <input type="checkbox" name="" id="" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'tenang'?'checked':'':'') ?> >
                            <span>Tenang</span>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'cemas'?'checked':'':'') ?>>
                            <span>Cemas</span>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'takut'?'checked':'':'') ?>>
                            <span>Takut</span>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'marah'?'checked':'':'') ?>>
                            <span>Marah</span>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'sedih'?'checked':'':'') ?>>
                            <span>Sedih</span>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'bunuhdiri'?'checked':'':'') ?>>
                            <span>Kecendrungan bunuh diri dilaporkan ke <?= (isset($data-> value_stat_psikologis_bunuhdiri)?$data-> value_stat_psikologis_bunuhdiri :'') ?></span><br>
                            <input type="checkbox" <?= (isset($data-> stat_psikologis)?$data-> stat_psikologis == 'lainnya'?'checked':'':'') ?>>
                            <span>lain lain, sebutkan <?= (isset($data-> value_stat_psikologis)?$data-> value_stat_psikologis :'') ?> </span>
                        </p>


                        


                        
                </div>

    </section>




    <section class="sheet padding-10mm">
        <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border: 2px solid black;"></div>

        <div class="margintb">
                <center>
                    <h4>ASSESMEN AWAL KEPERAWATAN IGD</h4>
                </center>
        </div>

        <div style="font-size:12px">
        <div style="margin-left:20px">   
        <!-- added -->
       
                            <div>
                            <p><b>ASESMEN SOSIAL EKONOMI</b></p>
                                <p style="margin-left:20px">Status pernikahan :
                                    <input type="checkbox" name="" id="" <?= isset($data_pasien[0]->status)?$data_pasien[0]->status == 'B'?'checked':'':''?>>
                                    <span>Single</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->status)?$data_pasien[0]->status == 'K'?'checked':'':"")?>>
                                    <span>Menikah</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->status)?$data_pasien[0]->status == 'C'?'checked':'':"")?>>
                                    <span>Janda/Duda</span>
                                </p>


                                <p style="margin-left:20px">Pekerjaan :
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Buruh'?'checked':'':"")?>>
                                    <span>Buruh</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Dagang'?'checked':'':"")?>>
                                    <span>Dagang</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Ibu Rumah Tangga'?'checked':'':"")?>>
                                    <span>Ibu Rumah Tangga</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Karyawan Swasta'?'checked':'':"")?>>
                                    <span>Karyawan Swasta</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'PNS/Pol/TNI'?'checked':'':"")?>>
                                    <span>PNS/Pol/TNI</span><br>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Pelajar/Mahasiswa'?'checked':'':"")?>>
                                    <span>Pelajar/Mahasiswa</span>
                                    <input type="checkbox" name="" id="" <?= (isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan == 'Lainnya'?'checked':'':"")?>>
                                    <span>Lainnya</span>
                                </p>
                                <p><b>ASESMEN FUNGSIONAL</b></p>
                                <p style="margin-left:20px">
                                    <input type="checkbox" name="" id="" <?= (isset($data-> fungsional_alat_bantu)?$data-> fungsional_alat_bantu == 'mandiri'?'checked':'':'') ?> >
                                    <span>Mandiri</span>
                                    <input type="checkbox" name="" id=""  <?= (isset($data-> fungsional_alat_bantu)?$data-> fungsional_alat_bantu == 'perlu_bantuan'?'checked':'':'') ?>>
                                    <span>Perlu bantuan, sebutkan
                                    <?= (isset($data->check_lainnya)?'<ins>'.$data->check_lainnya.'</ins>':'') ?></span><br>
                                    <input type="checkbox" name="" id=""  <?= (isset($data-> fungsional_alat_bantu)?$data-> fungsional_alat_bantu == 'ketergantungan_total'?'checked':'':'') ?>>
                                    <span>Ketergantungan total, dilaporkan ke dokter jaga</span><br>
                                    <input type="checkbox" name="" id=""  <?php echo isset($data->kekuatan_otot)?(in_array("kekuatan_otot_igd", $data->kekuatan_otot) ? "checked" : "disabled"):""; ?>>
                                    <span>Kekuatan Otot</span>
                                </p>
                            </div>
                            <div>
                                <table  width="10%">
                                    <tr style="border-bottom:1px solid black">
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->tangan_kanan_igd)?($data->tangan_kanan_igd?$data->tangan_kanan_igd :''):'' ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data->tangan_kiri_igd)?($data->tangan_kiri_igd?$data->tangan_kiri_igd :''):"" ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->kaki_kanan_igd)?($data->kaki_kanan_igd?$data->kaki_kanan_igd :''):"" ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data->kaki_kiri_igd)?($data->kaki_kiri_igd?$data->kaki_kiri_igd :''):"" ?></td>
                                    </tr>
                                </table>
                            </div>
                       

                        <p><b><u>MASALAH KEPERAWATAN</b></u></p>
                        <div style="margin-left:20px">
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("peningkatan_tekanan", $data-> masalah_keperawatan)?'checked':'':'') ?> > 
                                <span>Peningkatan Tekanan Intra Cranial</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("ketidak_efektifan", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Ketidakefektifan Perfusi Jaringan Cerebral</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("bersihan_jalan_nafas", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Bersihan Jalan Nafas</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("pola_nafas_tidak_efektif", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Pola Nafas Tidak Efektif</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("hipertermia", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Hipertermia</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("diare", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Diare</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("gangguan_menelan", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Gangguan Menelan</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("penurunan_curah_jantung", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Penurunan curah jantung</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan)?in_array("nyeri_akut", $data-> masalah_keperawatan)?'checked':'':'') ?> >
                                <span>Nyeri <?= isset($data->opsi_nyeri)?$data->opsi_nyeri == 'akut'?"(Akut /<del>Kronis</del>)":'(<del>Akut</del>/Kronis)':'(Akut /Kronis)'; ?></span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("ketidakseimbangan", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Ketidakseimbangan Nutrisi kurang dari kebutuhan tubuh</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("intoleranso_aktifitas", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Intoleransi AKtifitas</span>
                            </div>
                            
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("gangguan_mobilitas", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Gangguan Mobilias Fisik</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("hambatan_komunikasi", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Hambatan Komunikasi Verbal</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("diskontiunitas_jaringan", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Diskontiunitas jaringan</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data-> masalah_keperawatan2)?in_array("ketidakstabilan_kadar_gula", $data-> masalah_keperawatan2)?'checked':'':'') ?> >
                                <span>Ketidakstabilan kadar gula darah</span>
                            </div>
                            <div>
                                <input type="checkbox" name="" id="" <?= (isset($data->lainnyaa)?in_array("lainnya", $data->lainnyaa)?'checked':'':'') ?> >
                                <span><?= isset($data->check_lainnya8)?$data->check_lainnya8:'........................' ?></span>
                            </div>
                        </div>
                        <!-- end -->
                            
                        </div>
                    
        </div>
                
    </section>

    <section class="sheet padding-10mm">
        <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border: 2px solid black;"></div>

        <div class="margintb">
                <center>
                    <h4>ASSESMEN AWAL KEPERAWATAN IGD</h4>
                </center>
        </div>
        <div style="font-size:12px">

                <div>
                    <p><b><u>RENCANA ASUHAN KEPERAWATAN</b></u></p>
                    <table border=1 width="100%">
                        <tr>
                            <th width="17%" style="font-size:12px;">tgl/Jam</th>
                            <th width="30%" style="font-size:12px;" colspan="2">Intervensi Keperawatan</th>
                            <th width="30%" style="font-size:12px;">Evaluasi</th>
                            <th width="20%" style="font-size:12px;">Nama & TTD</th>
                        </tr>

                        <tr>
                            <td width="15%" style="font-size:12px;" rowspan="30">
                            <p style="text-align:center"><?= isset($data->waktu_intervensi)? date('d-m-Y',strtotime($data->waktu_intervensi)):''; ?></p>
                            <p style="text-align:center"><?= isset($data->waktu_intervensi)? date('H:i:s',strtotime($data->waktu_intervensi)):''; ?></p>
                        </td>
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name="" id="" <?= (isset($data->intervensi1)?in_array(1, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Observasi tingkat kesadaran,reaksi dan ukuran pupil fungsi sensorik motorik</td>
                            <td width="30%" style="text-align: left; padding-left: 5px;padding-right: 5px;font-size:12px;" rowspan="30">
                            <p>S :
                                <?= (isset($soap_pasien_rj->subjective_perawat)?$soap_pasien_rj->subjective_perawat:'') ?><br><br>
                            </p>
                            <p>O :
                                <?= isset($soap_pasien_rj->objective_perawat)? str_replace('-','<br>',$soap_pasien_rj->objective_perawat): '' ;?>
                                <br><br>
                            </p>
                            <p>A :
                                <?= (isset($soap_pasien_rj->assesment_perawat)?$soap_pasien_rj->assesment_perawat:'') ?><br><br>
                            </p>
                            <p>P : <br>Rencana Tindak Lanjut (Ruang Perawatan )
                                <?= (isset($soap_pasien_rj->plan_perawat)?$soap_pasien_rj->plan_perawat:'') ?><br><br>
                            </p>
                            </td>
                            <td width="20%" style="font-size:12px;text-align:center" rowspan="30">
                                <img width="120px" src="<?= isset($pemeriksa->ttd)?$pemeriksa->ttd:'' ?>" alt=""><br>
                                <span ><?= isset($pemeriksa->name)?$pemeriksa->name:''; ?></span>
                            </td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name="" id=""  <?= (isset($data->intervensi1)?in_array(2, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Observasi tanda tanda vital: TD, Nadi, RR , Suhu</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name="" id=""  <?= (isset($data->intervensi1)?in_array(3, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Monitor pernafasan : irama,pengembangan dinding dada,penggunaan otot tambahan pernafasan,bunyi nafas</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(4, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Lakukan pemasangan oksimetri</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(5, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Obervasi Produk sputum,jumlah,warna dan kekentalan</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(6, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Berikan posisi semi fowler atau posisi miring yang aman</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(7, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Lakukan pemasangan OPA</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(8, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Lakukan suction bila perlu</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(9, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Ajarkan pasien untuk nafas dalam dan batuk efektif</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(10, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Kompres</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(11, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Observasi turgor kulit</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(12, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Ajarkan tentang teknik non farmakologi</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(13, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Pantau reflek batuk,reflek muntah dan kemampuan menelan</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(14, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Monitor tanda hiperglikemia/hipoglikemia</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->intervensi1)?in_array(15, $data->intervensi1)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Lakukan kumbah lambung</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->berikan_oksigen)?in_array(16, $data->berikan_oksigen)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;"><span>Berikan oksigen<?= isset($data->check_oksigen)?' '.$data->check_oksigen.' ':'' ?></span></td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->imobilitas)?in_array(17, $data->imobilitas)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Imobilisasi daerah cedera : pasang bidai / spalak /sling</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->lakukan_perawatan_luka)?in_array(17, $data->lakukan_perawatan_luka)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Lakukan perawatan luka</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->Lainnya)?in_array(17, $data->Lainnya)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;"><?= isset($data->check_lainnya4)?$data->check_lainnya4:'' ?></td>
                        </tr>

                        <tr> 
                           
                            <td colspan ="2" width="30%" style="font-size:12px;">KOLABORASI</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->terapi_cairan)?in_array(18, $data->terapi_cairan)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;"><span>Terapi cairan: <?= isset($data->check_terapi)?' '.$data->check_terapi.' ':'' ?></span></td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->pemberian)?in_array(19, $data->pemberian)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;"><span>Pemberian oksigen: <?= isset($data->check_pemberian)?' '.$data->check_pemberian.' ':'' ?></span></td>
                        </tr>

                        
                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px">  <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(20, $data->nebulizer)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Nebulizer</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(21, $data->nebulizer)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Pemasangan NGT</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(22, $data->nebulizer)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Pemasangan DC</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(23, $data->nebulizer)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Heacting aff / jahit luka</td>
                        </tr>

                        <tr> 
                            <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"><input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(24, $data->nebulizer)?'checked':'':'') ?>></div></td>
                            <td width="30%" style="font-size:12px;">Pemberian obat</td>
                        </tr>
                        
                       
                    </table>
                </div> 

         
        </div>
        
    </section>
    
    <section class="sheet padding-10mm">
        <?php $this->load->view('emedrec/header_print') ?>
        <br>
        <div style="height:0px;border:2px solid black;">
            <div class="margintb">
                <center>
                    <h4>ASSESMENT AWAL KEPERAWATAN IGD</h4>
                </center>
            </div>
            <div style="font-size:12px">

            <table border=1 width="100%">
                <tr>
                    <th width="17%" style="font-size:12px;">tgl/Jam</th>
                    <th width="30%" style="font-size:12px;" colspan ="2">Intervensi Keperawatan</th>
                    <th width="30%" style="font-size:12px;">Evaluasi</th>
                    <th width="20%" style="font-size:12px;">Nama & TTD</th>
                </tr>
                <tr>
                    <td width="15%" style="font-size:12px;" rowspan="30"></td>
                    <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(25, $data->nebulizer)?'checked':'':'') ?>></div></td>
                    <td width="30%" style="font-size:12px;">DC Shock</td>
                    <td width="30%" style="font-size:12px;" rowspan="30"></td>
                    <td width="20%" style="font-size:12px;" rowspan="30"></td>
                </tr>
                <tr> 
                    <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->nebulizer)?in_array(26, $data->nebulizer)?'checked':'':'') ?>></div></td>
                    <td width="30%" style="font-size:12px;">RJP</td>
                </tr> 

                <tr> 
                    <td width="5%" style="font-size:12px;text-align:center;"><div style="margin-top:5px"> <input type="checkbox" name=""  <?= (isset($data->lainnyaa1)?in_array('lainnyaa1', $data->lainnyaa1)?'checked':'':'') ?>></div></td>
                    <td width="30%" style="font-size:12px;"><?= isset($data->check_lainnya2)?$data->check_lainnya2:'&nbsp;' ?></td>
                </tr>
            </table>


            <div style="min-height:500px">
            <p style="text-align:center;font-weight: bold;font-size: 12px;padding:5px">PEMBERIAN OBAT/INFUS/TINDAKAN</p>
            <table border="1" width="100%" >
                         
                            <tr>
                                <td style="text-align:center">Jam</td>
                                <td style="text-align:center">Tindakan</td>
                                <td style="text-align:center">Nama Obat/Infus</td>
                                <td style="text-align:center">Frekuensi</td>
                                <td style="text-align:center">Cara Pemberian</td>
                                <td style="text-align:center">Nama & Tanda Tangan</td>
                            </tr>
                            <?php
                          
                            $jml_array = isset($data->table1)?count($data->table1):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td style="text-align:center"><?= isset($data->table1[$x]->time)?$data->table1[$x]->time:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->tindakan)?$data->table1[$x]->tindakan:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->nama_obat_infus)?$data->table1[$x]->nama_obat_infus:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->dosis_frekuensi)?$data->table1[$x]->dosis_frekuensi:'' ?></td>
                                <td style="text-align:center"><?= isset($data->table1[$x]->cara_pemberian)?$data->table1[$x]->cara_pemberian:'' ?></td>
                                <td style="text-align:center">
                                    <?php
                                    if(isset($pemeriksa->ttd)){
                                    ?>
                                        <img width="120px" src="<?= ($pemeriksa->ttd)?$pemeriksa->ttd:'' ?>" alt=""><br>
                                        <span style="font-size:12px">(<?= ($pemeriksa->name)??""; ?>)</span><br>

                                    <?php }else{ ?>
                                        <br><br>
                                        <?php } ?>
                                </td>
                            </tr>
                                <?php } ?>

            </table>
            </div>

                <div class="ttd" >
                        <div id="childttd">
                            <span style="font-size:12px">
                                Bukittinggi, <?= isset($keperawatan[0]->tgl_assesment)?date('d-m-Y',strtotime($keperawatan[0]->tgl_assesment)):'-'; ?> <br>
                            </span>
                            <br>
                        <span style="font-size:12px">  Perawat IGD</span>
                            <table>
                            <tr>
                            <td>
                            <?php
                            if(isset($pemeriksa->ttd)){
                            ?>
                                <img width="120px" src="<?= ($pemeriksa->ttd)?$pemeriksa->ttd:'' ?>" alt="">

                            <?php }else{ ?>
                                <br><br>
                                <?php } ?>
                            </td>
                            </tr>
                            </table>
                            <span style="font-size:12px">(<?= ($pemeriksa->name)??""; ?>)</span><br>
                        </div>
                    
                </div>
            </div>
        </div>
    </section>

</body>

</html>