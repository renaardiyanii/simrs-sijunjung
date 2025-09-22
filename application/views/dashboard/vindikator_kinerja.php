<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 

<script src="<?php echo site_url(); ?>assets/plugins/highcharts/highcharts.js"></script>
<script src="<?php echo site_url(); ?>assets/plugins/highcharts/modules/exporting.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body chart-responsive">
          <div class="col-md-12">
            <div class="d-flex flex-wrap">                
              <div class="form-group">
                <h5 class="box-title m-t-30">INDIKATOR KINERJA</h5>
                <p class="text-muted m-b-20">Pilih Bulan</p>
                <div class="input-daterange input-group" id="date-range">
                    <input type="text" class="form-control" id="start" name="start" value="<?=date('Y-m');?>" onchange="cek_tahun()">
                    <span class="input-group-addon bg-info b-0 text-white">sampai</span>
                    <input type="text" class="form-control" id="end" name="end" value="<?=date('Y-m');?>" onchange="cek_tahun()">
                </div>
              </div>                
              <div class="ml-auto">
                <h4 class="vtot-heading" id="vtot" style="text-align: right"></h4>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <h6 class="card-title"><b>RS</b></h6>
            <div class="table-responsive">
              <table class="display table table-hover table-bordered dataTable" id="example3" style="font-size: 14px; border: 2px solid black;" >
                <thead style="border: 2px solid black; font-weight: bold;">
                    <tr style="border: 2px solid black;">
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TT</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BOR</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>LOS</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TOI</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BTO</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>NDR</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>GDR</center></td>
                    </tr>
                </thead>
              </table>              
            </div>
          </div>
          <div class="col-md-12">
            <h6 class="card-title"><b>Ruangan</b></h6>
            <div class="table-responsive">
              <table class="display table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                <thead style="border: 2px solid black; font-weight: bold;">
                    <tr style="border: 2px solid black;">
                      <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TT</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BOR</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>LOS</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TOI</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BTO</center></td>
                    </tr>
                </thead>
              </table>              
            </div>
          </div>
          <div class="col-md-12">
            <h6 class="card-title"><b>Kelas</b></h6>
            <div class="table-responsive">
              <table class="display nowrap table table-hover table-bordered dataTable" id="example2" style="font-size: 14px; border: 2px solid black;" >
                <thead style="border: 2px solid black; font-weight: bold;">
                  <tr style="border: 2px solid black;">
                      <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TT</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BOR</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>LOS</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>TOI</center></td>
                      <td style="border: 2px solid black; vertical-align: middle;"><center>BTO</center></td>
                  </tr>
                </thead>
              </table>              
            </div>
          </div>
        </div>        
      </div>
    </div>
  </div>
</section>

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";

  $(document).ready(function() {

    jQuery('#date-range').datepicker({
      format: "yyyy-mm",
      endDate: "current",
      autoclose: true,
      todayHighlight: true,
      viewMode: "months", 
      minViewMode: "months",
    });

    cek_tahun();

  });

  function cek_tahun() {
    var bln_thn=document.getElementById("start").value;
    var start=document.getElementById("start").value;
    var end=document.getElementById("start").value;
    // var tgl_awal=document.getElementById("date_picker_awal").value;
    if(bln_thn!=""){

      objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('dashboard/indikator_ruang'); ?>/"+start+"/"+end,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] },
          { data: [4] },
          { data: [5] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );

      objTable1 = $('#example2').DataTable( {
        ajax: "<?php echo site_url('dashboard/indikator_kelas'); ?>/"+start+"/"+end,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] },
          { data: [4] },
          { data: [5] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );

      objTable2 = $('#example3').DataTable( {
        ajax: "<?php echo site_url('dashboard/indikator_rs'); ?>/"+start+"/"+end,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] },
          { data: [4] },
          { data: [5] },
          { data: [6] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );
    } else {
      alert("Pilih Tanggal Dulu");
    }
  }
</script>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>