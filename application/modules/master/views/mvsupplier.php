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
          url:"<?php echo base_url(); ?>master/mcsupplier/insert_supplier",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Supplier';
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
								function () {
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Insert Supplier';
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
          url:"<?php echo base_url(); ?>master/Mcsupplier/edit_supplier",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Supplier';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
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
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Supplier';
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

  function edit_supplier(id_supplier) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcsupplier/get_data_edit_supplier')?>",
      data: {
        id_supplier: id_supplier
      },
      success: function(data){
        $('#edit_id_supplier').val(data[0].person_id);
        $('#edit_id_supplier_hidden').val(data[0].person_id);
        $('#edit_nmsupplier').val(data[0].company_name);
        $('#edit_accountnumber').val(data[0].account_number);
        $('#edit_adress').val(data[0].adress);
        $('#edit_zip_code').val(data[0].zip_code);
        $('#edit_phone').val(data[0].phone);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_supplier(id_supplier){
    if (confirm('Yakin Menghapus supplier?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcsupplier/soft_delete_supplier/')?>"+id_supplier,
        data: {
          id_supplier: id_supplier
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
          alert("error");
        }
      });
    } 
  }

  function aktif_supplier(id){
    if (confirm('Yakin Mengaktifkan Supplier ini?')) {
      $('#modalLoading').modal('show');
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/Mcsupplier/active_supplier/"+id,
        data: {
          id: id
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
      $('#modalLoading').modal('hide');
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
          <h3 class="text-white">DAFTAR SUPPLIER</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcsupplier/insert_supplier');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Supplier Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Supplier -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Supplier Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmsupplier">Nama Supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmsupplier" id="nmsupplier" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_accountnumber">Account Number</p>
                    <div class="col-sm-6">
                      <input onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" type="text" class="form-control" name="accountnumber" id="accountnumber" required>
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_adress">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="adress" id="adress" required>
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_zip_code">Zip Code</p>
                    <div class="col-sm-6">
                      <input onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" type="text" class="form-control" name="zip_code" id="zip_code" required>
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_phone">Phone</p>
                    <div class="col-sm-6">
                      <input onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Supplier</button>
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
                <th>ID Supplier</th>
                <th>Nama Supplier</th>
                <th>Account Number</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID supplier</th>
                <th>Nama supplier</th>
                <th>Account Number</th>
                <th>Telephon</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($suppliers as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->person_id;?></td>
                <td><?php echo $row->company_name;?></td>
                 <td><?php echo $row->account_number;?></td>
                 <td><?php echo $row->phone;?></td>
                 <?php if ($row->deleted ==0): ?>
                  <td>ACTIVE</td>
                <?php else: ?>
                  <td>NON-ACTIVE</td>
                <?php endif; ?>
                <td>
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_supplier('<?php echo $row->person_id;?>')"><i class="fa fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus_supplier('<?php echo $row->person_id;?>')"><i class="fa fa-trash"></i></button>
                  <!-- <a type="button" class="btn btn-success btn-sm" href="<?php echo base_url('master/Mcsupplier/active_supplier/'.$row->person_id)?>" ><i class="fa fa-check"></i></a> -->
                  <button type="button" class="btn btn-success btn-sm" onclick="aktif_supplier('<?php echo $row->person_id;?>')"><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/Mcsupplier/edit_supplier');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit-->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit supplier</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_supplier" id="edit_id_supplier" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_supplier_hidden" id="edit_id_supplier_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmsupplier" id="edit_nmsupplier">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Account Number</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_accountnumber" id="edit_accountnumber">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_adress" id="edit_adres">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode POS</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_zip_code" id="edit_zip_code">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">No.Telepon</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_phone" id="edit_phone">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit supplier</button>
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



  <div class="modal fade" id="modalLoading" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title"><b><i class="fa fa-spinner fa-spin" ></i>Loading....</b></h1>
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