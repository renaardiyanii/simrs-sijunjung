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
    $('#example').DataTable({
      "iDisplayLength": 25
    });
    
  });
  
  function edit_tindakan(idtindakan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('pa/pacmaster/get_data_edit_tindakan_pa')?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data){
        $('#edit_id_hidden').val(data[0].id_kode_jenis_tindakan);
        $('#edit_idtindakan').val(data[0].idtindakan);
        $('#edit_idtindakan_hidden').val(data[0].idtindakan);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
        $('#edit_jenis').val(data[0].jenis);
        $('#edit_kode').val(data[0].kode);
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
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <!-- <div class="card-header">
          <h3 class="text-white"><?=$title;?></h3>
        </div> -->
        <div class="card-block">
          <!-- <div class="col-sm-3">
            <div class="input-group">
              <span class="input-group-btn">
                <a href="<?php echo site_url('pa/pacmaster/kode'); ?>" class="btn btn-primary btn-md">Tabel Kode</a>
              </span>
              <span class="input-group-btn">
                <a href="<?php echo site_url('pa/pacmaster/jenis'); ?>" class="btn btn-danger btn-md">Tabel Jenis</a>
              </span>
            </div>
          </div>

          <div class="col-sm-6">
          </div>
          <br> -->

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
			  	<th>Aksi</th>
			  	<th>ID Tindakan</th>
			  	<th>Nama Tindakan</th>
			  	<th>Jenis</th>
			  	<th>Kode</th>
            </thead>
            <tbody id="bodyt">
              <?php
                  $i=1;
                  foreach($tindakan as $row){
              ?>
              <tr>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_tindakan('<?php echo $row->idtindakan;?>')"><i class="fa fa-pencil"></i></button>
                </td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td><?php echo $row->nm_jenis;?></td>
                <td><?php echo $row->nm_kode;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('pa/pacmaster/edit_tindakan');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Tindakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <p class="col-sm-3 form-control-label">ID Tindakan</p>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="edit_idtindakan" id="edit_idtindakan" disabled="">
                      <input type="hidden" class="form-control" name="edit_idtindakan_hidden" id="edit_idtindakan_hidden">
                      <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-3 form-control-label">Nama Tindakan</p>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-3 form-control-label">Jenis</p>
                    <div class="col-sm-9">
                      <select id="edit_jenis" class="form-control" name="edit_jenis" required>
                        <option value="" disabled selected="">-Pilih Jenis-</option>
                        <?php 
                          foreach($jenis as $row){
                            echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-3 form-control-label">Kode</p>
                    <div class="col-sm-9">
                      <select id="edit_kode" class="form-control" name="edit_kode" required>
                        <option value="" disabled selected="">-Pilih Kode-</option>
                        <?php 
                          foreach($kode as $row){
                            echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit</button>
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
	$this->load->view('layout/footer_left.php');
?>