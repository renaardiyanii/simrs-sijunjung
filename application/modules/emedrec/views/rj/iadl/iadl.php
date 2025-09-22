<?php 
$data = (isset($iadl->formjson)?json_decode($iadl->formjson):'');
// var_dump($data);
?>

<!DOCTYPE html>
<html>
    <head><title>INSTRUMENTAL ACTIVITIES OF DAILY LIVING (IADL)</title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 12px;
            position: relative;
            text-align: justify;
            font-family: arial;
           
        }
        #data th {
            font-family: arial;
            font-size: 13px;
            text-align:center
        }

        #data td {
            font-family: arial;
            font-size: 12px;
        }

        #noborder td{
            font-family: arial;
            font-size: 12px;
        }

        #divid{
            font-size:12px;
            font-family:arial;
        }

        .bg-checked{
        background-color:#64C9CF;
        } 


        
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
           
            <p style = "font-weight:bold; font-size: 14px; text-align: center;font-family:arial">
                INSTRUMENTAL ACTIVITIES OF DAILY LIVING (IADL)
            </p>
            
           
                <table id="noborder" width="100%" cellpadding="5px">
                    <tr>
                        <td width="20%">Nama Pewawancara</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question2->text1)?$data->question2->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Tanggal Wawancara</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question2->text2)?date('d-m-Y',strtotime($data->question2->text2)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Pendidikan	Pasien</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question2->text3)?$data->question2->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Jam Mulai</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question2->text4)?$data->question2->text4:'' ?></td>
                    </tr>
                </table><br>

                <table id="data" width="100%" cellpadding="4px" border="1">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Fungsi</th>
                        <th width="10%">Nilai</th>
                        <th>Keterangan</th>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">1</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Menggunakan telepon</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='0'?"bg-checked":"":''; ?>">Tidak mampu (termasuk yang tidak/memiliki telepon)</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='1'?"bg-checked":"":''; ?>">Sebagian dibantu (mampu menjawab telepon, tapi tidak dapat mengoperasikannya)</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'1'})?$data->question3->item1->{'1'} =='2'?"bg-checked":"":''; ?>">Mampu mengoperasikan telepon</td>
                    </tr>


                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">2</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center" >Berbelanja</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='0'?"bg-checked":"":''; ?>">Tidak mampu</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='1'?"bg-checked":"":''; ?>">Mampu belanja sendiri untuk keperluan terbatas (3buah/kurang, selebihnya perlu bantuan orang lain)</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'2'})?$data->question3->item1->{'2'} =='2'?"bg-checked":"":''; ?>">Mandiri</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">3</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center" >Menyiapkan makanan</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='0'?"bg-checked":"":''; ?>">Tidak mampu</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='1'?"bg-checked":"":''; ?>">Mampu menyiapkan makanan bila telah disediakan bahan-bahannya atau menghangatkan makanan yang telah dimasak</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'3'})?$data->question3->item1->{'3'} =='2'?"bg-checked":"":''; ?>">Mandiri</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">4</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Mengurus rumah</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='0'?"bg-checked":"":''; ?>">Tidak mampu</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='1'?"bg-checked":"":''; ?>">Mampu mengerjakan tugas harian yang ringan, dengan hasil yang kurang rapi atau tidak bersih</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'4'})?$data->question3->item1->{'4'} =='2'?"bg-checked":"":''; ?>">Mandiri</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">5</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Mencuci pakaian</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='0'?"bg-checked":"":''; ?>">Tidak mampu</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='1'?"bg-checked":"":''; ?>">Mampu mencuci/menyetrika jenis pakaian yang ringan, lainnya perlu bantuan orang lain</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'5'})?$data->question3->item1->{'5'} =='2'?"bg-checked":"":''; ?>">Mandiri (termasuk yang menggunakan mesin cuci)</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">6</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Mengadakan transportasi</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='0'?"bg-checked":"":''; ?>">Tidak mampu bepergian dengan sarana transportasi apapun</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='1'?"bg-checked":"":''; ?>">Bepergian dengan transportasi umum/taksi atau mobil pribadi, bila dibantu/ditemani orang lain</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'6'})?$data->question3->item1->{'6'} =='2'?"bg-checked":"":''; ?>">Mandiri</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">7</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Tanggung jawab pengobatan</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='0'?"bg-checked":"":''; ?>">Butuh pertolongan orang lain untuk mengkonsumsi obat-obatan</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='1'?"bg-checked":"":''; ?>">Mampu, bila obat sudah dipersiapkan sebelumnya</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'7'})?$data->question3->item1->{'7'} =='2'?"bg-checked":"":''; ?>">Mandiri</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">8</td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">Mengatur keuangan</td>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='0'?"bg-checked":"":''; ?>">0</td>
                        <td class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='0'?"bg-checked":"":''; ?>">Tidak mampu</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='1'?"bg-checked":"":''; ?>">1</td>
                        <td class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='1'?"bg-checked":"":''; ?>">Mampu atur belanja harian, tapi butuh pertolongan dalam urusan bank/pembelian dalam jumlah besar</td>
                    </tr>

                    <tr>
                        <td style="vertical-align:middle;text-align:center" class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='2'?"bg-checked":"":''; ?>">2</td>
                        <td class="<?= isset($data->question3->item1->{'8'})?$data->question3->item1->{'8'} =='2'?"bg-checked":"":''; ?>">Mampu mengatur masalah keuangan (anggaran rumah tangga, membayar sewa, kwitansi, urusan bank) atau memantau penghasilan</td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="vertical-align:middle;text-align:center"></td>
                        <td rowspan="3" style="vertical-align:middle;text-align:center">TOTAL NILAI</td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question3->item1->total)?$data->question3->item1->total:'' ?></td>
                        <td></td>
                    </tr>
                </table>

                <div id="divid">
                    <span style="font-family:arial">Catatan: Tidak berlaku apabila tidak pernah melakukan aktivitas di atas</span>
                </div>
                <table id="noborder" width="100%" cellpadding="5px">
                    <tr>
                        <td width="12%">NILAI IADL :</td>
                        <td width="5%" class="<?= isset($data->question3->item1->total)?$data->question3->item1->total >= 9?"bg-checked":"":''; ?>">9-16 </td>
                        <td>&#129138; Mandiri/tidak perlu bantuan</td>
                    </tr>
                    <tr>
                        <td width="12%"></td>
                        <td width="5%"   class="<?= isset($data->question3->item1->total)?$data->question3->item1->total >= 1 && $data->question3->item1->total <= 8 ?"bg-checked":"":''; ?>">1-8</td>
                        <td>&#129138; Perlu bantuan</td>
                    </tr>
                    <tr>
                        <td width="12%"></td>
                        <td width="5%" class="<?= isset($data->question3->item1->total)?$data->question3->item1->total == 1 ?"bg-checked":"":''; ?>">0</td>
                        <td>&#129138; Tidak dapat melakukan apa-apa</td>
                    </tr>
                </table>
                <br><br>
                <div style="display:flex;font-size:12px;font-family:arial">
                    <div>
                        <p></p>
                    </div>
                    <div style="margin-left:650px;">
                        <p style="font-family:arial">Hal 1 dari 4</p>
                    </div>
                </div>
            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>
           <br><br>
            
            <table id="noborder" width="100%" cellpadding="5px">
            <tr>
                        <td width="20%">Nama Pewawancara</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question5->text1)?$data->question5->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Tanggal Wawancara</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question5->text2)?date('d-m-Y',strtotime($data->question5->text2)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Pendidikan	Pasien</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question5->text3)?$data->question5->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Jam Mulai</td>
                        <td width="5%">:</td>
                        <td><?= isset($data->question5->text4)?$data->question5->text4:'' ?></td>
                    </tr>
                </table>
            <p style = "font-weight:bold; font-size: 12px; text-align: center;font-family:arial">ADL Barthel</p>
            <table id="data" width="100%" cellpadding="4px" border="1">
                <tr>
                    <th width="40%">Jenis Kegiatan</th>
                    <th width="15%">I</th>
                    <th width="15%">II</th>
                    <th width="15%">III</th>
                    <th width="15%">IV</th>
                </tr>
                <tr>
                    <td>Mengendalikan rangsang pembuangan tinja</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'1'})?$data->question6->item1->{'1'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'1'})?$data->question6->item1->{'1'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'1'})?$data->question6->item1->{'1'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'1'})?$data->question6->item1->{'1'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Mengendalikan rangsang berkemih</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'2'})?$data->question6->item1->{'2'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'2'})?$data->question6->item1->{'2'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'2'})?$data->question6->item1->{'2'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'2'})?$data->question6->item1->{'2'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Membersihkan diri</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'3'})?$data->question6->item1->{'3'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'3'})?$data->question6->item1->{'3'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'3'})?$data->question6->item1->{'3'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'3'})?$data->question6->item1->{'3'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Menggunakan jamban</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'4'})?$data->question6->item1->{'4'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'4'})?$data->question6->item1->{'4'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'4'})?$data->question6->item1->{'4'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'4'})?$data->question6->item1->{'4'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Makan</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'5'})?$data->question6->item1->{'5'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'5'})?$data->question6->item1->{'5'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'5'})?$data->question6->item1->{'5'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'5'})?$data->question6->item1->{'5'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Berubah sikap dari berbaring ke duduk</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'6'})?$data->question6->item1->{'6'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'6'})?$data->question6->item1->{'6'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'6'})?$data->question6->item1->{'6'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'6'})?$data->question6->item1->{'6'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Berpindah atau berjalan</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'7'})?$data->question6->item1->{'7'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'7'})?$data->question6->item1->{'7'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'7'})?$data->question6->item1->{'7'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'7'})?$data->question6->item1->{'7'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Memakai baju</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'8'})?$data->question6->item1->{'8'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'8'})?$data->question6->item1->{'8'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'8'})?$data->question6->item1->{'8'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'8'})?$data->question6->item1->{'8'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Naik turun tangga</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'9'})?$data->question6->item1->{'9'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'9'})?$data->question6->item1->{'9'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'9'})?$data->question6->item1->{'9'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'9'})?$data->question6->item1->{'9'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td>Mandi</td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'10'})?$data->question6->item1->{'10'} =='1'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'10'})?$data->question6->item1->{'10'} =='2'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'10'})?$data->question6->item1->{'10'} =='3'?"✓":"":''; ?></td>
                    <td style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->{'10'})?$data->question6->item1->{'10'} =='4'?"✓":"":''; ?></td>
                </tr>
                <tr>
                    <td >TOTAL</td>
                    <td colspan="4" style="vertical-align:middle;text-align:center"><?= isset($data->question6->item1->total)?$data->question6->item1->total:''; ?></td>
                   
                </tr>
            </table>
            <span style="font-size:12px;font-family:arial;font-weight:bold">Keterangan:</span>

            <table id="noborder" width="100%" cellpadding="5px">
               <tr>
                    <td width="3%">I</td>
                    <td>:Penilaian sebelum sakit</td>
               </tr>
               <tr>
                    <td width="3%">II</td>
                    <td>:Penilaian saat masuk rumah sakit</td>
               </tr>
               <tr>
                    <td width="3%">III</td>
                    <td>:Setelah 1 minggu perawatan</td>
               </tr>
               <tr>
                    <td width="3%">IV</td>
                    <td>:Saat pasien mau pulang</td>
               </tr>
            </table>

            <table id="noborder" width="100%" cellpadding="5px">
                <tr>
                    <td width="15%">NILAI ADL:</td>
                    <td width="7%"  class="<?= isset($data->question6->item1->total)?$data->question6->item1->total >= 20 ?"bg-checked":"":''; ?>">>20</td>
                    <td width="25%">&#129034; Mandiri</td>
                    <td width="5%" class="<?= isset($data->question6->item1->total)?$data->question6->item1->total >= 5 && $data->question6->item1->total <= 8?"bg-checked":"":''; ?>">5-8</td>
                    <td>&#129034; Ketergantungan berat</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="<?= isset($data->question6->item1->total)?$data->question6->item1->total >= 12 && $data->question6->item1->total <= 19?"bg-checked":"":''; ?>">12-19</td>
                    <td>&#129034; Ketergantungan ringan</td>
                    <td class="<?= isset($data->question6->item1->total)?$data->question6->item1->total >= 0 && $data->question6->item1->total <= 4?"bg-checked":"":''; ?>">0-4</td>
                    <td>&#129034; Ketergantungan total</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="<?= isset($data->question6->item1->total)?$data->question6->item1->total >= 9 && $data->question6->item1->total <= 11?"bg-checked":"":''; ?>">9-11</td>
                    <td>&#129034; Ketergantungan sedang</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:12px;font-family:arial">
                    <div>
                        <p></p>
                    </div>
                    <div style="margin-left:650px;">
                        <p style="font-family:arial">Hal 2 dari 4</p>
                    </div>
                </div>
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
           
            <p style = "font-weight:bold; font-size: 14px; text-align: center;font-family:arial">
                 MINI MENTAL STATE EXAMINATION (MMSE)
            </p>
                <table id="noborder" width="100%" cellpadding="5px">
                    <tr>
                        <td width="20%">Nama Pewawancara</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question18->text1)?$data->question18->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Tanggal Wawancara</td>
                        <td>:</td>
                        <td><?= isset($data->question18->text2)?date('d-m-Y',strtotime($data->question18->text2)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Pendidikan	Pasien</td>
                        <td>:</td>
                        <td><?= isset($data->question18->text3)?$data->question18->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Jam Mulai</td>
                        <td>:</td>
                        <td><?= isset($data->question18->text4)?$data->question18->text4:'' ?></td>
                    </tr>
                </table><br>
                <table id="data" width="100%" cellpadding="4px" border="1">
                    <tr>
                        <th width="15%">Skor Maksimum</th>
                        <th width="15%">Skor Responden</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;vertical-align:middle;text-align:center">Orientasi</td>
                    </tr>
                    <tr>
                        
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question8->{'1'}->{'1'})?$data->question8->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question8->{'1'}->{'2'})?$data->question8->{'1'}->{'2'}:'' ?></td>
                        <td>Sekarang hari, tanggal, bulan, tahun berapa? Musim apa?</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question10->{'1'}->{'1'})?$data->question10->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question10->{'1'}->{'2'})?$data->question10->{'1'}->{'2'}:'' ?></td>
                        <td>Sekarang kita berada di mana? (jalan, nomor rumah, kota, kabupaten, provinsi)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;vertical-align:middle;text-align:center">Registrasi</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question11->{'1'}->{'1'})?$data->question11->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question11->{'1'}->{'2'})?$data->question11->{'1'}->{'2'}:'' ?></td>
                        <td>Pewawancara menyebutkan nama 3 buah benda, 1 detik untuk tiap benda. Kemudian mintalah manula mengulang ke 3 nama benda tersebut. Berikan 1 angka untuk setiap jawaban yang benar. Bila masih salah, ulanglah penyebutan ke 3 nama benda tersebut sampai ia dapat mengulangnya dengan benar. Hitunglah jumlah percobaan dan catatlah. (misal: bola, kursi, sepatu)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;vertical-align:middle;text-align:center">Atensi dan Kalkulasi</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question12->{'1'}->{'1'})?$data->question12->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question12->{'1'}->{'2'})?$data->question12->{'1'}->{'2'}:'' ?></td>
                        <td>Hitunglah berturut-turut selang 7 mulai dari 100 ke bawah. Berilah 1 angka untuk setiap jawaban yang benar. Berhenti setelah 5 hitungan (93,86, 79, 72, 65). Kemungkinan lain, ejalah kata “dunia” dari akhir ke awal (a, i, n, u, d). Satu nilai untuk setiap jawaban yang benar.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;vertical-align:middle;text-align:center">Mengingat</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question13->{'1'}->{'1'})?$data->question13->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question13->{'1'}->{'2'})?$data->question13->{'1'}->{'2'}:'' ?></td>
                        <td>Tanyalah kembali 3 nama benda yang telah disebutkan di atas. Berilah 1 angka untuk setiap jawaban yang benar.</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;vertical-align:middle;text-align:center">Bahasa</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question14->{'1'}->{'1'})?$data->question14->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question14->{'1'}->{'2'})?$data->question14->{'1'}->{'2'}:'' ?></td>
                        <td>a.	Apakah nama benda-benda ini? Perlihatkan arloji dan pensil (2 nilai)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question15->{'1'}->{'1'})?$data->question15->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question15->{'1'}->{'2'})?$data->question15->{'1'}->{'2'}:'' ?></td>
                        <td>b.	Ulanglah kalimat berikut: “Jika Tidak, dan Atau Tapi” (1 nilai)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question16->{'1'}->{'1'})?$data->question16->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question16->{'1'}->{'2'})?$data->question16->{'1'}->{'2'}:'' ?></td>
                        <td>c.	Laksanakanlah 3 buah perintah ini: “peganglah selembar kertas dengan tangan kananmu, lipatlah kertas itu pada pertengahan, dan letakkan di lantai” (3 nilai)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question17->{'1'}->{'1'})?$data->question17->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question17->{'1'}->{'2'})?$data->question17->{'1'}->{'2'}:'' ?></td>
                        <td>d.	Bacalah dan laksanakan perintah berikut: “PEJAMKAN MATA ANDA” (1 nilai)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question19->{'1'}->{'1'})?$data->question19->{'1'}->{'1'}:'' ?></td>
                        <td style="vertical-align:middle;text-align:center"><?= isset($data->question19->{'1'}->{'2'})?$data->question19->{'1'}->{'2'}:'' ?></td>
                        <td>e.	Tulislah sebuah kalimat! (1 nilai)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>f.	Tirulah gambar ini!<br>
                        <img src="<?= base_url('assets/images/iadl.PNG') ?>" height="70px" width="100px" alt="">
                        <img width="80px" src="<?= isset($data->question24)?$data->question24:'' ?>" alt="">

                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah Nilai</td>
                        <td></td>
                        <td>Tandai tingkat kesadaran manula pada garis aksis di bawah ini dengan huruf “x”<br>
                            <span style="font-family:arial">Sadar ( <?= isset($data->question27->item1->Sadar)?$data->question27->item1->Sadar:'' ?>  )</span>&nbsp;&nbsp;&nbsp;
                            <span style="font-family:arial">Somnolen  ( <?= isset($data->question27->item1->Somnolen)?$data->question27->item1->Somnolen:'' ?>  )</span>&nbsp;&nbsp;&nbsp;
                            <span style="font-family:arial">Stupor  (  <?= isset($data->question27->item1->Stupor)?$data->question27->item1->Stupor:'' ?> )</span>&nbsp;&nbsp;&nbsp;
                            <span style="font-family:arial">Koma  (  <?= isset($data->question27->item1->Koma)?$data->question27->item1->Koma:'' ?> )</span>
                        </td>
                    </tr>

                </table><br>
                <table id="noborder" width="100%" cellpadding="5px">
                    <tr>
                        <td width="20%">Jam selesai</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question26->text1)?$data->question26->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Tempat wawancara</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question26->text2)?$data->question26->text2:'' ?></td>
                    </tr>
                </table><br><br><br><br><br>
                <div style="display:flex;font-size:12px;font-family:arial">
                    <div>
                        <p></p>
                    </div>
                    <div style="margin-left:650px;">
                        <p style="font-family:arial">Hal 3 dari 4</p>
                    </div>
                </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>
           
           <p style = "font-weight:bold; font-size: 14px; text-align: center;font-family:arial">
                GERIATRIC DEPRESSION SCALE 15 (GDS 15)
            </p>
            <div id="divid">
                <p style="font-family:arial">
                Pilihlah jawaban yang paling tepat untuk menggambarkan bagaimana perasaan anda selama satu minggu terakhir!
                </p>

                <table id="noborder" width="100%" cellpadding="5px">
                    <tr>
                        <td width="2%">1.</td>
                        <td width="70%">Apakah anda sebenarnya puas dengan kehidupan anda?</td>
                        <td>
                            <span class="<?= isset($data->question9->item1->{'0'})?$data->question9->item1->{'0'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'0'})?$data->question9->item1->{'0'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>2.	Apakah anda telah meninggalkan banyak kegiatan dan minat atau kesenangan anda?</td>
                        <td>
                            <span class="<?= isset($data->question9->item1->{'1'})?$data->question9->item1->{'1'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'1'})?$data->question9->item1->{'1'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Apakah anda merasa kehidupan anda kosong?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'2'})?$data->question9->item1->{'2'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                        <span>/</span>
                        <span class="<?= isset($data->question9->item1->{'2'})?$data->question9->item1->{'2'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Apakah anda sering merasa bosan?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'3'})?$data->question9->item1->{'3'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                        <span>/</span>
                        <span class="<?= isset($data->question9->item1->{'3'})?$data->question9->item1->{'3'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Apakah anda mempunyai semangat yang baik setiap saat?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'4'})?$data->question9->item1->{'4'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                        <span>/</span>
                        <span class="<?= isset($data->question9->item1->{'4'})?$data->question9->item1->{'4'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Apakah anda takut bahwa sesuatu yang buruk akan terjadi pada anda?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'5'})?$data->question9->item1->{'5'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'5'})?$data->question9->item1->{'5'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Apakah anda merasa bahagia dalam sebagian besar hidup anda?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'6'})?$data->question9->item1->{'6'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'6'})?$data->question9->item1->{'6'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                     </tr>
                    <tr>
                        <td>8.</td>
                        <td>Apakah anda sering merasa tidak berdaya?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'7'})?$data->question9->item1->{'7'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'7'})?$data->question9->item1->{'7'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>9.</td>
                        <td>Apakah anda lebih senang tinggal di rumah daripada pergi keluar dan	melakukan sesuatu yang baru?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'8'})?$data->question9->item1->{'8'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'8'})?$data->question9->item1->{'8'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>10.</td>
                        <td>Apakah anda merasa mempunyai banyak masalah dengan daya ingat anda dibandingkan dengan kebanyakan orang?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'9'})?$data->question9->item1->{'9'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'9'})?$data->question9->item1->{'9'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                         </td>
                    </tr>
                    <tr>
                        <td>11.</td>
                        <td>Apakah anda pikir bahwa kehidupan anda sekarang menyenangkan?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'10'})?$data->question9->item1->{'10'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'10'})?$data->question9->item1->{'10'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12.</td>
                        <td>Apakah anda merasa tidak berharga seperti perasaan anda saat ini?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'11'})?$data->question9->item1->{'11'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'11'})?$data->question9->item1->{'11'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>13.</td>
                        <td>Apakah anda merasa penuh semangat?	</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'12'})?$data->question9->item1->{'12'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'12'})?$data->question9->item1->{'12'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>14.</td>
                        <td>Apakah anda merasa bahwa keadaan anda tidak ada harapan?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'13'})?$data->question9->item1->{'13'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'13'})?$data->question9->item1->{'13'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td>15.</td>
                        <td>Apakah anda pikir bahwa orang lain, lebih baik keadaannya daripada anda?</td>
                        <td>
                         <span class="<?= isset($data->question9->item1->{'14'})?$data->question9->item1->{'14'} =='1'?"bg-checked":"":''; ?>">Ya</span>
                            <span>/</span>
                            <span class="<?= isset($data->question9->item1->{'14'})?$data->question9->item1->{'14'} =='0'?"bg-checked":"":''; ?>">Tidak</span>
                        </td>
                        </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Skor Total : <?= isset($data->question9->item1->total)?$data->question9->item1->total:'' ?></td>
                    </tr>
                </table>
                <p style="font-family:arial">Skor: hitung jumlah jawaban yang bercetak tebal</p>
                <li style="font-family:arial">Setiap jawaban bercetak tebal mempunyai nilai 1</li><br>
                <li style="font-family:arial">Skor 5-9 menunjukkan kemungkinan besar depresi</li><br>
                <li style="font-family:arial">Skor 10 atau lebih menunjukkan depresi</li>
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <div style="display:flex;font-size:12px;font-family:arial">
                    <div>
                        <p></p>
                    </div>
                    <div style="margin-left:650px;">
                        <p style="font-family:arial">Hal 4 dari 4</p>
                    </div>
                </div>

        </div>
            
    </body>
</html>