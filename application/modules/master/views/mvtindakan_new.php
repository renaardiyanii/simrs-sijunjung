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
        url: "<?php echo base_url(); ?>master/mctindakan_new/insert_tindakan_dgn_tarif",
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
        url: "<?php echo base_url(); ?>master/mctindakan_new/soft_delete_tindakan_dgn_tarif/",
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
    $('#edit_tarif_hcu').val("");
    $('#edit_tarif_icu').val("");

    $('#edit_tarif_iccu').val("");
    $('#edit_tarif_nicu').val("");

    $('#edit_tarif_elektif').val("");
    $('#edit_tarif_cito').val("");
    $('#edit_tarif_ods').val("");
    $('#edit_tarif_local').val("");

    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('master/mctindakan_new/get_data_edit_tindakan_dgn_tarif') ?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data) {
        // console.log(data[0].pake);
        $('#edit_idtindakan').val(data[0].idtindakan);
        $('#edit_idtindakan_hide').val(data[0].idtindakan);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
       
        if (data) {
         
          for (var i = 0; i < 7; i++) {
          
              if(data[i].kelas == 'ICU'){
                $('#edit_tarif_icu').val(data[i].total_tarif);
              }else if(data[i].kelas == 'HCU'){
                $('#edit_tarif_hcu').val(data[i].total_tarif);
              }else if(data[i].kelas == 'ICCU'){
                $('#edit_tarif_iccu').val(data[i].total_tarif);
              }else if(data[i].kelas == 'NICU/PICU'){
                $('#edit_tarif_nicu').val(data[i].total_tarif);
              }else if(data[i].kategory == 'elektif'){
                $('#edit_tarif_elektif').val(data[i].total_tarif);
              }else if(data[i].kategory == 'cito'){
                $('#edit_tarif_cito').val(data[i].total_tarif);
              }else if(data[i].kategory == 'ods'){
                $('#edit_tarif_ods').val(data[i].total_tarif);
              }else if(data[i].kategory == 'local'){
                $('#edit_tarif_local').val(data[i].total_tarif);
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

    url = "<?php echo site_url('master/mctindakan_new/edit_tindakan_dgn_tarif')?>";  

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
        url: "<?php echo base_url(); ?>master/mctindakan_new/active_tindakan_dgn_tarif/" + idtindakan,
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
  if (confirm('Yakin Ingin Mengnonaktifkan Tindakan ini?')) {
    $('#modalLoading').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url(); ?>master/mctindakan_new/nonactive_tindakan_dgn_tarif/" + idtindakan,
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
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="idtindakan" id="idtindakan" maxlength="7" required>
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
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Instalasi</p>
                      <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%" name="instalasi" id="instalasi">
                          <option value="">-- Pilih --</option>
                          <option value="IRI">IRI</option>
                          <option value="OK">OPERASI</option>
                        </select>
                      </div>
                    </div>
                   
                    <hr>


                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">HCU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_hcu" id="tarif_hcu" min="0">
                      </div>
                      <p class="col-sm-1 form-control-label" id="lbl_nama">ICU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_icu" id="tarif_icu" min="0">
                      </div>
                    </div>




                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">ICCU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_iccu" id="tarif_iccu" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">NICU/PICU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_nicu" id="tarif_nicu" min="0">
                      </div>
                    </div>



                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Cito</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_cito" id="tarif_cito" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">Elektif</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_elektif" id="tarif_elektif" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">ODS</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_ods" id="tarif_ods" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">Local</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="tarif_local" id="tarif_local" min="0">
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
          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalUpload"><i class="fa fa-plus"></i> Upload Tarif Excel</button> -->

          </div>
          <!-- <?php echo form_close(); ?> -->
          <hr>
          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>TMNO</th>
                <th>Ket</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>TMNO</th>
                <th>Ket</th>
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
                  <td><?php echo $row->tmno; ?></td>
                  <td><?php echo $row->keterangan; ?></td>
                  <?php if ($row->deleted == null || $row->deleted == '0') : ?>
                    <td>ACTIVE</td>
                  <?php else : ?>
                    <td>NON-ACTIVE</td>
                  <?php endif; ?>
                  <td>
                   
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onClick="edit_tindakan('<?php echo $row->idtindakan; ?>')"><i class="fa fa-edit"></i></button>
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
          <!-- <a href="<?php echo base_url('master/mctindakan/excel_tarif_tindakan');?>" class="btn btn-success" target="_blank">Excel</a> -->
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
                        <!-- <input type="checkbox" class="filled-in" value="1" name="edit_paket" id="edit_paket">
                        <label for="edit_paket">Tarif Paket</label> -->
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
                      <p class="col-sm-1 form-control-label" id="lbl_nama">HCU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_hcu" id="edit_tarif_hcu" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">ICU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_icu" id="edit_tarif_icu" min="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">ICCU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_iccu" id="edit_tarif_iccu" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">NICU/PICU</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_nicu" id="edit_tarif_nicu" min="0">
                      </div>
                    </div>


                    <div class="form-group row">
                      <p class="col-sm-1 form-control-label" id="lbl_nama">Elektif</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_elektif" id="edit_tarif_elektif" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">Cito</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_cito" id="edit_tarif_cito" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">ODS</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_ods" id="edit_tarif_ods" min="0">
                      </div>

                      <p class="col-sm-1 form-control-label" id="lbl_nama">Local</p>
                      <div class="col-sm-2">
                        <input type="number" class="form-control" name="edit_tarif_local" id="edit_tarif_local" min="0">
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