<?php  $this->load->view("layout/header_left"); ?>
<style type="text/css">
.canvas{
	background: #fff;border: 1px solid #000;
}

#my_image{
	background: #fff;border: 1px solid #000;
}

  .modal {
    overflow-y:auto;
  }
  .modal-search-kode .modal-header {
    background: rgb(0, 141, 76);
    border-bottom-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-search-kode .modal-footer {
    background: rgb(0, 141, 76);
    border-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-search-kode .modal-body {
    background: rgb(0, 166, 90);
    color: #fff;
  }
</style>
<script type='text/javascript'>
  $(document).ready(function() {
      $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcdokter/insert_dokter",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Dokter';
            $('#modal-insert').modal('hide'); 
            document.getElementById("insert_form").reset();
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
            document.getElementById("btn-insert").innerHTML = 'Insert Dokter';
            $('#modal-insert').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 
      $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcdokter/dokter_user_transaction",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Dokter';
            $('#modal-edit').modal('hide'); 
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
            document.getElementById("btn-edit").innerHTML = 'Edit Dokter';
            $('#modal-edit').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 
      $(document).on('hidden.bs.modal', '#modal-search-kode', function () {
        $('#table-dpjp > tbody').empty();
        $('#spesialis').val("NONE").change();
      });
      $(document).on("click",".select-kode-dpjp",function() {
          $("#kode_dpjp_bpjs").val($(this).data('kodedpjp'));
          $('#modal-search-kode').modal('hide');
      });
      $(document).on("click","#btn-cari-dpjp",function() {
        var button = $(this);
        var jns_pelayanan = $("#jns_pelayanan").val();
        var spesialis = $("#spesialis").val();
        button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
        if (jns_pelayanan === '' || spesialis === '') {
            button.html('<i class="fa fa-search"></i> Cari');
            swal("Lengkapi Data","Silahkan isi jenis pelayanan dan spesialis/sub spesialis.", "warning"); 
        } else {        
          $.ajax({
              type: "POST",
              url: "<?php echo site_url('bpjs/referensi/dokter_dpjp'); ?>"+"/"+jns_pelayanan+"/"+spesialis,
              dataType: "JSON",
              success: function(result) { 
                $('#table-dpjp > tbody').empty();
                button.html('<i class="fa fa-search"></i> Cari');
                if (result != '' || result != null) {
                  if (result.metaData.code == '200') {
                    $.each(result.response.list, function(i, item) {
                      $('#table-dpjp > tbody:last-child').append(
                        '<tr>'
                        +'<td class="text-center">'+item.kode+'</td>'
                        +'<td class="text-center">'+item.nama+'</td>'
                        +'<td class="text-center"><button class="btn btn-danger select-kode-dpjp" data-kodedpjp="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
                        +'</tr>'
                      );
                    });   
                  } else {
                    $('#table-dpjp > tbody:last-child').append(
                      '<tr>'
                      +'<td colspan="3" class="text-center">'+result.metaData.message+'</td>'
                      +'</tr>'
                    );
                  }
                } else {
                  swal("Error","Gagal load data dokter dpjp.", "error");  
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

  function edit_dokter(id_dokter) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcdokter/get_data_edit_dokter')?>",
      data: {
        id_dokter: id_dokter
      },
      success: function(data){
	      //alert(data[0].id_dokter);
        $('#edit_id_dokter').val(data[0].id_dokter);
        $('#edit_id_dokter_hidden').val(data[0].id_dokter);
        $('#edit_nm_dokter').val(data[0].nm_dokter);
        $('#edit_nipeg').val(data[0].nipeg);
        $('#kode_dpjp_bpjs').val(data[0].kode_dpjp_bpjs);
        $('#edit_klp_pelaksana').val(data[0].klp_pelaksana).change();;
      	$('#edit_poli').val(data[0].id_poli).change();
      	$('#edit_biaya').val(data[0].id_biaya_periksa).change();
      	$('#old_poli').val(data[0].id_poli);
        $('#old_klp_pelaksana').val(data[0].klp_pelaksana);
        $('#edit_ket').val(data[0].ket);
      },
      error: function(){
        alert("error");
      }
    });
  }
function search_dpjp() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search_dpjp");
  filter = input.value.toUpperCase();
  table = document.getElementById("table-dpjp");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}



function delete_dokter(id){
    if (confirm('Yakin Mengaktifkan Diagnosa ini?')) {
      // $('#modalLoading').modal('show');
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/mcdokter/delete_dokter/"+id,
        data: {
          id: id
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
          // $('#modalLoading').modal('hide');
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


  function aktif_dokter(id){
    if (confirm('Yakin Mengaktifkan Diagnosa ini?')) {
      // $('#modalLoading').modal('show');
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/mcdokter/active_dokter/"+id,
        data: {
          id: id
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
          // $('#modalLoading').modal('hide');
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
          <h3 class="text-white">DAFTAR DOKTER USER ( RELASI DOKTER DENGAN USER LOGIN )</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>
          <form method="POST" id="insert_form" class="form-horizontal"> 
          
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-insert"><i class="fa fa-plus"></i> Dokter User</button>
              </span>
            </div><!-- /input-group --> 
          

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="modal-insert" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Tambah Dokter Baru</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_nm_dokter">Nama Dokter</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="nm_dokter" id="nm_dokter" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <p class="col-sm-4 form-control-label" id="lbl_nipeg">Nipeg</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="nipeg" id="nipeg">
                        </div>
                      </div>
    		              <div class="form-group row">
                        <p class="col-sm-4 form-control-label" id="lbl_poli">Poli</p>
                        <div class="col-sm-8">
                          <select  class="form-control" style="width: 100%" name="poli" id="poli" >
                    				<option value="">-Pilih Poli-</option>
                    				<?php 									
                    					foreach($poli as $row1){						
                    						
                    						echo '<option value="'.$row1->id_poli.'">'.$row1->nm_poli.'</option>';											
                    					}
                    				?>
                    			</select>
                        </div>
                      </div>
    		              <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_biaya">Biaya Periksa</p>
                        <div class="col-sm-8">
                          <select  class="form-control" style="width: 100%" name="biaya" id="biaya" >
                    				<option value="">-Pilih Biaya Periksa-</option>
                    				<?php 									
                    					foreach($biaya as $row1){						
                    						echo '<option value="'.$row1->idtindakan.'">'.$row1->nmtindakan.'</option>';											
                    					}
                    				?>
                    			</select>
                        </div>
                      </div>
                      <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_poli">Kelompok Pelaksana</p>
                        <div class="col-sm-8">
                          <select  class="form-control" style="width: 100%" name="klp_pelaksana" id="klp_pelaksana" >
                            <option value="">-Pilih Kelompok-</option>            
                                <option value="DOKTER">DOKTER</option>
                                  <option value="PERAWAT">PERAWAT</option>
                                    <option value="PETUGAS">PETUGAS</option>                      
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label" id="lbl_ket">Keterangan</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="ket" id="ket" required>
                        </div>
                      </div>
                      <div class="form-group row">                      
                        <p class="col-sm-4 form-control-label">Scan TTD</p>
                        <div class="col-sm-8">                          
                          <div class="controls">
                            <input type="file" class="form-control" aria-invalid="false" name="insert_scan_ttd" id="insert_scan_tdd" accept="image/*"> 
                            <div class="help-block"></div>
                          </div>                                                                                     
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <table width="100%" class="table table-bordered table-condensed">
                        <thead>
                          <tr>
                            <td><b><i>Untuk Dokter :</i></b></td>
                            <td><b><i>Isi Keterangan Dengan :</i></b></td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Instalasi Rawat Darurat</td>
                            <td>Dokter Jaga</td>
                          </tr>
                          <tr>
                            <td>Residen</td>
                            <td>Dokter Residen</td>
                          </tr>
                          <tr>
                            <td>Patologi Anatomi</td>
                            <td>Patologi Anatomi</td>
                          </tr>
                          <tr>
                            <td>Laboratorium</td>
                            <td>Patologi Klinik</td>
                          </tr>
                          <tr>
                            <td>Radiologi</td>
                            <td>Radiologi</td>
                          </tr>
                          <tr>
                            <td>Kamar Operasi</td>
                            <td>Operasi</td>
                          </tr>
                          <tr>
                            <td>Perawat Ruangan IRI</td>
                            <td>Perawat</td>
                          </tr>
                          <tr>
                              <td>Keterangan</td>
                              <td>Spesialis (Nama Poli)</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                  <button class="btn btn-info waves-effect" type="submit" id="btn-insert">Insert Dokter</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- <?php echo form_close();?> -->
          </form>
          <br/>           

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Id Relasi</th>
                <th>Id Dokter</th>
                <th>Nama Dokter</th>
                <th>Id User</th>
                <th>Nama User</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($dokter_user as $row){
                   

              ?>
              <tr>
                  <td><?= $row->id_relasi; ?></td>
                <td><?php echo $row->id_dokter; ?></td>
                <td><?php echo $row->nm_dokter;?></td>
                <td><?= $row->userid ?></td>
                <td><?= $row->name ?></td>
              
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit" data-id_dokter="<?= $row->id_dokter; ?>" data-nm_dokter="<?= $row->nm_dokter ?>" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                    <a class="btn btn-danger" href="<?= base_url('master/mcdokter/delete_relasi_dokter_user/'.$row->id_relasi) ?>">Delete</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

 
          <form method="POST" id="ttd_form" class="form-horizontal"> 
          <!-- Modal ttd Obat -->
          <div class="modal fade" id="modal-ttd" role="dialog" aria-labelledby="modal-ttd" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Tambah TTD</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">Id Dokter</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="ttd_id_dokter" id="ttd_id_dokter" disabled="">
                          <input type="hidden" class="form-control" name="ttd_id_dokter_hidden" id="ttd_id_dokter_hidden">
                        </div>
                      </div>
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">Nama Dokter</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="ttd_nm_dokter" id="ttd_nm_dokter" disabled="">
                        </div>
                      </div>
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">TTD</p>
                        <div class="col-sm-8">
                        <!-- <div id="tandatangan"></div> -->
                        <canvas class="canvas"></canvas>                        
                        </div>
                      </div>
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">TTD DISIMPAN</p>
                        <div class="col-sm-8">
                        <img id="my_image" name="my_image" alt="ttd belum ada" style="" />                      
                        </div>
                      </div>
                      
                  
                </div>
                  
    
                <div class="modal-footer">
		              <input type="hidden" class="form-control" name="old_poli" id="old_poli">
                  <button type="button" class="btn btn-danger waves-effect " data-dismiss="modal">Close</button>
                  <button class="btn btn-info waves-effect btn-ttd" type="submit" id="btn-edit">Tambah TTD</button>
                </div>
              </div>
            </div>
          </div>
          </form>
        <form method="POST" id="edit_form" class="form-horizontal"> 
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="modal-edit" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit Dokter</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">Id Dokter</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="edit_id_dokter" id="id_dokter">
                        </div>
                      </div>
                      <div class="form-group row">                        
                        <p class="col-sm-4 form-control-label">Nama Dokter</p>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="edit_nm_dokter" id="nm_dokter">
                        </div>
                      </div>
                        <div class="form-group row">                        
                            <p class="col-sm-4 form-control-label" id="lbl_poli">User</p>
                            <div class="col-sm-8">
                            <select  class="form-control select2" style="width: 100%" name="edit_userid" id="edit_userid"  >
                                        <option value="">-Pilih User-</option>
                                        <?php 									
                                            foreach($hmis_users as $row1){                    						
                                                    echo '<option value="'.$row1->userid.'">'.$row1->name.' ('.$row1->userid.')'.'</option>';											
                                            }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        
                        </tbody>
                      </table>
              		  </div>
            		  </div>
                </div>
		
                <div class="modal-footer">
		              <input type="hidden" class="form-control" name="old_poli" id="old_poli">
                  <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                  <button class="btn btn-info waves-effect" type="submit" id="btn-edit">Edit Dokter</button>
                </div>
              </div>
            </div>
          </div>
          </form>



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

<div id="modal-search-kode" class="modal modal-search-kode fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-success">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title text-white" id="modal-search-kode">Cari Kode DPJP (BPJS)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <div class="col-sm-3">
                      <select  class="form-control" style="width: 100%" name="jns_pelayanan" id="jns_pelayanan">
                        <option value="2" selected="">R. Jalan</option>
                        <option value="1">R. Inap</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="spesialis" id="spesialis" >
                        <option value="NONE">-- Pilih Poli --</option>
                        <?php                   
                          foreach($poli as $row) {
                            if ($row->poli_bpjs != '' || $row->poli_bpjs != null) {
                              echo '<option value="'.$row->poli_bpjs.'">'.$row->nm_poli.'</option>';  
                            }                                
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-danger btn-block" type="button" id="btn-cari-dpjp"><i class="fa fa-search"></i> Cari</button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group row">
                      <div class="col-sm-12">
                          <div class="input-group">
                            <span class="input-group-btn">
                                  <button class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                              </span>
                              <input type="text" class="form-control" id="search_dpjp" onkeyup="search_dpjp()" placeholder="Ketikan Nama Dokter DPJP..">
                          </div> 
                      </div>
                    </div>
                </div>
                <div class="col-sm-12">
                  <table width="100%" class="table table-bordered table-condensed" id="table-dpjp">
                    <thead>
                      <tr>
                        <th class="text-center" width="22%"><b>Kode DPJP</b></th>
                        <th class="text-center" width="63%"><b>Nama Dokter</b></th>
                        <th class="text-center" width="15%"><b>Aksi</b></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
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

<script type='text/javascript'>

// $(function){
    $('#modal-edit').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var edit_id_dokter = $(e.relatedTarget).data('id_dokter');
    var nm_dokter = $(e.relatedTarget).data('nm_dokter');
    // console.log(iduser);

    //populate the textbox
    $(e.currentTarget).find('input[name="edit_id_dokter"]').val(edit_id_dokter);
    $(e.currentTarget).find('input[name="edit_nm_dokter"]').val(nm_dokter);
    });
// }


// $('#tandatangan').signature({guideline: true});
var canvas = document.querySelector("canvas");

var signaturePad = new SignaturePad(canvas);

function add_ttd(id_dokter) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcdokter/get_data_edit_dokter')?>",
      data: {
        id_dokter: id_dokter
      },
      success: function(data){
	      //alert(data[0].id_dokter);
        $('#ttd_id_dokter').val(data[0].id_dokter);
        $('#ttd_id_dokter_hidden').val(data[0].id_dokter);
        $('#ttd_nm_dokter').val(data[0].nm_dokter);
        $("#my_image").attr("src",data[0].ttd);
      },
      error: function(){
        alert("error");
      }
    });
}


$(document).on('click','.btn-ttd',function(e){
        e.preventDefault();        
    // var signature = $('#tandatangan').signature('toDataURL');
    var signature =	signaturePad.toDataURL(); 
    // var image = signature.replace("image/png", "image/octet-stream");
    // window.location.href=image;
    var id_dokter = $('#ttd_id_dokter_hidden').val();
		$.ajax({
			url: "<?php echo base_url(); ?>master/mcdokter/add_ttd",
			data :{
				foto: signature,
        id_dokter : id_dokter
			},
			method: "POST",
			success:function(data){
        if (data = true) {        
                        swal({
                            title: "Selesai",
                            text: "TTD Sudah Disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
            } else {
              swal("Error","TTD gagal disimpan.", "error");
            }
			},
          error:function(event, textStatus, errorThrown) {
            $('#modal-ttd').modal('hide');
            swal("Error","TTD gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  

		})
	})

</script>


<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
