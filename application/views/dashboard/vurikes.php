<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
    <style type="text/css">
        tbody > tr > td {
            border: 2px solid #000;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }
    </style>
<!-- Main content -->
<section class="content">
  <!-- <header class="floating-header"> 
    <div class="floating-menu-btn">
      <div class="floating-menu-toggle-wrap">
        <div class="floating-menu-toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </div>
    </div>
    <div class="main-navigation-wrap">
      <nav class="main-navigation" data-back-btn-text="Back">
        <ul class="menu">       
          <li class="delay-1"><a href="<?php echo site_url('dashboard'); ?>">Menu Utama</a></li>
          <li class="delay-1"><a href="<?php echo site_url('Change_password'); ?>">Ganti Password</a></li>
          <li class="delay-2"><a href="<?php echo site_url('logout'); ?>">Logout</a></li>      
        </ul>
      </nav>
    </div>
  </header> -->
  <!-- Main row -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="col-md-12">
            <div class="d-flex flex-wrap">                
                <h4 class="card-title"><br><b>URIKES</b></h4>
                <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6>           
                <div class="ml-auto">
                  <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                </div> -->   
            </div>
          </div>
          <div class="col-md-12">
              <div class="form-inline">
              <form id="formEx">
                <div class="form-group"> 
                  <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal"  required>&nbsp;
                  <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir"  required>&nbsp;
                  <!-- <label class="col-sm-1 control-label col-form-label">Kesatuan</label> -->
                  <div class="col-sm-3">
                    <select name="kesatuan" id="kesatuan" class="form-control" style="width: 100%" >
                      <option value="">- Pilih Kesatuan -</option>
                      <?php                     
                        foreach ($kesatuan as $item) {    
                          if ($item->kst2_id == '' && $item->kst3_id == '') {
                            echo '<option value="'.$item->kst_id . '">'.$item->kst_nama.'</option>';
                          } else if ($item->kst3_id == '') {
                            echo '<option value="'.$item->kst_id . '-' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
                          } else {
                            echo '<option value="'.$item->kst_id . '-' .$item->kst2_id . '-' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
                          }                         
                        }
                      ?>                            
                    </select>
                  </div>
                <!-- <label class="col-sm-2 control-label col-form-label" id="kes">Keterangan Urikes</label> -->
                <div class="col-sm-3">
                  <select name="ket_urikes" id="ket_urikes" class="js-states form-control" style="width: 100%" required>
                  <option value="">-Pilih Keterangan-</option>
                  <?php 
                  foreach($ket_urikes as $row){ 
                    echo '<option value="'.$row->ket_urikes.'">'.$row->nama_ket_urikes.'</option>';
                  }
                  ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <select name="diagnosa" id="diagnosa" class="js-states form-control" style="width: 100%" >
                  <option value="">-Pilih Diagnosa-</option>
                  <?php 
                  foreach($diagnosa as $row){ 
                    echo '<option value="'.$row->diagnosa.'">'.$row->nm_diagnosa.'</option>';
                  }
                  ?>
                  </select>
                </div>
                  <!-- <button class="btn btn-primary btn-xs get_dataurikes type="submit"><i class="fa fa-search"></i> Cari</button> -->
                  <button class="btn btn-primary btn-xs" type="button" id="btnCari"><i class="fa fa-search"></i> Cari</button>
                </div>
              </form>
              </div>
            </div>
          <div class="col-md-12">
            <!-- <h4 class="card-title"><center>Ruangan Rawat Inap</center></h4>
            <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->

            <div class="table-responsive">
             <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                                <thead style="border: 2px solid black; font-weight: bold;">
                                <tr style="border: 2px solid black;">
                                    <td style="border: 2px solid black; vertical-align: middle;" width="2%"><center>No</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="5%"><center><b>TGL PERIKSA</b></center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="15%"><center>NAMA PASIEN</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="5%"><center>UMUR</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="7%"><center>NRP/NIP</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="10%"><center>PANGKAT</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="10%"><center>KESATUAN</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>U</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>A</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>B</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>D</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>L</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>G</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;" width="4%"><center>J</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>STATKES</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Catatan</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Aksi</center></td>
                                </tr>
                                </thead>
                            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  $(document).ready(function() {
    $('#date_picker_awal').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 
    $('#date_picker_akhir').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 

    var objTable;

        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>",
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "nama" },
                { data: "umur" },
                { data: "nip" },
                { data: "pangkat" },
                { data: "kesatuan" },
                { data: "sf_umum" },
                { data: "sf_atas" },
                { data: "sf_bawah" },
                { data: "sf_dengar" },
                { data: "sf_lihat" },
                { data: "sf_gigi" },
                { data: "sf_jiwa" },
                { data: "statkes" },
                { data: "catatan" },
                { data: "aksi" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );

        $("#btnCari").click(function () {
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: $('#formEx').serialize(),
                url: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });

   //  $('#btnCari').click(function(){
   //  refreshList();
   // });

   //  var table;
   //  table = $('#example').DataTable({
   //    ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>",
   //    columns: [
   //      { data: "no" },
   //      { data: "tgl_kunjungan" },
   //      { data: "nama" },
   //      { data: "umur" },
   //      { data: "nip" },
   //      { data: "pangkat" },
   //      { data: "kesatuan" },
   //      { data: "sf_umum" },
   //      { data: "sf_atas" },
   //      { data: "sf_bawah" },
   //      { data: "sf_dengar" },
   //      { data: "sf_lihat" },
   //      { data: "sf_gigi" },
   //      { data: "sf_jiwa" },
   //      { data: "statkes" },
   //      { data: "catatan" },
   //      { data: "aksi" }
   //    ],
   //    columnDefs: [
   //      { targets: [ 0 ], visible: false }
   //    ],
   //    // searching: true,
   //    paging: true,
   //    bDestroy : true,
   //    bSort : false,
   //    "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
   //  });

   // function refreshList(){
   //  $.ajax({
   //      url: '<?php echo site_url(); ?>dashboard/data_pasien_urikes',
   //      type: 'POST',
   //      data: $('#formEx').serialize(),
   //      dataType: "json",
   //      success: function (response) {
   //        //alert(JSON.stringify(response.data));
   //        table.clear().draw();
   //        table.rows.add(response.data);
   //        table.columns.adjust().draw(); 
   //      }
   //  });
   // }

  });

   // $(function() {
   //  var date1=document.getElementById("date_picker_akhir").value;
   //  var date2=document.getElementById("date_picker_awal").value;
   //      objTable = $('#example').DataTable( {
   //          ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>/"+date1+"/"+date2+"/",
   //          data: {
   //            "date1" : date1,
   //            "date2" : date2
   //              },
   //          columns: [
   //              { data: "no" },
   //              { data: "tgl_kunjungan" },
   //              { data: "nama" },
   //              { data: "umur" },
   //              { data: "nip" },
   //              { data: "pangkat" },
   //              { data: "kesatuan" },
   //              { data: "sf_umum" },
   //              { data: "sf_atas" },
   //              { data: "sf_bawah" },
   //              { data: "sf_dengar" },
   //              { data: "sf_lihat" },
   //              { data: "sf_gigi" },
   //              { data: "sf_jiwa" },
   //              { data: "statkes" },
   //              { data: "catatan" },
   //              { data: "aksi" }
   //          ],
   //          columnDefs: [
   //              { targets: [ 0 ], visible: true }
   //          ] ,
   //          searching: true,
   //          paging: true,
   //          bDestroy : true,
   //          bSort : false,
   //          "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
   //      } );
   //  });

   

// $(document).on("click",".get_dataurikes",function() {
//     var date1=document.getElementById("date_picker_akhir").value;
//     var date2=document.getElementById("date_picker_awal").value;
//     var kesatuan=document.getElementById("kesatuan").value;;
//     var ket_urikes=document.getElementById("ket_urikes").value;;
//         objTable = $('#example').DataTable( {
//             ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>/"+date1+"/"+date2+"/"+ket_urikes+"/"+kesatuan+"/",
//             data: {
//               "date1" : date1,
//               "date2" : date2,
//               "ket_urikes" : ket_urikes,
//               "kesatuan" : kesatuan
//                 },
//             columns: [
//                 { data: "no" },
//                 { data: "tgl_kunjungan" },
//                 { data: "nama" },
//                 { data: "umur" },
//                 { data: "nip" },
//                 { data: "pangkat" },
//                 { data: "kesatuan" },
//                 { data: "sf_umum" },
//                 { data: "sf_atas" },
//                 { data: "sf_bawah" },
//                 { data: "sf_dengar" },
//                 { data: "sf_lihat" },
//                 { data: "sf_gigi" },
//                 { data: "sf_jiwa" },
//                 { data: "statkes" },
//                 { data: "catatan" },
//                 { data: "aksi" }
//             ],
//             columnDefs: [
//                 { targets: [ 0 ], visible: true }
//             ] ,
//             searching: true,
//             paging: true,
//             bDestroy : true,
//             bSort : false,
//             "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
//         } );
//     });


</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>