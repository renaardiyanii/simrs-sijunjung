<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<style type="text/css">
  th { font-size: 14px; }
</style>
<script type="text/javascript">
  var table_pasien;

  $(document).ready(function() { 

    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true,
    }).on("changeDate", function (e) {
        table_pasien.ajax.reload();
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
        "url": "<?php echo site_url('irj/sjp/get_pasien')?>",
        "type": "POST",
        "data": function (data) {
          var tgl_kunjungan = $('#tgl_kunjungan').val();
          data.tgl_kunjungan = tgl_kunjungan;
        } 
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 7 // column index 
      }],
   
    });
      
  });

  function cetak_tracer(no_register){
    var getLink = $(this).attr('href');
      swal({
        title: "Cetak Tracer",
        text: "Cetak tracer dengan No Registrasi tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Cetak",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
           $.ajax({
                type: "POST",
                url: "<?php echo base_url().'irj/rjcregistrasi/print_tracer/'; ?>"+no_register,
                dataType: "JSON",
                data: $('#form_add').serialize(),
                success: function(data){        
                  if (data == '') {
                       swal("Success","Proses Cetak Berhasil.", "success"); 
                  } else {

                  }
                },
                error:function(event, textStatus, errorThrown) { 
                    swal("Error","Proses Cetak Gagal.", "error");                   
                    console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                },
                timeout: 0
            });
      });
  }   
  function cetak_tracer(no_register) {
      var windowUrl = '<?php echo base_url();?>irj/tracer/cetak/'+no_register;
      window.open(windowUrl,'p');
  }   

  //  function cetak_sjp(no_register) {
  //     var windowUrl = '<?php echo base_url();?>irj/Rjcsjp/cetak_sjp/'+no_register;
  //     window.open(windowUrl,'p');
  // }   

</script>

<div>
  <div>
   
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Cetak SJP Kunjungan Poli</h4></div>
            <div class="card-block">     
                <form class="form-horizontal">
                  <div class="form-group row">
                    <label for="tgl_kunjungan" class="col-md-2 col-form-label">Tanggal :</label>
                    <div class="col-md-4">
                      <!-- /.input group -->
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                             <input type="text" id="tgl_kunjungan" class="form-control date_picker" value="<?php echo date('Y-m-d'); ?>" name="tgl_kunjungan">
                          </div>
                          <!-- /.input group -->
                    </div>
                  </div>
                </form>                             
              <div class="table-responsive m-t-0">      
             <table id="table-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>No. Register</th>
                  <th>No. RM</th>
                  <th>Nama</th>
                  <th>Poli Kunjungan</th>
                  <th>Tgl Kunjungan</th>
                  <th>Status Cetak</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->     
    
  </div>
</div>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>