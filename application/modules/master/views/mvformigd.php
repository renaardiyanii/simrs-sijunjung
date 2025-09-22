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

    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });

    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcformigd/insert",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Tambah Form';
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
            document.getElementById("btn-insert").innerHTML = 'Tambah Form';
            $('#myModal').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

      $('#insert_role_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcformigd/insert_role_form",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            data = JSON.parse(data);
            document.getElementById("btn-insert").innerHTML = 'Simpan';
            $('#myModalRoleForm').modal('hide'); 
            document.getElementById("insert_role_form").reset();
            if (data.code === 200) {        
              swal({
                  title: "Selesai",
                  text: data.message.akses_berhasil,
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
              swal("Error",data.message.akses_gagal, "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Tambah Form';
            $('#myModalRoleForm').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });


     
  });

  function hak_akses(id_form){
    $('#myModalRoleForm').modal('show');
    $('#myModalRoleForm').on('shown.bs.modal', function (e) {
      $('#id_form').val(id_form);
      $.ajax({  
        url:"<?php echo base_url(); ?>master/mcformigd/get_role_form/"+id_form,                           
        success: function(data)  
        { 
          var listForm = [];
          data.data.map((val)=>{
            
            if(!listForm.includes(val.role)){
              listForm.push(val.role);
            }
          });
          

          var html = `
          <div class="demo-checkbox">
                <input class="filled-in" type="checkbox" name="role[]" value="dokter" id="dokter_hakakses" ${listForm.includes('dokter')?'checked':''}>
                <label for="dokter_hakakses">Dokter</label>

                <input class="filled-in" type="checkbox" name="role[]" value="perawat" id="perawat" ${listForm.includes('perawat')?'checked':''}>
                <label for="perawat">Perawat</label>

               

              </div> 	
          `;
          $('#body-modal').html(html);

        },
        error:function(event, textStatus, errorThrown) {
          swal("Error","Data gagal Dimuat.", "error"); 
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }  
      });
    })
  }
  //---------------------------------------------------------


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
          <h3 class="text-white">DAFTAR FORM</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>
         <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Form Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="header-modal-tambah" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="header-modal-tambah"><b>Tambah Form Baru</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">Kode </p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="RM001" name="kode" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">Nama</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                  </div>                  
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Views</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="views" id="views">
                    </div>
                  </div>
                                 		  
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Tambah Form</button>
                </div>
              </div>
            </div>
          </div>
          </form>
	<hr>
          <br/> 
          <br/> 

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>views</th>
                <th>Aksi</th>
              </tr>
            </thead>           
            <tbody>
              <?php
                  $i=1;
                  foreach($form as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kode;?></td>
                <td><?php echo $row->nama;?></td>
                <td><?php echo $row->views;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" onclick="hak_akses('<?php echo $row->id;?>')"><i class="fa fa-edit"></i></button>
		              <button type="button" class="btn btn-danger btn-sm" onclick="hapus_poli('<?php echo $row->id;?>')" ><i class="fa fa-trash"></i></button>
                  <button type="button" class="btn btn-success btn-sm"onclick="active_poli('<?php echo $row->id;?>')"  ><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

         
        </div>
      </div>
    </div>
</section>

<form method="POST" id="insert_role_form" class="form-horizontal">


  <!-- Modal Insert Obat -->
  <div class="modal fade" id="myModalRoleForm" role="dialog" aria-labelledby="header-modal-tambah" aria-hidden="true">
    <div class="modal-dialog modal-success modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="header-modal-tambah"><b>Tambah Role Form Baru</b></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">

          <div class="form-group row">
            <label class="col-sm-3 control-label col-form-label">Hak Akses</label>
            <div class="col-sm-9">
              <div id="body-modal"></div>										
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <input type="hidden" class="form-control"  name="id_form" id="id_form">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button class="btn btn-primary" type="submit" id="btn-insert">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
