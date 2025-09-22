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
</style>
<script type="text/javascript">
  var table_pasien;
  var url_table;
  var ruangan = '<?php echo $ruangan; ?>'; 

  $(document).ready(function() {       
    table_pasien = $('#table-pasien').DataTable({ 
      "processing": true,
      "serverSide": true,
      "language": {
        "emptyTable": "Data tidak tersedia."
      },
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/get_pasien_ugd')?>",
        "type": "POST"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 6 // column index 
      },{ 
        "width": "8%",
        "targets": 0 // column index 
      }]
    });
  });

  function cetak_permintaan() {   
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
        window.open("<?php echo site_url('gizi/cetak_permintaan'); ?>/"+ruangan, "_blank");   
      }
    );
  } 
</script>
  <br>
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white">Ruangan : UGD</h4>
        </div>
        <div class="card-block">               
          <!-- <div class="form-group row m-b-0">                                  
            <div class="col-md-12">
              <button type="button" class="btn btn-danger" onclick="cetak_permintaan()"><i class="fa fa-print"></i> Cetak Permintaan Diet</button>
              <button class="btn btn-warning"><i class="fa fa-print"></i> Cetak Label Makanan</button>
            </div>
          </div>                
          <hr>  -->                          
          <div class="table-responsive m-t-0">      
            <table id="table-pasien" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">No. Register</th>
                <th class="text-center">Tgl. Masuk</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">No. Register</th>
                <th>Nama</th>
                <th class="text-center">Cara Bayar</th>
                <th class="text-center">Aksi</th>
              </tr>
              </thead>
              <tbody>                
              </tbody>
            </table>
          </div>
        </div> <!-- /.card-block -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->     

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>