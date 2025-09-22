<?php
if ($role_id == 1) {
  $this->load->view("layout/header_left");
} else {
  $this->load->view("layout/header_left");
}
?>
<script type='text/javascript'>
  var site = "<?php echo site_url(); ?>";
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    console.log(site + 'master/mctindakan/download_tarif');
    $('#example').DataTable();
    $(".select2").select2();
    $('input[type="checkcard"].flat-red, input[type="radio"].flat-red').iCheck({
      checkcardClass: 'icheckcard_flat-green',
      radioClass: 'iradio_flat-green'
    });

    // document.getElementById("btn-download").onclick = function(){
    //   window.open(site + "/master/mctindakan/download_tarif",'_blank');
    //   window.open(site + "/master/mctindakan/download_tindakan",'_blank');
    // }
    // document.querySelector(".multipleWindows").addEventListener("click", function(){
    //   window.open(site + "/master/mctindakan/download_tindakan");
    //   window.open(site + "/master/mctindakan/download_tarif"); 
    // });
    $('#insert_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mctindakan/insert_tindakan",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-insert").innerHTML = 'Insert Tindakan';
          $('#myModal').modal('hide');
          document.getElementById("insert_form").reset();
          swal({
              title: "Selesai",
              text: "Data berhasil disimpan",
              type: "success",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            },
            function() {
              window.location.reload();
            });
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-insert").innerHTML = 'Insert Tindakan';
          $('#myModal').modal('hide');
          swal("Error", "Data gagal disimpan.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#delete_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-delete").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mctindakan/soft_delete_tindakan/",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-delete").innerHTML = 'Hapus Tindakan';
          $('#deleteModal').modal('hide');
          document.getElementById("delete_form").reset();
          swal({
              title: "Selesai",
              text: "Data berhasil dihapus",
              type: "success",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            },
            function() {
              window.location.reload();
            });
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-delete").innerHTML = 'Hapus Tindakan';
          $('#deleteModal').modal('hide');
          swal("Error", "Data gagal dihapus.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

  });
  //---------------------------------------------------------
  
  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });
  });

  function openTwoLinks() {
        // Open the first link in a new tab
        window.open(site + 'master/mctindakan/download_tarif', '_blank');

        // Open the second link in the same tab
        window.location.href = site + 'master/mctindakan/download_tindakan';
    }

    function uploadTarifTindakan(){
        var fileTarifTindakakn; 
        fileTarifTindakan  = document.getElementById("tarifTindakanFile").value;
        $.ajax({
		      url:"<?php echo base_url(); ?>tarif/cuploadtindakan/upload_tarif_tindakan_excel_file/",
		      method:"POST",
		      data: {
                "tarifTindakanFile" : fileTarifTindakan,
              },
		      processData:false,
		      contentType:false,
		      cache:false,
		      success:function(data){
		      	console.log(data);
		        // loadData();
		      }
		  })
    }

  function total_vipa() {
    var jasa_rs_vipa = parseInt($('#jasa_rs_vipa').val()) || 0;
    var jasa_paramedis_vipa = parseInt($('#jasa_paramedis_vipa').val()) || 0;
    var jasa_anastesi_vipa = parseInt($('#jasa_anastesi_vipa').val()) || 0;
    var jasa_asistensi_vipa = parseInt($('#jasa_asistensi_vipa').val()) || 0;
    var jasa_dr_vipa = parseInt($('#jasa_dr_vipa').val()) || 0;
    var alkes_kelas_vipa = parseInt($('#alkes_kelas_vipa').val()) || 0;
    // var iks_vipa = parseInt($('#tarif_iks_vipa').val()) || 0;
    // var bpjs_vipa = parseInt($('#tarif_bpjs_vipa').val()) || 0;
    var total_vipa = jasa_rs_vipa + jasa_paramedis_vipa + jasa_anastesi_vipa + jasa_asistensi_vipa + jasa_dr_vipa + alkes_kelas_vipa;
    $('#kelas_vipa').val(total_vipa);
  }

  function total_vipb() {
    var jasa_rs_vipb = parseInt($('#jasa_rs_vipb').val()) || 0;
    var jasa_paramedis_vipb = parseInt($('#jasa_paramedis_vipb').val()) || 0;
    var jasa_anastesi_vipb = parseInt($('#jasa_anastesi_vipb').val()) || 0;
    var jasa_asistensi_vipb = parseInt($('#jasa_asistensi_vipb').val()) || 0;
    var jasa_dr_vipb = parseInt($('#jasa_dr_vipb').val()) || 0;
    var alkes_kelas_vipb = parseInt($('#alkes_kelas_vipb').val()) || 0;
    // var iks_vipb = parseInt($('#tarif_iks_vipb').val()) || 0;
    // var bpjs_vipb = parseInt($('#tarif_bpjs_vipb').val()) || 0;
    var total_vipb = jasa_rs_vipb + jasa_paramedis_vipb + jasa_anastesi_vipb + jasa_asistensi_vipb + jasa_dr_vipb + alkes_kelas_vipb;
    $('#kelas_vipb').val(total_vipb);
  }

  function total_3a() {
    var jasa_rs_3a = parseInt($('#jasa_rs_3a').val()) || 0;
    var jasa_paramedis_3a = parseInt($('#jasa_paramedis_3a').val()) || 0;
    var jasa_anastesi_3a = parseInt($('#jasa_anastesi_3a').val()) || 0;
    var jasa_asistensi_3a = parseInt($('#jasa_asistensi_3a').val()) || 0;
    var jasa_dr_3a = parseInt($('#jasa_dr_3a').val()) || 0;
    var alkes_kelas_3a = parseInt($('#alkes_kelas_3a').val()) || 0;
    // var iks_3a = parseInt($('#tarif_iks_3a').val()) || 0;
    // var bpjs_3a = parseInt($('#tarif_bpjs_3a').val()) || 0;
    var total_3a = jasa_rs_3a + jasa_paramedis_3a + jasa_anastesi_3a + jasa_asistensi_3a + jasa_dr_3a + alkes_kelas_3a;
    $('#kelas_3a').val(total_3a);
  }

  function total_1() {
    var jasa_rs_1 = parseInt($('#jasa_rs_1').val()) || 0;
    var jasa_paramedis_1 = parseInt($('#jasa_paramedis_1').val()) || 0;
    var jasa_anastesi_1 = parseInt($('#jasa_anastesi_1').val()) || 0;
    var jasa_asistensi_1 = parseInt($('#jasa_asistensi_1').val()) || 0;
    var jasa_dr_1 = parseInt($('#jasa_dr_1').val()) || 0;
    var alkes_kelas_1 = parseInt($('#alkes_kelas_1').val()) || 0;
    // var iks_1 = parseInt($('#tarif_iks_1').val()) || 0;
    // var bpjs_1 = parseInt($('#tarif_bpjs_1').val()) || 0;
    var total_1 = jasa_rs_1 + jasa_paramedis_1 + jasa_anastesi_1 + jasa_asistensi_1 + jasa_dr_1 + alkes_kelas_1;
    $('#kelas_1').val(total_1);
  }

  function total_2() {
    var jasa_rs_2 = parseInt($('#jasa_rs_2').val()) || 0;
    var jasa_paramedis_2 = parseInt($('#jasa_paramedis_2').val()) || 0;
    var jasa_anastesi_2 = parseInt($('#jasa_anastesi_2').val()) || 0;
    var jasa_asistensi_2 = parseInt($('#jasa_asistensi_2').val()) || 0;
    var jasa_dr_2 = parseInt($('#jasa_dr_2').val()) || 0;
    var alkes_kelas_2 = parseInt($('#alkes_kelas_2').val()) || 0;
    // var iks_2 = parseInt($('#tarif_iks_2').val()) || 0;
    // var bpjs_2 = parseInt($('#tarif_bpjs_2').val()) || 0;
    var total_2 = jasa_rs_2 + jasa_paramedis_2 + jasa_anastesi_2 + jasa_asistensi_2 + jasa_dr_2 + alkes_kelas_2;
    $('#kelas_2').val(total_2);
  }

  function total_3() {
    var jasa_rs_3 = parseInt($('#jasa_rs_3').val()) || 0;
    var jasa_paramedis_3 = parseInt($('#jasa_paramedis_3').val()) || 0;
    var jasa_anastesi_3 = parseInt($('#jasa_anastesi_3').val()) || 0;
    var jasa_asistensi_3 = parseInt($('#jasa_asistensi_3').val()) || 0;
    var jasa_dr_3 = parseInt($('#jasa_dr_3').val()) || 0;
    var alkes_kelas_3 = parseInt($('#alkes_kelas_3').val()) || 0;
    // var iks_3 = parseInt($('#tarif_iks_3').val()) || 0;
    // var bpjs_3 = parseInt($('#tarif_bpjs_3').val()) || 0;
    var total_3 = jasa_rs_3 + jasa_paramedis_3 + jasa_anastesi_3 + jasa_asistensi_3 + jasa_dr_3 + alkes_kelas_3;
    $('#kelas_3').val(total_3);
  }

  function total_nr() {
    var jasa_rs_nr = parseInt($('#jasa_rs_nr').val()) || 0;
    var jasa_paramedis_nr = parseInt($('#jasa_paramedis_nr').val()) || 0;
    var jasa_anastesi_nr = parseInt($('#jasa_anastesi_nr').val()) || 0;
    var jasa_asistensi_nr = parseInt($('#jasa_asistensi_nr').val()) || 0;
    var jasa_dr_nr = parseInt($('#jasa_dr_nr').val()) || 0;
    var alkes_kelas_nr = parseInt($('#alkes_kelas_nr').val()) || 0;
    // var iks_nr = parseInt($('#tarif_iks_nr').val()) || 0;
    // var bpjs_nr = parseInt($('#tarif_bpjs_nr').val()) || 0;
    var total_nr = jasa_rs_nr + jasa_paramedis_nr + jasa_anastesi_nr + jasa_asistensi_nr + jasa_dr_nr + alkes_kelas_nr;
    $('#kelas_nr').val(total_nr);
  }

  function edit_total_3a() {
    var jasa_rs_3a = parseInt($('#edit_jasa_rs_3a').val()) || 0;
    var jasa_paramedis_3a = parseInt($('#edit_jasa_paramedis_3a').val()) || 0;
    var jasa_anastesi_3a = parseInt($('#edit_jasa_anastesi_3a').val()) || 0;
    var jasa_asistensi_3a = parseInt($('#edit_jasa_asistensi_3a').val()) || 0;
    var jasa_dr_3a = parseInt($('#edit_jasa_dr_3a').val()) || 0;
    var alkes_kelas_3a = parseInt($('#edit_alkes_kelas_3a').val()) || 0;
    // var jasa_bpjs_3a = parseInt($('#edit_tarif_bpjs_3a').val()) || 0;
    // var jasa_iks_3a = parseInt($('#edit_tarif_iks_3a').val()) || 0;
    var total_3a = jasa_rs_3a + jasa_paramedis_3a + jasa_anastesi_3a + jasa_asistensi_3a + jasa_dr_3a + alkes_kelas_3a;
    $('#edit_kelas_3a').val(total_3a);
  }

  function edit_total_vipa() {
    var jasa_rs_vipa = parseInt($('#edit_jasa_rs_vipa').val()) || 0;
    var jasa_paramedis_vipa = parseInt($('#edit_jasa_paramedis_vipa').val()) || 0;
    var jasa_anastesi_vipa = parseInt($('#edit_jasa_anastesi_vipa').val()) || 0;
    var jasa_asistensi_vipa = parseInt($('#edit_jasa_asistensi_vipa').val()) || 0;
    // var jasa_bpjs_vipa = parseInt($('#edit_tarif_bpjs_vipa').val()) || 0;
    // var jasa_iks_vipa = parseInt($('#edit_tarif_iks_vipa').val()) || 0;
    var jasa_dr_vipa = parseInt($('#edit_jasa_dr_vipa').val()) || 0;
    var alkes_kelas_vipa = parseInt($('#edit_alkes_kelas_vipa').val()) || 0;
    var total_vipa = jasa_rs_vipa + jasa_paramedis_vipa + jasa_anastesi_vipa + jasa_asistensi_vipa + jasa_dr_vipa + alkes_kelas_vipa;
    $('#edit_kelas_vipa').val(total_vipa);
  }

  function edit_total_vipb() {
    var jasa_rs_vipb = parseInt($('#edit_jasa_rs_vipb').val()) || 0;
    var jasa_paramedis_vipb = parseInt($('#edit_jasa_paramedis_vipb').val()) || 0;
    var jasa_anastesi_vipb = parseInt($('#edit_jasa_anastesi_vipb').val()) || 0;
    var jasa_asistensi_vipb = parseInt($('#edit_jasa_asistensi_vipb').val()) || 0;
    var jasa_dr_vipb = parseInt($('#edit_jasa_dr_vipb').val()) || 0;
    var alkes_kelas_vipb = parseInt($('#edit_alkes_kelas_vipb').val()) || 0;
    // var jasa_bpjs_vipb = parseInt($('#edit_tarif_bpjs_vipb').val()) || 0;
    // var jasa_iks_vipb = parseInt($('#edit_tarif_iks_vipb').val()) || 0;
    var total_vipb = jasa_rs_vipb + jasa_paramedis_vipb + jasa_anastesi_vipb + jasa_asistensi_vipb + jasa_dr_vipb + alkes_kelas_vipb;
    $('#edit_kelas_vipb').val(total_vipb);
  }

  function edit_total_1() {
    var jasa_rs_1 = parseInt($('#edit_jasa_rs_1').val()) || 0;
    var jasa_paramedis_1 = parseInt($('#edit_jasa_paramedis_1').val()) || 0;
    var jasa_anastesi_1 = parseInt($('#edit_jasa_anastesi_1').val()) || 0;
    var jasa_asistensi_1 = parseInt($('#edit_jasa_asistensi_1').val()) || 0;
    var jasa_dr_1 = parseInt($('#edit_jasa_dr_1').val()) || 0;
    var alkes_kelas_1 = parseInt($('#edit_alkes_kelas_1').val()) || 0;
    // var jasa_bpjs_1 = parseInt($('#edit_tarif_bpjs_1').val()) || 0;
    // var jasa_iks_1 = parseInt($('#edit_tarif_iks_1').val()) || 0;
    var total_1 = jasa_rs_1 + jasa_paramedis_1 + jasa_anastesi_1 + jasa_asistensi_1 + jasa_dr_1 + alkes_kelas_1;
    $('#edit_kelas_1').val(total_1);
  }

  function edit_total_2() {
    var jasa_rs_2 = parseInt($('#edit_jasa_rs_2').val()) || 0;
    var jasa_paramedis_2 = parseInt($('#edit_jasa_paramedis_2').val()) || 0;
    var jasa_anastesi_2 = parseInt($('#edit_jasa_anastesi_2').val()) || 0;
    var jasa_asistensi_2 = parseInt($('#edit_jasa_asistensi_2').val()) || 0;
    var jasa_dr_2 = parseInt($('#edit_jasa_dr_2').val()) || 0;
    var alkes_kelas_2 = parseInt($('#edit_alkes_kelas_2').val()) || 0;
    // var jasa_bpjs_2 = parseInt($('#edit_tarif_bpjs_2').val()) || 0;
    // var jasa_iks_2 = parseInt($('#edit_tarif_iks_2').val()) || 0;
    var total_2 = jasa_rs_2 + jasa_paramedis_2 + jasa_anastesi_2 + jasa_asistensi_2 + jasa_dr_2 + alkes_kelas_2;
    $('#edit_kelas_2').val(total_2);
  }

  function edit_total_3() {
    var jasa_rs_3 = parseInt($('#edit_jasa_rs_3').val()) || 0;
    var jasa_paramedis_3 = parseInt($('#edit_jasa_paramedis_3').val()) || 0;
    var jasa_anastesi_3 = parseInt($('#edit_jasa_anastesi_3').val()) || 0;
    var jasa_asistensi_3 = parseInt($('#edit_jasa_asistensi_3').val()) || 0;
    var jasa_dr_3 = parseInt($('#edit_jasa_dr_3').val()) || 0;
    var alkes_kelas_3 = parseInt($('#edit_alkes_kelas_3').val()) || 0;
    // var jasa_bpjs_3 = parseInt($('#edit_tarif_bpjs_3').val()) || 0;
    // var jasa_iks_3 = parseInt($('#edit_tarif_iks_3').val()) || 0;
    var total_3 = jasa_rs_3 + jasa_paramedis_3 + jasa_anastesi_3 + jasa_asistensi_3 + jasa_dr_3 + alkes_kelas_3;
    $('#edit_kelas_3').val(total_3);
  }

  function edit_total_nr() {
    var jasa_rs_nr = parseInt($('#edit_jasa_rs_nr').val()) || 0;
    var jasa_paramedis_nr = parseInt($('#edit_jasa_paramedis_nr').val()) || 0;
    var jasa_anastesi_nr = parseInt($('#edit_jasa_anastesi_nr').val()) || 0;
    var jasa_asistensi_nr = parseInt($('#edit_jasa_asistensi_nr').val()) || 0;
    var jasa_dr_nr = parseInt($('#edit_jasa_dr_nr').val()) || 0;
    var alkes_kelas_nr = parseInt($('#edit_alkes_kelas_nr').val()) || 0;
    // var jasa_bpjs_nr = parseInt($('#edit_tarif_bpjs_nr').val()) || 0;
    // var jasa_iks_nr = parseInt($('#edit_tarif_iks_nr').val()) || 0;
    var total_nr = jasa_rs_nr + jasa_paramedis_nr + jasa_anastesi_nr + jasa_asistensi_nr + jasa_dr_nr + alkes_kelas_nr;
    $('#edit_kelas_nr').val(total_nr);
  }

  function edit_tindakan(idtindakan) {
    $('#edit_idtindakan').val("");
    $('#edit_idtindakan_hide').val("");
    $('#edit_nmtindakan').val("");

    $('#edit_idkel_tind').val("");
    $('#edit_sub_kelompok').val("");
    $('#edit_kategori').val("");
    $('#edit_satuan').val("");

    $('#edit_jasa_rs_3a').val("");
    $('#edit_jasa_paramedis_3a').val("");
    $('#edit_jasa_anastesi_3a').val("");
    $('#edit_jasa_asistensi_3a').val("");
    $('#edit_jasa_dr_3a').val("");
    $('#edit_tarif_iks_3a').val("");
    $('#edit_tarif_bpjs_3a').val("");
    $('#edit_jasa_alkes_kelas_3a').val("");
    $('#edit_kelas_3a').val("");

    $('#edit_jasa_rs_vipa').val("");
    $('#edit_jasa_paramedis_vipa').val("");
    $('#edit_jasa_anastesi_vipa').val("");
    $('#edit_jasa_asistensi_vipa').val("");
    $('#edit_jasa_dr_vipa').val("");
    $('#edit_tarif_iks_vipa').val("");
    $('#edit_tarif_bpjs_vipa').val("");
    $('#edit_jasa_alkes_kelas_vipa').val("");
    $('#edit_kelas_vipa').val("");

    $('#edit_jasa_rs_vipb').val("");
    $('#edit_jasa_paramedis_vipb').val("");
    $('#edit_jasa_anastesi_vipb').val("");
    $('#edit_jasa_asistensi_vipb').val("");
    $('#edit_jasa_dr_vipb').val("");
    $('#edit_tarif_iks_vipb').val("");
    $('#edit_tarif_bpjs_vipb').val("");
    $('#edit_jasa_alkes_kelas_vipb').val("");
    $('#edit_kelas_vipb').val("");

    $('#edit_jasa_rs_1').val("");
    $('#edit_jasa_paramedis_1').val("");
    $('#edit_jasa_anastesi_1').val("");
    $('#edit_jasa_asistensi_1').val("");
    $('#edit_jasa_dr_1').val("");
    $('#edit_tarif_iks_1').val("");
    $('#edit_tarif_bpjs_1').val("");
    $('#edit_jasa_alkes_kelas_1').val("");
    $('#edit_kelas_1').val("");

    $('#edit_jasa_rs_2').val("");
    $('#edit_jasa_paramedis_2').val("");
    $('#edit_jasa_anastesi_2').val("");
    $('#edit_jasa_asistensi_2').val("");
    $('#edit_jasa_dr_2').val("");
    $('#edit_tarif_iks_2').val("");
    $('#edit_tarif_bpjs_2').val("");
    $('#edit_jasa_alkes_kelas_2').val("");
    $('#edit_kelas_2').val("");

    $('#edit_jasa_rs_3').val("");
    $('#edit_jasa_paramedis_3').val("");
    $('#edit_jasa_anastesi_3').val("");
    $('#edit_jasa_asistensi_3').val("");
    $('#edit_jasa_dr_3').val("");
    $('#edit_tarif_iks_3').val("");
    $('#edit_tarif_bpjs_3').val("");
    $('#edit_jasa_alkes_kelas_3').val("");
    $('#edit_kelas_3').val("");

    $('#edit_jasa_rs_nr').val("");
    $('#edit_jasa_paramedis_nr').val("");
    $('#edit_jasa_anastesi_nr').val("");
    $('#edit_jasa_asistensi_nr').val("");
    $('#edit_jasa_dr_nr').val("");
    $('#edit_tarif_iks_nr').val("");
    $('#edit_tarif_bpjs_nr').val("");
    $('#edit_jasa_alkes_kelas_nr').val("");
    $('#edit_kelas_nr').val("");

    // $('#edit_kelas_3b').val("");
    // $('#edit_alkes_kelas_3b').val("");
    // $('#edit_paket').iCheck('uncheck');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('master/mctindakan/get_data_edit_tindakan') ?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data) {
        // console.log(data[0].pake);
        $('#edit_idtindakan').val(data[0].idtindakan);
        $('#edit_idtindakan_hide').val(data[0].idtindakan);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
        $('#edit_idkel_tind').val(data[0].id_kel+'@'+data[0].kel_tindakan);
        $('#edit_idkel_tind').trigger('change');
        $('#edit_sub_kelompok').val(data[0].id_sub_kelompok+'@'+data[0].sub_kelompok);
        $('#edit_sub_kelompok').trigger('change');
        $('#edit_kategori').val(data[0].id_kategori+'@'+data[0].kategori);
        $('#edit_kategori').trigger('change');
        $('#edit_satuan').val(data[0].id_satuan+'@'+data[0].satuan);
        $('#edit_satuan').trigger('change');
        if (data) {
         
          for (var i = 0; i < 7; i++) {
            // console.log(data[i].kelas == "VIP");
            if (data[i].kelas == "VVIP") {
              $('#edit_jasa_rs_vipa').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_vipa').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_vipa').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_vipa').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_vipa').val(data[i].jasa_dr);
              $('#edit_tarif_iks_vipa').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_vipa').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_vipa').val(data[i].tarif_alkes);
              $('#edit_kelas_vipa').val(data[i].total_tarif);
            }
            if (data[i].kelas == "VIP") {
              $('#edit_jasa_rs_vipb').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_vipb').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_vipb').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_vipb').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_vipb').val(data[i].jasa_dr);
              $('#edit_tarif_iks_vipb').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_vipb').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_vipb').val(data[i].tarif_alkes);
              $('#edit_kelas_vipb').val(data[i].total_tarif);
            }
            if (data[i].kelas == "NK") {
              $('#edit_jasa_rs_3a').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_3a').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_3a').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_3a').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_3a').val(data[i].jasa_dr);
              $('#edit_tarif_iks_3a').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_3a').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_3a').val(data[i].tarif_alkes);
              $('#edit_kelas_3a').val(data[i].total_tarif);
            }

            if (data[i].kelas == "I") {
              $('#edit_jasa_rs_1').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_1').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_1').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_1').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_1').val(data[i].jasa_dr);
              $('#edit_tarif_iks_1').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_1').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_1').val(data[i].tarif_alkes);
              $('#edit_kelas_1').val(data[i].total_tarif);
            }
            if (data[i].kelas == "II") {
              $('#edit_jasa_rs_2').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_2').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_2').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_2').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_2').val(data[i].jasa_dr);
              $('#edit_tarif_iks_2').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_2').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_2').val(data[i].tarif_alkes);
              $('#edit_kelas_2').val(data[i].total_tarif);
            }
            if (data[i].kelas == "III") {
              $('#edit_jasa_rs_3').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_3').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_3').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_3').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_3').val(data[i].jasa_dr);
              $('#edit_tarif_iks_3').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_3').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_3').val(data[i].tarif_alkes);
              $('#edit_kelas_3').val(data[i].total_tarif);
            }
            // console.log(data[i].kelas);
            // console.log(data[i].kelas=="NR");
            if (data[i].kelas == "NR") {
              $('#edit_jasa_rs_nr').val(data[i].jasa_rs);
              $('#edit_jasa_paramedis_nr').val(data[i].jasa_paramedis);
              $('#edit_jasa_anastesi_nr').val(data[i].jasa_anastesi);
              $('#edit_jasa_asistensi_nr').val(data[i].jasa_asistensi);
              $('#edit_jasa_dr_nr').val(data[i].jasa_dr);
              $('#edit_tarif_iks_nr').val(data[i].tarif_iks);
              $('#edit_tarif_bpjs_nr').val(data[i].tarif_bpjs);
              $('#edit_alkes_kelas_nr').val(data[i].tarif_alkes);
              $('#edit_kelas_nr').val(data[i].total_tarif);
            }

          }
        }
      },
      error: function() {
        alert("error");
      }
    });
  }

  function download_excel() {
    window.location.href = "<?php echo base_url('master/mctindakan/export_excel') ?>";
  }

  function edit()
  {
    $('#btnEdit').text('saving...'); //change button text
    $('#btnEdit').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('master/mctindakan/edit_tindakan')?>";  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            $('#editModal').modal('hide');
            swal("Sukses","berhasil diperbarui.", "success");
            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 
          
            window.location.reload();

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#editModal').modal('hide');
            // alert('Error adding / update data');
            swal("Error","Data gagal diperbarui.", "error"); 
            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

        }
    });
  }

  function delete_tindakan(id) {
    $('#delete_id').val(id);
  }

  function aktifTindakan(idtindakan) {
    if (confirm('Yakin Mengaktifkan Diagnosa ini?')) {
      $('#modalLoading').modal('show');
      $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>master/mctindakan/active_tindakan/" + idtindakan,
        data: {
          idtindakan: idtindakan
        },
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          $('#modalLoading').modal('hide');
          swal({
              title: "Selesai",
              text: "Data berhasil diaktifkan",
              type: "success",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            },
            function() {
              window.location.reload();
            });
        },
        error: function() {
          swal("Error", "Data gagal diaktifkan.", "error");
          alert("error");
        }
      });
    }
  }

function nonAktifTindakan(idtindakan) {
  if (confirm('Yakin Ingin Mengnonaktifkan Diagnosa ini?')) {
    $('#modalLoading').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url(); ?>master/mctindakan/nonactive_tindakan/" + idtindakan,
      data: {
        idtindakan: idtindakan
      },
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        $('#modalLoading').modal('hide');
        swal({
          title: "Selesai",
          text: "Data berhasil diaktifkan",
          type: "success",
          showCancelButton: false,
          closeOnConfirm: false,
          showLoaderOnConfirm: true
        },
        function() {
          window.location.reload();
        });
      },
      error: function() {
        swal("Error", "Data gagal diaktifkan.", "error");
        alert("error");
      }
    });
  }
}

  function buatajax() {
    if (window.XMLHttpRequest) {
      return new XMLHttpRequest();
    }
    if (window.ActiveXObject) {
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
  }

  function ajaxtindakan(id_poli) {
    var id = id_poli.substr(0, 4);
    var pokpoli = id_poli.substr(4, 4);
    ajaxku = buatajax();
    var url = "<?php echo site_url('master/mctindakan/data_tindakan'); ?>";
    url = url + "/" + id_poli;
    ajaxku.onreadystatechange = stateChangedDokter;
    ajaxku.open("GET", url, true);
    ajaxku.send(null);

  }

  function stateChangedDokter() {
    var data;
    if (ajaxku.readyState == 4) {
      data = ajaxku.responseText;
      console.log(data);
      if (data.length >= 0) {
        document.getElementById("id_tindakan").innerHTML = data;
      }
      /*else{
            document.getElementById("id_dokter").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
            }*/
    }
  }
</script>
<section class="content-header">
  <?php
  echo $this->session->flashdata('success_msg');
  echo $this->session->flashdata('success_msg_jenistindakan');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h3 class="card-title text-white">DAFTAR TINDAKAN</h3>
        </div>
        <div class="card-block ">
          <!-- <?php echo form_open('master/mctindakan/insert_tindakan'); ?> -->
          <div class="col-md-12">
          <form method="POST" id="insert_form" class="form-horizontal">
            <div class="form-group row">
              <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tindakan</button>
                    <!-- <button class="btn btn-primary" type="submit" onClick="download_excel()">Download Excel</button> -->
                  </span>
                </div><!-- /input-group -->
              </div><!-- /col-lg-6 -->
              <div class="col-sm-3" align="right">
                <div class="input-group">
                  <span class="input-group-btn">
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tindakan</button> -->
                  </span>
                </div><!-- /input-group -->
              </div><!-- /col-lg-6 -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" style="max-width: 100%;">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Tindakan</h4>
                  </div>
                  <div class="modal-body">
                    <!-- <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Jenis Tindakan</p>
                    <div class="col-sm-6">
                      <select name="" id="" class="form-control select2" style="width: 100%;" onchange="ajaxtindakan(this.value)">
                        <option value="">--Pilih--</option>
                        <option value="semua-semua">Semua</option>
                        <option value="admin-1B">Administratif</option>
                        <option value="ruang-1A">Ruangan</option>
                        <option value="ird-BA">Rawat Darurat</option>
                        <option value="penunjang-E">Elektromedik</option>
                        <option value="penunjang-H">Laboratorium</option>
                        <option value="penunjang-D">Operasi</option>
                        <option value="penunjang-L">Radiologi</option>
                        <?php foreach ($poli as $key) { ?>
                          <option value="poli-<?php echo $key->id_poli; ?>"><?php echo $key->nm_poli ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div> -->
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                      <div class="col-sm-4">
                        <!-- <select name="idtindakan" id="id_tindakan" class="form-control select2" style="width: 100%;" required></select> -->
                        <input type="text" class="form-control" name="idtindakan" id="idtindakan" maxlength="7" required>
                      </div>
                      <div class="col-sm-4">
                        <input type="checkbox" class="filled-in" value="1" name="paket" id="paket" />
                        <label for="paket">Tarif Paket</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="nmtindakan" id="nmtindakan" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="idkel_tind" id="idkel_tind">
                          <option value="">-- kelompok tindakan --</option>
                          <?php
                          foreach ($kel_tindakan as $row1) {
                            echo '<option value="'.$row1->id_keltind.'@'.$row1->kel_tindakan.'">'.$row1->kel_tindakan.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Sub Kelompok</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="sub_kelompok" id="sub_kelompok">
                          <option value="">-- sub kelompok --</option>
                          <?php
                          foreach ($subkelompok as $row) {
                            echo '<option value="'.$row->id_subkelompok.'@'.$row->nm_subkelompok.'">' . $row->nm_subkelompok . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kategori</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="kategori" id="kategori">
                          <option value="">-- kategori --</option>
                          <?php
                          foreach ($kategori as $row2) {
                            echo '<option value="'.$row2->id_kategori.'@'.$row2->kategori.'">' . $row2->kategori . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Satuan Tindakan</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="satuan" id="satuan">
                          <option value="">-- satuan --</option>
                          <?php
                          foreach ($satuan as $row3) {
                            echo '<option value="'.$row3->id.'@'.$row3->nm_satuan.'">' . $row3->nm_satuan . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama"></p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS RS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS PM</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Anastesi</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Asisten</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Operator</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif IKS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif BPJS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">BMHP</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Total</p>
                    </div>


                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">EKSEKUTIF</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="jasa_rs_vipa" id="jasa_rs_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Paramedis VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="jasa_paramedis_vipa" id="jasa_paramedis_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Anastesi VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="jasa_anastesi_vipa" id="jasa_anastesi_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Asisten VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="jasa_asistensi_vipa" id="jasa_asistensi_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Dokter VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="jasa_dr_vipa" id="jasa_dr_vipa" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_vipa" id="tarif_iks_vipa" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_vipa" id="tarif_bpjs_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_vipa()" name="alkes_kelas_vipa" id="alkes_kelas_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif Total VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_vipa" id="kelas_vipa" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">VIP</p>
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="jasa_rs_vipb" id="jasa_rs_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Paramedis VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="jasa_paramedis_vipb" id="jasa_paramedis_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Anastesi VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="jasa_anastesi_vipb" id="jasa_anastesi_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Asisten VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="jasa_asistensi_vipb" id="jasa_asistensi_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Dokter VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="jasa_dr_vipb" id="jasa_dr_vipb" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_vipb" id="tarif_iks_vipb" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_vipb" id="tarif_bpjs_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" onkeyup="total_vipb()" class="form-control" name="alkes_kelas_vipb" id="alkes_kelas_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_alamat">Tarif Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_vipb" id="kelas_vipb" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">I</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="jasa_rs_1" id="jasa_rs_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="jasa_paramedis_1" id="jasa_paramedis_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="jasa_anastesi_1" id="jasa_anastesi_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="jasa_asistensi_1" id="jasa_asistensi_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="jasa_dr_1" id="jasa_dr_1" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_1" id="tarif_iks_1" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_1" id="tarif_bpjs_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_1()" name="alkes_kelas_1" id="alkes_kelas_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_1" id="kelas_1" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">II</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="jasa_rs_2" id="jasa_rs_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="jasa_paramedis_2" id="jasa_paramedis_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="jasa_anastesi_2" id="jasa_anastesi_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="jasa_asistensi_2" id="jasa_asistensi_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="jasa_dr_2" id="jasa_dr_2" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_2" id="tarif_iks_2" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_2" id="tarif_bpjs_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_2()" name="alkes_kelas_2" id="alkes_kelas_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_2" id="kelas_2" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">III</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="jasa_rs_3" id="jasa_rs_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="jasa_paramedis_3" id="jasa_paramedis_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="jasa_anastesi_3" id="jasa_anastesi_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="jasa_asistensi_3" id="jasa_asistensi_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="jasa_dr_3" id="jasa_dr_3" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_3" id="tarif_iks_3" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_3" id="tarif_bpjs_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3()" name="alkes_kelas_3" id="alkes_kelas_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_3" id="kelas_3" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">NK/IGD/IRJ</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="jasa_rs_3a" id="jasa_rs_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Paramedis Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="jasa_paramedis_3a" id="jasa_paramedis_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Anastesi Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="jasa_anastesi_3a" id="jasa_anastesi_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Asisten Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="jasa_asistensi_3a" id="jasa_asistensi_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Jasa Dokter Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="jasa_dr_3a" id="jasa_dr_3a" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_3a" id="tarif_iks_3a" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_3a" id="tarif_bpjs_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_3a()" name="alkes_kelas_3a" id="alkes_kelas_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_3a" id="kelas_3a" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">NR</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="jasa_rs_nr" id="jasa_rs_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="jasa_paramedis_nr" id="jasa_paramedis_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="jasa_anastesi_nr" id="jasa_anastesi_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="jasa_asistensi_nr" id="jasa_asistensi_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="jasa_dr_nr" id="jasa_dr_nr" min="0">
                      </div>
                      <!-- tarif iks -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_iks_nr" id="tarif_iks_nr" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="tarif_bpjs_nr" id="tarif_bpjs_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="total_nr()" name="alkes_kelas_nr" id="alkes_kelas_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="kelas_nr" id="kelas_nr" min="0">
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-insert">Insert Tindakan</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalUpload"><i class="fa fa-plus"></i> Upload Tarif Excel</button>

          </div>
          <!-- <?php echo form_close(); ?> -->
          <hr>
          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $i = 1;
              foreach ($tindakan as $row) {
              ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row->idtindakan; ?></td>
                  <td><?php echo $row->nmtindakan; ?></td>
                  <?php if ($row->deleted == 0) : ?>
                    <td>ACTIVE</td>
                  <?php else : ?>
                    <td>NON-ACTIVE</td>
                  <?php endif; ?>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onClick="edit_tindakan('<?php echo $row->idtindakan; ?>')"><i class="fa fa-edit"></i></button>
                    <!-- <a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url('master/mctindakan/delete_tindakan/' . $row->idtindakan) ?>" ><i class="fa fa-trash"></i></a> -->
                    <!-- <a type="button" class="btn btn-danger btn-sm" href="<?php echo base_url('master/mctindakan/soft_delete_tindakan/' . $row->idtindakan) ?>" ><i class="fa fa-trash"></i></a> -->
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onClick="delete_tindakan('<?php echo $row->idtindakan; ?>')"><i class="fa fa-trash"></i></button>
                    <?php if($row->deleted == 0) { ?>
                      <button type="button" class="btn btn-success btn-sm" onclick="nonAktifTindakan('<?php echo $row->idtindakan; ?>')"><i class="fa fa-close"></i></button>
                    <?php } else {?>
                      <button type="button" class="btn btn-success btn-sm" onclick="aktifTindakan('<?php echo $row->idtindakan; ?>')"><i class="fa fa-check"></i></button>
                    <?php } ?>  
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          
          <!-- <button onclick="openTwoLinks()" class="btn btn-success">Excel</button> -->
          <!-- <a href="<?php echo base_url('master/mctindakan/download_tindakan');?>" target="_blank" class="btn btn-success">Excel Tindakan</a>-->
          <a href="<?php echo base_url('master/mctindakan/excel_tarif_tindakan');?>" class="btn btn-success" target="_blank">Excel</a>
          <!-- eDIT Modal -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" style="max-width: 95%;">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Tindakan</h4>
                </div>
                <div class="modal-body">
                  <form action="#" id="formedit" class="form-horizontal">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="edit_idtindakan" id="edit_idtindakan">
                        <input type="hidden" class="form-control" name="edit_idtindakan_hide" id="edit_idtindakan_hide">
                      </div>
                      <div class="col-sm-4">
                        <input type="checkbox" class="filled-in" value="1" name="edit_paket" id="edit_paket">
                        <label for="edit_paket">Tarif Paket</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="edit_idkel_tind" id="edit_idkel_tind">
                          <option value="">-- kelompok tindakan --</option>
                          <?php
                          foreach ($kel_tindakan as $row1) {
                            echo '<option value="'.$row1->id_keltind.'@'.$row1->kel_tindakan.'">'.$row1->kel_tindakan.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Sub Kelompok</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="edit_sub_kelompok" id="edit_sub_kelompok">
                          <option value="">-- sub kelompok --</option>
                          <?php
                          foreach ($subkelompok as $row) {
                            echo '<option value="'.$row->id_subkelompok.'@'.$row->nm_subkelompok.'">' . $row->nm_subkelompok . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kategori</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="edit_kategori" id="edit_kategori">
                          <option value="">-- kategori --</option>
                          <?php
                          foreach ($kategori as $row2) {
                            echo '<option value="'.$row2->id_kategori.'@'.$row2->kategori.'">' . $row2->kategori . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Satuan Tindakan</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="edit_satuan" id="edit_satuan">
                          <option value="">-- satuan --</option>
                          <?php
                          foreach ($satuan as $row3) {
                            echo '<option value="'.$row3->id.'@'.$row3->nm_satuan.'">' . $row3->nm_satuan . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama"></p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS RS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS PM</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Anastesi</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Asisten</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">JS Operator</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif IKS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Tarif BPJS</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">BMHP</p>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Total</p>
                    </div>



                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">VVIP/<br>EKSEKUTIF</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_jasa_rs_vipa" id="edit_jasa_rs_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_jasa_paramedis_vipa" id="edit_jasa_paramedis_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_jasa_anastesi_vipa" id="edit_jasa_anastesi_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_jasa_asistensi_vipa" id="edit_jasa_asistensi_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_jasa_dr_vipa" id="edit_jasa_dr_vipa" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_vipa" id="edit_tarif_iks_vipa" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_vipa" id="edit_tarif_bpjs_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipa()" name="edit_alkes_kelas_vipa" id="edit_alkes_kelas_vipa" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas VVIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_vipa" id="edit_kelas_vipa" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">VIP</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_jasa_rs_vipb" id="edit_jasa_rs_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_jasa_paramedis_vipb" id="edit_jasa_paramedis_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_jasa_anastesi_vipb" id="edit_jasa_anastesi_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_jasa_asistensi_vipb" id="edit_jasa_asistensi_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_jasa_dr_vipb" id="edit_jasa_dr_vipb" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_vipb" id="edit_tarif_iks_vipb" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_vipb" id="edit_tarif_bpjs_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_vipb()" name="edit_alkes_kelas_vipb" id="edit_alkes_kelas_vipb" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas VIP</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_vipb" id="edit_kelas_vipb" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">I</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_jasa_rs_1" id="edit_jasa_rs_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_jasa_paramedis_1" id="edit_jasa_paramedis_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_jasa_anastesi_1" id="edit_jasa_anastesi_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_jasa_asistensi_1" id="edit_jasa_asistensi_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_jasa_dr_1" id="edit_jasa_dr_1" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_1" id="edit_tarif_iks_1" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_1" id="edit_tarif_bpjs_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_1()" name="edit_alkes_kelas_1" id="edit_alkes_kelas_1" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas I</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_1" id="edit_kelas_1" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">II</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_jasa_rs_2" id="edit_jasa_rs_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_jasa_paramedis_2" id="edit_jasa_paramedis_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_jasa_anastesi_2" id="edit_jasa_anastesi_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_jasa_asistensi_2" id="edit_jasa_asistensi_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_jasa_dr_2" id="edit_jasa_dr_2" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_2" id="edit_tarif_iks_2" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_2" id="edit_tarif_bpjs_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_2()" name="edit_alkes_kelas_2" id="edit_alkes_kelas_2" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas II</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_2" id="edit_kelas_2" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">III</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_jasa_rs_3" id="edit_jasa_rs_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_jasa_paramedis_3" id="edit_jasa_paramedis_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_jasa_anastesi_3" id="edit_jasa_anastesi_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_jasa_asistensi_3" id="edit_jasa_asistensi_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_jasa_dr_3" id="edit_jasa_dr_3" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_3" id="edit_tarif_iks_3" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_3" id="edit_tarif_bpjs_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3()" name="edit_alkes_kelas_3" id="edit_alkes_kelas_3" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_3" id="edit_kelas_3" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">NK/IGD/IRJ</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_jasa_rs_3a" id="edit_jasa_rs_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_jasa_paramedis_3a" id="edit_jasa_paramedis_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_jasa_anastesi_3a" id="edit_jasa_anastesi_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_jasa_asistensi_3a" id="edit_jasa_asistensi_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_jasa_dr_3a" id="edit_jasa_dr_3a" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_3a" id="edit_tarif_iks_3a" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_3a" id="edit_tarif_bpjs_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_3a()" name="edit_alkes_kelas_3a" id="edit_alkes_kelas_3a" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas Suite</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_3a" id="edit_kelas_3a" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">NR</p>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_jasa_rs_nr" id="edit_jasa_rs_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Paramedis Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_jasa_paramedis_nr" id="edit_jasa_paramedis_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Anastesi Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_jasa_anastesi_nr" id="edit_jasa_anastesi_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Asisten Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_jasa_asistensi_nr" id="edit_jasa_asistensi_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Jasa Dokter Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_jasa_dr_nr" id="edit_jasa_dr_nr" min="0">
                      </div>
                      <!-- tarif IKS -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_iks_nr" id="edit_tarif_iks_nr" min="0">
                      </div>
                      <div class="col-sm-1">
                        <input type="number" class="form-control" name="edit_tarif_bpjs_nr" id="edit_tarif_bpjs_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Alkes</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" onkeyup="edit_total_nr()" name="edit_alkes_kelas_nr" id="edit_alkes_kelas_nr" min="0">
                      </div>
                      <!-- <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas NR</p> -->
                      <div class="col-sm-1">
                        <input type="number" class="form-control" readonly="true" name="edit_kelas_nr" id="edit_kelas_nr" min="0">
                      </div>
                    </div>

                </div>
                </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Tindakan</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form action="<?php echo base_url('tarif/cuploadtindakan/upload_tarif_tindakan_excel_file/');?>" method="POST" enctype="multipart/form-data">
          <div class="modal fade" id="myModalUpload" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Upload Tarif Tindakan</h4>
                </div>
                <div class="modal-body">
                  <a href="<?php echo base_url('assets/tarif_tindakan.xlsx');?>" class="btn btn-info" target="_blank" download>Template</a>
                  <div class="col-md-12"> 
                    <div class="center">Format Excel Tindakan</div>
                    <div class="form-group">              
                        <input type="file" name="tarifTindakanFile" class="form-control" id="tarifTindakanFile" accept=".xls,.xlsx,.csv">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" onCLick = "">Upload</button>
                </div>
              </div>
            </div>
          </div>
        </form>

        <form method="POST" id="delete_form" class="form-horizontal">
          <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
              <input type="hidden" class="form-control" name="delete_id" id="delete_id">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau hapus Tindakan?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Jangan hapus</button>
                  <button class="btn btn-primary" type="submit" id="btn-delete">Yakin hapus</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modalLoading" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title"><b><i class="fa fa-spinner fa-spin"></i>Loading....</b></h1>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
if ($role_id == 1) {
  $this->load->view("layout/footer_left");
} else {
  $this->load->view("layout/footer_horizontal");
}
?>