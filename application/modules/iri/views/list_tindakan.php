<?php
$data_konsultasi = '';
?>
<?php $this->load->view("layout/header_left"); ?>
<br>
<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>



<?php

$this->load->view("iri/data_pasien");
?>

<script type='text/javascript'>
  var table_pasien;
  var table_history;

  $(document).ready(function() {
    show_permintaan_diet('<?php echo $no_ipd; ?>');
    $('.select2').select2();
    $("#form_permintaan_diet").submit(function(event) {
      document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'gizi/insert_permintaan_diet'; ?>",
        dataType: "JSON",
        data: {
          "no_ipd": "<?php echo $no_ipd; ?>",
          "bed": "<?php echo $data_pasien[0]['bed']; ?>",
          "standar_diet": $("#standar_diet").val().toString(),
          "catatan": $("#catatan").val(),
          "bentuk_makanan": $("#bentuk_makanan").val()
        },
        success: function(result) {
          document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          if (result.metadata.code == '200') {
            table_history.ajax.reload();
            show_permintaan_diet('<?php echo $no_ipd; ?>');
            swal("Sukses", "Permintaan Diet Berhasil Disimpan.", "success");
          } else if (result.metadata.code == '402') {
            swal(result.metadata.message, "Harap isikan data jika ada perubahan permintaan diet.", "warning");
          } else {
            swal("Gagal Menyimpan Permintaan", "Silahkan COba Lagi.", "error");
          }
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          swal("Gagal Menyimpan Permintaan Diet", formatErrorMessage(event, errorThrown), "error");
        }
      });
      event.preventDefault();
    });
    table_history = $('#table-history').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [10, 25, 50, -1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
      ],
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?php echo site_url('gizi/history_permintaan_diet') ?>",
        "type": "POST",
        "data": {
          "no_ipd": "<?php echo $no_ipd; ?>"
        }
      }
    });


    // $('#tgl_tindakan').datepicker({
    // 	format: "yyyy-mm-dd",
    // 	autoclose: true,
    // 	todayHighlight: true,
    // 	endDate: '0',	
    // });
    $('.clockpicker').clockpicker({
      donetext: 'Done',
    }).find('input').change(function() {
      console.log(this.value);
    });

    // $('#tanggal').datepicker({
    // format: "yyyy-mm-dd",
    // autoclose: true,
    // todayHighlight: true,
    // });

    $('.js-example-basic-single').select2();

    $("#form_add_diet").submit(function(event) {
      document.getElementById("btn-diet").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'irj/rjcpelayanan/insert_dietpasien'; ?>",
        dataType: "JSON",
        data: $('#form_add_diet').serialize(),
        success: function(data) {
          if (data == true) {
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            swal("Sukses", "Jenis Diet berhasil disimpan.", "success");
          } else {
            document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            swal("Error", "Gagal menginput Jenis Diet. Silahkan coba lagi.", "error");
          }
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        },
        timeout: 0
      });
      event.preventDefault();
    });

    table_pasien = $('#table-pasien').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      // "language": {
      //   "searchPlaceholder": " No. SEP, Nama"
      // },
      "lengthMenu": [
        [10, 25, 50, -1],
        ['10 rows', '25 rows', '50 rows', 'Show all']
      ],
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      "ajax": {
        "url": "<?php echo site_url('gizi/show_pasien_gizi') . '/' . $no_ipd; ?>",
        "type": "post"
      },
      "columnDefs": [{
          "orderable": false, //set not orderable
          "width": "15%",
          "targets": 6 // column index 
        }
        // ,{ "width": "18%", "targets": 3 },{ "width": "10%", "targets": 2 },{ "width": "7%", "targets": 0 }
      ],

    });

    var v00 = $("#forminputmenupasien").validate({
      rules: {
        iddiet: {
          required: true
        },
        ket_waktu: {
          required: true
        },
        tanggal: {
          required: true
        }
      },
      highlight: function(element) { // hightlight error inputs
        $(element)
          .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
      },

      unhighlight: function(element) { // revert the change done by hightlight
        $(element)
          .closest('.form-group').removeClass('has-error'); // set error class to the control group
      },
      errorElement: "span",
      errorClass: "help-block help-block-error",
      submitHandler: function(form) {
        var formData = new FormData($("#forminputmenupasien")[0]);
        $.ajax({
          type: 'post',
          url: "<?php echo base_url('gizi/insert_gizipasien/') ?>",
          type: 'POST',
          data: formData,
          async: false,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function() {},
          complete: function() {
            //stopPreloader();
          },
          success: function(data) {
            alert("Data Berhasil Disimpan");
            // console.log(data);
            // tablegizipasien();
            $("#forminputmenupasien")[0].reset();
            table_pasien.ajax.reload();
          },
          error: function() {
            alert("error");
          }
        });
      }
    });
  });

  function form_tambah_tindakan() {
    alert("test");
  }


  $('tindakan').on('change', function(e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    alert(valueSelected);
  });

  // moris below

  function show_permintaan_diet(no_ipd) {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('gizi/show_permintaan_diet'); ?>/" + no_ipd,
      dataType: "JSON",
      success: function(result) {
        console.log(result);
        if (result != null) {
          var standar_diet = result.standar.split(',');
          $('#standar_diet').select2().select2('val', [standar_diet]);
          $('#bentuk_makanan').val(result.bentuk).trigger('change');
          $('#catatan').val(result.catatan);
        }
      },
      error: function(event, textStatus, errorThrown) {
        swal("Gagal Menampilkan Data Permintaan Diet", formatErrorMessage(event, errorThrown), "error");
      }
    });
  }

  function pilih_tindakan(val) {
    var temp = val.split("-");
    var cara_bayar = "$data_pasien[0]['carabayar']";
    temp[1] = (temp[1] == "" ? 0 : temp[1]);
    temp[3] = (temp[3] == "" ? 0 : temp[3]);
    $('#biaya_tindakan').val(temp[1]);
    $('#biaya_tindakan_hide').val(temp[1]);
    $('#paket').val(temp[2]);
    var qty = $('#qtyind').val();
    var total = ((parseInt(qty) * (parseInt(temp[1]) + parseInt(temp[3]))));
    $('#vtot').val(total);
  }

  function isEmpty(obj) {
    for (var prop in obj) {
      if (obj.hasOwnProperty(prop))
        return false;
    }

    return true;
  }

  function set_total(val) {
    var biaya_tindakan = $('#biaya_tindakan').val();
    var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();
    var total = (parseInt(val) * (parseInt(biaya_tindakan)));
    var total_jatah_kelas = val * harga_satuan_jatah_kelas;
    $('#vtot').val(total);
    $('#vtot_kelas').val(total_jatah_kelas);
  }

  function insert_total() {
    var jumlah = $('#jumlah').val();

    var val = $('select[name=idtindakan]').val();
    var temp = val.split("-");
    var cara_bayar = "$data_pasien[0]['carabayar']";

    $('#biaya_tindakan').val(jumlah);
    $('#biaya_tindakan_hide').val(jumlah);
    var qty = 1;
    $('#qtyind').val(1)
    var total = qty * jumlah;
    $('#vtot').val(total);

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
      data: {
        'id_tindakan': temp[0],
        'cara_bayar': temp[0],
        'kelas': "<?php echo $data_pasien[0]['jatahklsiri']; ?>",
      },
      success: function(data) {
        var obj = JSON.parse(data);

        if (!isEmpty(obj)) {
          $("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
          $("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
          $('#vtot_kelas').val(obj[0]['total_tarif']);
          $('#vtot').val(total - (obj[0]['total_tarif'] * qty));
          $('#biaya_tindakan').val(jumlah - obj[0]['total_tarif']);
        } else {
          $("#harga_satuan_jatah_kelas").val('0');
          $("#biaya_jatah_kelas").val('0');
          //$('#vtot').val('0');
        }
      }
    });

    //alert(jumlah);
  }

  function delete_menu(id) {
    swal({
      title: "Hapus Menu",
      text: "Hapus Menu tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya (hapus)",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
    }, function() {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url() . 'gizi/delete_menu/'; ?>" + id,
        dataType: "JSON",
        success: function(data) {
          if (data == true) {
            table_pasien.ajax.reload();
            swal("Sukses", "Menu berhasil dihapus.", "success");
          } else {
            swal("Error", "Gagal menghapus Menu. Silahkan coba lagi.", "error");
          }
        },
        error: function(event, textStatus, errorThrown) {
          swal("Error", "Gagal Menghapus Data.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });
  }
</script>
<section class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="ribbon-wrapper card">
        <div class="ribbon ribbon-info">
          Pelayanan Pasien
        </div>

        <div class="p-20">
          <ul class="nav nav-tabs customtab" role="tablist" style="overflow-x: scroll;">

          <?php
            if($ppa_sebagai == 'dokter_dpjp' || $ppa_sebagai =='Dokter Bersama 1' || $ppa_sebagai =='Dokter Bersama 2' || $ppa_sebagai =='Dokter Bersama 3' || $ppa_sebagai =='Kosultasi 1x' || strpos($ppa_sebagai,'sebelumnya') || $ppa_sebagai =='DPJP pengganti'  ){
            ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_konsultasi; ?>" data-toggle="tab" href="#tabKonsultasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Konsultasi Dokter</span></a> </li>
              <?php
              if (isset($user_dokter->id_dokter)) {
                foreach ($history_konsultasi_pasien_iri->result_array() as $res) {
                  if (in_array($user_dokter->id_dokter, $res)) {
                    $data_konsultasi = $res['tgl_jawaban'] == null ? $res['id'] : '';
                    if ($data_konsultasi != "") {
                      if (substr($res['id_poli_tujuan'], 0, 4) != 'BK00') {
              ?>
                        <li class="nav-item"> <a class="nav-link <?= $tab_jawabankonsultasi; ?>" data-toggle="tab" href="#tabJawabanKonsultasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Jawaban Konsultasi Dokter</span></a> </li>

                      <?php } else {
                      ?>
                        <li class="nav-item"> <a class="nav-link <?= $tab_jawabankonsultasiRehab; ?>" data-toggle="tab" href="#tabJawabanKonsultasiRehab" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Jawaban Konsultasi Rehab medik</span></a> </li>

                <?php
                      }
                    }
                  }
                }
                ?>
              <?php }

              ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rad ?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_lab ?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_em ?>" data-toggle="tab" href="#tabElektromedik" role="tab"><span class="hidden-xs-down">Elektromedik</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ok ?>" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_obat ?>" data-toggle="tab" href="#tabObat" role="tab"><span class="hidden-xs-down">Obat</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>

              <?php
              if ($ppa_sebagai == 'dokter_dpjp' || strpos($ppa_sebagai, 'sebelumnya')) {
              ?>
                <li class="nav-item"> <a class="nav-link <?= $tab_resume_pasien_pulang; ?>" data-toggle="tab" href="#tab_resume_pasien_pulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Resume Pasien Pulang</span></a> </li>
                <li class="nav-item"> <a class="nav-link <?= $tab_form_rekonsiliasi_obat; ?>" data-toggle="tab" href="#tab_form_rekonsiliasi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rekonsiliasi Obat</span></a> </li>
                <li class="nav-item"> <a class="nav-link <?= $tab_form_pemberian_obat; ?>" data-toggle="tab" href="#tab_form_pemberian_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Daftar Pemberian Obat</span></a> </li>
              <?php } ?>
            <?php
            } elseif ($ppa_sebagai == 'dokter_ruang_jaga' || $ppa_sebagai == 'dokter_jaga' || $ppa_sebagai == 'dokter_ruangan') {
            ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_transfer_ruangan; ?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transfer Ruangan</span></a> </li>

              <?php
              if (isset($user_dokter->id_dokter) && isset($user_dokter->id_dokter_penerima)) {
                if ($user_dokter->id_dokter == $history_konsultasi_pasien_iri->row()->id_dokter_penerima) {
              ?>
              <?php }
              } ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_catatan_medis_awal; ?>" data-toggle="tab" href="#tab_catatan_medis_awal" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan Medis Awal</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rad ?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_konsultasi; ?>" data-toggle="tab" href="#tabKonsultasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Konsultasi Dokter</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_lab ?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_em ?>" data-toggle="tab" href="#tabElektromedik" role="tab"><span class="hidden-xs-down">Elektromedik</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ok ?>" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_obat ?>" data-toggle="tab" href="#tabObat" role="tab"><span class="hidden-xs-down">Obat</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_resume_pasien_pulang; ?>" data-toggle="tab" href="#tab_resume_pasien_pulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Resume Pasien Pulang</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_persetujuan_dokter; ?>" data-toggle="tab" href="#tab_persetujuan_dokter" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">PERSETUJUAN TINDAKAN KEDOKTERAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_penolakan_kedokteran; ?>" data-toggle="tab" href="#tab_penolakan_kedokteran" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Penolakan Tindakan Kedokteran</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pernyataan_dnr; ?>" data-toggle="tab" href="#tab_pernyataan_dnr" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Surat Pernyataan DNR</span></a> </li>
            <?php
            } elseif ($ppa_sebagai == 'case_manager') {
            ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_transfer_ruangan; ?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transfer Ruangan</span></a> </li>

              <li class="nav-item"> <a class="nav-link <?= $tab_rencana_pemulangan; ?>" data-toggle="tab" href="#tabRencanaPemulangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rencana Pemulangan Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_a; ?>" data-toggle="tab" href="#tabA" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir A Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_b; ?>" data-toggle="tab" href="#tabB" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir B Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ceklis_pasien_mpp; ?>" data-toggle="tab" href="#tab_ceklis_pasien_mpp" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir Perencanaan Pemulangan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>

            <?php } elseif ($ppa_sebagai == "perawat" && $this->get_var("user_info")->userid != "1") { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_fisik; ?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pemeriksaan Fisik</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_assesment; ?>" data-toggle="tab" href="#tabAssesmentKeperawatan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Keperawatan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_transfer_ruangan; ?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transfer Ruangan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_fungsional; ?>" data-toggle="tab" href="#tab_fungsional" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Fungsional</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $pengkajian_dekubitus; ?>" data-toggle="tab" href="#pengkajian_dekubitus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pengkajian Dekubitus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $skala_morse; ?>" data-toggle="tab" href="#skala_morse" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Skala Morse</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ews; ?>" data-toggle="tab" href="#tab_ews" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Lembar Observasi EWS</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_rekonsiliasi_obat; ?>" data-toggle="tab" href="#tab_form_rekonsiliasi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rekonsiliasi Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_pemberian_obat; ?>" data-toggle="tab" href="#tab_form_pemberian_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Daftar Pemberian Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_serahterima; ?>" data-toggle="tab" href="#tab_form_serahterima" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Serah Terima</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rencana_pemulangan; ?>" data-toggle="tab" href="#tabRencanaPemulangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rencana Pemulangan Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_resume_pasien_pulang; ?>" data-toggle="tab" href="#tab_resume_pasien_pulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Resume Pasien Pulang</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_lab ?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rad ?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>

            <?php } elseif ($ppa_sebagai == "Nutrisionis") { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_assesment_gizi; ?>" data-toggle="tab" href="#tab_form_assesment_gizi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Gizi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_asuhan_gizi; ?>" data-toggle="tab" href="#tab_form_asuhan_gizi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Asuhan Gizi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt_adime; ?>" data-toggle="tab" href="#tab_form_cppt_adime" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>

            <?php } elseif ($ppa_sebagai == "Farmatologi") { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_rekonsiliasi_obat; ?>" data-toggle="tab" href="#tab_form_rekonsiliasi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rekonsiliasi Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_intruksi_obat; ?>" data-toggle="tab" href="#tab_intruksi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Kartu Intruksi Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_pemberian_obat; ?>" data-toggle="tab" href="#tab_form_pemberian_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Daftar Pemberian Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_obat ?>" data-toggle="tab" href="#tabObat" role="tab"><span class="hidden-xs-down">Obat</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_resume_pasien_pulang; ?>" data-toggle="tab" href="#tab_resume_pasien_pulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Resume Pasien Pulang</span></a> </li>
            <?php } elseif ($ppa_sebagai == "Fisioterapis" || $ppa_sebagai == 'Okupasi Terapi' || $ppa_sebagai == 'Ortotik Prostetik' || $ppa_sebagai == 'Terapi Wicara') { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_jawabankonsultasiRehab; ?>" data-toggle="tab" href="#tabJawabanKonsultasiRehab" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Jawaban Konsultasi Rehab medik</span></a> </li>

            <?php } elseif ($this->get_var("user_info")->userid == "1") { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_fisik; ?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pemeriksaan Fisik</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_konsultasi; ?>" data-toggle="tab" href="#tabKonsultasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Konsultasi Dokter</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_jawabankonsultasi; ?>" data-toggle="tab" href="#tabJawabanKonsultasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Jawaban Konsultasi Dokter</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_jawabankonsultasiRehab; ?>" data-toggle="tab" href="#tabJawabanKonsultasiRehab" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Jawaban Konsultasi Rehab medik</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rad ?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_lab ?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_em ?>" data-toggle="tab" href="#tabElektromedik" role="tab"><span class="hidden-xs-down">Elektromedik</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ok ?>" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_obat ?>" data-toggle="tab" href="#tabObat" role="tab"><span class="hidden-xs-down">Obat</span></a></li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_pasien; ?>" data-toggle="tab" href="#tabEdukasiPasien" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Edukasi Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_catatan_medis_awal; ?>" data-toggle="tab" href="#tab_catatan_medis_awal" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan Medis Awal</span></a> </li>

              <?php if ($data_pasien[0]['idrg'] == '0104') { ?>
                <li class="nav-item"> <a class="nav-link <?= $tab_catatan_persalinan; ?>" data-toggle="tab" href="#tab_catatan_persalinan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan Persalinan</span></a> </li>
                <li class="nav-item"> <a class="nav-link <?= $tab_laporan_persalinan; ?>" data-toggle="tab" href="#tab_laporan_persalinan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Laporan Persalinan</span></a> </li>
              <?php } ?>

              <?php if ($data_pasien[0]['idrg'] == '0104' || $data_pasien[0]['idrg'] == '0101') { ?>
                <li class="nav-item"> <a class="nav-link <?= $tab_keperawatan_bayi; ?>" data-toggle="tab" href="#tab_keperawatan_bayi" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Assesment Keperawatan Bayi</span></a> </li>
              <?php } ?>


              <li class="nav-item"> <a class="nav-link <?= $tab_intruksi_obat; ?>" data-toggle="tab" href="#tab_intruksi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Kartu Intruksi Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_fungsional; ?>" data-toggle="tab" href="#tab_fungsional" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Fungsional</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $pengkajian_dekubitus; ?>" data-toggle="tab" href="#pengkajian_dekubitus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pengkajian Dekubitus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $skala_morse; ?>" data-toggle="tab" href="#skala_morse" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Skala Morse</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_assesment; ?>" data-toggle="tab" href="#tabAssesmentKeperawatan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Keperawatan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rencana_pemulangan; ?>" data-toggle="tab" href="#tabRencanaPemulangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rencana Pemulangan Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_a; ?>" data-toggle="tab" href="#tabA" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir A Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_b; ?>" data-toggle="tab" href="#tabB" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir B Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_serahterima; ?>" data-toggle="tab" href="#tab_form_serahterima" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Serah Terima</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_asuhan_gizi; ?>" data-toggle="tab" href="#tab_form_asuhan_gizi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">ASUHAN GIZI</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_assesment_gizi; ?>" data-toggle="tab" href="#tab_form_assesment_gizi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Gizi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_rekonsiliasi_obat; ?>" data-toggle="tab" href="#tab_form_rekonsiliasi_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rekonsiliasi Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_pemberian_obat; ?>" data-toggle="tab" href="#tab_form_pemberian_obat" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Daftar Pemberian Obat</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_resume_pasien_pulang; ?>" data-toggle="tab" href="#tab_resume_pasien_pulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Resume Pasien Pulang</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_transfer_ruangan; ?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transfer Ruangan</span></a> </li>

              <li class="nav-item"> <a class="nav-link <?= $tab_ceklis_pasien_mpp; ?>" data-toggle="tab" href="#tab_ceklis_pasien_mpp" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir Perencanaan Pemulangan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ews; ?>" data-toggle="tab" href="#tab_ews" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Lembar Observasi EWS</span></a> </li>

              <!-- tahap 2 -->
              <li class="nav-item"> <a class="nav-link <?= $tab_selisih_tarif; ?>" data-toggle="tab" href="#tab_selisih_tarif" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Surat pernyataan Selisih Tarif</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_medis_neonatus; ?>" data-toggle="tab" href="#tab_medis_neonatus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Catatan Medis Awal Rawat Inap Neonatus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_asesmen_risiko_jatuh_dewasa; ?>" data-toggle="tab" href="#tab_asesmen_risiko_jatuh_dewasa" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Asesmen ulang risiko jatuh orang dewasa</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_asesmen_risiko_jatuh_anak; ?>" data-toggle="tab" href="#tab_asesmen_risiko_jatuh_anak" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Monitoring Asesmen Risiko Jatuh Anak anak</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_kebidanan_ginekologi; ?>" data-toggle="tab" href="#tab_kebidanan_ginekologi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesmen Awal Kebidanan Ginekologi Rawat Inap</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pengkajian_rehab_medik; ?>" data-toggle="tab" href="#tab_pengkajian_rehab_medik" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pengkajian Rehab Medik</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pengkajian_rehab_medik_anak; ?>" data-toggle="tab" href="#tab_pengkajian_rehab_medik_anak" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pengkajian Rehab Medik Anak</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_gizi_anak; ?>" data-toggle="tab" href="#tab_gizi_anak" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Gizi Anak</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_asesmen_ulang_nyeri_dewasa; ?>" data-toggle="tab" href="#tab_asesmen_ulang_nyeri_dewasa" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Asesmen Ulang Nyeri pada pasien Dewasa</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_monitoring_nyeri_anak; ?>" data-toggle="tab" href="#tab_monitoring_nyeri_anak" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Monitoring Asesmen Nyeri Pada Pasien Anak 1-7 Tahun</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_monitoring_nyeri_tidaksadar; ?>" data-toggle="tab" href="#tab_monitoring_nyeri_tidaksadar" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">MONITORING ASESMEN NYERI PADA PASIEN TIDAK SADAR</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_asesmen_resiko_dekubitus; ?>" data-toggle="tab" href="#tab_asesmen_resiko_dekubitus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Asesmen Ulang Risiko dan kejadian Decubitus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_asesmen_geriatri; ?>" data-toggle="tab" href="#tab_asesmen_geriatri" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Geriatri</span></a> </li>

              <li class="nav-item"> <a class="nav-link <?= $tab_tind_keperawatan; ?>" data-toggle="tab" href="#tab_tind_keperawatan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Tindakan Keperawatan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_obs_harian; ?>" data-toggle="tab" href="#tab_obs_harian" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Lembar Observasi Harian</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pemb_cairan; ?>" data-toggle="tab" href="#tab_pemb_cairan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pemantauan Pemberian Cairan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pemberian_infus; ?>" data-toggle="tab" href="#tab_pemberian_infus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Daftar Pemberian Infus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_persetujuan_dokter; ?>" data-toggle="tab" href="#tab_persetujuan_dokter" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">PERSETUJUAN TINDAKAN KEDOKTERAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_persetujuan_anestesi; ?>" data-toggle="tab" href="#tab_persetujuan_anestesi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Persetujuan Anestesi / Sedasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_penolakan_kedokteran; ?>" data-toggle="tab" href="#tab_penolakan_kedokteran" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Penolakan Tindakan Kedokteran</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_edukasi_anestesi; ?>" data-toggle="tab" href="#tab_edukasi_anestesi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Edukasi Anestesi dan Sedasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_site_marking; ?>" data-toggle="tab" href="#tab_site_marking" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Site Marking (Penandaan Operasi)</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_keperawatan_peri_operatif; ?>" data-toggle="tab" href="#tab_keperawatan_peri_operatif" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Asuhan Keperawatan Pre Operatif</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_status_sedasi; ?>" data-toggle="tab" href="#tab_status_sedasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Status Sedasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_checklist_keselamatan_operasi; ?>" data-toggle="tab" href="#tab_checklist_keselamatan_operasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Cheklist Keselamatan Pasien Dikamar Operasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_checklist_persiapan_operasi; ?>" data-toggle="tab" href="#tab_checklist_persiapan_operasi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Checklist Persiapan Operasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_laporan_anestesi; ?>" data-toggle="tab" href="#tab_laporan_anestesi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Laporan Anestesi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_assesment_pra_anastesi; ?>" data-toggle="tab" href="#tab_assesment_pra_anastesi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Pra Anastesi/Sedasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_survei_lans; ?>" data-toggle="tab" href="#tab_survei_lans" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Surveilans HAIs</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_surat_rujukan; ?>" data-toggle="tab" href="#tab_surat_rujukan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Surat Rujukan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pulang_permintaan_sendiri; ?>" data-toggle="tab" href="#tab_pulang_permintaan_sendiri" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pulang atas permintaan sendiri</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_pernyataan_dnr; ?>" data-toggle="tab" href="#tab_pernyataan_dnr" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Surat Pernyataan DNR</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_penundaan_pelayanan; ?>" data-toggle="tab" href="#tab_penundaan_pelayanan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir Penundaan Pelayanan</span></a> </li>



            <?php } else if ($ppa_sebagai == 'Perawat Case Manager') { ?>
              <li class="nav-item"> <a class="nav-link <?= $tab_tindakan; ?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_form_cppt; ?>" data-toggle="tab" href="#tabformcppt" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir CPPT </span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_rencana_pemulangan; ?>" data-toggle="tab" href="#tabRencanaPemulangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Rencana Pemulangan Pasien</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_a; ?>" data-toggle="tab" href="#tabA" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir A Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_b; ?>" data-toggle="tab" href="#tabB" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir B Evaluasi</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ceklis_pasien_mpp; ?>" data-toggle="tab" href="#tab_ceklis_pasien_mpp" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Formulir Perencanaan Pemulangan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_transfer_ruangan; ?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transfer Ruangan</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_fungsional; ?>" data-toggle="tab" href="#tab_fungsional" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Assesment Fungsional</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $pengkajian_dekubitus; ?>" data-toggle="tab" href="#pengkajian_dekubitus" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pengkajian Dekubitus</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $skala_morse; ?>" data-toggle="tab" href="#skala_morse" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Skala Morse</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?= $tab_ews; ?>" data-toggle="tab" href="#tab_ews" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Lembar Observasi EWS</span></a> </li>
            <?php } ?>
          </ul>
        </div>

        <div class="tab-content">

          <div class="tab-pane p-20 <?= $tab_transfer_ruangan ?>" id="tabTransferRuangan" role="tabpanel">
            <div class="p-20">
              <?php include('survey/transfer_ruangan/transfer_ruangan.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_ews ?>" id="tab_ews" role="tabpanel">
            <div class="p-20">
              <?php include('survey/form_ews/rivews.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_ceklis_pasien_mpp ?>" id="tab_ceklis_pasien_mpp" role="tabpanel">
            <div class="p-20">
              <?php include('survey/ceklis_pasien_mpp/ceklis_pasien_mpp.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_form_rekonsiliasi_obat ?>" id="tab_form_rekonsiliasi_obat" role="tabpanel">
            <div class="p-20">
              <?php include('survey/rekonsiliasi_obat/rekonsiliasi_obat.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_form_pemberian_obat ?>" id="tab_form_pemberian_obat" role="tabpanel">
            <div class="p-20">

              <?php include('survey/daftar_pemberian_obat/pemberian_obat.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_resume_pasien_pulang ?>" id="tab_resume_pasien_pulang" role="tabpanel">
            <div class="p-20">

              <?php include('survey/resume_medis_pulang/resume_medis_pulang.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_form_assesment_gizi ?>" id="tab_form_assesment_gizi" role="tabpanel">
            <div class="p-20">
              <?php include('survey/assesment_gizi/assesment_gizi.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_form_cppt_adime ?>" id="tab_form_cppt_adime" role="tabpanel">
            <div class="p-20">
              <?php include('survey/form_cppt/adime.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_form_serahterima ?>" id="tab_form_serahterima" role="tabpanel">
            <div class="p-20">
              <?php include('survey/catatan_serah_terima/catatan_serah_terima.php');  ?>
            </div>
          </div>
          <div class="tab-pane p-20 <?= $tab_a ?>" id="tabA" role="tabpanel">
            <div class="p-20">
              <?php include('survey/formaevaluasi/formaevaluasi.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_b ?>" id="tabB" role="tabpanel">
            <div class="p-20">
              <?php include('survey/formbevaluasi/formbevaluasi.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_em ?>" id="tabElektromedik" role="tabpanel">
            <div class="p-20">
              <?php include('penunjang/form_em.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_lab ?>" id="tabLaborat" role="tabpanel">
            <div class="p-20">
              <?php include('penunjang/form_lab.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_rad ?>" id="tabRadiologi" role="tabpanel">
            <div class="p-20">
              <?php include('penunjang/form_rad.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_ok ?>" id="tabOperasi" role="tabpanel">
            <div class="p-20">
              <?php include('penunjang/form_ok.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_obat ?>" id="tabObat" role="tabpanel">
            <div class="p-20">
              <?php include('penunjang/form_resep.php');  ?>
            </div>
          </div>

          <div class="tab-pane p-20 <?= $tab_diagnosa ?>" id="tabDiagnosa" role="tabpanel">
            <div class="p-20">
              <button class="btn btn-success" data-toggle="modal" data-target="#diagnosaHistory" onclick="history_diagnosa()"><i class="fa fa-binoculars">&nbsp; Diagnosa Sebelumnya</i> </button>&nbsp;&nbsp;&nbsp;
              <div class="form-group row">
                <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
                <div class="col-9">
                  <input type="text" class="form-control custom-select" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa">
                  <input type="hidden" name="id_diagnosa" id="id_diagnosa">
                </div>
              </div>
              <div class="form-group row">
                <label for="diagnosa_text" class="col-3 col-form-label">Catatan</label>
                <div class="col-9">
                  <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                  <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                  <button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
                </div>
              </div>
              <div class="table-responsive">
                <table id="table_diagnosa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th>Diagnosa</th>
                      <th>Catatan</th>
                      <th class="text-center">Klasifikasi</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div> <!-- table-responsive -->
            </div>
          </div>

          <div class="tab-pane <?= $tab_tindakan; ?>" id="tabTindakan" role="tabpanel">

            <div class="p-20">
              <?php include('rivtindakan.php') ?>
            </div>

          </div>

          <div class="tab-pane <?= $tab_konsultasi; ?>" id="tabKonsultasi" role="tabpanel">

            <div class="p-20">
              <?php include('survey/konsultasi/konsultasi.php') ?>
            </div>

          </div>
          <div class="tab-pane <?= $tab_jawabankonsultasi; ?>" id="tabJawabanKonsultasi" role="tabpanel">

            <div class="p-20">
              <?php include('survey/konsultasi/jawabankonsultasi.php') ?>
            </div>

          </div>

          <div class="tab-pane <?= $tab_jawabankonsultasiRehab; ?>" id="tabJawabanKonsultasiRehab" role="tabpanel">

            <div class="p-20">
              <?php include('survey/konsultasi/jawabankonsultasirehabmedik.php') ?>
            </div>

          </div>


          <div class="tab-pane <?= $tab_fisik ?>" id="tabFisik" role="tabpanel">
            <div class="p-20">
              <?php include('rivformfisik.php') ?>
            </div>
          </div>

          <div class="tab-pane <?= $tab_intruksi_obat ?>" id="tab_intruksi_obat" role="tabpanel">
            <div class="p-20">
              <?php include('survey/intruksi_obat/intruksi_obat.php') ?>
            </div>
          </div>

          <div class="tab-pane <?= $tab_fungsional ?>" id="tab_fungsional" role="tabpanel">
            <div class="p-20">
              <?php include('survey/assesment_fungsional/fungsional.php') ?>
            </div>
          </div>

          <div class="tab-pane <?= $pengkajian_dekubitus ?>" id="pengkajian_dekubitus" role="tabpanel">
            <div class="p-20">
              <?php include('survey/dekubitus/dekubitus.php') ?>
            </div>
          </div>

          <div class="tab-pane <?= $skala_morse ?>" id="skala_morse" role="tabpanel">
            <div class="p-20">
              <?php include('survey/skala_morse/skala_morse.php') ?>
            </div>
          </div>

          <div id="tabAssesmentKeperawatan" class="tab-pane <?= $tab_assesment ?>" role="tabpanel">

            <div class="p-20">
              <?php include('survey\assesment_awal\assesment_awal.php') ?>
            </div>
          </div>


          <div class="tab-pane <?= $tab_catatan_medis_awal; ?>" id="tab_catatan_medis_awal" role="tabpanel">

            <div class="p-20">
              <?php include('survey\catatan_medis_awal\catatan_medis_awal.php') ?>
            </div>

          </div>

          <div id="tabEdukasiPasien" class="tab-pane <?= $tab_edukasi_pasien ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/edukasi_pasien/edukasi_pasien.php'); ?>
            </div>
          </div>
          <div class="tab-pane <?= $tab_form_cppt; ?>" id="tabformcppt" role="tabpanel">

            <div class="p-20">
              <?php include('survey/form_cppt/cppt.php') ?>
            </div>

          </div>

          <div id="tabRencanaPemulangan" class="tab-pane <?= $tab_rencana_pemulangan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/rencana_pemulangan/rencana_pemulangan.php'); ?>
            </div>
          </div>

          <div id="tab_catatan_persalinan" class="tab-pane <?= $tab_catatan_persalinan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/catatan_persalinan/catatan_persalinan.php'); ?>
            </div>
          </div>

          <div id="tab_laporan_persalinan" class="tab-pane <?= $tab_laporan_persalinan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/laporan_persalinan/laporan_persalinan.php'); ?>
            </div>
          </div>



          <div id="tab_form_asuhan_gizi" class="tab-pane <?= $tab_form_asuhan_gizi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asuhangizi/asuhan_gizi.php'); ?>
            </div>
          </div>


          <div id="tab_persetujuan_dokter" class="tab-pane <?= $tab_persetujuan_dokter ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/persetujuan_dokter/persetujuan_dokter.php'); ?>
            </div>
          </div>

          <div id="tab_persetujuan_anestesi" class="tab-pane <?= $tab_persetujuan_anestesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/persetujuan_anestesi/persetujuan_anestesi.php'); ?>
            </div>
          </div>

          <div id="tab_penolakan_kedokteran" class="tab-pane <?= $tab_penolakan_kedokteran ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/penolakan_kedokteran/penolakan_kedokteran.php'); ?>
            </div>
          </div>

          <div id="tab_edukasi_anestesi" class="tab-pane <?= $tab_edukasi_anestesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/edukasi_anestesi/edukasi_anestesi.php'); ?>
            </div>
          </div>


          <div id="tab_site_marking" class="tab-pane <?= $tab_site_marking ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/site_marking/site_marking.php'); ?>
            </div>
          </div>

          <div id="tab_keperawatan_peri_operatif" class="tab-pane <?= $tab_keperawatan_peri_operatif ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asuhan_keperawatan_peri_operatif/asuhan_keperawatan_peri_operatif.php'); ?>
            </div>
          </div>



          <div id="tab_tind_keperawatan" class="tab-pane <?= $tab_tind_keperawatan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/tind_keperawatan/tind_keperawatan.php'); ?>
            </div>
          </div>

          <div id="tab_obs_harian" class="tab-pane <?= $tab_obs_harian ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/lembar_observasi_harian/obs_harian.php'); ?>
            </div>
          </div>

          <div id="tab_pemb_cairan" class="tab-pane <?= $tab_pemb_cairan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pemberian_cairan/pemberian_cairan.php'); ?>
            </div>
          </div>

          <div id="tab_persetujuan_anestesi" class="tab-pane <?= $tab_persetujuan_anestesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/persetujuan_anestesi/persetujuan_anestesi.php'); ?>
            </div>
          </div>

          <div id="tab_penolakan_kedokteran" class="tab-pane <?= $tab_penolakan_kedokteran ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/penolakan_kedokteran/penolakan_kedokteran.php'); ?>
            </div>
          </div>

          <div id="tab_edukasi_anestesi" class="tab-pane <?= $tab_edukasi_anestesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/edukasi_anestesi/edukasi_anestesi.php'); ?>
            </div>
          </div>

          <div id="tab_status_sedasi" class="tab-pane <?= $tab_status_sedasi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/status_sedasi/status_sedasi.php'); ?>
            </div>
          </div>

          <div id="tab_site_marking" class="tab-pane <?= $tab_site_marking ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/site_marking/site_marking.php'); ?>
            </div>
          </div>

          <div id="tab_pembedahan_anestesi_lokal" class="tab-pane <?= $tab_pembedahan_anestesi_lokal ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pembedahan_anestesi_lokal/pembedahan_anestesi_lokal.php'); ?>
            </div>
          </div>

          <div id="tab_laporan_anestesi" class="tab-pane <?= $tab_laporan_anestesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/laporan_anestesi/laporan_anestesi.php'); ?>
            </div>
          </div>

          <div id="tab_survei_lans" class="tab-pane <?= $tab_survei_lans ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/surveilans/surveilans.php'); ?>
            </div>
          </div>



          <div id="tab_pemberian_infus" class="tab-pane <?= $tab_pemberian_infus ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pemberian_infus/pemberian_infus.php'); ?>
            </div>
          </div>

          <div id="tab_gizi_anak" class="tab-pane <?= $tab_gizi_anak ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/gizi_anak/gizi_anak.php'); ?>
            </div>
          </div>

          <div id="tab_persetujuan_dokter" class="tab-pane <?= $tab_persetujuan_dokter ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/persetujuan_dokter/persetujuan_dokter.php'); ?>
            </div>
          </div>

          <div id="tab_pre_operatif" class="tab-pane <?= $tab_pre_operatif ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pre_operatif/pre_operatif.php'); ?>
            </div>
          </div>



          <div id="tab_monitoring_nyeri_anak" class="tab-pane <?= $tab_monitoring_nyeri_anak ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/monitoring_nyeri_anak/monitoring_nyeri_anak.php'); ?>
            </div>
          </div>

          <div id="tab_monitoring_nyeri_tidaksadar" class="tab-pane <?= $tab_monitoring_nyeri_tidaksadar ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/monitoring_tidak_sadar/monitoring_tidak_sadar.php'); ?>
            </div>
          </div>

          <div id="tab_assesment_pra_sedasi" class="tab-pane <?= $tab_assesment_pra_sedasi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/assesment_prasedasi/assesment_prasedasi.php'); ?>
            </div>
          </div>

          <div id="tab_assesment_pra_anastesi" class="tab-pane <?= $tab_assesment_pra_anastesi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/assesment_pra_anestesi/assesment_pra_anastesi.php'); ?>
            </div>
          </div>

          <div id="tab_checklist_persiapan_operasi" class="tab-pane <?= $tab_checklist_persiapan_operasi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/checklist_persiapan_operasi/checklist_persiapan_operasi.php'); ?>
            </div>
          </div>

          <div id="tab_lap_medik_anestesi_lokal" class="tab-pane <?= $tab_lap_medik_anestesi_lokal ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/laporan_medik_anestesi_lokal/laporan_medik_lokal_anastesi.php'); ?>
            </div>
          </div>

          <div id="tab_checklist_keselamatan_operasi" class="tab-pane <?= $tab_checklist_keselamatan_operasi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/checklist_keselamatan_operasi/checklist_keselamatan_pasien_operasi.php'); ?>
            </div>
          </div>

          <div id="tab_keperawatan_peri_operatif" class="tab-pane <?= $tab_keperawatan_peri_operatif ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asuhan_keperawatan_peri_operatif/asuhan_keperawatan_peri_operatif.php'); ?>
            </div>
          </div>




          <div id="tab_medis_neonatus" class="tab-pane <?= $tab_medis_neonatus ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/catatan_medis_neonatus/catatan_medis_awal_neonatus.php'); ?>
            </div>
          </div>

          <div id="tab_asesmen_risiko_jatuh_anak" class="tab-pane <?= $tab_asesmen_risiko_jatuh_anak ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asesmen_risiko_jatuh_anak/assesment_resiko_jatuh_anak.php'); ?>
            </div>
          </div>



          <div id="tab_selisih_tarif" class="tab-pane <?= $tab_selisih_tarif ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/selisih_tarif/selisih_tarif.php'); ?>
            </div>
          </div>


          <div id="tab_pengkajian_rehab_medik" class="tab-pane <?= $tab_pengkajian_rehab_medik ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pengkajian_awal_rehab_medik/pengkajian_rehab_medik/pengkajian_rehab_medik.php'); ?>
            </div>
          </div>

          <div id="tab_pengkajian_rehab_medik_anak" class="tab-pane <?= $tab_pengkajian_rehab_medik_anak ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pengkajian_awal_rehab_medik/pengkajian_rehab_medik_anak/pengkajian_rehab_medik_anak.php'); ?>
            </div>
          </div>

          <div id="tab_surat_rujukan" class="tab-pane <?= $tab_surat_rujukan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/surat_rujukan/surat_rujukan.php'); ?>
            </div>
          </div>

          <div id="tab_pulang_permintaan_sendiri" class="tab-pane <?= $tab_pulang_permintaan_sendiri ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/permintaan_pulang_sendiri/permintaan_pulang_sendiri.php'); ?>
            </div>
          </div>

          <div id="tab_pernyataan_dnr" class="tab-pane <?= $tab_pernyataan_dnr ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/pernyataan_dnr/pernyataan_dnr.php'); ?>
            </div>
          </div>

          <div id="tab_penundaan_pelayanan" class="tab-pane <?= $tab_penundaan_pelayanan ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/penundaan_pelayanan/penundaan_pelayanan.php'); ?>
            </div>
          </div>

          <div id="tab_asesmen_risiko_jatuh_dewasa" class="tab-pane <?= $tab_asesmen_risiko_jatuh_dewasa ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asesmen_risiko_jatuh_dewasa/assesment_resiko_jatuh_dewasa.php'); ?>
            </div>
          </div>

          <div id="tab_asesmen_ulang_nyeri_dewasa" class="tab-pane <?= $tab_asesmen_ulang_nyeri_dewasa ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asesmen_ulang_nyeri_dewasa/monitoring_nyeri_dewasa.php'); ?>
            </div>
          </div>

          <div id="tab_asesmen_resiko_dekubitus" class="tab-pane <?= $tab_asesmen_resiko_dekubitus ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asesmen_resiko_dekubitus/asesmen_resiko_dekubitus.php'); ?>
            </div>
          </div>

          <div id="tab_kebidanan_ginekologi" class="tab-pane <?= $tab_kebidanan_ginekologi ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/asesmen_kebidanan_ginekologi/asesmen_kebidanan_ginekologi.php'); ?>
            </div>
          </div>

          <div id="tab_asesmen_geriatri" class="tab-pane <?= $tab_asesmen_geriatri ?>" role="tabpanel">
            <div class="p-20">
              <?php include('survey/geriatri_ri/geriatri_ri.php'); ?>
            </div>
          </div>

          <!--  -->

        </div>

      </div><!-- p-20 -->
    </div> <!-- tab pane -->
  </div>
  </div>
  </div> <!-- row -->
</section>



<script>
  $(document).ready(function() {
    var dataTable = $('#dataTables-example').DataTable({

    });
  });
</script>
<?php $this->load->view("layout/footer_left"); ?>