<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>

<style type="text/css">
  .clockpicker-popover {
    z-index: 999999 !important;
  }
</style>
<script type="text/javascript">
  var table_history;
  var id_edit;

  $(document).ready(function() {  
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });
    $('.clockpicker').clockpicker({
          donetext: 'Pilih',
          placement: 'top'
      }).find('input').change(function() {
          console.log(this.value);
      });
    show_permintaan_diet('<?php echo $data_pasien->no_register; ?>');
    $('.select2').select2();
    $("#form_permintaan_diet").submit(function(event) {
      document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'gizi/insert_permintaan_diet'; ?>",
          dataType: "JSON",
          data: {"no_ipd" : "<?php echo $data_pasien->no_register; ?>","bed" : "","standar_diet" : $("#standar_diet").val().toString(),"catatan" : $("#catatan").val(),"bentuk_makanan" : $("#bentuk_makanan").val(),"tgl_permintaan" : $("#tgl_permintaan").val(),"jam_permintaan" : $("#jam_permintaan").val()},
          success: function(result) {   
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            if (result.metadata.code == '200') {
              table_history.ajax.reload(); 
              show_permintaan_diet('<?php echo $data_pasien->no_register; ?>');
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
        "data": {"no_ipd" : "<?php echo $data_pasien->no_register; ?>"}
      }
    });

    if( "<?php echo $data_pasien->edukasi ?>" == 1){
      $("#edCheckbox").prop("checked", true);
    }else{
      $("#edCheckbox").prop("checked", false);
    }

    if("<?php echo $data_pasien->asuhan?>" == 1){
      $("#asCheckbox").prop("checked", true);
    }else{
      $("#asCheckbox").prop("checked", false);
    }

    if("<?php echo $data_pasien->screening?>" == 1){
      $("#screnCheckbox").prop("checked", true);
    }else{
      $("#screnCheckbox").prop("checked", false);
    }

    if("<?php echo $data_pasien->screening?>" == 1){
      $("#monCheckbox").prop("checked", true);
    }else{
      $("#monCheckbox").prop("checked", false);
    }

    $("#asCheckbox").on("click", function(){
      if($(this).is(":checked")){
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/asuhan/1",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Sukses", "Data Asuhan Gizi Berhasil Disimpan.", "success");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Asuhan Gizi",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }else{
         $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/asuhan/0",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Batal", "Data Asuhan Gizi Dibatalkan", "warning");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }
    });
    $("#edCheckbox").on("click", function(){
      if($(this).is(":checked")){
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/edukasi/1",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Sukses", "Data Edukasi Berhasil Disimpan.", "success");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Asuhan Gizi",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }else{
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/edukasi/0",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Batal", "Data Edukasi Dibatalkan", "warning");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }
    });
    $("#screnCheckbox").on("click", function(){
      if($(this).is(":checked")){
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/screening/1",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Sukses", "Data Screening Gizi Berhasil Disimpan.", "success");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Asuhan Gizi",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }else{
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/screening/0",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Batal", "Data Screening Gizi Dibatalkan", "warning");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }
    });
    $("#monCheckbox").on("click", function(){
      if($(this).is(":checked")){
        $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/monitoring/1",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Sukses", "Data Monitoring Gizi Berhasil Disimpan.", "success");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Monitoring Gizi",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }else{
         $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "<?php echo base_url().'gizi/insert_ceklis_ahli_gizi/'; ?>"+"<?php echo $data_pasien->no_register;?>"+"/monitoring/0",
          success: function(result){
            if (result.metadata.code == '200') {
              swal("Batal", "Data Monitoring Gizi Dibatalkan", "warning");
            }else{
              swal("Gagal", "Data Gagal Disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) { 
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
        });
      }
    });

    $("#form_permintaan_diet_edit").submit(function(event) {
      document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'gizi/edit_permintaan_diet'; ?>",
          dataType: "JSON",
          data: {"id" : id_edit,"standar_diet" : $("#standar_diet_edit").val().toString(),"catatan" : $("#catatan_edit").val(),"bentuk_makanan" : $("#bentuk_makanan_edit").val(),"tgl_permintaan" : $("#tgl_permintaan_edit").val(),"jam_permintaan" : $("#jam_permintaan_edit").val()},
          success: function(result) {   
            document.getElementById("btn-edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            if (result.metadata.code == '200') {
              table_history.ajax.reload(); 
              swal("Sukses", "Permintaan Diet Berhasil Diedit.", "success");
              $('#modal_edit').modal('hide');
            }  else {
              swal("Gagal Mengedit Permintaan", "Silahkan COba Lagi.", "error");            
            }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';                     
            swal("Gagal Mengedit Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
      });
      event.preventDefault();
    });
  });

  function show_permintaan_diet(no_ipd)
  {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('gizi/show_permintaan_diet'); ?>/"+no_ipd,
      dataType: "JSON",      
      success: function(result){    
      // console.log(result);     
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

  function hapus_permintaan_diet(id)
  {
    swal({
        title: "Hapus Data",
        text: "Hapus data tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "GET",
            url: "<?php echo site_url('gizi/delete_permintaan_diet'); ?>/"+id,
            dataType: "JSON",      
            success: function(result){    
            console.log(result);     
              if (result != null) {    
                table_history.ajax.reload();
                swal("Sukses", "Berhasil Menghapus Data Permintaan Diet.", "success");
              }
            },
            error:function(event, textStatus, errorThrown) { 
              swal("Gagal Menampilkan Data Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
            }
          });         
      }); 
  }

  function show_edit_permintaan_diet(id)
  {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('gizi/show_permintaan_diet_byid'); ?>/"+id,
      dataType: "JSON",      
      success: function(result){    
      console.log(result);     
        if (result != null) {    
          id_edit = result.id;
          var standar_diet = result.standar.split(',');
          $('#standar_diet_edit').select2().select2('val', [standar_diet]);
          $('#bentuk_makanan_edit').val(result.bentuk).trigger('change');
          $('#catatan_edit').val(result.catatan);
          $('#tgl_permintaan_edit').val(result.created_at.substr(0, 10));
          $('#jam_permintaan_edit').val(result.created_at.substr(11, 5));
          $('#modal_edit').modal('show');
        }
      },
      error:function(event, textStatus, errorThrown) { 
        swal("Gagal Menampilkan Data Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
      }
    });
  }
</script>
<div class="row">
  <div class="col-lg-4 col-xlg-3 col-md-5">
      <div class="card card-outline-info">
          <div class="card-body">
            <center class="m-t-30"> <img src="<?php echo base_url("upload/photo/unknown.png");?>" class="img-circle" width="100">
              <h4 class="card-title m-t-10"><?php echo $data_pasien->nama; ?></h4>
              <h5>No. RM : <?php echo $data_pasien->no_cm; ?></h5>
              <h5>No. Register : <?php echo $data_pasien->no_register; ?></h5>
            </center>
          </div>
          <div><hr></div>
          <div class="card-block"> 
            <h6 class="text-muted">Ruangan</h6>
            <h5 class="m-b-15">UGD</h5> 
            <h6 class="text-muted">Tgl. Kunjungan</h6>
            <h5 class="m-b-15"><?php echo $data_pasien->tgl_kunjungan; ?></h5> 
            <h6 class="text-muted">Kelas</h6>
            <h5 class="m-b-15">III</h5>
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
            <div class="form-group row">
              <input type="checkbox" id="asCheckbox" class="flat-red" name="asCheckbox">  
              <label for="asCheckbox" class="col-xl-2 col-sm-12 col-form-label">Asuhan Gizi</label>
              <input type="checkbox" id="edCheckbox" class="flat-red" name="edCheckbox"> 
              <label for="edCheckbox" class="col-xl-2 col-sm-12 col-form-label">Edukasi</label>
              <input type="checkbox" id="screnCheckbox" class="flat-red" name="screnCheckbox">
              <label for="screnCheckbox" class="col-xl-3 col-sm-12 col-form-label"> Konsultasi Dokter Gizi </label>
              <input type="checkbox" id="monCheckbox" class="flat-red" name="monCheckbox">
              <label for="monCheckbox" class="col-xl-3 col-sm-12 col-form-label"> Monitoring Gizi </label>
            </div>
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
              <label for="catatan" class="col-3 col-form-label">Tanggal Permintaan</label>
              <div class="col-9">
                <div class='input-group date' >
                  <input type="text" class="form-control date_picker" id="tgl_permintaan" name="tgl_permintaan" placeholder="Tanggal" value="<?=date('Y-m-d');?>">
                  <span class="input-group-addon">
                    <span class="fa fa-calendar-o"></span>
                  </span>
                </div>
              </div>
            </div> 
            <div class="form-group row">
              <label for="catatan" class="col-3 col-form-label">Jam Permintaan</label>
              <div class="col-9">
                <div class='input-group clockpicker' >
                  <input type="text" id="jam_permintaan" name="jam_permintaan" class="form-control" placeholder="Jam" value="<?=date('H:i');?>" required="">
                  <span class="input-group-addon">
                    <span class="fa fa-clock-o"></span>
                  </span>
                </div>
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
                <th class="text-center">Aksi</th>            
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
<div class="modal fade" id="modal_edit" aria-labelledby="modal_edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form-horizontal" method="POST" id="form_permintaan_diet_edit">
        <div class="modal-header">
            <h4 class="modal-title" id="title-pendidikan">Tambah Pendidikan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body"> 
          <div class="form-group row">
            <label for="standar_diet_edit" class="col-3 col-form-label">Standar Diet</label>
            <div class="col-9">
              <select id="standar_diet_edit" name="standar_diet_edit" class="form-control select2 select2-multiple" multiple="multiple" style="width:100%;" data-placeholder="-- Pilih Standar Diet --">                    
                  <?php 
                    foreach($standar_diet as $row) { ?>
                      <option value="<?php echo $row->standar; ?>"><?php echo $row->standar; ?></option>
                  <?php } ?>
              </select> 
            </div>
          </div>
          <div class="form-group row">
            <label for="bentuk_makanan_edit" class="col-3 col-form-label">Bentuk Makanan</label>
            <div class="col-9">
              <select id="bentuk_makanan_edit" name="bentuk_makanan_edit" class="form-control select2"  style="width:100%;" required>
                  <option value="">-- Pilih Bentuk Makanan --</option>
                  <?php 
                    foreach($bentuk_makanan as $row) { ?>
                      <option value="<?php echo $row->kode; ?>"><?php echo $row->kode.' ('.$row->nm_bentuk.')'; ?></option>
                  <?php } ?>
              </select> 
            </div>
          </div>
          <div class="form-group row">
            <label for="catatan_edit" class="col-3 col-form-label">Catatan</label>
            <div class="col-9">
              <textarea class="form-control" id="catatan_edit" name="catatan_edit" rows="6"></textarea>    
            </div>
          </div> 
          <div class="form-group row">
            <label for="tgl_permintaan_edit" class="col-3 col-form-label">Tanggal Permintaan</label>
            <div class="col-9">
              <div class='input-group date' >
                <input type="text" class="form-control date_picker" id="tgl_permintaan_edit" name="tgl_permintaan_edit" placeholder="Tanggal">
                <span class="input-group-addon">
                  <span class="fa fa-calendar-o"></span>
                </span>
              </div>
            </div>
          </div> 
          <div class="form-group row">
            <label for="jam_permintaan_edit" class="col-3 col-form-label">Jam Permintaan</label>
            <div class="col-9">
              <div class='input-group clockpicker' style="z-index: 999999">
                <input type="text" id="jam_permintaan_edit" name="jam_permintaan_edit" class="form-control" placeholder="Jam">
                <span class="input-group-addon">
                  <span class="fa fa-clock-o"></span>
                </span>
              </div>
            </div>
          </div>   
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn-edit"><i class="fa fa-floppy-o"></i> Edit</button>
        </div>        
      </form>
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