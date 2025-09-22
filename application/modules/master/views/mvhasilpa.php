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
      $('#example').DataTable( {
        "iDisplayLength": 50
      } );
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

  function delete_jenis_hasil_pa(id_jenis_hasil_pa){
    if (confirm('Yakin Menghapus Jenis Hasil Patologi Anatomi?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mchasilpa/delete_jenis_hasil_pa')?>",
        data: {
          id_jenis_hasil_pa: id_jenis_hasil_pa
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          location.reload();
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR JENIS HASIL PATOLOGI ANATOMI</h3>
        </div>
        <div class="box-body ">

          <div class="col-sm-9">
          </div>

          <?php echo form_open('master/mchasilpa/insert_jenis_hasil_pa');?>
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Jenis Hasil PA Baru</button>
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
                  <h4 class="modal-title">Tambah Jenis Hasil PA</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_id_tindakan">Nama Tindakan</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="id_tindakan" id="id_tindakan" required="">
                          <option value="">-Pilih Tindakan-</option>
                          <?php                   
                            foreach($tindakan_pa as $row1){                                          
                              echo '<option value="'.$row1->idtindakan.'">'.$row1->nmtindakan.'</option>';                   
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Jenis Hasil</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="jenis_hasil" id="jenis_hasil">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Kadar Normal</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="kadar_normal" id="kadar_normal">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="satuan" id="satuan">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>
    
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Jenis Hasil PA</button>
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
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Jenis hasil</th>
                <th>Kadar Normal</th>
                <th>Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($hasil_pa as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_tindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td><?php echo $row->jenis_hasil;?></td>
                <td><?php echo $row->kadar_normal;?></td>
                <td><?php echo $row->satuan;?></td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#editModal" onclick="delete_jenis_hasil_pa('<?php echo $row->id_jenis_hasil_pa;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
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
