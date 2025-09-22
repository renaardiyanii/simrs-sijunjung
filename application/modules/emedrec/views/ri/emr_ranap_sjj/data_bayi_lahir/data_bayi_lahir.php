<?php
$data = (isset($data_bayi_lahir->formjson)?json_decode($data_bayi_lahir->formjson):'');
// var_dump($data);
?>

<head>
    <title></title>
</head>

<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 11px;
    position: relative;


}

#data tr td {

    font-size: 11px;
    /* font-family: arial; */
    line-height:1;

}

#data th {

    font-size: 10px;
    /* font-family: arial; */

}

#noborder td {
    font-family: arial;
    font-size: 12px;
}
</style>

</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_new') ?>
        </header>
        <table border="1" width="100%" cellpadding="5px">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Bidan)</td>
                <td style="text-align:right;font-style:italic">Halaman 1 dari 4</td>
            </tr>
        </table>
   
        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td width="28%">Tanggal Dilahirkan</td>
                                <td width="2%">:</td>
                                <td width ="30"></td>
                                <td width="10%">Jam</td>
                                <td width="2%">:</td>
                                <td width ="20"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td style="font-size:10px">
                        <table border="0" width="100%" style="font-size:10px">
                            <tr>
                                <td width="18%">Sumber Data</td>
                                <td width="2%">:</td>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Pasien</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Keluarga</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Lainnya</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="18%">Rujukan</td>
                                <td width="2%">:</td>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya , </span>
                                    <input type="checkbox" value="Tidak" style="margin-left:10px">
                                    <span>RS</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Puskesmas</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Dokter</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Bidan</span>
                                </td>
                            </tr>

                            <tr>
                                <td width="18%">Diagnosa Rujukan</td>
                                <td width="2%">:</td>
                                <td></td>
                        </table>
                    </td>
                </tr>
            </table>

            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td>
                        <p style="font-weight:bold">ASESMEN KEPERAWATAN </p>

                        <p style="font-weight:bold;margin-left:10px">
                            <span>1. IDENTITAS PASIEN<span>
                            <span style="margin-left:400px">SUAMI<span>
                        </p>

                        <table border="1" width="100%" cellpadding="5px" id="data">
                            <tr>
                                <td width="50%">
                                    <table border="0" cellpadding="5px">
                                        <tr>
                                            <td width="18%">Nama</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Tgl.lahir</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Pendidikan</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Pekerjaan</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Agama</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Suku</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Gol Darah</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>

                                <td width="50%">
                                    <table border="0" id="data" cellpadding="5px">
                                        <tr>
                                            <td width="18%">Nama</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Tgl.lahir</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Pendidikan</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Pekerjaan</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Agama</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Suku</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Gol Darah</td>
                                            <td width="2%">:</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Alamat</td>
                            </tr>
                        </table>

                        <p style="font-weight:bold;margin-left:10px">
                            <span>2. KELUHAN UTAMA :<span>    
                        </p>

                        <div style="min-height:20px"></div>

                        <p style="font-weight:bold;margin-left:10px">
                            <span>3. RIWAYAT KESEHATAN :<span>    
                        </p>

                        <div style="margin-left:20px">
                            <p>a. Riwayat Penyakit Dahulu :
                                <input type="checkbox" value="Tidak">
                                <span>Tidak</span>
                                <input type="checkbox" value="Tidak">
                                <span>Ya, Penyakit</span>
                            </p>
                            <div style="margin-left:20px">
                                <table width="100%">
                                    <tr>
                                        <td width="23%"><li>Pernah Dirawat</li></td>
                                        <td width="2%">:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya, Diagnosa</span>
                                            <span></span>
                                            <span style="margin-left:20px">Kapan :</span>
                                            <span style="margin-left:20px">Dimana :</span>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td><li>Pernah Di operasi</li></td>
                                        <td>:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya, Jenis Operasi</span>
                                            <span></span>
                                            <span style="margin-left:20px">Kapan :</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><li>Masih dalam pengobatan</li></td>
                                        <td>:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya, Obat</span>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <p>b. Riwayat Penyakit Keluarga :
                                <div style="margin-left:15px">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya (
                                        <input type="checkbox" value="Tidak">
                                        <span>Hipertensi</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Jantung</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Paru</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>DM</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Ginjal</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Lainnya</span>
                                    )
                                    </span>
                                </div>
                            </p>

                            <p>c. Ketergantungan Terhadap :
                                <div style="margin-left:15px">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya (
                                        <input type="checkbox" value="Tidak">
                                        <span>Obat-obatan</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Rokok</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Alkohol</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Lainnya</span>
                                    )
                                    </span>
                                </div>
                            </p>

                            <p>d. Riwayat pekerjaan ( apakah berhubungan dengan zat- zat berbahaya ) :
                                <div style="margin-left:15px">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya, sebutkan</span>
                                </div>
                            </p>

                            <p>e. Riwayat Alergi :
                                <input type="checkbox" value="Tidak">
                                <span>Tidak</span>
                                <input type="checkbox" value="Tidak">
                                <span>Ya</span>
                                <input type="checkbox" value="Tidak">
                                <span>Obat</span>
                                <input type="checkbox" value="Tidak">
                                <span>Makanan</span>
                                <input type="checkbox" value="Tidak">
                                <span>Lainnya</span>
                                <div style="margin-left:15px"> Reaksi : </div>
                            </p>

                            <p>f. Riwayat pemakaian alat kontrasepsi :
                                <div style="margin-left:15px">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya, jenis</span>
                                    <span style="margin-left:15px">Lama Pemakaian :</span>
                                    <span style="margin-left:15px">Keluhan :</span>
                                </div>
                            </p>

                            <p>g. Riwayat Pernikahan :</p>
                            <div style="margin-left:20px">
                                <table width="100%">
                                    <tr>
                                        <td width="23%"><li>Status Pernikahan</li></td>
                                        <td width="2%">:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>single</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Menikah ... kali</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Bercerai</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Janda</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Duda</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><li>Umur waktu pertama kawin</li></td>
                                        <td>:</td>
                                        <td>
                                            <span>.... tahun</span>
                                            <span style="margin-left:20px">Kawin dengan suami 1: .... , tahun</span>
                                            <span style="margin-left:20px">ke 2: .... tahun,</span>
                                            <span style="margin-left:20px">ke 3: .... tahun</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><li>Volume</li></td>
                                        <td>:</td>
                                        <td>
                                            <span>.... cc/24 jam</span>
                                            <span style="margin-left:20px">Keluhan saat haid</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya</span>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <p>h. Riwayat Penyakit Ginekologi :
                                <div style="margin-left:20px">
                                    <input type="checkbox" value="Tidak">
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Ya (</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Infertilitas </span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Infeksi Virus</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>PMS </span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Endometriosis </span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Myoma </span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Polyp Cervix</span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Kanker </span>
                                    <input type="checkbox" value="Tidak">
                                    <span>Lain-lain )</span>
                                </div>
                            </p>




                        </div>

                    </td>
                </tr>
                
            </table>
        </div>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>
    </div>

    <div class="A4 sheet  padding-fix-10mm">
         <header>
            <?php $this->load->view('emedrec/ri/header_print_new') ?>
        </header>
        <table border="1" width="100%" cellpadding="5px">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Bidan)</td>
                <td style="text-align:right;font-style:italic">Halaman 2 dari 4</td>
            </tr>
        </table>

        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td>
                        <div style="margin-left:20px">
                                <p>i. Riwayat Menstruasi</p>
                                <div style="margin-left:20px">
                                <li>
                                        <span>Menarche, umur : .... tahun,</span>
                                        <span style="margin-left:20px"> Siklus : ……. hari,</span>
                                        <input type="checkbox" value="Tidak">
                                        <span>Teratur  </span>
                                        <input type="checkbox" value="Tidak">
                                        <span> Tidak teratur, lama : ... hari </span>
                                </li>
                                </div>

                                <p>j. Riwayat Hamil ini :</p>
                                <div style="margin-left:20px">
                                <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="18%"><li>HPHT</li></td>
                                            <td width="2%">:</td>
                                            <td>.........................Taksiran Partus:</td>
                                        </tr>
                                        <tr>
                                            <td><li>Asuhan Antenatal</li></td>
                                            <td>:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Tidak</span> 
                                                <input type="checkbox" value="Tidak">
                                                <span>Ya</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>( Dokter Kandungan</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Dokter Umum</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Bidan</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Lainnya )</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><li>Frekwensi</li></td>
                                            <td>:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>1X</span> 
                                                <input type="checkbox" value="Tidak">
                                                <span>2X </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>3X </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>>3X</span>

                                                <span style="margin-left:20px">Imunisasi TT :</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Tidak</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Ya .... kali</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><li>Keluhan saat hamil</li></td>
                                            <td>:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Mual </span> 
                                                <input type="checkbox" value="Tidak">
                                                <span>Muntah  </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Perdarahan  </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Pusing </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Sakit Kepala</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Lainnya</span>
                                            </td>
                                        </tr>
                                </table>
                                </div>
                        </div>

                        <p style="font-weight:bold;margin-left:10px">
                            <span>4. RIWAYAT KEHAMILAN, PERSALINAN DAN NIFAS<span>    
                        </p>

                        <table border="1" width="100%" cellpadding="5px" id="data">
                            <tr>
                                <th width="5%" rowspan="2">No</th>
                                <th rowspan="2" width="5%">Tgl/th Partus</th>
                                <th rowspan="2" width="8%">Tempatpartus</th>
                                <th rowspan="2" width="8%">Umur Kehamilan</th>
                                <th rowspan="2" width="8%">Jenis Persalinan</th>
                                <th rowspan="2" width="8%">Penolong</th>
                                <th rowspan="2" width="8%">Penyulit</th>
                                <th colspan="3" width="10%">Anak</th>
                                <th rowspan="2" width="8%">Nifas</th>
                                <th rowspan="2" width="8%">Keadaan Anak Sekarang</th>
                            </tr>

                            <tr>
                                <th>JK</th>
                                <th>BB</th>
                                <th>PB</th>
                            </tr>

                            <tr>
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><br></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>

                        <p style="font-weight:bold;margin-left:10px">
                            <span>5. KEBUTUHAN BIO-PSIKOLOGIS DAN SOSIAL<span>    
                        </p>

                        <div style="margin-left:20px">
                            <p><span>a. Status Psikologis :<span></p>
                                <table border="0" width="100%" cellpadding="5px">
                                    <tr>
                                        <td width="23%"><li>Masalah Perkawinan</li></td>
                                        <td width="2%">:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya  : cerai/ istri baru / </span>
                                            <span style="margin-left:20px">Lain - lain ..... </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><li>Mengalami kekerasan  fisik</li></td>
                                        <td>:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya </span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Mencederai orang  lain </span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak </span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><li>Trauma dalam kehidupan</li></td>
                                        <td>:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya, Jelaskan  : ...... </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><li>Gangguan tidur</li></td>
                                        <td>:</td>
                                        <td>
                                            <input type="checkbox" value="Tidak">
                                            <span>Tidak</span>
                                            <input type="checkbox" value="Tidak">
                                            <span>Ya, Jelaskan  : ...... </span>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="30%"><li>Konsultasi dengan psikologi/psikiater</li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Tidak</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Ya, Jelaskan  : ...... </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><li>Penerimaan kondisi saat ini</li></td>
                                            <td>:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Menerima</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Tidak  Menerima, Jelaskan :</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><li>Dukungan sosial dari</li></td>
                                            <td>:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Suami</span>
                                                <input type="checkbox" value="Tidak">
                                                <span> Orang Tua </span>
                                                <input type="checkbox" value="Tidak">
                                                <span> Keluarga</span>
                                                <input type="checkbox" value="Tidak">
                                                <span> Lainnya </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <li>Pendamping persalinan yang diinginkan ( bila hamil ) : </li>
                                            </td>
                                        </tr>
                                </table>

                            <p><span>b. Kebutuhan sosial : <span></p>
                                <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="26%"><li>Status pernikahan</li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <input type="checkbox" value="Tidak">
                                                <span>Single </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Menikah ......... kali</span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Bercerai  </span>
                                                <input type="checkbox" value="Tidak">
                                                <span>Janda </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><li>Umur waktu pertama kawin</li></td>
                                            <td>:</td>
                                            <td>
                                                <span>............th </span>
                                                <span style="margin-left:20px"> Kawin dengan suami   1:.........th, </span>
                                                <span style="margin-left:20px">  ke 2,3 :..............th </span>
                                            </td>
                                        </tr>
                                </table>
                                <p><span>c. Kebutuhan biologis <span></p>
                                <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="26%"><li>Pola Makan</li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <span>............x/hari </span>
                                                <span style="margin-left:20px"> Terakhir jam</span>
                                                <span style="margin-left:20px">  ................................. </span>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td width="26%"><li>Pola Minum</li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <span>............cc/hari </span>
                                                <span style="margin-left:20px"> Terakhir jam</span>
                                                <span style="margin-left:20px">  ................................. </span>
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td width="26%"><li>Pola Eliminasi</li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <span>Bak................x/hari </span>
                                                <span style="margin-left:20px"> Terakhir jam</span>
                                                <span style="margin-left:20px">  ................................. </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="26%"><li></li></td>
                                            <td width="2%">:</td>
                                            <td>
                                                <span>Bab................x/hari </span>
                                                <span style="margin-left:20px"> Terakhir jam</span>
                                                <span style="margin-left:20px">  ................................. </span>
                                            </td>
                                        </tr>
                                       
                                </table>
                               
                        </div>
                        <p style="font-weight:bold;margin-left:10px">
                            <span>6. KEBUTUHAN KOMUNIKASI DAN EDUKASI<span>    
                        </p>
                        <p>Terdapat hambatan dalam pembelajaran :  </p>
                        <p><input type="checkbox">Tidak <input type="checkbox">Ya : <input type="checkbox">Pendengaran<input type="checkbox">Penglihatan <input type="checkbox">Kognitif<input type="checkbox">Fisik <input type="checkbox">Budaya <input type="checkbox">Emos <input type="checkbox">Bahasa <input type="checkbox">Lainnya.................</p>
                        <p>Dibutuhkan penerjemah :  <input type="checkbox">Tidak<input type="checkbox">Ya, sebutkan..............................&nbsp; Bahasa Isyarat :<input type="checkbox">Tidak <input type="checkbox">Ya </p>
                         </td>
                </tr>
            </table>
        </div>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>

    </div>
    <div class="A4 sheet  padding-fix-10mm">
         <header>
            <?php $this->load->view('emedrec/ri/header_print_new') ?>
        </header>
        <table border="1" width="100%"  cellpadding="5px">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Bidan)</td>
                <td style="text-align:right;font-style:italic">Halaman 3 dari 4</td>
            </tr>
        </table>

        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td>
                        <div style="margin-left:20px">
                        <p>Kebutuhan edukasi (pilih topik edukasi pada kotak yang tersedia)	:                        </p>
                        <p><input type="checkbox">Diagnos dan Manajemen Penyakit <input type="checkbox">Obat-obatan  / Terapi <input type="checkbox"> Diet dan Nutrisi<br>
                        <input type="checkbox">Tindakan Keperawatan............... <input type="checkbox">Rehabilitasi <input type="checkbox">Manajemen Nyeri <input type="checkbox">Lain lain , sebutkan..........................</p>
                        <p style="font-weight:bold;margin-left:10px">
                            <span>7. RISIKO CEDERA/JATUH (isi formulir monitoring pencegahan jatuh) <span>    
                        </p>
                        <p><input type="checkbox">Tidak <input type="checkbox">Ya,  JikaYa, gelang resiko jatuh warna kuning harus dipasang.</p>
                        <p style="font-weight:bold;margin-left:10px">
                            <span>8. STATUS FUNGSIONAL ( Isi Formulir Barthel Index)                            <span>    
                        </p>
                        <p>Aktivitas dan Mobilisasi : <input type="checkbox">Mandiri <input type="checkbox">Perlu bantuan, sebutkan.........................</p>
                        <p>Alat bantu, sebutkan ...............................................................................................</p>
                        <p><b>Bila terdapat gangguan fungsional, pasien di konsul ke Rehabilitasi Medis melalui DPJP                        </b></p>
                        <p style="font-weight:bold;margin-left:10px">
                            <span>9. SKALA NYERI <span>    
                        </p>
                        <p><input type="checkbox">Tidak<input type="checkbox">Ya </p>
                        <p><img src="<?= base_url("assets/img/skala nyer.jpg"); ?>" alt="img" height="150px" width="300px"><img src="<?= base_url("assets/img/nyeri.png"); ?>" alt="img" height="150px" width="300px"></p>
                        <p><input type="checkbox">Nyeri Kronis,  Lokasi :............................Frekuensi :...........................................Durasi :...........................................</p>
                        <p><input type="checkbox">Nyeri Akut,  Lokasi :............................Frekuensi :...........................................Durasi :...........................................</p>
                        <p><input type="checkbox">Skor nyeri (0-10): .........................................................</p>
                        <p>Nyeri hilang :</p>
                        <p><input type="checkbox">Minum obat  <input type="checkbox"> Istirahat  <input type="checkbox"> Mendengar musik  <input type="checkbox">Berubah posisi  <input type="checkbox"> Lain lain , sebutkan.......................................</p>
                        <p style="font-weight:bold;margin-left:10px">
                            <span>10. NUTRISI <span>    
                        </p>
                        <p><input type="checkbox"> Untuk pasien dengan masalah obstetri / Kehamilan / Nifas </p>
                        <table border="1" width="100%" cellpadding="5px" id="data">
                            <tr>
                                <td>NO</td>
                                <td>PARAMETER</td>
                                <td>PENILAIAN</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Apakah asupan makan berkurang karena nafsu makan berkurang?</td>
                                <td><input type="checkbox">Tidak<input type="checkbox">Ya</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Ada gangguan metabolism (DM, gangguan fungsi tiroid, infeksi kronis, lain-lain (sebutkan) ........................)</td>
                                <td><input type="checkbox">Tidak<input type="checkbox">Ya</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Ada pertambahan berat badan yang kurang atau lebih sesuai usia kehamilan</td>
                                <td><input type="checkbox">Tidak<input type="checkbox">Ya</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Nilai Hb< 10b g/dl atau HCT < 30%                                </td>
                                <td><input type="checkbox">Tidak<input type="checkbox">Ya</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>

    </div>
    <div class="A4 sheet  padding-fix-10mm">
         <header>
            <?php $this->load->view('emedrec/ri/header_print_new') ?>
        </header>
        <table border="1" width="100%"  cellpadding="5px">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Bidan)</td>
                <td style="text-align:right;font-style:italic">Halaman 4 dari 4</td>
            </tr>
        </table>

        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" id="data">
                <tr>
                    <td>
                        <div style="margin-left:20px">
                        <p>Bila jawabanya ≥ 1  dilaporkan kepada Tim Terapi Gizi. Tgl :............................ Jam :..............................                      </p>
                        <p><input type="checkbox"> Untuk pasien dengan masalah Ginekologi /Onkologi :</p>
                        <table border="1" width="100%" cellpadding="5px" id="data">
                            <tr>
                                <td>NO</td>
                                <td>PARAMETER</td>
                                <td>SKOR</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td colspan="2">Apakah pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6 bulan terakhir?</td>
                                
                            </tr>
                            <tr>
                                <td></td>
                                <td>a. Tidak penurunan berat badan</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">Jika ya, berapa penurunan berat badan tersebut                               </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>1-5 kg</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>6-10 kg</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>11-15 kg</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>>15 kg</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Tidak yakin penurunan nya</td>
                                <td>2</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="2">Apakah asupan makan berkurang karena berkurangnya nafsu makan?</td>
                               
                            </tr>
                            <tr>
                                <td></td>
                                <td>a. Tidak</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>b. Ya</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td colspan="2">Total Skor</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">3.  Pasien dengan diagnosa khusus : <input type="checkbox">Tidak <input type="checkbox">Ya (<input type="checkbox">DM <input type="checkbox">Ginja <input type="checkbox">Hati <input type="checkbox">Jantung <input type="checkbox"> Paru <input type="checkbox">Stroke <input type="checkbox"> Kanken <input type="checkbox"> Penurunan imunitas <input type="checkbox"> Geriatri <input type="checkbox"> Lainnya......................)</td>
                            </tr>
                        </table>
                        <p><b>Bila skor ≥2 dan atau pasien dengan diagnosis/kondisi khusus dilakukan pengkajian lanjut oleh Tim Terapi Gizi                        </b></p>
                        <p>Sudah dilaporkan ke Tim Terapi Gizi: <input type="checkbox">Tidak  <input type="checkbox">Ya, tanggal & jam..........................
                        <table border="1" width="100%" cellpadding="5px" id="data">
                            <tr>
                                <td><b>MASALAH KEBIDANAN</b></td>
                                <td><b>TUJUAN / TARGET TERUKUR</b></td>
                            </tr>
                            <tr>
                                <td style="height: 100px;">&nbsp;</td>
                                <td style="height: 100px;">&nbsp;</td>
                            </tr>
                        </table>
                        <p><input type="checkbox">Disusun Rencana Kebidanan</p><br><br><br><br><br><br>
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanggal & Jam </p>
                                <p style="margin: 5px 0;">Bidan yang Melakukan Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam </p>
                                <p style="margin: 5px 0;">Bidan yang Melengkapi Pengkajian                                </p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>

    </div>

</body>


   