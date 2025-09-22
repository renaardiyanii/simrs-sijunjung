<?php if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
} ?>
<html>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#table_tindakan').DataTable({
      autoWidth: false
    });
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

    // $('.icd9_select2').select2({
    //   placeholder: 'Ketik kode atau nama prosedur',
    //   minimumInputLength: 1,
    //   language: {
    //     inputTooShort: function(args) {
    //       return "Ketik kode atau nama prosedur";
    //     },
    //     noResults: function() {
    //       return "Procedure tidak ditemukan.";
    //     },
    //     searching: function() {
    //       return "Searching.....";
    //     }
    //   },
    //   ajax: {
    //     type: 'GET',
    //     url: '<?php echo base_url().'procedure/select2'; ?>',
    //     dataType: 'JSON',          
    //     delay: 250,
    //     processResults: function (data) {            
    //       return {
    //         results: data
    //       };
    //     },
    //     cache: true
    //   }
    // }).on("change", function() { 
    //   var data = $(this).select2('data');
    //   var id_tindakan = $(this).data("idtindakan");
    //   if (data.length > 0) {
    //     save_prosedur(id_tindakan,data[0].id);
    //   }
    // });
  });

  function edit_kel(idkel_inacbg, idtindakan) {
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
      url:"<?php echo base_url('inacbg/master/edit_tindakan')?>",
      data: {
        idtindakan: idtindakan,
        idkel_inacbg: idkel_inacbg
      },
      success: function(data){ 
        // swal("Success","Berhasil Update Data Kelompok.", "success");  
        swal({
          title: "Success",
          text: "Berhasil Update Data Kelompok.",
          type: "success",
          timer: 1500
        });

      },
      error: function(){
        swal("Error","Maaf Data Kelompok tidak terupdate.", "error");
      }
    });
  }

  function save_prosedur(id_tindakan, prosedur) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('inacbg/master/save_prosedur')?>",
      data: {
        idtindakan: id_tindakan,
        prosedur: prosedur
      },
      success: function(data){ 
        swal({
          title: "Success",
          text: "Prosedur berhasil disimpan.",
          type: "success",
          timer: 1500
        });
      },
      error: function(){
        swal("Error","Maaf prosedur tidak terupdate.", "error");
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
  <div class="row">
    <div class="col-sm-12">
      <div class="card card-outline-info">
        <!-- <div class="card-header">
          <h3 class="card-title text-white">DAFTAR TINDAKAN</h3>
        </div> -->
        <div class="card-block ">
          <table id="table_tindakan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Kelompok INACBG</th>
                <!-- <th>Prosedur</th> -->
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Kelompok INACBG</th>
                <!-- <th>Prosedur</th> -->
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $j=1;
                  foreach($tindakan as $row){
              ?>
              <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <?php
                  echo "
                  <td>
                    <select onchange='edit_kel(this.value, \"".$row->idtindakan."\")' class='form-control select2' style='width: 100%' name='idkel_".$row->idtindakan."' id='idkel_".$row->idtindakan."'> 
                      <option value='0' selected>-- Pilih Kelompok INACBG --</option>";
                    foreach($kel_inacbg as $row1){
                      if($row->idkel_inacbg==$row1->idkel_inacbg)
                        $selected = 'selected';
                      else
                        $selected = '';
                      echo '<option value="'.$row1->idkel_inacbg.'" '.$selected.'>'.$row1->nama_kel.'</option>';
                    }
                    echo '</select></td>';
                ?>
               <!--  <td>
                  <?php
                    echo "
                      <select class='form-control icd9_select2' data-idtindakan='$row->idtindakan' style='width: 100%'>";

                        if($row->prosedur != '' && $row->prosedur != NULL) {
                          $prosedure = explode("@", $row->prosedur);
                          $id_prosedure = $prosedure[0]; 
                          $nm_prosedure = $prosedure[1];  
                          echo '<option value="'.$id_prosedure.'" selected="selected">'.$id_prosedure.' - '.$nm_prosedure.'</option>';
                        }
                        echo '</select>';
                  ?>
                </td> -->
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
