<?php
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
$(function() {
	 
	$('#dataTables-example').DataTable();

	// $('#date_picker1').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	

	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_picker1').show();
	$('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();
});	
function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
	//		document.getElementById("date_picker_months").value = '';
	//		document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			document.getElementById("date_picker2").required = true;
	//		document.getElementById("date_picker_months").required = false;
	//		document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
		//	$('#date_picker_months').hide();
			$('#date_picker2').show();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			//$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
            <form action="<?php echo base_url();?>farmasi/Frmclaporan/view_data_penyerahan_obat" method="post" accept-charset="utf-8">
                <div class="col-lg-12">
                    <div class="form-inline">
                        <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" style="margin-left: 5px;" required>
                        <input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" style="margin-left: 5px;" required>
                        <button class="btn btn-primary" type="submit" style="margin-left: 5px;">Tampilkan</button>
                        
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>

<div class="card p-4">
	<div class="card-header">
		<div style="text-align:center;font-size:16px">
			<h4>DAFTAR PENYERAHAN OBAT RAWAT JALAN<br>
			Tanggal <?php echo $tgl_awal; ?> - <?php echo $tgl_akhir; ?>
			</h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table table-responsive" id="dataTables-example">
			<thead>
                <tr>
                    <th>No</th>
					<th>Aksi</th>
                    <th>Tgl Kunjungan</th>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>ALamat</th>
                    <th>No HP</th>
                    <th>Ruang</th>
                    <th>Jaminan</th>
                    <th>Waktu Order Obat</th>
                    <th>Waktu Telaah Obat</th>
                    <th>Waktu Penyerahan Obat</th>	
					
				</tr>
			</thead>
			<tbody>
				<?php
					 $i=1;
					foreach($data_kunjungan as $r){
				?>
	                <tr>
                        <th><?= $i++ ?></th>
						<th>
							<a target="_blank" href="<?php echo site_url('emedrec/C_emedrec/cetak_Eresep_telaah');?><?php echo '/'.$r->no_cm.'/'.$r->no_register;?>"><input type="button" class="btn 
							btn-primary" value="Cetak Telaah"></a><br>
							<a target="_blank" href="<?php echo site_url('farmasi/Frmcdaftar/cetak_all_resep');?><?php echo '/'.$r->no_register.'/'.$r->no_resep;?>"><input type="button" class="btn 
							btn-primary" value="Cetak E-tiket"></a>
						</th>
                        <th><?= $r->tgl_kunjungan ?></th>
                        <th><?= $r->no_cm ?></th>
                        <th><?= $r->nama ?></th>
                        <th><?= $r->sex ?></th>
                        <th><?= $r->alamat ?></th>
                        <th><?= $r->no_hp ?></th>
                        <th><?= $r->nm_poli ?></th>
                        <th><?= $r->cara_bayar ?></th>
                        <th><?= isset($r->waktu_resep_dokter)?date('h:i:s',strtotime($r->waktu_resep_dokter)):'' ?></th>
                        <th><?= isset($r->wkt_telaah_obat)?date('h:i:s',strtotime($r->wkt_telaah_obat)):'' ?></th>
                        <th><?= isset($r->wkt_penyerahan_obat)?date('h:i:s',strtotime($r->wkt_penyerahan_obat)):''  ?></th>	
						
				    </tr>

				
				<?php
						}	
				?>
			</tbody>
		</table>
	</div>
    <div class="form-inline" align="right">
        <div class="form-group">
            <a target="_blank" href="<?php echo site_url('farmasi/Frmclaporan/excel_penyerahan_obat');?><?php echo '/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
            btn-primary" value="Cetak Laporan Excel"></a>
        </div>
    </div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>