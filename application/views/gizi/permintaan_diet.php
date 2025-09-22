<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<script type="text/javascript">
  var table_history;

  $(document).ready(function() {  
    show_permintaan_diet('<?php echo $data_pasien->no_ipd; ?>');
    $('.select2').select2();
    $("#form_permintaan_diet").submit(function(event) {
      document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'gizi/insert_permintaan_diet'; ?>",
          dataType: "JSON",
          data: {"no_ipd" : "<?php echo $data_pasien->no_ipd; ?>","bed" : "<?php echo $data_pasien->bed; ?>","standar_diet" : $("#standar_diet").val().toString(),"catatan" : $("#catatan").val(),"bentuk_makanan" : $("#bentuk_makanan").val()},
          success: function(result) {   
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            if (result.metadata.code == '200') {
              table_history.ajax.reload(); 
              show_permintaan_diet('<?php echo $data_pasien->no_ipd; ?>');
              swal("Sukses", "Permintaan Diet Berhasil Disimpan.", "success");
            } else if (result.metadata.code == '402') {
              swal(result.metadata.message, "Harap isikan data jika ada perubahan permintaan diet.", "warning"); 
            } else {
              swal("Gagal Menyimpan Permintaan", "Silahkan COba Lagi.", "error");            
            }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';                     
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
      });
      event.preventDefault();
    });
    table_history = $('#table-history').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/history_permintaan_diet')?>",
        "type": "POST",
        "data": {"no_ipd" : "<?php echo $data_pasien->no_ipd; ?>"}
      }
    });
  });

  function show_permintaan_diet(no_ipd)
  {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('gizi/show_permintaan_diet'); ?>/"+no_ipd,
      dataType: "JSON",      
      success: function(result){    
      console.log(result);     
        if (result != null) {    
          var standar_diet = result.standar.split(',');
          $('#standar_diet').select2().select2('val', [standar_diet]);
          $('#bentuk_makanan').val(result.bentuk).trigger('change');
          $('#catatan').val(result.catatan);
        }
      },
      error:function(event, textStatus, errorThrown) { 
        swal("Gagal Menampilkan Data Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
      }
    });
  }
</script>
<div class="row">
  <!-- Column -->
  <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card card-outline-info">
          <div class="card-body">
              <div class="d-flex flex-row">
                <div class=""><img src="<?php echo base_url("upload/photo/unknown.png");?>" alt="user" class="img-circle" width="80"></div>
                <div class="p-l-15 m-t-15">
                    <h4 class="font-medium"><?php echo $data_pasien->nama; ?></h4>
                    <h6>No. RM : <?php echo $data_pasien->no_cm; ?></h6>                    
                </div>
              </div>
          </div>
          <div>
              <hr> </div>
          <div class="card-body"> 
            <h6 class="text-muted">Ruangan</h6>
            <h5 class="m-b-15"><?php echo $data_pasien->lokasi; ?></h5> 
            <h6 class="text-muted">Kelas</h6>
            <h5 class="m-b-15"><?php echo $data_pasien->kelas; ?></h5> 
            <h6 class="text-muted">Kamar - Bed</h6>
            <h5 class="m-b-15"><?php echo $kamar_bed; ?></h5>  
            <h6 class="text-muted">Diagnosa</h6>
            <h5><?php echo $data_pasien->nm_diagnosa; ?></h5> 
          </div>
      </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="col-lg-8 col-xlg-9 col-md-7">
    <div class="ribbon-wrapper card">
      <div class="ribbon ribbon-info">Permintaan Diet</div>
      <div class="ribbon-content">
        <div class="p-20">
          <form class="form-horizontal" method="POST" id="form_permintaan_diet">
            <div class="form-group row">
              <label for="standar_diet" class="col-3 col-form-label">Standar Diet</label>
              <div class="col-9">
                <select id="standar_diet" name="standar_diet" class="form-control select2 select2-multiple" multiple="multiple" style="width:100%;" data-placeholder="-- Pilih Standar Diet --">                    
                    <?php 
                      foreach($standar_diet as $row) { ?>
                        <option value="<?php echo $row->standar; ?>"><?php echo $row->standar; ?></option>
                    <?php } ?>
                </select> 
              </div>
            </div>
            <div class="form-group row">
              <label for="bentuk_makanan" class="col-3 col-form-label">Bentuk Makanan</label>
              <div class="col-9">
                <select id="bentuk_makanan" name="bentuk_makanan" class="form-control select2"  style="width:100%;" required>
                    <option value="">-- Pilih Bentuk Makanan --</option>
                    <?php 
                      foreach($bentuk_makanan as $row) { ?>
                        <option value="<?php echo $row->kode; ?>"><?php echo $row->kode.' ('.$row->nm_bentuk.')'; ?></option>
                    <?php } ?>
                </select> 
              </div>
            </div>
            <div class="form-group row">
              <label for="catatan" class="col-3 col-form-label">Catatan</label>
              <div class="col-9">
                <textarea class="form-control" id="catatan" name="catatan" rows="6"></textarea>    
              </div>
            </div> 
            <div class="form-group row">          
              <div class="col-9 push-md-3">
                <button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit"><i class="fa fa-floppy-o"></i> Simpan</button>  
              </div>
            </div>            
          </form>            
        </div>
      </div>
    </div>    
  </div>
  <!-- Column -->
</div>
<div class="row">
  <div class="col-12">
    <div class="ribbon-wrapper card">
      <div class="ribbon ribbon-info">History Perubahan</div>
      <div class="ribbon-content">
        <div class="p-20">          
          <div class="table-responsive m-t-0">      
            <table id="table-history" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th class="text-center">No.</th>
                <th>Standar Diet</th>
                <th class="text-center">Bentuk Makanan</th>
                <th>Catatan</th>  
                <th class="text-center">Waktu</th>  
                <th class="text-center">User</th>            
              </tr>
              </thead>
              <tbody>                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>