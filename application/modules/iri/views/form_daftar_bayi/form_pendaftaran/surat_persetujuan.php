
<?php //var_dump($data_pasien_iri); ?>
<div id="surveyPersetujuan"></div>

<div>
<?php if($surat_persetujuan_iri){ ?>
		<a href="<?= base_url('iri/Ricpendaftaran/update_irna_antrian_bayi/'.$noreg_ibu) ?>" class="btn btn-primary mt-4 mb-4"> Selesai </a>
		<a href="<?= base_url('iri/ricdaftar/index/1') ?>" class="btn btn-primary mt-4 mb-4"> Kembali </a>
		<a href="<?= base_url('emedrec/C_emedrec_iri/cetak_pengantar_iri/'.$data_pasien_iri->no_ipd); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Surat Pengantar </a>
		<a href="<?= base_url('emedrec/C_emedrec_iri/cetak_general_consent/1/'.$data_pasien_iri->no_ipd.'/'.$irna_reservasi[0]['no_cm']); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak General Consent </a>
		<a href="<?= base_url('emedrec/C_emedrec_iri/surat_persetujuan/1/'.$data_pasien_iri->no_ipd.'/'.$irna_reservasi[0]['no_cm']); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Surat Persetujuan </a>
		<a href="<?= base_url('emedrec/C_emedrec_iri/tata_terib_pasien/'.$data_pasien_iri->no_ipd.'/'.$irna_reservasi[0]['no_cm']); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Tata Tertib </a>
		<a href="<?= base_url('emedrec/C_emedrec_iri/ringkasan_masuk_keluar_pasien_iri/'.$data_pasien_iri->no_ipd.'/'.$irna_reservasi[0]['no_cm'].'/'.$data_pasien_iri->noregasal); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Catatan Masuk Dan Keluar </a>
<?php } ?>
</div>

<script>
Survey.StylesManager.applyTheme("modern");

var jsonPeretujuan = <?php echo file_get_contents("surat_persetujuan.json",FILE_USE_INCLUDE_PATH); ?>;


function sendDataToPersetujuan(survey) {
	$.ajax({
			type: "POST",
			url: "<?php echo site_url('iri/ricpendaftaran/insert_surat_persetujuan'); ?>",
			dataType: "JSON",
			data: {
				no_register:survey.data.identitas_pasien.no_register,
				no_register_lama:'<?= $no_register_asal ?>',
				no_cm:survey.data.identitas_pasien.no_cm,
				no_ipd:survey.data.identitas_pasien.no_ipd,
				formjson:JSON.stringify(survey.data)
			},
			success: function(result) { 
				console.log(result.no_ipd);
				if(result){
					swal({
						title: "Berhasil",
						text: "Data Berhasil Disimpan",
						type: "info",
						showCancelButton: true,
						closeOnConfirm: true,
						showLoaderOnConfirm: true,
					},
					function(){
						window.location.reload();
					});
				}
			},
		});

}

var surveyPersetujuan = new Survey.Model(jsonPeretujuan);
<?php if($surat_persetujuan_iri){ ?>
surveyPersetujuan.data = <?= $surat_persetujuan_iri[0]->formjson; ?>;

<?php }else{ ?>
	surveyPersetujuan.data = {"penanggung_jawab_pasien":
	{
		"nama":"<?php echo isset($data_pasien_iri->nmpjawabri)?$data_pasien_iri->nmpjawabri:'' ?>",
		"no_identitas":"<?php echo  isset($data_pasien_iri->kartuidpjawab)?$data_pasien_iri->kartuidpjawab:'' ?>",
		"Alamat":"<?php echo isset($data_pasien_iri->alamatpjawabri)?$data_pasien_iri->alamatpjawabri:"" ?>",
		"adalah":"<?php echo isset($data_pasien_iri->hubpjawabri)?$data_pasien_iri->hubpjawabri:"" ?>"},
		"identitas_pasien":{
			"nama":"<?php echo isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:"" ?>",
			"no_identitas":"<?php echo isset($data_pasien[0]['no_identitas'])?$data_pasien[0]['no_identitas']:"" ?>",
			"alamat":"<?php echo isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:"" ?>",
			"no_register":"<?= isset($data_pasien_iri->noregasal)?$data_pasien_iri->noregasal:'' ?>",
			"no_cm":"<?php echo $irna_reservasi[0]['no_cm']; ?>",
			"no_ipd":'<?= isset($data_pasien_iri->no_ipd)?$data_pasien_iri->no_ipd:'' ?>'
			}}
<?php } ?>



$("#surveyPersetujuan").Survey({
    model: surveyPersetujuan,
    onComplete: sendDataToPersetujuan
});
</script>