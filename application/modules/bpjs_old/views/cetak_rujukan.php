<?php 
// date_default_timezone_set("Asia/Jakarta");
// echo '<pre>';
// var_dump($rujukan);
// echo '</pre>';
// date_default_timezone_set("Asia/Jakarta");

function parsingbulan($bulan)
{
  switch($bulan){
    case '01':
      return 'Januari';
      break;
    case '02':
      return 'Februari';
      break;
    case '03':
      return 'Maret';
      break;
    case '04':
      return 'April';
      break;
    case '05':
      return 'Mei';
      break;
    case '06':
      return 'Juni';
      break;
    case '07':
      return 'Juli';
      break;
    case '08':
      return 'Agustus';
      break;
    case '09':
      return 'September';
      break;
    case '10':
      return 'Oktober';
      break;
    case '11':
      return 'November';
      break;
    case '12':
      return 'Desember';
      break;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SURAT RUJUKAN RSOMH BUKITTINGGI</title>
    <style>
    @page { size: legal landscape  }
    *{
      font-size:9pt;
      font-family:Arial;
      /* font-weight:bold; */
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

   <div class="header" style="display:flex;justify-content:space-between;">
        <div style="display:flex">
          <img src="<?= base_url('assets/img/logo_bpjs.png') ?>" width="220" alt="">
          <div class="header-judul" >
            <span style="font-size:13pt;">SURAT RUJUKAN<br>RSOMH BUKITTINGGI</span>
          </div>
        </div>
        <div class="header-judul">
          <span style="font-size:17pt;">No. <?= $rujukan->response->rujukan->noRujukan ?></span><br>
          <span style="font-size:15pt;">Tgl. <?= date('d',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)).' '.parsingbulan(date('m',strtotime($rujukan->response->rujukan->tglRencanaKunjungan))).' '.date('Y',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)) ?></span>
        </div>

   </div>
   <div class="content">
        <table  width="100%" style="margin-left:15px;">
            <tr>
                <td width="11%" style="padding-bottom:20px;font-size:11pt;<?= $rujukan->response->rujukan->tipeRujukan=='1'|| $rujukan->response->rujukan->tipeRujukan=='2'?'':'padding-bottom:20px;' ?>">Kepada Yth</td>
                <td width="" style="font-size:11pt;<?= $rujukan->response->rujukan->tipeRujukan=='1' || $rujukan->response->rujukan->tipeRujukan=='2'?'padding-bottom:20px;':''?>">: <?= $rujukan->response->rujukan->tipeRujukan=='1' || $rujukan->response->rujukan->tipeRujukan=='2'?'':($rujukan->response->rujukan->namaPoliRujukan.'<br>&nbsp;&nbsp;') ?> <?= $rujukan->response->rujukan->namaPpkDirujuk ?></td>
                <td width="20%"></td>
                <td ></td>
                <td colspan="2" style="font-size:11pt;">== <?= $rujukan->response->rujukan->namaTipeRujukan ?> ==</td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:11pt;">Mohon Pemeriksaan dan Penanganan Lebih Lanjut</td>
                <td colspan="" ></td>
                <td colspan="3" style="font-size:11pt;"><?= $rujukan->response->rujukan->jnsPelayanan=='2'?'Rawat Jalan':'Rawat Inap' ?></td>
            </tr>
            <tr>
                <td style="font-size:11pt;">No. Kartu</td>
                <td style="font-size:11pt;">: <?= $rujukan->response->rujukan->noKartu ?></td>
                <td ></td>
            </tr>
            <tr>
                <td style="font-size:11pt;">Nama Peserta</td>
                <td style="font-size:11pt;">: <?= $rujukan->response->rujukan->nama ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<?= $rujukan->response->rujukan->kelamin=='L'?"Laki-Laki":'Perempuan' ?>)</td>
                <td></td>
            </tr>
            <tr>
                <td style="font-size:11pt;">Tgl. Lahir</td>
                <td style="font-size:11pt;">: <?= date('d',strtotime($rujukan->response->rujukan->tglLahir)).' '.parsingbulan(date('m',strtotime($rujukan->response->rujukan->tglLahir))).' '.date('Y',strtotime($rujukan->response->rujukan->tglLahir)) ?></td>
                <td ></td>
            </tr>
            <tr>
                <td style="font-size:11pt;">Diagnosa</td>
                <td style="font-size:11pt;">: <?= $rujukan->response->rujukan->namaDiagRujukan ?></td>
                <td ></td>
            </tr>
            <tr>
                <td style="font-size:11pt;">Keterangan</td>
                <td style="font-size:11pt;">: <?= $rujukan->response->rujukan->catatan ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:11pt;">
                Demikian atas bantuannya diucapkan banyak terima kasih
                </td>
                <td width="18%" align="center"></td>
                <td width="3%"></td>
                <td width="18%" align="center" style="font-size:11pt;">Mengetahui,</td>
            </tr>
            <tr>
                <?php 
                if($rujukan->response->rujukan->tipeRujukan=='1'){
                  echo '<td colspan="2" style="font-size:7pt;">* Rujukan ini Rujukan Parsial,tidak dapat digunakan untuk penerbitan SEP pada FKRTL penerima rujukan.</br>';
                  echo '* Tgl.Rencana Berkunjung '.date('d',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)).' '.parsingbulan(date('m',strtotime($rujukan->response->rujukan->tglRencanaKunjungan))).' '.date('Y',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)).'</td>';
                }
                elseif($rujukan->response->rujukan->tipeRujukan=='2'){
                  echo '<td colspan="2"></td>';
                }
                else{
                  
                ?>
                <td colspan="2" style="font-size:7pt;">* Rujukan Berlaku Sampai Dengan <?= date('d',strtotime('+90days',strtotime($rujukan->response->rujukan->tglRujukan))).' '.parsingbulan(date('m',strtotime('+90days',strtotime($rujukan->response->rujukan->tglRujukan)))).' '.date('Y',strtotime('+90days',strtotime($rujukan->response->rujukan->tglRujukan))) ?><br>* Tgl. Rencana Berkunjung <?= date('d',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)).' '.parsingbulan(date('m',strtotime($rujukan->response->rujukan->tglRencanaKunjungan))).' '.date('Y',strtotime($rujukan->response->rujukan->tglRencanaKunjungan)) ?> </td>
                <?php } ?>
                
                <td></td>
                <td width="18%" align="center"><br/><br/><br/></td>
                <td width="3%"></td>
                <td width="18%" align="center"><br/><br/><br/>____________________</td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:7pt;"> Tgl. Cetak : <?= date('Y-m-d h:i A') ?></td>
            </tr>
        </table>
    
   </div>

  </section>


</body>


</html>