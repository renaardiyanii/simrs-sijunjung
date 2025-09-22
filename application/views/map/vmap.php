<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<style type="text/css">
  th { font-size: 16px; color : darkgreen; }
  td {
      font-size: 16px;
      color : black;
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 63px;
    height: 34px;
  }

  .switch input {display:none;}

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: green;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:disabled + .slider {
    background-color: gray;
  }

  input:checked + .slider {
    background-color: red;
  }

   input:checked1 + .slider {
    background-color: yellow;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

   input:checked1 + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 70px;
  }

  .slider.round:before {
    border-radius: 100px;
  }
</style>
<script type="text/javascript">
  var table_pasien;

  $(document).ready(function() { 
    $("#form_catatan").submit(function(event) {
      document.getElementById("submit_catatan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'map/mapfile/save_catatan'; ?>",
        dataType: "JSON",
        data: $('#form_catatan').serialize(),
        success: function(data){        
          if (data == true) {
            document.getElementById("submit_catatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';                        
            $('#modal_catatan').modal('hide');
            table_pasien.ajax.reload();
            swal("Sukses", "Data berhasil disimpan.", "success");
          } else {
            document.getElementById("submit_catatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            $('#modal_catatan').modal('hide');
            swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
          }          
        },
        error:function(event, textStatus, errorThrown) { 
          document.getElementById("submit_catatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          $('#modal_catatan').modal('hide');
          swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
      event.preventDefault();
    });

    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true,
    }).on("changeDate", function (e) {
        table_pasien.ajax.reload();
    });

    setTimeout(function(){
      table_pasien.ajax.reload();
    }, 9000);

    /*table_pasien = $('#table-pasien').DataTable({       
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('map/mapfile/get_pasien')?>",
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
   
    });*/
    // table_pasien = $('#table-pasien').DataTable({ 
    //   "language": {
    //   "emptyTable": "Data tidak ada."
    //   },
    //   "processing": true,
    //   "serverSide": true,
    //   "bDeferRender": true,
    //   "searching": false,
    //   "order": [],
    //   "lengthMenu": [
    //   [ 10, 25, 50, -1 ],
    //   [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    //   ],
    //   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
    //   "ajax": {
    //   "url": "<?php echo site_url('map/mapfile/get_pasien_irj')?>",
    //   "type": "POST",
    //   "dataType": 'JSON',
    //   "data": function (data) {
    //     data.tgl_kunjungan = $('#tgl_kunjungan').val();
    //   }        
    //   },
    //   "columnDefs": [
    //   { 
    //   "orderable": false, //set not orderable
    //   "targets": [0] // column index 
    //   }
    //   ],
    // }); 

    table_pasien = $('#table-pasien').DataTable({
    ajax: {
        url: "<?php echo site_url('map/mapfile/get_listpasien')?>",
        type: "POST",
        data : function (data) {
          var tgl_kunjungan = $('#tgl_kunjungan').val();
          data.tgl_kunjungan = tgl_kunjungan;
        }
    },
    columns: [
   
      { data: "idmap_pasien" },
      { data: "no" },
      { data: "no_register" },
      { data: "no_cm" },
      { data: "nama" },
      { data: "nm_poli" },
      { data: "tgl_kunjungan" },
      { data: "xcreate" },
      { data: "timeout" },
      { data: "timein" },
      { data: "status" },
      { data: "catatan" },
      { data: "aksi" }
    ],
    columnDefs: [
      { targets: [ 0 ], visible: false }
    ],
    bFilter: true,
    bPaginate: true,
    destroy: true,
    aaSorting:  [[ 1, "desc" ]]
  });
      
  });

  function excel_mappasien(){
      var tgl_kunjungan = $('#tgl_kunjungan').val();
      swal({
          title: "Download?",
          text: "Download Log Status Map Pasien !",
          type: "warning",
          showCancelButton: true,
            showLoaderOnConfirm: false,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya!",
          cancelButtonText: "Tidak!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {         
            swal("Download", "Sukses", "success");
            window.open("<?php echo base_url('map/mapfile/excel_mappasien')?>/"+tgl_kunjungan);
          } else {
            swal("Close", "Tidak Jadi", "error");          
          }
        });      
  }

  function saveTimeIn(noreg,Status,no_mr){    
      if(Status==''){
        url="<?php echo base_url().'map/mapfile/mapkeluar/'; ?>";
      }else{
        url="<?php echo base_url().'map/mapfile/mapkembali/'; ?>";
      }

      $.ajax({
        type: "POST",
        url: url,
        dataType: "JSON",
        data: {no_register:noreg, exist:Status, no_medrec: no_mr},
        success: function(data){        
          if (data == true) {
            console.log(data);
            table_pasien.ajax.reload();
            //swal("Success","Simpan waktu map Berhasil.", "success"); 
          } else {
            //swal("Error","Simpan Waktu Gagal.", "error");
          }
        },
        error:function(event, textStatus, errorThrown) { 
          swal("Terdapat Kesalahan","Simpan Waktu Gagal.", "error");                   
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
      });
  }

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
  function cetak_tracer(no_register,jns_kunjungan) {
      var windowUrl = '<?php echo base_url();?>irj/tracer/cetak/'+no_register+'/'+jns_kunjungan;
      window.open(windowUrl,'p');
  }   

  function catatan_map(no_register) {
    $('#modal_catatan').modal('show');
    $('#no_register').val(no_register);    
  }

</script>

<div>
  <div>
   
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-header">
              <h4 class="m-b-0 text-white">STATUS MAP PASIEN RAWAT JALAN & RAWAT INAP</h4></div>
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
                  <th>No.</th>
                  <th>No. Register</th>
                  <th>No. RM</th>
                  <th>Nama</th>
                  <th>Ruangan</th>
                  <th>Tgl Kunjungan</th>
                  <th>Petugas</th>
                  <th>Waktu Keluar</th>
                  <th>Waktu Kembali</th>                  
                  <th>Status Map</th>
                  <th>Catatan</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            <!-- <table id="table-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>                  
                  <th>No. Register</th>
                  <th>No. RM</th>
                  <th>Nama</th>
                  <th>Ruangan</th>
                  <th>Tgl Kunjungan</th>
                  <th>Petugas</th>
                  <th>Waktu Keluar</th>
                  <th>Waktu Kembali</th>                  
                  <th>Status Map</th>
                  <th>Catatan</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>                
                </tbody>
              </table> -->
              </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-default delete-sep" onclick="excel_mappasien()" style="margin-bottom:5px;"><i class="fa fa-print"></i> EXCEL</button>
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
<div class="modal fade" id="modal_catatan" role="dialog" aria-labelledby="modal_catatan">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Catatan Map Pasien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form id="form_catatan">
            <div class="modal-body">        
          <div class="box-body">                  
              <input type="hidden" class="form-control" name="no_register" id="no_register">              
              <div class="form-group">
                <label for="catatan" class="control-label">Catatan</label><br>
                <textarea rows="7" class="form-control" name="catatan" id="catatan"></textarea>
              </div> 
          </div>                                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit_catatan"><i class="fa fa-floppy-o"></i> Simpan</button>
            </div>
          </form> 
        </div>
      </div>
  </div><!-- /.modal -->

      <div class="modal fade" id="modal_catatan1" role="dialog" aria-labelledby="modal_catatan1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Catatan Map Pasien IRI</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form id="form_catatan">
            <div class="modal-body">        
          <div class="box-body">                  
              <input type="hidden" class="form-control" name="no_register" id="no_register">              
              <div class="form-group">
                <label for="catatan" class="control-label">Catatan</label><br>
                <textarea rows="7" class="form-control" name="catatan" id="catatan"></textarea>
              </div> 
          </div>                                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit_catatan1"><i class="fa fa-floppy-o"></i> Simpan</button>
            </div>
          </form> 
        </div>
      </div>
  </div><!-- /.modal2 -->
<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>