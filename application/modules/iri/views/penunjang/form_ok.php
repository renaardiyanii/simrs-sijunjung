
<script>
    function inputOperasi() {
		$.ajax({
                    type: "POST",
                    url: "<?=base_url('iri/rictindakan/update_rujukan_penunjang_ok')?>",
                    data: {
                        no_ipd: "<?=$data_pasien[0]['no_ipd']?>"
                    },
                    dataType: 'text',
                    success: function (data) {
                        //if(data === 'success'){
                            window.open("<?=base_url('ok/okcdaftar/pemeriksaan_ok/'.$data_pasien[0]['no_ipd'])?>", "_self");
                        /*}else{
                            swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                        }*/
                    }
                });
    }
</script>

<?php $this->load->view("layout/header_form"); ?>

<div class="card m-5">
	<div class="card-header ">
		<div class="d-flex justify-content-between">
			<h5>Riwayat Operasi</h5>
			<div class="d-flex">
				<button class="btn btn-primary" onclick="inputOperasi()"><i class="fa fa-plus"></i> Operasi</button>&nbsp;&nbsp;
			
			</div>
		</div>

	</div>

	<div class="card-body">
		<div class="input-group">
			<?php 
			foreach($rujukan_penunjang as $row){
				if($row->status_ok>='1'){
					echo '<label>'.$row->status_ok.'x Telah Di Tindak </label>';
				}else{}
			}
			?>&nbsp;
		</div>

		<div class="table-responsive m-t-0">
			<table id="tabel_ok" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  	<th>No Ok</th>
				  	<th width="15%">Jadwal Operasi</th>
				  	<th>Jenis Pemeriksaan</th>
				  	<th>Operator</th>
				  	<th width="10%">Total Pemeriksaan</th>
				</tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$total_bayar = 0;
				if(!empty($list_ok_pasien)){
					foreach($list_ok_pasien as $row){ ?>
					<tr>
						<td><?php echo $row->no_ok ; ?></td>
						<td><?php echo $row->tgl_jadwal_ok ; ?></td>
						<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
						<td>
							<?php
								echo 'Dokter : '.$row->nm_dokter.' ('.$row->id_dokter.')';
								if($row->id_opr_anes<>NULL)
								echo '<br>- Operator Anestesi: '.$row->nm_opr_anes.' ('.$row->id_opr_anes.')';
								if($row->id_dok_anes<>NULL)
								echo '<br>- Dokter Anestesi: '.$row->nm_dok_anes.' ('.$row->id_dok_anes.')';
								if($row->jns_anes<>NULL)
								echo '<br>- Jenis Anestesi: '.$row->jns_anes;
								if($row->id_dok_anak<>NULL)
								echo '<br>- Dokter Anak: '.$row->nm_dok_anak.' ('.$row->id_dok_anak.')';
							?> 
						</td>
						<td><?php echo 'Rp '.number_format( $row->vtot, 2 , ',' , '.' ); ?></td>
						<?php $total_bayar = $total_bayar + $row->vtot;?>
					</tr>
				<?php
					}
				}else{ ?>
				<tr>
						<td colspan="6">Tidak Ada Operasi</td>
						<!-- <td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td> -->
					</tr>
				<?php
				}
				?>
			  </tbody>
			</table>
			
		
		</div>
	</div>

	<div class="card-footer">

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
</div>



		<!-- style overflow -->