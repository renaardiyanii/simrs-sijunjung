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
        "url": "<?php echo site_url('gizi/get_pasien')?>",
        "type": "POST",
        "data": function (data) {
          data.ruangan = "<?php echo $ruangan; ?>";
          data.tanggal = $('#tanggal_permintaan').val();
        } 
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
    $('#tanggal_permintaan').datepicker({
      format: "yyyy-mm-dd",      
      autoclose: true,
      todayHighlight: true
    }).on("change", function (e) {
      table_pasien.ajax.reload();
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

  function cetak_label() {   
    swal({
      title: "Cetak Label",
      text: "Cetak Label Ruangan " + ruangan + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya (Cetak)",
      showCancelButton: true,
      closeOnConfirm: true,
      showLoaderOnConfirm: false,
      }, function() {                            
        window.open("<?php echo site_url('gizi/cetak_label'); ?>/"+ruangan, "_blank");   
      }
    );
  }

  // $(':checkbox').on('change', function() {
  //   $(this).closest('tr').find(':checkbox').prop('checked', this.checked);
  // });
</script>
  <br>
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white">Lokasi : <?php echo ucfirst($ruangan); ?></h4>
        </div>
        <div class="card-block">               
          <div class="form-group row m-b-0">
            <!-- <label for="example-text-input" class="col-md-1 col-form-label" style="max-width: 250px;">Tanggal : </label>
            <div class="col-md-3">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control date_picker" name="tanggal_permintaan" id="tanggal_permintaan" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>   -->                                        
            <div class="col-md-12">
              <button type="button" class="btn btn-danger" onclick="cetak_permintaan()"><i class="fa fa-print"></i> Cetak Permintaan Diet</button>
              <button class="btn btn-warning" onclick="cetak_label()"><i class="fa fa-print"></i> Cetak Label Makanan</button>
            </div>
          </div>                
          <hr>                           
          <div class="table-responsive m-t-0">      
            <table id="table-pasien" class="display nowrap table table-hover" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Aksi</th>
                <th class="text-center">Ruang</th>
                <th class="text-center">Tgl. Masuk</th>
                <th class="text-center">No. RM</th>
                <th class="text-center">No. Register</th>
                <th>Nama</th>
                <th class="text-center">Kamar</th>
                <th class="text-center">Bed</th>
                <th class="text-center">Cara Bayar</th>
                <!-- <th class="text-center">Ceklis Ahli Gizi</th> -->
                
              </tr>
              </thead>
              <tbody class="checkable">                
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