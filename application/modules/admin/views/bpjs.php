<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<script type="text/javascript">
  $(document).ready(function() {
    load_data();
    $("#form-bpjs").submit(function(event) {
      document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'admin/update_bpjs'; ?>",
          dataType: "JSON",
          data: $('#form-bpjs').serialize(),
          success: function(data){      
            if (data == true) {
                load_data();
                swal("Sukses", "Data berhasil disimpan.", "success");
                document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            } else {
                swal("Gagal", "Data gagal disimpan.", "error");
                document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            }
          },
          error:function(event, textStatus, errorThrown) {        
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }
      });
      event.preventDefault();
    });
  });
  function load_data(){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'admin/show_bpjs'; ?>",
        dataType: "JSON",
        success: function(result) { 
          console.log(result);
          $('#service_url').val(result.service_url);
          $('#consid').val(result.consid);
          $('#secid').val(result.secid);
          $('#rsid').val(result.rsid);
          if (result.poli_eksekutif === 1) {
            $('#poli_eksekutif').prop('checked', true);
          } 
          if (result.cob_irj === 1) {
            $('#cob_irj').prop('checked', true);
          }
          if (result.cob_iri == 1) {
            $('#cob_iri').prop('checked', true);
          }       
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Gagal meload data.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
  }
  function show_hide_secid() {
    if ($('#secid').attr("type") == "password") {
      swal({
        title: "Show/Hide Secret ID",
        text: "Masukkan Password :",
        type: "input",
        inputType: "password",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Submit",
        animation: "slide-from-top",
        inputPlaceholder: "Masukkan Password",
        showLoaderOnConfirm: true
      }, function(password) {
          if (password === false) return false;
          if (password === "") {
            swal.showInputError("Password tidak boleh kosong!");
            return false
          } 
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'admin/show_hide_secid'; ?>",
            dataType: "JSON",    
            data: {"user" : "<?php echo $user_info->username;?>","password" : password},
            success: function(result) { 
              if (result.length == 0) {
                swal.showInputError("Password yang anda masukkan salah.");
                return false
              } else {
                if ($('#secid').attr("type") == "password") {
                  $('#secid').attr("type", "text");
                  $('#btn_secid').html("<u>Hide</u>");
                } else {
                  $('#secid').attr("type", "password");
                  $('#btn_secid').html("<u>Show</u>");
                }
                swal.close();
              }
            },
            error:function(event, textStatus, errorThrown) {    
                swal(errorThrown,formatErrorMessage(event, errorThrown), "error");     
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
          });     
      }); 
    }
    if ($('#secid').attr("type") == "text") {
      $('#secid').attr("type", "password");
      $('#btn_secid').html("<u>Show</u>");
    }
  }
</script>
<?php echo $this->session->flashdata('success_msg'); ?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="card card-outline-info">
      <div class="card-header text-center">
       <h4 class="m-b-0 text-white">Bridging BPJS</h4>
      </div>
      <div class="card-block">
        <form role="form" method="POST" id="form-bpjs">
          <div class="box-body">
            <div class="form-group">
              <label for="service_url">Service URL</label>
              <input class="form-control" id="service_url" name="service_url" type="text" value="<?php echo $data->service_url; ?>">
            </div>              
            <div class="form-group">
              <label for="consid">Cons ID</label>
              <input class="form-control" id="consid" name="consid" type="text" value="<?php echo $data->consid; ?>">
            </div>
            <div class="form-group">
              <label for="secid">Sec ID</label>
              <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="show_hide_secid()" id="btn_secid"><u>Show</u></button>
                </span>
                <input class="form-control" id="secid" name="secid" type="password" value="<?php echo $data->secid; ?>">
              </div>  
            </div>
            <div class="form-group">
              <label for="rsid">RS ID</label>
              <input class="form-control" id="rsid" name="rsid" type="text" value="<?php echo $data->rsid; ?>">
            </div>
            <div class="form-group">
              <div class="demo-checkbox"> 
                <input type="checkbox" class="filled-in" value="1" name="poli_eksekutif" id="poli_eksekutif" <?php if($data->poli_eksekutif == 1 ) echo 'checked';?>/>
                  <label for="poli_eksekutif">Poli Eksekutif</label>
              </div>
            </div>
            <div class="form-group">
              <div class="demo-checkbox"> 
                <input type="checkbox" class="filled-in" value="1" name="cob_irj" id="cob_irj" <?php if($data->cob_irj == 1 ) echo 'checked';?>/>
                  <label for="cob_irj">COB Rawat Jalan</label>
              </div>
            </div>
            <div class="form-group">
              <div class="demo-checkbox"> 
                <input type="checkbox" class="filled-in" value="1" name="cob_iri" id="cob_iri" <?php if($data->cob_iri == 1 ) echo 'checked';?>/>
                  <label for="cob_iri">COB Rawat Inap</label>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
        </form>
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