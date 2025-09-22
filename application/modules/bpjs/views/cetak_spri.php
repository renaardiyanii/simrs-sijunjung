<?php 
// echo '<pre>';
// var_dump($surat);
// var_dump($datapasien);
// echo '</pre>';
// die();

?>

<!DOCTYPE html>
<html>
<head>
    <title>SURAT PERINTAH RAWAT INAP(SPRI)</title>
    <style>
    @page { size: legal landscape  }
    *{
      font-size:9pt;
      font-family:Arial;
      font-weight:bold;
    }
    tr td{
      text-align:left;
    }
    .header{
      display:flex;
    }
    .header-judul{
      align-self:center;
      margin-left:2rem;
    }
    .mt-2{
      margin-top:2rem;
    }
    .mt-4{
      margin-top:4rem;
    }
    .row{
      display:flex;
      justify-content:space-between;
    }
    .btn-primary{
      background-color:#2ecc71;
      border:none;
      padding:1em 2em;
      margin:1em;
      color:white;
      border-radius:5px;
    }
    .btn-primary:focus{
      background-color:#27ae60;
    }

    </style>
</head>
<link rel="stylesheet" href="<?= base_url('assets/css/paper_sep.css') ?>">
<body class="legal landscape">
  <section class="sheet padding-10mm">
    <table width="100%">
      <tr>
        <td width="10%">
          <img src="<?php echo base_url('assets/img/logo_bpjs.png') ?>" width="300" alt="">
        </td>
        <td width="80%">
          <span style="font-weight:normal;font-size:20pt;">SURAT PERINTAH RAWAT INAP<br>RSUD SIJUNJUNG</span>
        </td>
        <td>
          <span style="font-weight:normal;font-size:20pt;">No.<?= $surat->response->noSuratKontrol ?></span>
        </td>
      </tr>
    </table>
   <!-- <div class="header" style="display:flex;justify-content:space-between">
        <div style="display:flex">

          <div class="header-judul" >
          </div>
        </div>
   </div> -->
   <div class="content">
        <table  width="100%" style="margin-left:15px;">
            <tr>
                <td width="11%" style="font-weight:normal;font-size:18pt;">Kepada Yth</td>
                <td></td>
                <td width="45%" style="font-weight:normal;font-size:18pt;"><?= $surat->response->namaDokter ?><br>Sp / Sub. <?= $surat->response->namaPoliTujuan ?></td>
                <td width="10%"></td>
                <td></td>
                <td width="30%"></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight:normal;font-size:18pt;">Mohon Pemeriksaan dan Penanganan Lebih Lanjut</td>
            </tr>
            <tr>
                <td style="font-weight:normal;font-size:18pt;">No. Kartu</td>
                <td style="font-weight:normal;font-size:18pt;">:</td>
                <td style="font-weight:normal;font-size:18pt;" ><?= $datapasien->no_kartu??'' ?></td>
            </tr>
            <tr>
                <td style="font-weight:normal;font-size:18pt;">Nama Peserta</td>
                <td style="font-weight:normal;font-size:18pt;">:</td>
                <td style="font-weight:normal;font-size:18pt;"><?= $datapasien->nama ?>&nbsp;&nbsp;( <?= $datapasien->sex=='L'?'Laki - Laki':'Perempuan' ?> )</td>
            </tr>
            <tr>
                <td style="font-weight:normal;font-size:18pt;">Tgl. Lahir</td>
                <td style="font-weight:normal;font-size:18pt;">:</td>
                <td style="font-weight:normal;font-size:18pt;"><?= date('Y-m-d',strtotime($datapasien->tgl_lahir)); ?></td>
            </tr>
            <tr>
                <td style="font-weight:normal;font-size:18pt;">Diagnosa</td>
                <td style="font-weight:normal;font-size:18pt;">:</td>
                <td style="font-weight:normal;font-size:18pt;"><?= $surat->response->sep->diagnosa??''; ?></td>
            </tr>
            <tr>
                <td style="font-weight:normal;font-size:18pt;">Rencana Kontrol</td>
                <td style="font-weight:normal;font-size:18pt;">:</td>
                <td style="font-weight:normal;font-size:18pt;"><?= $surat->response->tglRencanaKontrol ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight:normal;font-size:18pt;">
                Demikian atas bantuannya diucapkan banyak terima kasih
                </td>
                <td width="18%" align="center"></td>
                <td width="3%"></td>
                <td width="18%" align="center" style="font-weight:normal;font-size:18pt;">Mengetahui DPJP,</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td width="18%" align="center"><br/><br/><br/></td>
                <td width="3%"></td>
                <td width="18%" align="center" style="font-weight:normal;font-size:18pt;"><br/><br/><br/><?= $surat->response->namaDokterPembuat ?></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight:normal;font-size:18pt;">Tgl Entri : <?= $surat->response->tglTerbit ?> | Tgl. Cetak : <?= date('Y-m-d h:i A') ?></td>
            </tr>
        </table>
    
   </div>

  </section>


</body>


</html>