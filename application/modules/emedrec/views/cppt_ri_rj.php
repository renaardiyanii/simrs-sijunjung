<?php
$result = array_chunk($cppt_iri, 1);
$json = isset($result[0]->konsul_dokter) ? json_decode($result[0]->konsul_dokter) : null;
$tot_page_cppt = 0;
foreach ($result as $item) {
  ($item[0]->form_cppt == 'RI') ? $tot_page_cppt = $tot_page_cppt + 1 : $tot_page_cppt = $tot_page_cppt + 2;
}
// var_dump($result);
// die();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Catatan Perkembangan Pasien Terintegrasi</title>
</head>
<style>
  #loading {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    /* opacity: 0.5; */
    background-color: white;
    z-index: 99;
    flex-direction: column;
  }

  #loading-image {
    z-index: 2200;
  }

  td,
  th {
    padding: 0.25em;
  }

  body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    background: #f1f1f1;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    /* text-align: center; */
    overflow: hidden;
  }

  #flipbook,
  .ipgs-flipbook {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
  }

  @media only screen and (max-width: 1024px) {}

  .ipgs-theme-default .ipgs-stage {
    background: url("<?php echo base_url('assets/flipbook/pattern-eq4r.png'); ?>") repeat;
  }
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jqueryui/jquery-ui.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/flipbook/ipage.min.css') ?>">
<script src="<?php echo base_url('assets/flipbook/jquery.ipage.min.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/flipbook/flipbook-custom.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/flipbook/flipbook-cover.css') ?>">


<body class="A4">
  <div class="preload" id="loading">
    <!-- <img id="loading-image" src="<?= base_url('assets/flipbook/ekamek.gif'); ?>"> -->
    <h2 style="text-align: center">
      <img src="<?= base_url('assets/flipbook/Book.gif'); ?>" style="vertical-align:middle">
      <span style="vertical-align:middle">Please Wait</span>
    </h2>
    <h3><span id="page-number">0</span> / <?= $tot_page_cppt + 2 ?> Pages</h3>
  </div>
  <script>
    const IntPageNumber = setInterval(function() {
      $('#page-number').text($('.padding-fix-10mm').length);
    }, 200);
  </script>
  <div id="flipbook">
    <div class="" style="background-image: linear-gradient(to right top, #1969a6, #0064ae, #005fb4, #0058ba, #0051be, #005ecc, #006cd9, #0079e6, #009cf8, #00bcfe, #00dafe, #5ff5fb); width: 100%; height: 100%;">
      <div class="cover-bg-blue">

        <div class="cover-logo">
          <img src="<?= base_url('assets/favicon-rsomh/apple-touch-icon.png'); ?>" alt="img" height="50px" width="50px" style="padding-right:15px;">
          <p>CPPT</p>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg">
          <defs>
            <pattern id="img" width="100%" height="100%" patternUnits="userSpaceOnUse" viewBox="-55 20 1550 1550">
              <image width="2000" height="1250" xlink:href="<?= base_url('assets/img/gedung.jpg'); ?>" class="pic" />
            </pattern>
          </defs>

          <g class="group--circle" transform="translate(90, -10) scale(1.1)">
            <circle class="cover-circle--border-two" r="264" cx="430" cy="220" />
            <circle class="cover-circle--border-two--wrap" r="264" cx="430" cy="220" />
            <circle class="cover-circle--border-one" r="200" cx="430" cy="220" />
            <circle class="cover-circle--border-one--wrap" r="200" cx="430" cy="220" />
            <circle class="circle--main" r="160" cx="430" cy="220" fill="url(#img)" />
          </g>
        </svg>

        <div class="cover-strategy">
          <h1>RSUD SIJUNJUNG</h1>
         
        </div>
      </div>
      <div class="cover-circles--top">
        <svg>
          <defs>
            <circle id="cover-circle-template" r="153" />
          </defs>
          <g class="group--thin-cover-circles--top" transform="translate(-75,195)">
            <use xlink:href="#cover-circle-template" />
            <use xlink:href="#cover-circle-template" transform="scale(1.09)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.18)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.27)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.36)" />
          </g>
        </svg>
      </div>
      <div class="cover-footer"></div>
      <div class="cover-contact">
        <h1 style="display: none;">CPPT</h1>
      </div>

      <div class="cover-summary">
        <div class="cover-item">
          <svg class="icon-user" viewBox="0 0 32 32" width="21" height="21">
            <path d="M18 22.082v-1.649c2.203-1.241 4-4.337 4-7.432 0-4.971 0-9-6-9s-6 4.029-6 9c0 3.096 1.797 6.191 4 7.432v1.649c-6.784 0.555-12 3.888-12 7.918h28c0-4.030-5.216-7.364-12-7.918z"></path>
          </svg>
          <h2><?php echo $data_pasien[0]->nama ?? ""; ?></h2>
          <h2>(<?php echo $data_pasien[0]->sex ?? ""; ?>)</h2>
        </div>
        <div class="cover-item">
          <svg class="icon-sphere" viewBox="0 0 32 32" width="21" height="21">
            <path d="M15 2c-8.284 0-15 6.716-15 15s6.716 15 15 15c8.284 0 15-6.716 15-15s-6.716-15-15-15zM23.487 22c0.268-1.264 0.437-2.606 0.492-4h3.983c-0.104 1.381-0.426 2.722-0.959 4h-3.516zM6.513 12c-0.268 1.264-0.437 2.606-0.492 4h-3.983c0.104-1.381 0.426-2.722 0.959-4h3.516zM21.439 12c0.3 1.28 0.481 2.62 0.54 4h-5.979v-4h5.439zM16 10v-5.854c0.456 0.133 0.908 0.355 1.351 0.668 0.831 0.586 1.625 1.488 2.298 2.609 0.465 0.775 0.867 1.638 1.203 2.578h-4.852zM10.351 7.422c0.673-1.121 1.467-2.023 2.298-2.609 0.443-0.313 0.895-0.535 1.351-0.668v5.854h-4.852c0.336-0.94 0.738-1.803 1.203-2.578zM14 12v4h-5.979c0.059-1.38 0.24-2.72 0.54-4h5.439zM2.997 22c-0.533-1.278-0.854-2.619-0.959-4h3.983c0.055 1.394 0.224 2.736 0.492 4h-3.516zM8.021 18h5.979v4h-5.439c-0.3-1.28-0.481-2.62-0.54-4zM14 24v5.854c-0.456-0.133-0.908-0.355-1.351-0.668-0.831-0.586-1.625-1.488-2.298-2.609-0.465-0.775-0.867-1.638-1.203-2.578h4.852zM19.649 26.578c-0.673 1.121-1.467 2.023-2.298 2.609-0.443 0.312-0.895 0.535-1.351 0.668v-5.854h4.852c-0.336 0.94-0.738 1.802-1.203 2.578zM16 22v-4h5.979c-0.059 1.38-0.24 2.72-0.54 4h-5.439zM23.98 16c-0.055-1.394-0.224-2.736-0.492-4h3.516c0.533 1.278 0.855 2.619 0.959 4h-3.983zM25.958 10h-2.997c-0.582-1.836-1.387-3.447-2.354-4.732 1.329 0.636 2.533 1.488 3.585 2.54 0.671 0.671 1.261 1.404 1.766 2.192zM5.808 7.808c1.052-1.052 2.256-1.904 3.585-2.54-0.967 1.285-1.771 2.896-2.354 4.732h-2.997c0.504-0.788 1.094-1.521 1.766-2.192zM4.042 24h2.997c0.583 1.836 1.387 3.447 2.354 4.732-1.329-0.636-2.533-1.488-3.585-2.54-0.671-0.671-1.261-1.404-1.766-2.192zM24.192 26.192c-1.052 1.052-2.256 1.904-3.585 2.54 0.967-1.285 1.771-2.896 2.354-4.732h2.997c-0.504 0.788-1.094 1.521-1.766 2.192z"></path>
          </svg>
          <h2><?php echo $data_pasien[0]->no_medrec ?? ""; ?></h2>
        </div>
        <div class="cover-item">
          <svg width="800px" height="800px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 1C4.77614 1 5 1.22386 5 1.5V2H10V1.5C10 1.22386 10.2239 1 10.5 1C10.7761 1 11 1.22386 11 1.5V2H12.5C13.3284 2 14 2.67157 14 3.5V12.5C14 13.3284 13.3284 14 12.5 14H2.5C1.67157 14 1 13.3284 1 12.5V3.5C1 2.67157 1.67157 2 2.5 2H4V1.5C4 1.22386 4.22386 1 4.5 1ZM10 3V3.5C10 3.77614 10.2239 4 10.5 4C10.7761 4 11 3.77614 11 3.5V3H12.5C12.7761 3 13 3.22386 13 3.5V5H2V3.5C2 3.22386 2.22386 3 2.5 3H4V3.5C4 3.77614 4.22386 4 4.5 4C4.77614 4 5 3.77614 5 3.5V3H10ZM2 6V12.5C2 12.7761 2.22386 13 2.5 13H12.5C12.7761 13 13 12.7761 13 12.5V6H2ZM7 7.5C7 7.22386 7.22386 7 7.5 7C7.77614 7 8 7.22386 8 7.5C8 7.77614 7.77614 8 7.5 8C7.22386 8 7 7.77614 7 7.5ZM9.5 7C9.22386 7 9 7.22386 9 7.5C9 7.77614 9.22386 8 9.5 8C9.77614 8 10 7.77614 10 7.5C10 7.22386 9.77614 7 9.5 7ZM11 7.5C11 7.22386 11.2239 7 11.5 7C11.7761 7 12 7.22386 12 7.5C12 7.77614 11.7761 8 11.5 8C11.2239 8 11 7.77614 11 7.5ZM11.5 9C11.2239 9 11 9.22386 11 9.5C11 9.77614 11.2239 10 11.5 10C11.7761 10 12 9.77614 12 9.5C12 9.22386 11.7761 9 11.5 9ZM9 9.5C9 9.22386 9.22386 9 9.5 9C9.77614 9 10 9.22386 10 9.5C10 9.77614 9.77614 10 9.5 10C9.22386 10 9 9.77614 9 9.5ZM7.5 9C7.22386 9 7 9.22386 7 9.5C7 9.77614 7.22386 10 7.5 10C7.77614 10 8 9.77614 8 9.5C8 9.22386 7.77614 9 7.5 9ZM5 9.5C5 9.22386 5.22386 9 5.5 9C5.77614 9 6 9.22386 6 9.5C6 9.77614 5.77614 10 5.5 10C5.22386 10 5 9.77614 5 9.5ZM3.5 9C3.22386 9 3 9.22386 3 9.5C3 9.77614 3.22386 10 3.5 10C3.77614 10 4 9.77614 4 9.5C4 9.22386 3.77614 9 3.5 9ZM3 11.5C3 11.2239 3.22386 11 3.5 11C3.77614 11 4 11.2239 4 11.5C4 11.7761 3.77614 12 3.5 12C3.22386 12 3 11.7761 3 11.5ZM5.5 11C5.22386 11 5 11.2239 5 11.5C5 11.7761 5.22386 12 5.5 12C5.77614 12 6 11.7761 6 11.5C6 11.2239 5.77614 11 5.5 11ZM7 11.5C7 11.2239 7.22386 11 7.5 11C7.77614 11 8 11.2239 8 11.5C8 11.7761 7.77614 12 7.5 12C7.22386 12 7 11.7761 7 11.5ZM9.5 11C9.22386 11 9 11.2239 9 11.5C9 11.7761 9.22386 12 9.5 12C9.77614 12 10 11.7761 10 11.5C10 11.2239 9.77614 11 9.5 11Z" fill="#fff" />
          </svg>
          <h2><?php echo date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir)) ?? ""; ?></h2>
        </div>
      </div>
    </div>
    <?php
    if ($result) {
      for ($i = 0; $i < count($result); $i++) {
        if ($result[$i][0]->form_cppt == 'RI') {
    ?>

          <div class="padding-fix-10mm" style="padding: 40px; ">
            <header>
              <?php
              ?>
              <script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
              <script>
                JsBarcode("#barcode", "Hi world!");
              </script>

              <br>
              <header style="margin-top:0px; font-size:1pt!important;">

                <table border="0" width="100%">
                  <tr>
                    <td width="10%">
                      <p align="center">
                        <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                      </p>
                    </td>
                    <td width="0%" align="left" style="font-size:18px;font-weight:bold;">
                      <p style="margin-top:20px">
                        <span>RSUD SIJUNJUNG</span><br>
                        <!-- <span> BUKITTINGGI</span><br> -->
                      </p>
                    </td>
                    <td width="45%">
                      <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px">
                        <?= isset($result[$i][0]->kode_document) ? $result[$i][0]->kode_document  : ""; ?>
                      </span>

                      <table class="table_nama" width="100%">
                        <tr>
                        </tr>
                        <?php
                        // foreach ($data_pasien as $row) {
                        ?>
                        <tr>
                          <td width="33%" style="font-size:12px"><span>Nama</span></td>
                          <td width="2%" style="font-size:12px"><span>:</span></td>
                          <td width="45%" style="font-size:12px" colspan="2"><span><?php echo $data_pasien[0]->nama ?? ""; ?></span></td>

                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>NIK</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_identitas ?? ""; ?></span></td>
                          <td style="font-size:12px"><span>(<?php echo $data_pasien[0]->sex ?? ""; ?>)</span></td>
                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>No. RM</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_cm ?? ""; ?></span></td>
                          <td style="font-size:12px" rowspan="2">
                            <span>
                              <svg class="barcode" jsbarcode-format="code128" jsbarcode-height="30" jsbarcode-width="1" jsbarcode-displayValue="false" jsbarcode-value="<?= $data_pasien[0]->no_cm ?? ""; ?>" jsbarcode-textmargin="0" jsbarcode-margin="0" jsbarcode-marginTop="5" jsbarcode-marginRight="5" jsbarcode-fontoptions="bold">
                              </svg>

                              <script>
                                JsBarcode(".barcode").init();
                              </script>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>Tgl Lahir</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir)) ?? ""; //substr($data_pasien[0]->tgl_lahir,0,10); 
                                                            ?></span></td>

                        </tr>
                        <?php
                        // }
                        ?>
                      </table>
                    </td>

                  </tr>

                </table>
              </header>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style="font-weight:bold; font-size: 13px; text-align: center;">
              <?= isset($result[$i][0]->form_title) ? $result[$i][0]->form_title  : ""; ?>
            </p>
            <div style="font-size:6px">
              <table id="data" border="1" cellspacing="0" cellpadding="0">
                <tr style="text-align: center;">
                  <td style="width: 10%;font-size:11px"><b>Tanggal / Jam</b></td>
                  <td style="width: 10%;font-size:11px"><b>PROFESI / BAGIAN</b></td>
                  <td style="width: 30%;font-size:11px">
                    <b>HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</b><br>
                    (Dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan paraf pada setiap akhir catatan)
                  </td>
                  <td style="width: 25%;font-size:11px">
                    <b>Instruksi Tenaga Kesehatan termasuk pasca Bedah/ Prosedur</b>
                    (Instruksi Ditulis dengan Rinci dan Jelas)
                  </td>
                  <td style="width: 25%;font-size:11px">
                    <b>VERIFIKASI DPJP
                      (Bubuhkan Stempel Nama, Paraf, Tgl, Jam)
                    </b>
                    (DPJP harus membaca seluruh rencana perawatan)
                  </td>
                </tr>
                <?php foreach ($result[$i] as $value) : ?>
                  <?php
                  $jsonValRI = json_decode($value->json_val);
                  // $kekuatan_otot = explode('@',$value->kekuatan_otot);
                  // if(count($kekuatan_otot) == 4){
                  $tangan_kiri = $jsonValRI->tangan_kiri_otot;
                  $tangan_kanan = $jsonValRI->tangan_kanan_otot;
                  $kaki_kiri = $jsonValRI->kaki_kiri_otot;
                  $kaki_kanan = $jsonValRI->kaki_kanan_otot;
                  // }
                  ?>
                  <tr>
                    <td>
                      <p style="font-size:11px;text-align:center"><?= isset($value->tanggal_pemeriksaan) ? date('d-m-Y H:i:s', strtotime($value->tanggal_pemeriksaan)) : ''; ?></p>
                    </td>
                    <td>
                      <p style="font-size:11px;text-align:center"><?= isset($jsonValRI->role) ? $jsonValRI->role : '' ?></p>
                    </td>
                    <td>

                      <table width="100%">
                        <tr height="20px">
                          <td width="10%" style="<?= ($jsonValRI->assesment_adime) ? "font-size:10px" : 'font-size:10px' ?>">
                            <p><?= ($jsonValRI->assesment_adime) ? 'A' : 'S' ?></p>
                          <td>
                          <td width="5%">
                            <p>:</p>
                          <td>
                          <td width="85%" style="<?= ($jsonValRI->assesment_adime) ? "font-size:10px" : 'font-size:10px' ?>">
                            <p><?= ($jsonValRI->assesment_adime) ? $jsonValRI->assesment_adime : chunk_split($jsonValRI->subjective, 40, "<br>") ?></p>
                          <td>
                        </tr>
                        <tr height="20px">
                          <td width="10%" style="<?= ($jsonValRI->diagnosa_adime) ? "font-size:10px" : 'font-size:10px' ?>"><?= ($jsonValRI->diagnosa_adime) ? 'D' : 'O' ?>
                          <td>
                          <td width="5%"> :
                          <td>
                          <td width="85%">
                            <pre style="<?= ($jsonValRI->diagnosa_adime) ? "font-size:10px; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;" : 'font-size:10px' ?>"><?= ($jsonValRI->diagnosa_adime) ? $jsonValRI->diagnosa_adime : chunk_split(str_replace('\n', '<br>', 'Pemerikaan Fisik :  \n' . $jsonValRI->objective), 40, "<br>") ?></pre>
                            <?php
                            if (isset($tangan_kanan) && isset($tangan_kiri) && isset($kaki_kanan) && isset($kaki_kiri)) {
                            ?>
                              <table width="10%">
                                <tr style="border-bottom:1px solid black">
                                  <td style="font-size:9pt;text-align:center;border-right:1px solid black;">
                                    <?= $tangan_kanan ?>
                                  </td>
                                  <td style="font-size:9pt;text-align:center;">
                                    <?= $tangan_kiri ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="font-size:9pt;text-align:center;border-right:1px solid black;">
                                    <?= $kaki_kanan ?>
                                  </td>
                                  <td style="font-size:9pt;text-align:center;">
                                    <?= $kaki_kiri ?>
                                  </td>
                                </tr>
                              </table>
                            <?php } ?>
                          <td>
                        </tr>
                        <tr height="20px">
                          <td width="10%" style="<?= ($jsonValRI->intervensi_adime) ? "font-size:10px" : 'font-size:10px' ?>">
                            <p><?= ($jsonValRI->intervensi_adime) ? 'I' : 'A' ?></p>
                          <td>
                          <td width="5%">
                            <p>:</p>
                          <td>
                          <td width="85%" style="<?= ($jsonValRI->intervensi_adime) ? "font-size:10px" : 'font-size:10px' ?>">
                            <p><?= ($jsonValRI->intervensi_adime) ? $jsonValRI->intervensi_adime : $jsonValRI->assesment ?></p>
                          <td>
                        </tr>
                        <tr height="20px">
                          <td width="10%" style="<?= ($jsonValRI->monitoring_adime) ? "font-size:10px" : 'font-size:10px' ?>"><?= ($jsonValRI->monitoring_adime) ? 'M' : 'P' ?>
                          <td>
                          <td width="5%">:
                          <td>
                          <td width="85%" style="<?= ($jsonValRI->monitoring_adime) ? "font-size:10px" : 'font-size:10px' ?>"><?= ($jsonValRI->monitoring_adime) ? $jsonValRI->monitoring_adime : $jsonValRI->plan ?>
                          <td>
                        </tr>
                        <tr height="20px">
                          <td width="10%" style="<?= ($jsonValRI->evaluasi_adime) ? "font-size:10px" : 'font-size:10px' ?>"><?= ($jsonValRI->evaluasi_adime) ? 'E' : '' ?>
                          <td>
                          <td width="5%"><?= ($jsonValRI->evaluasi_adime) ? ':' : '' ?>
                          <td>
                          <td width="85%" style="<?= ($jsonValRI->evaluasi_adime) ? "font-size:10px" : 'font-size:10px' ?>">
                            <?= ($jsonValRI->evaluasi_adime) ? $jsonValRI->evaluasi_adime : '' ?>
                            <?php echo isset($jsonValRI->ttd) ? '<img width="80" src="' . $jsonValRI->ttd . '" alt="">' : '<br>' ?>
                            <p><?= isset($jsonValRI->nama_pemeriksa) ? $jsonValRI->nama_pemeriksa : '' ?></p>
                            <?php
                            $json_konsultasi = isset($jsonValRI->konsul_dokter) ? $jsonValRI->konsul_dokter : null;
                            //var_dump($json_konsultasi[0]->konsultasi_dokter); die();
                            if ($json_konsultasi[0]) {
                              foreach ($json_konsultasi as $val) {
                            ?>
                                <table width="100%" border="1">
                                  <tr>
                                    <td colspan="2" style="text-align:center;font-size:9px;font-color:blue">KONFIRMASI</td>

                                  </tr>
                                  <tr>
                                    <td>
                                      <span style="font-size:9px">Tgl : <?= isset($value->tanggal_pemeriksaan) ? date('d/m/Y', strtotime($value->tanggal_pemeriksaan)) : '' ?></span><br>
                                      <span style="font-size:9px">Jam : <?= isset($value->tanggal_pemeriksaan) ? date('H:i', strtotime($value->tanggal_pemeriksaan)) : '' ?></span><br>
                                      <p style="font-size:9px;text-align:center;font-size:9px">Penerima Intruksi</p>
                                      <img width="30px" src="<?= isset($jsonValRI->ttd) ? $jsonValRI->ttd : '' ?>" alt="">

                                      <p style="font-size:9px;text-align:center"><?= isset($jsonValRI->nama_pemeriksa) ? $jsonValRI->nama_pemeriksa : '' ?></p>
                                    </td>
                                    <td width="50%">
                                      <span style="font-size:9px;">Tgl : <?= isset($val->Date) ? date('d/m/Y', strtotime($val->Date)) : '' ?></span><br>
                                      <span style="font-size:9px">Jam : <?= isset($val->Date) ? date('H:i', strtotime($val->Date)) : '' ?></span>
                                      <p style="font-size:9px;text-align:center">Pemberi Intruksi</p>
                                      <?php
                                      if (isset($val->respon_konsultasi)) {
                                        if ($val->respon_konsultasi == "ya") {
                                          if (isset($val->ttd_konsul)) {
                                      ?>
                                            <img width="30px" src="<?= $val->ttd_konsul ?>" alt="">
                                      <?php
                                          }
                                        }
                                      } ?>

                                      <p style="font-size:9px;text-align:center"><?= isset(explode('-', $val->konsultasi_dokter)[0]) ? explode('-', $val->konsultasi_dokter)[0] : null; ?></p>

                                    </td>

                                  </tr>

                                  <tr>
                                    <td colspan="2" style="font-size:10px;font-color:blue">
                                      Catatan Konsultasi :<br>
                                      <?= isset($val->cat_konsul) ? $val->cat_konsul : '' ?>
                                    </td>

                                  </tr>

                                </table>
                            <?php }
                            } ?>
                          <td>
                        </tr>
                      </table>



                    </td>
                    <td>
                      <p style="font-size:10px">
                        <?php echo $jsonValRI->instruksi ? str_replace([PHP_EOL, "\r", "\n"], '<br>', $jsonValRI->instruksi) : ''; ?>
                      </p>
                    </td>
                    <td>
                      <p style="font-size:10px">
                        <!-- disini dpjp -->
                        <span><?= ($jsonValRI->tgl_acc_pjp) ? date('d/m/Y , H:i:s', strtotime($jsonValRI->tgl_acc_pjp)) : '' ?></span><br><br>
                      </p>
                      <p style="text-align:center">
                        <?php echo ($jsonValRI->ttd_pjp) ? '<img width="120" src="' . $jsonValRI->ttd_pjp . '" alt="">' : '<br><br>' ?>
                      <p style="text-align:center;font-size:10px"><?= isset($jsonValRI->nama_pjp) ? $jsonValRI->nama_pjp : '' ?></p>


                      </p>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


            <!-- <p style="text-align:right;font-size:12px"></p> -->
            </br></br></br></br> </br></br></br></br></br></br></br>
          </div>
        <?php } else {
        ?>
          


          <div class="padding-fix-10mm" style="padding: 40px;">

            <header>
              <?php
              ?>
              <script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
              <script>
                JsBarcode("#barcode", "Hi world!");
              </script>

              <br>
              <header style="margin-top:0px; font-size:1pt!important;">

                <table border="0" width="100%">
                  <tr>
                    <td width="10%">
                      <p align="center">
                        <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                      </p>
                    </td>
                    <td width="0%" align="left" style="font-size:18px;font-weight:bold;">
                      <p style="margin-top:20px">
                        <span>RSUD SIJUNJUNG</span><br>
                        <!-- <span> BUKITTINGGI</span><br> -->
                      </p>
                    </td>
                    <td width="45%">
                      <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px">
                        <?= isset($result[$i][0]->kode_document) ? $result[$i][0]->kode_document  : ""; ?>
                      </span>

                      <table class="table_nama" width="100%">
                        <tr>
                        </tr>
                        <?php
                        // foreach ($data_pasien as $row) {
                        ?>
                        <tr>
                          <td width="33%" style="font-size:12px"><span>Nama</span></td>
                          <td width="2%" style="font-size:12px"><span>:</span></td>
                          <td width="45%" style="font-size:12px" colspan="2"><span><?php echo $data_pasien[0]->nama ?? ""; ?></span></td>

                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>NIK</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_identitas ?? ""; ?></span></td>
                          <td style="font-size:12px"><span>(<?php echo $data_pasien[0]->sex ?? ""; ?>)</span></td>
                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>No. RM</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_cm ?? ""; ?></span></td>
                          <td style="font-size:12px" rowspan="2">
                            <span>
                              <svg class="barcode" jsbarcode-format="code128" jsbarcode-height="30" jsbarcode-width="1" jsbarcode-displayValue="false" jsbarcode-value="<?= $data_pasien[0]->no_cm ?? ""; ?>" jsbarcode-textmargin="0" jsbarcode-margin="0" jsbarcode-marginTop="5" jsbarcode-marginRight="5" jsbarcode-fontoptions="bold">
                              </svg>

                              <script>
                                JsBarcode(".barcode").init();
                              </script>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td style="font-size:12px"><span>Tgl Lahir</span></td>
                          <td style="font-size:12px"><span>:</span></td>
                          <td style="font-size:12px"><span><?php echo date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir)) ?? ""; //substr($data_pasien[0]->tgl_lahir,0,10); 
                                                            ?></span></td>

                        </tr>
                        <?php
                        // }
                        ?>
                      </table>
                    </td>

                  </tr>

                </table>
              </header>
            </header>
            <hr color="black">

            <p align="center" class="text_isi" style="font-weight:bold;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI RAWAT JALAN</p>
            <!-- ======================================DOKTER==================================================================== -->
            <p style="font-weight:bold;">DOKTER</p>
            <table border="1" width="100%">
              <tr>
                <td width="15%">
                  <center><span class="text_body">Tanggal/Jam</span></center>
                </td>
                <td width="65%">
                  <center>
                    <p><span class="text_isi">HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</span></p>
                    <span class="text_body">(dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan parah pada setiap akhir catatan)</span>
                  </center>
                </td>
                <td width="20%">
                  <center><span class="text_body">Nama Jelas Petugas dan Tanda Tangan</span></center>
                </td>
              </tr>
              <?php foreach ($result[$i] as $value) :
                $jsonValRJ_d = json_decode($value->json_val);
              ?>

                <tr>
                  <td>
                    <table width="100%">
                      <tr>
                        <td><span class="text_body"><?= isset($jsonValRJ_d->waktu_masuk_dokter) ? date("Y-m-d", strtotime($jsonValRJ_d->waktu_masuk_dokter)) : '-'; ?></span></td>
                      </tr>
                      <tr>
                        <td><span class="text_body"><?= ($jsonValRJ_d->waktu_masuk_dokter) ? date("H:i", strtotime($jsonValRJ_d->waktu_masuk_dokter)) . ' wib' : '-'; ?></span></td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table border="1" width="100%">
                      <tr>
                        <td width=5%><span class="text_body soap"> S.</span></td>
                        <td><?php
                            if ($jsonValRJ_d->subjective_dokter != "" || $jsonValRJ_d->subjective_dokter != null) {
                              echo str_replace('-', '<br>', $jsonValRJ_d->subjective_dokter);
                            } else {
                              if ($jsonValRJ_d->subjective_perawat != null || $jsonValRJ_d->subjective_perawat != "") {
                                echo str_replace('-', '<br>', $jsonValRJ_d->subjective_perawat);
                              }
                            }
                            ?></td>
                      </tr>
                      <tr>
                        <td width=5%><span class="text_body soap">O.</span></td>
                        <td>
                          <?php
                          if ($jsonValRJ_d->objective_dokter != null || $jsonValRJ_d->objective_dokter != "") {
                            echo str_replace('-', '<br>', $jsonValRJ_d->objective_dokter);
                          } else {
                            if ($jsonValRJ_d->objective_perawat != null || $jsonValRJ_d->objective_perawat != "") {
                              echo str_replace('-', '<br>', $jsonValRJ_d->objective_perawat);
                            }
                          }
                          ?></td>
                      </tr>
                      <tr>
                        <td width=5%><span class="text_body soap">A.</span></td>
                        <td><?= isset($jsonValRJ_d->assesment_dokter) && $jsonValRJ_d->assesment_dokter != "" ? $jsonValRJ_d->assesment_dokter : '-'; ?></td>
                      </tr>
                      <tr>
                        <td width=5%><span class="text_body soap">P.</span></td>
                        <td><?= isset($jsonValRJ_d->plan_dokter) ? $jsonValRJ_d->plan_dokter : '-'; ?></td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table border="0">
                      <tr>
                        <td style="text-align:center;">
                          <?php if (isset($jsonValRJ_d->ttd_dokter)) { ?>
                            <img width="120px" src="<?= $jsonValRJ_d->ttd_dokter; ?>" alt="">
                          <?php } else {
                            echo '<br><br><br>';
                          } ?>
                        </td>
                      </tr>
                      <tr>
                        <td style="text-align:center;"><span class="text_isi">(<?= isset($jsonValRJ_d->nama_dokter) ? $jsonValRJ_d->nama_dokter : ''; ?>)</span></td>
                      </tr>
                      <tr>
                        <td><span class="text_isi">SIP. <?= isset($jsonValRJ_d->sip_dokter) ? $jsonValRJ_d->sip_dokter : ''; ?></span></td>
                      </tr>

                    </table>
                  </td>
                </tr>
              <?php endforeach; ?>
            </table><!-- BORDER LUAR -->

            <footer>
            </footer>
          </div>
      <?php }
      }
    } else { ?>
      <div class="padding-fix-10mm" style="padding: 40px;">
        <header>
          <script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
          <script>
            // By using querySelector
            JsBarcode("#barcode", "Hi world!");
          </script>
          <?php
          // var_dump($kode_document);
          ?>
          <br>
          <header style="margin-top:0px; font-size:1pt!important;">

            <table border="0" width="100%">
              <tr>
                <td width="10%">
                  <p align="center">
                    <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                  </p>
                </td>
                <td width="0%" align="left" style="font-size:18px;font-weight:bold;">
                  <p style="margin-top:20px">
                    <span>RSUD SIJUNJUNG</span><br>
                    <!-- <span> BUKITTINGGI</span><br> -->
                  </p>
                </td>
                <td width="45%">
                  <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px"></span>


                </td>

              </tr>

            </table>
          </header>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
          CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
        </p>
        <div style="font-size:11px">
          <table id="data" border="1" cellspacing="0" cellpadding="0">
            <tr style="text-align: center;">
              <td style="width: 10%;font-size:11px"><b>Tanggal / Jam</b></td>
              <td style="width: 10%;font-size:11px"><b>PROFESI / BAGIAN</b></td>
              <td style="width: 30%;font-size:11px">
                <b>HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</b><br>
                (Dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan paraf pada setiap akhir catatan)
              </td>
              <td style="width: 25%;font-size:11px">
                <b>Instruksi Tenaga Kesehatan termasuk pasca Bedah/ Prosedur</b>
                (Instruksi Ditulis dengan Rinci dan Jelas)
              </td>
              <td style="width: 25%;font-size:11px">
                <b>VERIFIKASI DPJP
                  (Bubuhkan Stempel Nama, Paraf, Tgl, Jam)
                </b>
                (DPJP harus membaca seluruh rencana perawatan)
              </td>
            </tr>
            <?php //foreach($result[$i] as $value): 
            ?>
            <tr>
              <td>
                <p style="font-size:11px;text-align:center">-</p>
              </td>
              <td>
                <p style="font-size:11px;text-align:center">-</p>
              </td>
              <td>

                <table width="100%">
                  <?php //if() 
                  ?>
                  <tr height="20px">
                    <td width="10%">
                      <p>S</p>
                    <td>
                    <td width="5%">
                      <p>:</p>
                    <td>
                    <td width="85%">
                      <p>-</p>
                    <td>
                  </tr>
                  <tr height="20px">
                    <td width="10%">
                      <p>O</p>
                    <td>
                    <td width="5%">
                      <p>:</p>
                    <td>
                    <td width="85%">
                      <p>-</p>
                    <td>
                  </tr>
                  <tr height="20px">
                    <td width="10%">
                      <p>A</p>
                    <td>
                    <td width="5%">
                      <p>:</p>
                    <td>
                    <td width="85%">
                      <p>-</p>
                    <td>
                  </tr>
                  <tr height="20px">
                    <td width="10%">
                      <p>P</p>
                    <td>
                    <td width="5%">
                      <p>:</p>
                    <td>
                    <td width="85%">
                      <p>-</p>
                    <td>
                  </tr>
                </table>



              </td>
              <td>
                <p>

                </p>
              </td>
              <td>
                <p>
                  <span>Bukittinggi,.........</span><br><br>
                <p style="text-align:center">
                  <br><br>
                <p style="text-align:center">-</p>
                </p>
              </td>
            </tr>
            <?php //endforeach; 
            ?>
          </table>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br>


        <p style="text-align:right;font-size:12px">1</p>
        </br></br></br></br> </br></br></br></br></br></br></br>
      </div>
    <?php } ?>
    <div class="padding-fix-10mm" style="background-image: linear-gradient(to left top, #1969a6, #0064ae, #005fb4, #0058ba, #0051be, #0051be, #0052be, #0052be, #0059ba, #005fb4, #0065ac, #0d69a4); background-size: cover; width: 100%; height: 100%;">
      <div class="cover-circles--top">
        <svg>
          <defs>
            <circle id="cover-circle-template" r="153" />
          </defs>
          <g class="group--thin-cover-circles--top" transform="translate(-75,195)">
            <use xlink:href="#cover-circle-template" />
            <use xlink:href="#cover-circle-template" transform="scale(1.09)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.18)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.27)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.36)" />
          </g>
        </svg>
      </div>

      <div class="cover-circles">
        <svg height="100%" width="100%">
          <g class="group--thin-circles" transform="translate(227.5,220)">
            <use xlink:href="#cover-circle-template" />
            <use xlink:href="#cover-circle-template" transform="scale(1.09)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.18)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.27)" />
            <use xlink:href="#cover-circle-template" transform="scale(1.36)" />
          </g>
        </svg>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(window).on('load', function() {
      $('#loading').hide();
      $('.cover-contact h1').css('display', 'block');
    });
    $(document).ready(function() {
      clearInterval(IntPageNumber);
      if (($('.padding-fix-10mm').length) % 2 == 0) {
        $('#flipbook .padding-fix-10mm:last').before('<div class="padding-fix-10mm"></div>');
      }
      var options = {
        bookEngine: 'TwoPageFlip',

        containerHeight: '100%',
        padding: {
          top: 30,
          right: 10,
          bottom: 80,
          left: 10
        },
        autoFit: true,
        pageWidth: 800,
        pageHeight: 1050,
        pageStart: 1,
        pageNumbersHidden: [1, -1],
        dblClickZoomDefault: true,
        flipDuration: 600,
        toolbarControls: [{
            type: 'share',
            active: false
          },
          {
            type: 'outline',
            active: false
          },
          {
            type: 'thumbnails',
            active: false
          },
          {
            type: 'gotofirst',
            active: true
          },
          {
            type: 'prev',
            active: true
          },
          {
            type: 'pagenumber',
            active: true
          },
          {
            type: 'next',
            active: true
          },
          {
            type: 'gotolast',
            active: true
          },
          {
            type: 'zoom-in',
            active: true
          },
          {
            type: 'zoom-out',
            active: true
          },
          {
            type: 'zoom-default',
            active: true
          },
          {
            type: 'optional',
            active: true
          },
          {
            type: 'download',
            active: false
          },
          {
            type: 'fullscreen',
            active: true,
            optional: false
          },
          {
            type: 'sound',
            active: false,
          },
          {
            type: 'download',
            active: false,
          }
        ]
      };

      $('#flipbook').ipages(options);
    });
  </script>
</body>

</html>