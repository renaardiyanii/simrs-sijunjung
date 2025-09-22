<?php
  if ($role_id == 1) {
      $this->load->view("layout/header_left");
  } else {
      $this->load->view("layout/header_horizontal");
  }
?>
<style type="text/css">
  	th { font-size: 14px; }  	
</style>
<script type="text/javascript">
  var table_sep;  
  $(document).ready(function() {   
    $(document).on("click",".create_sep",function() {
      var no_register = $(this).data("noregister");
      swal({
        title: "Pembuatan SEP",
        text: "Yakin akan membuat SEP dengan pasien tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Buat SEP",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'bpjs/sep/create/'; ?>"+no_register,
            dataType: "JSON",    
            success: function(result) {  
              if (result.metaData.code == '200') { 
                table_sep.ajax.reload();         
                window.open('<?php echo base_url().'bpjs/sep/cetak_perincian/'; ?>'+no_register, '_blank');
                swal("Sukses", "Silahkan Cetak SEP", "success");   
              } else {
                swal("Gagal membuat SEP", result.metaData.message, "error");   
              }       
            },
            error:function(event, textStatus, errorThrown) {    
                swal("Gagal membuat SEP",formatErrorMessage(event, errorThrown), "error");    
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
          }); 
      });
    }); 
    $(document).on("click",".cetak_sep",function() {
      var button = $(this);
      var no_register = button.data("noregister");
      button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/sep/cari_sep/'; ?>"+no_register,
        dataType: "JSON",    
        success: function(result) {  
          button.html('<i class="fa fa-print"></i> Cetak');
          if (result) {
            if (result.metaData.code == '200') {          
              window.open('<?php echo base_url().'bpjs/sep/cetak_perincian/'; ?>'+no_register, '_blank');
            } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
              swal("SEP Tidak Ditemukan","No. SEP Harus 19 digit.", "warning");  
            } else {
              swal("Gagal mencetak SEP", result.metaData.message, "error");           
            }          
          } else {        
            swal("Error","Gagal mencetak SEP", "error");            
          } 
            
        },
        error:function(event, textStatus, errorThrown) {    
            button.html('<i class="fa fa-print"></i> Cetak');
            swal("Gagal mencetak SEP",textStatus, "error");    
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }); 
    $('#tanggal_cari').daterangepicker({      
      locale: {
          format: 'DD/MM/YYYY'
      },
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-danger',
      cancelClass: 'btn-inverse'
    });
    $('#tanggal_cari').on('apply.daterangepicker', function(ev, picker) {
      table_sep.ajax.reload(); 
      var bulan = ['','Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; 
      var from_month = parseInt(picker.startDate.format('MM'));
      var to_month = parseInt(picker.endDate.format('MM'));                            
      $('#from_date').html(picker.startDate.format('DD')+' '+bulan[from_month]+ ' '+picker.startDate.format('YYYY')); 
      $('#to_date').html(picker.endDate.format('DD')+' '+bulan[to_month]+ ' '+picker.endDate.format('YYYY'));      
    });
    table_sep = $('#table-sep').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('bpjs/pasien/pasien_irj')?>",
        "type": "POST",
        "dataType": "JSON",
        "data": function (data) {
          data.tanggal_cari = $('#tanggal_cari').val();
        }   
      },
      "columnDefs": [{ 
        "orderable": false,
        "targets": [0,6]
      }],   
    });      
  });

  function hapus_sep(no_sep) {
    swal({
      title: "Hapus SEP",
      text: "Yakin akan menghapus Nomor SEP tersebut?",
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
          url: "<?php echo base_url().'bpjs/sep/delete'; ?>",
          dataType: "JSON",
          data: {'no_sep' : no_sep,'jnsPelayanan' : '2'},
          success: function(result) {
              if (result) {
                if (result.metaData.code == '200') {
                  table_sep.ajax.reload();
                  swal("Sukses", "SEP berhasil dihapus.", "success");
                } else {
                    swal("Gagal menghapus SEP", result.metaData.message, "error");
                }
              } else {
                swal("Gagal menghapus SEP", result.metaData.message, "error");
              }  
              
          },
          error:function(event, textStatus, errorThrown) {    
              swal("Gagal Menghapus SEP.",textStatus, "error");     
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }
        });
    });
  }

  function penjaminan_sep(no_register) {     
    swal({
        title: "Pengajuan Penjaminan SEP",
        text: "Isi keterangan pengajuan :",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Submit",
        animation: "slide-from-top",
        inputPlaceholder: "Isi keterangan",
        showLoaderOnConfirm: true
    }, function(keterangan){
        if (keterangan === false) return false;
        if (keterangan === "") {
          swal.showInputError("Keterangan tidak boleh kosong!");
          return false
        } 
        $.ajax({
          type: "POST",
          url: "<?php echo base_url().'bpjs/sep/pengajuan_sep/'; ?>"+no_register,
          dataType: "JSON",    
          data: {'keterangan' : keterangan},
          success: function(result) {   
              console.log(result);
              if (result) {
                if (result.metaData.code == '200') { 
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'bpjs/sep/create/'; ?>"+no_register,
                    dataType: "JSON",    
                    success: function(result) {  
                        if (result) {
                          if (result.metaData.code == '200') { 
                            table_sep.ajax.reload();         
                            window.open('<?php echo base_url().'bpjs/sep/cetak_perincian/'; ?>'+no_register, '_blank');
                            swal("Sukses", "Silahkan Cetak SEP", "success");   
                          } else {
                            swal("Gagal membuat SEP", result.metaData.message, "error");           
                          }          
                        } else {
                          swal("Gagal membuat SEP", result.metaData.message, "error");           
                        } 
                        
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Gagal mencetak SEP",textStatus, "error");    
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                  });                                                         
                } else if (result.metaData.message.substr(0,32) == 'Peserta Sudah Aproval Penjaminan') {
                  swal({
                    title: "Approval Penjaminan SEP",
                    text: result.metaData.message,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Buat SEP",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    closeOnCancel: true 
                    }, function(isConfirm) {                  
                      if (isConfirm) {
                        $.ajax({
                          type: "POST",
                          url: "<?php echo base_url().'bpjs/sep/create/'; ?>"+no_register,
                          dataType: "JSON",    
                          success: function(result) {  
                              if (result) {
                                if (result.metaData.code == '200') { 
                                  table_sep.ajax.reload();         
                                  window.open('<?php echo base_url().'bpjs/sep/cetak_perincian/'; ?>'+no_register, '_blank');
                                  swal("Sukses", "Silahkan Cetak SEP", "success");   
                                } else {
                                  swal("Gagal membuat SEP", result.metaData.message, "error");           
                                }          
                              } else {
                                swal("Gagal membuat SEP", result.metaData.message, "error");           
                              } 
                              
                          },
                          error:function(event, textStatus, errorThrown) {    
                              swal("Gagal mencetak SEP",textStatus, "error");    
                              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                          }
                        }); 
                      }             
                  }); 
                } else {
                  swal("Penjaminan SEP Gagal",result.metaData.message, "error");                          
                }
              } else {
                swal("Error","Penjaminan SEP Gagal", "error");            
              }
              
          },
          error:function(event, textStatus, errorThrown) {    
              swal("Gagal Membuat SEP",textStatus, "error");     
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }
        });     
    });  
  }
</script>
<div class="row">
  <div class="col-lg-12 col-md-12">    
    <div class="card card-outline-info">
      <div class="card-header">             
      <h4 class="m-b-0 text-white text-center">Daftar Pasien BPJS Tanggal <span id="from_date"><?php echo date_indo(date("Y-m-d",strtotime("-7 days")));?></span> s/d <span id="to_date"><?php echo date_indo(date('Y-m-d')); ?></span></h4> 
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
                <input type="text" class="form-control" name="tanggal_cari" id="tanggal_cari" value="<?php echo date("Y/m/d");?>-<?php echo date('Y/m/d'); ?>">
              </div>
            </div>
          </div>    
        <?php echo form_close();?> 
        <hr>
        <div class="table-responsive m-t-0">      
          <table id="table-sep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">No. SEP</th>
                <th class="text-center">No.RM</th>
                <th>Nama</th>
                <th class="text-center">No.Kartu</th>
                <th class="text-center">Tgl Kunjungan</th>
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

<?php
  if ($role_id == 1) {
      $this->load->view("layout/footer_left");
  } else {
      $this->load->view("layout/footer_horizontal");
  }
?>