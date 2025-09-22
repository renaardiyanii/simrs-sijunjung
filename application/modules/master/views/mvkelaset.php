<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>
  $(function() {
  
  });

</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content" style="width:97%;margin:0 auto">
  <div class="row">
		<div class="tab-content">			
			<div class="card card-outline-primary">
				<div class="card-block">
				  <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th>No</th>
						<th>Kode</th>
						<th>Kelompok Aset</th>
						<th>Aksi</th>
					  </tr>
					</thead>
					<tfoot>
					  <tr>
						<th>No</th>
						<th>Kode</th>
						<th>Kelompok Aset</th>
						<th>Aksi</th>
					  </tr>
					</tfoot>
					<tbody>
					  <?php
						  $i=1;
						  foreach($table as $row){
					  ?>
					  <tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $row->kd_skelbrg;?></td>
						<td><?php echo $row->ur_skel;?></td>
						<td>                  
							<center>
							<a href="<?php echo site_url("aset/delete_kel_aset/".$row->kd_skelbrg);?>" type="button" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
							</center>
						</td>
					  </tr>
					  <?php } ?>
					</tbody>
				  </table>
          
          <!-- View Modal -->
          
        </div>
      </div>
    </div>
</section>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>