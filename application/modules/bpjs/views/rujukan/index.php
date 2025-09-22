<?php
  if ($role_id == 1) {
      $this->load->view("layout/header_left");
  } else {
      $this->load->view("layout/header_horizontal");
  }
?>
<style type="text/css">
  .custom-modal .modal-header {
    color: #887056;
    border-bottom:1px solid #ddd;
    background-color: #eae4ce;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }
  .custom-modal .modal-footer {
    color: #887056;
    border-top: 1px solid #ddd;
    background-color: #eae4ce;
    -webkit-border-bottom-left-radius: 5px;
    -webkit-border-bottom-right-radius: 5px;
    -moz-border-radius-bottomleft: 5px;
    -moz-border-radius-bottomright: 5px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
  }
 
  .select-dropdown {
    position: static;
  }
  .select-dropdown .select-dropdown--above {
    margin-top: 336px;
  } 
  .demo-radio-button label{
    min-width: 90px;
  }
  .form-horizontal label {
    margin-bottom: 5px;
  }
  textarea { resize: vertical; }
  input:focus::-webkit-input-placeholder { color:transparent; }
  input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
  input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
  input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
  textarea:focus::-webkit-input-placeholder { color:transparent; }
  textarea:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
  textarea:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
  textarea:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
  ::-webkit-input-placeholder {
      font-style: italic;
  }
  :-moz-placeholder {
     font-style: italic;  
  }
  ::-moz-placeholder {
     font-style: italic;  
  }
  :-ms-input-placeholder {  
     font-style: italic; 
  }
  .date_picker { z-index:1151 !important; }
</style>
<script type="text/javascript">  
  var table_rujukan;  
  $(document).ready(function() {       
    $('#poli_rujukan,#update_poli_rujukan').select2({
      placeholder: '-- Ketik Kode atau Nama Poli --',
      minimumInputLength: 3,
      language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
      ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/poli_select2'; ?>',
        dataType: 'JSON',          
        delay: 250,
        processResults: function (data) {            
          return {
            results: data
          };
        },
        cache: true
      }
    });
    $('#ppk_dirujuk,#update_ppk_dirujuk').select2({
      placeholder: '-- Ketik Kode atau Nama PPK --',
      minimumInputLength: 3,
      language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
      ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/faskes_select2'; ?>',
        data: function (term, page) {
          return {
            q: term,
            asal_rujukan: '2'
          };
        },
        dataType: 'JSON',          
        delay: 250,
        processResults: function (data) {            
          return {
            results: data
          };
        },
        cache: true
      }
    });
    $('#diagnosa_rujukan,#update_diagnosa_rujukan').select2({
      placeholder: '-- Ketik Kode atau Nama Diagnosa --',
      minimumInputLength: 3,
      language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
      ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/diagnosa_select2'; ?>',
        dataType: 'JSON',          
        delay: 250,
        processResults: function (data) {            
          return {
            results: data
          };
        },
        cache: true
      }
    });
    $("#form-create-rujukan").submit(function(event) {
      var no_sep = $('#cari_sep').val();
      $('.btn-cari-sep').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      if (no_sep === '') {
        $('.btn-cari-sep').html('<i class="fa fa-search"></i> Cari Data');
        swal("Nomor SEP kosong.", "Masukkan nomor SEP terlebih dahulu.", "warning");
      } else {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url().'bpjs/rujukan/sep/'; ?>"+no_sep,
          dataType: "JSON",    
          success: function(result) {            
            if (result) {
              $('.btn-cari-sep').html('<i class="fa fa-search"></i> Cari Data');  
              if (result.metaData.code == '200') { 
                $('#no_sep').val(result.response.noSep);
                $('#tgl_sep').val(result.response.tglSep); 
                $('#noka').val(result.response.peserta.noKartu); 
                $('#nama').val(result.response.peserta.nama); 
                $('#tgl_lahir').val(result.response.peserta.tglLahir); 
                $('#kelas').val(result.response.peserta.hakKelas); 
                $('#diagnosa_sep').val(result.response.diagnosa);           
                $('#modal-create').modal('show');   
              } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
                swal("SEP Tidak Ditemukan","No. SEP Harus 19 digit.", "warning");  
              } else {
                swal("Gagal mencetak SEP", result.metaData.message, "error");           
              }          
            } else {          
              $('.btn-cari-sep').html('<i class="fa fa-search"></i> Cari Data');  
              swal("Error","Gagal mencari SEP", "error");            
            }                     
          },
          error:function(event, textStatus, errorThrown) {    
              $('.btn-cari-sep').html('<i class="fa fa-search"></i> Cari Data');
              swal("Gagal mencari SEP",formatErrorMessage(event, errorThrown), "error");    
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);              
          }
        });
      } 
      event.preventDefault();
    });          
    $("#form_create").submit(function(event) {   
      $("#btn-create").html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/rujukan/create'; ?>",
        dataType: "JSON", 
        data: $("#form_create").serialize(),
        success: function(result) {  
          $("#btn-create").html('<i class="fa fa-paper-plane-o"></i> Buat Rujukan'); 
          $('#modal-create').modal('hide');
          if (result.metaData.code == '200') {     
            window.open('<?php echo base_url().'bpjs/rujukan/cetak_rujukan/'; ?>'+result.response.rujukan.noRujukan, '_blank');
            table_rujukan.ajax.reload(); 
            swal("Sukses", "Silahkan Cetak Rujukan", "success");       
          } else {
            swal("Gagal Membuat Rujukan", result.metaData.message, "error");   
          }           
        },
        error:function(event, textStatus, errorThrown) {    
            $("#btn-create").html('<i class="fa fa-paper-plane-o"></i> Buat Rujukan'); 
            $('#modal-create').modal('hide');
            swal("Gagal Membuat Rujukan",formatErrorMessage(event, errorThrown), "error");    
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      }); 
      event.preventDefault();
    });
    $("#form_update").submit(function(event) {   
      $("#btn-update").html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/rujukan/update'; ?>",
        dataType: "JSON", 
        data: $("#form_update").serialize(),
        success: function(result) {  
          $("#btn-update").html('<i class="fa fa-paper-plane-o"></i> Update Rujukan'); 
          $('#modal-update').modal('hide');
          if (result.metaData.code == '200') {     
            window.open('<?php echo base_url().'bpjs/rujukan/cetak/'; ?>'+result.response, '_blank');
            table_rujukan.ajax.reload(); 
            swal("Update Berhasil.", "Silahkan Cetak Rujukan", "success");       
          } else {
            swal("Gagal Update Rujukan", result.metaData.message, "error");   
          }           
        },
        error:function(event, textStatus, errorThrown) {    
            $("#btn-update").html('<i class="fa fa-paper-plane-o"></i> Update Rujukan'); 
            $('#modal-update').modal('hide');
            swal("Gagal Update Rujukan",formatErrorMessage(event, errorThrown), "error");    
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      }); 
      event.preventDefault();
    }); 
    $(document).on("click",".update-rujukan",function() {
      var button = $(this);
      var no_rujukan = button.data("no-rujukan");
      button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/rujukan/show_rujukan/'; ?>"+no_rujukan,
        dataType: "JSON",    
        success: function(result) { 
          button.html('<i class="fa fa-pencil-square-o"></i> Update'); 
          if (result) {
            $('#update_norujukan').val(result.no_rujukan);
            if (result.jenis_pelayanan == 1) {
              $('#update_pelayanan_iri').prop('checked',true);
            }
            if (result.jenis_pelayanan == 2) {
              $('#update_pelayanan_irj').prop('checked',true);
            }
            if (result.tipe_rujukan == 0) {
              $('#update_penuh').prop('checked',true);
            }
            if (result.tipe_rujukan == 1) {
              $('#update_partial').prop('checked',true);
            }
            if (result.tipe_rujukan == 2) {
              $('#update_rujuk_balik').prop('checked',true);
            }
            var update_ppk_dirujuk = $("<option></option>").val(result.kode_ppk_dirujuk+' - '+result.nama_ppk_dirujuk).text(result.nama_ppk_dirujuk);
            $("#update_ppk_dirujuk").append(update_ppk_dirujuk).trigger('change');
            var update_poli_rujukan = $("<option></option>").val(result.kode_poli_rujukan+' - '+result.nama_poli_rujukan).text(result.nama_poli_rujukan);
            $("#update_poli_rujukan").append(update_poli_rujukan).trigger('change');
            var update_diagnosa_rujukan = $("<option></option>").val(result.diagnosa).text(result.diagnosa);
            $("#update_diagnosa_rujukan").append(update_diagnosa_rujukan).trigger('change');
            $('#update_catatan').val(result.keterangan);
            $('#modal-update').modal('show');
          } else {  
            swal("Error","Gagal load data rujukan.", "error");            
          } 
        },
        error:function(event, textStatus, errorThrown) {    
            button.html('<i class="fa fa-pencil-square-o"></i> Update'); 
            swal("Gagal load data rujukan.",textStatus, "error");    
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }); 
    $(document).on("click",".delete-rujukan",function() {
      var button = $(this);
      var no_rujukan = button.data("no-rujukan");
      swal({
        title: "Hapus No. Rujukan",
        text: "Yakin akan menghapus No. Rujukan tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'bpjs/rujukan/delete'; ?>",
            dataType: "JSON",
            data: {'no_rujukan' : no_rujukan},
            success: function(result) {
                if (result) {
                  if (result.metaData.code == '200') {
                    table_rujukan.ajax.reload();
                    swal("Sukses", "No. Rujukan berhasil dihapus.", "success");
                  } else {
                      swal("Gagal menghapus No. Rujukan", result.metaData.message, "error");
                  }
                } else {
                  swal("Gagal menghapus No. Rujukan", "Silahkan coba lagi.", "error");
                }  
                
            },
            error:function(event, textStatus, errorThrown) {    
                swal("Gagal Menghapus No. Rujukan.",textStatus, "error");     
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
          });
      });
    }); 
   
    $(document).on('hidden.bs.modal', '#modal-create', function () {
      $("#form_create")[0].reset();
      $("#ppk_dirujuk").val('').trigger('change');
      $("#poli_rujukan").val('').trigger('change');
      $("#diagnosa_rujukan").val('').trigger('change');
      $("#btn-create").html('<i class="fa fa-paper-plane-o"></i> Buat Rujukan'); 
    });
    $(document).on('hidden.bs.modal', '#modal-update', function () {
      $("#form_update")[0].reset();
      $("#update_ppk_dirujuk").val('').trigger('change');
      $("#update_poli_rujukan").val('').trigger('change');
      $("#update_diagnosa_rujukan").val('').trigger('change');
      $("#btn-update").html('<i class="fa fa-paper-plane-o"></i> Update Rujukan'); 
    });
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",      
      autoclose: true,
      todayHighlight: true,
      beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
          inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
      }
    }); 
    $('#tanggal_cari').daterangepicker({      
      locale: {
          format: 'YYYY/MM/DD'
      },
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-danger',
      cancelClass: 'btn-inverse'
    });
    $('#tanggal_cari').on('apply.daterangepicker', function(ev, picker) {
      table_rujukan.ajax.reload(); 
      var bulan = ['','Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; 
      var from_month = parseInt(picker.startDate.format('MM'));
      var to_month = parseInt(picker.endDate.format('MM'));                            
      $('#from_date').html(picker.startDate.format('DD')+' '+bulan[from_month]+ ' '+picker.startDate.format('YYYY')); 
      $('#to_date').html(picker.endDate.format('DD')+' '+bulan[to_month]+ ' '+picker.endDate.format('YYYY'));      
    });
    table_rujukan = $('#table-rujukan').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('bpjs/rujukan/get_rujukan')?>",
        "type": "POST",
        "dataType": "JSON",
        "data": function (data) {
          data.tanggal_cari = $('#tanggal_cari').val();
        }   
      },
      "columnDefs": [
        { "orderable": false, "targets": [0,6]},
        { "width": "7%", "targets": 0 },
        { "width": "14%", "targets": 5 },
        { "width": "12%", "targets": 6 }
      ],   
    });      
  });
</script>

<div class="row">
  <div class="col-lg-12 col-md-12"> 
    <div class="card card-outline-info">
      <div class="card-block">  
        <form id="form-create-rujukan">
          <div class="form-group row m-b-0">
            <label class="col-3 col-form-label">Pembuatan Rujukan : </label>
            <div class="col-5">            
                <input type="text" class="form-control" name="cari_sep" id="cari_sep" placeholder="Masukkan Nomor SEP...">
            </div> 
            <div class="col-3">
              <button type="submit" class="btn btn-primary btn-cari-sep"><i class="fa fa-search"></i> Cari Data</button> 
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-md-12">    
    <div class="card card-outline-info">
      <div class="card-header">             
      <h4 class="m-b-0 text-white text-center">Daftar Rujukan Tanggal <span id="from_date"><?php echo date_indo(date("Y-m-d",strtotime("-7 days")));?></span> s/d <span id="to_date"><?php echo date_indo(date('Y-m-d')); ?></h4> 
      </div>       
      <div class="card-block">  
        <?php $attributes = array('id' => 'form_cari');
        echo form_open('irj/rjcregistrasi/pasien',$attributes);?>
          <div class="form-group row m-b-0">
            <label for="example-text-input" class="col-2 col-form-label">Cari Data : </label>
            <div class="col-4">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="tanggal_cari" id="tanggal_cari" value="<?php echo date("Y/m/d",strtotime("-7 days"));?> - <?php echo date('Y/m/d'); ?>">
              </div>
            </div>
          </div>    
        <?php echo form_close();?> 
        <hr>
        <div class="table-responsive m-t-0">      
          <table id="table-rujukan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">No. Rujukan</th>              
                <th class="text-center">No. SEP</th> 
                <th class="text-center">Poli Rujukan</th>              
                <th>Nama</th>
                <th>No. Kartu</th>
                <th class="text-center">Tgl Rujukan</th>                
                <th class="text-center">Aksi</th>
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

  <div class="modal fade custom-modal" id="modal-create" role="dialog" aria-labelledby="modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
              <h4 class="modal-title">Pembuatan Rujukan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form role="form" class="form-horizontal m-t-15" id="form_create">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nosep">Nomor SEP</label>
                        <input type="text" class="form-control" name="no_sep" id="no_sep" readonly>
                    </div>
                    <div class="form-group">
                      <label for="tgl_sep">Tanggal SEP</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control" name="tgl_sep" id="tgl_sep" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="noka">No. Kartu</label>
                        <input type="text" class="form-control" name="noka" id="noka" readonly>
                    </div>                
                    <div class="form-group">
                      <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" readonly>
                    </div>  
                    <div class="form-group">
                      <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" readonly>
                    </div>    
                    <div class="form-group">
                      <label for="kelas">Hak Kelas</label>
                        <input type="text" class="form-control" name="kelas" id="kelas" readonly>
                    </div>            
                    <div class="form-group">
                      <label for="diagnosa_sep">Diagnosa</label>
                        <textarea class="form-control" name="diagnosa_sep" id="diagnosa_sep" cols="30" rows="3" readonly></textarea>
                    </div>  
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="tgl_rujukan">Tanggal Rujukan</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control date_picker" name="tgl_rujukan" id="tgl_rujukan" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>Pelayanan</label>                  
                        <div class="demo-radio-button">                    
                            <input class="with-gap" type="radio" name="jenis_pelayanan" value="2" id="pelayanan_irj" required checked>
                            <label for="pelayanan_irj">Rawat Jalan</label>
                            <input class="with-gap" type="radio" name="jenis_pelayanan" value="1" id="pelayanan_iri" required>
                            <label for="pelayanan_iri">Rawat Inap</label>
                        </div>                 
                    </div>
                    <div class="form-group">
                      <label>Tipe</label>                  
                        <div class="demo-radio-button">                    
                            <input class="with-gap" type="radio" name="tipe_rujukan" value="0" id="penuh" required checked>
                            <label for="penuh">Penuh</label>
                            <input class="with-gap" type="radio" name="tipe_rujukan" value="1" id="partial" required>
                            <label for="partial">Partial</label>
                            <input class="with-gap" type="radio" name="tipe_rujukan" value="2" id="rujuk_balik" required>
                            <label for="rujuk_balik">Rujuk Balik</label>
                        </div>                 
                    </div>
                    <div class="form-group">
                      <label for="ppk_dirujuk">Dirujuk ke</label>
                        <select class="form-control" name="ppk_dirujuk" id="ppk_dirujuk" style="width: 100%;" required>             
                        </select>
                    </div>  
                    <div class="form-group">
                      <label for="poli_rujukan">Poli Rujukan</label>
                        <select class="form-control" name="poli_rujukan" id="poli_rujukan" style="width: 100%;" required>                      
                        </select>
                    </div>    
                    <div class="form-group">
                      <label for="diagnosa_rujukan">Diagnosa Rujukan</label>
                      <select class="form-control " name="diagnosa_rujukan" id="diagnosa_rujukan" style="width: 100%;" required>
                      </select>
                    </div>    
                    <div class="form-group">
                      <label for="catatan">Catatan Rujukan</label>
                        <textarea class="form-control" name="catatan" id="catatan" cols="30" rows="5" placeholder="Isi catatan apabila ada."></textarea>
                    </div>
                  </div>  
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-create"><i class="fa fa-paper-plane-o"></i> Buat Rujukan</button>
              </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
  </div> 

  <div class="modal fade custom-modal" id="modal-update" role="dialog" aria-labelledby="modal-update">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
              <h4 class="modal-title">Update Rujukan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form role="form" class="form-horizontal m-t-15" id="form_update">
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <label for="update_norujukan" class="col-sm-3 col-form-label">No. Rujukan</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_norujukan" id="update_norujukan" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Pelayanan</label>
                      <div class="col-sm-6" style="padding-top: 5px;">
                        <div class="demo-radio-button">                    
                            <input class="with-gap" type="radio" name="update_jenis_pelayanan" value="2" id="update_pelayanan_irj" required>
                            <label for="update_pelayanan_irj">Rawat Jalan</label>
                            <input class="with-gap" type="radio" name="update_jenis_pelayanan" value="1" id="update_pelayanan_iri" required>
                            <label for="update_pelayanan_iri">Rawat Inap</label>
                        </div>   
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Tipe</label>
                      <div class="col-sm-6" style="padding-top: 5px;">
                        <div class="demo-radio-button">                    
                            <input class="with-gap" type="radio" name="update_tipe_rujukan" value="0" id="update_penuh" required>
                            <label for="update_penuh">Penuh</label>
                            <input class="with-gap" type="radio" name="update_tipe_rujukan" value="1" id="update_partial" required>
                            <label for="update_partial">Partial</label>
                            <input class="with-gap" type="radio" name="update_tipe_rujukan" value="2" id="update_rujuk_balik" required>
                            <label for="update_rujuk_balik">Rujuk Balik</label>
                        </div>   
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Dirujuk ke</label>
                      <div class="col-sm-6" style="padding-top: 5px;">
                        <select class="form-control" name="update_ppk_dirujuk" id="update_ppk_dirujuk" style="width: 100%;" required>             
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Poli Rujukan</label>
                      <div class="col-sm-6" style="padding-top: 5px;">
                        <select class="form-control" name="update_poli_rujukan" id="update_poli_rujukan" style="width: 100%;" required>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Diagnosa Rujukan</label>
                      <div class="col-sm-6" style="padding-top: 5px;">
                        <select class="form-control " name="update_diagnosa_rujukan" id="update_diagnosa_rujukan" style="width: 100%;" required>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Catatan Rujukan</label>
                      <div class="col-sm-8" style="padding-top: 5px;">
                        <textarea class="form-control" name="update_catatan" id="update_catatan" cols="30" rows="5" placeholder="Isi catatan apabila ada."></textarea>
                      </div>
                    </div>
                  </div>  
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-update"><i class="fa fa-paper-plane-o"></i> Update Rujukan</button>
              </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
  </div>  

<?php
  if ($role_id == 1) {
      $this->load->view("layout/footer_left");
  } else {
      $this->load->view("layout/footer_horizontal");
  }
?>