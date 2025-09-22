<?php if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
} ?>
<html>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
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

  function edit_tind(lis, idtindakan) {
    // swal("Success","Loading.");  
    swal({
      title: "Success",
      text: "Loading....",
      buttons: false,
      timer: 5000
    });
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('lab/mctindakanlab/edit_tindakan_lab_lis')?>",
      data: {
        idtindakan: idtindakan,
        lis: lis
      },
      success: function(data){ 
        // swal("Success","Berhasil Update Data Tindakan.", "success");  
        swal({
          title: "Success",
          text: "Berhasil Update Data Tindakan.",
          type: "success",
          timer: 1500
        });

      },
      error: function(){
        swal("Error","Maaf Data Tindakan tidak terupdate.", "error");
      }
    });
  }

</script>
<section class="content-header">
  <?php
    // echo $this->session->flashdata('success_msg');
    // $this->session->set_flashdata('success_msg', "");
    echo $this->session->tempdata('msg_success');
    $this->session->unset_tempdata('msg_success');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <div class="card card-outline-info">
        <!-- <div class="card-header">
          <h3 class="card-title text-white">DAFTAR TINDAKAN</h3>
        </div> -->
        <div class="card-block ">
          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <!-- <th width="15%">LIS</th> -->
                <th>Komponen Hasil</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <!-- <th>LIS</th> -->
                <th>Komponen Hasil</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $j=1;
                  foreach($tindakan as $row){
                    $selected1='';
                    $selected0='';
              ?>
              <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <?php
                  // echo "
                  // <td>
                  //   <select onchange='edit_tind(this.value, \"".$row->idtindakan."\")' class='form-control select2' style='width: 100%' name='idkel_".$row->idtindakan."' id='idkel_".$row->idtindakan."'> 
                  //     <option value='' selected>-Pilih LIS-</option>";
                  //     if($row->lis=='1')
                  //       $selected1 = 'selected';
                  //     if($row->lis=='0')
                  //       $selected0 = 'selected';
                  //     echo '<option value="1" '.$selected1.'>True</option>';
                  //     echo '<option value="0" '.$selected0.'>False</option>';
                  //   echo '</select></td>';
                ?>
                <td><a href="javascript:;" class="btn btn-success" onClick="return openUrl('<?php echo site_url('lab/mctindakanlab/tindakan/'.$row->idtindakan); ?>');"><i class="ti-pencil"></i></a></td>
                
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
