<?php 
// var_dump($data);
// // die();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Surat Eligibilitas Peserta</title>
  <style>

    * {
      font-size: 2pt;
      font-family: Arial;
      font-weight: bold;
    }

    tr td {
      text-align: left;
    }

    .header {
      display: flex;
    }

    .header-judul {
      align-self: center;
      margin-left: 2rem;
    }

    .mt-2 {
      margin-top: 2rem;
    }

    .mt-4 {
      margin-top: 4rem;
    }

    .row {
      display: flex;
      justify-content: space-between;
    }

    .btn-primary {
      background-color: #2ecc71;
      border: none;
      padding: 1em 2em;
      margin: 1em;
      color: white;
      border-radius: 5px;
    }

    .btn-primary:focus {
      background-color: #27ae60;
    }
    @media print {
      .printPageButton {
        display: none;
      }
    }
  </style>
</head>
<!-- <link rel="stylesheet" href="<?= base_url('assets/css/paper_sep.css') ?>"> -->
<body class="">
  <!-- <div class="printPageButton" width="100%" style="display:flex;justify-content:space-between;">
    <button class="btn btn-primary">
      Back
    </button> -->
    <!-- <button class="btn btn-primary printPageButton" onclick="window.print()">
      Print
    </button> -->
  <!-- </div> -->

  <section class="">

    <div class="header">
      <img src="<?= base_url('assets/img/logo_bpjs.png') ?>" width="80" alt="">
      <div class="header-judul">
        <span style="font-size:9pt;font-family: Arial, Helvetica, sans-serif;">SURAT ELEGIBILITAS PESERTA <br>RSUD AHMAD SYAFII MAARIF</span>
      </div>
    </div>
    <div class="content">
      <table width="100%">
        <tr>
          <td width="18%" style="font-weight:bold;font-family: Arial, Helvetica, sans-serif;font-size:9pt">No.SEP</td>
          <td width="2%">:</td>
          <td width="30%" style="font-weight:bold;font-size:9pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->noSep : '-'; ?></td>
          <td width="18%" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">PRB</td>
          <td width="2%" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td width="30%" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $daftarulang->prb : '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Tgl.SEP</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->tglSep : '-'; ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Katarak</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->katarak == '1'?"Ya":"":"" ?></td>

        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">No.Kartu</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->peserta->noKartu . '&nbsp;(MR. ' . $daftarulang->no_cm . ')' : '-'; ?></td>
          
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Peserta</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->peserta->jnsPeserta : '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Nama Peserta</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->peserta->nama : '-'; ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Jns.Rawat</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->jnsPelayanan : '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Tgl.Lahir</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->peserta->tglLahir . '&nbsp; Kelamin :' . ($data->response->peserta->kelamin == 'L' ? ' Laki - Laki' : ' Perempuan') : '-'; ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Jns. Kunjungan</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($daftarulang) ? $daftarulang->jenis_kunjungan : '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">No.Telpon</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($daftarulang) ? $daftarulang->notelp == "" ? '-' : $daftarulang->notelp : '-';  ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Poli Perujuk</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Sub/Spesialis</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->poli : '-' ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Kls.Hak</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->peserta->hakKelas : '-' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">DPJP Yg Melayani</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= $data->response->dpjp->nmDPJP ?></td>
          <!-- perbaikan penghilangan kelas rawat -->
          <?php
          if (substr($daftarulang->no_register, 0, 2) == 'RI') {
            echo '<td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Kls.Rawat</td>
            <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
            <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">' . (isset($data) ? $data->response->kelasRawat : ' - ') . '</td>';
          }
          ?>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Faskes Perujuk</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= $daftarulang->namafaskes ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Diagnosa Awal</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= $daftarulang->diagawal . ' - ' . $data->response->diagnosa ?></td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Penjamin</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= isset($data) ? $data->response->klsRawat->penanggungJawab : '' ?></td>
        </tr>
        <tr>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Catatan</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">:</td>
          <td style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;"><?= $data->response->catatan ?></td>
        </tr>
        <!-- <tr>
          <td colspan ="6"><br></td>
        </tr> -->
        <tr>
          <td colspan ="4" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi media pasien jika diperlukan.</td>
          <td colspan ="2" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">Pasien/Keluarga Pasien</td>
         
        </tr>
        <tr>
          <td colspan ="6"><br></td>
        </tr>
        <!-- <tr>
          <td colspan ="6"><br></td> -->
        <!-- </tr>
        <tr>
          <td colspan ="6"><br></td>
        </tr>
        <tr>
          <td colspan ="6"><br></td>
        </tr> -->
        <tr>
          <td colspan ="4" style="font-size:8pt;font-family: Arial, Helvetica, sans-serif;">*SEP Bukan sebagai bukti penjamin peserta.</td>
          <td colspan ="2">
							<img width="50"  src="data:image/png;base64,<?= $qrCodeBase64 ?>" alt="QR Code" />
          </td>
         
        </tr>
      </table>

     


      <div>
        <div>
          <span style="font-size:5pt;">Cetakan ke <?= isset($cetakan_ke) ? $cetakan_ke : 1; ?> <?= date('d-m-Y H:i:s') . ' wib' ?></span>
        </div>
      </div>

    </div>

  </section>


</body>


</html>