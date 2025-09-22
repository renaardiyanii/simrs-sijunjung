<style type="text/css">
table tr td {
    font-size: 14px;
}

.table-font-size1 {
    font-size: 8px;
}
</style>

<p style="font-size: 12px" size="6" align="right"></p>
<br />
<table style="width: 100%" border="0">
    <tr>
        <td width="13%">
            <p align="center">
                <img src="<?= base_url() ?>assets/img/kementriankesehatan.png" alt="img" height="60"
                    style="padding-right: 5px" />
            </p>
        </td>
        <td width="74%" style="font-size: 9px" align="center">
            <font style="font-size: 12px">
                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br />
            </font>
            <font style="font-size: 11px">
                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br />
                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
            </font>
            <br />
            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile
                (0752) 23431</label><br />
            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website :
                www.rsstrokebkt.com</label>
        </td>
        <td width="13%">
            <p align="center">
                <img src="<?= base_url() ?>assets/img/logo.png" alt="img" height="60" style="padding-right: 5px" />
            </p>
        </td>
    </tr>
</table>
<hr />

<table style="width: 100%" width="100%">
    <tr>
        <td colspan="6" style="">
            <p size="11">
                <u><b>RINCIAN BIAYA RAWAT INAP</b></u>
            </p>
        </td>
    </tr>
    <tr>
        <td width="17%"><b>Sudah Terima Dari</b></td>
        <td width="2%">:</td>
        <td width="37%"><?= $terimadari==null?$namapasien:$terimadari; ?></td>
        <td width="20%"><b>Tanggal Masuk</b></td>
        <td width="2%">:</td>
        <td>21-11-2023</td>
    </tr>
    <tr>
        <td><b>Nama Pasien</b></td>
        <td>:</td>
        <td><?= $namapasien ?></td>
        <td><b>No Medrec / No Register</b></td>
        <td>:</td>
        <td><?= $nomedrec_register ?></td>
    </tr>
    <tr>
        <td><b>Umur</b></td>
        <td>:</td>
        <td>
            <?= $umur ?>
            Thn
        </td>

        <td><b>Gol. Pasien</b></td>
        <td>:</td>
        <td><?= $carabayar ?></td>
    </tr>
    <tr>
        <td><b>Alamat</b></td>
        <td>:</td>
        <td><?= $alamat ?></td>
        <td><b>Tanggal Keluar</b></td>
        <td>:</td>
        <td><?= $tglkeluar??'-' ?></td>
    </tr>
    <tr></tr>
</table>
<style type="text/css">
.table-isi th {
    border-bottom: 1px solid #ddd;
}

.table-isi td {
    border-bottom: 1px solid #ddd;
}
</style>
<br />
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Visite Dan Konsul</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td align="left" colspan="3">Tindakan</td>
        <td align="left">Pelaksana</td>
        <td align="center">Tgl layanan</td>
        <td align="right">Total</td>
    </tr>
    <?php
  $totalVisite = 0;
  $subtotal = 0;
    foreach($visitedankonsul['igd'] as $r):
      $subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'], 0);
  ?>
    <tr>
        <td align="left" colspan="3"><?= $r['nmtindakan'] ?></td>
        <td align="left"><?= $r['nm_dokter']?></td>
        <td align="center"><?= date("d-m-Y", strtotime($r['tgl_kunjungan']))?></td>
        <td align="right"><?= number_format($r['vtot'], 0) ?></td>
    </tr>
    <?php endforeach;$totalVisite += $subtotal; ?>
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Total</td>
        <td align="right"><?php echo number_format($subtotal, 0); ?></td>
    </tr>
</table>
<br>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>

<?php 
$konten = "";

//if(($list_tindakan_pasien[0]['carabayar'] == 'UMUM' || $list_tindakan_pasien[0]['carabayar'] == 'BPJS') && ($list_tindakan_pasien[0]['titip'] == NULL)) {
$konten = $konten . '
<table class="table-isi" border="0" style="width: 100%;" width="100%">
<tr style="font-weight:bold;">
     <td width="20%" align="left">Konsul/Visite</td>
     <td width="35%">Dokter</td>
     <td width="25%">Ruang</td>
     <td width="10%">Qty</td>
     <td width="10%" align="right">Total</td>
</tr>
';
$subtotal = 0;
$subtotal_alkes = 0;
//foreach($list_dokter as $d){	
$subtotalinner = 0;
$subtotal_alkesinner = 0;
foreach ($visitedankonsul['rawatinap'] as $r) {
  //if($d['idoprtr']==$r['idoprtr']){
  $subtotal += $r->total;
  $konten = $konten . "
      <tr>
      <td align=\"left\">" . $r->nmtindakan . "</td>
      <td>" . $r->name . "</td>
      <td>" . $r->nmruang . "</td>
      <td>" . $r->qty . "</td>
      <td align=\"right\">" . number_format($r->total) . "</td>
      </tr>					
      ";
  //}

}
$konten = $konten . '
  <tr style="font-weight:bold;">
    <td colspan="4" align="left">Subtotal</td>
    <td align="right">' . number_format($subtotal, 0) . '</td>
  </tr>
  ';
$konten = $konten . "</table><br>";
echo $konten;
$totalVisite+=$subtotal;
?>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Visite & Konsul IGD & Rawat Inap</th>
        <th align="right">Rp. <?= number_format($totalVisite) ?></th>
    </tr>
</table>
<br>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Laboratorium</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;">
    <tr style="font-weight:bold;">
        <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
        <td align="center" width="10%">Qty</td>
        <td align="right" width="10%">Total</td>
    </tr>
    <?php
  $totalLabor = 0;
  $subtotal = 0;
    foreach($tindakanlaboratorium['igd'] as $r):
      $subtotal = $subtotal + $r['vtot'];
  ?>
    <tr>
        <td colspan="3"><?= $r['jenis_tindakan'] ?></td>
        <td align="center"><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr style="font-weight:bold;">
        <td colspan="4" align="left">Total</td>
        <td align="right"><?php echo number_format($subtotal); $totalLabor += $subtotal; ?></td>
    </tr>
</table>
<br>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;">
    <tr style="font-weight:bold;">
        <td colspan="3" width="35%">Jenis Tind Laboratorium</td>
        <td align="center" width="10%">Qty</td>
        <td align="right" width="10%">Total</td>
    </tr>
    <?php
  $subtotal = 0;
    foreach($tindakanlaboratorium['rawatinap'] as $r):
      $subtotal = $subtotal + $r['vtot'];
  ?>
    <tr>
        <td colspan="3"><?= $r['jenis_tindakan'] ?></td>
        <td align="center"><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr style="font-weight:bold;">
        <td colspan="4" align="left">Total</td>
        <td align="right"><?php echo number_format($subtotal); $totalLabor += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Laboratorium IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalLabor); ?></th>
    </tr>
</table>
<br>


<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Radiologi</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Jenis Tind Radiologi</td>
        <td colspan="5" align="center">Dokter</td>
        <td colspan="4" align="right">Total</td>
    </tr>
    <?php 
  $totalRadiologi = 0;
  $subtotal = 0;
  foreach($tindakanradiologi['igd'] as $r):
    $subtotal = $subtotal + ($r['biaya_rad'] * $r['qty']);
?>
    <tr>
        <td colspan="5" align="left"><?= $r['jenis_tindakan'] ?></td>
        <td colspan="5" align="center"><?= $r['nm_dokter'] ?></td>
        <td colspan="4" align="right"><?= number_format(strval(intval($r['biaya_rad'] * $r['qty']))) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="13" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalRadiologi+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Jenis Tind Radiologi</td>
        <td colspan="5" align="center">Dokter</td>
        <td colspan="4" align="right">Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($tindakanradiologi['rawatinap'] as $r):
    $subtotal = $subtotal + ($r['biaya_rad'] * $r['qty']);
?>
    <tr>
        <td colspan="5" align="left"><?= $r['jenis_tindakan'] ?></td>
        <td colspan="5" align="center"><?= $r['nm_dokter'] ?></td>
        <td colspan="4" align="right"><?= number_format(strval(intval($r['biaya_rad'] * $r['qty']))) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="13" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalRadiologi+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Radiologi IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalRadiologi); ?></th>
    </tr>
</table>
<br>

<!-- Rehab Medik -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Rehab Medik</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Pelaksana</td>
        <td>Tgl Layanan</td>
        <td>Biaya Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalRehab = 0;
  $subtotal = 0;
  foreach($tindakanrehabmedik['igd'] as $r):
    $subtotal = $subtotal + $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['nm_dokter'] ?></td>
        <td><?= date('Y-m-d',strtotime($r['tgl_kunjungan'])) ?></td>
        <td><?= number_format($r['biaya_tindakan'],0) ?></td>
        <td><?= $r['qtyind'] ?></td>
        <td align="right"><?= number_format($r['vtot'],0) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalRehab+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Pelaksana</td>
        <td>Tgl Layanan</td>
        <td>Biaya Tindakan</td>
        <td>Qty</td>
        <td>Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($tindakanrehabmedik['rawatinap'] as $r):
    $subtotal = $subtotal + ($r['tumuminap'] * $r['qtyyanri']);
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['pelaksana'] ?></td>
        <td><?= date('Y-m-d',strtotime($r['tgl_layanan'])) ?></td>
        <td><?= number_format($r['tumuminap'],0) ?></td>
        <td><?= $r['qtyyanri'] ?></td>
        <td><?= number_format(($r['tumuminap'] * $r['qtyyanri']),0) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalRehab+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Rehab Medik IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalRehab); ?></th>
    </tr>
</table>
<br>
<br>
<br>
<!-- End Rehab Medik -->

<!-- Akomodasi -->

<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Akomodasi</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td align="left" colspan="3">Tindakan</td>
        <td align="left">Pelaksana</td>
        <td align="center">Tgl layanan</td>
        <td align="right">Total</td>
    </tr>

</table>
<br>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>

<?php 
$konten = "";
$totalAkomodasi = 0;
$ipdibu = $this->rimpasien->get_ipd_ibu($no_ipd)->row()->ipdibu;
$status_paket = 0;
$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd); //data kosong


if (($data_paket)) {
  $status_paket = 1;
}

if (($carabayar == 'UMUM') && ($titip == NULL)) {
  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
      <td align="left" colspan="3" width="25%">Ruangan</td>
      <td align="center" width="15%">Kelas</td>
      <td align="center" width="15%">Tgl Masuk</td>
      <td align="center" width="15%">Tgl Keluar</td>
      <td align="center" width="15%">Lama Inap</td>
      <td align="right" width="15%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($ipdibu != NULL) {
          $total_per_kamar = ($r['total_tarif'] / 2) * $diff;
        } else {
          $total_per_kamar = $r['total_tarif'] * $diff;
        }
      }

      $subtotal = $subtotal + $total_per_kamar;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_per_kamar) . "</td>
    </tr>
    ";
    }
  }
} else if ($carabayar == 'BPJS' && $titip == NULL) {

  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
      <td align="left" colspan="3" width="25%">Ruangan</td>
      <td align="center" width="15%">Kelas</td>
      <td align="center" width="15%">Tgl Masuk</td>
      <td align="center" width="15%">Tgl Keluar</td>
      <td align="center" width="15%">Lama Inap</td>
      <td align="right" width="15%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($tgl_masuk >= '2023-04-06') {
          if ($ipdibu != NULL) {
            $total_per_kamar = ($r['tarif_bpjs'] / 2) * $diff;
          } else {
            $total_per_kamar = $r['tarif_bpjs'] * $diff;
          }
        } else if ($tgl_masuk < '2023-04-06') {
          if ($ipdibu != NULL) {
            $total_per_kamar = ($r['total_tarif'] / 2) * $diff;
          } else {
            $total_per_kamar = $r['total_tarif'] * $diff;
          }
        }
      }

      $subtotal = $subtotal + $total_per_kamar;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_per_kamar) . "</td>
    </tr>
    ";
    }
  }
} else if (($carabayar == 'KERJASAMA') && ($titip == NULL)) {
  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
      <td align="left" width="25%">Ruangan</td>
      <td align="center" width="5%">Kelas</td>
      <td align="center" width="15%">Tgl Masuk</td>
      <td align="center" width="15%">Tgl Keluar</td>
      <td align="center" width="10%">Lama Inap</td>
      <td align="center" width="10%">Total Kelas</td>
      <td align="center" width="10%">Total Jatah</td>
      <td align="right" width="10%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $total = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($ipdibu != NULL) {
          $total_per_kamar = ($r['tarif_iks'] / 2) * $diff;
          $total_jatah = ($r['tarif_jatah_iks'] / 2) * $diff;
        } else {
          $total_per_kamar = $r['tarif_iks'] * $diff;
          $total_jatah = $r['tarif_jatah_iks'] * $diff;
        }

        if (($r['tarif_iks'] > $r['tarif_jatah_iks']) || ($r['tarif_iks'] == $r['tarif_jatah_iks'])) {
          $total = $total + ($total_per_kamar - $total_jatah);
        } else if ($r['tarif_iks'] < $r['tarif_jatah_iks']) {
          $total = $total + (0);
        }
      }

      $subtotal = $subtotal + $total;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\">" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_per_kamar) . "</td>
      <td align=\"right\"> " . number_format($total_jatah) . "</td>
      <td align=\"right\"> " . number_format($total) . "</td>
    </tr>
    ";
    }
  }
} else if (($carabayar == 'UMUM') && ($titip == '1')) {
  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
    <td align="left" colspan="3" width="25%">Ruangan</td>
    <td align="center" width="15%">Kelas</td>
    <td align="center" width="15%">Tgl Masuk</td>
    <td align="center" width="15%">Tgl Keluar</td>
    <td align="center" width="15%">Lama Inap</td>
    <td align="right" width="15%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $total = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($ipdibu != NULL) {
          $total_jatah = ($r['tarif_jatah'] / 2) * $diff;
        } else {
          $total_jatah = $r['tarif_jatah'] * $diff;
        }
      }

      $subtotal = $subtotal + $total_jatah;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_jatah) . "</td>
    </tr>
    ";
    }
  }
} else if ($carabayar == 'BPJS' && $titip == '1') {
  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
    <td align="left" colspan="3" width="25%">Ruangan</td>
    <td align="center" width="15%">Kelas</td>
    <td align="center" width="15%">Tgl Masuk</td>
    <td align="center" width="15%">Tgl Keluar</td>
    <td align="center" width="15%">Lama Inap</td>
    <td align="right" width="15%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $total = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($tgl_masuk >= '2023-04-06') {
          if ($ipdibu != NULL) {
            $total_jatah = ($r['tarif_jatah_bpjs'] / 2) * $diff;
          } else {
            $total_jatah = $r['tarif_jatah_bpjs'] * $diff;
          }
        } else if ($tgl_masuk < '2023-04-06') {
          if ($ipdibu != NULL) {
            $total_jatah = ($r['tarif_jatah'] / 2) * $diff;
          } else {
            $total_jatah = $r['tarif_jatah'] * $diff;
          }
        }
      }

      $subtotal = $subtotal + $total_jatah;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_jatah) . "</td>
    </tr>
    ";
    }
  }
} else if ($carabayar == 'KERJASAMA' && $titip == '1') {
  $konten = $konten . '
  <table  class="table-isi" border="0"  style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
    <td align="left" colspan="3" width="25%">Ruangan</td>
    <td align="center" width="15%">Kelas</td>
    <td align="center" width="15%">Tgl Masuk</td>
    <td align="center" width="15%">Tgl Keluar</td>
    <td align="center" width="15%">Lama Inap</td>
    <td align="right" width="15%">Subtotal</td>
    </tr>
  ';
  $subtotal = 0;
  $subtotalruang = 0;
  $diff = 1;
  $total_subsidi = 0;
  $total = 0;
  $jasaperawat = 0;
  $ceknull = 0;
  $subtotalvk = 0;
  $subtotalicu = 0;
  foreach ($akomodasi['rawatinap'] as $r) {
    if (strpos($r['nmruang'], 'Bersalin') == false) {
      $tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
      if ($r['tglkeluarrg'] != null) {
        $tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg']));
      } else {
        if ($tgl_keluar_resume != null) {
          $tgl_keluar_rg = date("d-m-Y", strtotime($tgl_keluar_resume));
        } else {
          //$tgl_keluar_rg = "-" ;
          $tgl_keluar_rg = date("d-m-Y");
        }
      }
      if ($r['tglkeluarrg'] != null) {
        $start = new DateTime($r['tglmasukrg']); //start
        $end = new DateTime($r['tglkeluarrg']); //end

        $diff = $end->diff($start)->format("%a");
        if ($diff == 0) {
          $diff = 1;
        }
        $selisih_hari =  $diff . " Hari";
      } else {
        if ($tgl_keluar_resume != NULL) {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime($tgl_keluar_resume); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
        } else {
          $start = new DateTime($r['tglmasukrg']); //start
          $end = new DateTime(); //end

          $diff = $end->diff($start)->format("%a");
          if ($diff == 0) {
            $diff = 1;
          }
          $selisih_hari =  $diff . " Hari";
          //$selisih_hari =  "- Hari";
        }
      }
      $jasaperawat = $jasaperawat + $r['jasa_perawat'];
      if (($r['tglkeluarrg'] == null || $r['tglkeluarrg'] == '') && ($tgl_keluar_resume == null || $tgl_keluar_resume == '')) {
        $ceknull = 1;
      }
      $total_tarif = $r['harga_jatah_kelas'];



      $subsidi_inap_kelas = $diff * $total_tarif; //harga permalemnya berapa kalo ada jatah kelas
      $total_subsidi = $total_subsidi + $subsidi_inap_kelas;

      // $total_per_kamar = $r['vtot'] * $diff;

      if ($status_paket == 1) {
        // $temp_diff = $diff - 2;//kalo ada paket free 2 hari
        // if($temp_diff < 0){
        // 	$temp_diff = 0;
        // }
        $total_per_kamar = 0;
      } else {
        if ($ipdibu != NULL) {
          $total_jatah = ($r['tarif_jatah_iks'] / 2) * $diff;
        } else {
          $total_jatah = $r['tarif_jatah_iks'] * $diff;
        }
      }

      $subtotal = $subtotal + $total_jatah;

      if (strpos($r['nmruang'], 'ICU')) {
        $subtotalicu += $total_per_kamar;
      } else {
        $subtotalruang += $total_per_kamar;
      }

      $konten = $konten . "
    <tr>
      <td align=\"left\" colspan=\"3\" >" . $r['nmruang'] . "</td>
      <td align=\"center\">" . $r['kelas'] . "</td>
      <td align=\"center\">" . $tgl_masuk_rg . "</td>
      <td align=\"center\">" . $tgl_keluar_rg . "</td>
      <td align=\"center\">" . $selisih_hari . "</td>
      <td align=\"right\"> " . number_format($total_jatah) . "</td>
    </tr>
    ";
    }
  }
}
$konten = $konten . '
  <tr style="font-weight:bold;">
    <td colspan="7" align="left">Subtotal</td>
    <td align="right"> ' . number_format($subtotal, 0) . '</td>
  </tr>
  ';
$konten = $konten . "</table><br>";
echo $konten;
$totalAkomodasi +=$subtotal;
?>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Akomodasi IGD & Rawat Inap</th>
        <th align="right">Rp. <?= number_format($totalAkomodasi) ?></th>
    </tr>
</table>
<br>
<!-- end akomodasi -->

<!-- Tindakan Keperawatan -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Keperawatan</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalTindakanKeperawatan = 0;
  $subtotal = 0;
  foreach($tindakankeperawatan['igd'] as $r):
    $subtotal = $subtotal + $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qtyind'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal); $totalTindakanKeperawatan+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td>Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($tindakankeperawatan['rawatinap'] as $r):
    $subtotal = $subtotal + $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qtyyanri'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal); $totalTindakanKeperawatan+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Keperawatan IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalTindakanKeperawatan); ?></th>
    </tr>
</table>
<br>

<!-- end tindakan keperawatan -->

<!-- Tindakan Operasi -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Operasi</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Jenis Tind Operasi</td>
        <td>Dokter</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalOperasi = 0;
  $subtotal = 0;
  foreach($tindakanoperasi['igd'] as $r):
    $subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
?>
    <tr>
        <td colspan="5"><?= $r['jenis_tindakan'] ?></td>
        <td colspan="5" align="center"><?= $r['dok_ok'] ?></td>
        <td colspan="4" align="right"><?= number_format($r['biaya_ok'] * $r['qty'], 0) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="5" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalOperasi+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>

<?php
$konten='';
$konten = $konten . '
     <table class="table-isi" border="0" style="width: 100%;" width="100%">
     <tr style="font-weight:bold;">
       <td colspan="3" align="left">Jenis Tind Operasi</td>
       <td align="center">Qty</td>
       <td align="right">Total</td>
     </tr>';

    $subtotal = 0;
    foreach ($tindakanoperasi['rawatinap'] as $r) {
      $subtotal += $r->total_rekap;
      $konten = $konten . "
    <tr>
      <td colspan=\"3\" align=\"left\">" . $r->jenis_tindakan . "</td>
      <td align=\"center\">" . $r->qtx . "</td>
      <td align=\"right\">" . number_format($r->total_rekap) . "</td>
    </tr>";
    }
// if ($titip == NULL) {
//   if ($carabayar == 'UMUM') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td colspan="3" align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       $subtotal = $subtotal + ($r['total_tarif'] * $r['qty']);
//       $konten = $konten . "
//     <tr>
//       <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//       <td align=\"center\">" . $r['dok_ok'] . "</td>
//       <td align=\"right\">" . number_format($r['total_tarif'] * $r['qty'], 0) . "</td>
//     </tr>
//     ";
//     }
//   } else if ($carabayar == 'BPJS') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td colspan="3" align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       if ($tindakanoperasi['rawatinap'][0]['tgl_masuk'] >= '2023-04-06') {
//         $subtotal = $subtotal + ($r['tarif_bpjs'] * $r['qty']);
//         $konten = $konten . "
//       <tr>
//         <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"right\">" . number_format($r['tarif_bpjs'] * $r['qty'], 0) . "</td>
//       </tr>
//       ";
//       } else if ($tindakanoperasi['rawatinap'][0]['tgl_masuk'] < '2023-04-06') {
//         $subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
//         $konten = $konten . "
//       <tr>
//         <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
//       </tr>
//       ";
//       }
//     }
//   } else if ($carabayar == 'KERJASAMA') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="center">Total Kelas</td>
//       <td align="center">Total Jatah</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
//         $subtotal = $subtotal + (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']));
//       } else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
//         $subtotal = $subtotal + (0);
//       }

//       if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
//         $konten = $konten . "
//       <tr>
//         <td align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"center\">" . number_format($r['tarif_jatah_iks'] * $r['qty'], 0) . "</td>
//         <td align=\"center\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
//         <td align=\"right\">" . number_format(($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']), 0) . "</td>
//       </tr>
//       ";
//       } else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
//         $konten = $konten . "
//       <tr>
//         <td align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"center\">" . number_format($r['tarif_jatah_iks'] * $r['qty'], 0) . "</td>
//         <td align=\"center\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
//         <td align=\"right\">" . number_format((0), 0) . "</td>
//       </tr>
//       ";
//       }
//     }
//   }
// } else {
//   if ($carabayar == 'UMUM') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td colspan="3" align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       $subtotal = $subtotal + ($r['tarif_jatah'] * $r['qty']);
//       $konten = $konten . "
//     <tr>
//       <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//       <td align=\"center\">" . $r['dok_ok'] . "</td>
//       <td align=\"right\">" . number_format($r['tarif_jatah'] * $r['qty'], 0) . "</td>
//     </tr>
//     ";
//     }
//   } else if ($carabayar == 'BPJS') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td colspan="3" align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       if ($tindakanoperasi['rawatinap'][0]['tgl_masuk'] >= '2023-04-06') {
//         $subtotal = $subtotal + ($r['tarif_jatah_bpjs'] * $r['qty']);
//         $konten = $konten . "
//       <tr>
//         <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"right\">" . number_format($r['tarif_jatah_bpjs'] * $r['qty'], 0) . "</td>
//       </tr>
//       ";
//       } else if ($tindakanoperasi['rawatinap'][0]['tgl_masuk'] < '2023-04-06') {
//         $subtotal = $subtotal + ($r['biaya_ok'] * $r['qty']);
//         $konten = $konten . "
//       <tr>
//         <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//         <td align=\"center\">" . $r['dok_ok'] . "</td>
//         <td align=\"right\">" . number_format($r['biaya_ok'] * $r['qty'], 0) . "</td>
//       </tr>
//       ";
//       }
//     }
//   } else if ($carabayar == 'KERJASAMA') {
//     $konten = $konten . '
//     <table class="table-isi" border="0" style="width: 100%;" width="100%">
//     <tr style="font-weight:bold;">
//       <td colspan="3" align="left">Jenis Tind Operasi</td>
//       <td align="center">Dokter</td>
//       <td align="right">Total</td>
//     </tr>
//     ';

//     $subtotal = 0;
//     foreach ($tindakanoperasi['rawatinap'] as $r) {
//       $subtotal = $subtotal + ($r['tarif_iks'] * $r['qty']);
//       $konten = $konten . "
//     <tr>
//       <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
//       <td align=\"center\">" . $r['dok_ok'] . "</td>
//       <td align=\"right\">" . number_format($r['tarif_iks'] * $r['qty'], 0) . "</td>
//     </tr>
//     ";
//     }
//   }
// }

$konten = $konten . '
  <tr style="font-weight:bold;">
    <td colspan="4" align="left">Subtotal</td>
    <td align="right">' . number_format($subtotal, 0) . '</td>
  </tr>
  ';
$konten = $konten . "</table><br>";
$totalOperasi +=$subtotal;
echo $konten

?>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Operasi IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalOperasi); ?></th>
    </tr>
</table>
<br>
<!-- End Tindakan Operasi -->

<!-- BMHP -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>BMHP</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalBmhp = 0;
  $subtotal = 0;
  foreach($bmhp['igd'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal); 
        $totalBmhp += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($bmhp['rawatinap'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal);
        $totalBmhp += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total BMHP IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalBmhp); ?></th>
    </tr>
</table>
<br>
<!-- end BMHP-->

<!-- sewa alat -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Sewa Alat</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalAlat = 0;
  $subtotal = 0;
  foreach($alat['igd'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal); 
        $totalAlat += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($alat['rawatinap'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal);
        $totalAlat += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Sewa Alat IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalAlat); ?></th>
    </tr>
</table>
<br>
<!-- end sewa alat -->

<!-- pelayanan darah -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Pelayanan Darah</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $totalDarah = 0;
  $subtotal = 0;
  foreach($darah['igd'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>

    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal); 
        $totalDarah += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
    <tr style="font-weight:bold;">
        <td>Tindakan</td>
        <td>Qty</td>
        <td align="right">Total</td>
    </tr>
    <?php 
  $subtotal = 0;
  foreach($darah['rawatinap'] as $r):
    $subtotal += $r['vtot'];
?>
    <tr>
        <td><?= $r['nmtindakan'] ?></td>
        <td><?= $r['qty'] ?></td>
        <td align="right"><?= number_format($r['vtot']) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="2" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal);
        $totalDarah += $subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Pelayanan Darah IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalDarah); ?></th>
    </tr>
</table>
<br>
<!-- end pelayanan darah -->
<!-- Resep -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Resep</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="6" align="left">Resep (Nama Obat)</td>
    <td align="center">Qty</td>
    <td align="right">Total</td>
  </tr>
  <?php 
  $totalResep = 0;
  $subtotal = 0;
  foreach($resepfarmasi['igd'] as $r):
    $subtotal += $r->total_rekap;
  ?>
    <tr>
				<td colspan="6" align="left"><?= strtoupper($r->nama_obat == '' ? 'Obat Racikan' : $r->nama_obat) ?></td>
				<td align="center"><?= $r->quantiti ?></td>
				<td align="right"><?= number_format($r->total_rekap) ?></td>
			</tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="7" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalResep+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="6" align="left">Resep (Nama Obat)</td>
    <td align="center">Qty</td>
    <td align="right">Total</td>
  </tr>
  <?php 
  $subtotal = 0;
  foreach($resepfarmasi['rawatinap'] as $r):
    $subtotal += $r->total_rekap;
?>
    <tr>
				<td colspan="6" align="left"><?= strtoupper($r->nama_obat == '' ? 'Obat Racikan' : $r->nama_obat) ?></td>
				<td align="center"><?= $r->quantiti ?></td>
				<td align="right"><?= $r->total_rekap ?></td>
			</tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="7" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalResep+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Resep IGD & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalResep); ?></th>
    </tr>
</table>
<br><br><br>
<!-- End Resep -->


<!-- Elektromedik -->
<table class="table-isi" border="0">
    <tr>
        <td colspan="8"><b>Tindakan Elektromedik</b></td>
    </tr>
    <tr>
        <td colspan="8"><br>&nbsp;&nbsp;&nbsp;&nbsp;<b>IGD</b></td>
    </tr>
</table>
<table class="table-isi" border="0" style="width: 100%;" width="100%">
		<tr style="font-weight:bold;">
			<td colspan="5" align="left">Jenis Tind Elektromedik</td>
			<td colspan="5" align="center">Dokter</td>
			<td colspan="4" align="right">Total</td>
		</tr>
  <?php 
  $totalEm = 0;
  $subtotal = 0;
  foreach($tindakanelektromedik['igd'] as $r):
    $subtotal += ($r['biaya_em'] * $r['qty']);
  ?>
    <tr>
      <td colspan="5" align="left"><?= $r['jenis_tindakan'] ?></td>
      <td colspan="5" align="center"><?= $r['nm_dokter'] ?></td>
      <td colspan="4" align="right"><?= ($r['biaya_em'] * $r['qty']) ?></td>
    </tr>

    <?php endforeach;  ?>
    <tr style="font-weight:bold;">
        <td colspan="7" align="left">Subtotal</td>
        <td align="right"><?= number_format($subtotal, 0);$totalEm+=$subtotal; ?></td>
    </tr>
</table>
<table class="table-isi" border="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<b>Rawat Inap</b></td>
    </tr>
</table>
<?php 
$konten = "";
// <table border="1">
if ($titip== NULL) {
  if ($carabayar == 'UMUM') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="3" align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      $subtotal = $subtotal + ($r['total_tarif'] * $r['qty']);
      $konten = $konten . "
    <tr>
      <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
      <td align=\"center\">" . $r['nm_dokter'] . "</td>
      <td align=\"right\">" . ($r['total_tarif'] * $r['qty']) . "</td>
    </tr>
    ";
    }
  } else if ($carabayar == 'BPJS') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="3" align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      if ($tindakanelektromedik['rawatinap'][0]['tgl_masuk'] >= '2023-04-06') {
        $subtotal = $subtotal + ($r['tarif_bpjs'] * $r['qty']);
        $konten = $konten . "
      <tr>
        <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"right\">" . ($r['tarif_bpjs'] * $r['qty']) . "</td>
      </tr>
      ";
      } else if ($tindakanelektromedik['rawatinap'][0]['tgl_masuk'] < '2023-04-06') {
        $subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
        $konten = $konten . "
      <tr>
        <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"right\">" . ($r['biaya_em'] * $r['qty']) . "</td>
      </tr>
      ";
      }
    }
  } else if ($carabayar == 'KERJASAMA') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="center">Total Kelas</td>
    <td align="center">Total Jatah</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
        $subtotal = $subtotal + (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty']));
      } else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
        $subtotal = $subtotal + (0);
      }

      if (($r['tarif_jatah_iks'] > $r['tarif_iks']) || ($r['tarif_jatah_iks'] == $r['tarif_iks'])) {
        $konten = $konten . "
      <tr>
        <td align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"center\">" . ($r['tarif_jatah_iks'] * $r['qty']) . "</td>
        <td align=\"center\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
        <td align=\"right\">" . (($r['tarif_jatah_iks'] * $r['qty']) - ($r['tarif_iks'] * $r['qty'])) . "</td>
      </tr>
      ";
      } else if ($r['tarif_jatah_iks'] < $r['tarif_iks']) {
        $konten = $konten . "
      <tr>
        <td align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"center\">" . ($r['tarif_jatah_iks'] * $r['qty']) . "</td>
        <td align=\"center\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
        <td align=\"right\">" . number_format(0) . "</td>
      </tr>
      ";
      }
    }
  }
} else {
  if ($carabayar == 'UMUM') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="3" align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      $subtotal = $subtotal + ($r['tarif_jatah'] * $r['qty']);
      $konten = $konten . "
    <tr>
      <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
      <td align=\"center\">" . $r['nm_dokter'] . "</td>
      <td align=\"right\">" . ($r['tarif_jatah'] * $r['qty']) . "</td>
    </tr>
    ";
    }
  } else if ($carabayar == 'BPJS') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="3" align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      if ($tindakanelektromedik['rawatinap'][0]['tgl_masuk'] >= '2023-04-06') {
        $subtotal = $subtotal + ($r['tarif_jatah_bpjs'] * $r['qty']);
        $konten = $konten . "
      <tr>
        <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"right\">" . ($r['tarif_jatah_bpjs'] * $r['qty']) . "</td>
      </tr>
      ";
      } else if ($tindakanelektromedik['rawatinap'][0]['tgl_masuk'] < '2023-04-06') {
        $subtotal = $subtotal + ($r['biaya_em'] * $r['qty']);
        $konten = $konten . "
      <tr>
        <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
        <td align=\"center\">" . $r['nm_dokter'] . "</td>
        <td align=\"right\">" . ($r['biaya_em'] * $r['qty']) . "</td>
      </tr>
      ";
      }
    }
  } else if ($carabayar == 'KERJASAMA') {
    $konten = $konten . '
  <table class="table-isi" border="0" style="width: 100%;" width="100%">
  <tr style="font-weight:bold;">
    <td colspan="3" align="left">Jenis Tind Elektromedik</td>
    <td align="center">Dokter</td>
    <td align="right">Total</td>
  </tr>
  ';

    $subtotal = 0;
    foreach ($tindakanelektromedik['rawatinap'] as $r) {
      $subtotal = $subtotal + ($r['tarif_iks'] * $r['qty']);
      $konten = $konten . "
    <tr>
      <td colspan=\"3\" align=\"left\">" . $r['jenis_tindakan'] . "</td>
      <td align=\"center\">" . $r['nm_dokter'] . "</td>
      <td align=\"right\">" . ($r['tarif_iks'] * $r['qty']) . "</td>
    </tr>
    ";
    }
  }
}

$konten = $konten . '
  <tr style="font-weight:bold;">
    <td colspan="4" align="left">Subtotal</td>
    <td align="right">' . number_format($subtotal, 0) . '</td>
  </tr>
  ';
$konten = $konten . "</table><br>";
echo $konten;
$totalEm+=$subtotal;

?>
<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Total Tindakan Elektromedik & Rawat Inap</th>
        <th align="right">Rp. <?php echo number_format($totalEm); ?></th>
    </tr>
</table>
<br><br><br>
<!-- End Elektromedik -->
<?php
$grandtotal =$totalVisite +  $totalLabor + $totalRadiologi + $totalRehab + $totalAkomodasi + $totalTindakanKeperawatan + $totalOperasi + $totalResep + $totalEm + $totalAlat + $totalBmhp + $totalDarah;
?>

<table class="table-isi" border="0" style="width:100%">
    <tr style="font-weight:bold">
        <th align="left">Grand Total </th>
        <th align="right">Rp. <?php echo number_format($grandtotal); ?></th>
    </tr>
</table>
<!-- sampe sini -->

<table style="width: 100%" width="100%">
    <tr>
        <td style="width: 50%"></td>
        <td style="width: 50%" align="center">Bukittinggi, 30 November 2023</td>
    </tr>
    <tr>
        <td align="center">Pasien</td>
        <td align="center">ADMINISTRATOR</td>
    </tr>
</table>