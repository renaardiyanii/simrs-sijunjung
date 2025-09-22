<?php 
  if ($role_id == 1) {
    $this->load->view("layout/header_left");
  } else {
    $this->load->view("layout/header_horizontal");
  }
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();


    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>akun/crsakun/insert_norekening",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Nomor Rekening';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Nomor Rekening';
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
          url:"<?php echo base_url(); ?>akun/crsakun/edit_norek",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Nomor Rekening';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
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
            } else {
              swal("Error","Data gagal diperbaharui.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Nomor Rekening';
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
  }); 

  function edit_norek(kode) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_edit_norekening')?>",
      data: {
        kode: kode
      },
      success: function(data){
	       //alert(data[0].nrl);
        $('#id_norek').val(kode);
        $('#edit_no_rek').val(data[0].no_rek);
        $('#edit_no_rek_hidden').val(data[0].no_rek);
        $('#edit_jns_bank').val(data[0].jns_bank);
        $('#edit_deskripsi').val(data[0].deskripsi);
        },
      error: function(){
        alert("error");
      }
    });
  }


  function hapus_norek(id_norek){
    if (confirm('Yakin Menghapus Nomor Rekening?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('akun/crsakun/delete_norek/')?>"+id_norek,
        data: {
          id_norek: id_norek
        },
        success: function(data){
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
        },
        error: function(){
          swal("Error","Data gagal dihapus.", "error");
          // alert("error");
        }
      });
    } 
  }


  function active_norek(id_norek){
    if (confirm('Yakin Mengaktifkan Nomor Rekening?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('akun/crsakun/active_rekening/')?>"+id_norek,
        data: {
          id_norek: id_norek
        },
        success: function(data){
          swal({
                            title: "Selesai",
                            text: "Nomor Rekening berhasil diaktifkan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
        },
        error: function(){
          swal("Error","Data gagal diaktifkan.", "error");
          // alert("error");
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
      <div class="card">	
        <div class="card-block ">

          <div class="col-xs-9">
          </div>

          <!-- <?php echo form_open('akun/crsakun/insert_norekening');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Nomor Rekening</i> </button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
		<br>
          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Nomor Rekening</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_kode_manggaran">Nomor Rekening</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="no_rek" id="no_rek" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_jns_bank">Jenis Bank</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="jns_bank" id="jns_bank" placeholder="Contoh : BRI" required>
                    </div>
                  </div>
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Deskripsi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="deskripsi" id="deskripsi"  required>
                    </div>
                  </div>
                  
		  
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xcreate">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->
          <br/> 
          <br/> 

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
		            <th>No Rekening</th>
		            <th>Bank</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>No Rekening</th>
                <th>Bank</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($nomorrekening as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->no_rek;?></td>
                <td><?php echo $row->jns_bank;?></td>
                <td><?php if($row->deskripsi!=''){echo $row->deskripsi;}else{ echo '-';}?></td>
                <td><?php if((int)$row->deleted!=1){echo 'Active';}else{ echo '<b>Deleted</b>';}?></td>
                <td>
                  
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_norek('<?php echo $row->id_norek;?>')"><i class="fa fa-edit"></i></button>	
					        <button type="button" class="btn btn-danger btn-sm" onclick="hapus_norek('<?php echo $row->id_norek;?>')"><i class="fa fa-trash"></i></button>
                  <button type="button" onclick="active_norek('<?php echo $row->id_norek;?>')" class="btn btn-success btn-xs" ><i class="fa fa-check"></i></button>
                  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('akun/crsakun/edit_norek');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Nomor Rekening</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nomor Rekening</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_no_rek" id="edit_no_rek">
                      <input type="hidden" class="form-control" name="id_norek" id="id_norek">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_jns_bank">Jenis Bank</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_jns_bank" id="edit_jns_bank" placeholder="Contoh : BRI" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Deskripsi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_deskripsi" id="edit_deskripsi"  required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
		              <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->

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
