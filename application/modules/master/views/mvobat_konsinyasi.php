<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script>
  function angka(evt){
   var char = (evt.which) ? evt.which : event.keyCode
   if (char > 31 &&(char < 48 || char > 57)) 
    return false;
   return true;
  }
</script>

<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    	$('#example').DataTable();
	$(".select2").select2();


  $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcobat_konsinyasi/insert_obatk",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Obat Konsinyasi';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Obat Konsinyasi';
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
          url:"<?php echo base_url(); ?>master/Mcobat_konsinyasi/edit_obatk",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat Konsinyasi';
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
            document.getElementById("btn-edit").innerHTML = 'Edit Obat Konsinyasi';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });  
  } );
  //---------------------------------------------------------

  function edit_obatk(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcobat_konsinyasi/get_data_edit_obatk')?>",
      data: {
        id: id
      },
      success: function(data){
	//alert(data[0].id_dokter);
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
        $('#edit_nm_obatk').val(data[0].nm_obatk);
        $('#edit_hargab').val(data[0].hargabeli);
        $('#edit_hargaj').val(data[0].hargajual);
        $('#edit_jenis').val(data[0].obatalkes);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_obat_konsinyasi(id){
    if (confirm('Yakin Menghapus Obat Konsinyasi?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcobat_konsinyasi/delete_obatk/')?>"+id,
        data: {
          id: id
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
          <h3 class="text-white">DAFTAR OBAT KONSINYASI</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcobat_konsinyasi/insert_obatk');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Obat Konsinyasi</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Obat Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-8">
                        <?php
                        $data=$this->Mmobat_konsinyasi->get_id_max()->result();
                        foreach ($data as $value) {
                       ?>
                        <input type="hidden" class="form-control" name="id_obatk" id="id_obatk" value="<?php echo "OL".sprintf("%03s",$value->kodex);?>">
                      <?php }?>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Obat</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama" id="nama">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_hargab">Harga Beli</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="hargab" id="hargab" onkeypress="return angka(event)">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_hargaj">Harga Jual</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="hargaj" id="hargaj" onkeypress="return angka(event)">
                      </div>
                    </div>

  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_jenis">Jenis</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="jenis" id="jenis" >
                  				<option value="">-Pilih Jenis-</option>
                          <option value="obat">Obat</option>
                          <option value="alkes">Alkes</option>
                  			</select>
                      </div>
                    </div>

                  </div>
                  <div class="col-sm-6 container">
                   
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Obat</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->
          <br/> 
          <br/> 

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Jenis</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($jadwal as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->nm_obatk;?></td>
                <td><?php echo $row->hargabeli;?></td>
                <td><?php echo $row->hargajual;?></td>
                <td><?php echo $row->obatalkes;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_obatk('<?php echo $row->id;?>')" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus_obat_konsinyasi('<?php echo $row->id;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/Mcobat_konsinyasi/edit_obatk');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Obat Konsinyasi</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-10">
                    <div class="form-group row">
                      <div class="col-sm-8">
                        <input type="hidden" class="form-control" name="edit_id" id="edit_id" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Obat</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nm_obatk" id="edit_nm_obatk">
                      </div>
                    </div>
              
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Harga Beli</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_hargab" id="edit_hargab" onkeypress="return angka(event)">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Harga Jual</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_hargaj" id="edit_hargaj" onkeypress="return angka(event)">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">jenis</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="edit_jenis" id="edit_jenis" required>
                          <option value="">-Pilih Jenis-</option>
                          <option value="obat">Obat</option>
                          <option value="alkes">Alkes</option>
                        </select>
                      </div>
                    </div>
                  </div>
    		          
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Obat</button>
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
