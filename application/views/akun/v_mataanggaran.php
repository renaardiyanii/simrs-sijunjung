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

  function edit_mataanggaran(kode) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_mataanggaran')?>",
      data: {
        kode: kode
      },
      success: function(data){
        $('#edit_kode').val(data[0].kode_manggaran);
        $('#edit_kode_hidden').val(data[0].kode_manggaran);
        $('#edit_nm_manggaran').val(data[0].nm_manggaran);
        $('#edit_upkode').val(data[0].upkode).change();
        },
      error: function(){
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
    <div class="col-xs-12">
      <div class="card">	
        <div class="card-block ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('akun/crsakun/insert_mataanggaran');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Mata Anggaran</i> </button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
		<br>
          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Mata Anggaran</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_kode_manggaran">Kode Mata Anggaran</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kode_manggaran" id="kode_manggaran" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_manggaran">Nama</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_manggaran" id="nm_manggaran" required>
                    </div>
                  </div>
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_upkode">Upkode</p>
                    <div class="col-sm-6">
                      	<select  class="form-control select2" style="width: 100%" name="upkode" id="upkode"  >
                  				<option value="">Parent</option>
                          <?php foreach($anggaranparent as $row){ 
                            echo '<option value="'.$row->kode_manggaran.'" >'.$row->nm_manggaran.'</option>';
                          }?>
                  			</select>
                    </div>
                  </div>
                  
		  
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          
          <?php echo form_close();?>
          <br/> 
          <br/> 

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
		            <th>KODE</th>
		            <th>NAMA</th>
                <th>UPKODE</th>
                <th>STATUS</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>KODE</th>
                <th>NAMA</th>
                <th>UPKODE</th>
                <th>STATUS</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($mataanggaran as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kode_manggaran;?></td>
                <td><?php echo $row->nm_manggaran;?></td>
                <td><?php if($row->upkode_nm!=''){echo $row->upkode_nm.' ('.$row->upkode.')';}?></td>
                <td><?php echo $row->status;?></td>
                <td>
                  <?php if($row->status=='Aktif'){?>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_mataanggaran('<?php echo $row->kode_manggaran;?>')"><i class="fa fa-edit"></i></button>	
					<a href="<?php echo base_url('akun/crsakun/delete_mataanggaran/').'/'.$row->kode_manggaran;?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i></a>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('akun/crsakun/edit_mataanggaran');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Mata Anggaran</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-2 form-control-label">Kode</p>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="edit_kode" id="edit_kode" disabled="true">
                      <input type="hidden" class="form-control" name="edit_kode_hidden" id="edit_kode_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-2 form-control-label">Nama</p>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="edit_nm_manggaran" id="edit_nm_manggaran" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-2 form-control-label">Upkode</p>
                    <div class="col-sm-9">
                      	<select  class="form-control select2" style="width: 100%" name="edit_upkode" id="edit_upkode" >
				                  <option value="">Parent</option>
				                  <?php foreach($anggaranparent as $row){ 
                            echo '<option value="'.$row->kode_manggaran.'" >'.$row->nm_manggaran.'</option>';
                          }?>
			                  </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xupdate">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

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
