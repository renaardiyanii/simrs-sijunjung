
<?php
$data = (isset($geriatri->formjson)?json_decode($geriatri->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
</head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10.5px;
            position: relative;
        }

        #data tr td{
            font-size: 10.5px;
        }
       
        #ortu {
            border-left: 1px solid;
            border-right: 1px solid;
            border-top: 1px solid;
            border-bottom: 1px solid;
        }

        #allo {
            border-left: 1px solid;
            border-right: 1px solid;
            border-top: 1px solid;
        }

        #keluhan {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        }

        #riwayat {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        }

        #pemeriksaanfisik {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        } #gizi tr td {
            border: 1px solid;
            font-size: 10px;
        }
        .penanda{
            background-color:#3498db; 
            color:white;
        }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p>Hari / Tanggal : <?= isset($data->question3)?date('d-m-Y',strtotime($data->question3)):'' ?>	Jam :<?= isset($data->question3)?date('h:i',strtotime($data->question3)):'' ?> WIB</p>
            <p><b>I.	Pengkajian Status Mental Mini</b><br>
            <span>Mini Mental State Examination(MMSE)</span></p>

            <table id="data" border="1">
                <tr>
                    <th style="width: 20%">Nilai Maksimum</th>
                    <th style="width: 20%">Nilai Responden</th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%"> </th>
                </tr>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%">ORIENTASI </th>
                </tr>
                <tr>
                    <td style="width: 20%;text-align: center;">5</td>
                    <td style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"><?= isset($data->orientasi->item1->{'Column 2'})?$data->orientasi->item1->{'Column 2'}:'' ?></td>
                    <td style="width: 50%">5.Sekarang (hari-tanggal-bulan-tahun) berapa dan musim apa?</td>
                </tr>
                <tr>
                    <td rowspan="3" style="width: 20%;text-align: center;">5</td>
                    <td rowspan="3" style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->orientasi->item2->{'Column 2'})?$data->orientasi->item2->{'Column 2'}:'' ?></td>
                    <td style="width: 50%">Sekarang kita berada di mana?</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->orientasi->item3->{'Column 2'})?$data->orientasi->item3->{'Column 2'}:'' ?></td>
                    <td style="width: 50%">(Nama rumah sakit atau instansi)</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->orientasi->item4->{'Column 2'})?$data->orientasi->item4->{'Column 2'}:'' ?></td>
                    <td style="width: 50%">(Instansi, jalan, nomor rumah, kota, kabupaten, propinsi)</td>
                </tr>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%">REGISTRASI</th>
                </tr>
                <tr>
                    <td rowspan="3" style="width: 20%;text-align: center;">3</td>
                    <td rowspan="3" style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->registrasi->item1->{'Column 2'})?$data->registrasi->item1->{'Column 2'}:'' ?></td>
                    <td  style="width: 50%">Pewawancara menyebutkan nama 3 buah benda, misalnya: (bola, kursi, sepatu).<br>
                                            Satu detik untuk tiap benda. Kemudian mintalah responden mengulang ketiga <br>
                                            nama benda tersebut.</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;"><?= isset($data->registrasi->item2->{'Column 2'})?$data->registrasi->item2->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">Berilah nilai 1 untuk tiap jawaban yang benar, bila masih salah ulangi penyebutan ketiga nama tersebut sampai responden dapat mengatakannya dengan benar:</td>
                </tr>
                <tr>
                    
                    <td  style="width: 10%;text-align: center;"><?= isset($data->registrasi->item3->{'Column 2'})?$data->registrasi->item3->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">Hitunglah jumlah percobaan dan catatlah : ______ kali</td>
                </tr>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%">ATENSI DAN KALKULASI</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 20%;text-align: center;">5</td>
                    <td rowspan="2" style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->atensi->item1->{'Column 2'})?$data->atensi->item1->{'Column 2'}:'' ?></td>
                    <td  style="width: 50%">Hitunglah berturut-turut selang 7 angka mulai dari 100 ke bawah. 
                        Berhenti setelah 5 kali hitungan (93-86-79-72-65). 
                        Kemungkinan lain ejaan kata dengan lima huruf, misalnya 'DUNIA' dari akhir ke awal/ dari kanan ke kiri :'AINUD'</td>
                </tr>
                <tr>
                    
                    <td  style="width: 10%;text-align: center;"><?= isset($data->atensi->item2->{'Column 2'})?$data->atensi->item2->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">Satu (1) nilai untuk setiap jawaban benar.</td>
                </tr>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%">MENGINGAT</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 20%;text-align: center;">5</td>
                    <td rowspan="2" style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"> <?= isset($data->mengingat->item1->{'Column 2'})?$data->mengingat->item1->{'Column 2'}:'' ?></td>
                    <td  style="width: 50%">Tanyakan kembali nama ketiga benda yang telah disebut di atas.</td>
                </tr>
                <tr>
                    
                    <td  style="width: 10%;text-align: center;"><?= isset($data->mengingat->item2->{'Column 2'})?$data->mengingat->item2->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">Berikan nilai 1 untuk setiap jawaban yang benar</td>
                </tr>
                <tr>
                    <th style="width: 20%"></th>
                    <th style="width: 20%"></th>
                    <th style="width: 10%"> </th>
                    <th style="width: 50%">BAHASA</th>
                </tr>
                <tr>
                    <td rowspan="8" style="width: 20%;text-align: center;">9</td>
                    <td rowspan="8" style="width: 20%"></td>
                    <td style="width: 10%;text-align: center;"><?= isset($data->bahasa->item1->{'Column 2'})?$data->bahasa->item1->{'Column 2'}:'' ?> </td>
                    <td  style="width: 50%">a. Apakah nama benda ini? Perlihatkan pensil dan arloji</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"><?= isset($data->bahasa->item2->{'Column 2'})?$data->bahasa->item2->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">b. Ulangi kalimat berikut :"JIKA TIDAK, DAN ATAU TAPI"</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"> <?= isset($data->bahasa->item3->{'Column 2'})?$data->bahasa->item3->{'Column 2'}:'' ?></td>
                    <td   style="width: 50%">c. Laksanakan 3 perintah ini :</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"> <?= isset($data->bahasa->item4->{'Column 2'})?$data->bahasa->item4->{'Column 2'}:'' ?></td>
                    <td   style="width: 50%">Peganglah selembar kertas dengan tangan kananmu, lipatlah kertas itu pada pertengahan dan letakkan di lantai</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"><?= isset($data->bahasa->item5->{'Column 2'})?$data->bahasa->item5->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">d. Bacalah dan laksanakan perintah berikut</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"><?= isset($data->bahasa->item6->{'Column 2'})?$data->bahasa->item6->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">"PEJAMKAN MATA ANDA"</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"><?= isset($data->bahasa->item7->{'Column 2'})?$data->bahasa->item7->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">e. Tulislah sebuah kalimat !</td>
                </tr>
                <tr> 
                    <td  style="width: 10%;text-align: center;"><?= isset($data->bahasa->item8->{'Column 2'})?$data->bahasa->item8->{'Column 2'}:'' ?> </td>
                    <td   style="width: 50%">f. Tirulah gambar ini !<br>
                            <img src="<?= base_url('assets/images/geriatri.PNG') ?>" height="70px" width="100px" alt="">
                            <img src=" <?= isset($data->question18)?$data->question18:'' ?>"  alt="img" height="80px" width="120px">
                    
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%;text-align: center;">30</td>
                    <td style="width: 20%"></td>
                    <td style="width: 10%"> </td>
                    <td style="width: 50%"></td>
                </tr>
            </table><br>

            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Neurologi</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question2)? $data->question2:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> _</p>
                        <?php
                            } else {?>
                                <br><br><br><br><br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p>
            <span><b>
                II.	Penapisan Depresi<br>
                (Geritiatri Depression Scale)
            </b></span><br>
            <span>pilih jawaban yang paling tepat,sesuai perasaan pasien/respondedn dalam dua minggu terakhir</span>
        </p>
        <table id="data" border="1">
            <tr>
                <th rowspan="2" style="width: 10%">No</th>
                <th rowspan="2" style="width: 50%">Keadaan Yang Dialami selama seminggu</th>
                <th colspan="2" style="width: 20%">Nilai Respon </th>
               
            </tr>
            <tr>
                <th style="width: 20%">Ya</th>
                <th style="width: 20%">	Tidak </th>
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">1.</td>
                <td style="width: 50%">Apakah anda sebenarnya puas dengan kehidupan anda ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'1'})?intval($data->table->{'Row 1'}->{'1'}) =="0"?"penanda":"":''; ?>">0</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'1'})?intval($data->table->{'Row 1'}->{'1'}) =="1"?"penanda":"":''; ?>">1</td>
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">2.</td>
                <td style="width: 50%">Apakah anda telah banyak meninggalkan kegiatan dan hobi anda ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'2'})?intval($data->table->{'Row 1'}->{'2'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'2'})?intval($data->table->{'Row 1'}->{'2'}) =="0"?"penanda":"":''; ?>">0</td>
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">3.</td>
                <td style="width: 50%">Apakah anda merasa kehidupan anda kosong ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'3'})?intval($data->table->{'Row 1'}->{'3'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'3'})?intval($data->table->{'Row 1'}->{'3'}) =="0"?"penanda":"":''; ?>">0</td>
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">4.</td>
                <td style="width: 50%">Apakah anda sering merasa bosan ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'4'})?intval($data->table->{'Row 1'}->{'4'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'4'})?intval($data->table->{'Row 1'}->{'4'}) =="0"?"penanda":"":''; ?>">0</td>
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">5.</td>
                <td style="width: 50%">Apakah anda masih memiliki semangat hidup ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'5'})?intval($data->table->{'Row 1'}->{'5'}) =="0"?"penanda":"":''; ?>">0</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'5'})?intval($data->table->{'Row 1'}->{'5'}) =="1"?"penanda":"":''; ?>">1</td>            
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">6.</td>
                <td style="width: 50%">Apakah anda takut bahwa sesuatu yang buruk akan terjadi pada anda?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'6'})?intval($data->table->{'Row 1'}->{'6'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'6'})?intval($data->table->{'Row 1'}->{'6'}) =="0"?"penanda":"":''; ?>">0</td>           
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">7.</td>
                <td style="width: 50%">Apakah anda merasa bahagia utuk sebagian besar hidu anda ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'7'})?intval($data->table->{'Row 1'}->{'7'}) =="0"?"penanda":"":''; ?>">0</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'7'})?intval($data->table->{'Row 1'}->{'7'}) =="1"?"penanda":"":''; ?>">1</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">8.</td>
                <td style="width: 50%">Apakah anda sering merasa tidak berdaya ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'8'})?intval($data->table->{'Row 1'}->{'8'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'8'})?intval($data->table->{'Row 1'}->{'8'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">9.</td>
                <td style="width: 50%">Apakah anda lebuh suka tinggal di rumah, daripada pergi keluar untuk mengerjakan sesuatu yang baru ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'9'})?intval($data->table->{'Row 1'}->{'9'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'9'})?intval($data->table->{'Row 1'}->{'9'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">10.</td>
                <td style="width: 50%">Apakah ana merasa mempunyai banyak masalah dengan daya ingat anda dibandingkan orang lain ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'10'})?intval($data->table->{'Row 1'}->{'10'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'10'})?intval($data->table->{'Row 1'}->{'10'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">11.</td>
                <td style="width: 50%">Apakah anda pikir bahwa hidup anda sekarang menyenangkan ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'11'})?intval($data->table->{'Row 1'}->{'11'}) =="0"?"penanda":"":''; ?>">0</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'11'})?intval($data->table->{'Row 1'}->{'11'}) =="1"?"penanda":"":''; ?>">1</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">12.</td>
                <td style="width: 50%">Apakah anda merasa tidak berharga ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'12'})?intval($data->table->{'Row 1'}->{'12'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'12'})?intval($data->table->{'Row 1'}->{'12'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">13.</td>
                <td style="width: 50%">Apakah anda merasa penuh semangat ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'13'})?intval($data->table->{'Row 1'}->{'13'}) =="0"?"penanda":"":''; ?>">0</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'13'})?intval($data->table->{'Row 1'}->{'13'}) =="1"?"penanda":"":''; ?>">1</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">14.</td>
                <td style="width: 50%">Apakah anda merasa keadaan anda tidak ada harapan ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'14'})?intval($data->table->{'Row 1'}->{'14'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'14'})?intval($data->table->{'Row 1'}->{'14'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td style="width: 10%;text-align: center;">15.</td>
                <td style="width: 50%">Apakah anda merasa bahwa orang lain lebih baik keadaannya daripada anda ?</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'15'})?intval($data->table->{'Row 1'}->{'15'}) =="1"?"penanda":"":''; ?>">1</td>
                <td style="width: 20%;text-align: center;" class="<?= isset($data->table->{'Row 1'}->{'15'})?intval($data->table->{'Row 1'}->{'15'}) =="0"?"penanda":"":''; ?>">0</td>          
            </tr>
            <tr>
                <td colspan="2" style="width: 10%;text-align: center;"><b>SKOR</b></td><br>
                <td style="width: 20%;text-align: center;"></td>
                <td style="width: 20%;text-align: center;"><?= isset($data->table->{'Row 1'}->total_skor)?$data->table->{'Row 1'}->total_skor:'' ?></td>          
            </tr>
            <tr>
                <td colspan="2" style="width: 10%;text-align: center;"><b>Kategori</b></td><br>
                <td style="width: 20%;text-align: center;"></td>
                <td style="width: 20%;text-align: center;"><?= isset($data->table->{'Row 1'}->kategori)?$data->table->{'Row 1'}->kategori:'' ?></td>          
            </tr>
        </table>
        <p>
            <b>Interpretasi</b>
        </p>
        <p>
            <p>1.	Normal			: 0 - 4</p>
            <p>2.	Depresi ringan		: 5 - 8</p>
            <p>3.	Depresi sedang	: 9 - 11</p>
            <p>4.	Depresi berat 		: 12 – 15</p>
        </p>

            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Psikiatri</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question1)? $data->question1:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br><br><br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 2 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p>
            <b>III.	PENGKAJIAN ABBREVIATED MENTAL TEST (AMT)</b>
            </p>
            <table id="data" border="1">
                <tr>
                    <th colspan="2" >Status  mental</th>
                    <th colspan="2" >Nilai</th>
                
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">A</td>
                    <td style="width: 50%">Umur : <?= isset($data->abbreviated->{'Row 1'}->detailumur)?$data->abbreviated->{'Row 1'}->detailumur:'...' ?> tahun</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'1'})?intval($data->abbreviated->{'Row 1'}->{'1'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'1'})?intval($data->abbreviated->{'Row 1'}->{'1'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">B</td>
                    <td style="width: 50%">Waktu / jam sekarang <?= isset($data->abbreviated->{'Row 1'}->detailjam)?$data->abbreviated->{'Row 1'}->detailjam:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'2'})?intval($data->abbreviated->{'Row 1'}->{'2'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'2'})?intval($data->abbreviated->{'Row 1'}->{'2'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">C</td>
                    <td style="width: 50%">Alamat tempat tinggal <?= isset($data->abbreviated->{'Row 1'}->tempat_tinggal)?$data->abbreviated->{'Row 1'}->tempat_tinggal:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'3'})?intval($data->abbreviated->{'Row 1'}->{'3'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'3'})?intval($data->abbreviated->{'Row 1'}->{'3'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">D</td>
                    <td style="width: 50%">Tahun ini <?= isset($data->abbreviated->{'Row 1'}->tahun)?$data->abbreviated->{'Row 1'}->tahun:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'4'})?intval($data->abbreviated->{'Row 1'}->{'4'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'4'})?intval($data->abbreviated->{'Row 1'}->{'4'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">E</td>
                    <td style="width: 50%">Saat ini berada dimana <?= isset($data->abbreviated->{'Row 1'}->berada)?$data->abbreviated->{'Row 1'}->berada:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'5'})?intval($data->abbreviated->{'Row 1'}->{'5'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'5'})?intval($data->abbreviated->{'Row 1'}->{'5'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">F</td>
                    <td style="width: 50%">Mengenal orang lain (dokter, perawat, penanya)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'6'})?intval($data->abbreviated->{'Row 1'}->{'6'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'6'})?intval($data->abbreviated->{'Row 1'}->{'6'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">G</td>
                    <td style="width: 50%">Tahun kemerdekaan RI <?= isset($data->abbreviated->{'Row 1'}->tahunkemerdekaan)?$data->abbreviated->{'Row 1'}->tahunkemerdekaan:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'7'})?intval($data->abbreviated->{'Row 1'}->{'7'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'7'})?intval($data->abbreviated->{'Row 1'}->{'7'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">H</td>
                    <td style="width: 50%">Nama presiden RI <?= isset($data->abbreviated->{'Row 1'}->presiden)?$data->abbreviated->{'Row 1'}->presiden:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'8'})?intval($data->abbreviated->{'Row 1'}->{'8'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'8'})?intval($data->abbreviated->{'Row 1'}->{'8'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">I</td>
                    <td style="width: 50%">Tahun kelahiran pasien atau anak terakhir</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'9'})?intval($data->abbreviated->{'Row 1'}->{'9'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'9'})?intval($data->abbreviated->{'Row 1'}->{'9'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">J</td>
                    <td style="width: 50%">Menghitung terbaik (20 s/d 1) <?= isset($data->abbreviated->{'Row 1'}->hitung)?$data->abbreviated->{'Row 1'}->hitung:'...' ?></td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'10'})?intval($data->abbreviated->{'Row 1'}->{'10'}) =="0"?"penanda":"":''; ?>">0. salah</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->abbreviated->{'Row 1'}->{'10'})?intval($data->abbreviated->{'Row 1'}->{'10'}) =="1"?"penanda":"":''; ?>">1. Benar </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">K</td>
                    <td style="width: 50%">Perasaan hati (afeksi)</td>
                    <td colspan="2" style="width: 20%;">
                        <span class="<?= isset($data->abbreviated->{'Row 1'}->{'11'})?$data->abbreviated->{'Row 1'}->{'11'} =="item1"?"penanda":"":''; ?>">A.	Baik</span> <br>
                        <span class="<?= isset($data->abbreviated->{'Row 1'}->{'11'})?$data->abbreviated->{'Row 1'}->{'11'} =="item2"?"penanda":"":''; ?>">B.	Labil<span><br>
                        <span class="<?= isset($data->abbreviated->{'Row 1'}->{'11'})?$data->abbreviated->{'Row 1'}->{'11'} =="item3"?"penanda":"":''; ?>">C.	Depresi<span><br>
                        <span class="<?= isset($data->abbreviated->{'Row 1'}->{'11'})?$data->abbreviated->{'Row 1'}->{'11'} =="item4"?"penanda":"":''; ?>">D.	Gelisah<span><br>
                        <span class="<?= isset($data->abbreviated->{'Row 1'}->{'11'})?$data->abbreviated->{'Row 1'}->{'11'} =="item5"?"penanda":"":''; ?>">E.	Cemas<span><br>
                         <br>
                         <br>
                         </td>
                
                </tr>
                <tr>
                    <td colspan="4">Total Skor : <?= isset($data->abbreviated->{'Row 1'}->total_skor)?$data->abbreviated->{'Row 1'}->total_skor:'...' ?></td> 
                </tr>
                <tr>
                    <td colspan="4">Ket : <?= isset($data->abbreviated->{'Row 1'}->kategori)?$data->abbreviated->{'Row 1'}->kategori:'...' ?></td> 
                </tr>
            </table>
            <p>
                <b>KETERANGAN : Skor AMT</b>
            </p>
            <p>
                <p>0 – 3 	: Gangguan ingatan berat </p>
                <p>4 – 7 	: Gangguan ingatan sedang</p>
                <p>8 – 10 	: Normal</p>
            </p>
            <br><br><br><br><br><br><br><br>
            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Psikiatri</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question19)? $data->question19:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br><br><br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 3 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p><b>IV.	Status Fungsional (Indeks ADL Barthel</b></p>
            <table id="data" border="1">
                <tr>
                    <th style="width: 10%;">No</th>
                    <th style="width: 25%;" >Fungsi</th>
                    <th style="width: 15%;" >Skor</th>
                    <th style="width: 30%;" >Keterangan</th> 
                    <th style="width: 20%;" >Nilai Skor</th>  
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">1</td>
                    <td style="width: 10%;">Mengendalikan Rangsang Pembuangan tinja</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tak terkendali?takteratur (perlu pencahar
                        Kadang – kadang tak terkendali (1 X seminggu)
                        Terkendali teratur
                        </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'1'})?$data->question5->{'Row 1'}->{'1'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">2</td>
                    <td style="width: 10%;">Mengendalikan Rangsang berkemih  </td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tak terkendali atau pakai karteter
                        Kadang – kadang tak terkendali (1 X 24 jam)
                        Mandiri
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'2'})?$data->question5->{'Row 1'}->{'2'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">3</td>
                    <td style="width: 10%;">Membersihkan diri(seka muka,sisir rambut, sikat gigi)</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1
                        </td>
                    <td style="width: 10%;">
                        Butuh pertolongan orang lain Mandiri
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'3'})?$data->question5->{'Row 1'}->{'3'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">4</td>
                    <td style="width: 10%;">Pengguanaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihakan, menyiram)</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tergantung pertolongan orang lain
                        Perlu pertolongan pada beberapa kegiatan tetapi dapat mengerjakan sendiri beberapa kegiatan yang lain
                        Mandiri

                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'4'})?$data->question5->{'Row 1'}->{'4'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">5</td>
                    <td style="width: 10%;">makan</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tidak mampu
                        Perlu ditolong memotong makanan
                        Mandiri
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'5'})?$data->question5->{'Row 1'}->{'5'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">6</td>
                    <td style="width: 10%;">Berubah sikap dari berbaringn ke duduk</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2<br>
                        3
                        </td>
                    <td style="width: 10%;">
                        tidak mampu
                        Perlu banyak bantuan untuk bisa duduk 92 orang)
                        Bantuan minimal 1 orang
                        Mandiri
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'6'})?$data->question5->{'Row 1'}->{'6'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">7</td>
                    <td style="width: 10%;">Berpindah / berjalan</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2<br>
                        3
                        </td>
                    <td style="width: 10%;">
                        Tidak mampu
                        Biosa (pindah) dengan kursi roda
                        Berjalan dengan bantuan 1 orang
                        mandiri                    
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'7'})?$data->question5->{'Row 1'}->{'7'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">8</td>
                    <td style="width: 10%;">Memakai baju</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tergantung orang lain
                        Sebagaian dibantu (misalnya mengancing baju)
                        Mandiri                 
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'8'})?$data->question5->{'Row 1'}->{'8'}:'' ?></td>
                </tr>

                <tr>
                    <td style="width: 10%;text-align: center;">9</td>
                    <td style="width: 10%;">Naik turun tangga</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1<br>
                        2
                        </td>
                    <td style="width: 10%;">
                        Tidak mampu
                        Butuh pertolongan
                        Mandiri            
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'9'})?$data->question5->{'Row 1'}->{'9'}:'' ?></td>
                </tr>

                
                <tr>
                    <td style="width: 10%;text-align: center;">10</td>
                    <td style="width: 10%;">Mandi</td>
                    <td style="width: 10%;text-align: center;">
                        0<br>
                        1
                        </td>
                    <td style="width: 10%;">
                        Tergantung orang lain Mandiri        
                    </td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->{'10'})?$data->question5->{'Row 1'}->{'10'}:'' ?></td>
                </tr>

                <tr>
                    <td colspan="4">TOTAL SKOR</td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->total_skor)?$data->question5->{'Row 1'}->total_skor:'' ?></td>
                </tr>

                <tr>
                    <td colspan="4">Ket</td>
                    <td style="width: 10%;text-align:center;vertical-align:middle"><?= isset($data->question5->{'Row 1'}->kategori)?$data->question5->{'Row 1'}->kategori:'' ?></td>
                </tr>
                
            </table>
            <p>
                <b>Keterangan Skor :</b><br>
                <span style="margin-left: 30px;">20	: Mandiri</span><br>
                <span style="margin-left: 30px;">12-19	: Ketergantungan Ringan</span><br>
                <span style="margin-left: 30px;">9-11	: Ketergantungan Sedang</span><br>
                <span style="margin-left: 30px;">0-4	: Ketergantungan Total</span><br>
                <span style="margin-left: 30px;">5-8	: Ketergantunagn Berat</span>
            </p>
            <br><br><br>
            <table width="100%">
                <tr>
                    <td align="right"><b>Perawat</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question6)? $data->question6:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br><br><br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 4 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p>
            <b>V.	Status Nutrisi (Mini Ntrisional Asesment (MNA)</b><br>
            <span>BB: <?= isset($data->bb)?$data->bb:'' ?></span>
            <span style="margin-left: 20px;">TB: <?= isset($data->tb)?$data->tb:'' ?></span>
            <span style="margin-left: 20px;">TL: <?= isset($data->tl)?$data->tl:'' ?></span>
            </p>
            <table id="gizi">
                <tr>
                    <td style="width: 50%;">
                                <span><b>1. PENAPISAN (SCREENING) Di lakukan oleh Perawat</b></span><br>
                                <span><b>a. Apakah ada penurunan asupan makanan dalam  jangka waktu 3
                                            bulan oleh karena kehilangan nafsu makan,  masalah pencernaan, 
                                    kesulitan menelan atau mengunyah? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = nafsu makan yang sangat berkurang </span><br>
                                        <span>1 = nafsu makan sedikit berkurang (sedang)</span><br>
                                        <span>2 = nafsu makan biasa saja</span><br>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'1'})?$data->penapisan->{'Row 1'}->{'1'}:'' ?></span>
                                </span>
                                <br> <br> <br>

                                <span><b>b.Penurunan berat badan dalam 3 bulan terakhir?</b></span><br>
                                    <span style="float: left;">
                                        <span>0 = penurunan berat badan lebih dari 3 kg </span><br>
                                        <span>1 = tidak tahu </span><br>
                                        <span>2 = penurunan berat badan 1 – 3 kg</span><br>
                                        <span>3 = tidak ada penurunan berat badan </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;margin-top:10px">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'2'})?$data->penapisan->{'Row 1'}->{'2'}:'' ?></span>
                                    <!-- <img src="8.PNG" alt="" width="50px"> -->
                                </span>
                                <br> <br> <br> <br>

                                <span><b>c. Mobilitas</b></span><br>
                                    <span style="float: left;">
                                        <span>0 = harus berbaring di tempat tidur atau menggunakan kursi roda</span><br>
                                        <span>1 = biasa keluar dari tempat tidur atau kursi roda, tetapi  tidak bisa   keluar rumah </span><br>
                                        <span>2= bisa keluar rumah </span><br>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span><br><br>
                        
                    </td>

                    <td style="width: 50%;">
                                <span><b>d. Menderita stress psikologis atau penyakit akut dalam 3 bulan terakhir? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = ya</span><br>
                                        <span>2 = tidak </span><br>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'4'})?$data->penapisan->{'Row 1'}->{'4'}:'' ?></span>
                                </span><br><br>

                                <span><b>e. Masalah neuropsikologis? </b></span><br>
                                <span style="float: left;">
                                    <span>0 = demensia berat atau depresi berat </span><br>
                                    <span>1 = demensia ringan </span><br>
                                    <span>2 = tidak ada masalah psikologis </span><br>
                                </span>
                            <span style="float: right;margin-right: 30px;">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'5'})?$data->penapisan->{'Row 1'}->{'5'}:'' ?></span>
                            </span><br><br><br>

                            <span><b>f. Indeks Masssa Tubuh (IMT) yaitu berat badan dalam kg/tinggi badan dalam m²? </b></span><br>
                                <span style="float: left;">
                                    <span>0 = IMT < 19 kg/ m²</span><br>
                                    <span>1 = IMT 19 – < 21 kg/ m² </span><br>
                                    <span>2 = IMT 21 – < 23 kg/ m²  </span><br>
                                    <span>3 = IMT 23 atau lebih  </span><br>
                                </span>
                            <span style="float: right;margin-right: 30px;">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'6'})?$data->penapisan->{'Row 1'}->{'6'}:'' ?></span>
                            </span><br><br><br><br>

                            <span><b>Skor PENAPISAN (subtotal maksimum 14 poin)<br>  <br>
                                TOTAL
                                </b></span><br>
                            <span style="float: right;margin-right: 30px;">
                            <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->total_skor)?$data->penapisan->{'Row 1'}->total_skor:'' ?></span>
                            </span><br><br><br>
                            <span><b>Keterangan : <?= isset($data->penapisan->{'Row 1'}->kategori)?$data->penapisan->{'Row 1'}->kategori:'' ?>
                                </b></span><br>
                                <span>Skor ≥ 11 normal, tidak beresiko = tidak perlu melengkapi form pengkajian</span><br>
                                <span>Skor ≤ 11 kemungkinan malnutrisi = lanjutkan pengkajian</span>
                    </td>
                </tr>


                <tr>
                    <td style="width: 50%;">
                                <span><b>2. PENGKAJIAN (ASSESSMENT) Dilakukan oleh Dokter Gizi Klinik</b></span><br>
                                <span><b>a. Hidup mandiri, tidak bergantung pada orang lain (bukan di rumah sakit atau panti werdha)?</b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak</span><br>
                                        <span>1 = ya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'7'})?$data->penapisan->{'Row 1'}->{'7'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>b. Minum obat lebih dari 3 macam dalam 1 hari? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak</span><br>
                                        <span>1 = ya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'8'})?$data->penapisan->{'Row 1'}->{'8'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>c. Terdapat ulkus decubitus/luka tekan atau luka di kulit?  </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak</span><br>
                                        <span>1 = ya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'9'})?$data->penapisan->{'Row 1'}->{'9'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>d. Berapa kali pasien makan lengkap dalm 1 hari?   </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak</span><br>
                                        <span>1 = ya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'10'})?$data->penapisan->{'Row 1'}->{'10'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>e. Konsumsi BM tertentu yang diketahui sebagai BM sumber protein (asupan protein)? </b></span><br>
                                    <ul>
                                        <li>Sedikitnya 1 penukar dari produk susu (susu, keju, yogurt) perhari (ya/tidak) </li>
                                        <li>Dua penukar atau lebih dari kacang – kacangan atau telur perminggu </li>
                                        <li>Daging, ikan atau ungags setiap hari (ya/tidak) </li>
                                    </ul>
                                    <span style="float: left;">
                                        <span>0,0 = jika 0 atau 1 pertanyaan yang jawabannya ya </span><br>
                                        <span>0,5 = jika 2 pertanyaan jawabannya</span><br>
                                        <span>(ya/tidak) </span><br>
                                        <span>“ya” </span><br>
                                        <span>1,0 = jika 3 pertanyaan jawabannya “ya” </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br><br><br>
            
                                <span><b>f. Adakah mengkonsumsi 2 penukar atau lebih buah atau sayuran perhari ?</b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak</span><br>
                                        <span>1 = ya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br><br><br>

                                <span><b>g. Berapa banyak cairan (air, jus, kopi, teh, susu, …)   yang diminum setiap hari? </b></span><br>
                                    <span style="float: left;">
                                        <span>0,0 = kurang dari 3 gelas </span><br>
                                        <span>0,5 = 3 sampai 5 gelas </span><br>
                                        <span>1,0 = lebih dari 5 gelas</span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                    </td>


                    <td style="width: 50%;">
                        <span><b>h. Cara makan? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = tidak dapat makan tanpa bantuan orang lain </span><br>
                                        <span>1 = makan sendiri dengan sedikit kesulitan </span>
                                        <span>2 = dapat makan sendiri tanpa masalah </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br><br><br>


                                <span><b>i.	Pandangan pasien terhadap status gizinya? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = merasa dirinya kekurangan makan.kurang gizi </span><br>
                                        <span>1 = tidak dapat menilai/tidak yakin dengan status gizinya  </span>
                                        <span>2 = merasa tidak ada masalah dengan status gizinya </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br><br><br>


                                <span><b>j.  Dibandingkan dengan orang lain yang seumur, </b></span><br>
                                    <span style="float: left;">
                                        <span>bagaimana pasien melihat status kesehatannya? </span><br>
                                        <span>0.0 = tidak sebaik mereka </span>
                                        <span>0,5 = tidak tahu</span>
                                        <span>1,0 = sama baik</span>
                                        <span>2,0 = lebih baik</span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br><br>

                                <span><b>k. Lingkar Lengan Atas (LLA) dalam cm? </b></span><br>
                                    <span style="float: left;">
                                        <span>0,0 = LLA < 21 cm </span><br>
                                        <span>0,5 = LLA 21 – < 22 cm </span>
                                        <span>1,0 = LLA ≥ 22 cm </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>l. Lingkar betis (LB) dalam cm? </b></span><br>
                                    <span style="float: left;">
                                        <span>0 = LB < 31 cm </span><br>
                                        <span>1 = LB ≥ 31 cm  </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br><br>

                                <span><b>Skor PENGKAJIAN </b></span><br>
                                    <span style="float: left;">
                                        <span>maksimum 16 poin)  </span>
                                    </span>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span style="float: left;"><b>Skor PENAPISAN </b></span><br>
                                <span style="float: right;margin-right: 30px;">
                                    <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span style="float: left;">PENILAIAN TOTAL (maksimum 30 poin</span><br>
                                <span style="float: right;margin-right: 30px;">
                                <span style="border-style:solid;border-width: 1px;padding:3px;"><?= isset($data->penapisan->{'Row 1'}->{'3'})?$data->penapisan->{'Row 1'}->{'3'}:'' ?></span>
                                </span>
                                <br><br><br>

                                <span><b>Keterangan :</b></span><br>                        
                                        <span>
                                            17 sampai 23,5 :beresiko malnutrisi<br>
                                            kurang dari 17 poin:malnutrisi
                                        </span>
                    </td>
                </tr>
            </table><br>

            <table width="100%" >
                <tr>
                    <td width="50%" align="left" style="font-size:10px"><b>Perawat</b></td>
                    <td width="50%" align="right" style="font-size:10px"><b>Dokter Gizi Klinik</b></td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                    <?php
                        $id = explode('-',isset( $data->question7)? $data->question7:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                    </td>
                    <td width="50%" align="right">
                    <?php
                        $id = explode('-',isset( $data->question8)? $data->question8:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left" style="font-size:10px"><b>Nama jelas & tanda tangan</b></td>
                    <td width="50%" align="right" style="font-size:10px"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 5 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
            <p>
            <span><b>
                Geriatric Giant
            </b></span><br>
            </p>
            <table id="data" border="1">
                <tr>
                    <th rowspan="2" style="width: 10%">No</th>
                    <th rowspan="2" style="width: 50%">Keadaan Yang Dialami selama seminggu</th>
                    <th colspan="2" style="width: 20%">Nilai Respon </th>
                
                </tr>
                <tr>
                    <th style="width: 20%">Ya</th>
                    <th style="width: 20%">	Tidak </th>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">1.</td>
                    <td style="width: 50%">Immobilisasi (Berdasarkan skor ADL)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'1'})?intval($data->question12->{'Row 1'}->{'1'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'1'})?intval($data->question12->{'Row 1'}->{'1'}) =="0"?"penanda":"":''; ?>">0</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">2.</td>
                    <td style="width: 50%">Instabilitas dan jatuh</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'2'})?intval($data->question12->{'Row 1'}->{'2'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'2'})?intval($data->question12->{'Row 1'}->{'2'}) =="0"?"penanda":"":''; ?>">0</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">3.</td>
                    <td style="width: 50%">Inkontinensia urin dan alvi</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'3'})?intval($data->question12->{'Row 1'}->{'3'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'3'})?intval($data->question12->{'Row 1'}->{'3'}) =="0"?"penanda":"":''; ?>">0</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">4.</td>
                    <td style="width: 50%">Gangguan kognitif ( berdasarkan MMSE</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'4'})?intval($data->question12->{'Row 1'}->{'4'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'4'})?intval($data->question12->{'Row 1'}->{'4'}) =="0"?"penanda":"":''; ?>">0</td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">5.</td>
                    <td style="width: 50%">Infeksi</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'5'})?intval($data->question12->{'Row 1'}->{'5'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'5'})?intval($data->question12->{'Row 1'}->{'5'}) =="0"?"penanda":"":''; ?>">0</td>            
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">6.</td>
                    <td style="width: 50%">Gangguan pendengaran</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'6'})?intval($data->question12->{'Row 1'}->{'6'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'6'})?intval($data->question12->{'Row 1'}->{'6'}) =="0"?"penanda":"":''; ?>">0</td>           
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">7.</td>
                    <td style="width: 50%">Inpaksi (Konstipasi)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'7'})?intval($data->question12->{'Row 1'}->{'7'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'7'})?intval($data->question12->{'Row 1'}->{'7'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">8.</td>
                    <td style="width: 50%">Depresi ( Berdasarkan GDS/DSM/PPDGJ)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'8'})?intval($data->question12->{'Row 1'}->{'8'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'8'})?intval($data->question12->{'Row 1'}->{'8'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">9.</td>
                    <td style="width: 50%">Malnutrisi (Berdasarkan MNA)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'9'})?intval($data->question12->{'Row 1'}->{'9'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'9'})?intval($data->question12->{'Row 1'}->{'9'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">10.</td>
                    <td style="width: 50%">Inpecunity (Kemiskinan)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'10'})?intval($data->question12->{'Row 1'}->{'10'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'10'})?intval($data->question12->{'Row 1'}->{'10'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">11.</td>
                    <td style="width: 50%">Latrogenesis (Penyakit akibat poli farmasi)</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'11'})?intval($data->question12->{'Row 1'}->{'11'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'11'})?intval($data->question12->{'Row 1'}->{'11'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">12.</td>
                    <td style="width: 50%">Insomnia</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'12'})?intval($data->question12->{'Row 1'}->{'12'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'12'})?intval($data->question12->{'Row 1'}->{'12'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">13.</td>
                    <td style="width: 50%">Defisiensi Imunitas</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'13'})?intval($data->question12->{'Row 1'}->{'13'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'13'})?intval($data->question12->{'Row 1'}->{'13'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td style="width: 10%;text-align: center;">14.</td>
                    <td style="width: 50%">Impotensi</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'14'})?intval($data->question12->{'Row 1'}->{'14'}) =="1"?"penanda":"":''; ?>">1</td>
                    <td style="width: 20%;text-align: center;" class="<?= isset($data->question12->{'Row 1'}->{'14'})?intval($data->question12->{'Row 1'}->{'14'}) =="0"?"penanda":"":''; ?>">0</td>          
                </tr>
                <tr>
                    <td colspan="2" style="width: 10%;text-align: center;"><b>SKOR</b></td><br>
                    <td style="width: 20%;text-align: center;" colspan="2"><?= isset($data->question12->{'Row 1'}->total_skor)?$data->question12->{'Row 1'}->total_skor:'' ?></td>
                        
                </tr>

                <tr>
                    <td colspan="2" style="width: 10%;text-align: center;"><b>KATEGORI</b></td><br>
                    <td style="width: 20%;text-align: center;" colspan="2"><?= isset($data->question12->{'Row 1'}->kategori)?$data->question12->{'Row 1'}->kategori:'' ?></td>
                        
                </tr>
            </table>
            <p>
                <b> Interpretasi : Skor > 2 : Kategori Pasien Geriatri</b>
            </p>
            <br><br> <br><br> <br><br>
            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Penyakit Dalam</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question9)? $data->question9:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br> <br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br> <br><br> <br><br><br><br> <br><br> <br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 6 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <center><h4>ASSESMENT AWAL MEDIS GERIATRI</h4></center>

            <div style="font-size:12px">
                <table id="data" border="1">
                <tr>
                    <td>
                        <p>Pemeriksaan Fisik :</p>
                        <p>TD  :	<?= isset($data->pemeriksaan_fisik->td)?$data->pemeriksaan_fisik->td:'' ?> mmHg </p>
                        <p>Nadi	:	<?= isset($data->pemeriksaan_fisik->nadi)?$data->pemeriksaan_fisik->nadi:'' ?> x/i </p>
                        <p>Pernafasan   	:	<?= isset($data->pemeriksaan_fisik->pernafasan)?$data->pemeriksaan_fisik->pernafasan:'' ?>  x/i </p>
                        <p>Suhu	:	<?= isset($data->pemeriksaan_fisik->suhu)?$data->pemeriksaan_fisik->suhu:'' ?> 0C</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Diagnosis Kerja
                        <p style="min-height:30px"><?= isset($data->diag_kerja)?$data->diag_kerja:'' ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Diagnosis Banding
                        <p style="min-height:30px"><?= isset($data->diag_banding)?$data->diag_banding:'' ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Pemeriksaan Penunjang
                        <p style="min-height:30px"><?= isset($data->penunjang)?$data->penunjang:'' ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Therapi/Tindakan
                        <p style="min-height:30px"><?= isset($data->therapi)?$data->therapi:'' ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Kontrol Ulang : 
                        <input type="checkbox" value="Kembali Kontrol" <?= (isset($data->kontrol)?in_array("kembali", $data->kontrol)?'checked':'':'') ?>>
                        <label for="Kembali Kontrol">Kembali Kontrol</label>
                        <span style="margin-left: 30px;">Hari/Tanggal : <?= isset($data->question15->hari)?date('d-m-Y',strtotime($data->question15->hari)):'' ?>   </span>
                        <span style="margin-left: 30px;">Jam <?= isset($data->question15->hari)?date('h:i',strtotime($data->question15->hari)):'' ?> WIB    </span><br>
                        <span style="margin-left: 100px;">Poliklinik : <?= isset($data->question11)?$data->question11:'' ?> </span>
                        
                
                    </td>
                </tr>
            </table><br>
            <br><br>   <br><br>   <br><br>   <br><br>
            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Penyakit Dalam</b></td>
                </tr>
                <tr>
                    <td align="right">
                    <?php
                        $id = explode('-',isset( $data->question10)? $data->question10:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                                <br><br><br> <br><br><br>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 7 dari 7
                </div>
                <!-- <div style="margin-left:470px">
                RM.RJ 05N
                </div> -->
           </div>
        </div>
    </body>
    </html>