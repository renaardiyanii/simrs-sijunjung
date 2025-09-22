<?php
$data = (isset($nihss->formjson_dewasa)?json_decode($nihss->formjson_dewasa):'');
// $data_chunk = isset($data->question3[0]->question2)? array_chunk($data->question3[0]->question2,5):null;
//  var_dump($data);

?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 10px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
            
            
        }

        #data tr td{
            
            font-size: 11px;
            font-family:arial;
            
        }

        #data th{
            
            font-size: 11px;
            font-family:arial;
            
        }

        #noborder td{
            font-family: arial;
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
            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">THE NATIONAL INSTITUTE OF HEALTH STROKE SCALE (NIHSS)</p>
            <div style="font-size:12px;font-family:arial;line-height:180%;min-height:900px">
                <table id="data" width="100%" border="1" cellpadding="3px">
                    <tr>
                        <th width="3%" rowspan="3">No</th>
                        <th width="30%" rowspan="3">PARAMETER YANG DINILAI</th>
                        <th width="42%" rowspan="3">SKALA</th>
                        <th colspan="6">TANGGAL PEMERIKSAAN</th>
                    </tr>
                    <tr>

                        
                        <td width="5%"><center><?= isset($nihss->tanggal_pemeriksaan)?date('d/m/Y',strtotime($nihss->tanggal_pemeriksaan)):'' ?></center></td>
                        
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:center;font-weight:bold">SKOR</td>
                    </tr>


                    <tr>
                        <td style="text-align:center;vertical-align:middle">1a</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Tingkat Kesadaran</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Sadar penuh</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Tidak sadar penuh; dapat dibangunkan dengan stimulasi minor (suara)</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Tidak sadar penuh; dapat berespon dengan stimulasi berulang atau stimulasi nyeri</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Koma; tidak sadar dan tidak berespon dengan stimulasi apapun</td>
                                </tr>
                            </table>
                        </td>

                        
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'1'})?$data->question3[0]->{'1'}:'' ?></td>
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">1b</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Menjawab pertanyaan</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Benar semua</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>1 benar/ETT/disartria</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Salah semua/afasia/stupor/koma</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'2'})?$data->question3[0]->{'2'}:'' ?></td>
                     
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">1c</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Mengikuti perintah</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Mampu melakukan 2 perintah</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Mampu melakukan 1 perintah</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Tidak mampu melakukan perintah</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'3'})?$data->question3[0]->{'3'}:'' ?></td>
                        
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">2</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Gaze: Gerakan mata konyugat horizontal</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Normal</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Paresis gaze parsial pada 1 atau 2 mata,terdapat abnormal gaze namun forced deviation atau paresis gaze total tidak ada</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Forced deviation, atau paresis gaze total tidak dapat diatasi dengan maneuver okulosefalik</td>
                                </tr>
                            </table>
                        </td>
                     
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'4'})?$data->question3[0]->{'4'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">3</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Visual: Lapang pandang pada tes konfrontasi</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                            <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada gangguan</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia Parsial</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia Lengkap</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia bilateral</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'5'})?$data->question3[0]->{'5'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">4</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Paresis Wajah</td>
                        <td>
                        <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Normal</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia parsial</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia lengkap</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Hemianopsia bilateral</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'6'})?$data->question3[0]->{'6'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle" rowspan="2">5</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle" rowspan="2">Motorik Lengan</td>
                        <td rowspan="2">
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada drift; lengan dapat diangkat 90 (45)°, selama minimal 10 detik penuh</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Drift; lengan dapat diangkat 90 (45) namun turun sebelum 10 detik, tidak mengenai tempat tidur</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Ada upaya melawan gravitasi; lengan tidak dapat diangkat atau dipertahankan dalam posisi 90 (45)°, jatuh mengenai tempat tidur, nhamunada upaya melawan gravitasi</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada upaya melawan gravitasi, tidak mampu mengangkat, hanya bergeser</td>
                                </tr>
                                <tr>
                                    <td width="5%">4</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada gerakan</td>
                                </tr>
                                <tr>	
                                    <td width="5%">UN</td>
                                    <td width="5%">=</td>
                                    <td>Amputasi atau fusi sendi, jelaskan…………</td>
                                </tr>
                            </table>
                        </td>
                     
                            <td style="text-align:center;vertical-align:middle">Kanan : <?= isset($data->question3[0]->{'9'})?$data->question3[0]->{'9'}:'' ?></td>
                       
                    </tr>

                    <tr>
                    
                            <td style="text-align:center;vertical-align:middle">Kiri : <?= isset($data->question3[0]->{'8'})?$data->question3[0]->{'8'}:'' ?></td>
                       
                    </tr>

                </table>
            </div>
              
            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 1 dari 2
                </div>
                <div style="margin-left:530px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">THE NATIONAL INSTITUTE OF HEALTH STROKE SCALE (NIHSS)</p>
            <div style="font-size:12px;font-family:arial;line-height:180%;min-height:900px">
                <table id="data" width="100%" border="1" cellpadding="3px">
                    <tr>
                        <td width="3%" style="text-align:center;vertical-align:middle" rowspan="2">6</td>
                        <td width="30%" style="font-weight:bold;text-align:center;vertical-align:middle" rowspan="2">Motorik Tungkai</td>
                        <td width="42%" rowspan="2">
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada drift; tungkai dapat dipertahankan dalam posisi 30° minimal 5 detik</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Drift; tungkai jatuh persis 5 detik, namun tidak mengenai tempat tidur</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Ada upaya melawan gravitasi; tungkai jatuh mengenai tempat tidur dalam 5 detik, namun ada upaya melawan gravitasi</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada upaya melawan gravitasi</td>
                                </tr>
                                <tr>
                                    <td width="5%">4</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada gerakan</td>
                                </tr>
                                <tr>	
                                    <td width="5%">UN</td>
                                    <td width="5%">=</td>
                                    <td>Amputasi atau fusi sendi, jelaskan…………</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle">Kanan :<?= isset($data->question3[0]->{'12'})?$data->question3[0]->{'12'}:'' ?></td>
                       
                    </tr>

                    <tr>
                   
                            <td width ="5%" style="text-align:center;vertical-align:middle">Kiri :<?= isset($data->question3[0]->{'11'})?$data->question3[0]->{'11'}:'' ?></td>
                      
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">7</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Ataksia anggota gerak</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada ataksia</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Ataksia pada satu ekstremitas</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Ataksia pada 2 atau lebih ekstremitas</td>
                                </tr>
                                <tr>
                                    <td width="5%">UN</td>
                                    <td width="5%">=</td>
                                    <td>Amputasi atau fusi sendi, jelaskan…………</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'13'})?$data->question3[0]->{'13'}:'' ?></td>
                      
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">8</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Sensorik</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Normal; tidak ada gangguan sensorik</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Gangguan sensorik ringan-sedang; sensasi disentuh atau nyeri berkurang namun masih terasa disentuh</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Gangguan sensorik berat; tidak merasakan sentuhan di wajah, lengan, atau tungkai</td>
                                </tr>
                            </table>
                        </td>
                      
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'14'})?$data->question3[0]->{'14'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">9</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Bahasa Terbalik</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Normal; tidak ada afasia</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Afasia ringan-sedang; dapat berkomunikasi namun terbatas. Masih dapat mengenali benda namun kesulitan bicara percakapan dan mengerti percakapan</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Afasia berat; seluruh komunikasi melalui ekspresi yang terfragmentasi, dikira-kira dan pemeriksa tidak dapat memahami respons pasien</td>
                                </tr>
                                <tr>
                                    <td width="5%">3</td>
                                    <td width="5%">=</td>
                                    <td>Mutisme, afasia global; tidak ada kata-kata yang keluar maupun pengertian akan kata-kata</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'15'})?$data->question3[0]->{'15'}:'' ?></td>
                     
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">10</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Disartria</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Normal</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Disartria ringan-sedang; pasien pelo setidaknya pada beberapa kata namun meski berat dapat dimengerti</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Disartria berat; bicara pasien sangat pelo namun tidak afasia</td>
                                </tr>
                                <tr>
                                    <td width="5%">UN</td>
                                    <td width="5%">=</td>
                                    <td>Intubasi atau hambatan fisik lain, jelaskan</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'16'})?$data->question3[0]->{'16'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle">11</td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle">Pengabaian & Inatensi (Neglect)</td>
                        <td>
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%">0</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada neglect</td>
                                </tr>
                                <tr>
                                    <td width="5%">1</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada atensi pada salah satu modalitas berikut; visual, tactile, auditory, spatial, or personal inattention</td>
                                </tr>
                                <tr>
                                    <td width="5%">2</td>
                                    <td width="5%">=</td>
                                    <td>Tidak ada atensi pada lebih dari satu modalitas</td>
                                </tr>
                            </table>
                        </td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->{'17'})?$data->question3[0]->{'17'}:'' ?></td>
                       
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle"></td>
                        <td style="font-weight:bold;text-align:center;vertical-align:middle" colspan="2">TOTAL</td>
                       
                            <td width ="5%" style="text-align:center;vertical-align:middle"><?= isset($data->question3[0]->total)?$data->question3[0]->total:'' ?></td>
                        
                    </tr>

                    <tr>
                        <td style="text-align:center;vertical-align:middle"></td>
                        <td colspan="8">
                            <table id="noborder" width="100%" cellpadding="2px">
                                <tr>
                                    <td width="5%" style="font-weight:bold">Keterangan</td>
                                    <td width="2%" style="font-weight:bold">:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold">Skor < 5</td>
                                    <td style="font-weight:bold">=</td>
                                    <td style="font-weight:bold">defisit neurologis ringan</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold">Skor 6-14</td>
                                    <td style="font-weight:bold">=</td>
                                    <td style="font-weight:bold">defisit neurologis sedang</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold">Skor 15-24</td>
                                    <td style="font-weight:bold">=</td>
                                    <td style="font-weight:bold">defisit neurologis berat</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold">Skor ≥ 25</td>
                                    <td style="font-weight:bold">=</td>
                                    <td style="font-weight:bold">defisit neurologis sangat berat</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

                <table id="data" width="100%" border="1" cellpadding="3px">
                    <tr>
                        <td width="30%"><center><img src="<?= base_url('assets/images/nihss1.PNG') ?>" height="160px" width="180px" alt=""></center></td>
                        <td width="30%"><center><img src="<?= base_url('assets/images/nihss2.PNG') ?>" height="160px" width="180px" alt=""></center></td>
                        <td width="40%">
                            <p style="text-align:center;font-weight:bold;font-family:arial;font-size:13px">Anda tahu kenapa</p>
                            <p style="text-align:center;font-weight:bold;font-family:arial;font-size:13px">Jatuh ke bumi</p>
                            <p style="text-align:center;font-weight:bold;font-family:arial;font-size:13px">Saya pulang dari kerja</p>
                            <p style="text-align:center;font-weight:bold;font-family:arial;font-size:13px">Dekat meja di ruang Makan</p>
                            <p style="text-align:center;font-weight:bold;font-family:arial;font-size:13px">Mereka mendengar dia siaran di radio tadi malam</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 2 dari 2
                </div>
                <div style="margin-left:530px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
        </div>



    </body>

   
</html>