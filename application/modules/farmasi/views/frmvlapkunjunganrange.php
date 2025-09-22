<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	$('#tgl').daterangepicker({
      	opens: 'left',
		format: 'DD/MM/YYYY',
		startDate: moment('<?= $tgl_awal ?>'),
      	endDate: moment('<?= $tgl_akhir ?>'),
	});

    $('#example').DataTable();
   
	
	
});


</script>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}

@media print{
  .periode{
	  display: none;
  }
  .cara_bayar{
	  display: none;
  }
}

</style>

<!-- <section class="content-header"> -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
				<?php echo form_open('farmasi/Frmclaporan/data_kunjungan');?>
				<div class="row">
					<div class="col-md-3">
				        <div class="form-group">
				            Periode
				            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
				                <input type="text" class="form-control pull-right" id="tgl" name="tgl">
				            </div>
				        </div>
				    </div>

				    <div class="col-md-3">
				        <div class="form-group">
				            Cara Bayar
                        <select name="cara_bayar" id="filter" class="form-control">
                            <!-- <option value="" selected="">---- Pilih Semua ----</option> -->
                            <option value="UMUM" <?= $cara_bayar == "UMUM" ? 'selected' : ''?>>UMUM</option>
                            <option value="KERJASAMA" <?= $cara_bayar == "KERJASAMA" ? 'selected' : ''?>>KERJASAMA</option>
                            <option value="BPJS" <?= $cara_bayar == "BPJS" ? 'selected' : ''?>>BPJS</option>
							<!-- <option value="PASIEN LUAR" <?= $cara_bayar == "PASIEN LUAR" ? 'selected' : ''?>>BPJS</option> -->

                        </select>
				        </div>			
				    </div>
				    <div class="col-md-3">
				        <div class="form-group">
				            Depo PEngeluaran
                        <select name="instalasi" id="instalasi" class="form-control">
                        <!-- <option value="" selected="">---- Pilih Semua ----</option> -->
                            <?php
                          foreach($gudang as $row){
                            echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                          }
                        ?>
                        </select>
				        </div>			
				    </div>
					
					 <div class="form-group col-md-1">
                        <br>
                        <button class="btn btn-primary" type="submit">Lihat</button>
                    </div>
                    <div class="form-group col-md-1">
                        <br>
						<a href="<?= base_url("farmasi/frmclaporan/lap_penjualan_farmasi/$tgl_awal/$tgl_akhir/$cara_bayar/$instalasi") ?>" class='btn btn-primary'>Download</a>
                    </div>
				</div>			
				<?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<!-- </section> -->
              
<section class="content">
	<div class="row">
		<div class="panel panel-default" style="width:97%;margin:0 auto">
			<div class="panel-heading">			
				<h4 align="center"><?php echo $date_title; ?></h4>
			</div>
			<div class="panel-body">				
				<?php
	if(count($data_laporan_kunj)>0){
?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Pasien</th>
			<th>No Medrec</th>
			<th>No Register</th>
			<th>Nama</th>		
			<th>Dokter</th>		
			<th>Rincian Obat</th>								 
		</tr>
	</thead>
	<tbody>
		<?php	// print_r($pasien_daftar);
		$i=1;
		$vtot_banyak=0;
		$vtot=0;
		foreach($data_laporan_kunj as $row){
		$no_register=$row->no_register;
		$vtot_banyak=$vtot_banyak+$row->banyak;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->tgl_kunjungan;?></td>
			<td><?php echo $row->cara_bayar;?></td>
			<td><?php echo $row->no_cm;?></td>
			<td><?php echo $row->no_register;?></td>
			<td><?php echo $row->nama;?></td>
			<td><?php echo $row->nm_dokter;?></td>
			<td>
				<table width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Obat</th>
							<th>Banyak Obat</th>
							<th>Harga Total</th>									 
						</tr>
					</thead>
					<tbody>
				<?php
					$j=1;
					foreach($data_tindakan as $row2){
						if($no_register==$row2->no_register){
							echo "<tr><td>".$j."</td>";
							echo "<td>".$row2->nama_obat."</td>";
							echo "<td>".$row2->qty."</td>";
							echo "<td>Rp. ".$row2->vtot."</td></tr>";
							$j++;
							$vtot+=$row2->vtot;
						}
					}
					echo "<tr><td colspan='3' align='right' bgcolor='grey'>Total</td><td align='right' bgcolor='grey'>Rp. ".$row->vtot."</td></tr>";
				?>
					</tbody>
				</table>
			</td>

		</tr>
	<?php	} ?>
	</tbody>
</table>
<h4 align="center"><b>Total Kunjungan : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Obat : <?php echo $vtot_banyak;?><b></h4>
<h4 align="center"><b>Omset Obat : Rp. <?php echo $vtot;?><b></h4>
<hr>
<br>

<?php 
			
			//TUTUP IF 
	} else {
	echo $message_nodata;
} 
?>
					
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