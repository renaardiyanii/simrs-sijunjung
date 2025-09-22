<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<style type="text/css" >
td {
            color : black;
        }  

th {
            color : darkgreen;
        }
</style>
<script type="text/javascript">
  var table_pasien;

  $(document).ready(function() { 

    $('#search_per').val('all').change();

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

    $('.auto_search_by_nocm').autocomplete({
    serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
    onSelect: function (suggestion) {
      $('#cari_no_cm').val(''+suggestion.no_cm);
      $('#no_medrec_baru').val(''+suggestion.no_medrec);
    }
  });

    table_pasien = $('#table-pasien').DataTable({
    ajax: {
        url: "<?php echo site_url('map/mapfile/get_logpasien')?>",
        type: "POST",
        data : function (data) {
          var tgl_kunjungan = $('#tgl_kunjungan').val();
          var param = $('#search_per').val();
          if($('#no_medrec_baru').val()!=''){
            var nocm = $('#no_medrec_baru').val();
          }else{
            var nocm = $('#cari_no_cm').val();
          }          
          data.tgl_kunjungan = tgl_kunjungan;
          data.param = param;
          data.nocm = nocm;
        }
    },
    columns: [
    /*<th>No. Register</th>
                  <th>No. RM</th>
                  <th>Nama</th>
                  <th>Ruangan</th>
                  <th>Tgl Kunjungan</th>
                  <th>Waktu Keluar</th>
                  <th>Waktu Kembali</th>
                  <th>Status Map</th>*/
      { data: "idmap_pasien" },
      { data: "no" },
      { data: "no_register" },
      { data: "no_cm" },
      { data: "nama" },
      { data: "nm_poli" },
      { data: "petugas" },
      { data: "timeout" },
      { data: "timein" },
      { data: "status" },
      { data: "catatan" }
    ],
    columnDefs: [
      { targets: [ 0 ], visible: false }
    ],
    bFilter: true,
    bPaginate: true,
    destroy: true,
    order:  [[ 6, "desc" ]]
  });
      
  });

  function excel_mappasien(){
      var param1 = $('#search_per').val();
      var param2 = $('#tgl_kunjungan').val();
      if($('#no_medrec_baru').val()!=''){
            var param3 = $('#no_medrec_baru').val();
          }else{
            var param3 = $('#cari_no_cm').val();
          }
      

      swal({
          title: "Download?",
          text: "Download History Status Map Pasien !",
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
            window.open("<?php echo base_url('map/mapfile/excel_maphistorylogpasien')?>/"+param1+"/"+param2+"/"+param3);
          } else {
            swal("Close", "Tidak Jadi", "error");
          }
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

function cek_search(val_search_per){
  //alert(val_search_per);
  if(val_search_per=='cm'){
    $("#cari_no_cm").css("display", ""); // To unhide
    $("#div_tgl").hide();
  }else if(val_search_per=='all'){
    $("#cari_no_cm").css("display", "none"); // To unhide
    $("#div_tgl").show();
  }

}

function reloadTabel(){
  //alert(val_search_per);
  table_pasien.ajax.reload();

}
</script>

<div>
  <div>
   
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-header">
              <h4 class="m-b-0 text-white">CARI HISTORY STATUS MAP PASIEN</h4></div>
            <div class="card-block">                       
                  <div class="col-md-7">
                        <div class="form-group row">
                            <label for="search_per" class="col-md-4 col-form-label">Jenis Pencarian :</label>
                            <div class="col-md-4">
                            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search(this.value)">
                              <option value="cm">No. RM</option>
                              <option value="all">Semua</option>                              
                            </select>
                          </div>
                            <!-- <small class="form-control-feedback"> This is inline help </small> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group has-danger">
                        <input type="search" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No RM" style="width:450;">
                        <input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >

                      </div>
                    </div>
                    <div class="col-md-7">
                    <div class="form-group row " id="div_tgl">
                      <label for="tgl_kunjungan" class="col-md-4 col-form-label">Tanggal :</label>
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
                </div>
                  <div class="col-md-5">
                        <div class="form-actions">
                          <button class="btn waves-effect waves-light btn-info" type="button" onclick="reloadTabel()">
                            <i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                         <hr>                   
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
                  <th>Petugas</th>
                  <th>Waktu Keluar</th>
                  <th>Waktu Kembali</th>
                  <th>Status Map</th>
                  <th>Catatan</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
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

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>