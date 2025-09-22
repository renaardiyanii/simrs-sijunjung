<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<style type="text/css">
  .page-titles {
    display: none;
  }   
  /*.card {
      position: relative;
      padding: 0px;
      margin-bottom: 20px;
      height: 100%;
      border-radius: 3px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.15);
      border: 1px solid #d8d8d8;
      background-color: #fff;
  }*/

  .card:hover {
      box-shadow:0 0 0 1px rgba(0,0,0,0.13);   
      cursor: pointer;
  }
</style>
<script type="text/javascript">
  var table_pasien;

  $(document).ready(function() {     
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",      
      autoclose: true,
      todayHighlight: true     
    });  
    table_pasien = $('#table-pasien').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/get_pasien')?>",
        "type": "post"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 7 // column index 
      }
      // ,{ "width": "18%", "targets": 3 },{ "width": "10%", "targets": 2 },{ "width": "7%", "targets": 0 }
      ],
   
    });
      
  });
  // function save_menu() {
  //   $.ajax({
  //     type: "POST",
  //     url: "<?php echo base_url().'gizi/show_pasien'; ?>",
  //     dataType: "JSON",
  //     data: {'no_ipd' : no_ipd},
  //     success: function(data) {
  //       // alert(data);
  //     },
  //     error:function(event, textStatus, errorThrown) {    
  //         swal("Error","Gagal load data.", "error");     
  //         console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
  //     }
  //   });  
  // }
  // function menu_diet(no_ipd) {
  //   $.ajax({
  //     type: "POST",
  //     url: "<?php echo base_url().'gizi/show_pasien'; ?>",
  //     dataType: "JSON",
  //     data: {'no_ipd' : no_ipd},
  //     success: function(data) {
  //       $('#modal_menudiet').modal('show');
  //       $('#no_ipd').val(no_ipd);
  //       $('#nama').val(data.nama);
  //       $('#bed').val(data.bed);
  //       $('#no_cm').val(data.no_cm);
  //       $('#kelas').val(data.kelas_bpjs);
  //     },
  //     error:function(event, textStatus, errorThrown) {    
  //         swal("Error","Gagal load data.", "error");     
  //         console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
  //     }
  //   });  
  // }

  function cetak_permintaan() {  
    var tanggal_permintaan = $('#tanggal_permintaan').val();
    var ruangan = $('#select_ruangan').val();    
    if (ruangan === '') {
      swal("Ruangan Kosong.", "Silahkan Pilih Ruangan Terlebih Dahulu.", "warning");
    } else {
      swal({
        title: "Cetak Permintaan Diet",
        text: "Cetak Permintaan Diet Ruangan " + ruangan + " ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (Cetak)",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: false,
        }, function() {                            
          window.open("<?php echo site_url('gizi/cetak_permintaan'); ?>/"+tanggal_permintaan+"/"+ruangan, "_blank");   
        }
      );
    }                
  } 
</script>
  <br>
  <div class="row">
      <?php foreach ($ruangan as $row) { ?>
        <div class="col-lg-3 col-md-12">
          <a href="<?php echo site_url('gizi/ruangan/'.strtolower(str_replace(' ', '', $row->lokasi))); ?>">
            <div class="card card-inverse card-info">
              <div class="card-body">
                <div class="d-flex">
                  <div class="m-r-20 align-self-center">
                      <h1 class="text-white"><i class="fa fa-building"></i></h1></div>
                  <div>
                  <h3 class="card-title"><?php echo $row->lokasi; ?></h3>
                  <!-- <h5 class="card-subtitle">130 Pasien</h5>  -->
                </div>
                </div>             
              </div>
            </div> 
          </a>         
        </div>  
      <?php } ?>                       
  </div>    

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>