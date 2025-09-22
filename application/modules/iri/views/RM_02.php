<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style>
    #div1 {
        position: relative;
    }

    .header-parent {
        display: flex;
        justify-content: space-between;

    }

    .right {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
        height: 50px;
        font-size: 12px;
    }

    .patient-info {
        border: 1px solid black;
        padding: 1em;
        display: flex;
        border-radius: 10px;
    }

    #date {
        display: flex;
        justify-content: space-between;
    }

    .kotak {

        height: 10;
        width: 10;
        /* border: 1px solid black; */
    }

    #data {
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
        font-size: 10px;
        position: relative;
    }

    table {
        font-size: 10px;
    }

    #data thead tr th {
        text-align: center;
    }


    #column01 {
        text-align: center;
    }

    #footer {
        position: relative;
    }


    #text-footer2 {
        position: absolute;
        left: 10px;
        font-size: 10px
    }

    #text-footer3 {
        position: absolute;
        right: 10px;
        font-size: 10px
    }
    .width-25{
        width:25%;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">


<body class="A4">
    <div id="div1" class="A4 sheet padding-10mm">

        <header>
            <div class="header-parent">
                <img src="logo.PNG" height="80px" alt="">
                <div class="right">
                    <span>21.01.2020.RM.RJ.05 N</span>
                    <div class="patient-info">
                        <div id="identity">
                            <span>No. RM</span><br>
                            <span>NAMA</span><br>
                            <span>Tanggal Lahir</span>
                        </div>
                        <div id="result-identity">
                            <span>: </span><br>
                            <span>: Lk / Pr</span><br>
                            <span>: </span>
                        </div>
                    </div>
                </div>
            </div>
        </header><br>
        <div style="height:0px;border: 2px solid black;"></div>

        <div style="width: 100%;font-size: 12px;">
            <p style="font-weight: bold;text-align: center;">RINGKASAN MASUK DAN KELUAR PASIEN RAWAT INAP</p>
        </div>

        <table style="width: 100%;" >

            <tr>
                <td class="width-25" >Alamat</td>
                <td class="width-25">: </td>
                <td class="width-25">Tanggal Masuk</td>
                <td>: </td>
            </tr>
            <tr>
                <td></td>
                <td> </td>
                <td>Jam</td>
                <td>: </td>
            </tr>
            <tr>
                <td></td>
                <td> </td>
                <td>Telepon Rumah</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Suku Bangsa</td>
                <td>: </td>
                <td>Telepon Selular (HP)</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>: </td>
                <td>Telepon Kantor</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Status Pasien</td>
                <td>: </td>
                <td>No. KTP / SIM / Pasport</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: </td>
                <td>Agama</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Kelas Perawatan</td>
                <td>: </td>
                <td>Status Perkawinan</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Nama Keluarga Terdekat</td>
                <td>: </td>
                <td>Hubungan Keluarga</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: </td>
                <td>Telepon Selular (HP)</td>
                <td>: </td>
            </tr>
            <tr>
                <td></td>
                <td> </td>
                <td></td>
                <td> </td>
            </tr>
            <tr>
                <td>Perhatian Khusus</td>
                <td>: </td>
                <td>Alergi Obat</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Diagnosa Masuk & Kode ICD-10</td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td>Dokter yang merawat</td>
                <td>: </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lama dirawat </td>
                <td>: Hari</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Diagnosa Keluar & Kode ICD-10</td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td>Tindakan </td>
                <td colspan="3">:
                    
                </td>
            </tr>
            <tr>
                <td>Nama Tindakan & Kode ICD-9</td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">:
                    
                </td>
                <td> ()</td>
            </tr>
            <tr>
                <td>Golongan Operasi</td>
                <td colspan="3">
                    <input type="checkbox" name="" id=""><label for="">Kecil</label>
                    <input type="checkbox" name="" id=""><label for="">Sedang</label>
                    <input type="checkbox" name="" id=""><label for="">Besar</label>
                    <input type="checkbox" name="" id=""><label for="">Khusus</label>
                </td>
            </tr>
            <tr>
                <td>Jenis Anestesi</td>
                <td colspan="3">
                    <input type="checkbox" name="" id=""><label for="">Lokal</label>
                    <input type="checkbox" name="" id=""><label for="">Umum</label>
                    <input type="checkbox" name="" id=""><label for="">Regional</label>
                </td>
            </tr>
            <tr>
                <td>Infeksi Nosokomial</td>
                <td colspan="3">
                    <input type="checkbox" name="" id=""><label for="">Ya</label>
                    <input type="checkbox" name="" id=""><label for="">Tidak</label>
                </td>
            </tr>
            <tr>
                <td>Penyebab Infeksi</td>
                <td colspan="3">:
                    
                </td>
            </tr>
            <tr>
                <td>Keadaan Keluar</td>
                <td>Cara Keluar</td>
                <td rowspan="5" colspan="2">
                    <div style="display: inline; position: relative;">
                        <div style="float: right;">
                            <p>Bukittinggi, ………………………………………………..</p>
                            <p>Tanda Tangan</p><br><br><br>
                            <span>(.......)</span><br>
                            <span> Dokter yang merawat</span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""><label for="">Sembuh</label></td>
                <td><input type="checkbox" name="" id=""><label for="">Atas Persetujuan</label></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""><label for="">Perbaikan</label></td>
                <td><input type="checkbox" name="" id=""><label for="">Pulang Paksa</label></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""><label for="">Belum Sembuh</label></td>
                <td><input type="checkbox" name="" id=""><label for="">Pindah RS. Lain/Rujuk</label></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""><label for="">Meninggal < 48 Jam</label>
                </td>
                <td><input type="checkbox" name="" id=""><label for="">Lari</label></td>
            </tr>
            <tr>
                <td><input type="checkbox" name="" id=""><label for="">Meninggal ≥ 48 Jam</label></td>
                <td></td>
            </tr>
            <tr>
                <td>Nama Perusahaan / Penanggung Jawab Biaya</td>
                <td colspan="3">:
                    
                </td>
            </tr>
            <tr>
                <td>Alamat Penaggung Jawab Biaya</td>
                <td colspan="3">:
                    
                </td>
            </tr>
            <tr>
                <td>Telepon / HP</td>
                <td>: </td>
                <td>Yang dihubungi</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Nomor Asuransi</td>
                <td>: </td>
                <td>Keterangan</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Surat Jaminan</td>
                <td>
                    <input type="checkbox" name="" id=""><label for="">Ya</label>
                    <input type="checkbox" name="" id=""><label for="">Tidak</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                    <div style="display: inline; position: relative;">
                        <div style="float: right;">
                            <br><br><br>
                            <p>Bukittinggi, ………………………………………………..</p>
                            <p>Tanda Tangan</p><br><br><br>
                            <span>(.......)</span><br>
                            <span> Petugas Admission Pasien</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <br>

        <div id="footer">
            <p id="text-footer2">Hal 1 dari 1</p>
            <p id="text-footer3">Rev.27.01.2016.RM-001d / RI</p>
        </div>

    </div>

</body>

</html>