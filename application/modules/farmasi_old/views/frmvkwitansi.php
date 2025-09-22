<?php
	$this->load->view('layout/header_left.php');
?>

<script type='text/javascript'>
	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true
		// });  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );
	//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

</script>

<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>DAFTAR KWITANSI</h3>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-4">
                        <?php echo form_open('farmasi/Frmckwitansi/kwitansi_by_date');?>
                        <div class="form-group row">
							<div style="width: 80%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
                        <?php echo form_close();?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_open('farmasi/Frmckwitansi/kwitansi_by_no');?>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="key" placeholder="No. Register" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <?php echo form_close();?>
                    </div>
                </div>
                <br/>
                <table id="example" class="display table table-hover table-bordered table-striped" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>No</th>
                        <!-- <th>No Resep</th> -->
                        <th>Tanggal Kunjungan</th>
                        <th>No Registrasi</th>
                        <th>No Medrec</th>
                        <th>Nama</th>
                        <th>Asal</th>
                        
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    // print_r($pasien_daftar);
                    $i=1;
                    foreach($daftar_farmasi as $row){
                        //$no_resep=$row->no_resep;
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('farmasi/Frmckwitansi/kwitansi_pasien_rj/'.$row->no_register); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
                            </td>
                            <td><?php echo $i++;?></td>
                            <!-- <td><?php //echo $row->no_resep; ?></td> -->
                            <td><?php echo $row->tgl_kunjungan; ?></td>
                            <td><?php echo $row->no_register;?></td>
                            <td><?php echo $row->no_cm;?></td>
                            <td><?php echo $row->nama;?></td>
                            <td><?php echo $row->nm_poli;?></td>
                            
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
	$this->load->view('layout/footer_left.php');
?>