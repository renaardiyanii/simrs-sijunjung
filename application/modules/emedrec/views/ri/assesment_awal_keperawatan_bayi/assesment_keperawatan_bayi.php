<?php
$data = (isset($assesment_awal_keperawatan_iri[0]->formjson_bayi)?json_decode($assesment_awal_keperawatan_iri[0]->formjson_bayi):'');
//  var_dump($data);
?>

<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 5px;   
            font-size: 11px;
            position: relative;
            width:100%;
        }

        #data tr td{
            
            font-size: 11px;
            
        }
        #bg-checked{
            background-color:#64C9CF;
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
        
        <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print') ?>
                </header>

                <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP NEONATUS</h4></center>
                <div style="font-size:12px">
                    <table id="data" cellpadding="1px" border="0">
                        <tr>
                            <td width="15%">Tiba di Ruangan</td>
                            <td width="2%">:</td>
                            <td>
                                <span>Tanggal <?= isset($data->tiba_diruangan->tanggal)?$data->tiba_diruangan->tanggal:'' ?></span>
                                <span style="margin-left:30px">Jam <?= isset($data->tiba_diruangan->jam)?$data->tiba_diruangan->jam:'' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Pengkajian</td>
                            <td>:</td>
                            <td>
                                <span>Tanggal <?= isset($data->tiba_diruangan->tanggal1)?$data->tiba_diruangan->tanggal1:'' ?></span>
                                <span style="margin-left:30px">Jam <?= isset($data->tiba_diruangan->jam1)?$data->tiba_diruangan->jam1:'' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Cara Masuk</td>
                            <td>:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "brankar" ? "checked":'':'' ?>>
                                <span>Brankar</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "kursi_roda" ? "checked":'':'' ?>>
                                <span>Kursi Roda</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "digendong" ? "checked":'':'' ?>>
                                <span>Digendong</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "other" ? "checked":'':'' ?>>
                                <span>Lain-lain,sebutkan <?= isset($data->cara_masuk->{'cara_masuk-Comment'})?$data->cara_masuk->{'cara_masuk-Comment'}:'' ?></span>
                            </td>
                        </tr>
                    </table>

                    <p>I. IDENTIFIKASI</p>
                    <span>1. Identitas bayi</span>
                    <table id="data" cellpadding="1px" border="0" style="margin-left:20px">

                        <tr>
                            <td width="20%">Tanggal Masuk RS</td>
                            <td width="2%">:</td>
                            <td><?= isset($data->identitas_bayi->tanggal_masuk_rs)?$data->identitas_bayi->tanggal_masuk_rs:'' ?></td>
                        </tr>

                        <tr>
                            <td>Anak Ke</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_bayi->anak_ke)?$data->identitas_bayi->anak_ke:'' ?></td>
                        </tr>
                    </table>

                    <p>2. Identitas Orang Tua</p>

                    <table id="data" cellpadding="1px" border="0" style="margin-left:20px">

                        <tr>
                            <td width="20%"><b>Nama Ayah</b></td>
                            <td width="2%">:</td>
                            <td><?= isset($data->identitas_orang_tua->nama_ayah)?$data->identitas_orang_tua->nama_ayah:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Umur<p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->umur)?$data->identitas_orang_tua->umur:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->agama)?$data->identitas_orang_tua->agama:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Suku / Bangsa</p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->suku_bangsa)?$data->identitas_orang_tua->suku_bangsa:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Pendidikan</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->pendidikan)?$data->identitas_orang_tua->pendidikan:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Pekerjaan</p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->pekerjaan)?$data->identitas_orang_tua->pekerjaan:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->alamat)?$data->identitas_orang_tua->alamat:'' ?></td>
                        </tr>

                        <tr>
                            <td><b><p>Nama Ibu</p></b></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->nama_ibu)?$data->identitas_orang_tua->nama_ibu:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Umur</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->umur1)?$data->identitas_orang_tua->umur1:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Agama</p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->agama1)?$data->identitas_orang_tua->agama1:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Suku / Bangsa</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->suku_bangsa1)?$data->identitas_orang_tua->suku_bangsa1:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Pendidikan</p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->pendidikan1)?$data->identitas_orang_tua->pendidikan1:'' ?></p></td>
                        </tr>

                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= isset($data->identitas_orang_tua->pekerjaan1)?$data->identitas_orang_tua->pekerjaan1:'' ?></td>
                        </tr>

                        <tr>
                            <td><p>Alamat</p></td>
                            <td><p>:</p></td>
                            <td><p><?= isset($data->identitas_orang_tua->alamat1)?$data->identitas_orang_tua->alamat1:'' ?></p></td>
                        </tr>
                    </table>

                    <p>II. KELUHAN UTAMA</p>
                    <div style="min-height:50px;margin-left:30px">
                    <span><?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?></span>
                    </div>

                    <p>RIWAYAT PENYAKIT SEKARANG</p>
                    <div style="min-height:50px;margin-left:30px">
                    <span><?= isset($data->penyakit)?$data->penyakit:'' ?></span>
                    </div>

                    <p>III. RIWAYAT ANTENATAL</p>
                    <div style="margin-left:20px">
                        <span>Penyakit/Kesehatan ibu dan Pengobatan</span>
                        <table id="data" cellpadding="1px" border="0">
                            <tr>
                                <td width="30%">Sebelum Hamil</td>
                                <td width="2%">:</td>
                                <td><?= isset($data->question2->sebelum_hamil)?$data->question2->sebelum_hamil:'' ?></td>
                            </tr>
                            <tr>
                                <td width="30%">Selama Hamil (trimester !-III)</td>
                                <td width="2%">:</td>
                                <td><?= isset($data->question2->selama_hamil)?$data->question2->selama_hamil:'' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 4</p>    
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

                <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP NEONATUS</h4></center>
                <div style="font-size:12px">
                    <span>IV. RIWAYAT PROSES PERSALINAN</span>
                        <div style="margin-left:35px">
                            <table id="data" cellpadding="1px" border="0">
                                <tr>
                                    <td width="25%">Umur Kehamilan</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->umur_kehamilan)?$data->riwayat_proses_persalinan[0]->umur_kehamilan:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Kehamilan Tunggal/Kembar</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->kehamilan_tunggal_kembar)?$data->riwayat_proses_persalinan[0]->kehamilan_tunggal_kembar:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Lama Persalinan Kala I</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->lama_persalinan_kala1)?$data->riwayat_proses_persalinan[0]->lama_persalinan_kala1:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Kelainan</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->kelainan)?$data->riwayat_proses_persalinan[0]->kelainan:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Lama Persalinan Kala II</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->lama_persalinan_kala2)?$data->riwayat_proses_persalinan[0]->lama_persalinan_kala2:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Kelainan</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->kelainan1)?$data->riwayat_proses_persalinan[0]->kelainan1:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Air Ketuban</td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->air_ketuban)?$data->riwayat_proses_persalinan[0]->air_ketuban:'' ?></td>
                                </tr>

                                <tr>
                                    <td><span style="margin-left:15px">Ketuban Pecah</span></td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->ketuban_pecah)?$data->riwayat_proses_persalinan[0]->ketuban_pecah:'' ?> jam sebelum lahir</td>
                                </tr>
                                <tr>
                                    <td><span style="margin-left:15px">Jumlah</span></td>
                                    <td>:</td>
                                    <td><?= isset($data->riwayat_proses_persalinan[0]->jumlah)?$data->riwayat_proses_persalinan[0]->jumlah:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td><span style="margin-left:15px">Warna</span></td>
                                    <td>:</td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_proses_persalinan[0]->warna)? $data->riwayat_proses_persalinan[0]->warna == "jernih" ? "checked":'':'' ?>>
                                        <span>Jernih</span>
                                        
                                        <input type="checkbox" value="Tidak" style="margin-left:20px" <?php echo isset($data->riwayat_proses_persalinan[0]->warna)? $data->riwayat_proses_persalinan[0]->warna == "keruh" ? "checked":'':'' ?>>
                                        <span>Keruh</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span style="margin-left:15px">Meconium</span></td>
                                    <td>:</td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_proses_persalinan[0]->meconium)? $data->riwayat_proses_persalinan[0]->meconium == "ada" ? "checked":'':'' ?>>
                                        <span>Ada</span>
                                        <input type="checkbox" value="Tidak" style="margin-left:20px" <?php echo isset($data->riwayat_proses_persalinan[0]->meconium)? $data->riwayat_proses_persalinan[0]->meconium == "tidak" ? "checked":'':'' ?>>
                                        <span>Tidak</span>
                                        <input type="checkbox" value="Tidak" style="margin-left:20px" <?php echo isset($data->riwayat_proses_persalinan[0]->meconium)? $data->riwayat_proses_persalinan[0]->meconium == "lainnya" ? "checked":'':'' ?>>
                                        <span>Lain Lain</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <span style="margin-left:15px">Jelaskan</span>
                                        <div style="min-height:30px;margin-left:15px"><?= isset($data->riwayat_proses_persalinan[0]->detillainnya)?$data->riwayat_proses_persalinan[0]->detillainnya:''  ?></div>
                                    </td>  
                                </tr> 
                            </table>

                            <table id="data" cellpadding="1px" border="0" style="margin-left:15px">
                                <tr>
                                    <td width="20%">Letak Bayi</td>
                                    <td width="2%">:</td>
                                    <td width="78%"><?= isset($data->riwayat_proses_persalinan[0]->letak_bayi)?$data->riwayat_proses_persalinan[0]->letak_bayi:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Jenis Persalinan</td>
                                    <td>:</td>
                                    <td>
                                        <input type="checkbox" value="Tidak"  <?php echo isset($data->riwayat_proses_persalinan[0]->jenis_persalinan)? $data->riwayat_proses_persalinan[0]->jenis_persalinan == "spontan" ? "checked":'':'' ?>>
                                        <span>Spontan</span>
                                        <input type="checkbox" value="Tidak"  <?php echo isset($data->riwayat_proses_persalinan[0]->jenis_persalinan)? $data->riwayat_proses_persalinan[0]->jenis_persalinan == "seccio_caesaria" ? "checked":'':'' ?>>
                                        <span>Secsio Caesaria</span>
                                        <input type="checkbox" value="Tidak"  <?php echo isset($data->riwayat_proses_persalinan[0]->jenis_persalinan)? $data->riwayat_proses_persalinan[0]->jenis_persalinan == "vacum_ekstaksi" ? "checked":'':'' ?>>
                                        <span>Vacum Ekstaksi</span><br>
                                        <input type="checkbox" value="Tidak"  <?php echo isset($data->riwayat_proses_persalinan[0]->jenis_persalinan)? $data->riwayat_proses_persalinan[0]->jenis_persalinan == "Lainya" ? "checked":'':'' ?>>
                                        <span>Lain Lain Jelaskan <?= isset($data->riwayat_proses_persalinan[0]->lainnya)?$data->riwayat_proses_persalinan[0]->lainnya:'' ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%">Indikasi</td>
                                    <td width="2%">:</td>
                                    <td width="78%"><?= isset($data->riwayat_proses_persalinan[0]->indikasi)?$data->riwayat_proses_persalinan[0]->indikasi:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="20%">Berat Badan Lahir</td>
                                    <td width="2%">:</td>
                                    <td width="78%"><?= isset($data->riwayat_proses_persalinan[0]->berat_badan_lahir)?$data->riwayat_proses_persalinan[0]->berat_badan_lahir:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="20%">Panjang Badan Lahir</td>
                                    <td width="2%">:</td>
                                    <td width="78%"></td>
                                </tr>
                                <tr>
                                    <td width="20%">Lingkar Dada</td>
                                    <td width="2%">:</td>
                                    <td width="78%"><?= isset($data->riwayat_proses_persalinan[0]->lingkar_dada)?$data->riwayat_proses_persalinan[0]->lingkar_dada:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="20%">Lingkar Kepala</td>
                                    <td width="2%">:</td>
                                    <td width="78%"><?= isset($data->riwayat_proses_persalinan[0]->lingkar_kepala)?$data->riwayat_proses_persalinan[0]->lingkar_kepala:'' ?></td>
                                </tr>
                                <tr>
                                    <td width="20%">Apgar Skore</td>
                                    <td width="2%">:</td>
                                    <td width="78%"></td>
                                </tr>
                            </table>

                            <table id="data" cellpadding="1px" border="1">
                                <tr>
                                    <TH  width="20%">APGAR SCORE</TH>
                                    <TH  width="15%">0</TH>
                                    <TH  width="30%">1</TH>
                                    <TH  width="15%">2</TH>
                                    <TH  width="10%">1 MENIT</TH>
                                    <TH  width="10%">5 MENIT</TH>
                                </tr>

                                <tr>
                                    <td>Denyut Jantung</td>
                                    <td>Tidak Ada</td>
                                    <td> < 100 </td>
                                    <td> > 100</td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->{'1'})?$data->apgar_skore->{'1menit'}->{'1'}:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->{'1'})?$data->apgar_skore->{'2menit'}->{'1'}:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Pernafasan</td>
                                    <td>Tidak Ada</td>
                                    <td> Tak teratur </td>
                                    <td> Baik</td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->{'2'})?$data->apgar_skore->{'1menit'}->{'2'}:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->{'2'})?$data->apgar_skore->{'2menit'}->{'2'}:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Tonus Otot</td>
                                    <td>tidak ada</td>
                                    <td>Fleksi Sedikit </td>
                                    <td> gerakan aktif</td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->{'3'})?$data->apgar_skore->{'1menit'}->{'3'}:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->{'3'})?$data->apgar_skore->{'2menit'}->{'3'}:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Peka Rangsangan</td>
                                    <td>Tidak ADA</td>
                                    <td></td>
                                    <td>Menangis Kuat</td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->{'4'})?$data->apgar_skore->{'1menit'}->{'4'}:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->{'4'})?$data->apgar_skore->{'2menit'}->{'4'}:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Warna</td>
                                    <td>Pucat</td>
                                    <td>Badan merah estermitas biru </td>
                                    <td>Merah Jambu</td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->{'5'})?$data->apgar_skore->{'1menit'}->{'5'}:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->{'5'})?$data->apgar_skore->{'2menit'}->{'5'}:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td> </td>
                                    <td></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'1menit'}->total_skore)?$data->apgar_skore->{'1menit'}->total_skore:'' ?></td>
                                    <td style="text-align:center"><?= isset($data->apgar_skore->{'2menit'}->total_skore)?$data->apgar_skore->{'2menit'}->total_skore:'' ?></td>
                                </tr>
                            </table>

                            <table id="data" cellpadding="1px" border="0">
                                <tr>
                                    <td width="27%">Resusitasi</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->resusitasi->Resusitasi1)?$data->resusitasi->Resusitasi1:'' ?></td>
                                </tr>

                                <tr>
                                    <td width="20%">Obat-obat yang diberikan</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->resusitasi->obat_obat)?$data->resusitasi->obat_obat:'' ?></td>
                                </tr>

                                <tr>
                                    <td width="20%">Imunisasi</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->resusitasi->imunisasi)?$data->resusitasi->imunisasi:'' ?></td>
                                </tr>

                                <tr>
                                    <td width="20%">Menetek Pertama kali</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->resusitasi->menetek_pertama_kali)?$data->resusitasi->menetek_pertama_kali:'' ?> jam setelah lahir <?= isset($data->resusitasi->jam_stelah_lahir)?$data->resusitasi->jam_stelah_lahir:'' ?></td>
                                </tr>
                            </table>
                        </div><br>

                    <span>V. PEMERIKSAAN FISIK BAYI</span>
                    <div style="margin-left:25px">
                        <table>
                            <tr>
                                <td width="30%">1. Keadaan umum bayi</td>
                                <td width="2%">:</td>
                                <td><?= isset($data->keadaan_umum_bayi)?$data->keadaan_umum_bayi:'' ?></td>
                            </tr>
                            <tr>
                                <td>2. Tanda tanda vital</td>
                                <td>:</td>
                                <td>
                                    <span>Suhu : <?= isset($data->tanda_tanda->suhu)?$data->tanda_tanda->suhu:'' ?> °C</span>
                                    <span style="margin-left:20px">Frekuensi nadi : <?= isset($data->tanda_tanda->frekuensi_nadi)?$data->tanda_tanda->frekuensi_nadi:'' ?> x/menit</span><br>
                                    <span>Frekuensi Pernafasan <?= isset($data->tanda_tanda->frekuensi_pernafasan)?$data->tanda_tanda->frekuensi_pernafasan:'' ?> x/menit</span>
                                </td>
                            </tr>
                            <tr>
                                <td>3. Pernafasan</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "teratur" ? "checked":'':'' ?>>
                                    <span>Teratur</span> 
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "tidak_teratur" ? "checked":'':'' ?>>
                                    <span>Tidak Teratur</span> 
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "cuping_hidung" ? "checked":'':'' ?>>
                                    <span>Cuping Hidung</span> 
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "sianosis" ? "checked":'':'' ?>>
                                    <span>Sianosis</span> <br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "apnea" ? "checked":'':'' ?>>
                                    <span>Apnea</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->pernafasan)? $data->pernafasan == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain jelaskan <?= isset($data->{'tanda_tanda-Comment'})?$data->{'tanda_tanda-Comment'}:'' ?></span>
                                </td>
                            </tr>
                        </table>
                        <span>4. Peredaran Darah</span>

                        <table id="data" cellpadding="1px" border="0" style="margin-left:20px">
                            <tr>
                                <td width="30%">Denyut Nadi</td>
                                <td width="2%">:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->denyut_nadi)? $data->peredaran_darah[0]->denyut_nadi == "teratur" ? "checked":'':'' ?>>
                                    <span>Teratur</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->denyut_nadi)? $data->peredaran_darah[0]->denyut_nadi == "tidak_teratur" ? "checked":'':'' ?>>
                                    <span>Tidak Teratur</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->denyut_nadi)? $data->peredaran_darah[0]->denyut_nadi == "lemah" ? "checked":'':'' ?>>
                                    <span>Lemah</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Ekstremitas atas dan bawah</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->ekstremitas)? $data->peredaran_darah[0]->ekstremitas == "hangat" ? "checked":'':'' ?>>
                                    <span>Hangat</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->ekstremitas)? $data->peredaran_darah[0]->ekstremitas == "dingin" ? "checked":'':'' ?>>
                                    <span>Dingin</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->ekstremitas)? $data->peredaran_darah[0]->ekstremitas == "pucat" ? "checked":'':'' ?>>
                                    <span>Pucat</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->ekstremitas)? $data->peredaran_darah[0]->ekstremitas == "biru" ? "checked":'':'' ?>>
                                    <span>Biru</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->peredaran_darah[0]->ekstremitas)? $data->peredaran_darah[0]->ekstremitas == "merah_muda" ? "checked":'':'' ?>>
                                    <span>Merah muda</span>
                                </td>
                            </tr>
                        </table>
                    </div>   
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 2 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print') ?>
                </header>

                <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP NEONATUS</h4></center>
                <div style="font-size:12px">
                    <span>5. Eliminasi</span>

                    <table id="data" cellpadding="1px" border="0" style="margin-left:30px">
                        <tr>
                            <td width="10%">BAK</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->BAK)? $data->panel_eliminasi[0]->BAK == "ada" ? "checked":'':'' ?>>
                                <span>Ada</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->BAK)? $data->panel_eliminasi[0]->BAK == "belum" ? "checked":'':'' ?>>
                                <span>Belum</span> 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">Mekonium</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->mekonium)? $data->panel_eliminasi[0]->mekonium == "ada" ? "checked":'':'' ?>>
                                <span>Ada</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->mekonium)? $data->panel_eliminasi[0]->mekonium == "belum" ? "checked":'':'' ?>>
                                <span>Belum</span> 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">Feses</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->feses)? $data->panel_eliminasi[0]->feses == "ada" ? "checked":'':'' ?>>
                                <span>Ada</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->panel_eliminasi[0]->feses)? $data->panel_eliminasi[0]->feses == "belum" ? "checked":'':'' ?>>
                                <span>Belum</span> 
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">Konsistensi</td>
                            <td width="2%">:</td>
                            <td>
                               <?= isset($data->panel_eliminasi[0]->konsistensi)?$data->panel_eliminasi[0]->konsistensi:'' ?> warna <?= isset($data->panel_eliminasi[0]->warna)?$data->panel_eliminasi[0]->warna:'' ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">Frekuensi</td>
                            <td width="2%">:</td>
                            <td>
                            <?= isset($data->panel_eliminasi[0]->frekuensi)?$data->panel_eliminasi[0]->frekuensi:'' ?>
                            </td>
                        </tr>
                    </table>

                    <table id="data" cellpadding="1px" border="0">
                        <tr>
                            <td width="15%">6. Reflex</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("menghisap", $data->reflex)?'checked':'':'') ?>>
                                <span>Menghisap (suckling reflex)</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("menggenggam", $data->reflex)?'checked':'':'') ?>>
                                <span>Menggenggam (palmar gresp reflex)</span> <br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("mencari", $data->reflex)?'checked':'':'') ?>>
                                <span>Mencari (rooting reflex)</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("menelan", $data->reflex)?'checked':'':'') ?>>
                                <span>Menelan (swallowing reflex)</span> <br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("moro reflex", $data->reflex)?'checked':'':'') ?>>
                                <span>Moro Reflex</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->reflex)?in_array("", $data->reflex)?'checked':'':'') ?>>
                                <span>Babinski reflex</span>
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">7. Kepala</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("simetris", $data->kepala)?'checked':'':'') ?>>
                                <span>Simetris</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("asimetris", $data->kepala)?'checked':'':'') ?>>
                                <span>Asimetris</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("macrocephal", $data->kepala)?'checked':'':'') ?>>
                                <span>Macrocephal</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("microcephal", $data->kepala)?'checked':'':'') ?>>
                                <span>Microcephal</span> <br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("caput succedanum", $data->kepala)?'checked':'':'') ?>>
                                <span>Caput succedanum</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("luka lecet", $data->kepala)?'checked':'':'') ?>>
                                <span>Luka lecet</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("hematoma", $data->kepala)?'checked':'':'') ?>>
                                <span>Hematoma</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("hidrosefalus", $data->kepala)?'checked':'':'') ?>>
                                <span>Hidrosefalus</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("other", $data->kepala)?'checked':'':'') ?>>
                                <span>lain lain jelaskan <?= isset($data->{'kepala-Comment'})?$data->{'kepala-Comment'}:'' ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">8. Dada</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->dada)? $data->dada == "simetris" ? "checked":'':'' ?>>
                                <span>Simetris</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->dada)? $data->dada == "asimetris" ? "checked":'':'' ?>>
                                <span>Asimetris</span> 
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">9. Ekstremitas</td>
                            <td width="2%">:</td>
                            <td>
                                <span>Tangan</span>
                                <input style="margin-left:10px" type="checkbox" value="Tidak" <?php echo isset($data->ekstremitas[0]->ekstremitas_tangan)? $data->ekstremitas[0]->ekstremitas_tangan == "normal" ? "checked":'':'' ?>>
                                <span>Normal</span> 
                                <input style="margin-left:30px" type="checkbox" value="Tidak" <?php echo isset($data->ekstremitas[0]->ekstremitas_tangan)? $data->ekstremitas[0]->ekstremitas_tangan != "normal" ? "checked":'':'' ?>>
                                <span>Tidak nomal,jelaskan <?= isset($data->ekstremitas[0]->{'ekstremitas_tangan-Comment'})?$data->ekstremitas[0]->{'ekstremitas_tangan-Comment'}:'' ?></span> <br>

                                <span>Kaki</span>
                                <input style="margin-left:23px" type="checkbox" value="Tidak" <?php echo isset($data->ekstremitas[0]->ekstremitas_kaki)? $data->ekstremitas[0]->ekstremitas_kaki == "normal" ? "checked":'':'' ?>>
                                <span>Normal</span> 
                                <input style="margin-left:30px" type="checkbox" value="Tidak" <?php echo isset($data->ekstremitas[0]->ekstremitas_kaki)? $data->ekstremitas[0]->ekstremitas_kaki != "normal" ? "checked":'':'' ?>>
                                <span>Tidak nomal,jelaskan <?= isset($data->ekstremitas[0]->{'ekstremitas_kaki-Comment'})?$data->ekstremitas[0]->{'ekstremitas_kaki-Comment'}:'' ?></span> 
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">10. Abdomen</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->abdomen)? $data->abdomen == "normal" ? "checked":'':'' ?>>
                                <span>Normal</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->abdomen)? $data->abdomen != "normal" ? "checked":'':'' ?>>
                                <span>Tidak normal,jelaskan <?= isset($data->ekstremitas[0]->{'abdomen-Comment'})?$data->ekstremitas[0]->{'abdomen-Comment'}:'' ?></span> <br>

                               
                                <span>Tali Pusat</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->tali_pusat)? $data->tali_pusat == "perdarahan" ? "checked":'':'' ?>>
                                <span>Perdarahan</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->tali_pusat)? $data->tali_pusat == "tidak_perdarahan" ? "checked":'':'' ?>>
                                <span>Tidak Perdarahan</span><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cek_tali_pusat)? $data->cek_tali_pusat == "bau" ? "checked":'':'' ?>>
                                <span>Bau</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->cek_tali_pusat)? $data->cek_tali_pusat == "tidak_bau" ? "checked":'':'' ?>>
                                <span>Tidak Bau</span>
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">11. Alat Kelamin</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->alat_kelamin)? $data->question4[0]->alat_kelamin == "normal" ? "checked":'':'' ?>>
                                <span>Normal</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->alat_kelamin)? $data->question4[0]->alat_kelamin != "normal" ? "checked":'':'' ?>>
                                <span>Tidak Normal, jelaskan <?= isset($data->question4[0]->{'alat_kelamin-Comment'})?$data->question4[0]->{'alat_kelamin-Comment'}:'' ?></span> 
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">12. Anus</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->anus)? $data->question4[0]->anus == "normal" ? "checked":'':'' ?>>
                                <span>Normal</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->anus)? $data->question4[0]->anus != "normal" ? "checked":'':'' ?>>
                                <span>Atresia ani <?= isset($data->question4[0]->{'anus-Comment'})?$data->question4[0]->{'anus-Comment'}:'' ?></span> 
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">13. Kulit</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "kemerahan" ? "checked":'':'' ?>>
                                <span>Kemerahan</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "pucat" ? "checked":'':'' ?>>
                                <span>Pucat</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "biru" ? "checked":'':'' ?>>
                                <span>Biru</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "kuning" ? "checked":'':'' ?>>
                                <span>Kuning</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "kering" ? "checked":'':'' ?>>
                                <span>Kering</span><br>

                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "mengelupas" ? "checked":'':'' ?>>
                                <span>Mengelupas</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "edema" ? "checked":'':'' ?>>
                                <span>Edema</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->kulit)? $data->question4[0]->kulit == "other" ? "checked":'':'' ?>>
                                <span>Lain lain jelaskan <?= isset($data->question4[0]->{'kulit-Comment'})?$data->question4[0]->{'kulit-Comment'}:'' ?></span>
                            </td>
                        </tr>

                        <tr>
                            <td width="10%">14. Turgor</td>
                            <td width="2%">:</td>
                            <td>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->turgor)? $data->question4[0]->turgor == "baik" ? "checked":'':'' ?>>
                                <span>Baik</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->turgor)? $data->question4[0]->turgor == "buruk" ? "checked":'':'' ?>>
                                <span>Buruk</span> 
                              
                            </td>
                        </tr>

                    </table>

                    <p>VI. DAFTAR DIAGNOSA KEPERAWATAN</p>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("gangguan_pertukaran", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Gangguan pertukaran gas (asfiksia)</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("ikterik_neonatus", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Ikterik neonatus</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("menyusui_efektif", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Menyusui efektif</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("menyusui_tidak_efektif", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Menyusui tidak efektif</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("resiko_ikterik", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Resiko ikterik neonatus</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("hipertermi", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Hipertemi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->diagnosa_keperawatan)?in_array("hipotermi", $data->diagnosa_keperawatan)?'checked':'':'') ?>>
                        <span>Hipotermi</span><br>
                        <?php 
                        $jml_array = isset($data->question1)?count($data->question1):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                         <input type="checkbox" value="Tidak" <?= (isset($data->question1[$x]->{'Column 1'})?in_array("item1", $data->question1[$x]->{'Column 1'})?'checked':'':'') ?>>
                        <span><?= isset($data->question1[$x]->{'Column 2'})?$data->question1[$x]->{'Column 2'}:'' ?></span><br>
                        <?php  } ?>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 3 dari 4</p>    
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

                <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP NEONATUS</h4></center>
                <div style="font-size:12px">
                    <p>VII. INTERVENSI KEPERAWATAN</p>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pemantauan_respirasi", $data->question5)?'checked':'':'') ?>>
                        <span>Pemantauan respirasi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("terapi_oksigen", $data->question5)?'checked':'':'') ?>>
                        <span>Terapi oksigen</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pencegahan_aspirasi", $data->question5)?'checked':'':'') ?>>
                        <span>Pencegahan aspirasi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pengaturan_posisi", $data->question5)?'checked':'':'') ?>>
                        <span>Pengaturan Posisi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pemberian_obat", $data->question5)?'checked':'':'') ?>>
                        <span>Pemberian obat (oral.IV,IM,IC,SC,dll)</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("fototerapi_neonatus", $data->question5)?'checked':'':'') ?>>
                        <span>Fototerapi naonatus</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("perawatan_bayi", $data->question5)?'checked':'':'') ?>>
                        <span>Perawatan bayi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("perawatan_neonatus", $data->question5)?'checked':'':'') ?>>
                        <span>Perawatan neonatus</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pemantauan_tanda_vital", $data->question5)?'checked':'':'') ?>>
                        <span>Pemantauan tanda vital</span><br> 
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("konseling_lactasi", $data->question5)?'checked':'':'') ?>>
                        <span>Konseling lactasi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("promosi_ASI", $data->question5)?'checked':'':'') ?>>
                        <span>Promosi ASI eksekutif</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("promosi_laktasi", $data->question5)?'checked':'':'') ?>>
                        <span>Promosi Laktasi</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pendampingan_proses", $data->question5)?'checked':'':'') ?>>
                        <span>Pendampingan proses menyusui</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("manajemen_nyeri", $data->question5)?'checked':'':'') ?>>
                        <span>Manajemen nyeri</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("manajemen_hipertermia", $data->question5)?'checked':'':'') ?>>
                        <span>Manajemen hipetermia</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("regulasi_temperatur", $data->question5)?'checked':'':'') ?>>
                        <span>Regulasi temperatur</span><br>
                       
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("manajemen_cairan", $data->question5)?'checked':'':'') ?>>
                        <span>Manajemen cairan</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("managemen_kejang", $data->question5)?'checked':'':'') ?>>
                        <span>Managemen kejang</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("pemantauan_cairan", $data->question5)?'checked':'':'') ?>>
                        <span>Pemantauan cairan</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("manajeman_hipotermia", $data->question5)?'checked':'':'') ?>>
                        <span>Manajemen hipotermia</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("kompres_panas", $data->question5)?'checked':'':'') ?>>
                        <span>Kompres panas</span><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("managemen_lingkungan", $data->question5)?'checked':'':'') ?>>
                        <span>Managemen lingkungan</span><br>
                        <?php 
                        $jml_array = isset($data->question3)?count($data->question3):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                         <input type="checkbox" value="Tidak" <?= (isset($data->question3[$x]->{'Column 1'})?in_array("item1", $data->question3[$x]->{'Column 1'})?'checked':'':'') ?>>
                        <span><?= isset($data->question3[$x]->{'Column 2'})?$data->question3[$x]->{'Column 2'}:'' ?></span><br>
                        <?php  } ?>

                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 4 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>
    </body>

    </html>