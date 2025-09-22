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
    $(document).on("click",".cetak_sep",function() {
      var button = $(this);
      var no_register = button.data("noregister");
      button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/sep/cari_sep/'; ?>"+no_register,
        dataType: "JSON",    
        success: function(result) {  
            if (result) {
              button.html('<i class="fa fa-print"></i> Cetak');
              if (result.metaData.code == '200') {          
                window.open('<?php echo base_url().'bpjs/sep/cetak/'; ?>'+no_register, '_blank');
              } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
                swal("SEP Tidak Ditemukan","No. SEP Harus 19 digit.", "warning");  
              } else {
                swal("Gagal mencetak SEP", result.metaData.message, "error");           
              }          
            } else {  
              button.html('<i class="fa fa-print"></i> Cetak');        
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
                window.open('<?php echo base_url().'bpjs/sep/cetak/'; ?>'+no_register, '_blank');
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
    $(document).on("click",".update_tglplg",function() {
      var no_register = $(this).data("noregister");
      swal({
        title: "Update Tgl Pulang SEP",
        text: "Yakin akan mengupdate tgl pulang SEP tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (Update)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'bpjs/sep/update_tglplg/'; ?>"+no_register,
            dataType: "JSON",
            success: function(data){  
                if (data.metaData.code == '200') {
                  table_sep.ajax.reload();
                  swal("Sukses", "Tanggal Pulang Berhasil diupdate.", "success");
                } else if(data.metaData.message == 'Tanggal Keluar Kosong.') {
                  swal({
                      title: "Tgl Keluar Kosong", 
                      type: "warning",
                      html: true,
                      text: data.response,  
                      confirmButtonText: "OK", 
                      allowOutsideClick: "true" 
                  });
                } else {
                  swal("Error", data.metaData.message, "error");
                }
            },
            error:function(event, textStatus, errorThrown) {    
                swal("Error","Gagal mengupdate tanggal pulang.", "error");     
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
          }); 
      });
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
        "url": "<?php echo site_url('bpjs/pasien/pasien_iri')?>",
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
          data: {'no_sep' : no_sep,'jnsPelayanan' : '1'},
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
                            window.open('<?php echo base_url().'bpjs/sep/cetak/'; ?>'+no_register, '_blank');
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
                                  window.open('<?php echo base_url().'bpjs/sep/cetak/'; ?>'+no_register, '_blank');
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

  // function update_sep(no_sep) {
  //   $.ajax({
  //     type: "POST",
  //     url: "<?php echo base_url().'bpjs/pasien/get_pasien_iri'; ?>",
  //     dataType: "JSON",
  //     data: {'no_sep' : no_sep},
  //     success: function(data) {
  //       $('#modal_update').modal('show');
  //       $('#no_sep').val(no_sep);
  //       $('#tgl_pulang').val(data.tgl_keluar);
  //     },
  //     error:function(event, textStatus, errorThrown) {    
  //         swal("Error","Gagal load data.", "error");     
  //         console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
  //     }
  //   });
  	
  // }


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
                <input type="text" class="form-control" name="tanggal_cari" id="tanggal_cari" value="<?php echo date("Y/m/d",strtotime("-7 days"));?> - <?php echo date('Y/m/d'); ?>">
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
                <th>No. SEP</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>No. Kartu</th>
                <th>Tgl Masuk</th>                  
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

	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_update">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="title_modal">Update SEP</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body">
                    <input type="hidden" class="form-control" name="no_sep" id="no_sep">
                   	<ul class="nav nav-tabs customtab" role="tablist">
                       	<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#data" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan</span></a> </li>
                       	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tglpulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Tanggal Pulang</span></a> </li>
                   	</ul>
                    <div class="tab-content">
                        <div class="tab-pane active p-20" id="data" role="tabpanel">
                        	<form class="form-horizontal" id="form_catatan">
                            <div class="form-group row">
                  <label for="example-number-input" class="col-sm-2 col-form-label">Tanggal SEP</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="tgl_sep" id="tgl_sep">
                  </div>
                </div>
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-2 col-form-label">Catatan</label>
								  <div class="col-sm-9">
								    <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-2 col-sm-9">	
								    <button type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                        <div class="tab-pane  p-20" id="tglpulang" role="tabpanel">
                        	<form class="form-horizontal" id="form_tglpulang">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-3 col-form-label">Tanggal Pulang</label>
								  <div class="col-sm-6">
								   	<input type="text" class="form-control" name="tgl_pulang" id="tgl_pulang">
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-3 col-sm-9">	
								    <button type="button" class="btn btn-primary" onclick="update_tglplg('')"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                    </div>                                 
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal Update SEP -->

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>