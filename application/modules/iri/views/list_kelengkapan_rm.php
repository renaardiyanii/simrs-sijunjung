<?php
date_default_timezone_set('Asia/Jakarta');
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
$(function() {
	 
	$('#dataTables-example').DataTable();

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
	$('#date_days').show();
	$('#date_months').hide();
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
		document.getElementById("date_days").required = true;
		document.getElementById("date_months").required = false;
		$('#date_days').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		document.getElementById("date_months").required = true;
		document.getElementById("date_days").required = false;
		$('#date_days').hide();
		$('#date_months').show();
	}
}

</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<form action="<?php echo base_url();?>iri/ricmedrec/list_kelengkapan_rm" method="post" accept-charset="utf-8">
				<div class="col-lg-12">
					<div class="form-inline">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Tanggal</option>
							<option value="BLN">Bulan</option>
						</select>
						<input type="date" id="date_days" class="form-control" name="date_days" style="margin-left: 5px;">
						<input type="month" id="date_months" class="form-control" name="date_months" style="margin-left: 5px;">
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
			<h4>Laporan Pengembalian Rekam Medik Lengkap Dalam 24 jam<br><?php echo $date_title; ?></h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table table-responsive" id="dataTables-example">
			<thead>
				<tr>
					<th width="3%"><b>No</b></th>
					<th width="10%"><b>No RM</b></th>
					<th width="5%"><b>Nama</b></th>
					<th width="3%"><b>Jenis Kelamin</b></th>
					<th width="3%"><b>Agama </b></th>
					<th width="6%"><b>Umur</b></th>
					<th width="6%"><b>Kabupaten/Kota</b></th>
					<th width="10%"><b>Provinsi</b></th>
					<th width="10%"><b>Jaminan</b></th>				
					<th width="10%"><b>Ruangan Awal</b></th>
					<th width="5%"><b>Kelas</b></th>
					<th width="5%"><b>Ket Tempat Tidur</b></th>
					<th width="5%"><b>Ruangan Pindah I</b></th>
					<th width="5%"><b>Kelas Pindah I</b></th>
                    <th width="5%"><b>Tgl Pindah I</b></th>
                    <th width="5%"><b>Ruangan Pindah II</b></th>
					<th width="5%"><b>Kelas Pindah II</b></th>
                    <th width="5%"><b>Tgl Pindah II</b></th>
                    <th width="5%"><b>Ruangan Pindah III</b></th>
					<th width="5%"><b>Kelas Pindah III</b></th>
                    <th width="5%"><b>Tgl Pindah III</b></th>
                    <th width="5%"><b>Ruangan Pindah IV</b></th>
					<th width="5%"><b>Kelas Pindah IV</b></th>
                    <th width="5%"><b>Tgl Pindah IV</b></th>
                    <th width="5%"><b>DPJP Utama</b></th>
                    <th width="5%"><b>Diagnosa Utama</b></th>
                    <th width="5%"><b>Diagnosa Sekunder Pertama</b></th>
                    <th width="5%"><b>Diagnosa Sekunder Kedua</b></th>
                    <th width="5%"><b>Diagnosa Sekunder Ketiga</b></th>
                    <th width="5%"><b>Tindakan</b></th>
                    <th width="5%"><b>Kondisi Pulang</b></th>
                    <th width="5%"><b>Cara Pulang</b></th>
                    <th width="5%"><b>Tgl Masuk</b></th>
                    <th width="5%"><b>Tgl Keluar</b></th>
                    <th width="5%"><b>Lama Rawat</b></th>
                    <th width="5%"><b>Hari Rawatan</b></th>
                    <th width="5%"><b>Kelengkapan RM</b></th>
                    <th width="5%"><b>Pintu Masuk</b></th> 
                    <th width="5%"><b>User yang memulangkan</b></th>
				</tr>
			</thead>
			<tbody>
			<?php
                $i = 1;
                foreach($data_kunjungan as $r) { 
                    $ruang = $this->rimpasien->get_ruang($r->no_ipd)->result();
                    $diag = $this->rimpasien->get_diagnosa($r->no_ipd)->result();
					$operasi = $this->rimpasien->get_operasi($r->no_ipd)->result(); ?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $r->no_cm;?></td>
                        <td><?php echo $r->nama;?></td>
                        <td><?php echo $r->sex;?></td>
                        <td><?php echo $r->agama;?></td>
						<?php
							$tgl_lahir = new DateTime($r->tgl_lahir);//start time
							$today = new DateTime('today');//end time
							$y = $today->diff($tgl_lahir)->y;
						?>
                        <td><?php echo $y.' '.'Thn';?></td>
                        <td><?php echo $r->kotakabupaten;?></td>
                        <td><?php echo $r->provinsi;?></td>
                        <td><?php echo $r->carabayar;?></td>
                        <td><?php echo $r->ruang_awal;?></td>
                        <td><?php echo $r->kelas_awal;?></td>
                        <td>
							<?php 
							if($r->selisih_tarif == 1){
								echo 'Selisih Tarif';
							}else if($r->titip == 1){
								echo 'Titip';
							}else if($r->naik_1_tingkat == 1){
								echo 'Naik 1 Tingkat';
							}else{
								echo 'Sesuai';
							}
							?>
						</td>
                        <?php 
                        // var_dump($ruang);die();
                        ?>
                        <?php 
                        if($ruang != null){
                        if($r->no_ipd == $ruang[0]->no_ipd){ ?>
                            <td><?= isset($ruang[0]->nmruang)?$ruang[0]->nmruang:'' ?></td>
                            <td><?= isset($ruang[0]->kelas)?$ruang[0]->kelas:'' ?></td>
                            <td><?= isset($ruang[0]->tglmasukrg)?$ruang[0]->tglmasukrg:'' ?></td>
                            <td><?= isset($ruang[1]->nmruang)?$ruang[1]->nmruang:'' ?></td>
                            <td><?= isset($ruang[1]->kelas)?$ruang[1]->kelas:'' ?></td>
                            <td><?= isset($ruang[1]->tglmasukrg)?$ruang[1]->tglmasukrg:'' ?></td>
                            <td><?= isset($ruang[2]->nmruang)?$ruang[2]->nmruang:'' ?></td>
                            <td><?= isset($ruang[2]->kelas)?$ruang[2]->kelas:'' ?></td>
                            <td><?= isset($ruang[2]->tglmasukrg)?$ruang[2]->tglmasukrg:'' ?></td>
                            <td><?= isset($ruang[3]->nmruang)?$ruang[3]->nmruang:'' ?></td>
                            <td><?= isset($ruang[3]->kelas)?$ruang[3]->kelas:'' ?></td>
                            <td><?= isset($ruang[3]->tglmasukrg)?$ruang[3]->tglmasukrg:'' ?></td>
                            
                         <?php
                        }}else{ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php }?>
                        <td><?php echo $r->dokter;?></td>
                        <?php 
                      if($diag != null){
                        if($r->no_ipd == $diag[0]->no_register){
                            ?>
                            <td><?= isset($diag[0]->diagnosa)?$diag[0]->diagnosa:'' ?></td>
                            <td><?= isset($diag[1]->diagnosa)?$diag[1]->diagnosa:'' ?></td>
                            <td><?= isset($diag[2]->diagnosa)?$diag[2]->diagnosa:'' ?></td>
                            <td><?= isset($diag[3]->diagnosa)?$diag[3]->diagnosa:'' ?></td>
                         <?php
                       }} else{?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php }?>

						<?php 
						if($operasi != null){
							if($r->no_ipd == $operasi[0]->no_ipd){
                            ?>
                            <td>Operasi</td>
                         <?php
                          }} else{?>
                            <td></td>
                        <?php }?>
						<td><?php echo $r->status_pulang;?></td>
						<td><?php echo $r->cara_pulang;?></td>
						<td><?php echo $r->tgl_masuk;?></td>
						<td><?php echo $r->tgl_keluar;?></td>
						<?php
							$temp_tgl_awal = strtotime($r->tgl_masuk);
							$temp_tgl_akhir = strtotime($r->tgl_keluar);
							$diff = $temp_tgl_akhir - $temp_tgl_awal;
							$diff =  floor($diff/(60*60*24));
							if($diff == 0){
							$diff = 1;
							}
							$lama_rawat = $diff.' Hari';
							$hari_rawat = ($diff + 1).' Hari';

					    ?>
						<td><?php echo $lama_rawat;?></td>
						<td><?php echo $hari_rawat;?></td>
						 <td><?php echo $r->kelengkapan_rm ?></td>
						 <td><?php echo $r->pintu_masuk ?></td>
						 <td><?php echo $r->user_plg ?></td>
                    </tr>
            <?php } ?>
			</tbody>
		</table>
	</div>
	<div class="form-inline" align="right">
		<div class="form-group">
			<a target="_blank" href="<?php echo site_url('iri/ricmedrec/excel_lap_kelengkapan_rm');?><?php echo '/'.$date.'/'.$tampil;?>"><input type="button" class="btn btn-primary" value="Cetak Laporan Excel"></a>
		</div>
	</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>