<?php 
  $this->load->view("layout/header_left");
    ?>
    
<script type='text/javascript'>
  $(document).ready(function() {
      $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?= base_url('master/mckaru/transaction/insert') ?>",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
           
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
          },
          error:function(event, textStatus, errorThrown) {
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 

      $('.dataparsing').click(function(){
        $('#userid-disabled').val($(this).data('userid'));
        $('#id-hidden').val($(this).data('id'));
        $('#addBookDialog').modal('show');
      });

      // update
      $('#update_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?= base_url('master/mckaru/transaction/update_by_id') ?>",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
           
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
          },
          error:function(event, textStatus, errorThrown) {
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 

      

      $('#edit_form').on('submit', function(e){  
        e.preventDefault();
        $.ajax({  
          url:"",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
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
          },
          error:function(event, textStatus, errorThrown) {
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 
    	$('#example').DataTable();
	$(".select2").select2();
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

function deleteKaru(id){
    $.ajax({
      type:'post',
      url:`<?= base_url('master/mckaru/transaction/delete') ?>/${id}`,  
      contentType: 'JSON',  
      cache: false,  
      processData:false, 
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
        swal("Error","Data gagal diaktifkan.", "error");
        alert("error");
      }
    });
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
          <h3 class="text-white">DAFTAR KEPALA RUANGAN</h3>
        </div>
        <div class="card-block">

          <form method="POST" id="insert_form" class="form-horizontal"> 
          
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-insert"><i class="fa fa-plus"></i> Tambah Baru</button>
              </span>
            </div><!-- /input-group --> 
          

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="modal-insert" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Tambah Baru</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                      
    		              <div class="form-group row">
                        <p class="col-sm-4 form-control-label" id="lbl_poli">Kepala Ruangan</p>
                        <div class="col-sm-8">
                          <select  class="form-control select2" style="width: 100%" name="userid" >
                    				<option value="">-Pilih Kepala Ruangan-</option>
                    			  <?php
                            foreach($user as $val){
                            ?>
                            <option value=<?= $val->userid ?> ><?= $val->name ?></option>
                            <?php } ?>
                    			</select>
                        </div>
                      </div>
    		              <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_biaya">Pilih Ruangan</p>
                        <div class="col-sm-8">
                          <select  class="form-control select2" style="width: 100%" name="idrg">
                    				<option value="">-Pilih Ruangan-</option>
                            <?php
                            foreach($ruangan as $val){
                            ?>
                            <option value="<?= $val->idrg ?>"><?= $val->nmruang ?></option>
                            <?php } ?>
                    			</select>
                        </div>
                      </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->userid;?>" name="xuser">
                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                  <button class="btn btn-info waves-effect" type="submit" id="btn-insert">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>

          <form method="POST" id="update_form" class="form-horizontal"> 
          <!-- Modal Insert Obat -->
          <div class="modal fade" id="modal-update" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit Kepala Ruangan</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                      
    		              <div class="form-group row">
                        <p class="col-sm-4 form-control-label" id="lbl_poli">Kepala Ruangan</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="userid-disabled" disabled>
                          <input type="hidden" id="id-hidden" name="id" >
                        </div>
                      </div>
    		              <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_biaya">Pilih Ruangan</p>
                        <div class="col-sm-8">
                          <select  class="form-control select2" style="width: 100%" name="idrg">
                    				<option value="">-Pilih Ruangan-</option>
                            <?php
                            foreach($ruangan as $val){
                            ?>
                            <option value="<?= $val->idrg ?>"><?= $val->nmruang ?></option>
                            <?php } ?>
                    			</select>
                        </div>
                      </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->userid;?>" name="xuser">
                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                  <button class="btn btn-info waves-effect" type="submit" id="btn-insert">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <br/>           

          <table id="table-list-karu" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <!-- <th>No</th> -->
                <th>Aksi</th>
                <th>Id</th>
                <th>Nama</th>
                <th>Ruangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($karu as $val){
              ?>
              <tr>
                <td>
                  <button class="btn btn-info dataparsing" type="button" data-toggle="modal" data-target="#modal-update" data-id="<?= $val->id ?>" data-userid="<?= $val->name ?>">Edit</button>
                  <button class="btn btn-danger" onclick="deleteKaru('<?= $val->id ?>')">Hapus</button>
                </td>
                <td><?= $val->userid ?></td>
                <td><?= $val->name ?></td>
                <td><?= $val->nmruang ?></td>
              </tr>
              <?php
              }
              ?>
            </tbody>
           
          </table>

 
         

      

        </div>
      </div>
    </div>
  </div>

</section>

<script type='text/javascript'>

</script>


<?php $this->load->view("layout/footer_left"); ?>
