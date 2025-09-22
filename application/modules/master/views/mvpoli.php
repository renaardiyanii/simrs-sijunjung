<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<style type="text/css">
  .table-wrapper-scroll-y {
    display: block;
    max-height: 400px;
    overflow-y: auto;
    -ms-overflow-style: -ms-autohiding-scrollbar;
  }
  .modal {
    overflow-y:auto;
  }
  .modal-edit-poli .modal-header {
    background: rgb(0, 141, 76);
    border-bottom-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-edit-poli .modal-footer {
    background: rgb(0, 141, 76);
    border-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-edit-poli .modal-body {
    background: rgb(0, 166, 90);
    color: #fff;
  }
  .modal-tambah-poli .modal-header {
    background: rgb(0, 141, 76);
    border-bottom-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-tambah-poli .modal-footer {
    background: rgb(0, 141, 76);
    border-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-tambah-poli .modal-body {
    background: rgb(0, 166, 90);
    color: #fff;
  }
</style>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();

    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcpoli/insert_poli",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Poli';
            $('#myModal').modal('hide'); 
            document.getElementById("insert_form").reset();
            if (data = true) {        
              swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
              console.log(data)
            } else {
              swal("Error","Data gagal disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Insert Poli';
            $('#myModal').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });


      $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcpoli/edit_poli",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Poli';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            if (data = true) {        
              swal({
                            title: "Selesai",
                            text: "Data berhasil diperbaharui",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
            } else {
              swal("Error","Data gagal diperbaharui.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Poli';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
    $(document).on('hidden.bs.modal', '#modal-edit-poli', function () {
      $('#table-poli > tbody').empty();
      $('#spesialis').val("NONE").change();
    });
    $(document).on("click",".select-kode-edit",function() {
        $("#edit_kode_bpjs").val($(this).data('kodepoli'));
        $('#modal-edit-poli').modal('hide');
    });
    $(document).on("click",".select-kode-tambah",function() {
        $("#kode_bpjs").val($(this).data('kodepoli'));
        $('#modal-tambah-poli').modal('hide');
    });
    $(document).on("click","#btn-cari-tambah",function() {
      var button = $(this);
      var poli = $("#search_tambah_poli").val();
      button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      if (poli === '') {
          button.html('<i class="fa fa-search"></i> Cari');
          swal("Lengkapi Data","Silahkan isi nama atau kode poli.", "warning"); 
      } else {        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('bpjs/referensi/refpoliklinik'); ?>"+"?q="+poli,
            dataType: "JSON",
            success: function(result) { 
              $('#table-poli > tbody').empty();
              button.html('<i class="fa fa-search"></i> Cari');
              if (result != '' || result != null) {
                if (result.metaData.code == '200') {
                  $.each(result.response.poli, function(i, item) {
                    $('#table-poli > tbody:last-child').append(
                      '<tr>'
                      +'<td class="text-center">'+item.kode+'</td>'
                      +'<td class="text-center">'+item.nama+'</td>'
                      +'<td class="text-center"><button class="btn btn-danger select-kode-tambah" data-kodepoli="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
                      +'</tr>'
                    );
                  });   
                } else {
                  $('#table-poli > tbody:last-child').append(
                    '<tr>'
                    +'<td colspan="3" class="text-center">'+result.metaData.message+'</td>'
                    +'</tr>'
                  );
                }
              } else {
                swal("Error","Gagal load data poli.", "error");  
              }
            },
            error:function(event, textStatus, errorThrown) { 
              button.html('<i class="fa fa-search"></i> Cari');
              swal("Error",formatErrorMessage(event, errorThrown), "error");                   
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
      }
    });
    $(document).on("click","#btn-cari-edit",function() {
      var button = $(this);
      var poli = $("#search_edit_poli").val();
      button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
      if (poli === '') {
          button.html('<i class="fa fa-search"></i> Cari');
          swal("Lengkapi Data","Silahkan isi nama atau kode poli.", "warning"); 
      } else {        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('bpjs/referensi/refpoliklinik'); ?>"+"?q="+poli,
            dataType: "JSON",
            success: function(result) { 
              $('#table-poli > tbody').empty();
              button.html('<i class="fa fa-search"></i> Cari');
              if (result != '' || result != null) {
                if (result.metaData.code == '200') {
                  $.each(result.response.poli, function(i, item) {
                    $('#table-poli > tbody:last-child').append(
                      '<tr>'
                      +'<td class="text-center">'+item.kode+'</td>'
                      +'<td class="text-center">'+item.nama+'</td>'
                      +'<td class="text-center"><button class="btn btn-danger select-kode-edit" data-kodepoli="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
                      +'</tr>'
                    );
                  });   
                } else {
                  $('#table-poli > tbody:last-child').append(
                    '<tr>'
                    +'<td colspan="3" class="text-center">'+result.metaData.message+'</td>'
                    +'</tr>'
                  );
                }
              } else {
                swal("Error","Gagal load data poli.", "error");  
              }
            },
            error:function(event, textStatus, errorThrown) { 
              button.html('<i class="fa fa-search"></i> Cari');
              swal("Error",formatErrorMessage(event, errorThrown), "error");                   
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
      }
    });
  }); 

  function edit_poli(id_poli) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcpoli/get_data_edit_poli')?>",
      data: {
        id_poli: id_poli
      },
      success: function(data){
	    //alert(data[0].id_poli);
        $('#edit_id_poli').val(data[0].id_poli);
        $('#edit_id_poli_hidden').val(data[0].id_poli);
        $('#edit_nm_poli').val(data[0].nm_poli);
        $('#edit_nm_pokpoli').val(data[0].nm_pokpoli);
        $('#edit_kode_bpjs').val(data[0].poli_bpjs);
        if (data[0].active=='1') {
          $('#edit_aktif').val('1');
          $('#edit_aktif').prop('checked', true);
        } else {
          $('#edit_aktif').val('0');
          $('#edit_aktif').prop('checked', false);
        }
        $('#edit_id_polilama').val(data[0].id_polilama);

      },
      error: function(){
        alert("error");
      }
    });
  }


  function hapus_poli(id_poli){
    if (confirm('Yakin Menghapus Poliklinik?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcpoli/soft_delete_poli/')?>"+id_poli,
        data: {
          id_poli: id_poli
        },
        success: function(data){
          if(data == true){
            swal({
                            title: "Selesai",
                            text: "Data berhasil dihapus",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
           // location.reload();
          }else{
            
          swal("Error","Data gagal dihapus.", "error");
          }
        },
        error: function(){
          swal("Error","Data gagal dihapus.", "error");
          alert("error");
        }
      });
    } 
  }


  function active_poli(id_poli){
    if (confirm('Yakin akan mengaktifkan Poliklinik?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcpoli/active_poli/')?>"+id_poli,
        data: {
          id_poli: id_poli
        },
        success: function(data){
          if(data == true){
            swal({
                            title: "Selesai",
                            text: "Data berhasil diaktifkan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
           // location.reload();
          }else{
            
          swal("Error","Data gagal diaktifkan.", "error");
          }
        },
        error: function(){
          swal("Error","Data gagal diaktifkan.", "error");
          alert("error");
        }
      });
    } 
  }


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <div class="card-header">
          <h3 class="text-white">DAFTAR POLIKLINIK</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcpoli/insert_poli');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Poliklinik Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="header-modal-tambah" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="header-modal-tambah"><b>Tambah Poliklinik Baru</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">ID Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Ex: BB00" name="id_poli" id="id_poli" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">Nama Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_poli" id="nm_poli">
                    </div>
                  </div>                  
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Nama Pokpoli</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_pokpoli" id="nm_pokpoli">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_lokasi">Lokasi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="lokasi" id="lokasi">
                    </div>
                  </div>  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode BPJS</p>
                    <div class="col-sm-6">
                      <div class="input-group">
                          <input type="text" class="form-control" name="kode_bpjs" id="kode_bpjs">
                          <span class="input-group-btn">
                              <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-tambah-poli"><i class="fa fa-search"></i> Cari Kode BPJS</button>
                          </span>
                      </div> 
                    </div>
                  </div>                 		  
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Poliklinik</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->
	<hr>
          <br/> 
          <br/> 

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Poliklinik</th>                
                <th>Keterangan</th>
                <th>Lokasi</th>
                <th>Kode BPJS</th>
                <th>Aktif</th>
                <th>ID Poli Lama</th>
                <th>Aksi</th>
              </tr>
            </thead>           
            <tbody>
              <?php
                  $i=1;//print_r($poli);
                  foreach($poli as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_poli;?></td>
                <td><?php echo $row->nm_poli;?></td>
                <td><?php echo $row->nm_pokpoli;?></td>
                <td><?php echo $row->lokasi;?></td>
                <td><?php echo $row->poli_bpjs;?></td>
                <td><?php echo $row->active=='1'?'Aktif':'Non-Aktif';;?></td>
                <td><?php echo $row->id_polilama?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_poli('<?php echo $row->id_poli;?>')"><i class="fa fa-edit"></i></button>
		              <button type="button" class="btn btn-danger btn-sm" onclick="hapus_poli('<?php echo $row->id_poli;?>')" ><i class="fa fa-trash"></i></button>
                  <button type="button" class="btn btn-success btn-sm"onclick="active_poli('<?php echo $row->id_poli;?>')"  ><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/mcpoli/edit_poli');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit Poliklinik</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_poli" id="edit_id_poli" disabled>
                      <input type="hidden" class="form-control" name="edit_id_poli_hidden" id="edit_id_poli_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_poli" id="edit_nm_poli">
                    </div>
                  </div>                                 
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Nama Pokpoli</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_pokpoli" id="edit_nm_pokpoli">
                    </div>
                  </div> 
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_lokasi">Lokasi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_lokasi" id="edit_lokasi">
                    </div>
                  </div>    
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode BPJS</p>
                    <div class="col-sm-6">
                      <div class="input-group">
                          <input type="text" class="form-control" name="edit_kode_bpjs" id="edit_kode_bpjs">
                          <span class="input-group-btn">
                              <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-edit-poli"><i class="fa fa-search"></i> Cari Kode BPJS</button>
                          </span>
                      </div> 
                    </div>
                  </div>               		  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Aktif?</p>
                    <div class="col-sm-6">
                      <div class="input-group">
                          <input type="checkbox" class="filled-in" style="left:0;opacity:1;" value="1" name="edit_aktif" id="edit_aktif">
                      </div> 
                    </div>
                  </div>               		  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode Poli Lama</p>
                    <div class="col-sm-6">
                      <div class="input-group">
                          <input type="text" class="form-control" name="edit_id_polilama" id="edit_id_polilama">
                      </div> 
                    </div>
                  </div>               		  
                </div>                
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Poliklinik</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->

        </div>
      </div>
    </div>
</section>
<div id="modal-tambah-poli" class="modal modal-tambah-poli fade" role="dialog" aria-labelledby="header-tambah-poli" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-success">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title text-white" id="header-tambah-poli">Cari Kode Poli BPJS</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="search_tambah_poli" id="search_tambah_poli" placeholder="Ketik Nama atau Kode Poli">
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-danger btn-block" type="button" id="btn-cari-tambah"><i class="fa fa-search"></i> Cari</button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="table-wrapper-scroll-y">
                    <table width="100%" class="table table-bordered table-condensed" id="table-poli">
                      <thead>
                        <tr>
                          <td class="text-center" width="22%"><b>ID</b></td>
                          <td class="text-center" width="63%"><b>Nama Poli</b></td>
                          <td class="text-center" width="15%"><b>Aksi</b></td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div id="modal-edit-poli" class="modal modal-edit-poli fade" role="dialog" aria-labelledby="header-edit-poli" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-success">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title text-white" id="header-edit-poli">Cari Kode Poli BPJS</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <input class="form-control" type="text" name="search_edit_poli" id="search_edit_poli" placeholder="Ketik Nama atau Kode Poli">
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-danger btn-block" type="button" id="btn-cari-edit"><i class="fa fa-search"></i> Cari</button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="table-wrapper-scroll-y">
                    <table width="100%" class="table table-bordered table-condensed" id="table-poli">
                      <thead>
                        <tr>
                          <td class="text-center" width="22%"><b>ID</b></td>
                          <td class="text-center" width="63%"><b>Nama Poli</b></td>
                          <td class="text-center" width="15%"><b>Aksi</b></td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
