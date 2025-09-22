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
	$(".select2").select2();

  $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcjadwal/insert_jadwal",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Jadwal';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Jadwal';
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
          url:"<?php echo base_url(); ?>master/Mcjadwal/edit_jadwal",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Jadwal';
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
            document.getElementById("btn-edit").innerHTML = 'Edit Jadwal';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });  
  } );
  //---------------------------------------------------------

  $(function() {
    $('.clockpicker').clockpicker({
          donetext: 'Done',
      }).find('input').change(function() {
          console.log(this.value);
      });  
  }); 

  function edit_jadwal(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcjadwal/get_data_edit_jadwal')?>",
      data: {
        id: id
      },
      success: function(data){
	//alert(data[0].id_dokter);
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
        $('#edit_nm_dokter').val(data[0].nm_dokter);
        $('#edit_nm_poli').val(data[0].nm_poli);
        $('#edit_hari').val(data[0].hari);
        $('#edit_awal').val(data[0].awal);
        $('#edit_akhir').val(data[0].akhir);
      },
      error: function(){
        alert("error");
      }
    });
  }
  function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

  function ajaxdokter(id_poli){
	var id = id_poli;
	console.log(id);

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);

	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
      data=ajaxku.responseText;
      if(data.length>=0){
        document.getElementById("dokter").innerHTML = data;
      }
    }
}


function hapus_jadwal(id){
    if (confirm('Yakin Menghapus Jadwal?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcjadwal/soft_delete_jadwal_dokter/')?>"+id,
        data: {
          id: id
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


  function active_jadwal(id){
    if (confirm('Yakin akan mengaktifkan Jadwal?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcjadwal/active_jadwal_dokter/')?>"+id,
        data: {
          id: id
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
          <h3 class="text-white">DAFTAR JADWAL DOKTER</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcjadwal/insert_jadwal');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Jadwal Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Jadwal Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_poli">Poli</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="poli" id="poli" onchange="ajaxdokter(this.value)">
                  				<option value="">-Pilih Poli-</option>
                  				<?php 									
                  					foreach($poli as $row){						
                  						
                  						echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';											
                  					}
                  				?>
                  			</select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="dokter" id="dokter"  >
                          <option value="">-Pilih Dokter-</option>
                          <?php                   
                            foreach($dokter as $row1){            
                              
                              echo '<option value="'.$row1->id_dokter.'">'.$row1->nm_dokter.'</option>';                      
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_hari">Hari</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="hari" id="hari">
                      </div>
                    </div>
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_awal">Jam Awal</p>
                      <div class="col-sm-8">
                        <input type="time" class="form-control" name="awal" id="awal">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_akhir">Jam Akhir</p>
                      <div class="col-sm-8">
                        <input type="time" class="form-control" name="akhir" id="akhir">
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
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Jadwal</button>
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
                <th>Poli</th>
                <th>Nama Dokter</th>
                <th>Hari</th>
                <th>Jam Awal</th>
                <th>Jam Akhir</th>
                <th>Status</th>
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
                <td><?php echo $row->nm_poli;?></td>
                <td><?php echo $row->nm_dokter;?><?php if($row->deleted=='1'){echo '<br><b>Nonaktif</b>';}?></td>
                <td><?php echo $row->hari;?></td>
                <td><?php echo $row->awal;?></td>
                <td><?php echo $row->akhir;?></td>
                <td><?php echo $row->status=='0'?'Aktif':'Non-Aktif';?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_jadwal('<?php echo $row->id;?>')" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-danger btn-sm" onclick="hapus_jadwal('<?php echo $row->id;?>')" style="margin-bottom: 5px;"><i class="fa fa-trash"></i></button>
                  <button class="btn btn-success btn-sm" onclick="active_jadwal('<?php echo $row->id;?>')" style="margin-bottom: 5px;" style="margin-bottom: 5px;"><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/Mcjadwal/edit_jadwal');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Jadwal Dokter</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-10">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Jadwal</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Dokter</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nm_dokter" id="edit_nm_dokter" disabled="">
                      </div>
                    </div>
              
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Poli</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nm_poli" id="edit_nm_poli" disabled="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Hari</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_hari" id="edit_hari">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Awal</p>
                      <div class="col-sm-8">
                        <input type="time" class="form-control" name="edit_awal" id="edit_awal">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Akhir</p>
                      <div class="col-sm-8">
                        <input type="time" class="form-control" name="edit_akhir" id="edit_akhir">
                      </div>
                    </div>
                  </div>
    		          
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Jadwal Dokter</button>
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
