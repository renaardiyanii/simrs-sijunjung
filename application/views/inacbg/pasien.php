<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<style type="text/css">
  .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
      border: 1px solid #dad55e;
      background: #fffa90;
      color: #777620;
      font-weight: normal;
  }
  .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-state-active.ui-button:hover 
  {
    border: 1px solid #eee;
    background: #eee;
    color: #000;
  }
  .ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
  .ui-widget-content {    
      font-size: 13.68px;
  }
  .ui-widget-content .ui-state-active {    
      font-size: 13.68px;
  }
  .ui-autocomplete-loading {
      background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
  }
  .page-titles {
    display: none;
  }
  .dataTables_info {
    display: none; 
  }
  .sidebar-nav > ul > li > a.active {
      font-weight: 400;
      background: #ffffff;
      color: #546e7b;
  }
  .sidebar-nav > ul > li > a.active:hover i{   
      /*background-color: #fff;*/
      color: #fff;  
  }
  .sidebar-nav > ul > li > a.active i {
      color: #546e7b;
  }
  th { font-size: 14px; }
  #table-pelayanan tbody tr {
    cursor: pointer;
  }
</style>
<script type="text/javascript">
  var table_klaim;
  var site_url = "<?php echo site_url(); ?>";
  $(document).ready(function() {
    $('#separate_rm').hide();
    $('#separate_nama').hide();
    $('#separate_gender').hide();
    $('#show-pasien').hide();    
    table_klaim = $('#table-pelayanan').DataTable({       
      "processing": true,
      "serverSide": true,
      "searching": false,
      "filter": false,
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('inacbg/pasien/get_pelayanan')?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": function (data) {
          data.no_cm = $('#no_cm').val();
        }
      },     
      "columnDefs": [{ 
        "orderable": false,
        "width": "5%",
        "targets": 0
      }],
    });
    $('#table-pelayanan tbody').on('click', 'tr', function () {
        var data = table_klaim.row( this ).data();     
        window.location = site_url+'inacbg/pasien/pelayanan/'+data[1];
    });
  });   
    
  $(function(){   
    $("#cari_pasien").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
            url: site_url+'inacbg/pasien/get_autocomplete',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
              if(!data.length){
                var result = [{
                 label: 'Data tidak ditemukan'
                }];
                $.ui.autocomplete.prototype._renderItem = function (ul, item) {                          
                return $("<li></li>")
                     .data("item.autocomplete", item)
                     .append("<a style='display:inline-block;width: 100%;'><span style='font-weight:bold;'>" + item.label + "</span></a>")
                     .appendTo(ul);
                };
                response(result);
              } else {
                $.ui.autocomplete.prototype._renderItem = function (ul, item) {        
                  var no_cm = String(item.no_cm).replace(
                          new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                          "<span class='ui-state-highlight'>$&</span>");
                  var nama = String(item.nama).replace(
                      new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>");
                  var tgl_lahir = String(item.tgl_lahir).replace(
                      new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>");
                  var no_kartu = String(item.no_kartu).replace(
                      new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                      "<span class='ui-state-highlight'>$&</span>");
                 return $("<li></li>")
                     .data("item.autocomplete", item)
                     .append("<a style='display:inline-block;width: 100%;'><span class='pull-right' style='font-weight:bold;'>" + no_cm + "</span><span style='font-weight:bold;'>" + nama + "</span></br><span>No. KARTU : " + no_kartu + "</span></br><span>TGL LAHIR : " + tgl_lahir + "</a>")
                     .appendTo(ul);
                };
                response(data);                  
              }                  
            }
          });
      },      
      minLength: 1,     
      select: function (event, ui) {
          if (ui.item == null) {
            $('#show-pasien').hide();
          } else $('#show-pasien').show();
          if (ui.item.no_cm != '' && ui.item.nama != '') {
            $('#separate_rm').show();
          }
          if (ui.item.nama != '' && ui.item.gender != '') {
            $('#separate_nama').show();
          }
          if (ui.item.gender != '' && ui.item.tgl_lahir != '') {
            $('#separate_gender').show();
          }
          $('#no_cm').val(ui.item.no_cm);
          $('#no_rm').html(ui.item.no_cm);
          $('#nama_pasien').html(ui.item.nama);
          $('#tgl_lahir').html(ui.item.tgl_lahir);
          $('#gender').html(ui.item.gender);
          table_klaim.ajax.reload();
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    }); 
    
    $('#btn-cari').click(function() {            
      $("#cari_pasien").autocomplete("search", $("#cari_pasien").val());
    });
  });
</script>
<?php if($this->session->flashdata('alert_new_claim')) { ?>
<script type="text/javascript">
  swal("Gagal Klaim", "<?php echo $this->session->flashdata('alert_new_claim'); ?>", "error");
</script>
<?php } ?>
<br>
<?php echo $this->session->flashdata('notification');?>
<div class="row">
    <div class="col-lg-12 col-md-12">        
      <div class="card card-outline-info">
          <div class="card-block">                                                                                   
                <div class="form-group row mb-0">                                     
                  <label class="col-sm-3 control-label col-form-label">No. RM / No. SEP / Nama / NIK</label>                  
                  <div class="col-sm-4">
                    <input type="hidden" class="form-control" name="no_cm" id="no_cm">                    
                    <input type="text" class="form-control" name="cari_pasien" id="cari_pasien" style="max-width: 400px;">
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-primary" id="btn-cari" style="margin-right: 5px;"><i class="fa fa-search"></i> Cari Pasien </button> 
                  </div> 
                </div>                                                                                                                 
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-12 col-md-12">
      <div class="card card-outline-danger" id="show-pasien">
        <div class="card-header">
            <div class="card-actions">               
                <a class="btn-close text-white" data-action="close"><i class="ti-close"></i></a>
            </div>
            <h4 class="m-b-0 text-white"><span id="no_rm"></span> <span style="color:#fff;" id="separate_rm">••</span> <span id="nama_pasien"></span> <span style="color:#fff;" id="separate_nama">••</span> <span id="gender"></span> <span style="color:#fff;" id="separate_gender">••</span> <span id="tgl_lahir"></span> </h4>
        </div>
        <div class="card-body b-t p-b-20">
          <br>
          <div class="col-md-12">
            <table id="table-pelayanan" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr> 
                  <th>No.</th>     
                  <th>No. Registrasi</th>             
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Pulang</th>
                  <th>No. SEP</th>
                  <th class="text-center">Jaminan</th>
                  <th class="text-center">Tipe</th>
                  <th class="text-center">CBG</th>
                  <th class="text-center">Status</th>                                   
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>            
        </div>
      </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->     


<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>