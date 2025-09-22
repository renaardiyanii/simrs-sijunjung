<?php 

function parsingbulan($bulan){
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
    <title>SURAT RUJUKAN BALIK ( PRB )</title>
    <style>
    @page { size: letter landscape  }
    *{
        font-size: 11pt;
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
<body class="letter landscape">
  <section class="sheet padding-10mm">

   <div class="header" style="display:flex;justify-content:space-between">
        <div style="display:flex">

          <img src="<?= base_url('assets/img/logo_bpjs.png') ?>" width="200" alt="">
          <div class="header-judul" >
            <span style="font-size:11pt;">SURAT RUJUKAN BALIK (PRB)<br><?= $prb->response->prb->peserta->asalFaskes->nama ?></span>
          </div>
        </div>
        <div class="header-judul">
          <span style="font-size:11pt;">No. SRB <?= $prb->response->prb->noSRB ?></span><br>
          <span style="font-size:11pt;">Tanggal <?= date('d',strtotime($prb->response->prb->tglSRB)).' '.parsingbulan(date('m',strtotime($prb->response->prb->tglSRB))).' '.date('Y',strtotime($prb->response->prb->tglSRB)) ?></span>
        </div>
   </div>
   <div class="content">
        <table  width="100%" style="margin-left:15px;">
            <tr>
                <td width="11%" style="font-weight:bold;">Kepada Yth</td>
                <td>:</td>
                <td width="45%" style="font-weight:bold;font-size:11pt;"></td>
                <td width="10%"></td>
                <td></td>
                <td width="30%"></td>
            </tr>
            <tr>
                <td width="11%" style="font-weight:bold;"></td>
                <td></td>
                <td width="45%" style="font-weight:bold;font-size:11pt;"></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[0])?'R/.':'' ?></td>
            </tr>
            
            <tr>
                <td colspan="3" >Mohon Pemeriksaan dan Penanganan Lebih Lanjut</td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[0])?'1. '.$prb->response->prb->obat->obat[0]->signa1.'x'.$prb->response->prb->obat->obat[0]->signa2.' '.$prb->response->prb->obat->obat[0]->nmObat:'' ?></td>
            </tr>
            <tr>
                <td >No. Kartu</td>
                <td>:</td>
                <td ><?= $prb->response->prb->peserta->noKartu ?></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[1])?'2. '.$prb->response->prb->obat->obat[1]->signa1.'x'.$prb->response->prb->obat->obat[1]->signa2.' '.$prb->response->prb->obat->obat[1]->nmObat:'' ?></td>
                
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td>:</td>
                <td><?= $prb->response->prb->peserta->nama ?>&nbsp;&nbsp;&nbsp;(<?= $prb->response->prb->peserta->kelamin ?>)</td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[2])?'3. '.$prb->response->prb->obat->obat[2]->signa1.'x'.$prb->response->prb->obat->obat[2]->signa2.' '.$prb->response->prb->obat->obat[2]->nmObat:'' ?></td>
           
            </tr>
            <tr>
                <td >Tgl. Lahir</td>
                <td>:</td>
                <td ><?= $prb->response->prb->peserta->tglLahir ?></td>
           
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[3])?'4. '.$prb->response->prb->obat->obat[3]->signa1.'x'.$prb->response->prb->obat->obat[3]->signa2.' '.$prb->response->prb->obat->obat[3]->nmObat:'' ?></td>
            </tr>
            <tr>
                <td >Diagnosa</td>
                <td>:</td>
                <td ><?= '' ?></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[4])?'5. '.$prb->response->prb->obat->obat[4]->signa1.'x'.$prb->response->prb->obat->obat[4]->signa2.' '.$prb->response->prb->obat->obat[4]->nmObat:'' ?></td>
            </tr>
            <tr>
                <td>Program PRB</td>
                <td>:</td>
                <td><?= $prb->response->prb->programPRB->nama ?></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[5])?'6.'.$prb->response->prb->obat->obat[5]->signa1.'x'.$prb->response->prb->obat->obat[5]->signa2.' '.$prb->response->prb->obat->obat[5]->nmObat:'' ?></td>

            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?= $prb->response->prb->keterangan ?></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[6])?'7.'.$prb->response->prb->obat->obat[6]->signa1.'x'.$prb->response->prb->obat->obat[6]->signa2.' '.$prb->response->prb->obat->obat[6]->nmObat:'' ?></td>

            </tr>
            <tr>
                <td colspan="3">
                Saran Pengelolaan lanjutan di FKTP:
                </td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[7])?'8.'.$prb->response->prb->obat->obat[7]->signa1.'x'.$prb->response->prb->obat->obat[7]->signa2.' '.$prb->response->prb->obat->obat[7]->nmObat:'' ?></td>

            </tr>
            <tr>
                <td>CATATAN</td>
                <td></td>
                <td></td>
                <td colspan="3"><?= isset($prb->response->prb->obat->obat[8])?'9.'.$prb->response->prb->obat->obat[8]->signa1.'x'.$prb->response->prb->obat->obat[8]->signa2.' '.$prb->response->prb->obat->obat[8]->nmObat:'' ?></td>
            </tr>
            <?php
            // lebih dari 10;
            if(count($prb->response->prb->obat->obat)>8):
                foreach($prb->response->prb->obat->obat as $index=>$obat):
                    if($index>8):
                        $nomor = $index+1;
                        if($index == 10){
                            echo '
                                <tr>
                                    <td colspan="3">Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
                                    <td colspan="3">'.strval($nomor).'. '.$index.$prb->response->prb->obat->obat[$index]->signa1.'x'.$prb->response->prb->obat->obat[$index]->signa2.' '.$prb->response->prb->obat->obat[$index]->nmObat .'</td>
                                </tr>
                        ';
                        }
                        else if($index == 11){
                            echo '
                                <tr>
                                    <td colspan="3">Tgl. Cetak : '.date('Y-m-d h:i A').'</td>
                                    <td colspan="3">'.strval($nomor).'. '.$index.$prb->response->prb->obat->obat[$index]->signa1.'x'.$prb->response->prb->obat->obat[$index]->signa2.' '.$prb->response->prb->obat->obat[$index]->nmObat .'</td>
                                </tr>
                            ';
                        }
                        else{
                ?>
                        
                    <tr>
                        <td colspan="3" ></td>
                        <td colspan="3"> <?= strval($nomor).'. '.$index.$prb->response->prb->obat->obat[$index]->signa1.'x'.$prb->response->prb->obat->obat[$index]->signa2.' '.$prb->response->prb->obat->obat[$index]->nmObat ?></td>
                    </tr>
            <?php 
                        }
                    
                    endif;
                endforeach;
            endif; ?>
            <tr>
                <td colspan="3"><?= count($prb->response->prb->obat->obat)>8?'':'Demikian atas bantuannya, diucapkan banyak terima kasih.' ?></td>
                <td width="18%" align="center"></td>
                <td width="3%"></td>
                <td width="18%" align="center"><?= count($prb->response->prb->obat->obat)>8?'<br>Mengetahui,':'Mengetahui,' ?></td>
            </tr>
            <tr>
                <td colspan="3"><?= count($prb->response->prb->obat->obat)>8?'':'Tgl. Cetak : '.date('Y-m-d h:i A') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td width="18%" align="center"></td>
                <td width="3%"></td>
                <td width="18%" align="center">____________</td>
            </tr>
        </table>
    
   </div>

  </section>


</body>


</html>