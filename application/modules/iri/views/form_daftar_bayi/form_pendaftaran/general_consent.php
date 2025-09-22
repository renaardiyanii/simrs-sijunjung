<div id="surveyGeneralConsent"></div>
<script>
	Survey.StylesManager.applyTheme("modern");
	var surveyJSON = <?php echo file_get_contents("general_consent.json", FILE_USE_INCLUDE_PATH); ?>;
	var survey = new Survey.Model(surveyJSON);
	<?php
	if ($pasien_iri) { ?>
		survey.data = {
			"question28": {
				"tgldaftarri": '<?= date('d-m-Y', strtotime($data_pasien_iri->tgldaftarri)) ?>',
				"waktu": '<?= date('H.i.s', strtotime($data_pasien_iri->tgldaftarri)) ?>',
				"idrg": '<?= isset($data_pasien_iri->nm_ruang) ? $data_pasien_iri->nm_ruang : '' ?>',
				"klsiri": '<?= isset($data_pasien_iri->klsiri) ? $data_pasien_iri->klsiri : '' ?>'
			},
			"question23": {
				"no_register": '<?= isset($data_pasien_iri->no_ipd) ? $data_pasien_iri->no_ipd : '' ?>',
				"no_cm": '<?= isset($irna_reservasi[0]['no_cm']) ? $irna_reservasi[0]['no_cm'] : '' ?>',
				"nama": '<?= isset($data_pasien_iri->nmpjawabri) ? $data_pasien_iri->nmpjawabri : '' ?>',
				"tgl_lahir": '<?= isset($data_pasien_iri->tgllahirpjawabri) ? $data_pasien_iri->tgllahirpjawabri : '' ?>',
				"hub": '<?= isset($data_pasien_iri->hubpjawabri) ? $data_pasien_iri->hubpjawabri : '' ?>',
				"alamat": '<?= isset($data_pasien_iri->alamatpjawabri) ? $data_pasien_iri->alamatpjawabri : '' ?>',
				"no_hp": '<?= isset($data_pasien_iri->notlppjawab) ? $data_pasien_iri->notlppjawab : '' ?>'
			},
			"carabayar": '<?= isset($data_pasien_iri->carabayar) ? $data_pasien_iri->carabayar : '' ?>',
			"question10": '<?= isset($data_pasien_iri->namaaksespjawabri1) ? $data_pasien_iri->namaaksespjawabri1 : '' ?>',
			"question24": '<?= isset($data_pasien_iri->namaaksespjawabri2) ? $data_pasien_iri->namaaksespjawabri2 : '' ?>',
			"question25": '<?= isset($data_pasien_iri->namaaksespjawabri3) ? $data_pasien_iri->namaaksespjawabri3 : '' ?>'
		}
	<?php } ?>

	<?php
	$ttd_pasien = '';
	if (count($general_consent) > 0) {
		$objGenConsent = json_decode($general_consent[0]->formjson);
		if (isset($objGenConsent)) {
			$ttd_pasien = $objGenConsent->ttd_pasien;
		}
	}
	?>
	survey.setValue('ttd_pasien', '<?= $ttd_pasien ?>');
	var noipd = '<?= $pasien_iri[0]->no_ipd ?? '' ?>';
	var nomedrec = '<?php echo $irna_reservasi[0]['no_medrec']; ?>';

	function sendDataToServer(survey) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('iri/ricpendaftaran/insert_general_consent'); ?>",
			dataType: "JSON",
			data: {
				no_register: noipd,
				no_cm: nomedrec,
				no_register_lama: '<?= $no_register_asal ?>',
				formjson: JSON.stringify(survey.data)
			},
			success: function(result) {
				if (result) {
					swal({
							title: "Sukses",
							text: "Data Berhasil Disimpan?",
							type: "success",
							showCancelButton: true,
							closeOnConfirm: true,
							showLoaderOnConfirm: true,
						},
						function() {
							location.reload();
						});
				}
			},
		});
	}

	$("#surveyGeneralConsent").Survey({
		model: survey,
		onComplete: sendDataToServer
	});

	$('#submitsurvey').click(function() {
		survey.completeLastPage();

	});
</script>