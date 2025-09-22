<?php 
$data = isset($sep)?json_decode($sep):'';
// var_dump($data);
// var_dump($daftar_ulang_irj);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Surat Eligibilitas Peserta</title>
    <style>
    @page { size: A5 landscape  }
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
<body class="A5 landscape">
  <!-- <div width="100%" style="display:flex;justify-content:space-between;">
    <button class="btn btn-primary">
      Back
    </button>
    <button class="btn btn-primary" >
      Print
    </button>
  </div> -->
  
  <section class="sheet padding-10mm">

   <div class="header">
        <img src="<?= base_url('assets/img/logo_bpjs.png') ?>" width="200" alt="">
        <div class="header-judul">
          <span style="font-size:11pt;">SURAT ELEGIBILITAS PESERTA <br>RSOMH BUKITTINGGI</span>
        </div>
   </div>
   <div class="content">
        <table  width="100%">
            <tr>
                <td width="20%" style="font-weight:bold;">No.SEP</td>
                <td>:</td>
                <td width="40%" style="font-weight:bold;font-size:11pt;"><?= isset($data)?$data->response->noSep:'-'; ?></td>
                <td>Peserta</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->peserta->jnsPeserta:'-' ?></td>
            </tr>
            <tr>
                <td>Tgl.SEP</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->tglSep:'-'; ?></td>
            </tr>
            <tr>
                <td>No.Kartu</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->peserta->noKartu .'&nbsp;(MR. '.$data->response->peserta->noMr.')':'-'; ?></td>
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->peserta->nama .'&nbsp;&nbsp;&nbsp;('.$data->response->peserta->kelamin.')':'-'; ?></td>
                <td>Jns.Rawat</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->jnsPelayanan:'-' ?></td>
            </tr>
            <tr>
                <td>Tgl.Lahir</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->peserta->tglLahir:'-'; ?></td>
                <td>Kls.Hak</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->peserta->hakKelas:'-' ?></td>
            </tr>
            <tr>
                <td>No.Telpon</td>
                <td>:</td>
                <td><?= isset($daftar_ulang_irj[0])?$daftar_ulang_irj[0]->no_hp == ""?'-':$daftar_ulang_irj[0]->no_hp:'-';  ?></td>
                <td>Kls.Rawat</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->kelasRawat:'-' ?></td>
            </tr>
            <tr>
                <td>Sub/Spesialis</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->poli:'-' ?></td>
                <td>Penjamin</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>DPJP Yg Melayani</td>
                <td>:</td>
                <td><?= isset($daftar_ulang_irj[0])?$daftar_ulang_irj[0]->nm_dokter:'-' ?></td>
            </tr>
            <tr>
                <td>Faskes Perujuk</td>
                <td>:</td>
                <td><?= isset($daftar_ulang_irj[0])?$daftar_ulang_irj[0]->nama_faskes_perujuk: '-' ?></td>
            </tr>
            <tr>
                <td>Diagnosa Awal</td>
                <td>:</td>
                <td><?= isset($data)?$daftar_ulang_irj[0]->diagnosa. '-' . $data->response->diagnosa:'-' ?></td>
            </tr>
            <tr >
                <td>Catatan</td>
                <td>:</td>
                <td><?= isset($data)?$data->response->catatan:'-' ?></td>
            </tr>
          </table>
          <table width="100%"> 
            <tr >
                  <td id="font-italic-normal" style="font-size:7pt !important;" colspan="6">*Saya Menyetujui BPJS Kesehatan menggunakan informasi media pasien jika diperlukan.</td>
                  <td>
                    <span>Pasien/Keluarga Pasien</span>
                  </td>
                </tr>
              <tr id="font-italic-normal">
                  <td id="font-italic-normal" style="font-size:7pt !important;  vertical-align: text-top;" colspan="6">*SEP Bukan sebagai bukti penjamin peserta.</td>
                  <td><br><br>
                  <span>______________________</span>
                
                </td>
              </tr>
          </table>
            
            
        <div class="row mt-4">
          <div >
            <span style="font-size:7pt;">Cetakan ke <?= isset($cetakan_ke)?$cetakan_ke:1; ?> <?= date('d-m-Y H:i:s').' wib' ?></span>
          </div>
        </div>
       
   </div>

  </section>


</body>


</html>