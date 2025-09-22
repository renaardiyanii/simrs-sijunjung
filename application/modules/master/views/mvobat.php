<?php 
            $this->load->view("layout/header_left");
        
    ?>
<script type='text/javascript'>
  $(document).ready(function() {
    $('#example').DataTable({
     // "iDisplayLength": 10
    });

    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcobat/insert_obat",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Obat';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Obat';
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
          url:"<?php echo base_url(); ?>master/mcobat/edit_obat",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
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
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });  

      $('#delete_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-delete").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcobat/delete_obat",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-delete").innerHTML = 'Hapus Obat';
            $('#deleteModal').modal('hide'); 
            document.getElementById("delete_form").reset();
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
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-delete").innerHTML = 'Hapus Obat';
            $('#deleteModal').modal('hide');
            swal("Error","Data gagal dihapus.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 
    
  });

  
  function edit_obat(id_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcobat/get_data_edit_obat')?>",
      data: {
        id_obat: id_obat
      },
      success: function(data){
        //console.log(data);
        $('#edit_generik').val(data[0].id_generik+'@'+data[0].nama_generik);
        $('#edit_generik').trigger('change');
        $('#edit_id_obat').val(data[0].id_obat);
        $('#edit_id_obat_hidden').val(data[0].id_obat);
        $('#edit_nm_obat').val(data[0].nm_obat);
        // var option = new Option(data[0].nama_generik, data[0].id_generik+'@'+data[0].nama_generik+'@', false, false);
        // $('#edit_generik').append(option).trigger('change');
        // $('#edit_generik').val(data[0].id_generik+'@'+data[0].nama_generik);
        // $('#edit_generik').trigger('change');
        $('#edit_satuank').val(data[0].satuank);
        $('#edit_kategori').val(data[0].kategori_obat);
        $('#edit_jenis_obat').val(data[0].jenis_obat);
       $('#edit_golongan_obat').val(data[0].golongan_obat);
        $('#edit_kel').val(data[0].kelompok);
        $('#edit_subkel').val(data[0].subkelompok);
        $('#edit_kat1').val(data[0].kategori1);
        $('#edit_kat2').val(data[0].kategori2);
        $('#edit_kat3').val(data[0].kategori3);
        $('#edit_kat4').val(data[0].kategori4);
        $('#edit_kat5').val(data[0].kategori5);
        $('#edit_kat6').val(data[0].kategori6);
        $('#edit_formularium').val(data[0].formularium);
        $('#edit_kemasan').val(data[0].kemasan);
        // $('#edit_produksi').val(data[0].produksi);
        // $('#edit_minstok').val(data[0].min_stock);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_obat(id) {
    $('#delete_id').val(id);
  }

  function aktif_obat(id){
    if (confirm('Yakin Mengaktifkan Obat ini?')) {
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/mcobat/active_obat/"+id,
        data: {
          id: id
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
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

  $(function() {
  

  $("#generik").select2();
  //  $("#edit_generik").select2(); 

   $("#edit_generik").select2(
    {
      dropdownParent:$("#editModal")
    }
  );
});
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
          <h3 class="text-white">DAFTAR OBAT</h3>
        </div>
        <div class="card-block">

        <!-- untuk form cari -->
        <?php echo form_open('master/Mcobat/search_obat');?>

        <!-- <div class="form-group row">
						<label class="col-sm-2 control-label">Janis Obat</label>
						<div class="col-sm-4">
            <select id="jenis_obat" class="form-control" name="jenis_obat">
              <option value="" disabled selected="">-Pilih Jenis-</option>
              <?php 
                foreach($jenis as $row){
                  echo '<option value="'.$row->nm_jenis.'">'.$row->nm_jenis.'</option>';
                }
              ?>
            </select>
						</div> -->
            <div class="col-sm-2">
              <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Obat Baru</button>
					  </div>
						
				<!-- </div> -->


        <!-- <div class="form-group row">
						<label class="col-sm-2 control-label">Kelompok</label>
						<div class="col-sm-4">
            <select id="kel" class="form-control" name="kel">
              <option value="" disabled selected="">-Pilih Kelompok-</option>
              <?php 
                foreach($kelompok as $row){
                  echo '<option value="'.$row->kode.'">'.$row->nm_kelompok.'</option>';
                }
              ?>
            </select>
						</div>
						
				</div> -->

        <!-- <div class="form-group row">
						<label class="col-sm-2 control-label">Sub Kelompok</label>
						<div class="col-sm-4">
            <select id="subkel" class="form-control" name="subkel">
              <option value="" disabled selected="">-Pilih SubKelompok-</option>
              <?php 
                foreach($subkelompok as $row){
                  echo '<option value="'.$row->kode.'">'.$row->bentuk_sediaan.'</option>';
                }
              ?>
            </select>
						</div>
						
				</div> -->

        <!-- <div class="col-sm-4">
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div> -->
        <?php echo form_close();?>
        <!-- sampai sini -->

          <!-- <hr> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <!-- Modal Insert Obat -->
            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false" >
              <div class="modal-dialog modal-success" > 

                <!-- Modal content-->
                <div class="modal-content" >
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Obat Baru</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Nama Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="nm_obat" id="nm_obat" required>
                      </div>
                    </div>

                   

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Satuan Kecil</p>
                      <div class="col-sm-6">
                        <select id="satuank" class="form-control" name="satuank">
                          <option value="" disabled selected="">-Pilih Satuan Kecil-</option>
                          <?php 
                            foreach($satuan as $row){
                              echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_nama">Kategori</p>
                      <div class="col-sm-6">
                        <select id="kategori" class="form-control" name="kategori">
                          <option value="" disabled selected="">-Pilih Kategori Obat-</option>
                          <?php 
                            foreach($kategori as $row){
                              echo '<option value="'.$row->id.'">'.$row->nm_kategori_1.'</option>';
                            }
                          ?>
                        </select>
                      </div>
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
          
          <br/> 
          <br/> 
          <div class="table-responsive">
            <table id="example" class="display table table-hover table-striped table-bordered" cellpadding="0" cellspacing="0" width="100%">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Id Obat</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Id Obat</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
              <tbody id="bodyt">
                <?php
                    $i=1;
                    foreach($obat as $row){
                ?>
                <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row->id_obat;?></td>
                  <td><?php echo $row->nm_obat;?></td>
                  <td><?php echo $row->satuank;?></td> 
                  <td><?php echo $row->kategori;?></td> 
                  <?php if ($row->deleted ==0): ?>
                    <td>ACTIVE</td>
                  <?php else: ?>
                    <td>NON-ACTIVE</td>
                  <?php endif; ?>
                  <td>
                  <button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $row->id_obat;?>')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"  onclick="delete_obat('<?php echo $row->id_obat;?>')"><i class="fa fa-trash"></i></button>
                    <button type="button" class="btn btn-success btn-sm" onclick="aktif_obat('<?php echo $row->id_obat?>')" ><i class="fa fa-check"></i></button>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          

       
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Obat</h4>
                  </div>
                  <div class="modal-body">

                  <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Id Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_obat_hidden" id="edit_id_obat_hidden">
                      </div>
                    </div> 

                  <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Nama Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nm_obat" id="edit_nm_obat">
                      </div>
                    </div>

                   

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Satuan Kecil</p>
                      <div class="col-sm-6">
                        <select id="edit_satuank" class="form-control" name="edit_satuank" required>
                          <option value="" disabled selected="">-Pilih Satuan Kecil-</option>
                          <?php 
                            foreach($satuan as $row){
                              echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>  

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Kategori</p>
                      <div class="col-sm-6">
                      <select id="edit_kategori" class="form-control" name="edit_kategori">
                          <option value="" disabled selected="">-Pilih kategori-</option>
                          <?php 
                            foreach($kategori as $row){
                              echo '<option value="'.$row->id.'">'.$row->nm_kategori_1.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>  

                   

                   

                   
                                                            
                    


                       
                                                                                        
                    

                  
                    
            
                    

                    
                    
                   

                    
                   

                    <!-- <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_alamat">Kategori 4</p>
                      <div class="col-sm-6">
                        <select id="edit_kat4" class="form-control" name="edit_kat4">
                          <option value="" disabled selected="">-Pilih Kategori 4-</option>
                          <?php 
                            foreach($kategori_empat as $row){
                              echo '<option value="'.$row->kode.'">'.$row->nama_kategori.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div> -->

                   

                    <!-- <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_alamat">Formularium</p>
                      <div class="col-sm-6">
                        <select id="edit_formularium" class="form-control" name="edit_formularium">
                          <option value="" disabled selected="">-Pilih Formularium-</option>
                          <?php 
                            foreach($kelompok as $row){
                              echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div> -->


                    <!-- <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_alamat">Bahan Produksi</p>
                      <div class="col-sm-6">
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="edit_produksi" id="flexRadioDefault3" value=1>
                          <label class="form-check-label" for="flexRadioDefault3">Ya</label>
                      
                          <input class="form-check-input" type="radio" name="edit_produksi" id="flexRadioDefault4" value=0>
                          <label class="form-check-label" for="flexRadioDefault4">Tidak</label>
                        </div>
                      </div>
                    </div> -->


                  
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Edit Obat</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
         

         
          <form method="POST" id="delete_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
            <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success">
              <input type="hidden" class="form-control" name="delete_id" id="delete_id">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Yakin mau non-aktifkan Obat?</h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Jangan non-aktifkan</button>
                    <button class="btn btn-primary" type="submit" id="btn-delete">Yakin non-aktifkan</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
         

        </div>
      </div>
    </div>
  </div>
</section>


<?php 
       
            $this->load->view("layout/footer_left");
        
    ?>