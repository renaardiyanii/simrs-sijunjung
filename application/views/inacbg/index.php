<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/css/toastr.min.css'); ?>">
<script type="text/javascript" src="<?php echo site_url('assets/js/toastr.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/datetimepicker-master/jquery.datetimepicker.css'); ?>">
<script type="text/javascript" src="<?php echo site_url('assets/plugins/datetimepicker-master/jquery.datetimepicker.js'); ?>"></script>

<style type="text/css">
  [type="radio"]:disabled + label {
    color: #4b5255;
  }
  .demo-radio-button label{
    min-width: 90px;
  }
  .comment-text {
    padding: 0;
    padding-left: 20px;
  }
  input[type=text]:disabled, textarea:disabled {
    background: #fafafa;
    color: #555;
    cursor: default;
  }
  .tooltip-inner {
      color: #fff;
      background: #FF9900;
  }
 /* input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }*/
  #toast-container > div {
     opacity: 0.9;
    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=90);
    filter: alpha(opacity=90);
  }
  table.dataTable tbody td {
    padding: 10px 18px;
  }
  table.dataTable tbody th {
    padding: 10px 22px;
  }
  #claim_form {
    margin-top: 10px;
  }
  #table-pelayanan tbody tr {
    background-color: #f6f6f6;
  }
  #table_diagnosa tbody tr, #table_procedure tbody tr, #table-grouper-result tbody tr, #table-pelayanan tbody tr[role="row"] {
    background-color: #ffffff;
  }
  .ui-menu .ui-menu-item {
    padding: 0;
    border-bottom: 1px solid #ededed;
  }
  .ui-menu .ui-state-focus,
  .ui-menu .ui-state-active {
    margin: 0;
  }
  .user-block .description {
    color: #444;
    font-size: 16px;
  }
  .user-block .username {
    font-size: 18px;
    font-weight: bold;
  }
  .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
    border: 0;
    background: #fffa90;
    color: #777620;
    font-weight: normal;
  }
  .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-state-active.ui-button:hover 
  {
    border: 0;
    background: #eee;
    color: #333;
  }
  .ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
  .ui-widget-content {    
      font-size: 12px;
  }
  .ui-widget-content .ui-state-active {    
      font-size: 12px;
  }
  .ui-autocomplete-loading {
      background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
  }
  .page-titles {
    display: none;
  }
  .dataTables_info {
    display: none; 
  }
  .sidebar-nav > ul > li > a.active {
      font-weight: 400;
      background: #ffffff;
      color: #546e7b;
  }
  .sidebar-nav > ul > li > a.active:hover i{   
      /*background-color: #fff;*/
      color: #fff;  
  }
  .sidebar-nav > ul > li > a.active i {
      color: #546e7b;
  }
  th { font-size: 14px; }
  #table-pelayanan tbody tr {
    cursor: pointer;
  }

  td.details-control {
      background: url('<?php echo site_url('assets/images/details_open.png'); ?>') no-repeat center center;
      cursor: pointer;
  }
  tr.shown td.details-control {
      background: url('<?php echo site_url('assets/images/details_close.png'); ?>') no-repeat center center;
  }
  .borderless>tbody>tr>td {
    border: none;
  }
  td.dataTables_empty {
    text-align: center;    
  }
  @media screen and (min-width: 768px) {
    .box-body {
        padding: 15px;
    }
  }
  .profile-username {
    margin-top: 10px;
  }
  .profile-user-img {
      margin: 0 auto;
      width: 100px;
      padding: 10px;
      border: 3px solid #bfbfbf;
  }
  th { font-size: 14px; }
  .box-body {
    padding: 15px;
  }
  #total_tarif_rs:before {
      content: 'Rp';
      /*font-size: 0.85em;*/
      margin-right: 5px;
      /*vertical-align: bottom;*/
  }
  .load_input {
    background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") center center no-repeat;
  }  
</style>
<script type="text/javascript">
  var table_pelayanan;
  var table_diagnosa;
  var table_procedure;
  var no_register;
  var jenis_rawat;
  var no_sep;
  var data_pasien;

  $(function() {
    $(document).on("click","#btn-new-claim",function() {
      var gender = $('#gender').text();
      if (gender == 'L') {
        gender = 1;
      }
      if (gender == 'P') {
        gender = 2;
      }
      swal({
        title: "Buat Klaim",
        text: "Yakin membuat klaim tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (buat klaim)",
        showCancelButton: true,
        // closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/new_claim'; ?>",
            dataType: "JSON",
            data: $('#claim_form').serialize(),
            success: function(result){  
              if (result.metadata.code) {                  
                if (result.metadata.code == '200') {
                  get_claim_data();
                  toastr.success('Berhasil membuat klaim.', 'Sukses!');
                } else {
                  toastr.error(result.metadata.message, 'Error!');
                }
              } else {
                toastr.error('Koneksi Service Gagal.', 'Error!');
              }
            },
            error:function(event, textStatus, errorThrown) {    
              swal("Gagal membuat klaim",formatErrorMessage(event, errorThrown), "error");     
            }
          });                          
      });
      return false;
    });

    $(document).on("click","#send_claim_individual",function() { 
      swal({
        title: "Kirim Klaim Online",
        text: "Yakin akan mengirim klaim online?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (kirim)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/send_claim_individual'; ?>",
            dataType: "JSON",
            data: {"nomor_sep" : no_sep},
            success: function(result){  
              if (result.metadata.code) {              
                if (result.metadata.code == '200' && result.response.data[0].kemkes_dc_status == 'sent') {
                  get_claim_data(); 
                  toastr.success('Berhasil Kirim Klaim Online.', 'Sukses!');
                } else {
                  toastr.warning(result.metadata.message, 'Gagal Kirim Klaim Online.');
                } 
              } else {
                toastr.error('Koneksi Service Gagal.', 'Error!');
              }              
            },
            error:function(event, textStatus, errorThrown) {                     
              toastr.error(formatErrorMessage(event, errorThrown), 'Gagal Kirim Klaim Online.');    
            }
          });           
      });       
    });

    $(document).on("click","#btn-final-claim",function() {
      swal({
        title: "Finalisasi Klaim",
        text: "Yakin finalisasi klaim tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (finalisasi)",
        showCancelButton: true,
        // closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/claim_final'; ?>",
            dataType: "JSON",
            data: {"no_sep" : no_sep},
            success: function(result){  
              if (result.metadata.code) {                  
                if (result.metadata.code == '200') {
                  get_claim_data();
                  toastr.success('Berhasil Final Klaim.', 'Sukses!');
                } else {
                  toastr.error(result.metadata.message, 'Error!');
                }
              } else {
                toastr.error('Koneksi Service Gagal.', 'Error!');
              }
            },
            error:function(event, textStatus, errorThrown) {    
              toastr.error(formatErrorMessage(event, errorThrown), "Error!");     
            }
          });                          
      });
      return false;
    });

    $(document).on("click","#reedit_claim",function() {
      swal({
        title: "Edit Ulang Klaim",
        text: "Batalkan status final dan edit ulang klaim?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (edit ulang)",
        showCancelButton: true,
        // closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/reedit_claim'; ?>",
            dataType: "JSON",
            data: {"no_sep" : no_sep},
            success: function(result){  
              if (result.metadata.code) {                  
                if (result.metadata.code == '200') {
                  get_claim_data(); 
                  toastr.success('Berhasil Edit Ulang Klaim.', 'Sukses!');
                } else {
                  toastr.warning(result.metadata.message, 'Perhatian!');
                }
              } else {
                swal("Error", "Koneksi Service Gagal.", "error");
              }
            },
            error:function(event, textStatus, errorThrown) {    
              toastr.error(formatErrorMessage(event, errorThrown), "Error!");  
            }
          });                          
      });
      return false;
    });

    $(document).on("click","#delete_claim",function() {      
      swal({
        title: "Hapus Klaim",
        text: "Yakin akan menghapus klaim tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        // closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/delete_claim'; ?>",
            dataType: "JSON",
            data: {"nomor_sep" : no_sep},
            success: function(result){  
              if (result.metadata.message) {                    
                if (result.metadata.code == '200') {
                  get_claim_data(); 
                  toastr.success('Berhasil Hapus Klaim.', 'Sukses!');
                } else {
                  toastr.warning(result.metadata.message, 'Perhatian!');
                }
              } else {
                toastr.error('Koneksi Service Gagal.', 'Error!');
              }
            },
            error:function(event, textStatus, errorThrown) {    
              swal("Gagal menghapus klaim.",formatErrorMessage(event, errorThrown), "error");
            }
          });           
      });
      return false;
    });
    $(document).on("click","#btn-grouper",function() { 
      $('#btn-grouper').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'inacbg/klaim/set_claim_data'; ?>",
        dataType: "JSON",
        data: $('#claim_form').serialize(),
        success: function(result) {      
          console.log(result);
          $('#btn-grouper').prop('disabled', false).css('cursor','pointer').html('Grouper');
          if (result.metadata.code) {
            if (result.metadata.code == '200') {
              get_claim_data();
              $('html, body').animate({
                  scrollTop: $("#grouper_result").offset().top
              }, 2000); 
              toastr.success('Klaim berhasil digrouper.', 'Sukses!');
            } else {
              toastr.warning(result.metadata.message, 'Perhatian!');
            }  
          } else {
            toastr.error('Koneksi Service Gagal.', 'Error!');
          }                
        },
        error:function(event, textStatus, errorThrown) {             
            $('#btn-grouper').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-check"></i> GROUPER');        
            console.log(formatErrorMessage(event, errorThrown)); 
        }
      });
      event.preventDefault();
    });
    $("#form_sep_manual").submit(function(event) {
      if ($('#no_sep_manual').val() === $('#no_sep').val()) {
        toastr.warning('No. SEP sudah digunakan.', 'Perhatian!');
      } else {
        $('#btn-sep-manual').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
        $.ajax({
          type: "POST",
          url: "<?php echo base_url().'bpjs/sep/insert_manual'; ?>",
          dataType: "JSON",
          data: {
            "no_register": $('#no_register').val(),
            "no_sep_manual": $('#no_sep_manual').val()
          },
          success: function(result) {    
            $('#btn-sep-manual').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
            if (result.metaData.code == '200') { 
              load_data_pasien();
              $('#modal_sep').modal('hide');
              toastr.success('Data SEP berhasil disimpan.', 'Sukses!');
            } else {
              toastr.warning(result.metadata.message, 'Perhatian!');
            }
          },
          error:function(event, textStatus, errorThrown) {             
            $('#btn-sep-manual').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
            toastr.error(formatErrorMessage(event, errorThrown), 'Gagal Simpan SEP');
          }
        });
      }
      event.preventDefault();
    });
    $(document).on("click","#btn-cek-sep",function() {      
      var button = $(this);
      var no_sep = $("#no_sep_manual").val();
      button.prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');    
        if (no_sep == '') {
          $(this).prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-eye"></i> Data SEP');
          swal("No. SEP Kosong","Silahkan masukan nomor sep.", "warning"); 
        } else {        
          $.ajax({
              type: "POST",
              url: '<?php echo site_url('bpjs/sep/show_sep'); ?>'+'/'+no_sep,
              dataType: "JSON",           
              success: function(result){ 
                button.prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-eye"></i> Data SEP');           
                if (result != '') {
                  if (result.metaData.code == '200') {                 
                    data = result.response;
                    $('#show_sep').html(data.noSep);  
                    $('#show_tgl_sep').html(data.tglSep);    
                    $('#show_no_rujukan').html(data.noRujukan);    
                    $('#show_jns_pelayanan').html(data.jnsPelayanan);    
                    $('#show_kls_rawat').html(data.kelasRawat);      
                    $('#show_poli').html(data.poli);    
                    $('#show_nama').html(data.peserta.nama);    
                    $('#show_no_bpjs').html(data.peserta.noKartu);    
                    $('#show_diagnosa').html(data.diagnosa);    
                    $('#show_catatan').html(data.catatan);    
                    $('#show_result_sep').fadeIn(1000);      
                  } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
                    toastr.warning('No. SEP Harus 19 digit.', 'SEP Tidak Ditemukan!');
                  } else {                  
                    toastr.warning(result.metaData.message, 'Gagal Lihat Data SEP!');
                  }                 
                } else {                
                    toastr.error('Koneksi Service Gagal.', 'Error!');
                }
              },
              error:function(event, textStatus, errorThrown) { 
                button.prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-eye"></i> Data SEP');           
                toastr.error(formatErrorMessage(event, errorThrown), "Error!");                   
              }
          });
        }
    });

    // $(document).on("wheel", "input[type=number]", function (e) {
    //   $(this).blur();
    // });

    var openRows = new Array();
    $('#separate_rm').hide();
    $('#separate_nama').hide();
    $('#separate_gender').hide();
    $('#show-pasien').hide();  

    $(document).on("change",".input_tarif_rs",function() {
        if ($(this).val() === '') {
          $(this).val(0);
        }
        total_tarif_rs();
    });

    $(document).on("change","#category",function() {
      $("#cari_pasien").autocomplete("search", $("#cari_pasien").val());
    }); 

    $('#btn-cari').click(function() {            
      $("#cari_pasien").autocomplete("search", $("#cari_pasien").val());
    });

    table_pelayanan = $('#table-pelayanan').DataTable({  
      autoWidth: false,
      columns:[
        {
          "className": 'details-control',
          "orderable": false,
          "data": null,
          "defaultContent": ''
        },
        { data: "no_register" },
        { data: "tgl_kunjungan" },
        { data: "tgl_pulang" },
        { data: "no_sep" },
        { data: "tipe" },
        { data: "cbg_code" },
        { data: "status_kirim" }
      ],
      columnDefs: [
        { targets: [ 0 ], visible: true, orderable: false, className: "text-center" },
        { targets: [ 1 ], visible: false },
        { targets: [ 2 ], visible: true },
        { targets: [ 3 ], visible: true },
        { targets: [ 4 ], visible: true },
        { targets: [ 5 ], visible: true, className: "text-center" },
        { targets: [ 6 ], visible: true, className: "text-center" },
        { targets: [ 7 ], visible: true, className: "text-center" }
      ],   
      drawCallback: function( settings ) {
        $("#table-pelayanan").wrap( "<div class='table-responsive'></div>" );
      }      
    });
    
    function closeOpenedRows(table, selectedRow) {
      $.each(openRows, function (index, openRow) {
          if ($.data(selectedRow) !== $.data(openRow)) {
              var rowToCollapse = table.row(openRow);
              rowToCollapse.child.hide();
              openRow.removeClass('shown');
              var index = $.inArray(selectedRow, openRows);
              openRows.splice(index, 1);
          }
      });
    }
 
    $('#table-pelayanan tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_pelayanan.row(tr);
 
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            closeOpenedRows(table_pelayanan, tr);
            row.child(form_klaim(row.data())).show();
            tr.addClass('shown');
            openRows.push(tr);

            /// Reinitialize for klaim ///
            $('#no_register').val(no_register);
            $('#show_result_sep').hide();
            $(document).on('hidden.bs.modal', '#modal_sep', function () {
              reset_result_sep();
            });

            $(document).on('show.bs.modal', '#modal_sep', function () {
              $('#no_sep_manual').val($('#no_sep').val());
            });
            // $(".date_picker").datetimepicker({ 
            //   dateFormat:'yy-mm-dd',
            //   timeFormat: "hh:mm:ss",
            //   beforeShow : function(input,inst){
            //       var offset = $(input).offset();
            //       var height = $(input).height();
            //       window.setTimeout(function () {
            //           $(inst.dpDiv).css({ top: (offset.top + height) + 'px', left:offset.left + 'px' })
            //       }, 1);
            //   }
            // }); 
            $('.date_picker').datetimepicker({
              format:'Y-m-d H:i:s',
            });
            // $(".hasDatepicker").click(function(e){
            //     $("#ui-datepicker-div").css({'top':e.pageY+20,'left':e.pageX-250});
            // });
            $('#nama_dokter').select2({
              placeholder: 'Silahkan Pilih DPJP',
            });

            $.ajax({
              url: '<?php echo site_url('inacbg/master/data_dokter'); ?>',
              type: "POST",
              dataType: "JSON",
              success:function(data) {
                $('#nama_dokter').empty();
                $('#nama_dokter').append('<option value="">-- Silahkan Pilih DPJP --</option>');
                $.each(data, function(key, value) {
                  $('#nama_dokter').append('<option value="'+ value.nm_dokter +'">'+ value.nm_dokter +'</option>');
                });
                load_data_pasien();
              }
            });
            $('.tambahan_biaya_result').hide();
            $('#grouper_result').hide();
            $('#div_upgrade_class_ind,#div_upgrade_class_class,#div_upgrade_class_los,#div_icu_indicator,#div_icu_los,#div_ventilator_hour').hide();
            $('#div_add_payment_pct').hide(); 
            $('#div_rawat_inap').hide();
            load_data_pasien();
            get_claim_data();
            tarif_rs();    
            get_diagnosa();
            get_procedure();

            $('#upgrade_class_ind').change(function() {
                if ($(this).is(':checked')) {
                  $('#div_upgrade_class_class,#div_upgrade_class_los').fadeIn(300);
                } else {
                  $('#upgrade_class_class').val(null).trigger('change');
                  $('#upgrade_class_los').val('0');
                  $('#div_upgrade_class_class,#div_upgrade_class_los').fadeOut(300);
                }
            });

            $('#icu_indicator').change(function() {
                if ($(this).is(':checked')) {
                  $('#div_icu_los,#div_ventilator_hour').fadeIn(300);
                } else {
                  $('#div_icu_los').val('0');
                  $('#div_ventilator_hour').val('0');
                  $('#div_icu_los,#div_ventilator_hour').fadeOut(300);
                }
            });

            $(".input_tarif_rs").on("keypress keyup blur",function (event) {    
              $(this).val($(this).val().replace(/[^\d].+/, ""));
              if ((event.which < 48 || event.which > 57)) {
                  event.preventDefault();
              }
            });

            $('#id_diagnosa').select2({
              placeholder: 'Ketik kode atau nama diagnosa',
              minimumInputLength: 1,
              language: {
                inputTooShort: function(args) {
                  return "Ketik kode atau nama diagnosa";
                },
                noResults: function() {
                  return "Diagnosa tidak ditemukan.";
                },
                searching: function() {
                  return "Searching.....";
                }
              },
              ajax: {
                type: 'GET',
                url: '<?php echo base_url().'diagnosa/select2_inacbg'; ?>',
                dataType: 'JSON',          
                delay: 250,
                processResults: function (data) {            
                  return {
                    results: data
                  };
                },
                cache: true
              }
            }).on("change", function() { 
              $('.select2-selection__rendered').removeAttr('title');
              var data = $('#id_diagnosa').select2('data');
              if (data.length > 0) {
                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url('diagnosa/insert')?>",
                  dataType: "JSON",
                  data: {
                    "no_register" : no_register,
                    "tgl_masuk" : $('#tgl_masuk').val(),
                    "diagnosa" : data[0].id
                  },
                  success: function(result) {
                    if (result.metadata.code) {            
                      if (result.metadata.code == '200') {                      
                        table_diagnosa.ajax.reload();   
                        get_diagnosa();       
                        $('#id_diagnosa').val(null).trigger('change');
                        toastr.success('Diagnosa berhasil disimpan.', 'Sukses!');
                      } else if (result.metadata.code == '422') {             
                        toastr.warning('Silahkan pilih diagnosa yang lain.', 'Diagnosa sudah ada.');
                      } else {              
                        toastr.error(result.metadata.message, 'Gagal menginput diagnosa.');      
                      }                   
                    } else toastr.error('Silahkan coba kembali.', 'Gagal menginput diagnosa.');          
                  },
                  error:function(event, textStatus, errorThrown) {  
                    toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput diagnosa.');   
                  }
                });
              }
            });

            $('#id_procedure').select2({
              placeholder: 'Ketik kode atau nama prosedur',
              minimumInputLength: 1,
              language: {
                inputTooShort: function(args) {
                  return "Ketik kode atau nama prosedur";
                },
                noResults: function() {
                  return "Prosedur tidak ditemukan.";
                },
                searching: function() {
                  return "Searching.....";
                }
              },
              ajax: {
                type: 'GET',
                url: '<?php echo base_url().'procedure/select2_inacbg'; ?>',
                dataType: 'JSON',          
                delay: 250,
                processResults: function (data) {            
                  return {
                    results: data
                  };
                },
                cache: true
              }
            }).on("change", function() { 
              $('.select2-selection__rendered').removeAttr('title');
              var data = $('#id_procedure').select2('data');
              if (data.length > 0) {
                $.ajax({
                  type: "POST",
                  url: "<?php echo site_url('procedure/insert')?>",
                  dataType: "JSON",
                  data: {
                    "no_register" : no_register,
                    "tgl_masuk" : $('#tgl_masuk').val(),
                    "procedure" : data[0].id
                  },
                  success: function(result) {
                    if (result.metadata.code) {            
                      if (result.metadata.code == '200') {                      
                        table_procedure.ajax.reload();   
                        get_procedure();       
                        $('#id_procedure').val(null).trigger('change');
                        toastr.success('Prosedur berhasil disimpan.', 'Sukses!');
                      } else if (result.metadata.code == '422') {             
                        toastr.warning('Silahkan pilih prosedur yang lain.', 'Prosedur sudah ada.');
                      } else {              
                        toastr.error(result.metadata.message, 'Gagal menginput prosedur.');      
                      }                   
                    } else toastr.error('Silahkan coba kembali.', 'Gagal menginput prosedur.');          
                  },
                  error:function(event, textStatus, errorThrown) {  
                    toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput prosedur.');   
                  }
                });
              }
            });

            table_diagnosa = $('#table_diagnosa').DataTable({ 
              "lengthChange": false,
              "language": {
                "emptyTable": "Diagnosa belum diinput."
              },
              "searching": false,
              "processing": true,
              "serverSide": true,
              "order": [],
              "lengthMenu": [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
              ],
              "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              "ajax": {
                "url": "<?php echo site_url('diagnosa/get_diagnosa_inacbg')?>",
                "type": "POST",
                "dataType": 'JSON',
                "data": function (data) {
                  data.no_register = no_register;
                }        
              },
              "columnDefs": [
                { "width": "8%", "targets": 0 },
                { "width": "13%", "targets": [3,4,5] },
                { "orderable": false, "targets": [0,1,2,3,4,5]}
              ],   
              "drawCallback": function( settings ) {
                $("#table_diagnosa").wrap( "<div class='table-responsive'></div>" );
              }   
            });

            table_procedure = $('#table_procedure').DataTable({ 
              "lengthChange": false,
              "language": {
                "emptyTable": "Procedure belum diinput."
              },
              "searching": false,
              "processing": true,
              "serverSide": true,
              "order": [],
              "lengthMenu": [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
              ],
              "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              "ajax": {
                "url": "<?php echo site_url('procedure/get_procedure')?>",
                "type": "POST",
                "dataType": 'JSON',
                "data": function (data) {
                  data.no_register = no_register;
                }        
              },
              "columnDefs": [
                { "width": "8%", "targets": 0 },
                { "width": "13%", "targets": [2] },
                { "orderable": false, "targets": [0,2]}
              ],   
              "drawCallback": function( settings ) {
                $("#table_procedure").wrap( "<div class='table-responsive'></div>" );
              }   
            });

            /// Reinitialize for klaim ///
        }
    });

    $("#cari_pasien").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
            url: "<?php echo site_url('inacbg/pasien/get_autocomplete')?>",
            dataType: "JSON",
            beforeSend: function() {
              check_login();
            },
            data: {
                term: request.term,
                category: $('#category').val()
            },
            success: function (data) {
              if(!data.length){
                var result = [{
                  label: 'Data tidak ditemukan'
                }];
                $.ui.autocomplete.prototype._renderItem = function (ul, item) {                          
                  return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a style='display:inline-block;width: 100%;'><p style='font-size: 14px;margin-bottom: 3px;font-style: italic'>" + item.label + "</p></a>")
                    .appendTo(ul);
                };
                response(result);
              } else {
                $.ui.autocomplete.prototype._renderItem = function (ul, item) {   
                  var no_cm = String(item.no_cm).replace(
                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                    "<span class='ui-state-highlight'>$&</span>"
                  );
                  var nama = String(item.nama).replace(
                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>"
                  );
                  var tgl_lahir = String(item.tgl_lahir).replace(
                      new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>"
                  );
                  var no_kartu = String(item.no_kartu).replace(
                      new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>"
                  );
                  return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a style='display:inline-block;width: 100%;'><p class='pull-right' style='font-size: 14px;font-weight: 600;'>RM : " + no_cm + "</p><p style='font-size: 14px;font-weight: 600;margin-bottom: 3px;'>" + nama + "</p><p style='font-size: 14px;margin-bottom: 3px;'>No. Kartu : " + no_kartu + "</p><span style='font-size: 14px;'>Tgl. Lahir : " + tgl_lahir + "</span></a>")
                    .appendTo(ul);
                };
                response(data);                  
              }                  
            }
          });
      },      
      minLength: 1,     
      select: function (event, ui) {
          if (ui.item == null) {
            $('#show-pasien').hide();
          } else $('#show-pasien').show();

          if (ui.item.no_cm != '' && ui.item.nama != '') {
            $('#separate_rm').show();
          }
          if (ui.item.nama != '' && ui.item.gender != '') {
            $('#separate_nama').show();
          }
          if (ui.item.gender != '' && ui.item.tgl_lahir != '') {
            $('#separate_gender').show();
          }
          $('#no_cm').val(ui.item.no_cm);
          $('#no_rm').html(ui.item.no_cm);
          $('#nama_pasien').html(ui.item.nama);
          $('#tgl_lahir').html(ui.item.tgl_lahir);
          $('#gender').html(ui.item.gender);
          load_pelayanan();
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    }); 
    $('#btn-cari').click(function() {            
      $("#cari_pasien").autocomplete("search", $("#cari_pasien").val());
    });

    ////// Klaim //////
  });

function show_modal() {
  $('#modal_sep').modal('show');
}

function get_claim_data(){
    $.ajax({
      type: "GET",
      url: "<?php echo base_url().'inacbg/klaim/get_claim_data/'; ?>"+no_sep,
      dataType: "JSON",
      beforeSend:function(){
        $('#div-btn-service1').html('<center><img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>"></center>'); 
      },
      success: function(result) { 
        $('.input_tarif_rs').prop('readonly', false);
        $('#id_diagnosa,#id_procedure').prop('disabled', false);
        $("#card-result").css({"background-color": "#ffffff"});
        $('#div-btn-service1,#div-btn-service2').empty();
        $('#tr_status_klaim').hide();
        $('#grouper_result').hide();
        $('#cbg_code_'+no_register).html('-');
        $('#cbg_status_'+no_register).html('-');
        if (result.metadata.code == 200) {  
          $('#cbg_status_'+no_register).html(result.response.data.klaim_status_cd.toUpperCase());
          if (result.response.data.grouper.response == null) {
            $('.div-non-final').show();
            $('#div-btn-service1').html('<button type="button" class="btn btn-danger waves-effect waves-light m-r-10" id="delete_claim"><i class="fa fa-trash"></i> Hapus Klaim</button><button type="submit" class="btn btn-info pull-right" id="btn-grouper"><i class="fa fa-check"></i> Grouper</button>');
          } else {
            $('#cbg_code_'+no_register).html(result.response.data.grouper.response.cbg.code);
            $('.div-non-final').hide();
            $('#grouper_result').fadeIn(1000);
            $('#kelas_rs_result').html(result.response.data.kelas_rs);
            if (result.response.data.jenis_rawat == 1) {
              $('#jenis_rawat_result').html('Rawat Inap');
            }
            if (result.response.data.jenis_rawat == 2) {
              $('#jenis_rawat_result').html('Rawat Jalan');
            }
            $('#kelas_rawat_result').html(result.response.data.kelas_rawat);
            $('#kelas_rs_result').html(result.response.data.kelas_rs);
            if (result.response.data.kode_tarif == "BP") {
              $('#tarif_kelas_result').html("B PEMERINTAH");
            }
            $('#description_cbg').html(result.response.data.grouper.response.cbg.description);
            $('#code_cbg').html(result.response.data.grouper.response.cbg.code);
            $('#tarif_cbg').html(result.response.data.grouper.response.cbg.tariff);

            if (result.response.data.grouper.response.sub_acute) {
              $('#sub_acute_description').html(result.response.data.grouper.response.sub_acute.description);
              $('#sub_acute_code').html(result.response.data.grouper.response.sub_acute.code);
              $('#sub_acute_tarif').html(result.response.data.grouper.response.sub_acute.tariff);
            } else {
              $('#sub_acute_description').html('-');
              $('#sub_acute_code').html('-');
              $('#sub_acute_tarif').html(0);
            }
            if (result.response.data.grouper.response.chronic) {
              $('#chronic_description').html(result.response.data.grouper.response.chronic.description);
              $('#chronic_code').html(result.response.data.grouper.response.chronic.code);
              $('#chronic_tarif').html(result.response.data.grouper.response.chronic.tariff);
            } else {
              $('#chronic_description').html('-');
              $('#chronic_code').html('-');
              $('#chronic_tarif').html(0);
            }
            if (result.response.data.grouper.response.special_cmg) {
              $.each(result.response.data.grouper.response.special_cmg, function( key, value ) {
                if (key.type == 'Special Procedure') {
                  $('#special_procedure_description').html(key.description);
                  $('#special_procedure_code').html(key.code);
                  $('#special_procedure_tarif').html(key.tariff);
                }
                if (key.type == 'Special Prosthesis') {
                  $('#special_prosthesis_description').html(key.description);
                  $('#special_prosthesis_code').html(key.code);
                  $('#special_prosthesis_tarif').html(key.tariff);
                }
                if (key.type == 'Special Investigation') {
                  $('#special_investigation_description').html(key.description);
                  $('#special_investigation_code').html(key.code);
                  $('#special_investigation_tarif').html(key.tariff);
                }
                if (key.type == 'Special Drug') {
                  $('#special_drug_description').html(key.description);
                  $('#special_drug_code').html(key.code);
                  $('#special_drug_tarif').html(key.tariff);
                }
              });
            } else {
              $('#special_procedure_description,#special_prosthesis_description,#special_investigation_description,#special_drug_description,#special_procedure_code,#special_prosthesis_code,#special_investigation_code,#special_drug_code').html('-');
              $('#special_procedure_tarif,#special_prosthesis_tarif,#special_investigation_tarif,#special_drug_tarif').html(0);
            }

            if(result.response.data.klaim_status_cd == 'normal') {
              $('.div-non-final').show();
              $('#header_grouper_result').html('Hasil Grouper');
              $('#div-btn-service1').html('<button type="button" class="btn btn-danger waves-effect waves-light m-r-10" id="delete_claim"><i class="fa fa-trash"></i> Hapus Klaim</button><button type="submit" class="btn btn-info pull-right" id="btn-grouper"><i class="fa fa-check"></i> Grouper</button>');
              $('#div-btn-service2').html('<button type="button" class="btn btn-primary waves-effect waves-light pull-right" id="btn-final-claim" style="padding-right: 25px;padding-left: 25px;"><i class="fa fa-check"></i> Final Klaim</button>');
            }

            if(result.response.data.klaim_status_cd == 'final') {
              $('.input_tarif_rs').prop('readonly', true);
              $('#id_diagnosa,#id_procedure').prop('disabled', true);
              $("#card-result").css({"background-color": "#eeffee"});
              $('#header_grouper_result').html('Hasil Grouper - Final');
              $('#div-btn-service2').html('<button data-no_sep="'+no_sep+'" class="btn btn-primary pull-right" id="reedit_claim"><i class="fa fa-pencil-square-o"></i> Edit Ulang Klaim</button><a href="<?php echo site_url('inacbg/klaim/claim_print')?>/'+no_sep+'" target="_blank" class="btn btn-warning waves-effect waves-light" id="cetak_klaim" style="margin-right: 10px;"><i class="fa fa-print"></i> Cetak Klaim</a><button type="button" class="btn btn-info waves-effect waves-light m-r-10" id="send_claim_individual"><i class="fa fa-paper-plane"></i> Kirim Klaim Online</button>');
              if(result.response.data.kemenkes_dc_status_cd == 'unsent') {
                $('#tr_status_klaim').show();
                $('#status_data_klaim').html('Klaim belum terkirim ke Pusat Data Kementerian Kesehatan');
              }
              if(result.response.data.kemenkes_dc_status_cd == 'sent') {
                $('#tr_status_klaim').show();
                $('#status_data_klaim').html('Terkirim');
              }
            }

            var total_tarif = 0;
            $('.tarif_result').each(function(){
                total_tarif += parseInt($(this).text());  
            });
            $('#total_tarif').html(total_tarif.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));  
          }
        } else {
          $('#grouper_result').fadeOut(1000);
          $('#div-btn-service1').html('<button type="button" class="btn btn-info waves-effect waves-light pull-right" id="btn-new-claim" style="padding-right: 25px;padding-left: 25px;">Buat Klaim</button>');
        }  
      },
      error:function(event, textStatus, errorThrown) {
        swal("Gagal Load Klaim.",formatErrorMessage(event, errorThrown), "error"); 
      }
    });
  }

  function load_data_pasien() {
    $("input[name='no_rm']").val($('#no_rm').text());
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('inacbg/pasien/get_inacbg')?>",
      dataType: "JSON",
      data: {
        "no_register" : no_register
      },
      beforeSend: function() { 
        check_login();
        $('.input_data_pasien').addClass('load_input');
      },
      success: function(result_inacbg) {
        if (result_inacbg === null) {
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('inacbg/pasien/get_pasien')?>",
            dataType: "JSON",
            data: {
              "no_register" : no_register
            },
            success: function(result_pasien) {
              $('#nama').val(result_pasien.nama);
              $('#tgl_lahir_pasien').val(result_pasien.tgl_lahir);
              $('#no_bpjs').val(result_pasien.no_kartu);
              $('#no_sep').val(result_pasien.no_sep);
              $('#tgl_masuk').val(result_pasien.tgl_masuk);
              $('#tgl_pulang').val(result_pasien.tgl_pulang);
              $('#nama_dokter').val(result_pasien.nm_dokter).trigger("change");
              $("#discharge_status").prop("selectedIndex", 0);

              if (jenis_rawat === 'RJ') {
                $('#kelas_rawat_3').prop("checked", true).trigger("change");
                if (result_pasien.tgl_pulang === '' || result_pasien.tgl_pulang === null) {
                  $('#tgl_pulang').val(result_pasien.tgl_masuk);
                } else {
                  $('#tgl_pulang').val(result_pasien.tgl_pulang);
                }
                $('#div_upgrade_class_ind,#div_icu_indicator').hide();
              }
              if (jenis_rawat === 'RI') {
                if (result_pasien.klsiri === '' || result_pasien.klsiri === null) {
                  $('input[name=kelas_rawat]').prop('checked',false).trigger("change");
                } else if (result_pasien.klsiri === 'III') {
                  $('#kelas_rawat_3').prop("checked", true).trigger("change");
                } else if (result_pasien.klsiri === 'II') {
                  $('#kelas_rawat_2').prop("checked", true).trigger("change");
                } else {
                  $('#kelas_rawat_1').prop("checked", true).trigger("change");
                }
                $('#div_rawat_inap').fadeIn(300);
                $('#div_upgrade_class_ind,#div_icu_indicator').fadeIn(300);
              }

              // $.ajax({
              //   type: "POST",
              //   url: '<?php echo site_url('bpjs/sep/show_sep'); ?>'+'/'+no_sep,
              //   dataType: "JSON",           
              //   success: function(result_sep) { 
              //     console.log(result_sep);
              //     if (result_sep.metaData.code == '200') {                 
              //       if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 3') {
              //         $('#kelas_rawat_3').prop("checked", true).trigger("change");
              //       } else if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 2') {
              //         $('#kelas_rawat_2').prop("checked", true).trigger("change");
              //       } else if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 1') {
              //         $('#kelas_rawat_1').prop("checked", true).trigger("change");
              //       } else {
              //         $('#kelas_rawat_3').prop("checked", true).trigger("change");
              //         $("input[name='kelas_rawat']").prop("disabled", true);
              //       }
              //     }               
              //   },
              //   error:function(event, textStatus, errorThrown) {            
              //     console.log(formatErrorMessage(event, errorThrown));                   
              //   }
              // });

              // Belum Ada Bridging

              $('.input_data_pasien').removeClass('load_input');   
            },
            error:function(event, textStatus, errorThrown) { 
              $('.input_data_pasien').removeClass('load_input');          
              console.log(formatErrorMessage(event, errorThrown));    
            }
          });
        } else {
          if (jenis_rawat === 'RJ') {
            $('#div_rawat_inap').fadeOut(300);
            $('#div_upgrade_class_ind,#div_icu_indicator').fadeOut(300);
          }
          if (jenis_rawat === 'RI') {
            $('#div_rawat_inap').fadeIn(300);
            $('#div_upgrade_class_ind,#div_icu_indicator').fadeIn(300);
          }
          $('#nama').val(result_inacbg.nama_pasien);
          $('#tgl_lahir_pasien').val(result_inacbg.tgl_lahir);
          $('#no_bpjs').val(result_inacbg.nomor_kartu);
          $('#no_sep').val(result_inacbg.no_sep);
          $('#tgl_masuk').val(result_inacbg.tgl_masuk);
          $('#tgl_pulang').val(result_inacbg.tgl_pulang);
          $('#nama_dokter').val(result_inacbg.nama_dokter).trigger("change");
          $("#discharge_status").val(result_inacbg.discharge_status).trigger("change");
          $('#kelas_rawat_'+result_inacbg.kelas_rawat).prop("checked", true).trigger("change");
          
          if (result_inacbg.upgrade_class_ind === '1') {
            $('#upgrade_class_ind').prop("checked", true).trigger("change");
            $('#div_upgrade_class_class,#div_upgrade_class_los').fadeIn(300);
            $('#upgrade_class_class').val(result_inacbg.upgrade_class_class).trigger('change');
            $('#upgrade_class_los').val(result_inacbg.upgrade_class_los);
          }
          if (result_inacbg.icu_indicator === '1') {
            $('#icu_indicator').prop("checked", true).trigger("change");
            $('#div_icu_los,#div_ventilator_hour').fadeIn(300);
            $('#icu_los').val(result_inacbg.icu_los);
            $('#ventilator_hour').val(result_inacbg.ventilator_hour);
          }
          $('#discharge_status').val(result_inacbg.discharge_status).trigger("change");        
          $('.input_data_pasien').removeClass('load_input');
        }
      },
      error:function(event, textStatus, errorThrown) {     
        $('.input_data_pasien').removeClass('load_input');      
        toastr.error(formatErrorMessage(event, errorThrown), "Error!");    
      }
    });
  }

  function load_pelayanan() {
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('inacbg/pasien/get_pelayanan')?>",
        dataType: "JSON",
        data: {
          "no_cm" : $('#no_cm').val()
        },
        beforeSend:function(){ 
          check_login();
          $('#show-table-pelayanan').hide();
          $('#show-loading').show();
        },
        success: function(result) {
          $('#show-loading').fadeOut("slow", function(){
            $('#show-table-pelayanan').fadeIn("slow");
          });
          table_pelayanan.clear().draw();
          table_pelayanan.rows.add(result);
          table_pelayanan.columns.adjust().draw();
        },
        error:function(event, textStatus, errorThrown) {           
          swal("Gagal", formatErrorMessage(event, errorThrown), "error");    
        }
      });
  }

  function get_diagnosa() {
    $.ajax({
      type: "GET",
      url: "<?php echo base_url().'inacbg/klaim/get_diagnosa/'; ?>"+no_register,
      dataType: "json",
      success: function(data){
        var diags = [];
        var diagnosa;         
        if (data.diagnosa_utama == '') {
          diagnosa = '';
        } else {
          diags.push(data.diagnosa_utama);    
          $.each(data.diagnosa_tambahan, function(i, item) {
            diags.push(item);
          });          
          diagnosa = diags.join('#');         
        }             
            
        if (diagnosa == '' || diagnosa == null) {
          $('#diagnosa').val('#');
        } else {
          $('#diagnosa').val(diagnosa);
        }
      },
      error:function(event, textStatus, errorThrown) {
        console.log(formatErrorMessage(event, errorThrown)); 
      }        
    });
  }

  function get_procedure(){
    $.ajax({
      type: "GET",
      url: "<?php echo base_url().'inacbg/klaim/get_procedure/'; ?>"+no_register,
      dataType: "JSON",
      success: function(result){
        console.log(result);
        var procedures = [];
        var procedure;          
        // if (result.procedure_utama == '') {
        //   procedure = '';
        // } else {
        //   procedures.push(result.procedure_utama);
        $.each(result, function(i, item) {
          procedures.push(item.id_procedure);
        });          
        procedure = procedures.join('#');             
        // }                   
        if (procedure == '' || procedure == null) {
          $('#procedure').val('#');
        } else {
          $('#procedure').val(procedure);
        }
      },
      error:function(event, textStatus, errorThrown) {
        swal("Gagal load data procedure",formatErrorMessage(event, errorThrown), "error"); 
      }
    });
  }   

  function set_utama_diagnosa(id_diagnosa_pasien) {
    swal({
      title: "Set Utama",
      text: "Set utama diagnosa tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya",
      showLoaderOnConfirm: true,
      closeOnConfirm: true
      }, function() {
        $.ajax({
          type: 'POST',
          url: "<?php echo site_url('diagnosa/set_utama')?>",
          dataType:"JSON",
          data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : no_register},
          success: function(data){                
            if (data == true) {            
              table_diagnosa.ajax.reload();
              get_diagnosa();      
            } else {
              swal("Error", "Gagal men-set utama diagnosa. Silahkan coba lagi.", "error");            
            }               
          },
          error:function(event, textStatus, errorThrown) {
              swal("Error", formatErrorMessage(event, errorThrown), "error");            
          },
        });           
    });
  }

  function delete_diagnosa(id) {       
    swal({
      title: "Hapus Diagnosa",
      text: "Hapus diagnosa tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya (hapus)",
      showCancelButton: true,
      // closeOnConfirm: false,
      showLoaderOnConfirm: true,
      }, function() {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url().'diagnosa/delete'; ?>",
          dataType: "JSON",        
          data: {"id_diagnosa_pasien" : id,"no_register" : no_register},             
          success: function(data){  
            if (data == true) {
              table_diagnosa.ajax.reload();
              get_diagnosa();
              toastr.success('Diagnosa berhasil dihapus.', 'Sukses!');   
            } else {
              toastr.error('Gagal menghapus diagnosa. Silahkan coba lagi.', 'Error!');         
            }
          },
          error:function(event, textStatus, errorThrown) {    
            toastr.error(formatErrorMessage(event, errorThrown), 'Error!');      
          }
        });           
    });   
  }

  function delete_procedure(id) {       
    swal({
      title: "Hapus Prosedur",
      text: "Hapus prosedur tersebut?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya (hapus)",
      showCancelButton: true,
      // closeOnConfirm: false,
      showLoaderOnConfirm: true,
      }, function() {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url().'procedure/delete'; ?>",
          dataType: "JSON",                    
          data: {"id" : id,"no_register" : no_register},                    
          success: function(data){  
            if (data == true) {
              table_procedure.ajax.reload();
              get_procedure();  
              toastr.success('Prosedur berhasil dihapus.', 'Sukses!');   
            } else {
              toastr.error('Gagal menghapus prosedur. Silahkan coba lagi.', 'Error!');               
            } 
          },
          error:function(event, textStatus, errorThrown) {    
            toastr.error(formatErrorMessage(event, errorThrown), 'Error!');               
          }
        });           
    });   
  }

  function check_login() {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('login/ajax_check')?>",
      dataType: "JSON",
      success: function(result) {
        if (result === 0) {
          swal({
              title: "Perhatian",
              text: "Sesi Anda Sudah Habis. Silahkan Login Kembali.",
              type: "warning"
          }, function() {
              window.location.href = "<?php echo site_url('/login'); ?>";
          });
        }
      }
    });
  }

  function form_klaim(row) {
    no_register = row.no_register;
    jenis_rawat = row.tipe;
    no_sep = row.no_sep;
    return  '<form id="claim_form" class="form-horizontal">'+
    '<input type="hidden" class="form-control" id="no_register" name="no_register">'+
    '<div class="col-md-12">'+
      '<div class="row">'+
        '<div class="col-md-12">'+
          '<div class="card">'+
            '<div class="card-body">'+
              '<div class="col-md-12">'+
                '<div class="row">'+
                  '<div class="col-md-4">'+
                      '<label>Jaminan / Cara Bayar</label>'+
                      '<select name="payor_cd" id="payor_cd" class="form-control input_data_pasien" onchange="pilih_payor(this.value)">'+
                        '<option value="JKN" selected>JKN</option>'+
                        '<option value="001">JAMKESDA</option>'+
                        '<option value="999">PASIEN BAYAR</option>'+
                      '</select>'+
                  '</div>'+
                  '<div class="col-md-4">'+
                      '<label>No. BPJS</label>'+
                      '<input type="text" class="form-control input_data_pasien" id="no_bpjs" name="no_bpjs" value="">'+
                  '</div>'+
                  '<div class="col-md-4">'+
                      '<label>No. SEP</label>'+
                      '<div class="input-group">'+
                        '<input type="text" class="form-control input_data_pasien" id="no_sep" name="no_sep" required readonly>'+
                        '<span class="input-group-btn">'+
                          '+<button class="btn btn-danger" type="button" onclick="show_modal()"><i class="fa fa-pencil-square-o"></i></button>'+
                        '</span>'+
                      '</div>'+
                  '</div>'+
                '</div>'+
                '<br/>'+
                '<div class="row">'+
                  '<div class="col-md-6">'+
                    '<input type="hidden" class="form-control" name="no_rm">'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;">Nama</label>'+
                      '<div class="col-md-9">'+
                        '<input type="text" class="form-control input_data_pasien pull-right" id="nama" name="nama">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;">Tgl. Masuk</label>'+
                      '<div class="col-md-9">'+
                        '<div class="input-group date">'+
                          '<div class="input-group-addon">'+
                            '<i class="fa fa-calendar"></i>'+
                          '</div>'+
                          '<input type="text" class="form-control date_picker input_data_pasien pull-right" id="tgl_masuk" name="tgl_masuk">'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;">Tgl. Pulang</label>'+
                      '<div class="col-md-9">'+
                        '<div class="input-group date">'+
                          '<div class="input-group-addon">'+
                            '<i class="fa fa-calendar"></i>'+
                          '</div>'+
                          '<input type="text" class="form-control input_data_pasien date_picker pull-right" id="tgl_pulang" name="tgl_pulang">'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row" id="div_rawat_inap">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;"></label>'+
                      '<div class="col-md-9">'+
                        '<label class="checkbox-inline" id="div_upgrade_class_ind">'+
                          '<input class="filled-in" name="upgrade_class_ind" id="upgrade_class_ind" type="checkbox" value="1">Naik Kelas'+
                        '</label>'+
                        '<label class="checkbox-inline" id="div_icu_indicator">'+
                          '<input class="filled-in" name="icu_indicator" id="icu_indicator" type="checkbox" value="1">Ada Rawat Intensif'+
                        '</label>'+
                      '</div>'+  
                    '</div>'+
                    '<div class="form-group row" id="div_upgrade_class_los">'+
                      '<label class="col-md-6 col-form-label" style="text-align: left;" for="upgrade_class_los"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Masukkan jumlah hari naik kelas rawat.">Lama (hari)</label>'+
                      '<div class="col-md-6">'+
                        '<input type="text" class="form-control input_data_pasien text-center" id="upgrade_class_los" name="upgrade_class_los" value="0">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row" id="div_icu_los">'+
                      '<label class="col-md-6 col-form-label" style="text-align: left;" for="icu_los"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Untuk perbaikan tarif: <br>Masukan total jumlah hari rawat intensif"> Rawat Intensif (hari)</label>'+
                      '<div class="col-md-6">'+
                        '<input type="text" class="form-control input_data_pasien text-center" id="icu_los" name="icu_los" value="0">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;" for="nama_dokter">DPJP</label>'+
                      '<div class="col-md-9">'+
                        '<select class="form-control input_data_pasien select2" name="nama_dokter" id="nama_dokter" style="width: 100%"></select>'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                  '<div class="col-md-6">'+
                    '<div class="form-group row" id="div_add_payment_pct">'+
                      '<label class="col-md-8 col-form-label" style="text-align: left;" for="add_payment_pct"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Koefisien pengali sesuai peraturan yang berlaku. <br>Silakan klik kemudian ketik persentasenya <br>atau gunakan tombol panah atas/bawah">Koefisien Tambahan Biaya Naik Kelas</label>'+
                      '<div class="col-md-4">'+
                        '<input type="text" class="form-control input_data_pasien text-center" id="add_payment_pct" name="add_payment_pct" value="0">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;">Tgl. Lahir</label>'+
                      '<div class="col-md-9">'+
                        '<input type="text" class="form-control input_data_pasien pull-right date_picker" id="tgl_lahir_pasien" name="tgl_lahir" value="">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;" for="kelas_rawat">Kelas Hak</label>'+
                      '<div class="col-md-9">'+
                        '<div class="demo-radio-button">'+
                          '<input type="radio" name="kelas_rawat" value="3" id="kelas_rawat_3">'+
                          '<label for="kelas_rawat_3">Kelas 3</label>'+
                          '<input type="radio" name="kelas_rawat" value="2" id="kelas_rawat_2">'+
                          '<label for="kelas_rawat_2">Kelas 2</label>'+
                          '<input type="radio" name="kelas_rawat" value="1" id="kelas_rawat_1">'+
                          '<label for="kelas_rawat_1">Kelas 1</label>'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;" for="birth_weight">Berat Lahir</label>'+
                      '<div class="col-md-9">'+
                        '<input type="text" class="form-control input_data_pasien text-center" id="birth_weight" name="birth_weight" value="0">'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                      '<label class="col-md-3 col-form-label" style="text-align: left;" for="discharge_status">Cara Pulang</label>'+
                      '<div class="col-md-9">'+
                        '<select name="discharge_status" id="discharge_status" class="form-control input_data_pasien" required>'+
                          '<option value="1">Atas Persetujuan Dokter</option>'+
                          '<option value="2">Dirujuk</option>'+
                          '<option value="3">Atas Permintaan Sendiri</option>'+
                          '<option value="4">Meninggal</option>'+
                          '<option value="5">Lain-lain</option>'+
                        '</select>'+
                      '</div>'+    
                    '</div>'+
                    '<div class="form-group row" id="div_upgrade_class_class">'+
                      '<label class="col-md-5 col-form-label" style="text-align: left;" for="naik_kelas_rawat"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Masukkan kenaikan kelas yang diambil pasien.">Naik Kelas Rawat</label>'+
                      '<div class="col-md-7">'+
                        '<select name="upgrade_class_class" id="upgrade_class_class" class="form-control input_data_pasien">'+
                          '<option value="" selected>-- Pilih Kelas --</option>'+
                          '<option value="kelas_2">Kelas 2</option>'+
                          '<option value="kelas_1">Kelas 1</option>'+
                          '<option value="vip">Kelas VIP</option>'+
                          '<option value="vvip">Kelas VVIP</option>'+
                        '</select>'+
                      '</div>'+
                    '</div>'+
                    '<div class="form-group row" id="div_ventilator_hour">'+
                      '<label class="col-md-5 col-form-label" style="text-align: left;" for="ventilator_hour"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Untuk perbaikan tarif:<br/>Masukkan total jumlah jam pemakaian ventilator"> Ventilator (jam)</label>'+
                      '<div class="col-md-7">'+
                        '<input type="text" class="form-control input_data_pasien text-center" id="ventilator_hour" name="ventilator_hour" value="0">'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</div>'+
                          
                '<input type="hidden" class="form-control" id="diagnosa" name="diagnosa" value="">'+
                '<input type="hidden" class="form-control" id="procedure" name="procedure" value="">'+  
                '<input type="hidden" class="form-control" name="id_poli" value="">'+
                '<!-- Activities of Daily Living -->'+
                '<input type="hidden" class="form-control" id="adl_sub_acute" name="adl_sub_acute" value="">'+
                '<input type="hidden" class="form-control" id="adl_chronic" name="adl_chronic" value="">'+
                '<!-- Payor ID -->'+  
                '<input type="hidden" class="form-control" id="payor_id" name="payor_id" value="3" readonly>'+        
                '<!-- Jika pasien COB -->'+ 
                '<input type="hidden" class="form-control" id="cob_cd" name="cob_cd" value="#">'+
                '<!-- Status Klaim di SIMRS -->'+  
                '<input type="hidden" class="form-control" id="status" name="status" value="0">'+ 
                '<!-- <input type="hidden" class="form-control text-center" id="tarif_poli_eks" name="tarif_poli_eks" value="0"> -->'+
              '</div>'+
            '</div>'+
            '<div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125);">'+
                '<h4 class="card-title m-b-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" title="Total nilai tertagih pada perawatan dalam satu episode,<br> tidak termasuk item tagihan pada <strong>Tarif Non INA-CBG</strong> yang tersebut dibawah.">Tarif Rumah Sakit : <span class="font-weight-bold" id="total_tarif_rs" style="display:inline-block;border-left:0;font-size:1.1em;text-align:left;font-family: sans-serif;"></span></h4>'+
            '</div>'+
            '<div class="card-body" style="padding-top: 30px;padding-bottom30px;">'+
              '<div class="row">'+
                <?php
                  foreach ($kelompok_tarif as $row) { ?>
                    '<div class="col-md-4">'+
                      '<div class="form-group row">'+
                        '<label class="col-sm-7"><h6 style="font-size: 11px;font-weight: 600;"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-animation="false" data-placement="right" title="<?php echo $row->description; ?>"><?php echo $row->nama_kel; ?></h6></label>'+
                        '<div class="col-sm-5">'+
                          '<input class="form-control text-center input_tarif_rs" type="text" name="<?php echo $row->attribute; ?>" id="<?php echo $row->attribute; ?>">'+
                        '</div>'+
                      '</div>'+
                    '</div>'+
                <?php } ?>
                '<div class="col-md-12 text-center">'+
                    '<label class="checkbox-inline">'+
                        '<input class="filled-in" id="agree" type="checkbox" value="ya" disabled checked><small class="text-muted">Menyatakan bahwa data tarif tersebut di atas adalah benar sesuai dengan kondisi yang sesungguhnya.</small>'+
                        '<br>'+
                    '</label>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125);">'+
              '<h4 class="card-title m-b-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-animation="false" data-placement="right" title="Kode diagnosa akan dicheck terhadap versi ICD-10 yang berlaku. <br>Jika ada kode yang tidak terdaftar atau berlaku, maka kode tersebut tidak akan tersimpan.">Diagnosa (ICD-10) : </h4>'+
            '</div>'+
            '<div class="card-body">'+
              '<div class="form-group">'+ 
                '<div class="col-md-5 float-right">'+
                  '<select class="form-control" name="id_diagnosa" id="id_diagnosa" style="width: 100%;"></select>'+
                '</div>'+
                '<label class="col-md-2 col-form-label float-right">Cari Diagnosa :</label>'+
              '</div>'+
              '<div class="table-responsive">'+
              '<br/>'+
                '<table id="table_diagnosa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">'+
                  '<thead>'+
                    '<tr>'+
                      '<th class="text-center">No</th>'+
                      '<th>Diagnosa</th>'+
                      '<th>Catatan</th>'+
                      '<th class="text-center">Klasifikasi</th>'+
                      '<th class="text-center">Status</th>'+
                      '<th class="text-center">Aksi</th>'+
                    '</tr>'+
                  '</thead>'+
                  '<tbody>'+
                  '</tbody>'+
                '</table>'+
              '</div>'+
            '</div>'+
            '<div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125);">'+
              '<h4 class="card-title m-b-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-animation="false" data-placement="right" title="Kode procedure akan dicheck terhadap versi ICD-9-CM yang berlaku.<br> Jika ada kode yang tidak terdaftar atau berlaku, maka kode tersebut tidak akan tersimpan.">Prosedur (ICD-9-CM) : </h4>'+
            '</div>'+
            '<div class="card-body">'+
              '<div class="form-group">'+ 
                '<div class="col-md-5 float-right">'+
                  '<select class="form-control" name="id_procedure" id="id_procedure" style="width: 100%;"></select>'+
                '</div>'+
                '<label class="col-md-2 col-form-label pull-right">Cari Prosedur :</label>'+ 
              '</div>'+
              '<div class="table-responsive">'+
                '<br/>'+
                '<table id="table_procedure" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">'+
                  '<thead>'+
                    '<tr>'+
                      '<th class="text-center">No</th>'+
                      '<th>Prosedur</th>'+
                      '<th class="text-center">Aksi</th>'+
                    '</tr>'+
                  '</thead>'+
                  '<tbody>'+
                  '</tbody>'+
                '</table>'+
              '</div>'+
            '</div>'+
            '<div><hr style="margin-bottom: 0;margin-top: 0;"></div>'+
            '<div class="card-body">'+
              '<div class="col-md-12" id="div-btn-service1">'+
              '</div>'+
            '</div>'+ 
          '</div>'+
          '<!-- /.card -->'+
        '</div>'+
      '</div>'+
      '<div class="row" id="grouper_result">'+
        '<div class="col-md-12">'+
          '<div class="card">'+
            '<div class="card-body" style="padding-bottom: 20px;">'+
              '<div class="col-md-12">'+
                '<h4 class="text-center" style="margin-bottom: 20px;">Hasil Grouper</h4>'+
                '<div class="table-responsive m-t-15" style="clear: both;">'+
                  '<table class="table table-hover m-b-0" id="table-grouper-result">'+
                    '<tbody>'+
                      '<tr>'+
                        '<td class="text-right" style="border-right: 1px solid #ededed;">Info 0</td>'+
                        '<td>INACBG @ <span id="grouper_at"></span> •• Kelas <span id="kelas_rs_result"></span> •• Tarif : TARIF RS KELAS <span id="tarif_kelas_result"></span></td>'+
                        '<td></td>'+
                        '<td></td>'+
                        '<td></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Jenis Rawat</td>'+
                         '<td><span id="jenis_rawat_result"></span> Kelas <span id="kelas_rawat_result"></span></td>'+
                          '<td></td>'+
                          '<td></td>'+
                          '<td></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Group</td>'+
                          '<td id="description_cbg"></td>'+
                          '<td class="text-center" id="code_cbg"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="tarif_cbg"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Sub Acute</td>'+
                          '<td id="sub_acute_description"></td>'+
                          '<td class="text-center" id="sub_acute_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="sub_acute_tarif"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Chronic</td>'+
                          '<td id="chronic_description"></td>'+
                          '<td class="text-center" id="chronic_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="chronic_tarif"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Special Procedure</td>'+
                          '<td id="special_procedure_description"></td>'+
                          '<td class="text-center" id="special_procedure_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="special_procedure_tarif"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Special Prosthesis</td>'+
                          '<td id="special_prosthesis_description"></td>'+
                          '<td class="text-center" id="special_prosthesis_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="special_prosthesis_tarif"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Special Investigation</td>'+
                          '<td id="special_investigation_description"></td>'+
                          '<td class="text-center" id="special_investigation_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="special_investigation_tarif"></td>'+
                      '</tr>'+
                      '<tr>'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Special Drug</td>'+
                          '<td id="special_drug_description"></td>'+
                          '<td class="text-center" id="special_drug_code"></td>'+
                          '<td class="text-right">Rp</td>'+
                          '<td class="text-right tarif_result" id="special_drug_tarif"></td>'+
                      '</tr>'+
                      '<tr id="tr_status_klaim">'+
                          '<td class="text-right" style="border-right: 1px solid #ededed;">Status Data Klaim</td>'+
                          '<td id="status_data_klaim"></td>'+
                          '<td></td>'+
                          '<td></td>'+
                          '<td></td>'+
                      '</tr>'+
                      '<tr>'+
                        '<td class="text-right" colspan="4"><h4>Total Rp</h4></td>'+
                        '<td class="text-right"><h4 id="total_tarif"></h4></td>'+
                      '</tr>'+
                      '<tr class="tambahan_biaya_result"><td class="text-center" colspan="5" style="font-weight:bold;">Tambahan Biaya Yang Dibayar Pasien Untuk Naik Kelas 2</td></tr>'+
                      '<tr class="tambahan_biaya_result">'+
                        '<td>Tambahan Biaya</td>'+
                        '<td colspan="2" class="text-right">'+
                          '<span style="cursor:default;" data-tooltip="Tarif Kelas 2">'+
                          '<span>Rp</span> 6,299,700</span> -'+
                          '<span style="cursor:default;" data-tooltip="Tarif Kelas 3"><span class="">Rp</span> 5,249,700</span>'+
                        '</td>'+
                        '<td>=&nbsp;Rp</td>'+
                        '<td class="text-right" id="td_add_payment_amt"></td>'+
                      '</tr>'+
                    '</tbody>'+
                  '</table>'+
                '</div>'+
              '</div>'+
              '<div class="col-md-12">'+
                '<div class="clearfix"></div>'+
                '<hr>'+
                '<div id="div-btn-service2">'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</div>'+
    '</form>';
  }

  function reset_result_sep() { 
    $('#no_register').val('');
    $('#show_sep').empty();
    $('#show_tgl_sep').empty();
    $('#show_no_rujukan').empty();
    $('#show_jns_pelayanan').empty();
    $('#show_kls_rawat').empty();
    $('#show_poli').empty();
    $('#show_nama').empty();
    $('#show_no_bpjs').empty();
    $('#show_diagnosa').empty();
    $('#show_catatan').empty();
    $('#show_result_sep').hide();
  }

  function tarif_rs(){  
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('inacbg/pasien/tarif_rs'); ?>"+"/"+no_register,
      dataType: "JSON", 
      beforeSend:function() {
        check_login();
        $(".input_tarif_rs").addClass("load_input"); 
        $('#total_tarif_rs').html('<img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>">'); 
      },     
      success: function(result){  
        var total = 0;             
        if (result) {  
          $(".input_tarif_rs").removeClass("load_input");            
          $('#prosedur_non_bedah').val(result.tarif_prosedur_non_bedah);  
          $('#prosedur_bedah').val(result.tarif_prosedur_bedah);  
          $('#konsultasi').val(result.tarif_konsultasi);  
          $('#tenaga_ahli').val(result.tarif_tenaga_ahli);  
          $('#keperawatan').val(result.tarif_keperawatan);  
          $('#penunjang').val(result.tarif_penunjang);  
          $('#radiologi').val(result.tarif_radiologi);  // daftar_ulang_irj
          $('#laboratorium').val(result.tarif_laboratorium);  // daftar_ulang_irj 
          $('#pelayanan_darah').val(result.tarif_pelayanan_darah);  
          $('#rehabilitasi').val(result.tarif_rehabilitasi);  
          $('#kamar').val(result.tarif_kamar);  
          $('#rawat_intensif').val(result.tarif_rawat_intensif);  
          $('#obat').val(result.tarif_obat);   // daftar_ulang_irj
          $('#obat_kronis').val(result.tarif_obat_kronis);  // daftar_ulang_irj
          $('#obat_kemoterapi').val(result.tarif_obat_kemoterapi);  // daftar_ulang_irj
          $('#alkes').val(result.tarif_alkes);  // daftar_ulang_irj
          $('#bmhp').val(result.tarif_bmhp);  
          $('#sewa_alat').val(result.tarif_sewa_alat);   
          total_tarif_rs();
        } else {
          $(".input_tarif_rs").removeClass("load_input");           
          $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));  
          $('#prosedur_non_bedah').val(0);  
          $('#prosedur_bedah').val(0); 
          $('#konsultasi').val(0); 
          $('#tenaga_ahli').val(0); 
          $('#keperawatan').val(0); 
          $('#penunjang').val(0); 
          $('#radiologi').val(0);
          $('#laboratorium').val(0);
          $('#pelayanan_darah').val(0); 
          $('#rehabilitasi').val(0); 
          $('#kamar').val(0);  
          $('#rawat_intensif').val(0);  
          $('#obat').val(0);
          $('#obat_kronis').val(0);
          $('#obat_kemoterapi').val(0);
          $('#alkes').val(0);
          $('#bmhp').val(0); 
          $('#sewa_alat').val(0);                  
        }
      },
      error:function(event, textStatus, errorThrown) {       
        $(".input_tarif_rs").removeClass("load_input");     
        swal("Gagal load data tarif rs", formatErrorMessage(event, errorThrown), "error");     
      }    
    });
  }

  function total_tarif_rs(){  
        $('#total_tarif_rs').html('<img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>">'); 
        var total = parseInt($('#prosedur_non_bedah').val())+  
          parseInt($('#prosedur_bedah').val())+  
          parseInt($('#konsultasi').val())+  
          parseInt($('#tenaga_ahli').val())+  
          parseInt($('#keperawatan').val())+  
          parseInt($('#penunjang').val())+  
          parseInt($('#radiologi').val())+  
          parseInt($('#laboratorium').val())+  
          parseInt($('#pelayanan_darah').val())+  
          parseInt($('#rehabilitasi').val())+  
          parseInt($('#kamar').val())+  
          parseInt($('#rawat_intensif').val())+  
          parseInt($('#obat').val())+  
          parseInt($('#obat_kronis').val())+  
          parseInt($('#obat_kemoterapi').val())+  
          parseInt($('#alkes').val())+  
          parseInt($('#bmhp').val())+  
          parseInt($('#sewa_alat').val());
        $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));  
  }
</script>
<br>
<div class="row"> 
  <div class="col-lg-12 col-md-12">    
    <div class="card card-outline-info">
      <div class="card-header">
        <h4 class="m-b-0 text-white"><i class="fa fa-check-square-o"></i> Coding / Grouping</h4>
      </div>
      <div class="card-block">      
        <div class="form-group row mb-0">    
          <label class="col-sm-2 col-form-label col-form-label" style="text-align: left;">Cari Berdasarkan :</label>            
          <div class="col-sm-2">
            <select class="form-control" name="category" id="category">
              <option value="1" selected>No. RM</option>
              <option value="2">No. SEP</option>
              <option value="3">Nama Pasien</option>
              <option value="4">NIK</option>
            </select>
          </div>
          <div class="col-sm-4">
            <div class="input-group">
              <input type="hidden" class="form-control" name="no_cm" id="no_cm">                    
              <input type="text" class="form-control" name="cari_pasien" id="cari_pasien">
              <span class="input-group-btn">
                  <button class="btn btn-primary" type="button" id="btn-cari"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div> 
        </div>                        
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-md-12">
    <div class="card card-outline-default" id="show-pasien">
      <div class="card-header">
         <!--  <div class="card-actions">               
              <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
          </div> -->
          <!-- <h4 class="m-b-0 text-white"><span id="no_rm"></span> <span style="color:#fff;" id="separate_rm">••</span> <span id="nama_pasien"></span> <span style="color:#fff;" id="separate_nama">••</span> <span id="gender"></span> <span style="color:#fff;" id="separate_gender">••</span> <span id="tgl_lahir"></span> </h4> -->
          <div class="d-flex flex-row comment-row">
            <!-- <div class="p-2"> -->
            <img src="<?php echo site_url("assets/images/user_unknown.png"); ?>" alt="user" width="45" height="45">
            <!-- </div> -->
            <div class="comment-text w-100">
              <h5 class="username box-title" id="nama_pasien" style="margin-bottom: 4px;"></h5>
              <p style="margin-bottom: 0;"><span id="no_rm"></span> <span style="color:#444;" id="separate_rm">••</span> <span id="gender"></span> <span style="color:#444;" id="separate_gender">••</span> <span id="tgl_lahir"></span></p>
            </div>
          </div>
      </div>
      <div class="card-body b-t p-t-20 p-b-20 text-center" id="show-loading" style="padding: 20px;">
        <p style="font-size: 16px;font-weight: 600;"><i class="fa fa-spinner fa-spin"></i>&nbsp; Menampilkan Data Pelayanan</p>
      </div>
      <div class="card-body b-t p-b-20" id="show-table-pelayanan">
        <br>
        <div class="col-md-12">
          <table id="table-pelayanan" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr> 
                <th class="text-center">Pilih</th>               
                <th>No. Register</th>
                <th>Tgl. Masuk</th>
                <th>Tgl. Pulang</th>
                <th>No. SEP</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">CBG</th>
                <th class="text-center">Status</th>                                       
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>            
      </div>
    </div>
  </div>
</div>  

<div id="modal_sep" class="modal fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-success">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="modal-search-kode">Edit SEP</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form id="form_sep_manual" class="form-horizontal">
        <div class="modal-body" style="background-color: #ecf0f5;">     
          <div class="form-group row">
            <label for="no_sep_manual" class="col-sm-2 col-form-label" style="text-align: left;">No. SEP</label> 
            <div class="col-sm-10">
              <input type="text" class="form-control" name="no_sep_manual" id="no_sep_manual" placeholder="Masukkan Nomor SEP"> 
            </div>
          </div>                                       
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-sep-manual"><i class="fa fa-floppy-o"></i> Simpan</button>
        </div>
      </form> 
    </div>
  </div>
</div>
<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>