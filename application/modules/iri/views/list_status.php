<?php
        // if ($role_id == 1) {
            $this->load->view("layout/header_left");
        // } else {
            // $this->load->view("layout/header_horizontal");
        // }

 
		// var_dump($grand_total);
		// var_dump($data_pasien);
?>
<!-- <?php $this->load->view("iri/layout/script_addon"); ?> -->
<br>
<?php if($state==''){
	$this->load->view("iri/data_pasien_status"); }
	else {
	$this->load->view("iri/data_pasien_medrec"); } ?>
<style>
	.bebas{
		background-color:#50CB93!important;
	} #vtot_tindakan {
		border: none;
		border-color: transparent;
	}
</style>
<script>
var no_register = "<?php echo $no_ipd;?>";
var view = "<?php echo $view; ?>";
var total_tind = "<?php echo $total_tind;?>";
// console.log(numberWithCommas(total_tind));
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
$(document).ready(function() {	
	$('.select2').select2();
	$('#vtot_tindakan').val(numberWithCommas(total_tind));
	if(view==0){
		tabeltindakan(no_register);
	}else{
		tabeltindakan(no_register);
	}	    		
	$('#diskon_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-hapus-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
        $.ajax({  
          url:"<?php echo base_url(); ?>iri/ricstatus/hapus_tindakan",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-hapus-tindakan").innerHTML = 'Hapus';
            // $('#ulangModal').modal('hide'); 
            // document.getElementById("ulang_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil dihapus",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: true,
									showLoaderOnConfirm: true
								},
								function () {
									//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-hapus-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
            //$('#ulangModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
	});

	$('.hapus-tindakan').click(function() {
        var id = $(this).attr("id");
        //if (confirm("Are you sure you want to delete this Member?")) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>iri/ricstatus/hapus_tindakan",
                data: ({
                    id: id
                }),
                cache: false,
                success: function(html) {
                    $(".delete_mem" + id).fadeOut('slow');
					$("#tot_tind").html.reload();
					// swal({
					// 	title: "Selesai",
					// 	text: "Data berhasil dihapus",
					// 	type: "success",
					// 	showCancelButton: false,
					// 	closeOnConfirm: true,
					// 	showLoaderOnConfirm: true
					// },
					// function () {
					// 	//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
					// });
                }
            });
        // } else {
        //     return false;
        // }
    });
});

function hapus_tindakan(id) {
    // document.getElementById('btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>iri/ricstatus/hapus_tindakan",                         
      type:"POST",  
	  dataType: 'json',
      data:{
        id: id,
		no_register: no_register
      },  
      success: function(data)  
      { 
		$('#vtot_tindakan').val(numberWithCommas(data.total));
		tabeltindakan(no_register);
      },
      error:function(event, textStatus, errorThrown) {
        // document.getElementById('btn-tarif-umum-'+no_register).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });   
}

function tabeltindakan(no_register){
    table = $('#table_tindakan_iri').DataTable({
        ajax: "<?php echo site_url();?>iri/ricstatus/tindakan_pasien/"+no_register,
        columns: [
            { data: "tindakan" },
            { data: "pelaksana" },
            { data: "ruang" },
            { data: "tgl_tindakan" },
            { data: "jam_tindakan" },
            { data: "biaya_tindakan" },
            { data: "biaya_alkes" },
            { data: "qty"},
			{ data: "total"},
			{ data: "ttd"},
			{ data: "aksi"}
        ],
        // columnDefs: [
        //     { targets: [ 0 ], visible: false }
        // ],
        bFilter: true,
        bPaginate: true,
        destroy: true
        // order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	});
}
</script>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.buttons.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/jszip.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/pdfmake.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/vfs_fonts.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.html5.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.print.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedHeader.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.keyTable.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.responsive.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/responsive.bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.scroller.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.colVis.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedColumns.min.js"></script>

		<!-- Keterangan page -->
		<section class="content-header">
			<h1><?php echo $title2 ?></h1>
			
			
		</section>
		<!-- /Keterangan page -->  
		<section class="content">              	
		<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<?php echo $this->session->flashdata('pesan_tindakan');?>
					<!-- Tabs -->
					<div class="card card-block">
						<ul class="nav nav-tabs customtab" role="tablist">
							<li class="nav-item text-center"><a class="nav-link active" href="#mutasi" data-toggle="tab" role="tab"><span class="hidden-xs-down">Ruangan</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#tindakan" data-toggle="tab" role="tab"><span class="hidden-xs-down">Tindakan</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#ok_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Operasi</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#radiologi" data-toggle="tab" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>
							<!-- <li class="nav-item text-center"><a class="nav-link" href="#elektromedik" data-toggle="tab" role="tab"><span class="hidden-xs-down">Elektromedik</span></a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#lab_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Lab</span></a></li>
							<!-- <li class="nav-item text-center"><a class="nav-link" href="#pa_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#resep_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Resep</span></a></li>
							<!-- <li class="nav-item text-center"><a href="#tindakan_ird" data-toggle="tab">Tindakan IRD</a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#poli_irj" data-toggle="tab" role="tab"><span class="hidden-xs-down">Poli/IRD</span></a></li>							
						</ul>
						<div class="tab-content"><br>
							<div class="tab-pane active" id="mutasi" role="tabpanel">
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Ruang</th>
									  <th>Kelas</th>
									  <th>Bed</th>
									  <th>Tgl Masuk</th>
									  <th>Tgl Keluar</th>
									  <th>Lama Inap</th>
									  <th>Total Biaya</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_mutasi_pasien)){
										foreach($list_mutasi_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['nmruang'] ; ?></td>
											<td><?php echo $r['kelas'] ; ?></td>
											<td><?php echo $r['bed'] ; ?></td>
											<td>
												<?php
										  		echo date('d-m-Y',strtotime($r['tglmasukrg']));
										  		?>
											</td>
											<td><?php 
											if($r['tglkeluarrg'] != null){

										  		echo date('d-m-Y',strtotime($r['tglkeluarrg']));

												//echo date("j F Y", strtotime($r['tglkeluarrg'])) ;
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
													//echo date("j F Y", strtotime($data_pasien[0]['tgl_keluar'])) ;
											  		echo date('d-m-Y',strtotime($data_pasien[0]['tgl_keluar']));
												}else{
													echo "-";	
												}
											}
											?>

											</td>
											<td>
											<?php
											$diff = 1;
											if($r['tglkeluarrg'] != null){
												$start = new DateTime($r['tglmasukrg']);//start
												$end = new DateTime($r['tglkeluarrg']);//end

												$diff = $end->diff($start)->format("%a");
												if($diff == 0){
													$diff = 1;
												}
												echo $diff." Hari"; 
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
												$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime($data_pasien[0]['tgl_keluar']);//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													echo $diff." Hari"; 
												}else{
													$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime(date("Y-m-d"));//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													
													echo $diff." Hari"; 
												}
											}
											?>
											</td>
											<?php if($data_pasien[0]['carabayar'] == 'UMUM') { ?>
												<td><?php echo "Rp. ".number_format( ($diff * $r['total_tarif'] ),0);
													$total_bayar = $total_bayar + ($diff * $r['total_tarif'] );?>
												</td>
											<?php } else if($data_pasien[0]['carabayar'] == 'BPJS') { ?>
												<td><?php echo "Rp. ".number_format( ($diff * $r['total_tarif'] ),0);
													$total_bayar = $total_bayar + ($diff * $r['total_tarif'] );?>
												</td>
											<?php } else { ?>
												<td><?php echo "Rp. ".number_format( ($diff * $r['tarif_iks'] ),0);
													$total_bayar = $total_bayar + ($diff * $r['tarif_iks'] );?>
												</td>
											<?php } ?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Ruangan</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="tindakan" role="tabpanel">
							<!-- <a href="<?= base_url('iri/ricstatus/cetak_list_pembayaran_pasien'.'/'.$no_ipd.'/0'); ?>" class="btn btn-primary btn-sm" target="_blank">Cetak</a>
							<a href="<?= base_url('iri/ricstatus/cetak_list_tindakan'.'/'.$no_ipd); ?>" class="btn btn-primary btn-sm" target="_blank">Print Tindakan</a>
							<?php if($data_pasien[0]['verifikasi_plg'] == NULL) { ?>
								<a href="<?= base_url('iri/rictindakan/form/tindakan'.'/'.$no_ipd); ?>" class="btn btn-info btn-sm" target="_blank">Tambah Tindakan</a>
							<?php } ?>
							<a href="<?= base_url('emedrec/C_emedrec_iri/cetak_rekap_tindakan/'.$no_ipd); ?>" class="btn btn-danger btn-sm" target="_blank">Rekap Tindakan</a> -->
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="table_tindakan_iri" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Nama Ruang</th>
									  <th>Tgl Tindakan</th>
									  <th>Jam Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Biaya Alkes</th>
									  <th>Qty</th>
									  <th>Total</th>
									  <th>TTD</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar = 0;
									if(!empty($list_tindakan_pasien)){
										foreach($list_tindakan_pasien as $r){ ?>
											<?php $total_bayar = $total_bayar + ($r['tumuminap']+$r['tarifalkes'])*$r['qtyyanri'];?>
										<?php
										}
									}else{ ?>
									<?php
									}
									?>
								  </tbody>
								</table>

								<form class="form-horizontal" id="total_tindakan" method="POST">
									<div class="form-inline" align="right" id="tot_tind">
										<div class="input-group">
											<table width="100%" class="table table-hover table-striped table-bordered" id="tbl_total_tindakan">
												<tr>
													<td colspan="6">Total Tindakan</td>
													<td><input type="text" name="vtot_tindakan" id="vtot_tindakan" disabled></td>
												</tr>
											</table>
										</div>
									</div>
								</form>
							</div>
							
							<div class="tab-pane" id="lab_pasien" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_lab_pasien)){
										echo form_open('lab/labcpengisianhasil/st_cetak_hasil_lab_rawat');
									?>
										<select id="no_lab" class="form-control" name="no_lab"  required>
											<?php 
												foreach($cetak_lab_pasien as $row){
													echo "<option value=".$row['no_lab']." selected>".$row['no_lab']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example4" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Lab</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Status</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_lab_pasien)){
										foreach($list_lab_pasien as $r){ ?>
										<tr>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['no_lab'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['jenis_tindakan'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php if($r['tgl_kunjungan'] != NULL) {
									  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											} else {}
											?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['nm_dokter'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['status'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['tarif_jatah'],0) ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['qty'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['tarif_jatah'] * $r['qty'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + ($r['tarif_jatah'] * $r['qty']);?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>


								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Laboratorium</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>	
							</div>

							<div class="tab-pane" id="pa_pasien" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_pa_pasien)){
										echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa_rawat');
									?>
										<select id="no_pa" class="form-control" name="no_pa"  required>
											<?php 
												foreach($cetak_pa_pasien as $row){
													echo "<option value=".$row['no_pa']." selected>".$row['no_pa']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example5" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No PA</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_pa_pasien)){
										foreach($list_pa_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['no_pa'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td>
											<?php 
											echo date('d-m-Y',strtotime($r['xupdate']));
											?>
											</td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_pa'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
										<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Patologi Anatomi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="ok_pasien" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example9" style="table-layout: fixed;">
								  <thead>
									<tr>
									  	<th>No Ok</th>
									  	<th >Jadwal Operasi</th>
									  	<th>Jenis Pemeriksaan</th>
										<th>Status</th>
									  	<th>Operator</th>
									  	<th >Total Pemeriksaan</th>
										<th>Aksi</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_ok_iri)){
										foreach($list_ok_iri as $row){ ?>
										<tr>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><?php echo $row['no_ok'] ; ?></td>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><?php if($row['tgl_kunjungan'] != NULL) {
												echo date('d-m-Y',strtotime($row['tgl_kunjungan'])); 
											} else {}?></td>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><?php echo $row['jenis_tindakan'].' ('.$row['id_tindakan'].')' ; ?></td>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><?php echo $row['status']; ?></td>
											<td class="<?= $row['no_ok']?'bebas':''; ?>">
												<?php
													echo 'Dokter : '.$row['dok_ok'].'';
													// if($row['id_opr_anes']<>NULL)
													// echo '<br>- Operator Anestesi: '.$row['nm_opr_anes'].'';
													if($row['id_dok_anes']<>NULL)
													echo '<br>- Dokter Anestesi: '.$row['dok_anes'].'';
													if($row['jns_anes']<>NULL)
													echo '<br>- Jenis Anestesi: '.$row['jns_anes'];
													if($row['id_dok_anak']<>NULL)
													echo '<br>- Dokter Anak: '.$row['dok_anak'].'';
												?> 
											</td>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><?php echo 'Rp '.number_format( $row['okvtot'], 2 , ',' , '.' ); ?></td>
											<?php $total_bayar = $total_bayar + $row['okvtot'];?>
											<td class="<?= $row['no_ok']?'bebas':''; ?>"><a href="<?= base_url('iri/ricstatus/hapus_tindakan_ok/'.$row['id_pemeriksaan_ok'].'/'.$no_ipd); ?>" class="btn btn-danger btn-sm">Hapus</a></td>
										</tr>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Biaya Operasi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table> 
									</div>
								</div>
							</div>

							<div class="tab-pane" id="radiologi" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_rad_pasien)){
										echo form_open('rad/radcpengisianhasil/st_cetak_hasil_rad_rawat');
									?>
										<select id="no_rad" class="form-control" name="no_rad"  required>
											<?php 
												foreach($cetak_rad_pasien as $row){
													echo "<option value=".$row['no_rad']." selected>".$row['no_rad']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example6" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Rad</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Status</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_radiologi)){
										foreach($list_radiologi as $r){ ?>
										<tr>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['no_rad'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['jenis_tindakan'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php if($r['tgl_kunjungan'] != NULL) {
									  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											} else {}
											?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['nm_dokter'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['status'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['qty'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['biaya_rad'] * $r['qty']) ; ?></td>
											<?php $total_bayar = $total_bayar + ($r['biaya_rad'] * $r['qty']) ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Radiologi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="elektromedik" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_em_pasien)){
										echo form_open('elektromedik/emcpengisianhasil/st_cetak_hasil_em_rawat');
									?>
										<select id="no_em" class="form-control" name="no_em"  required>
											<?php 
												foreach($cetak_em_pasien as $row){
													echo "<option value=".$row['no_em']." selected>".$row['no_em']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<!-- <table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example11" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Em</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Status</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_elektromedik)){
										foreach($list_elektromedik as $r){ ?>
										<tr>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['no_em'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['jenis_tindakan'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php if($r['tgl_kunjungan'] != NULL) {
									  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											} else {}
											?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['nm_dokter'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['status'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['biaya_em'],0) ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>"><?php echo $r['qty'] ; ?></td>
											<td class="<?= $r['tgl_kunjungan']?'bebas':''; ?>">Rp. <?php echo number_format($r['total']) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['total'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table> -->

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Elektromedik</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="resep_pasien" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example7" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <!-- <th>Status</th> -->
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_resep)){
										foreach($list_resep as $r){ ?>
										<tr>
											<td ><?php echo $r['no_resep'] ; ?></td>
											<td ><?php echo $r['nama_obat'] ; ?></td>
											<td ><?php 

									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));

											?></td>
											<!-- <td ><?php //echo $r['status'] ; ?></td> -->
											<td ><?php echo $r['Satuan_obat'] ; ?></td>
											<td ><?php echo $r['qty'] ; ?></td>
											<td >Rp. <?php echo number_format($r['vtot'] + $r['embalase'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + ($r['vtot'] + $r['embalase']);?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Resep</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- <a target="_blank" href="<?php //echo base_url() ;?>iri/ricstatus/cetak_detail_farmasi/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Cetak Detail"></a> -->
							</div>

							<!--<div class="tab-pane" id="tindakan_ird" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example8">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_tindakan_ird)){
										foreach($list_tindakan_ird as $r){ ?>
										<tr>
											<td><?php echo $r['nama_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_ird'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan IRD</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>-->

							<!-- <div class="tab-pane" id="poli_irj" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example10" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($poli_irj)){
										foreach($poli_irj as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php 
											echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_tindakan'],0) ; ?></td>
											<td><?php echo $r['qtyind'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan Poli</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div> -->
							
							<div class="tab-pane" id="poli_irj" role="tabpanel">
								<h2>Tindakan</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example12" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Tgl Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar_tindakan = 0;
									if(!empty($list_tindakan_ird)){
										foreach($list_tindakan_ird as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td>Rp. <?php echo number_format($r['biaya_tindakan'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_tindakan = $total_bayar_tindakan + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan IRD</td>
											  <td>Rp. <?php echo number_format($total_bayar_tindakan,0);?></td>
											</tr>
										</table>
									</div>
								</div>
								
								<hr>

								<h2>Operasi</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example13" style="table-layout: fixed;">
								  <thead>
									<tr>
									  	<th>No Ok</th>
									  	<th >Jadwal Operasi</th>
									  	<th>Jenis Pemeriksaan</th>
									  	<th>Operator</th>
									  	<th >Total Pemeriksaan</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_ok = 0;
									if(!empty($list_ok_ird)){
										foreach($list_ok_ird as $row){ ?>
										<tr>
											<td><?php echo $row['no_ok'] ; ?></td>
											<td><?php echo date('d-m-Y',strtotime($row['tgl_kunjungan'])); ?></td>
											<td><?php echo $row['jenis_tindakan'].' ('.$row['id_tindakan'].')' ; ?></td>
											<td>
												<?php
													echo 'Dokter : '.$row['nm_dokter'].' ('.$row['id_dokter'].')';
													if($row['id_opr_anes']<>NULL)
													echo '<br>- Operator Anestesi: '.$row['nm_opr_anes'].' ('.$row['id_opr_anes'].')';
													if($row['id_dok_anes']<>NULL)
													echo '<br>- Dokter Anestesi: '.$row['nm_dok_anes'].' ('.$row['id_dok_anes'].')';
													if($row['jns_anes']<>NULL)
													echo '<br>- Jenis Anestesi: '.$row['jns_anes'];
													if($row['id_dok_anak']<>NULL)
													echo '<br>- Dokter Anak: '.$row['nm_dok_anak'].' ('.$row['id_dok_anak'].')';
												?> 
											</td>
											<td><?php echo 'Rp '.number_format( $row['vtot'], 2 , ',' , '.' ); ?></td>
											<?php $total_bayar_ok = $total_bayar_ok + $row['vtot'];?>
										</tr>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Biaya Operasi</td>
											  <td>Rp. <?php echo number_format($total_bayar_ok,0);?></td>
											</tr>
										</table> 
									</div>
								</div>

								<hr>

								<h2>Radiologi</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example14" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Rad</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_rad = 0;
									if(!empty($list_rad_ird)){
										foreach($list_rad_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_rad'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php $total_bayar_rad = $total_bayar_rad + $r['vtot'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Radiologi</td>
											  <td>Rp. <?php echo number_format($total_bayar_rad,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<hr>

								<!-- <h2>Elektromedik</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example15" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Em</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_em = 0;
									if(!empty($list_em_ird)){
										foreach($list_em_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_em'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_em'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php $total_bayar_em = $total_bayar_em + $r['vtot'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Elektromedik</td>
											  <td>Rp. <?php echo number_format($total_bayar_em,0);?></td>
											</tr>
										</table>
									</div>
								</div> -->

								<hr>

								<h2>Laboratorium</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example16" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Lab</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_lab = 0;
									if(!empty($list_lab_ird)){
										foreach($list_lab_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_lab'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_lab'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_lab = $total_bayar_lab + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>


								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Laboratorium</td>
											  <td>Rp. <?php echo number_format($total_bayar_lab,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<hr>

								<h2>Resep</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example17" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_resep = 0;
									if(!empty($list_resep_ird)){
										foreach($list_resep_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_resep'] ; ?></td>
											<td><?php echo $r['nama_obat'] ; ?></td>
											<td><?php 

									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));

											?></td>
											<td><?php echo $r['Satuan_obat'] ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_resep = $total_bayar_resep + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Resep</td>
											  <td>Rp. <?php echo number_format($total_bayar_resep,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<?php 
									$total_bayar_ird = 0 ;
									$total_bayar_ird = $total_bayar_ird + $total_bayar_tindakan + $total_bayar_rad + $total_bayar_em + $total_bayar_lab + $total_bayar_ok + $total_bayar_resep;
								?>

								<hr>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Semua Biaya Poli IGD</td>
											  <td>Rp. <?php echo number_format($total_bayar_ird,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

						</div>
						
						</div>
					</div>
					<!-- /Tabs -->
					
				
			</div>
		</section>								

<script>

	function getBase64Image(img) {
		var canvas = document.createElement("canvas");
		canvas.width = img.width;
		canvas.height = img.height;
		var ctx = canvas.getContext("2d");
		ctx.drawImage(img, 0, 0);
		var dataURL = canvas.toDataURL("image/base64");
		//return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
	}
	$(document).ready(function() {
		
		let idkontraktor = '<?= $data_pasien[0]['id_kontraktor'] ?>';
		var ttd = "<?php $ttd ?>";
			if(idkontraktor === "0"){
				let grandtotal = <?= $grand_total ?>;
				if(grandtotal >= 20000000){
					new swal({
                            title: "Peringatan",
                            text: "Biaya Mencapai Rp. <?= number_format($grand_total,0) ?>",
                            type: "info",
                            showCancelButton: false,
                            closeOnConfirm: true,
                        },
                        function () {
                            // window.location.reload();
                        });
				}
			}
	    $('#dataTables-example').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example4').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example5').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example6').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example7').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example8').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example9').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example10').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	});

    function inputResep() {
        swal({
                title: "Resep",
                text: "Input Data Resep Pasien?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "<?=base_url('iri/rictindakan/update_rujukan_resep_ruangan')?>",
                        data: {
                            no_register: "<?=$data_pasien[0]['no_ipd']?>",
                            obat: "1"
                        },
                        dataType: 'text',
                        success: function (data) {
                            //if(data === 'success'){
                            window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat_ruangan/'.$data_pasien[0]['no_ipd'])?>", "_self");
                            /*}else{
                                swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                            }*/
                        }
                    });
                } else {
                    swal("Close", "Batal Input Resep", "error");
                }
            });
    }
</script>

<?php 
        // if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        // } else {
            // $this->load->view("layout/footer_horizontal");
        // }
    ?> 
