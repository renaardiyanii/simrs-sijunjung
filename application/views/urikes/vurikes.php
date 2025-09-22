<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
		
?>
 <link rel="stylesheet" href="<?php echo site_url('assets/plugins/dropify/dist/css/dropify.min.css'); ?>">
<style type="text/css">
  th { font-size: 14px; }
    #table-urikes tbody tr {
      cursor: pointer;
    }
</style>
<script type="text/javascript">
  var table_urikes;

  $(document).ready(function() {

    table_urikes = $('#table-urikes').DataTable({       
      "processing": true,
      "serverSide": true,
      "searching": true,
      "filter": false,
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('urikes/curikes/pasien_urikes')?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": function(data) { // function untuk pasrsing data yang dilempar ke view  dalam bentuk post
          data.roleid = '<?php echo $roleid; ?>';
        }
      },     
      "columnDefs": [{ 
        "orderable": false,
        "width": "5%",
        "targets": 0
      }],
    });
 

      
  });   

</script>
<?php if($this->session->flashdata('alert_new_claim')) { ?>

<script type="text/javascript">
  swal("Gagal Klaim", "<?php echo $this->session->flashdata('alert_new_claim'); ?>", "error");
</script>
<?php } ?>
<div>
  <div>
<div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Daftar Pasien URIKES</h4></div>
        <div class="card-block">                    
          <div class="table-responsive m-t-0">    
            <table id="table-urikes" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID Urikes</th>
                    <th>No. Kode</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Kepentingan</th>
                    <th>Statkes</th>
                    <th><center>Aksi</center></th>
                    <!-- <th class="text-center">Aksi</th> -->
                  </tr>
                </thead>
                  <?php 	$url=site_url('urikes/Curikes/regpasien_urikes'); 
                          $url2=site_url('urikes/Curikes/regpasien_skd'); ?>
                     <!--  <div class="col-md-5" style=' float:right; text-align:right;'>
                          <div class="form-actions">
                          	
                          	<button type="button" onclick="javascript:window.location.href='<?php echo $url ?>'; return false;" class="btn waves-effect waves-light btn-danger"><i class="fa fa-user-plus" ></i> Tambah Pasien Baru</button>
                            <button type="button" onclick="javascript:window.location.href='<?php echo $url2 ?>'; return false;" class="btn waves-effect waves-light btn-submit"><i class="fa fa-user-plus" ></i> Tambah Pasien untuk SKD</button> -->
                          </div>
                      </div> 
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